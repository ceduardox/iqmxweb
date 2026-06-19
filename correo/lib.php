<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../require/configuracion.php';
require_once __DIR__ . '/../require/util.php';

function correo_data_dir()
{
    $envDir = trim((string) getenv('IQMAXIMO_CORREO_STORAGE_DIR'));
    if ($envDir !== '') {
        return rtrim($envDir, DIRECTORY_SEPARATOR);
    }

    $tmpDir = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'iqmax-correo';
    return $tmpDir;
}

function correo_users_file()
{
    return correo_data_dir() . '/users.json';
}

function correo_user_row_to_array($row)
{
    return array(
        'id' => $row['id'] ?? '',
        'username' => $row['username'] ?? '',
        'email' => $row['email'] ?? '',
        'assigned_email' => $row['assigned_email'] ?? ($row['email'] ?? ''),
        'password' => $row['password'] ?? '',
        'role' => $row['role'] ?? 'user',
        'active' => !empty($row['active']),
    );
}

function correo_db_fetch_users()
{
    correo_db_ready();
    $link = ConectarBD();
    $sql = "SELECT id, username, email, assigned_email, password, role, active
            FROM correo_users
            ORDER BY role DESC, username ASC, id ASC";
    $result = mysqli_query($link, $sql);
    $users = array();
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = correo_user_row_to_array($row);
        }
    }
    return $users;
}

function correo_db_count_users()
{
    correo_db_ready();
    $link = ConectarBD();
    $result = mysqli_query($link, "SELECT COUNT(*) AS total FROM correo_users");
    if (!$result) {
        return 0;
    }
    $row = mysqli_fetch_assoc($result);
    return (int) ($row['total'] ?? 0);
}

function correo_db_has_admin()
{
    correo_db_ready();
    $link = ConectarBD();
    $result = mysqli_query($link, "SELECT 1 FROM correo_users WHERE role='admin' LIMIT 1");
    return $result && mysqli_num_rows($result) > 0;
}

function correo_file_users()
{
    $file = correo_users_file();
    if (!is_file($file)) {
        return array();
    }
    $json = json_decode((string) file_get_contents($file), true);
    return is_array($json) ? $json : array();
}

function correo_current_user()
{
    return $_SESSION['correo_user'] ?? null;
}

function correo_is_admin()
{
    $user = correo_current_user();
    return is_array($user) && (($user['role'] ?? '') === 'admin');
}

function correo_require_login()
{
    if (!correo_current_user()) {
        header('Location: ./index.php');
        exit;
    }
}

function correo_read_users()
{
    return array();
}

function correo_seed_admin()
{
    $adminUser = trim((string) iqmaximo_config('IQMAXIMO_CORREO_ADMIN_USER', 'admin'));
    $adminPass = (string) iqmaximo_config('IQMAXIMO_CORREO_ADMIN_PASS', '');
    if ($adminPass === '') {
        return;
    }

    if (correo_db_has_admin()) {
        return;
    }

    $link = ConectarBD();
    $id = correo_db_escape(uniqid('admin_', true));
    $username = correo_db_escape($adminUser);
    $email = correo_db_escape(MAIL_WEBMASTER);
    $password = correo_db_escape(password_hash($adminPass, PASSWORD_DEFAULT));
    $sql = "INSERT INTO correo_users (id, username, email, assigned_email, password, role, active)
            VALUES ('$id', '$username', '$email', '$email', '$password', 'admin', 1)";
    mysqli_query($link, $sql);
}

function correo_find_user($username)
{
    $adminUser = trim((string) iqmaximo_config('IQMAXIMO_CORREO_ADMIN_USER', 'admin'));
    $adminPass = (string) iqmaximo_config('IQMAXIMO_CORREO_ADMIN_PASS', '');
    $username = trim((string) $username);
    if ($adminPass === '') {
        return null;
    }

    if (strcasecmp($username, $adminUser) !== 0 && strcasecmp($username, MAIL_WEBMASTER) !== 0 && strcasecmp($username, 'admin') !== 0) {
        return null;
    }

    return array(
        'id' => 'admin',
        'username' => $adminUser,
        'email' => MAIL_WEBMASTER,
        'assigned_email' => MAIL_WEBMASTER,
        'password' => password_hash($adminPass, PASSWORD_DEFAULT),
        'role' => 'admin',
        'active' => true,
    );
}

function correo_public_user($user)
{
    return array(
        'id' => $user['id'] ?? '',
        'username' => $user['username'] ?? '',
        'email' => $user['email'] ?? '',
        'assigned_email' => $user['assigned_email'] ?? ($user['email'] ?? ''),
        'role' => $user['role'] ?? 'admin',
        'active' => !empty($user['active']),
        'password' => $user['password'] ?? '',
    );
}

function correo_resend_key()
{
    return trim((string) iqmaximo_config('IQMAXIMO_RESEND_API_KEY', ''));
}

function correo_webhook_secret()
{
    return trim((string) iqmaximo_config('IQMAXIMO_CORREO_WEBHOOK_SECRET', ''));
}

function correo_request_header($name)
{
    $name = strtoupper(trim((string) $name));
    if ($name === '') {
        return '';
    }

    $serverKey = 'HTTP_' . str_replace('-', '_', $name);
    if (isset($_SERVER[$serverKey])) {
        return trim((string) $_SERVER[$serverKey]);
    }

    if (function_exists('getallheaders')) {
        $headers = getallheaders();
        if (is_array($headers)) {
            foreach ($headers as $key => $value) {
                if (strtoupper(str_replace('-', '_', $key)) === str_replace('-', '_', $name)) {
                    return trim((string) $value);
                }
            }
        }
    }

    return '';
}

function correo_webhook_secret_matches()
{
    $expected = correo_webhook_secret();
    if ($expected === '') {
        return true;
    }

    $provided = trim((string) ($_GET['secret'] ?? ''));
    if ($provided === '') {
        $provided = correo_request_header('X-IQMAXIMO-CORREO-SECRET');
    }
    if ($provided === '') {
        $provided = correo_request_header('X-IQMAXIMO-WEBHOOK-SECRET');
    }
    if ($provided === '') {
        $auth = correo_request_header('Authorization');
        if (stripos($auth, 'Bearer ') === 0) {
            $provided = trim(substr($auth, 7));
        }
    }

    if ($provided === '') {
        return false;
    }

    return hash_equals($expected, $provided);
}

function correo_call_resend($method, $path, $body = null)
{
    $key = correo_resend_key();
    if ($key === '') {
        return array('ok' => false, 'error' => 'Falta configurar IQMAXIMO_RESEND_API_KEY.');
    }

    static $lastCallAt = 0.0;
    $minInterval = 0.22;

    for ($attempt = 0; $attempt < 2; $attempt++) {
        $elapsed = microtime(true) - $lastCallAt;
        if ($elapsed < $minInterval) {
            usleep((int) (($minInterval - $elapsed) * 1000000));
        }

        $lastCallAt = microtime(true);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.resend.com' . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $key,
            'Content-Type: application/json',
            'Accept: application/json',
        ));
        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return array('ok' => false, 'error' => $error);
        }

        $decoded = json_decode((string) $response, true);
        if ($status === 429 && $attempt === 0) {
            usleep(800000);
            continue;
        }

        if ($status < 200 || $status >= 300) {
            $message = is_array($decoded) && isset($decoded['message']) ? $decoded['message'] : ('Resend HTTP ' . $status);
            return array('ok' => false, 'error' => $message, 'raw' => $decoded);
        }

        return array('ok' => true, 'data' => $decoded);
    }

    return array('ok' => false, 'error' => 'Resend rate limited. Intenta de nuevo en unos segundos.');
}

function correo_norm_email($value)
{
    return strtolower(trim((string) $value));
}

function correo_normalize_subject($subject)
{
    $subject = trim((string) $subject);
    if ($subject === '') {
        return '';
    }

    $prefix = strtolower(substr($subject, 0, 3));
    if ($prefix === 're:' || $prefix === 'fw:') {
        return $subject;
    }

    return 'Re: ' . $subject;
}

function correo_quote_html($source)
{
    $from = htmlspecialchars((string) ($source['from'] ?? ''), ENT_QUOTES, 'UTF-8');
    $to = htmlspecialchars((string) ($source['to'] ?? ''), ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars((string) ($source['subject'] ?? ''), ENT_QUOTES, 'UTF-8');
    $body = (string) ($source['html'] ?? ($source['text'] ?? ''));
    if (trim($body) === '') {
        $body = '<p>Sin contenido original.</p>';
    }

    return '<div style="font-family:Arial,sans-serif;font-size:14px;line-height:1.6;color:#111">'
        . '<p>Hola,</p>'
        . '<p></p>'
        . '<p>---</p>'
        . '<p><strong>Mensaje original</strong></p>'
        . '<p><strong>De:</strong> ' . $from . '</p>'
        . '<p><strong>Para:</strong> ' . $to . '</p>'
        . '<p><strong>Asunto:</strong> ' . $subject . '</p>'
        . '<div style="border-left:3px solid #ccc;padding-left:12px;margin-top:12px">' . $body . '</div>'
        . '</div>';
}

function correo_store_received_message($source, $fallback = array())
{
    $source = is_array($source) ? $source : array();
    $fallback = is_array($fallback) ? $fallback : array();
    $merged = array_merge($fallback, $source);

    $sender = correo_norm_email($merged['from'] ?? '');
    $recipient = is_array($merged['to'] ?? null) ? implode(', ', $merged['to']) : (string) ($merged['to'] ?? '');
    $html = (string) ($merged['html'] ?? '');
    $text = (string) ($merged['text'] ?? '');
    $payload = json_encode($merged, JSON_UNESCAPED_UNICODE);

    if (trim($html) === '' && trim($text) === '') {
        $html = correo_payload_text($payload, true);
        $text = correo_payload_text($payload, false);
    }

    return correo_db_save_message(array(
        'direction' => 'received',
        'resend_id' => (string) ($merged['id'] ?? ($fallback['id'] ?? '')),
        'message_id' => (string) ($merged['message_id'] ?? ($fallback['message_id'] ?? ($fallback['id'] ?? ''))),
        'sender_email' => $sender,
        'recipient_email' => $recipient,
        'subject' => $merged['subject'] ?? '',
        'html' => $html,
        'text' => $text,
        'status' => 'received',
        'event_type' => $merged['event_type'] ?? 'received',
        'payload_json' => $payload,
    ));
}

function correo_payload_text($payloadJson, $preferHtml = true)
{
    $payloadJson = trim((string) $payloadJson);
    if ($payloadJson === '') {
        return '';
    }

    $decoded = json_decode($payloadJson, true);
    if (!is_array($decoded)) {
        return '';
    }

    $candidates = array();
    if ($preferHtml) {
        $candidates = array('html', 'text', 'body', 'content', 'preview');
    } else {
        $candidates = array('text', 'html', 'body', 'content', 'preview');
    }

    foreach ($candidates as $key) {
        if (isset($decoded[$key]) && is_string($decoded[$key]) && trim($decoded[$key]) !== '') {
            return (string) $decoded[$key];
        }
    }

    foreach (array('data', 'email', 'message') as $containerKey) {
        if (!isset($decoded[$containerKey]) || !is_array($decoded[$containerKey])) {
            continue;
        }
        foreach ($candidates as $key) {
            if (isset($decoded[$containerKey][$key]) && is_string($decoded[$containerKey][$key]) && trim($decoded[$containerKey][$key]) !== '') {
                return (string) $decoded[$containerKey][$key];
            }
        }
    }

    return '';
}

function correo_extract_items($payload)
{
    if (!is_array($payload)) {
        return array();
    }
    if (isset($payload['data']) && is_array($payload['data'])) {
        return $payload['data'];
    }
    return $payload;
}

function correo_map_messages($items, $mode)
{
    $out = array();
    foreach ((array) $items as $item) {
        $toValue = $item['to'] ?? '';
        if (is_array($toValue)) {
            $toValue = implode(', ', $toValue);
        }
        $out[] = array(
            'id' => $item['id'] ?? '',
            'from' => $item['from'] ?? '',
            'to' => $toValue,
            'subject' => $item['subject'] ?? '',
            'text' => $item['text'] ?? '',
            'html' => $item['html'] ?? '',
            'preview' => $item['preview'] ?? ($item['text'] ?? ''),
            'created_at' => $item['created_at'] ?? ($item['received_at'] ?? ''),
            'status' => $mode,
        );
    }
    return $out;
}

function correo_filter_by_user($items, $user)
{
    if (correo_is_admin()) {
        return $items;
    }

    $email = correo_norm_email($user['email'] ?? '');
    if ($email === '') {
        return array();
    }

    $filtered = array();
    foreach ($items as $item) {
        $from = correo_norm_email($item['from'] ?? '');
        $to = correo_norm_email($item['to'] ?? '');
        if (strpos($to, $email) !== false || strpos($from, $email) !== false) {
            $filtered[] = $item;
        }
    }
    return $filtered;
}

function correo_filter_by_email($items, $email)
{
    $email = correo_norm_email($email);
    if ($email === '') {
        return array();
    }

    $filtered = array();
    foreach ($items as $item) {
        $from = correo_norm_email($item['from'] ?? '');
        $to = correo_norm_email($item['to'] ?? '');
        if (strpos($to, $email) !== false || strpos($from, $email) !== false) {
            $filtered[] = $item;
        }
    }
    return $filtered;
}

function correo_mailboxes()
{
    $raw = trim((string) iqmaximo_config('IQMAXIMO_CORREO_MAILBOXES_JSON', ''));
    if ($raw === '') {
        return array(
            array('username' => 'info', 'email' => MAIL_INFO, 'assigned_email' => MAIL_INFO, 'active' => true),
            array('username' => 'webmaster', 'email' => MAIL_WEBMASTER, 'assigned_email' => MAIL_WEBMASTER, 'active' => true),
            array('username' => 'fparedes', 'email' => 'fparedes@iqmaximo.com', 'assigned_email' => 'fparedes@iqmaximo.com', 'active' => true),
        );
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        return array();
    }

    $mailboxes = array();
    foreach ($decoded as $item) {
        if (!is_array($item)) {
            continue;
        }
        $email = trim((string) ($item['email'] ?? ''));
        if ($email === '') {
            continue;
        }
        $mailboxes[] = array(
            'username' => trim((string) ($item['username'] ?? $email)),
            'email' => $email,
            'assigned_email' => trim((string) ($item['assigned_email'] ?? $email)),
            'active' => !isset($item['active']) || (bool) $item['active'],
        );
    }
    if (!$mailboxes) {
        return array(
            array('username' => 'info', 'email' => MAIL_INFO, 'assigned_email' => MAIL_INFO, 'active' => true),
            array('username' => 'fparedes', 'email' => 'fparedes@iqmaximo.com', 'assigned_email' => 'fparedes@iqmaximo.com', 'active' => true),
        );
    }
    return $mailboxes;
}

function correo_default_mailbox()
{
    $mailboxes = correo_mailboxes();
    foreach ($mailboxes as $mailbox) {
        $email = strtolower(trim((string) ($mailbox['assigned_email'] ?? ($mailbox['email'] ?? ''))));
        if ($email === 'fparedes@iqmaximo.com') {
            return 'fparedes@iqmaximo.com';
        }
    }
    $default = trim((string) iqmaximo_config('IQMAXIMO_CORREO_DEFAULT_MAILBOX', ''));
    if ($default !== '') {
        return $default;
    }
    if (!empty($mailboxes[0])) {
        return $mailboxes[0]['assigned_email'] ?? ($mailboxes[0]['email'] ?? '');
    }

    return 'fparedes@iqmaximo.com';
}

function correo_log_boot($context = array())
{
    $parts = array();
    foreach ((array) $context as $key => $value) {
        $parts[] = $key . '=' . (is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE));
    }
    error_log('[correo] ' . implode(' ', $parts));
}

function correo_db_ready()
{
    static $ready = false;
    if ($ready) {
        return true;
    }

    $link = ConectarBD();
    $sqlMessages = "
        CREATE TABLE IF NOT EXISTS correo_messages (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            direction VARCHAR(16) NOT NULL,
            resend_id VARCHAR(128) NULL,
            message_id VARCHAR(128) NULL,
            sender_email VARCHAR(255) NULL,
            recipient_email VARCHAR(255) NULL,
            subject VARCHAR(255) NULL,
            html MEDIUMTEXT NULL,
            text MEDIUMTEXT NULL,
            status VARCHAR(32) NOT NULL DEFAULT 'stored',
            event_type VARCHAR(64) NULL,
            payload_json LONGTEXT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
            KEY idx_direction_created (direction, created_at),
            KEY idx_resend_id (resend_id),
            KEY idx_message_id (message_id),
            KEY idx_recipient (recipient_email),
            KEY idx_sender (sender_email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ";
    $sqlEvents = "
        CREATE TABLE IF NOT EXISTS correo_events (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            event_type VARCHAR(64) NOT NULL,
            resend_id VARCHAR(128) NULL,
            payload_json LONGTEXT NOT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            KEY idx_event_type_created (event_type, created_at),
            KEY idx_event_resend_id (resend_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ";
    $sqlUsers = "
        CREATE TABLE IF NOT EXISTS correo_users (
            id VARCHAR(80) NOT NULL PRIMARY KEY,
            username VARCHAR(120) NOT NULL,
            email VARCHAR(255) NOT NULL,
            assigned_email VARCHAR(255) NOT NULL DEFAULT '',
            password VARCHAR(255) NOT NULL,
            role VARCHAR(16) NOT NULL DEFAULT 'user',
            active TINYINT(1) NOT NULL DEFAULT 1,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_username (username),
            UNIQUE KEY uniq_email (email),
            KEY idx_role_active (role, active)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ";
    mysqli_query($link, $sqlMessages);
    mysqli_query($link, $sqlEvents);
    mysqli_query($link, $sqlUsers);
    $ready = true;
    return true;
}

function correo_db_escape($value)
{
    $link = ConectarBD();
    return mysqli_real_escape_string($link, (string) $value);
}

function correo_db_insert_message($data)
{
    correo_db_ready();
    $link = ConectarBD();
    $direction = correo_db_escape($data['direction'] ?? '');
    $resendId = correo_db_escape($data['resend_id'] ?? '');
    $messageId = correo_db_escape($data['message_id'] ?? '');
    $sender = correo_db_escape($data['sender_email'] ?? '');
    $recipient = correo_db_escape($data['recipient_email'] ?? '');
    $subject = correo_db_escape($data['subject'] ?? '');
    $html = correo_db_escape($data['html'] ?? '');
    $text = correo_db_escape($data['text'] ?? '');
    $status = correo_db_escape($data['status'] ?? 'stored');
    $eventType = correo_db_escape($data['event_type'] ?? '');
    $payload = correo_db_escape($data['payload_json'] ?? '');

    $sql = "INSERT INTO correo_messages
        (direction, resend_id, message_id, sender_email, recipient_email, subject, html, text, status, event_type, payload_json)
        VALUES
        ('$direction', " . ($resendId === '' ? 'NULL' : "'$resendId'") . ", " . ($messageId === '' ? 'NULL' : "'$messageId'") . ",
         " . ($sender === '' ? 'NULL' : "'$sender'") . ", " . ($recipient === '' ? 'NULL' : "'$recipient'") . ",
         " . ($subject === '' ? 'NULL' : "'$subject'") . ", " . ($html === '' ? 'NULL' : "'$html'") . ",
         " . ($text === '' ? 'NULL' : "'$text'") . ", '$status', " . ($eventType === '' ? 'NULL' : "'$eventType'") . ",
         " . ($payload === '' ? 'NULL' : "'$payload'") . ")";

    mysqli_query($link, $sql);
    return mysqli_insert_id($link);
}

function correo_db_update_message_fields($id, $data, $direction = '')
{
    correo_db_ready();
    $link = ConectarBD();
    $id = correo_db_escape($id);
    $direction = correo_db_escape($direction);
    $sender = correo_db_escape($data['sender_email'] ?? '');
    $recipient = correo_db_escape($data['recipient_email'] ?? '');
    $subject = correo_db_escape($data['subject'] ?? '');
    $html = correo_db_escape($data['html'] ?? '');
    $text = correo_db_escape($data['text'] ?? '');
    $status = correo_db_escape($data['status'] ?? 'stored');
    $eventType = correo_db_escape($data['event_type'] ?? '');
    $payload = correo_db_escape($data['payload_json'] ?? '');

    $set = array(
        "sender_email=" . ($sender === '' ? 'NULL' : "'$sender'"),
        "recipient_email=" . ($recipient === '' ? 'NULL' : "'$recipient'"),
        "subject=" . ($subject === '' ? 'NULL' : "'$subject'"),
        "html=" . ($html === '' ? 'NULL' : "'$html'"),
        "text=" . ($text === '' ? 'NULL' : "'$text'"),
        "status='" . $status . "'",
        "payload_json=" . ($payload === '' ? 'NULL' : "'$payload'"),
    );
    if ($eventType !== '') {
        $set[] = "event_type='$eventType'";
    }
    $where = "(resend_id='$id' OR message_id='$id')";
    if ($direction !== '') {
        $where = "direction='$direction' AND " . $where;
    }
    $sql = "UPDATE correo_messages SET " . implode(', ', $set) . " WHERE " . $where . " LIMIT 1";
    mysqli_query($link, $sql);
    return mysqli_affected_rows($link);
}

function correo_db_save_message($data)
{
    $resendId = trim((string) ($data['resend_id'] ?? ''));
    $messageId = trim((string) ($data['message_id'] ?? ''));
    $direction = trim((string) ($data['direction'] ?? ''));
    $lookupId = $resendId !== '' ? $resendId : $messageId;
    if ($lookupId !== '' && correo_db_find_message($lookupId, $direction)) {
        correo_db_update_message_fields($lookupId, $data, $direction);
        return true;
    }
    correo_db_insert_message($data);
    return true;
}

function correo_db_insert_event($data)
{
    correo_db_ready();
    $link = ConectarBD();
    $eventType = correo_db_escape($data['event_type'] ?? '');
    $resendId = correo_db_escape($data['resend_id'] ?? '');
    $payload = correo_db_escape($data['payload_json'] ?? '');
    $sql = "INSERT INTO correo_events (event_type, resend_id, payload_json) VALUES
        (" . ($eventType === '' ? 'NULL' : "'$eventType'") . ",
        " . ($resendId === '' ? 'NULL' : "'$resendId'") . ",
        '$payload')";
    mysqli_query($link, $sql);
    return mysqli_insert_id($link);
}

function correo_db_update_message_status($resendId, $status, $eventType = '')
{
    correo_db_ready();
    $link = ConectarBD();
    $resendId = correo_db_escape($resendId);
    $status = correo_db_escape($status);
    $eventType = correo_db_escape($eventType);
    $sql = "UPDATE correo_messages SET status='$status'" . ($eventType !== '' ? ", event_type='$eventType'" : '') . " WHERE resend_id='$resendId' OR message_id='$resendId'";
    mysqli_query($link, $sql);
    return mysqli_affected_rows($link);
}

function correo_db_list_messages($direction)
{
    correo_db_ready();
    $link = ConectarBD();
    $direction = correo_db_escape($direction);
    $sql = "SELECT * FROM correo_messages WHERE direction='$direction' ORDER BY created_at DESC, id DESC LIMIT 300";
    $result = mysqli_query($link, $sql);
    $items = array();
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $html = $row['html'] ?? '';
            $text = $row['text'] ?? '';
            $payloadJson = $row['payload_json'] ?? '';
            if ($html === '' && $text === '') {
                $html = correo_payload_text($payloadJson, true);
                $text = correo_payload_text($payloadJson, false);
            }
            $items[] = array(
                'id' => $row['resend_id'] ?: $row['message_id'] ?: (string) $row['id'],
                'from' => $row['sender_email'] ?? '',
                'to' => $row['recipient_email'] ?? '',
                'subject' => $row['subject'] ?? '',
                'text' => $text,
                'html' => $html,
                'preview' => $text !== '' ? $text : $html,
                'created_at' => $row['created_at'] ?? '',
                'status' => $row['status'] ?? '',
                'payload_json' => $payloadJson,
            );
        }
    }
    return $items;
}

function correo_db_find_message($id, $direction = '')
{
    correo_db_ready();
    $link = ConectarBD();
    $id = correo_db_escape($id);
    $direction = correo_db_escape($direction);
    $where = "resend_id='$id' OR message_id='$id'";
    if ($direction !== '') {
        $where = "direction='$direction' AND (" . $where . ")";
    }
    $sql = "SELECT * FROM correo_messages WHERE $where ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($link, $sql);
    if ($result && ($row = mysqli_fetch_assoc($result))) {
        $html = $row['html'] ?? '';
        $text = $row['text'] ?? '';
        $payloadJson = $row['payload_json'] ?? '';
        if ($html === '' && $text === '') {
            $html = correo_payload_text($payloadJson, true);
            $text = correo_payload_text($payloadJson, false);
        }
        return array(
            'id' => $row['resend_id'] ?: $row['message_id'] ?: (string) $row['id'],
            'from' => $row['sender_email'] ?? '',
            'to' => $row['recipient_email'] ?? '',
            'subject' => $row['subject'] ?? '',
            'text' => $text,
            'html' => $html,
            'preview' => $text !== '' ? $text : $html,
            'created_at' => $row['created_at'] ?? '',
            'status' => $row['status'] ?? '',
            'payload_json' => $payloadJson,
        );
    }
    return null;
}

function correo_resend_list_all($endpoint)
{
    return correo_resend_list_page($endpoint, 100, '');
}

function correo_resend_list_page($endpoint, $limit = 5, $after = '')
{
    $path = $endpoint . (strpos($endpoint, '?') === false ? '?' : '&') . 'limit=' . max(1, (int) $limit);
    if ($after !== '') {
        $path .= '&after=' . urlencode($after);
    }
    $result = correo_call_resend('GET', $path);
    if (empty($result['ok'])) {
        return array('ok' => false, 'error' => $result['error'] ?? 'No se pudo consultar Resend.');
    }

    $payload = $result['data'] ?? array();
    $items = array();
    if (isset($payload['data']) && is_array($payload['data'])) {
        $items = $payload['data'];
    } elseif (is_array($payload)) {
        $items = $payload;
    }

    $nextAfter = '';
    if (!empty($payload['has_more']) && !empty($items)) {
        $last = end($items);
        $nextAfter = is_array($last) && !empty($last['id']) ? (string) $last['id'] : '';
    }

    return array('ok' => true, 'items' => $items, 'has_more' => !empty($payload['has_more']), 'next_after' => $nextAfter);
}

function correo_import_cursor_decode($after)
{
    $after = trim((string) $after);
    if ($after === '') {
        return array(
            'received_after' => '',
            'sent_after' => '',
            'received_done' => false,
            'sent_done' => false,
        );
    }

    $decoded = json_decode($after, true);
    if (!is_array($decoded) || json_last_error() !== JSON_ERROR_NONE) {
        return array(
            'received_after' => $after,
            'sent_after' => '',
            'received_done' => false,
            'sent_done' => false,
        );
    }

    return array(
        'received_after' => isset($decoded['received_after']) ? (string) $decoded['received_after'] : '',
        'sent_after' => isset($decoded['sent_after']) ? (string) $decoded['sent_after'] : '',
        'received_done' => !empty($decoded['received_done']),
        'sent_done' => !empty($decoded['sent_done']),
    );
}

function correo_import_cursor_encode($receivedAfter, $sentAfter, $receivedDone = false, $sentDone = false)
{
    $payload = array(
        'received_after' => (string) $receivedAfter,
        'sent_after' => (string) $sentAfter,
        'received_done' => (bool) $receivedDone,
        'sent_done' => (bool) $sentDone,
    );
    if ($payload['received_after'] === '' && $payload['sent_after'] === '' && $payload['received_done'] && $payload['sent_done']) {
        return '';
    }
    return json_encode($payload, JSON_UNESCAPED_UNICODE);
}

function correo_resend_get_received_email($id)
{
    $id = trim((string) $id);
    if ($id === '') {
        return array('ok' => false, 'error' => 'Falta el id.');
    }
    $result = correo_call_resend('GET', '/emails/receiving/' . rawurlencode($id));
    if (empty($result['ok'])) {
        return array('ok' => false, 'error' => $result['error'] ?? 'No se pudo consultar el correo.');
    }
    return array('ok' => true, 'item' => $result['data'] ?? array());
}

function correo_import_history_for_email($email, $limit = 5, $after = '')
{
    $email = correo_norm_email($email);
    if ($email === '') {
        return array('ok' => false, 'error' => 'Email vacio.');
    }

    $cursor = correo_import_cursor_decode($after);
    $imported = 0;
    $updated = 0;
    $maxReceivedPages = 12;
    $maxSentPages = 4;

    $receivedAfter = $cursor['received_after'];
    $receivedDone = !empty($cursor['received_done']);
    if (!$receivedDone) {
        $receivedPages = 0;
        do {
            $receivedResult = correo_resend_list_page('/emails/receiving', max(1, (int) $limit), $receivedAfter);
            if (empty($receivedResult['ok'])) {
                return $receivedResult;
            }
            $receivedPages++;

            foreach (($receivedResult['items'] ?? array()) as $index => $item) {
                $toList = is_array($item['to'] ?? null) ? $item['to'] : array($item['to'] ?? '');
                $matches = false;
                foreach ($toList as $recipient) {
                    if (correo_norm_email($recipient) === $email) {
                        $matches = true;
                        break;
                    }
                }
                if (!$matches) {
                    continue;
                }

                if ($index > 0) {
                    usleep(250000);
                }
                $detail = correo_resend_get_received_email($item['id'] ?? '');
                $detailItem = !empty($detail['ok']) ? ($detail['item'] ?? array()) : array();
                $source = is_array($detailItem) && !empty($detailItem) ? $detailItem : $item;
                $sender = correo_norm_email($source['from'] ?? '');
                $recipient = is_array($source['to'] ?? null) ? implode(', ', $source['to']) : (string) ($source['to'] ?? '');
                $html = (string) ($source['html'] ?? '');
                $text = (string) ($source['text'] ?? '');
                $payload = json_encode($source, JSON_UNESCAPED_UNICODE);
                $saved = correo_db_save_message(array(
                    'direction' => 'received',
                    'resend_id' => (string) ($source['id'] ?? ($item['id'] ?? '')),
                    'message_id' => (string) ($source['message_id'] ?? ($item['message_id'] ?? ($item['id'] ?? ''))),
                    'sender_email' => $sender,
                    'recipient_email' => $recipient,
                    'subject' => $source['subject'] ?? '',
                    'html' => $html,
                    'text' => $text,
                    'status' => 'received',
                    'event_type' => 'import',
                    'payload_json' => $payload,
                ));
                $updated += $saved ? 1 : 0;
            }

            $receivedAfter = !empty($receivedResult['next_after']) ? (string) $receivedResult['next_after'] : '';
            $receivedDone = empty($receivedResult['has_more']) || $receivedAfter === '';
        } while (!$receivedDone && $receivedPages < $maxReceivedPages);
    }

    $sentAfter = $cursor['sent_after'];
    $sentDone = !empty($cursor['sent_done']);
    if (!$sentDone) {
        $sentPages = 0;
        do {
            $sentResult = correo_resend_list_page('/emails', 30, $sentAfter);
            if (empty($sentResult['ok'])) {
                return $sentResult;
            }
            $sentPages++;

            foreach (($sentResult['items'] ?? array()) as $item) {
                $from = correo_norm_email($item['from'] ?? '');
                $to = correo_norm_email(is_array($item['to'] ?? null) ? implode(', ', $item['to']) : ($item['to'] ?? ''));
                if ($from !== $email && strpos($to, $email) === false) {
                    continue;
                }

                $direction = strpos($from, $email) !== false ? 'sent' : 'received';
                $resendId = (string) ($item['id'] ?? '');
                $payload = json_encode($item, JSON_UNESCAPED_UNICODE);
                $saved = correo_db_save_message(array(
                    'direction' => $direction,
                    'resend_id' => $resendId,
                    'message_id' => $resendId,
                    'sender_email' => $from,
                    'recipient_email' => $to,
                    'subject' => $item['subject'] ?? '',
                    'html' => $item['html'] ?? '',
                    'text' => $item['text'] ?? '',
                    'status' => $direction,
                    'event_type' => 'import',
                    'payload_json' => $payload,
                ));
                $imported += $saved ? 1 : 0;
            }

            $sentAfter = !empty($sentResult['next_after']) ? (string) $sentResult['next_after'] : '';
            $sentDone = empty($sentResult['has_more']) || $sentAfter === '';
        } while (!$sentDone && $sentPages < $maxSentPages);
    }

    $nextAfter = correo_import_cursor_encode(
        $receivedAfter,
        $sentAfter,
        $receivedDone,
        $sentDone
    );

    return array(
        'ok' => true,
        'imported' => $imported,
        'updated' => $updated,
        'has_more' => $nextAfter !== '',
        'next_after' => $nextAfter,
    );
}
