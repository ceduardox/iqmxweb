<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(-1);
extract($_REQUEST);
$accion = (isset($accion)) ? $accion : '';
$valida = 0;
$rtn = 'Error al ejecutar el archivo';
$msje = '';
$class = 'alert-danger';
try {
	if ($accion != '') {
		require_once ("require/util.php");
		require_once ("require/transacciones.php");
		$REQUEST = array();
		if ($accion == 'sendPushNotification') {
			$obj = new ClssPushNoification();
			$objRtn = $obj->send($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarPushNotification') {
			$obj = new ClssPushNoification();
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarPushNotification') {
			$obj = new ClssPushNoification();
			$objRtn = $obj->guardar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarLandingTestimonio') {
			$obj = new ClssLandingTestimonio();
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'saveLandingTestimonio') {
			$obj = new ClssLandingTestimonio();
			$objRtn = $obj->guardar($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarFAQ') {
			$obj = new ClssLandingFAQ();
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'saveLandingFAQ') {
			$obj = new ClssLandingFAQ();
			$objRtn = $obj->guardar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'saveLandingPrecios') {
			$obj = new ClssLandingPrecios();
			$objRtn = $obj->guardar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'saveLanding') {
			$obj = new ClssLanding();
			$objRtn = $obj->guardar($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarContacto') {
			$obj = new ClssContacto();
			$objRtn = $obj->guardar($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'sortedContacto') {
			$obj = new ClssContacto();
			$objRtn = $obj->sorted($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarContacto') {
			$obj = new ClssContacto();
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarMaterialCategoria') {
			$obj = new ClssMaterial();
			$objRtn = $obj->guardarCategoria($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarMaterialCategoria') {
			$obj = new ClssMaterial();
			$objRtn = $obj->eliminarCategoria($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarMaterial') {
			$obj = new ClssMaterial();
			$objRtn = $obj->guardar($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarMaterial') {
			$obj = new ClssMaterial();
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarLectura') {
			$obj = new ClssTest();
			if ($_REQUEST['cod'] == 0) {
				$objRtn = $obj->insertarLectura($_REQUEST, $_FILES);
			} else {
				$objRtn = $obj->actualizarLectura($_REQUEST, $_FILES);
			}
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'activoLectura') {
			$obj = new ClssTest();
			$objRtn = $obj->activoLectura($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarLectura') {
			$obj = new ClssTest();
			$objRtn = $obj->eliminarLectura($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarRankingModulo') {
			$obj = new ClssRanking();
			$objRtn = $obj->guardarRankingModulo($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarRankingModulo') {
			$obj = new ClssRanking();
			$objRtn = $obj->eliminarRankingModulo($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarRanking') {
			$obj = new ClssRanking();
			$objRtn = $obj->guardar($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarNoticia') {
			$obj = new ClssNoticia();
			$objRtn = $obj->guardar($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'activoNoticiaComentario') {
			$obj = new ClssNoticia();
			$objRtn = $obj->activoNoticiaComentario($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarEtiqueta') {
			$obj = new ClssNoticia();
			$objRtn = $obj->guardarEtiqueta($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarCategoria') {
			$obj = new ClssNoticia();
			$objRtn = $obj->guardarCategoria($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarCategoria') {
			$obj = new ClssNoticia();
			$objRtn = $obj->eliminarCategoria($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarTestiQTipo') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->guardarTipo($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarTestiQPregunta') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->guardarPregunta($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'verdaderoTestiQAlternativa') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->verdaderoAlternativa($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarTestiQPercentil') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->guardarPercentil($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarTestiQPercentilEdad') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->guardarPercentilEdad($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarTestiQSerie') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->guardarSerie($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarTestiQAlternativa') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->guardarAlternativa($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarTestiQPregunta') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->eliminarPregunta($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarTestiQPercentil') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->eliminarPercentil($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarTestiQPercentilEdad') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->eliminarPercentilEdad($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarTestiQAlternativa') {
			$obj = new ClssTestiQ();
			$objRtn = $obj->eliminarAlternativa($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarEtiqueta') {
			$obj = new ClssNoticia();
			$objRtn = $obj->eliminarEtiqueta($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarNoticia') {
			$obj = new ClssNoticia();
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarALeerBoliviaTestimonio') {
			$obj = new ClssALeerBoliviaTestimonios();
			$objRtn = $obj->guardar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'activateALeerBoliviaTestimonio') {
			$obj = new ClssALeerBoliviaTestimonios();
			$objRtn = $obj->activate($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarALeerBoliviaTestimonio') {
			$obj = new ClssALeerBoliviaTestimonios();
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarALeerBoliviaLogo') {
			$obj = new ClssALeerBoliviaLogos();
			$objRtn = $obj->guardar($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'activateALeerBoliviaLogo') {
			$obj = new ClssALeerBoliviaLogos();
			$objRtn = $obj->activate($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarALeerBoliviaLogo') {
			$obj = new ClssALeerBoliviaLogos();
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarALeerBoliviaFicha') {
			$obj = new ClssALeerBoliviaFicha();
			$objRtn = $obj->guardar($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'activateALeerBoliviaFicha') {
			$obj = new ClssALeerBoliviaFicha();
			$objRtn = $obj->activate($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarALeerBoliviaFicha') {
			$obj = new ClssALeerBoliviaFicha();
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarVideo') {
			$obj = new ClssVideos('videos');
			$objRtn = $obj->guardar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarVideo') {
			$obj = new ClssVideos('videos');
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'guardarTestimonio') {
			$obj = new ClssVideos('testimonios');
			$objRtn = $obj->guardar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'eliminarTestimonio') {
			$obj = new ClssVideos('testimonios');
			$objRtn = $obj->eliminar($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		if ($accion == 'activateTestimonio') {
			$obj = new ClssVideos('testimonios');
			$objRtn = $obj->activate($_REQUEST);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		/* ACTUALIZAR MIS DATOS */
		if ($accion == 'guardarMisDatos') {
			$obj = new ClssUsuario();
			$objRtn = $obj->actualizar($_REQUEST, $_FILES);
			$valida = $objRtn['estado'];
			$rtn = $objRtn['mensaje'];
			$class = $objRtn['class'];
		}
		/* INICIO DE SESIÓN */
		if ($accion == 'sesion') {
			$obj = new ClssLogeo();
			$usuario = trim($usuario);
			$clave = trim($clave);
			if ($usuario != "" and $clave != "") {
				$rst = $obj->getLogeo($usuario, $clave);
				if ($rst !== 0) {
					$valida = 1;
					$rtn = 'Bienvenid@ ' . $_SESSION['USER_CITEXBO_ADM'];
					$class = 'alert-success';
				} else {
					$valida = 0;
					$rtn = 'No te encuentras registrado.';
					$class = 'alert-danger';
				}
			} else {
				$valida = 0;
				$rtn = 'Por favor ingresa tus datos de acceso.';
				$class = 'alert-warning';
			}
		}
	}
} catch (Exception $e) {
	$valida = 0;
	$rtn = $e->getMessage();
	$class = 'alert-warning';
}
$dato = array();
$dato['estado'] = $valida;
$dato['mensaje'] = $rtn;
$dato['class'] = $class;
echo json_encode($dato);
?>