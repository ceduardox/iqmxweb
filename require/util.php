<?php
extract($_REQUEST);
require_once("configuracion.php");

function encrypt($string, $key)
{
	$result = '';
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) + ord($keychar));
		$result .= $char;
	}
	return base64_encode($result);
}

function decrypt($string, $key)
{
	$result = '';
	$string = base64_decode($string);
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) - ord($keychar));
		$result .= $char;
	}
	return $result;
}

function slugCategoria($categoria)
{
	$slug = array();
	$slug['ADOLESCENTE'] = 'ADO';
	$slug['ADULTO'] = 'ADU';
	$slug['NI&Ntilde;O'] = 'NIN';
	return $slug[htmlentities($categoria)];
}

function getUrlActivo($url)
{
	if (strpos($url, ',') === false) {
		return (PAG_ACTUAL == $url) ? 'activo' : '';
	} else {
		$arrs = explode(",", $url);
		$urlStr = "";

		foreach ($arrs as $arr) {
			$urlStr .= (PAG_ACTUAL == $arr) ? 'activo' : ' ';
		}

		return $urlStr;
	}
}

function getMes($num, $tipo = '')
{
	if ($tipo == "nombre") {
		$alpha = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SETIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	} else {
		$alpha = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
	}
	return $alpha[$num - 1];
}

function imagen($path, $archivo, $ancho = '', $imagenDefault = '', $class = '')
{
	if (!file_exists($path . $archivo)) {
		$src = ($imagenDefault != "") ? $imagenDefault : "img/util/noPerson.jpg";
	} else {
		$src = $path . $archivo;
	}
	$ancho = ($ancho != "") ? $ancho . 'px' : '122px';
	$class = ($class != "") ? $class : '';
	$image = "<img src='" . $src . "' width='" . $ancho . "' class='" . $class . "' />";
	return $image;
}

function limpiaVideo($urlVideo)
{
	$urlVideo = trim($urlVideo);
	$urlVideo = str_replace("https://www.youtube.com/watch?v=", "", $urlVideo);
	$urlVideo = str_replace("http://www.youtube.com/watch?v=", "", $urlVideo);
	$urlVideo = str_replace("//www.youtube.com/watch?v=", "", $urlVideo);
	$urlVideo = str_replace("https://youtu.be/", "", $urlVideo);
	return $urlVideo;
}

function setNumAlternativa($num)
{
	$alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X ', 'Y', 'Z');
	return $alpha[$num - 1];
}

function logger($mensaje)
{
	// Define la ruta al archivo log
	$archivoLog = 'custom.log';  // Asegúrate de tener permisos de escritura en esta ruta

	// Abre el archivo para añadir contenido al final (append)
	$fileHandle = fopen($archivoLog, 'a');

	if ($fileHandle === false) {
		echo "ERROR: No se pudo abrir el archivo log.";
		return;  // Sale de la función si no puede abrir el archivo
	}

	// Construye el mensaje con una estampa de tiempo
	$timestamp = date('Y-m-d H:i:s');
	$logEntry = $timestamp . " - " . $mensaje . "\n";

	// Escribe el mensaje en el archivo log
	fwrite($fileHandle, $logEntry);

	// Cierra el archivo
	fclose($fileHandle);
}


function enviaMail($toEmail, $subject, $msje, $fromEmail = MAIL_WEBMASTER, $file = '')
{
	$mailjetApiKey = iqmaximo_config("IQMAXIMO_MAILJET_API_KEY", "");
	$mailjetSecretKey = iqmaximo_config("IQMAXIMO_MAILJET_SECRET_KEY", "");
	if ($mailjetApiKey == "" || $mailjetSecretKey == "") {
		return array(
			"estado" => FALSE,
			"mensaje" => "Mailjet no esta configurado."
		);
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERPWD, $mailjetApiKey . ":" . $mailjetSecretKey);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

	$mensaje = array();
	if (!is_array($msje)) {
		$mensaje['tipo'] = '';
		$mensaje['texto'] = $msje;
		$mensaje['contacto'] = FALSE;
	} else {
		$mensaje = $msje;
	}

	$message = array(
		"From" => array(
			"Email" => $fromEmail,
			"Name" => 'iQMaximo.com'
		),
		"To" => array(
			array(
				"Email" => $toEmail,
				"Name" => $toEmail
			)
		),
		"Subject" => $subject,
		"HTMLPart" => generateEmailBodyMessage($mensaje),
		"CustomID" => "AppGettingStartedTest"
	);

	// Agrega el archivo adjunto si existe
	if ($file !== '') {
		$filePath = '/home/iqmaximo/public_html/' . $file;

		$attachments = array(
			array(
				"path" => $filePath,
				"name" => $file,
				"type" => mime_content_type_file($filePath)
			)
		);

		$message['Attachments'] = array();
		foreach ($attachments as $attachment) {
			$content = base64_encode(file_get_contents($attachment['path']));
			$message['Attachments'][] = array(
				"ContentType" => $attachment['type'],
				"Filename" => $attachment['name'],
				"Base64Content" => $content
			);
		}
	}

	$data = json_encode(array("Messages" => array($message)));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$response = curl_exec($ch);

	$result = array();
	if (curl_errno($ch)) {
		$result['mensaje'] = 'Vuelve a intentarlo. ' . curl_error($ch);
		$result['estado'] = 0;
	} else {
		$result['mensaje'] = 'Tu mensaje fue enviado.';
		$result['estado'] = 1;
	}

	curl_close($ch);
	logger($response);
	return json_encode($result);
}

function enviaMailAdmin($mail_destino, $asunto, $msje, $datos_remitente = MAIL_WEBMASTER, $file = '')
{
	require_once("class.phpmailer.php");

	$mensaje = array();
	if (!is_array($msje)) {
		$mensaje['tipo'] = '';
		$mensaje['texto'] = utf8_encode($msje);
		$mensaje['contacto'] = FALSE;
	} else {
		$mensaje = $msje;
	}
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Port = 587; // Usa el puerto correcto
	$mail->Host = "localhost"; // Cambia si usas un servidor externo
	$mail->SMTPAuth = false; // Activa si necesitas autenticación
	$mail->SMTPAutoTLS = false; // Desactiva para evitar el intento de TLS automático
	$mail->From = "$datos_remitente";
	$mail->FromName = "iQmaximo.com";
	$mail->SMTPSecure = ''; // No necesita encriptación si SMTPAutoTLS es false
	$mail->CharSet = 'utf-8';
	$mail->setLanguage('es');


	$mail->Subject = "$asunto";
	$mail->AddAddress("$mail_destino", "$mail_destino");

	if ($file != '') {
		$mail->AddAttachment('/home/iqmaximo/public_html/' . $file);
	}

	$mail->Body = generateEmailBodyMessage($mensaje);
	$mail->IsHTML(true);
	//$mail->SMTPDebug = 2;
	$exito = $mail->Send();
	$Error = $mail->ErrorInfo;
	//print_r($Error);

	$result = array();
	if (!$exito) {
		$result['mensaje'] = 'Vuelve a intentarlo. ' . $mail->ErrorInfo;
		$result['estado'] = 0;
	} else {
		$result['mensaje'] = 'Tu mensaje fue enviado.';
		$result['estado'] = 1;
	}
	return json_encode($result);
}

function generateEmailBodyMessage($mensaje)
{
	$html = '';

	// Encabezado del mensaje
	$html .= '<table width="600" border="0" cellspacing="0" cellpadding="0" style="font-family:arial; font-size:12px">
        <tr>
            <td colspan="2" style="background:#fff; padding:10px; text-align:center; color:#999; font-size:11px">
                Si no visualiza correctamente las imágenes por favor habilite el contenido del mensaje.
            </td>
        </tr>
        <tr>
            <td style="background: #f7f7f7; padding:10px; text-align: left; font-size:11px; color:#999">
                <a href="' . URL . '" title="ir a iQmaximo.com"><img src="' . URL . 'img/util/loguito.jpg" alt="iQmaximo.com" style="border:none"></a>
            </td>
            <td valign="bottom" style="background: #f7f7f7; padding:10px; text-align: right; font-size:11px; color:#999">
                Generado el ' . getFechaActual() . '
            </td>
        </tr>
    </table>';

	// Contenido principal del mensaje
	$html .= '<table width="600" border="0" cellspacing="0" cellpadding="0" style="font-family:arial; font-size:12px">';

	if (isset($mensaje['tipo'])) {
		switch ($mensaje['tipo']) {
			case 'TEST':
				$html .= '<tr><td style="background:#053E66; color:#FFF; padding:10px; text-align:left; line-height:20px; border-radius:4px"><b>EVALUACIÓN PSICOTÉCNICA DEL TEST</b></td></tr>';
				break;
			case 'ESCRIBENOS':
				$contacto = $mensaje['contacto'] ? 'Gracias por escribirnos!' : 'Mensaje:';
				$html .= '<tr><td style="background:#053E66; color:#FFF; padding:10px; text-align:left; line-height:20px; border-radius:4px"><b>' . $contacto . '</b></td></tr>';
				break;
		}
	}

	// Cuerpo del mensaje
	$html .= '<tr><td style="padding:10px; text-align:left; line-height:18px">' . $mensaje['texto'] . '</td></tr>';
	$html .= '</table>';

	// Redes sociales y términos legales
	$html .= '<table width="600" border="0" cellspacing="0" cellpadding="0" style="font-family:arial; font-size:12px">
        <tr><td style="padding:10px; text-align:right; font-size:11px">Síguenos en: ' . generarEnlacesSociales() . '</td></tr>
        <tr><td style="color:#999; text-align:left; font-size:11px; border-top:1px solid #CCC; padding:10px">' . obtenerTextoLegal($mensaje['tipo']) . '</td></tr>
        <tr><td style="color:#999; text-align:left; font-size:11px; padding:10px">Corporación Talentos para la Excelencia © | iQmaximo.com <br>iQmaximo.com</td></tr>
    </table>';

	return $html;
}

function generarEnlacesSociales()
{
	return '<a href="https://www.facebook.com/IQmaximo" title="ir al facebook"><img src="' . URL . 'img/icono/fb-mini.jpg" style="vertical-align:middle; border:none" alt="Facebook"></a>&nbsp;&nbsp;
            <a href="https://twitter.com/IQmaximo" title="ir al twitter"><img src="' . URL . 'img/icono/tw-mini.jpg" style="vertical-align:middle; border:none" alt="Twitter"></a>&nbsp;&nbsp;
            <a href="https://www.youtube.com/channel/UCd7TzLXg1uXNtQqd1oYOGfA" title="ir al youtube"><img src="' . URL . 'img/icono/yt-mini.jpg" style="vertical-align:middle; border:none" alt="Youtube"></a>&nbsp;&nbsp;
            <a href="https://iqmaximo.com/blog" title="ir al blog"><img src="' . URL . 'img/icono/blog-mini.jpg" style="vertical-align:middle; border:none" alt="blog"></a>';
}

function obtenerTextoLegal($tipo)
{
	$texto = 'Para asegurarte de que recibes nuestros correos electrónicos de forma óptima añade ' . MAIL_INFO . ' a tu lista de remitentes seguros.';
	if ($tipo == 'TEST') {
		$texto .= ' Estos datos han sido generados automáticamente por el sistema en la sección Test de la página web iQmaximo.com. Sus datos personales ingresados en el formulario del Test han quedado incorporados en un fichero automatizados, con la finalidad de poder gestionar su solicitud, así como para futuras comunicaciones.';
	} else if ($tipo == 'ESCRIBENOS') {
		$texto .= ' Sus datos personales ingresados en el formulario de contacto han quedado incorporados en un fichero automatizados, con la finalidad de poder gestionar su solicitud, así como para futuras comunicaciones.';
	}
	return $texto;
}

function mime_content_type_file($filename)
{
	$mime_types = array(
		'txt' => 'text/plain',
		'htm' => 'text/html',
		'html' => 'text/html',
		'php' => 'text/html',
		'css' => 'text/css',
		'js' => 'application/javascript',
		'json' => 'application/json',
		'xml' => 'application/xml',
		'swf' => 'application/x-shockwave-flash',
		'flv' => 'video/x-flv',

		// images
		'png' => 'image/png',
		'jpe' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'jpg' => 'image/jpeg',
		'gif' => 'image/gif',
		'bmp' => 'image/bmp',
		'ico' => 'image/vnd.microsoft.icon',
		'tiff' => 'image/tiff',
		'tif' => 'image/tiff',
		'svg' => 'image/svg+xml',
		'svgz' => 'image/svg+xml',

		// archives
		'zip' => 'application/zip',
		'rar' => 'application/x-rar-compressed',
		'exe' => 'application/x-msdownload',
		'msi' => 'application/x-msdownload',
		'cab' => 'application/vnd.ms-cab-compressed',

		// audio/video
		'mp3' => 'audio/mpeg',
		'qt' => 'video/quicktime',
		'mov' => 'video/quicktime',

		// adobe
		'pdf' => 'application/pdf',
		'psd' => 'image/vnd.adobe.photoshop',
		'ai' => 'application/postscript',
		'eps' => 'application/postscript',
		'ps' => 'application/postscript',

		// ms office
		'doc' => 'application/msword',
		'rtf' => 'application/rtf',
		'xls' => 'application/vnd.ms-excel',
		'ppt' => 'application/vnd.ms-powerpoint',
		'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',

		// open office
		'odt' => 'application/vnd.oasis.opendocument.text',
		'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
	);

	// Extrae la extensión del archivo
	$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

	// Verifica si el archivo existe y la extensión está en el mapa
	if (!file_exists($filename)) {
		return "Error: El archivo no existe.";
	} elseif (!array_key_exists($ext, $mime_types)) {
		return 'application/octet-stream';
	}

	// Devuelve el tipo MIME basado en la extensión del archivo
	return $mime_types[$ext];
}

function getFechaActual()
{
	$arrayMeses = array(
		'Enero',
		'Febrero',
		'Marzo',
		'Abril',
		'Mayo',
		'Junio',
		'Julio',
		'Agosto',
		'Septiembre',
		'Octubre',
		'Noviembre',
		'Diciembre'
	);
	$arrayDias = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
	return $arrayDias[date('w')] . ", " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y');
}

function ValidaSessionOff($asParm1)
{
	if ($asParm1 != "") { ?>
		<script>
			location.href = "index";
		</script>
	<?php }
}

function ValidaSessionOn($asParm1)
{
	if ($asParm1 == "") { ?>
		<script>
			location.href = "index";
		</script>
	<?php }
}

function selectDataQuery($sql)
{
	$link = ConectarBD();
	$total = 0;
	//	echo $sql;
	$recordset = mysqli_query($link, $sql);
	$total = mysqli_num_rows($recordset);
	$result = array();
	$i = 0;
	if ($recordset && $total) {
		while ($row = mysqli_fetch_assoc($recordset)) {
			$result[$i]['nro'] = $i + 1;
			foreach ($row as $key => $value) {
				$result[$i][$key] = $value;
			}
			$i++;
		}
		$return['result'] = $result;
	} else {
		$return['result'] = false;
	}
	$return['total'] = $total;
	$return['sql'] = $sql;
	return $return;
}


function insertData($table, $array)
{
	$link = ConectarBD();
	$cont = 1;
	$rtn = false;
	$total = count($array);
	$keys = '';
	$values = '';
	foreach ($array as $key => $value) {
		($cont < $total) ? ($sep = ',') : ($sep = '');
		$keys .= "$key$sep";
		($value == NULL) ? $values .= "NULL $sep" : $values .= "'$value'$sep";
		$cont++;
	}
	$sql = "INSERT INTO $table($keys) VALUES ($values)";
	$recordset = mysqli_query($link, $sql);
	if ($recordset) {
		$rtn = mysqli_insert_id($link);
	} else {
		$rtn = false;
	}

	(mysqli_errno($link) > 0) ? $rtn = mysqli_error($link) : $rtn;
	// echo $sql."\n";  
	return $rtn;
}

function updateData($table, $array, $where)
{
	$link = ConectarBD();
	$cont_a = 1;
	$cont_w = 1;
	$tot_array = count($array);
	$tot_where = count($where);
	$values = '';
	$condition = '';
	foreach ($array as $key => $value) {
		($cont_a < $tot_array) ? ($sep = ',') : ($sep = '');
		($value == NULL) ? $values .= "$key=NULL $sep" : $values .= "$key='$value'$sep";
		$cont_a++;
	}
	foreach ($where as $key => $value) {
		($cont_w < $tot_where) ? ($sep = ' AND ') : ($sep = '');
		$condition .= "$key='$value'$sep";
		$cont_w++;
	}

	$values = str_replace("'NULL'", "NULL", $values);
	$sql = "UPDATE $table SET $values WHERE $condition";
	//	echo $sql; exit;
	$recordset = mysqli_query($link, $sql);
	if ($recordset)
		return true;
	else
		return false;
}

function selectRowData($table, $field, $where)
{
	$link = ConectarBD();
	$cont_w = 1;
	$tot_where = count($where);
	$condition = '';
	if ($where != NULL) {
		foreach ($where as $key => $value) {
			($cont_w < $tot_where) ? ($sep = ' AND ') : ($sep = '');
			$condition .= "$key='$value'$sep";
			$cont_w++;
		}
	}
	$sql = "SELECT $field FROM $table";
	if (!empty($condition))
		$sql .= " WHERE $condition";
	//echo $sql;
	$recordset = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($recordset);
	$total = mysqli_num_rows($recordset);
	if ($total) {
		return $row;
	} else {
		return false;
	}
}

function ConectarBD()
{
	// ini_set('memory_limit', '64M');
	$link = mysqli_connect(SERVER, USUARIO, CLAVE) or die("<b>Problema en MySQL: </b> Error al conectar con la base de datos");
	$rtn_conn = mysqli_select_db($link, BASE_DE_DATOS);
	mysqli_set_charset($link, 'utf8mb4');
	if (!$rtn_conn) {
		die('No se puede usar la base de datos: ' . ErrorBD($link));
	}
	return $link;
}

function ErrorBD($link)
{
	echo "<br/><span style='color:#C80101'>(<b>" . mysqli_errno($link) . "</b>): " . mysqli_error($link) . "</span>";
}

function formatoFecha($p_fecha, $p_formato = '')
{

	if ($p_fecha != '0000-00-00') {
		$fecha = strtotime($p_fecha);
		switch ($p_formato) {
			case "dd":
				$fecha = date("d", $fecha);
				break;
			case "mm":
				$fecha = date("m", $fecha);
				break;
			case "dd/mm/yy":
				$fecha = date("d", $fecha) . "/" . date("m", $fecha) . "/" . date("y", $fecha);
				break;
			case "dd/mm/yyyy":
				$fecha = date("d", $fecha) . "/" . date("m", $fecha) . "/" . date("Y", $fecha);
				break;
			case "dd-mm-yyyy":
				$fecha = date("d", $fecha) . "-" . date("m", $fecha) . "-" . date("Y", $fecha);
			case "yyyy-mm-dd":
				$fecha = date("Y", $fecha) . "-" . date("m", $fecha) . "-" . date("d", $fecha);
				break;
			default:
				$fecha = date("d", $fecha) . "/" . date("m", $fecha) . "/" . date("y", $fecha);
				break;
		}
	} else {
		$fecha = "-";
	}
	return $fecha;
}

function fechaToMySQL($fecha)
{
	$rtn = 'NULL';
	if ($fecha != "") {
		list($d, $m, $y) = explode('/', $fecha);
		$rtn = "$y-$m-$d";
	}
	return $rtn;
}

function url($s)
{
	return limpiarCadena(($s));
}

function limpiarCadena($cadena)
{
	$table = array(
		',' => '',
		'?' => '',
		'¿' => '',
		'¡' => '',
		'!' => '',
		'_' => '-',
		'|' => '-',
		'°' => '',
		'*' => '',
		'´' => '',
		'¨' => '',
		'{' => '',
		'}' => '',
		'^' => '',
		'[' => '',
		']' => '',
		'+' => '-',
		'%' => '',
		'#' => '',
		'"' => '',
		'(' => '',
		')' => '',
		'$' => '',
		'.' => '',
		':' => '',
		'Š' => 'S',
		'š' => 's',
		'Đ' => 'Dj',
		'đ' => 'dj',
		'Ž' => 'Z',
		'ž' => 'z',
		'Č' => 'C',
		'č' => 'c',
		'Ć' => 'C',
		'ć' => 'c',
		'À' => 'A',
		'Á' => 'A',
		'Â' => 'A',
		'Ã' => 'A',
		'Ä' => 'A',
		'Å' => 'A',
		'Æ' => 'A',
		'Ç' => 'C',
		'È' => 'E',
		'É' => 'E',
		'Ê' => 'E',
		'Ë' => 'E',
		'Ì' => 'I',
		'Í' => 'I',
		'Î' => 'I',
		'Ï' => 'I',
		'Ñ' => 'N',
		'Ò' => 'O',
		'Ó' => 'O',
		'Ô' => 'O',
		'Õ' => 'O',
		'Ö' => 'O',
		'Ø' => 'O',
		'Ù' => 'U',
		'Ú' => 'U',
		'Û' => 'U',
		'Ü' => 'U',
		'Ý' => 'Y',
		'Þ' => 'B',
		'ß' => 'Ss',
		'à' => 'a',
		'á' => 'a',
		'â' => 'a',
		'ã' => 'a',
		'ä' => 'a',
		'å' => 'a',
		'æ' => 'a',
		'ç' => 'c',
		'è' => 'e',
		'é' => 'e',
		'ê' => 'e',
		'ë' => 'e',
		'ì' => 'i',
		'í' => 'i',
		'î' => 'i',
		'ï' => 'i',
		'ð' => 'o',
		'ñ' => 'n',
		'ò' => 'o',
		'ó' => 'o',
		'ô' => 'o',
		'õ' => 'o',
		'ö' => 'o',
		'ø' => 'o',
		'ù' => 'u',
		'ú' => 'u',
		'û' => 'u',
		'ý' => 'y',
		'þ' => 'b',
		'ÿ' => 'y',
		'Ŕ' => 'R',
		'ŕ' => 'r',
		'/' => '-',
		' ' => '-'
	);

	//$stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $cadena);
	return strtolower(strtr($cadena, $table));
}

function cortarTexto($string, $length = NULL)
{
	if ($length == NULL)
		$length = 50;
	//Primero eliminamos las etiquetas html y luego cortamos el string
	$stringDisplay = substr(strip_tags($string), 0, $length);
	//Si el texto es mayor que la longitud se agrega puntos suspensivos
	if (strlen(strip_tags($string)) > $length)
		$stringDisplay .= ' ...';
	return $stringDisplay;
}

function espacioURL($cadena)
{
	$cadena = trim(str_replace(array("\r", "\n"), '', $cadena));
	$table = array(
		' ' => '%20',
		'<br>' => '%0D%0A',
		'<br />' => '%0D%0A',
		'<br/>' => '%0D%0A'
	);

	return strtr($cadena, $table);
}

function comprobarEmail($email)
{
	$sintaxis = "/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i";
	$rtn = array();
	if (preg_match($sintaxis, $email)) {
		$rtn['valida'] = 0;
		$rtn['mensaje'] = 'Ok';
	} else {
		$rtn['valida'] = 1;
		$rtn['mensaje'] = 'El Email no tiene un formato válido.';
	}
	return $rtn;
}

//function enviaEmail($para,$asunto,$mensaje) {

//	require_once 'configuracion.php';

//	require_once 'PHPMailer-master/PHPMailerAutoload.php';

//	//https://github.com/PHPMailer/PHPMailer

//	

//	$mail = new PHPMailer;

//	

//	//$mail->SMTPDebug = 3;             

//	

////	$mail->isSMTP();                                      

////	$mail->Host = SERVER_SMTP;  

////	$mail->SMTPAuth = true;                               

////	$mail->Username = USUARIO_SMTP;                 

////	$mail->Password = CLAVE_SMTP;                           

////	$mail->SMTPSecure = 'tls';                            

////	$mail->Port = PUERTO_SMTP;                                    

//

//	$mail->setFrom(EMAIL_SMTP, NOMEMAIL_SMTP);

//	$mail->addAddress(trim($para));     

//	$mail->isHTML(true);   

//	

//	$cabecera  = "<div style='font-family:arial; font-size:12px; padding:20px'>";

//	$cabecera .= "<a href='".URL."' target='_blank' title='ir a iQmax'><img src='".URL."img/logo/logoMail.png' style='border:0px' target='_blank' alt='iQmax'/></a><br><br>";

//

//	$mensaje .= "<br><br>Que tengas buen día.<br>El equipo de <strong>iQmax</strong>";

//		$mensaje .= "<div style='padding-top:10px; margin-top:20px; border-top:3px solid #F9B65B'>";

//			$mensaje .= "iQmax<br>";

//			$mensaje .= "<a href='".URL."' target='_blank' style='color:#999; font-size:11px'>www.iqmax.bo</a>";

//		$mensaje .= "</div>";

//	$mensaje .= "</div>";

//	

//	$mail->Subject = utf8_decode(trim($asunto))." - ".date("d/m/Y H:i");

//	$mail->Body    = nl2br(utf8_decode(trim($cabecera.$mensaje)));

//	$mail->AltBody = strip_tags(utf8_decode(trim($cabecera.$mensaje)));

//

//	$rtn = array();

//	

//	if(!$mail->send()) {

//		$rtn['estado'] = 1;

//		$rtn['mensaje'] = $mail->ErrorInfo;

//	} else {

//		$rtn['estado'] = 0;

//		$rtn['mensaje'] = "Mensaje enviado!";

//	}	

//	

//	return $rtn;

//}



function generarSeguridad($str)
{
	return sha1(md5(strtolower(trim($str))));
}

function validaTextIn($text)
{
	$rtn = (preg_match('/[a-zA-Z0-9.-]+$/', $text)) ? true : false;
	return $rtn;
}

function validar_clave($clave, &$error_clave)
{
	if (strlen($clave) < 6) {
		$error_clave = "La clave debe tener al menos 6 caracteres";
		return false;
	}
	if (strlen($clave) > 16) {
		$error_clave = "La clave no puede tener más de 16 caracteres";
		return false;
	}
	if (!preg_match('`[a-z]`', $clave)) {
		$error_clave = "La clave debe tener al menos una letra minúscula";
		return false;
	}
	if (!preg_match('`[A-Z]`', $clave)) {
		$error_clave = "La clave debe tener al menos una letra mayúscula";
		return false;
	}
	if (!preg_match('`[0-9]`', $clave)) {
		$error_clave = "La clave debe tener al menos un caracter numérico";
		return false;
	}
	$error_clave = "";
	return true;
}

function generaClave($length)
{
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	return substr(str_shuffle($chars), 0, $length);
}
?>
