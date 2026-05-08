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

$clssTestiQ = new ClssTestiQ();

function listarTipo($clssTestiQ) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';

    $result = $clssTestiQ->tipo($cod, $slug);
    prettyPrintJSON($result);
}

function listarSerieTipo($clssTestiQ) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';

    $result = $clssTestiQ->serieTipo($cod);
    prettyPrintJSON($result);
}

function listarSerie($clssTestiQ) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

    $result = $clssTestiQ->serie($cod, $tipo);
    prettyPrintJSON($result);
}

function listarPregunta($clssTestiQ) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $serie = isset($_GET['serie']) ? $_GET['serie'] : '';

    if(!$serie) {
        prettyPrintJSON(["message" => "Missing parameter: serie"],400);
        exit;
    }

    $result = $clssTestiQ->pregunta($cod, $serie);
    prettyPrintJSON($result);
}

function listarAlternativa($clssTestiQ) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $pregunta = isset($_GET['pregunta']) ? $_GET['pregunta'] : '';

    if(!$pregunta) {
        prettyPrintJSON(["message" => "Missing parameter: pregunta"],400);
        exit;
    }

    $result = $clssTestiQ->alternativa($cod, $pregunta);
    prettyPrintJSON($result);
}

function getEdad($clssTestiQ) {
    $edad = isset($_GET['edad']) ? $_GET['edad'] : '';

    if(!is_numeric($edad)) {
        prettyPrintJSON(["message" => "Wrong format for parameter: edad"],400);
        exit;
    }

    $result = $clssTestiQ->getEdad($edad);
    prettyPrintJSON($result);
}

function listarSerieConPreguntasAlternativas($clssTestiQ) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

    $serieData = $clssTestiQ->serie($cod, $tipo);

    if (!$serieData['result']) {
        prettyPrintJSON(["message" => "Serie not found"], 404);
        exit;
    }

    // Extract the series data from $serieData
    $series = $serieData['result'];

    // Initialize an array to store results for all series
    $allSeriesResults = [];

    // Loop through each series
    foreach ($series as $serie) {
        $serieId = $serie['id'];
        $serieName = $serie['nombre'];
        
        $resultsForSerie = listarPreguntasConAlternativas($clssTestiQ, $serieId, '');

        $serieWithQuestions = [
            "id" => $serieId,
            "nombre" => $serieName,
            "preguntas" => $resultsForSerie
        ];

        // Append the results for this series to the overall results array
        $allSeriesResults[] = $serieWithQuestions;
    }

    // Return the combined results for all series
    prettyPrintJSON($allSeriesResults);
}

// Function for listing questions with alternatives based on provided serie and cod
function listarPreguntasConAlternativas($clssTestiQ, $serie, $cod) {
    if (!$serie) {
        prettyPrintJSON(["message" => "Missing parameter: serie"], 400);
        exit;
    }

    if (!is_numeric($serie)) {
        prettyPrintJSON(["message" => "Wrong format for parameter: serie"], 400);
        exit;
    }

    $preguntas = $clssTestiQ->pregunta($cod, $serie);

    if ($preguntas['total'] === 0) {
        prettyPrintJSON(["message" => "No questions found"], 404);
        exit;
    }

    // Iterate through the list of questions and get their alternatives
    $preguntasConAlternativas = [];
    foreach ($preguntas['result'] as $pregunta) {
        $preguntaId = $pregunta['id'];
        $alternativas = $clssTestiQ->alternativa('', $preguntaId);

        // Add alternatives to the question data
        $pregunta['alternativas'] = $alternativas['result'];

        // Append the modified question data to the result array
        $preguntasConAlternativas[] = $pregunta;
    }

    // Return the result array with questions and their alternatives for this series
    return $preguntasConAlternativas;
}

// Main routing logic
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'listarTipo':
                listarTipo($clssTestiQ);
                break;
            case 'listarSerieTipo':
                listarSerieTipo($clssTestiQ);
                break;
            case 'listarSerie':
                listarSerie($clssTestiQ);
                break;
            case 'listarPregunta':
                listarPregunta($clssTestiQ);
                break;
            case 'listarAlternativa':
                listarAlternativa($clssTestiQ);
                break;
            case 'getEdad':
                getEdad($clssTestiQ);
                break;
            case 'listarSerieConPreguntasAlternativas':
                listarSerieConPreguntasAlternativas($clssTestiQ);
                break;
            default:
                prettyPrintJSON(["message" => "Endpoint not found"],404);
                break;
        }
    } else {
        prettyPrintJSON(["message" => "Action not specified"],400);
    }
}

function save($clssTest)
{
    $deviceFrom = isset($_POST['deviceFrom']) ? $_POST['deviceFrom'] : 'web';
    $deviceInfo = isset($_POST['deviceInfo']) ? $_POST['deviceInfo'] : '';

    $nombreTest = isset($_POST['nombreTest']) ? $_POST['nombreTest'] : '';
    $edadTest = isset($_POST['edadTest']) ? $_POST['edadTest'] : '';
    $ciudadTest = isset($_POST['ciudadTest']) ? $_POST['ciudadTest'] : '';
    $emailTest = isset($_POST['emailTest']) ? $_POST['emailTest'] : '';
    $fonoTest = isset($_POST['fonoTest']) ? $_POST['fonoTest'] : '';
    $comentarioTest = isset($_POST['comentarioTest']) ? $_POST['comentarioTest'] : '';

    $soyTest = isset($_POST['soyTest']) ? $_POST['soyTest'] : '';
    $semestreTest = isset($_POST['semestreTest']) ? $_POST['semestreTest'] : '';
    $carreraTest = isset($_POST['carreraTest']) ? $_POST['carreraTest'] : '';
    $institucionTest = isset($_POST['institucionTest']) ? $_POST['institucionTest'] : '';

    $tipoTestForm = isset($_POST['tipoTestForm']) ? $_POST['tipoTestForm'] : '';
    $tipoIdTestForm = isset($_POST['tipoIdTestForm']) ? $_POST['tipoIdTestForm'] : '';
    $tipoNameTestForm = isset($_POST['tipoNameTestForm']) ? $_POST['tipoNameTestForm'] : '';

    $correctas = isset($_POST['correctas']) ? $_POST['correctas'] : '';
    $incorrectas = isset($_POST['incorrectas']) ? $_POST['incorrectas'] : '';

    // cast edad to number
    $edad = (int)$edadTest;

    /* calculo */
    $datosPercentil = $clssTest->getPercentil($edad, $correctas, $incorrectas, $tipoIdTestForm);
    $datoPercentil = $datosPercentil['result'][0];
    $percentil = ($datoPercentil['valor'] != "") ? $datoPercentil['valor'] : 0;
    $detalle = ($datoPercentil['detalle'] != "") ? $datoPercentil['detalle'] : 'no se pudo calcular';

    $userMessage = 'Hola ' . $nombreTest . ', <br/><br/>';
    $userMessage .= 'Hemos verificado tus respuestas y éste es el resultado de tu Test: <br/><br/>';
    $userMessage .= '<b>REALIZADO EN: </b>APP<br/>';
    $userMessage .= "<b>RESPUESTAS CORRECTAS:</b> " . $correctas . " de " . $incorrectas . "<br/>";
    $userMessage .= "<b>PERCENTIL:</b> " . $percentil . "<br/>";
    $userMessage .= "<b>COCIENTE INTELECTUAL:</b> " . $detalle . "<br/>";
    if ($comentarioTest != "") {
        $userMessage .= '<b>TU COMENTARIO ES: </b>' . nl2br($comentarioTest) . '<br/>';
    }
    
    //TO CTEX
    $systemMessage = 'Hola, <br/><br/>';
    $systemMessage .= 'Han realizado un Test: <br/><br/>';
    $systemMessage .= '<b>REALIZADO EN: </b>APP<br/>';
    $systemMessage .= '<b>NOMBRE Y APELLIDO: </b>' . $nombreTest . '<br/>';
    $systemMessage .= '<b>EMAIL: </b>' . $emailTest . '<br/>';
    $systemMessage .= '<b>EDAD: </b>' . $edadTest . '<br/>';
    $systemMessage .= '<b>TELÉFONO: </b>' . $fonoTest . '<br/>';
    $systemMessage .= '<b>CIUDAD: </b>' . $ciudadTest . '<br/>';
    $systemMessage .= "<b>RESPUESTAS CORRECTAS:</b> " . $correctas . " DE " . $incorrectas . "<br/>";
    $systemMessage .= "<b>PERCENTIL:</b> " . $percentil . "<br/>";
    $systemMessage .= "<b>COCIENTE INTELECTUAL:</b> " . $detalle . "<br/>";

    // Save the data
    $rst = insertData(
        'resultado',
        array(
            'deviceFrom' => $deviceFrom,
            'deviceInfo' => print_r($deviceInfo, true),
            'resnom' => $nombreTest,
            'edad' => $edadTest,
            'resmail' => $emailTest,
            'restele' => $fonoTest,
            'resciud' => $ciudadTest,
            'respais' => 'BOLIVIA',
            'rescat' => $tipoNameTestForm,
            'restipo' => $tipoTestForm,
            'rescom' => $comentarioTest,
            'ressoy' => $soyTest,
            'rescarrera' => $carreraTest,
            'ressemestre' => $semestreTest,
            'resinstitucion' => $institucionTest,
        )
    ); 

    if ($rst) {
        prettyPrintJSON(["message" => "Data saved successfully", 
                         "result" => [
                            "id" => $rst,
                            "percentil" => $percentil,
                            "cociente" => $detalle,
                            "correctas" => $correctas,
                            "incorrectas" => $incorrectas,
                        ]], 201);

        $userDetail = array();
        $userDetail['texto'] = $userMessage;
        $userDetail['contacto'] = TRUE;
        $userDetail['tipo'] = 'TEST';
        enviaMail($emailTest, 'Resultado de Test - iQ', $userDetail);
        
        $systemDetail = array();
        $systemDetail['texto'] = $systemMessage;
        $systemDetail['contacto'] = FALSE;
        $systemDetail['tipo'] = 'TEST';
        enviaMailAdmin(MAIL_INFO, 'Resultado de Test - iQ', $systemDetail);
    } else {
        prettyPrintJSON(["message" => "Error saving data"], 500);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'save':
                save($clssTestiQ);
                break;
            default:
                prettyPrintJSON(["message" => "Endpoint not found"], 404);
                break;
        }
    } else {
        prettyPrintJSON(["message" => "Action ".$_POST['action']." not specified"], 400);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    prettyPrintJSON(["message" => "Method not allowed"], 405);
    exit;
}
?>