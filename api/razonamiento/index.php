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

$clssTest = new ClssTest();

function listarLectura($clssTest) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
    $subcategoria = isset($_GET['subcategoria']) ? $_GET['subcategoria'] : '';

    $result = $clssTest->listarLectura($cod, $categoria, $subcategoria, 9999);
    prettyPrintJSON($result);
}

function listarSubCategoria($clssTest) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

    if(!$categoria) {
        prettyPrintJSON(["message" => "Missing parameter: categoria"],400);
        exit;
    }

    if(!is_numeric($categoria)) {
      prettyPrintJSON(["message" => "Wrong format for parameter: categoria"],400);
      exit;
    }

    $result = $clssTest->listarSubCategoria($cod, $categoria);
    prettyPrintJSON($result);
}

function listarCategoria($clssTest) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';

    $result = $clssTest->listarCategoria($cod, $slug);
    prettyPrintJSON($result);
}

function listarPregunta($clssTest) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $lectura = isset($_GET['lectura']) ? $_GET['lectura'] : '';

    if(!$lectura) {
      prettyPrintJSON(["message" => "Missing parameter: lectura"],400);
      exit;
    }

    if(!is_numeric($lectura)) {
      prettyPrintJSON(["message" => "Wrong format for parameter: lectura"],400);
      exit;
    }

    $result = $clssTest->listarPregunta($cod, $lectura);
    prettyPrintJSON($result);
}

function listarAlternativas($clssTest) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $pregunta = isset($_GET['pregunta']) ? $_GET['pregunta'] : '';
 
    if(!$pregunta) {
      prettyPrintJSON(["message" => "Missing parameter: pregunta"],400);
      exit;
    }

    if(!is_numeric($pregunta)) {
      prettyPrintJSON(["message" => "Wrong format for parameter: pregunta"],400);
      exit;
    }

    $result = $clssTest->listarAlternativas($cod, $pregunta);
    prettyPrintJSON($result);
}


function listarPreguntasConAlternativas($clssTest) {
    $cod = isset($_GET['cod']) ? $_GET['cod'] : '';
    $lectura = isset($_GET['lectura']) ? $_GET['lectura'] : '';

    if (!$lectura) {
        prettyPrintJSON(["message" => "Missing parameter: lectura"], 400);
        exit;
    }

    if (!is_numeric($lectura)) {
        prettyPrintJSON(["message" => "Wrong format for parameter: lectura"], 400);
        exit;
    }

    $preguntas = $clssTest->listarPregunta($cod, $lectura);

    if($preguntas['total'] === 0) {
        prettyPrintJSON(["message" => "No questions found"],404);
        exit;
    }

    // Iterate through the list of questions and get their alternatives
    $preguntasConAlternativas = [];
    foreach ($preguntas['result'] as $pregunta) {
        $preguntaId = $pregunta['id'];
        $alternativas = $clssTest->listarAlternativas('', $preguntaId);

        // Add alternatives to the question data
        $pregunta['alternativas'] = $alternativas['result'];

        // Append the modified question data to the result array
        $preguntasConAlternativas[] = $pregunta;
    }

    // Return the result array with questions and their alternatives
    prettyPrintJSON($preguntasConAlternativas);
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

    $nomLecturaForm = isset($_POST['nomLecturaForm']) ? $_POST['nomLecturaForm'] : '';
    $tipoPersonaForm = isset($_POST['tipoPersonaForm']) ? $_POST['tipoPersonaForm'] : '';
    $tiempoRespuestasForm = isset($_POST['tiempoRespuestasForm']) ? $_POST['tiempoRespuestasForm'] : '';

    $tipoTestForm = isset($_POST['tipoTestForm']) ? $_POST['tipoTestForm'] : 'RAZONA';

    $respuestasOkForm = isset($_POST['respuestasOkForm']) ? $_POST['respuestasOkForm'] : '';
    $rsptasOk = explode(",", $respuestasOkForm);

    $respuestasForm = isset($_POST['respuestasForm']) ? $_POST['respuestasForm'] : '';
    $rsptas = explode(",", $respuestasForm);

    $i = 0;
    $ok = 0;
    $ko = 0;

    $cta_rsptasOk = 100 / count($rsptasOk);

    foreach ($rsptasOk as $rsptaOk) {
        ($rsptaOk == $rsptas[$i]) ? $ok++ : $ko++;
        $i++;
    }

    $porcentajeComprension = $cta_rsptasOk * $ok;
    
    //TO USUARIO
    $userMessage = 'Hola ' . $nombreTest . ', <br/><br/>';
    $userMessage .= 'Hemos verificado tus respuestas y éste es el resultado de tu Test: <br/><br/>';
    $userMessage .= '<b>REALIZADO EN: </b>APP<br/>';
    $userMessage .= '<b>IDENTIFICADO COMO: </b>' . $tipoPersonaForm . '<br/>';
    $userMessage .= '<b>TEST: </b><u>' . $nomLecturaForm . '</u><br/>';
    $userMessage .= '<b>TU RAZONAMIENTO ES DEL: </b>' . $porcentajeComprension . '%<br/>';

    if ($comentarioTest != "") {
        $userMessage .= '<b>TU COMENTARIO ES: </b>' . nl2br($comentarioTest) . '<br/>';
    }

    //TO CTEX
    $systemMessage = 'Hola, <br/><br/>';
    $systemMessage .= 'Han realizado un Test: <br/><br/>';
    $systemMessage .= '<b>REALIZADO EN: </b>APP<br/>';
    $systemMessage .= '<b>NOMBRE Y APELLIDO: </b>' . $nombreTest . '<br/>';
    $systemMessage .= '<b>EDAD: </b>' . $edadTest . '<br/>';
    $systemMessage .= '<b>EMAIL: </b>' . $emailTest . '<br/>';
    $systemMessage .= '<b>TELÉFONO: </b>' . $fonoTest . '<br/>';
    $systemMessage .= '<b>CIUDAD: </b>' . $ciudadTest . '<br/>';
    $systemMessage .= '<b>IDENTIFICADO COMO: </b>' . $tipoPersonaForm . '<br/>';
    $systemMessage .= '<b>TEST: </b><u>' . $nomLecturaForm . '</u><br/>';
    $systemMessage .= '<b>TIEMPO DE RESPUESTA DEL CUESTIONARIO: </b>' . $tiempoRespuestasForm . '<br/>';
    $systemMessage .= '<b>SU RAZONAMIENTO ES DEL: </b>' . $porcentajeComprension . '%<br/>';

    if ($comentarioTest != "") {
        $systemMessage .= '<b>SU COMENTARIO ES: </b>' . nl2br($comentarioTest) . '<br/>';
    }

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
            'rescat' => $tipoPersonaForm,
            'restipo' => $tipoTestForm,
            'restmres' => $tiempoRespuestasForm,
            'rescomp' => $porcentajeComprension,
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
                            "tiempoRespuesta" => $tiempoRespuestasForm,
                            "comprension" => $porcentajeComprension,
                        ]], 201);
                        
        $userDetail = array();
        $userDetail['texto'] = $userMessage;
        $userDetail['contacto'] = TRUE;
        $userDetail['tipo'] = 'TEST';
        enviaMail($emailTest, 'Resultado de Test - Razonamiento', $userDetail);

        $systemDetail = array();
        $systemDetail['texto'] = $systemMessage;
        $systemDetail['contacto'] = FALSE;
        $systemDetail['tipo'] = 'TEST';
        enviaMailAdmin(MAIL_INFO, 'Resultado de Test - Razonamiento', $systemDetail);
    } else {
        prettyPrintJSON(["message" => "Error saving data"], 500);
    }

}

// Main routing logic
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'listarLectura':
                listarLectura($clssTest);
                break;
            case 'listarSubCategoria':
                listarSubCategoria($clssTest);
                break;
            case 'listarCategoria':
                listarCategoria($clssTest);
                break;
            case 'listarPregunta':
                listarPregunta($clssTest);
                break;
            case 'listarAlternativas':
                listarAlternativas($clssTest);
                break;
            case 'listarPreguntasConAlternativas':
                listarPreguntasConAlternativas($clssTest);
                break;
            default:
                prettyPrintJSON(["message" => "Endpoint not found"],404);
                break;
        }
    } else {
        prettyPrintJSON(["message" => "Action not specified"],400);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'save':
                save($clssTest);
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