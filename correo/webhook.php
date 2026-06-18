<?php
require_once __DIR__ . '/lib.php';

header('Content-Type: application/json; charset=utf-8');

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);
if (!is_array($payload)) {
    http_response_code(400);
    echo json_encode(array('ok' => false, 'error' => 'Payload invalido'), JSON_UNESCAPED_UNICODE);
    exit;
}

if (!correo_webhook_secret_matches()) {
    http_response_code(401);
    echo json_encode(array('ok' => false, 'error' => 'Webhook no autorizado'), JSON_UNESCAPED_UNICODE);
    exit;
}

$eventType = $payload['type'] ?? ($payload['event'] ?? '');
$data = $payload['data'] ?? $payload;
$resendId = $data['id'] ?? ($data['email_id'] ?? ($data['message_id'] ?? ''));
$from = $data['from'] ?? ($data['source'] ?? '');
$to = $data['to'] ?? ($data['recipient'] ?? '');
$subject = $data['subject'] ?? '';
$html = $data['html'] ?? '';
$text = $data['text'] ?? '';
$statusMap = array(
    'email.sent' => 'sent',
    'email.delivered' => 'delivered',
    'email.bounced' => 'bounced',
    'email.complained' => 'complained',
    'email.received' => 'received',
);
$status = $statusMap[$eventType] ?? 'stored';

correo_db_insert_event(array(
    'event_type' => (string) $eventType,
    'resend_id' => (string) $resendId,
    'payload_json' => $raw,
));

if ($eventType === 'email.received' || $status === 'received') {
    $source = array(
        'id' => (string) $resendId,
        'message_id' => (string) ($data['message_id'] ?? $resendId),
        'from' => is_array($from) ? json_encode($from) : (string) $from,
        'to' => is_array($to) ? $to : (string) $to,
        'subject' => (string) $subject,
        'html' => (string) $html,
        'text' => (string) $text,
        'event_type' => (string) $eventType,
    );
    $detail = correo_resend_get_received_email((string) $resendId);
    if (!empty($detail['ok'])) {
        $detailItem = $detail['item'] ?? array();
        if (is_array($detailItem) && !empty($detailItem)) {
            $source = array_merge($source, $detailItem);
        }
    }
    correo_store_received_message($source, array(
        'id' => (string) $resendId,
        'message_id' => (string) $resendId,
        'from' => is_array($from) ? json_encode($from) : (string) $from,
        'to' => is_array($to) ? $to : (string) $to,
        'subject' => (string) $subject,
        'html' => (string) $html,
        'text' => (string) $text,
        'event_type' => (string) $eventType,
    ));
} else {
    if ($resendId !== '') {
        correo_db_update_message_status((string) $resendId, $status, (string) $eventType);
    }
}

echo json_encode(array('ok' => true), JSON_UNESCAPED_UNICODE);
