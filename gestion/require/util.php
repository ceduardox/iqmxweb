<?php
if (!defined('PDO::ATTR_DRIVER_NAME')) {
	die('PDO unavailable');
}  
function is_json($data,$return_data = false) {
	$rtn = FALSE;
	if(is_string($data)) {
		$rtn = (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
	}
	return $rtn;
}

function validExistData($dato,$cod){
	if(empty($dato) and $cod==0) {
		echo '<script>location.href="index";</script>';
		exit;
	}
}

function getAvatar($img, $genero) {
	$_PATH = '';
    if ($img != "" and ! is_null($img)) {
        if (file_exists($_PATH.RUTA_USUARIO . $img)) {
            $src =  $_PATH.RUTA_USUARIO . $img;
        } else {
            $src = $_PATH.'img/anonimo1.png';
        }
    } else {
        $src = $_PATH."img/anonimo" . $genero . ".jpg";
    }
    return $src;
}

function fechaToMySQL($fecha) {
    $fecha = str_replace("-", "/", $fecha);
    $rtn = 'NULL';
    if ($fecha != "") {
        list($d, $m, $y) = explode('/', $fecha);
        $rtn = "$y-$m-$d";
    }
    return $rtn;
}

function fechaToPHP($fechaDateTime, $tipo = '') {
    if (!is_null($fechaDateTime) and $fechaDateTime != "") {
        $fecha = explode('-', $fechaDateTime);
        if ($tipo != "") {
            switch ($tipo) {
                case "nacimiento" :
                    $fecha_convertida = date('d') . '/' . date('m') . '/' . (date('Y') - 15);
                    break;
            }
        } else {
            $fecha_convertida = $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0];
        }
    } else {
        $fecha_convertida = "";
    }
    return $fecha_convertida;
}

function getExtensionFichero($name) {
    $split = explode('.', $name);
    $splitCount = count($split) - 1;
    return strtolower($split[$splitCount]);
}

function validActive($page = '', $pageMain = false) {
	$active = '';
	if($pageMain == false) {
		if(is_array($page)) {
			$cta = 0;
			foreach($page as $pages) {
				if($pages == $_REQUEST['page'] and PAG_ACTUAL == 'main') {
					$cta++;
				}
			}
			$active = ($cta>0) ? 'active' : '';
		} else {
			if($page == $_REQUEST['page'] and PAG_ACTUAL == 'main') {
				$active = 'active';
			}
		}
	} else {
		if($page == PAG_ACTUAL and !isset($_REQUEST['page']) and $_REQUEST['page']=="") {
			$active = 'active';
		}
	}
	echo $active;
}

function limpiarCadena($cadena) {
    $traduce = array("á" => "a", "é" => "e", "í" => "i",
        "ó" => "o", "ú" => "u", "ñ" => "n",
        "à" => "a", "è" => "e", "ì" => "i",
        "ò" => "o", "ù" => "u", "ä" => "a",
        "ë" => "e", "ï" => "i", "ö" => "o",
        "ü" => "u", "â" => "a", "ê" => "e",
        "î" => "i", "ô" => "o", "û" => "u",
        "…" => "-", " " => "-", "\\" => "-",
        "Á" => "a", "É" => "e", "Í" => "i", "Ó" => "o", "Ú" => "u",
        "À" => "a", "È" => "e", "Ì" => "i", "Ò" => "o", "Ù" => "u",
        "¨" => "-", "º" => "-", "," => "",
        "~" => "-", "#" => "-", "@" => "-",
        "|" => "", "!" => "", "\'" => "-",
        "$" => "-", "%" => "-",
        "&" => "-", "/" => "-", "(" => "-",
        ")" => "-", "?" => "-", "'" => "-",
        "¡" => "-", "¿" => "-", "[" => "-",
        "^" => "-", "`" => "-", "]" => "-",
        "+" => "-", "}" => "-", "{" => "-", '"' => "",
        "¨" => "-", "´" => "-", ">" => "-",
        "<" => "-", ";" => "-", ":" => "-");
    $cadena = strtr(trim($cadena), $traduce);
    $cadena = str_replace("Ã¡", "-", $cadena);
    $cadena = str_replace("Ã©", "-", $cadena);
    $cadena = str_replace("Â®", "-", $cadena);
    $cadena = str_replace("Ã­", "-", $cadena);
    $cadena = str_replace("ï¿½", "-", $cadena);
    $cadena = str_replace("Ã³", "-", $cadena);
    $cadena = str_replace("Ãº", "-", $cadena);
    $cadena = str_replace("n~", "-", $cadena);
    $cadena = str_replace("Âº", "-", $cadena);
    $cadena = str_replace("Âª", "-", $cadena);
    $cadena = str_replace("ÃƒÂ¡", "-", $cadena);
    $cadena = str_replace("Ã±", "-", $cadena);
    $cadena = str_replace("Ã‘", "-", $cadena);
    $cadena = str_replace("ÃƒÂ±", "-", $cadena);
    $cadena = str_replace("n~", "-", $cadena);
    $cadena = str_replace("Ãš", "-", $cadena);
    $cadena = str_replace("\n", "", $cadena);
    $cadena = str_replace("\r", "", $cadena);
    
    return strtolower($cadena);
}

function subirFichero($fichero, $ruta, $extensiones, $sAncho = '', $sAlto = '') {
    if ($_FILES[$fichero]['name'] != "") {
        $tamano_archivo = $_FILES[$fichero]['size'];
        $tipo = getExtensionFichero($_FILES[$fichero]['name']);
        $extension = explode(".", $_FILES[$fichero]['name']);
        $num = count($extension) - 1;
        $admitido = false;

        for ($i = 0; $i <= count($extensiones) - 1; $i++) {
            if ($extensiones[$i] == strtoupper($extension[1])) {
                $admitido = true;
                break;
            }
        }
        if ($admitido) {
            if (!copy($_FILES[$fichero]['tmp_name'], $ruta . $_FILES[$fichero]['name'])) {
                $err = 1;
                $str = "Ha ocurrido un error al intentar subir el fichero.";
                $nomFile = "";
            } else {
                $strName = limpiarCadena(RAND . "_" . str_replace(" ", "", $_FILES[$fichero]['name']));
                rename($ruta . $_FILES[$fichero]['name'], $ruta . $strName);
                $nomFile = $strName;
                $err = 0;
                $str = true;

                if ($sAncho != "" or $sAlto != "") {
                    $size = getimagesize($ruta . $strName);
                    $alto = $size[1];
                    $ancho = $size[0];

                    if ($ancho == $sAncho and $alto == $sAlto) {
                        $err = 0;
                    } else {
                        $err = 0;
                        $str = true; //La foto se ha sido redimensionada por no tener las medidas recomendadas.\nSi deseas vuelve a cargar otra foto con ".$sAncho."px de ancho y ".$sAlto."px de alto.";
                        $nomFile = resize($ruta, $strName, $sAncho, $sAlto);
                    }
                }
            }
        } else {
            $err = 1;
            $str_extension = "";

            foreach ($extensiones as $extension) {
                $str_extension .= $extension . ", ";
            }

            $str = 'La extensión del archivo no es correcta. Sólo se permiten: ' . substr($str_extension, 0, -2);
            $nomFile = "";
        }
    } else {
        $err = 0;
        $str = '';
        $nomFile = "";
    }
    $valor['tipo'] = $tipo;
    $valor['error'] = $str; //captura el mensaje de error
    $valor['archivo'] = $nomFile; //captura el nombre del archivo
    return $valor;
}

function getFileExtension($str) {
	$i = strrpos($str,".");
	if (!$i) {
		return "";
	}
	$ext = substr($str,$i+1); // get ext
	return $ext;
}

function resize($path, $archivo, $ancho_ideal, $alto_ideal, $rename = false) {
    $prod_img = $path . $archivo;
    $sizes = getimagesize($prod_img);

    if ($sizes === false) {
        echo 'No se pudo obtener el tamaño de la imagen.';
        return false;
    }

    $aspect_ratio = $sizes[1] / $sizes[0];
    if ($sizes[1] <= $alto_ideal) {
        $new_width = $sizes[0];
        $new_height = $sizes[1];
    } else {
        $new_height = $alto_ideal;
        $new_width = $new_height / $aspect_ratio;
    }

    $type = pathinfo($prod_img, PATHINFO_EXTENSION);

    if (function_exists('imagecreatetruecolor')) {
        $destimg = imagecreatetruecolor($new_width, $new_height) or die('Problema al crear la imagen.');

        switch ($type) {
            case 'gif':
                $srcimg = imagecreatefromgif($prod_img);
                break;
            case 'jpg':
            case 'jpeg':
                $srcimg = imagecreatefromjpeg($prod_img);
                break;
            case 'png':
                $srcimg = imagecreatefrompng($prod_img);
                break;
            default:
                echo 'Formato de archivo no soportado.';
                return false;
        }

        if ($srcimg === false) {
            echo 'Problema al crear la imagen desde el archivo original.';
            return false;
        }

        if (function_exists('imagecopyresampled')) {
            imagecopyresampled($destimg, $srcimg, 0, 0, 0, 0, $new_width, $new_height, imagesx($srcimg), imagesy($srcimg)) or die('Problema al redimensionar.');
        } else {
            imagecopyresized($destimg, $srcimg, 0, 0, 0, 0, $new_width, $new_height, imagesx($srcimg), imagesy($srcimg)) or die('Problema al redimensionar.');
        }

        $outputPath = $rename ? $path . $archivo : $path . time() . rand() . '.jpg';

        if (!imagejpeg($destimg, $outputPath, 100)) {
            echo 'Problema al guardar la imagen.';
            return false;
        }

        imagedestroy($destimg);
        imagedestroy($srcimg);
    } else {
        // GD no está disponible, mover o renombrar el archivo sin redimensionar
        $outputPath = $rename ? $path . $archivo : $path . time() . rand() . '.jpg';
        if (!$rename) {
            // Si no se va a renombrar, mueve el archivo a la nueva ubicación con el nuevo nombre
            if (!rename($prod_img, $outputPath)) {
                echo 'Problema al mover el archivo.';
                return false;
            }
        }
    }

    // Si se renombra, el proceso ya se manejo con anterioridad.
    return $rename ? $archivo : basename($outputPath);
}

function eliminaFichero($path_file) {
    if (file_exists($path_file) == true) {
        $estado = unlink($path_file);
        return $estado;
    }
}

function getMes($num,$tipo='') {
	if($tipo=='nombre') {
		$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	} else {
		$mes = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	}
	return $mes[date($num)-1];
}

function setFormatoFecha($fecha, $formato = '') {
    if ($fecha != '') {
        switch ($formato) {
            case "dd/mm/yyyy":
                $fecha = strtotime($fecha);
                $fecha = date("d", $fecha) . "/" . date("m", $fecha) . "/" . date("Y", $fecha);
                break;
            case "full":
                $fecha = strtotime($fecha);
                $fecha = date("d", $fecha) . " de " . strtolower(getMes(date("m", $fecha), 'nombre')) . " de " . date("Y", $fecha);
                break;
            case "fullHora":
                $fecha = strtotime($fecha);
                $fecha = date("d", $fecha) . " de " . strtolower(getMes(date("m", $fecha), 'nombre')) . " de " . date("Y", $fecha) . ", " . date("g", $fecha) . ":" . date("i", $fecha) . " " . date("a", $fecha);
                break;
            case "MesHora":
                $fecha = strtotime($fecha);
                $fecha = date("d", $fecha) . "-" . strtolower(getMes(date("m", $fecha), 'sigla')) . "-" . date("Y", $fecha); // . "  " . date("g", $fecha) . ":" . date("i", $fecha) . " " . date("a", $fecha);
                break;
            default:
                $fecha = strtotime($fecha);
                if ($fecha != '') {
                    $fecha = date("d", $fecha) . "/" . date("m", $fecha) . "/" . date("Y", $fecha);
                } else {
                    $fecha = "-";
                }
                break;
        }
    } else {
        $fecha = "-";
    }
    return $fecha;
}

function cortarTexto($texto, $num) {
	$texto = strip_tags($texto);
    return (strlen($texto) > $num) ? substr($texto, 0, $num) . "..." : $texto;
}

class Paginacion {	
	function pagina($pagina,$cantidad) {
		return (($pagina-1)*$cantidad);
	}

 	function registros($data) {
		return $data;
	}

	function totalRegistros($registros) {
		return count($registros);
	}

	function calcularPaginas($totalRegistros,$cantidadPorPagina = 10) {
		return ceil($totalRegistros / $cantidadPorPagina);		
	}

	function pintarPaginasc($paginas,$pagina,$addres,$params=NULL) {
		$pags = '';
		if($paginas>1) {
			$url = '';
			if(!is_null($params)) {
				foreach ($params as $key=>$value) {
					if($key!="pagina" and !empty($value)) {
						$url .= "$key=" . urldecode($value)."&";
					}
				}
			}
 			$pags = '<ul id="paginador" class="pagination pagination-sm no-margin pull-right">';
			for($i = 0; $i < $paginas; $i++) {
				$activo = ($pagina==($i+1)) ? 'class="activo"' : '';
				$pags .= '<li><a href="'.$addres.'-pagina-'.($i+1).''.$url.'" '.$activo.'>'.($i+1).'</a></li>';
			}
			$pags .= '</ul>';
		}
		return $pags;
	}

        private $_limit;
        private $_page;
        private $_total;

	function pintarPaginas($paginas,$pagina,$total,$limit,$addres) {
		$this->_total = $total;
		$this->_page = $pagina;
		$this->_limit = $limit;
		$links = 7;

		$list_class = 'pagination pagination-sm no-margin pull-right';
		if ( $this->_limit == 'all' ) {
			return '';
		}

		$last       = ceil( $this->_total / $this->_limit );
		$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
		$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
		$html       = '<ul class="' . $list_class . '">';
		$class      = ( $this->_page == 1 ) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="'.$addres.'-pagina-' . ( $this->_page - 1 ) . '">&laquo;</a></li>';
		
        if ( $start > 1 ) {
			$html   .= '<li><a href="'.$addres.'-pagina-1">1</a></li>';
			$html   .= '<li class="disabled"><span>...</span></li>';
		}

		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $this->_page == $i ) ? "active" : "";
			$html   .= '<li class="' . $class . '"><a href="'.$addres.'-pagina-' . $i . '">' . $i . '</a></li>';
		}

		if ( $end < $last ) {
			$html   .= '<li class="disabled"><span>...</span></li>';
			$html   .= '<li><a href="'.$addres.'-pagina-' . $last . '">' . $last . '</a></li>';
		}

		$class      = ( $this->_page == $last ) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="'.$addres.'-pagina-' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
		$html       .= '</ul>';

		return $html;
	}	
}

function getPage($page = 'dashboard') {
	$file = 'pages/'.$page.'.php';
 	if(file_exists($file)) {
		include($file);
	} else {
		echo "<div class='alert alert-danger'>La página que intentas ver no existe.</div>";
	}
}

function limpiaTextoAdmin($texto) {
   $texto = str_replace('\"', '"', $texto);
    return $texto;
}

function validaSesionLogon() {
	if (isset($_SESSION['USER_CITEXBO_ADM']) and $_SESSION['USER_CITEXBO_ADM'] != "") {
		header('Location: main');
		exit;
	}   
}

function validaSesionAdm() {
	if (!isset($_SESSION['USER_CITEXBO_ADM']) and $_SESSION['USER_CITEXBO_ADM'] == "") {
		header('Location: index');
		exit;
	}
}

function getActivo($estado,$opts='') {
	if($opts!="") {
		if(is_array($opts)){
		    if($estado == 1) {
				$rtn = $opts['ok'];
			} else { 
				$rtn = $opts['ko'];
			}
		}
	} else {	
	    $rtn = ($estado == 0) ? 'Activar' : 'Desactivar';
	}
    return $rtn;
}

function errorInfo($q,$idx=2) {
    $msjeErr = $q->errorInfo();
    $msje = $msjeErr[$idx];
    return $msje;
}

function slug($string) {
    $table = array(
        '.' => '', 'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
        'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'ü' => 'u', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
        'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o','°' => 'o',
        'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
        'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', '/' => '-', ' ' => '-', ',' => '', '?' => '', '¿' => '', '|' => ''
    );
    
    $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);
    $str = trim(strtolower(strtr($string, $table)));
    $sustituye = array("\r\n", "\n\r", "\n", "\r");
    return str_replace($sustituye, '', $str);
}

function inc_retorna_mes($numero)
{
	switch($numero)
	{
		case "1" :	$mes="Enero";       break;
		case "2" :	$mes="Febrero"; 	break;
		case "3" :	$mes="Marzo";    	break;
		case "4" :	$mes="Abril";		break;
		case "5" :	$mes="Mayo";		break;
		case "6" :	$mes="Junio";		break;
		case "7" :	$mes="Julio";		break;
		case "8" :	$mes="Agosto";		break;
		case "9" :	$mes="Setiembre";	break;
		case "10":	$mes="Octubre";		break;
		case "11":	$mes="Noviembre";	break;
		case "12":	$mes="Diciembre";	break;
	}
	return $mes;
}

function setCortarTextoLimpio($texto, $num)  
{   
	$texto = strip_tags(trim($texto));
	$txt = (strlen($texto) > $num) ? substr($texto,0,$num)."..." : $texto;      
	echo $txt;
}

function setNumAlternativa($num) {
	$alpha = array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');
	return $alpha[$num-1];
}

function createEmbedURL($text) {
	$text = trim($text);
    $urlEmbed = "https://www.youtube.com/embed/";
	$text = str_replace("https://www.youtube.com/watch?v=",$urlEmbed,$text);
	$text = str_replace("http://www.youtube.com/watch?v=",$urlEmbed,$text);
	$text = str_replace("//www.youtube.com/watch?v=",$urlEmbed,$text);
	$text = str_replace("https://youtu.be/",$urlEmbed,$text);
    return $text;
}
?>