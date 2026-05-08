<?php
require_once ("../../require/util.php");
require_once ("../../require/transacciones.php");

function prettyPrintJSON($data, $statusCode = 200)
{
	header('Content-Type: application/json');
	http_response_code($statusCode);

	echo json_encode($data);
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$json = file_get_contents('php://input');
	$data = json_decode($json, true);

	if (isset($_GET['action'])) {
		switch ($_GET['action']) {
			case 'send':
				send($data);
				break;
			case 'create':
				create($data);
				break;
			default:
				prettyPrintJSON(["message" => "Endpoint not found"], 404);
				break;
		}
	} else {
		prettyPrintJSON(["message" => "Action not specified"], 400);
	}
} else {
	prettyPrintJSON(["message" => "Invalid request method"], 405);
}

function create($data)
{
	if (!isset($data['token'])) {
		prettyPrintJSON(["message" => "Missing required parameters"], 400);
	}

	$clssPushNotification = new ClssPushNotification();
	$token = trim($data['token']);
	$deviceInfo = json_encode($data['deviceInfo']);

	$result = $clssPushNotification->create($token, $deviceInfo);
	if ($result) {
		prettyPrintJSON(["message" => "Token created"], 201);
	} else {
		prettyPrintJSON(["message" => "Failed to create token"], 500);
	}
}

function send($data)
{
	try {
		if (
			!isset($data['title']) ||
			!isset($data['message']) ||
			!isset($data['deepLink'])
		) {
			prettyPrintJSON(["message" => "Missing required parameters"], 400);
		}

		$clssPushNotification = new ClssPushNotification();

		$tokensList = $clssPushNotification->lista();
		if ($tokensList['total'] === 0) {
			prettyPrintJSON(["message" => "No tokens found"], 404);
		}
		$tokensData = $tokensList['result'];
		$tokensArr = array_column($tokensData, 'token');
		$tokens = array_filter($tokensArr);

		$messageId = $data['messageId'];
		if (!isset($messageId)) {
			$title = trim($data['title']);
			$message = trim($data['message']);
			$deepLink = trim($data['deepLink']);
		} else {
			$messageData = $clssPushNotification->getMessage($messageId);
			if ($messageData === false || $messageData['total'] === 0) {
				prettyPrintJSON(["message" => "Message not found"], 404);
			}

			$title = $messageData['title'];
			$message = $messageData['message'];
			$deepLink = $messageData['deepLink'];
		}

		$url = 'https://exp.host/--/api/v2/push/send';

		$notifications = [];
		foreach ($tokens as $token) {
			$notifications[] = [
				'to' => $token,
				'sound' => 'default',
				'title' => $title,
				'body' => $message,
				'data' => ['url' => $deepLink]
			];
		}

		$chunks = array_chunk($notifications, 50);
		$responses = [];
		foreach ($chunks as $chunk) {
			$context = stream_context_create([
				'http' => [
					'method' => 'POST',
					'header' => "Accept: application/json\r\n" .
						"Content-Type: application/json\r\n",
					'content' => json_encode($chunk),
					'ignore_errors' => true
				]
			]);

			$result = file_get_contents($url, false, $context);
			if ($result === FALSE) {
				$error = error_get_last()['message'];
				prettyPrintJSON(["message" => "Failed to connect to Expo API", "error" => $error], 500);
			} else {

				$response = json_decode($result, true);
				$responses[] = $response;

				// Revisar cada respuesta para cada token
				foreach ($response['data'] as $resp) {
					if (isset($resp['status'])) {
						// Si hay un error, eliminar el token de la base de datos
						if ($resp['status'] === 'error') {
							$resp['message'] = str_replace('"', '\"', $resp['message']);

							$issue = json_encode(["message" => $resp['message'], "error" => $resp['details']['error']]);
							$clssPushNotification->deactivate($resp['details']['expoPushToken'], $issue);
						}

						// Si hay un id, enviar a la cola de notificaciones
						if (isset($resp['id']) && isset($messageId)) {
							$clssPushNotification->dispatch($resp['id'], $resp['status'], $messageId);
						}
					}
				}
			}
		}

		prettyPrintJSON(["message" => "Notifications processed", "details" => $responses], 200);
	} catch (Exception $e) {
		prettyPrintJSON(["message" => $e->getMessage()], 500);
	}
}
?>