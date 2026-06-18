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
