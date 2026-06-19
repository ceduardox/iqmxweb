<?php
require_once __DIR__ . '/lib.php';

header('Content-Type: application/json; charset=utf-8');

function correo_json($ok, $data = array(), $error = '')
{
    echo json_encode(array_merge(array('ok' => $ok, 'error' => $error), $data), JSON_UNESCAPED_UNICODE);
    exit;
}

function correo_input()
{
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : $_POST;
}

correo_seed_admin();
$GLOBALS['correo_bootstrap'] = correo_read_users();
$input = correo_input();
$action = $input['action'] ?? '';
$GLOBALS['correo_boot_log'] = correo_log_boot(array('page' => 'api', 'action' => $action, 'default_mailbox' => correo_default_mailbox()));

switch ($action) {
    case 'login':
        $username = trim((string) ($input['username'] ?? ''));
        $password = (string) ($input['password'] ?? '');
        $user = correo_find_user($username);
        if (!$user || empty($user['active']) || !password_verify($password, (string) ($user['password'] ?? ''))) {
            correo_json(false, array(), 'Usuario o contraseña inválidos.');
        }
        $_SESSION['correo_user'] = correo_public_user($user);
        correo_json(true, array('user' => correo_public_user($user)));
        break;

    case 'logout':
        unset($_SESSION['correo_user']);
        correo_json(true);
        break;

    case 'me':
        correo_json(true, array('user' => correo_current_user()));
        break;

    case 'listUsers':
        if (!correo_is_admin()) {
            correo_json(false, array(), 'Acceso restringido.');
        }
        correo_json(true, array('items' => correo_mailboxes()));
        break;

    case 'importHistory':
        if (!correo_is_admin()) {
            correo_json(false, array(), 'Acceso restringido.');
        }
        $email = trim((string) ($input['email'] ?? ''));
        $limit = (int) ($input['limit'] ?? 5);
        $after = trim((string) ($input['after'] ?? ''));
        $result = correo_import_history_for_email($email, $limit, $after);
        if (empty($result['ok'])) {
            correo_json(false, array(), $result['error'] ?? 'No se pudo importar el historial.');
        }
        correo_json(true, array(
            'imported' => $result['imported'] ?? 0,
            'updated' => $result['updated'] ?? 0,
            'has_more' => !empty($result['has_more']),
            'next_after' => $result['next_after'] ?? '',
        ));
        break;

    case 'listInbox':
    case 'listSent':
        correo_require_login();
        $user = correo_current_user();
        $items = correo_db_list_messages($action === 'listInbox' ? 'received' : 'sent');
        correo_json(true, array('items' => correo_filter_by_user($items, $user)));
        break;

    case 'listMailbox':
        correo_require_login();
        $email = trim((string) ($input['email'] ?? ''));
        if ($email === '') {
            correo_json(false, array(), 'Falta el correo.');
        }
        $kind = trim((string) ($input['kind'] ?? 'received'));
        $items = correo_db_list_messages($kind === 'sent' ? 'sent' : 'received');
        correo_json(true, array('items' => correo_filter_by_email($items, $email)));
        break;

    case 'send':
        correo_require_login();
        $user = correo_current_user();
        $from = trim((string) ($input['from'] ?? ''));
        $to = trim((string) ($input['to'] ?? ''));
        $subject = trim((string) ($input['subject'] ?? ''));
        $html = trim((string) ($input['html'] ?? ''));

        if ($to === '' || $subject === '' || $html === '') {
            correo_json(false, array(), 'Completa destinatario, asunto y mensaje.');
        }

        if ($from === '') {
            $from = $user['email'] ?? MAIL_WEBMASTER;
        }

        $fromName = iqmaximo_config('IQMAXIMO_RESEND_FROM_NAME', 'iQmaximo.com');
        $payload = array(
            'from' => $fromName . ' <' . $from . '>',
            'to' => array($to),
            'subject' => $subject,
            'html' => $html,
        );

        $result = correo_call_resend('POST', '/emails', $payload);
        if (empty($result['ok'])) {
            correo_json(false, array(), $result['error'] ?? 'No se pudo enviar.');
        }
        $resendData = $result['data'] ?? array();
        $storedId = correo_db_insert_message(array(
            'direction' => 'sent',
            'resend_id' => $resendData['id'] ?? '',
            'message_id' => $resendData['id'] ?? '',
            'sender_email' => $from,
            'recipient_email' => $to,
            'subject' => $subject,
            'html' => $html,
            'text' => strip_tags($html),
            'status' => 'sent',
            'event_type' => 'email.sent',
            'payload_json' => json_encode($resendData, JSON_UNESCAPED_UNICODE),
        ));
        correo_json(true, array('data' => $resendData, 'stored_id' => $storedId));
        break;

    case 'read':
        correo_require_login();
        $id = trim((string) ($input['id'] ?? ''));
        if ($id === '') {
            correo_json(false, array(), 'Falta el id.');
        }
        $kind = trim((string) ($input['kind'] ?? 'received'));
        $result = correo_db_find_message($id, $kind === 'sent' ? 'sent' : 'received');
        if (!$result) {
            correo_json(false, array(), 'No se encontro el correo.');
        }
        // Marcar como leído en la base de datos si es recibido y no lo está ya
        if ($kind === 'received' && (($result['status'] ?? '') === 'received' || ($result['status'] ?? '') === 'stored')) {
            correo_db_update_message_status($id, 'read');
            $result['status'] = 'read';
        }
        correo_json(true, array('data' => $result));
        break;

    case 'replyDraft':
        correo_require_login();
        $id = trim((string) ($input['id'] ?? ''));
        if ($id === '') {
            correo_json(false, array(), 'Falta el id.');
        }
        $kind = trim((string) ($input['kind'] ?? 'received'));
        $result = correo_db_find_message($id, $kind === 'sent' ? 'sent' : 'received');
        if (!$result) {
            correo_json(false, array(), 'No se encontro el correo.');
        }
        $subject = correo_normalize_subject($result['subject'] ?? '');
        correo_json(true, array('draft' => array(
            'to' => trim((string) ($result['from'] ?? '')),
            'subject' => $subject,
            'html' => correo_quote_html($result),
            'original' => $result,
        )));
        break;

    case 'reply':
        correo_require_login();
        $user = correo_current_user();
        $id = trim((string) ($input['id'] ?? ''));
        if ($id === '') {
            correo_json(false, array(), 'Falta el id.');
        }
        $kind = trim((string) ($input['kind'] ?? 'received'));
        $original = correo_db_find_message($id, $kind === 'sent' ? 'sent' : 'received');
        if (!$original) {
            correo_json(false, array(), 'No se encontro el correo.');
        }
        $to = trim((string) ($input['to'] ?? ($original['from'] ?? '')));
        $from = trim((string) ($input['from'] ?? ''));
        $subject = trim((string) ($input['subject'] ?? ''));
        $html = trim((string) ($input['html'] ?? ''));
        if ($to === '') {
            correo_json(false, array(), 'Falta destinatario.');
        }
        if ($from === '') {
            $from = $user['email'] ?? MAIL_WEBMASTER;
        }
        if ($subject === '') {
            $subject = correo_normalize_subject($original['subject'] ?? '');
        }
        if ($html === '') {
            $html = correo_quote_html($original);
        }

        $fromName = iqmaximo_config('IQMAXIMO_RESEND_FROM_NAME', 'iQmaximo.com');
        $payload = array(
            'from' => $fromName . ' <' . $from . '>',
            'to' => array($to),
            'subject' => $subject,
            'html' => $html,
        );

        $result = correo_call_resend('POST', '/emails', $payload);
        if (empty($result['ok'])) {
            correo_json(false, array(), $result['error'] ?? 'No se pudo enviar.');
        }

        $resendData = $result['data'] ?? array();
        $storedId = correo_db_insert_message(array(
            'direction' => 'sent',
            'resend_id' => $resendData['id'] ?? '',
            'message_id' => $resendData['id'] ?? '',
            'sender_email' => $from,
            'recipient_email' => $to,
            'subject' => $subject,
            'html' => $html,
            'text' => strip_tags($html),
            'status' => 'sent',
            'event_type' => 'email.sent',
            'payload_json' => json_encode(array(
                'data' => $resendData,
                'reply_to' => $original,
            ), JSON_UNESCAPED_UNICODE),
        ));
        correo_json(true, array('data' => $resendData, 'stored_id' => $storedId));
        break;

    default:
        correo_json(false, array(), 'Accion invalida.');
}
