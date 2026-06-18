<?php
require_once __DIR__ . '/../require/configuracion.php';
require_once __DIR__ . '/../require/util.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

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
    $file = correo_users_file();
    if (!is_file($file)) {
        return array();
    }
    $json = json_decode((string) file_get_contents($file), true);
    return is_array($json) ? $json : array();
}

function correo_write_users($users)
{
    $dir = correo_data_dir();
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    $bytes = @file_put_contents(correo_users_file(), json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    if ($bytes === false) {
        $fallbackDir = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'iqmax-correo';
        if (!is_dir($fallbackDir)) {
            mkdir($fallbackDir, 0775, true);
        }
        $fallbackFile = $fallbackDir . DIRECTORY_SEPARATOR . 'users.json';
        $bytes = @file_put_contents($fallbackFile, json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        if ($bytes === false) {
            throw new RuntimeException('No se pudo guardar users.json en una ruta escribible.');
        }
    }
}

function correo_seed_admin()
{
    $users = correo_read_users();
    foreach ($users as $user) {
        if (($user['role'] ?? '') === 'admin') {
            return;
        }
    }

    $adminUser = trim((string) iqmaximo_config('IQMAXIMO_CORREO_ADMIN_USER', 'admin'));
    $adminPass = (string) iqmaximo_config('IQMAXIMO_CORREO_ADMIN_PASS', '');
    if ($adminPass === '') {
        return;
    }

    $users[] = array(
        'id' => uniqid('user_', true),
        'username' => $adminUser,
        'email' => MAIL_WEBMASTER,
        'password' => password_hash($adminPass, PASSWORD_DEFAULT),
        'role' => 'admin',
        'active' => true,
    );
    correo_write_users($users);
}

function correo_find_user($username)
{
    foreach (correo_read_users() as $user) {
        if (strcasecmp((string) ($user['username'] ?? ''), (string) $username) === 0) {
            return $user;
        }
    }
    return null;
}

function correo_public_user($user)
{
    return array(
        'id' => $user['id'] ?? '',
        'username' => $user['username'] ?? '',
        'email' => $user['email'] ?? '',
        'role' => $user['role'] ?? 'user',
        'active' => !empty($user['active']),
    );
}

function correo_resend_key()
{
    return trim((string) iqmaximo_config('IQMAXIMO_RESEND_API_KEY', ''));
}

function correo_call_resend($method, $path, $body = null)
{
    $key = correo_resend_key();
    if ($key === '') {
        return array('ok' => false, 'error' => 'Falta configurar IQMAXIMO_RESEND_API_KEY.');
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.resend.com' . $path);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $key,
        'Content-Type: application/json',
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
    if ($status < 200 || $status >= 300) {
        $message = is_array($decoded) && isset($decoded['message']) ? $decoded['message'] : ('Resend HTTP ' . $status);
        return array('ok' => false, 'error' => $message, 'raw' => $decoded);
    }

    return array('ok' => true, 'data' => $decoded);
}

function correo_norm_email($value)
{
    return strtolower(trim((string) $value));
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
    mysqli_query($link, $sqlMessages);
    mysqli_query($link, $sqlEvents);
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
            $items[] = array(
                'id' => $row['resend_id'] ?: $row['message_id'] ?: (string) $row['id'],
                'from' => $row['sender_email'] ?? '',
                'to' => $row['recipient_email'] ?? '',
                'subject' => $row['subject'] ?? '',
                'text' => $row['text'] ?? '',
                'html' => $row['html'] ?? '',
                'preview' => $row['text'] ?? '',
                'created_at' => $row['created_at'] ?? '',
                'status' => $row['status'] ?? '',
                'payload_json' => $row['payload_json'] ?? '',
            );
        }
    }
    return $items;
}
