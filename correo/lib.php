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

function correo_config_users()
{
    $raw = trim((string) iqmaximo_config('IQMAXIMO_CORREO_USERS_JSON', ''));
    if ($raw === '') {
        return array();
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        return array();
    }

    $users = array();
    foreach ($decoded as $item) {
        if (!is_array($item)) {
            continue;
        }
        $username = trim((string) ($item['username'] ?? ''));
        $email = trim((string) ($item['email'] ?? ''));
        if ($username === '' || $email === '') {
            continue;
        }
        $users[] = array(
            'id' => trim((string) ($item['id'] ?? '')),
            'username' => $username,
            'email' => $email,
            'assigned_email' => trim((string) ($item['assigned_email'] ?? $email)),
            'password' => (string) ($item['password'] ?? ''),
            'role' => ($item['role'] ?? 'user') === 'admin' ? 'admin' : 'user',
            'active' => !isset($item['active']) || (bool) $item['active'],
        );
    }

    return $users;
}

function correo_upsert_user_record($record)
{
    correo_db_ready();
    $link = ConectarBD();

    $id = correo_db_escape($record['id'] !== '' ? $record['id'] : uniqid('user_', true));
    $username = correo_db_escape($record['username']);
    $email = correo_db_escape($record['email']);
    $assignedEmail = correo_db_escape($record['assigned_email'] !== '' ? $record['assigned_email'] : $record['email']);
    $password = correo_db_escape($record['password']);
    $role = $record['role'] === 'admin' ? 'admin' : 'user';
    $active = !empty($record['active']) ? 1 : 0;

    if ($username === '' || $email === '' || $password === '') {
        return false;
    }

    $sql = "INSERT INTO correo_users (id, username, email, assigned_email, password, role, active)
            VALUES ('$id', '$username', '$email', '$assignedEmail', '$password', '$role', $active)
            ON DUPLICATE KEY UPDATE
                username=VALUES(username),
                email=VALUES(email),
                assigned_email=VALUES(assigned_email),
                password=VALUES(password),
                role=VALUES(role),
                active=VALUES(active)";
    return (bool) mysqli_query($link, $sql);
}

function correo_sync_config_users()
{
    $configUsers = correo_config_users();
    if (!$configUsers) {
        return;
    }

    foreach ($configUsers as $user) {
        correo_upsert_user_record($user);
    }
}

function correo_migrate_file_users_to_db()
{
    static $migrated = false;
    if ($migrated) {
        return;
    }

    if (correo_db_count_users() > 0) {
        $migrated = true;
        return;
    }

    $fileUsers = correo_file_users();
    if (!$fileUsers) {
        $migrated = true;
        return;
    }

    correo_write_users($fileUsers);
    $migrated = true;
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
    correo_db_ready();
    correo_migrate_file_users_to_db();
    correo_sync_config_users();
    $users = correo_db_fetch_users();
    if ($users) {
        return $users;
    }
    correo_seed_admin();
    return correo_db_fetch_users();
}

function correo_write_users($users)
{
    correo_db_ready();
    $link = ConectarBD();
    mysqli_begin_transaction($link);

    $reset = mysqli_query($link, "DELETE FROM correo_users");
    if (!$reset) {
        mysqli_rollback($link);
        throw new RuntimeException('No se pudo limpiar la tabla de usuarios.');
    }

    foreach (array_values($users) as $user) {
        $record = correo_user_row_to_array($user);
        $id = correo_db_escape($record['id'] !== '' ? $record['id'] : uniqid('user_', true));
        $username = correo_db_escape($record['username']);
        $email = correo_db_escape($record['email']);
        $assignedEmail = correo_db_escape($record['assigned_email'] !== '' ? $record['assigned_email'] : $record['email']);
        $password = correo_db_escape($record['password']);
        $role = $record['role'] === 'admin' ? 'admin' : 'user';
        $active = !empty($record['active']) ? 1 : 0;

        if ($username === '' || $email === '' || $password === '') {
            continue;
        }

        $sql = "INSERT INTO correo_users (id, username, email, assigned_email, password, role, active)
                VALUES ('$id', '$username', '$email', '$assignedEmail', '$password', '$role', $active)";
        if (!mysqli_query($link, $sql)) {
            mysqli_rollback($link);
            throw new RuntimeException('No se pudo guardar el usuario ' . $record['username'] . '.');
        }
    }

    mysqli_commit($link);
}

function correo_seed_admin()
{
    if (correo_db_has_admin()) {
        return;
    }

    $adminUser = trim((string) iqmaximo_config('IQMAXIMO_CORREO_ADMIN_USER', 'admin'));
    $adminPass = (string) iqmaximo_config('IQMAXIMO_CORREO_ADMIN_PASS', '');
    if ($adminPass === '') {
        return;
    }

    $record = array(
        'id' => uniqid('user_', true),
        'username' => $adminUser,
        'email' => MAIL_WEBMASTER,
        'assigned_email' => MAIL_WEBMASTER,
        'password' => password_hash($adminPass, PASSWORD_DEFAULT),
        'role' => 'admin',
        'active' => true,
    );
    correo_upsert_user_record($record);
}

function correo_find_user($username)
{
    correo_db_ready();
    $link = ConectarBD();
    $username = correo_db_escape($username);
    $sql = "SELECT id, username, email, assigned_email, password, role, active
            FROM correo_users
            WHERE LOWER(username)=LOWER('$username')
            LIMIT 1";
    $result = mysqli_query($link, $sql);
    if ($result && ($row = mysqli_fetch_assoc($result))) {
        return correo_user_row_to_array($row);
    }
    return null;
}

function correo_public_user($user)
{
    return array(
        'id' => $user['id'] ?? '',
        'username' => $user['username'] ?? '',
        'email' => $user['email'] ?? '',
        'assigned_email' => $user['assigned_email'] ?? ($user['email'] ?? ''),
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
    $sqlUserLegacy = "ALTER TABLE correo_users ADD UNIQUE KEY uniq_username (username)";
    $sqlUserLegacy2 = "ALTER TABLE correo_users ADD UNIQUE KEY uniq_email (email)";
    mysqli_query($link, $sqlMessages);
    mysqli_query($link, $sqlEvents);
    mysqli_query($link, $sqlUsers);
    @mysqli_query($link, $sqlUserLegacy);
    @mysqli_query($link, $sqlUserLegacy2);
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

function correo_resend_list_all($endpoint)
{
    $path = $endpoint . (strpos($endpoint, '?') === false ? '?' : '&') . 'limit=100';
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

    return array('ok' => true, 'items' => $items);
}

function correo_import_history_for_email($email)
{
    $email = correo_norm_email($email);
    if ($email === '') {
        return array('ok' => false, 'error' => 'Email vacio.');
    }

    $imported = 0;
    $updates = 0;

    foreach (array('/emails', '/emails/received') as $endpoint) {
        $result = correo_resend_list_all($endpoint);
        if (empty($result['ok'])) {
            return $result;
        }

        foreach (($result['items'] ?? array()) as $item) {
            $from = correo_norm_email($item['from'] ?? '');
            $to = correo_norm_email(is_array($item['to'] ?? null) ? implode(', ', $item['to']) : ($item['to'] ?? ''));
            if ($from !== $email && strpos($to, $email) === false) {
                continue;
            }

            $direction = $endpoint === '/emails/received' ? 'received' : 'sent';
            $resendId = $item['id'] ?? '';
            $existingUpdated = false;
            if ($resendId !== '') {
                $existingUpdated = correo_db_update_message_status($resendId, $direction, 'import');
            }
            if (!$existingUpdated) {
                correo_db_insert_message(array(
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
                    'payload_json' => json_encode($item, JSON_UNESCAPED_UNICODE),
                ));
                $imported++;
            } else {
                $updates++;
            }
        }
    }

    return array('ok' => true, 'imported' => $imported, 'updated' => $updates);
}
