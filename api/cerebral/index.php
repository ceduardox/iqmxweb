<?php
require_once("../../require/util.php");
require_once("../../require/transacciones.php");

function prettyPrintJSON($data, $statusCode = 200)
{
    header('Content-Type: application/json');
    http_response_code($statusCode);

    if (isset($data['sql'])) {
        // Remove unwanted characters and extra consecutive spaces from the "sql" field
        $data['sql'] = preg_replace('/\s+/', ' ', $data['sql']);
    }

    echo json_encode($data);
}

function calculatePercentFromNumber($number, $total) {
    $percent = ($number / $total) *100;
    return round($percent);
}
  
function save()
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

    $left = isset($_POST['left']) ? (int) $_POST['left'] : 0;
    $right = isset($_POST['right']) ? (int) $_POST['right'] : 0;

    if ($left == 0 or $right == 0) {
        prettyPrintJSON(["message" => "Debes completar los valores para el cálculo"], 500);
    } else {
        $comment = 'El lado derecho de tu cerebro es más dominante.';
        if ($left > $right) {
            $comment = 'El lado izquierdo de tu cerebro es más dominante.';
        } else if ($left == $right) {
            $comment = 'Ambos lados de tu cerebro son igualmente dominantes.';
        }

        $total = $left+$right;

        $PATH_IMAG = 'https://iqmaximo.com/cerebral/img/';
        //TO USUARIO
        $userMessage = 'Hola ' . $nombreTest . ', <br/><br/>';
        $userMessage .= 'Hemos verificado tus respuestas y éste es el resultado de tu Test: <br/><br/>';
        $userMessage .= '<b>REALIZADO EN: </b>APP<br/>';
        $userMessage .= '<b>HEMISFERIO IZQUIERDO: </b>' . calculatePercentFromNumber($left, $total) . '%<br/>';
        $userMessage .= '<b>HEMISFERIO DERECHO: </b>' . calculatePercentFromNumber($right, $total) . '%<br/>';
        $userMessage .= '<b>RESULTADO: </b>' . $comment . '<br/><br/>';
        $userMessage .= '<div class="explaination test" id="explaination">';
        $userMessage .= ' <div class="row">';
        $userMessage .= ' <div class="col-md-10 col-md-offset-1 text-left mtop50">';
        $userMessage .= '      <span class="headexplain">Pregunta 1:</span>';
        $userMessage .= '      <span class="headtitle">bailarina</span>';
        $userMessage .= '    </div>  </div>';
        $userMessage .= '  <div class="row text-left mtop20">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'taenzerin.gif"/>';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '      Según funcione su cerebro, la bailarina girará hacia la izquierda o hacia la derecha. Si gira hacia la derecha, significa que utiliza predominantemente el lado derecho de su cerebro; además, tiene más posibilidades de ser diestro.';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row">';
        $userMessage .= '    <div class="col-md-10 col-md-offset-1 text-left mtop20">';
        $userMessage .= '      <span class="headexplain">Pregunta 2: </span>';
        $userMessage .= '      <span class="headtitle">Test de color</span>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'explain_farben.png"/>';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '     Conflicto:El lado derecho del cerebro quiere elegir el color que concuerda con la palabra, mientras que el izquierdo quiere elegir la palabra escrita. Si comete un error, es debido a la acción del lado izquierdo del cerebro.';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row">';
        $userMessage .= '    <div class="col-md-10 col-md-offset-1 text-left mtop20">';
        $userMessage .= '      <span class="headexplain">Pregunta 3: </span>';
        $userMessage .= '      <span class="headtitle">dibujo</span>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'figur01.png">';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '      <h5>Respuesta A:</h5>';
        $userMessage .= '      <p>';
        $userMessage .= '        Si ha elegido este dibujo, el lado izquierdo de su cerebro es más dominante. Esto es debido a que el círculo tiene una forma simple y reconocible que es más fácil de definir.';
        $userMessage .= '      </p>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'figur02.png">';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '      <h5>Respuesta B:</h5>';
        $userMessage .= '      <p>';
        $userMessage .= '        Esta forma es un punto intermedio entre la simplicidad del primer dibujo y la complejidad de la respuesta C. La figura es más compleja y fascinante, aunque autónoma. Por tanto, es elegida mayoritariamente por gente cuyas mitades cerebrales dominan por igual.';
        $userMessage .= '      </p>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'figur03.png">';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '     <h5>Respuesta C:</h5>';
        $userMessage .= '      <p>';
        $userMessage .= '        Si ha elegido este dibujo, el lado derecho de su cerebro es más dominante. La figura aparece incompleta, sin forma o dirección. Ofrece la posibilidad de desarrollo.';
        $userMessage .= '      </p>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div><div class="row">';
        $userMessage .= '    <div class="col-md-10 col-md-offset-1 text-left mtop20">';
        $userMessage .= '      <span class="headexplain">Pregunta 4:</span>';
        $userMessage .= '      <span class="headtitle">Parecido a</span>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'passen01.png">';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '      <h5>Respuesta A:</h5>';
        $userMessage .= '      <p>';
        $userMessage .= '        Aquí, las figuras también son iguales en tamaño. Sin embargo, difieren ampliamente en color. El factor visual es el resultado de la dominancia del lado izquierdo del cerebro.';
        $userMessage .= '      </p>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'passen02.png">';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '      <h5>Respuesta B:</h5>';
        $userMessage .= '      <p>';
        $userMessage .= '        Las figuras son iguales en tamaño y relativamente iguales en color. Si ha elegido la respuesta A, el lado derecho de su cerebro es más dominante.';
        $userMessage .= '      </p>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'passen03.png">';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '      <h5>Respuesta C:</h5>';
        $userMessage .= '      <p>';
        $userMessage .= '        Aquí, el dibujo original estaba fragmentado. Si ha elegido esta respuesta, el lado derecho de su cerebro es más dominante.';
        $userMessage .= '      </p>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row">';
        $userMessage .= '    <div class="col-md-10 col-md-offset-1 text-left mtop20">';
        $userMessage .= '      <span class="headexplain">Pregunta 5:</span>';
        $userMessage .= '      <span class="headtitle">amistad</span>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'freundschaft01.png">';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '      <h5>Respuesta A:</h5>';
        $userMessage .= '      <p>';
        $userMessage .= '        Los círculos en esta figura están agrupados holgadamente, aunque no de manera completamente desestructurada. Si ha elegido esta respuesta, ningún lado de su cerebro domina con claridad.';
        $userMessage .= '      </p>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'freundschaft02.png">';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '      <h5>Respuesta B:</h5>';
        $userMessage .= '      <p>        La disposición de los círculos en esta imagen es la que se espera típicamente de un circulo de amigos. Este factor visual es el resultado de la dominancia del lado izquierdo del cerebro.';
        $userMessage .= '      </p>';
        $userMessage .= '    </div>';
        $userMessage .= '  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="'.$PATH_IMAG.'freundschaft03.png">';
        $userMessage .= '    <div class="col-md-7">';
        $userMessage .= '      <h5>Respuesta C:</h5>';
        $userMessage .= '      <p>        En esta imagen, los círculos están igualmente distantes entre sí. La respuesta C es elegida con más frecuencia por aquellos cuya parte derecha del cerebro es dominante.      </p>   </div>  </div>';
        $userMessage .= '  <div class="row">';
        $userMessage .= '    <div class="col-md-10 col-md-offset-1 text-left mtop20">';
        $userMessage .= '      <span class="headexplain">Preguntas 6, 7 y 8:</span>    </div>  </div>';
        $userMessage .= '  <div class="row text-left mtop10">';
        $userMessage .= '    <div class="col-md-10 col-md-offset-1">';
        $userMessage .= '      <p>Si el lado derecho es dominante, utilizará la mano izquierda, la pierna izquierda o el ojo izquierdo.</p>';
        $userMessage .= '      <p>Si el lado izquierdo es dominante, utilizará la mano derecha, la pierna derecha o el ojo derecho. En estos casos, el lado derecho del cuerpo es controlado por el lado izquierdo del cerebro, y viceversa.</p>    </div>  </div>';
        //fin
    
        //TO CTEX
        $systemMessage = 'Hola, <br/><br/>';
        $systemMessage .= 'Han realizado un Test: <br/><br/>';
        $systemMessage .= '<b>REALIZADO EN: </b>APP<br/>';
        $systemMessage .= '<b>TEST: </b>CEREBRAL<br/>';
        $systemMessage .= '<b>NOMBRE Y APELLIDO: </b>' . $nombreTest . '<br/>';
        $systemMessage .= '<b>EDAD: </b>' . $edadTest . '<br/>';
        $systemMessage .= '<b>EMAIL: </b>' . $emailTest . '<br/>';
        $systemMessage .= '<b>TELÉFONO: </b>' . $fonoTest . '<br/>';
        $systemMessage .= '<b>CIUDAD: </b>' . $ciudadTest . '<br/>';

        if ($comentarioTest != "") {
            $systemMessage .= '<b>SU COMENTARIO ES: </b>' . nl2br($comentarioTest) . '<br/>';
        }

        $systemMessage .= '<b>HEMISFERIO IZQUIERDO: </b>' . calculatePercentFromNumber($left, $total) . '%<br/>';
        $systemMessage .= '<b>HEMISFERIO DERECHO: </b>' . calculatePercentFromNumber($right, $total) . '%<br/>';

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
                'rescat' => 'GRAL',
                'reslect' => 'TEST CEREBRAL',
                'rescant' => '0',
                'restime' => '0',
                'restmres' => 'izquierda: ' . $left . ' ('.calculatePercentFromNumber($left, $total).'%) - derecha: ' . $right.' ('.calculatePercentFromNumber($right, $total).'%)',
                'rescomp' => '0',
                'resvel' => '0',
                'restipo' => $tipoTestForm,
                'rescom' => $comentarioTest,
                'ressoy' => $soyTest,
                'rescarrera' => $carreraTest,
                'ressemestre' => $semestreTest,
                'resinstitucion' => $institucionTest,
            )
        );

        if ($rst) {
            prettyPrintJSON([
                "message" => "Data saved successfully",
                "result" => [
                    "id" => $rst,
                    "left" => $left,
                    "right" => $right,
                    "comment" => $comment,
                ]
            ], 201);

            $userDetail = array();
            $userDetail['texto'] = $userMessage;
            $userDetail['contacto'] = TRUE;
            $userDetail['tipo'] = 'TEST';
            enviaMail($emailTest, 'Resultado de Test - Cerebral', $userDetail);

            $systemDetail = array();
            $systemDetail['texto'] = $systemMessage;
            $systemDetail['contacto'] = FALSE;
            $systemDetail['tipo'] = 'TEST';
            enviaMailAdmin(MAIL_INFO, 'Resultado de Test - Cerebral', $systemDetail);
        } else {
            prettyPrintJSON(["message" => "Error saving data"], 500);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'save':
                save();
                break;
            default:
                prettyPrintJSON(["message" => "Endpoint not found"], 404);
                break;
        }
    } else {
        prettyPrintJSON(["message" => "Action " . $_POST['action'] . " not specified"], 400);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    prettyPrintJSON(["message" => "Method not allowed"], 405);
    exit;
}
?>