<?php
require_once("../../require/util.php");
require_once("../../require/transacciones.php");

function prettyPrintJSON($data, $statusCode = 200) {
  header('Content-Type: application/json');
  http_response_code($statusCode);    
  
  if(isset($data['sql'])) {
    // Remove unwanted characters and extra consecutive spaces from the "sql" field
    $data['sql'] = preg_replace('/\s+/', ' ', $data['sql']);
  }

  echo json_encode($data);
}

$clssTest = new ClssContacto();

function listar($clssTest) {
    $result = $clssTest->lista();
    prettyPrintJSON($result);
}

// Main routing logic
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'listar':
                listar($clssTest);
                break;
            default:
                prettyPrintJSON(["message" => "Endpoint not found"],404);
                break;
        }
    } else {
        prettyPrintJSON(["message" => "Action not specified"],400);
    }
} else {
    prettyPrintJSON(["message" => "Method not allowed"],405);
}
?>