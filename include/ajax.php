<?php

extract($_REQUEST);

$rtn = 'Acceso restringido';

if (isset($tipo)) {
	require_once ('../require/configuracion.php');
	require_once ('../require/class.phpmailer.php');
	require_once ('../require/util.php');

	switch ($tipo) {
		case 'comienzaAhora':
			$validaEMail = comprobarEmail($email);

			if ($validaEMail['valida'] == 0) {
				$nombre = trim($nombre);
				$email = trim($email);
				$nameEmpresa = trim($nameEmpresa);
				$fono = trim($fono);
				$numEmpresa = trim($numEmpresa);
				$suscripciones = trim($suscripciones);
				$objectivos = trim($objectivos);

				/* WEBMASTER - inicio */
				$str = 'Hola,<br><br>';
				$str .= 'Te informamos que han escrito desde la sección de <strong>Programas</strong> el siguiente mensaje:<br><br>';
				$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';
				$str .= '<strong>Nombre completo:</strong> ' . $nombre . '<br>';
				$str .= '<strong>Email:</strong> ' . $email . '<br>';
				$str .= '<strong>Empresa:</strong> ' . $nameEmpresa . '<br>';
				$str .= '<strong>Tel&eacute;fono:</strong> ' . $fono . '<br>';
				$str .= '<strong>Tamaño de la empresa:</strong> ' . $numEmpresa . '<br>';
				$str .= '<strong>Número de suscripciones:</strong> ' . $suscripciones . '<br>';

				$str .= '<strong>¿Qué objetivos tiene tu equipo?:</strong> <br>' . $objectivos;
				$str .= '</div>';
				$str .= '<br>Trata de reponderle lo más pronto posible.';
				$retorna = enviaMailAdmin(MAIL_INFO, 'Mensaje desde Programas - ' . $nombre, $str);
				/* WEBMASTER - inicio */

				/* USUARIO - inicio */
				$str = 'Hola ' . $nombre . ',<br><br>';
				$str .= 'Gracias por escribirnos, trateremos de responderte lo más pronto posible.<br><br>';
				$str .= 'Tus datos enviados son:<br><br>';
				$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';
				$str .= '<strong>Nombre completo:</strong> ' . $nombre . '<br>';
				$str .= '<strong>Email:</strong> ' . $email . '<br>';
				$str .= '<strong>Empresa:</strong> ' . $nameEmpresa . '<br>';
				$str .= '<strong>Tel&eacute;fono:</strong> ' . $fono . '<br>';
				$str .= '<strong>Tamaño de la empresa:</strong> ' . $numEmpresa . '<br>';
				$str .= '<strong>Número de suscripciones:</strong> ' . $suscripciones . '<br>';
				$str .= '<strong>¿Qué objetivos tiene tu equipo?:</strong> <br>' . $objectivos;
				$str .= '</div>';
				$retorna = enviaMail($email, 'Mensaje desde Programas - ' . $nombre, $str);
				/* USUARIO - fin */

				$valida = 1;
				$rtn = 'Mensaje enviado!';
			} else {
				$valida = $validaEMail['valida'];
				$rtn = $validaEMail['mensaje'];
			}

			$rtnResult = array();
			$rtnResult['estado'] = $valida;
			$rtnResult['mensaje'] = $rtn;
			$rtn = json_encode($rtnResult);
			break;


		case 'formRegistroAuspiciador':
			if ($_SERVER["REQUEST_METHOD"] === "POST") {
				$recaptcha_secret = KEY_CAPTCHA_SECRET_V2;
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
				$response = json_decode($response, true);

				if ($response["success"] === true) {

					$nombre_responsable = trim($nombre_responsable);
					$ci_responsable = trim($ci_responsable);
					$cargo_responsable = trim($cargo_responsable);
					$profesion_responsable = trim($profesion_responsable);
					$telefono_responsable = trim($telefono_responsable);
					$email_responsable = trim($email_responsable);
					$nombre_institucion = trim($nombre_institucion);
					$razon_social = trim($razon_social);
					$nit = trim($nit);
					$direccion = trim($direccion);
					$telefono_institucion = trim($telefono_institucion);
					$email_institucion = trim($email_institucion);

					/* WEBMASTER - inicio */
					$str = 'Hola,<br><br>';
					$str .= 'Te informamos que han escrito desde la sección de <strong>Inscripción de Auspiciadores</strong>:<br><br>';
					$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';

					$formInfo = '<strong>RESPONSABLE DEL EVENTO</strong><br>';
					$formInfo .= '<strong>Nombre completo:</strong> ' . $nombre_responsable . '<br>';
					$formInfo .= '<strong>C.I.:</strong> ' . $ci_responsable . '<br>';
					$formInfo .= '<strong>Cargo en la Institución:</strong> ' . $cargo_responsable . '<br>';
					$formInfo .= '<strong>Profesión o Actividad:</strong> ' . $profesion_responsable . '<br>';
					$formInfo .= '<strong>Tel&eacute;fono:</strong> ' . $telefono_responsable . '<br>';
					$formInfo .= '<strong>Email:</strong> ' . $email_responsable . '<br>';

					$formInfo .= '<hr/>';

					$formInfo .= '<strong>DATOS DE LA INSTITUCIÓN</strong><br>';
					$formInfo .= '<strong>Nombre de la Institución:</strong> ' . $nombre_institucion . '<br>';
					$formInfo .= '<strong>Razón Social:</strong> ' . $razon_social . '<br>';
					$formInfo .= '<strong>NIT:</strong> ' . $nit . '<br>';
					$formInfo .= '<strong>Dirección:</strong> ' . $direccion . '<br>';
					$formInfo .= '<strong>Tel&eacute;fonos:</strong> ' . $telefono_institucion . '<br>';
					$formInfo .= '<strong>Email:</strong> ' . $email_institucion . '<br>';

					$str .= $formInfo . '</div>';
					$str .= '<br>Trata de reponderle lo más pronto posible.';
					$retorna = enviaMailAdmin(MAIL_INFO, 'A Leer Bolivia: Inscripción de Auspiciadores', $str, MAIL_WEBMASTER, $file);
					/* WEBMASTER - inicio */

					/* USUARIO - inicio */
					$str = 'Hola,<br><br>';
					$str .= 'Gracias por escribirnos, trateremos de responderte lo más pronto posible.<br><br>';
					$str .= 'Tus datos enviados son:<br><br>';
					$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';
					$str .= $formInfo . '</div>';
					$retorna = enviaMail($email_institucion, 'A Leer Bolivia: Inscripción de Auspiciadores', $str, MAIL_WEBMASTER, $file);
					/* USUARIO - fin */

					$valida = 1;
					$rtn = 'Mensaje enviado!';
				} else {
					$valida = 0;
					$rtn = 'Marca la casilla de verificación para confirmar que no eres un robot';
				}
			} else {
				$valida = 0;
				$rtn = 'Ha ocurrido un error, vuelve a intentarlo';
			}

			$rtnResult = array();
			$rtnResult['estado'] = $valida;
			$rtnResult['mensaje'] = $rtn;
			$rtn = json_encode($rtnResult);
			break;

		case 'formRegistroEstudiante':
			if ($_SERVER["REQUEST_METHOD"] === "POST") {

				$recaptcha_secret = KEY_CAPTCHA_SECRET_V2;
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
				$response = json_decode($response, true);

				if ($response["success"] === true) {

					$nombre_tutor = trim($nombre_tutor);
					$parentesco = trim($parentesco);
					$estudiante_ci = trim($estudiante_ci);
					$telefono_tutor = trim($telefono_tutor);
					$email_tutor = trim($email_tutor);
					$nombre_estudiante = trim($nombre_estudiante);
					$nacimiento_estudiante = trim($nacimiento_estudiante);
					$edad_estudiante = trim($edad_estudiante);
					$colegio_estudiante = trim($colegio_estudiante);
					$grado_estudiante = trim($grado_estudiante);
					$telefono_estudiante = trim($telefono_estudiante);
					$email_estudiante = trim($email_estudiante);

					/* WEBMASTER - inicio */
					$str = 'Hola,<br><br>';
					$str .= 'Te informamos que han escrito desde la sección de <strong>Inscripción de Estudiante Independiente</strong>:<br><br>';
					$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';

					$formInfo = '<strong>IDENTIFICACIÓN DEL PADRE/MADRE O TUTOR</strong><br>';
					$formInfo .= '<strong>Nombre completo:</strong> ' . $nombre_tutor . '<br>';
					$formInfo .= '<strong>Parentesco:</strong> ' . $parentesco . '<br>';
					$formInfo .= '<strong>C.I.:</strong> ' . $estudiante_ci . '<br>';
					$formInfo .= '<strong>Tel&eacute;fono:</strong> ' . $telefono_tutor . '<br>';
					$formInfo .= '<strong>Email:</strong> ' . $email_tutor . '<br>';

					$formInfo .= '<hr/>';

					$formInfo .= '<strong>INFORMACIÓN DEL ESTUDIANTE</strong><br>';
					$formInfo .= '<strong>Nombre completo:</strong> ' . $nombre_estudiante . '<br>';
					$formInfo .= '<strong>Fecha de nacimiento:</strong> ' . $nacimiento_estudiante . '<br>';
					$formInfo .= '<strong>Edad:</strong> ' . $edad_estudiante . '<br>';
					$formInfo .= '<strong>Colegio:</strong> ' . $colegio_estudiante . '<br>';
					$formInfo .= '<strong>Grado:</strong> ' . $grado_estudiante . '<br>';
					$formInfo .= '<strong>Tel&eacute;fono:</strong> ' . $telefono_estudiante . '<br>';
					$formInfo .= '<strong>Email:</strong> ' . $email_estudiante . '<br>';

					$str .= $formInfo . '</div>';
					$str .= '<br>Trata de reponderle lo más pronto posible.';
					$retorna = enviaMailAdmin(MAIL_INFO, 'A Leer Bolivia: Inscripción de Estudiante Independiente', $str, MAIL_WEBMASTER, $file);
					/* WEBMASTER - inicio */

					/* USUARIO - inicio */
					$str = 'Hola,<br><br>';
					$str .= 'Gracias por escribirnos, trateremos de responderte lo más pronto posible.<br><br>';
					$str .= 'Tus datos enviados son:<br><br>';
					$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';
					$str .= $formInfo . '</div>';
					$retorna = enviaMail($email_tutor, 'A Leer Bolivia: Inscripción de Estudiante Independiente', $str, MAIL_WEBMASTER, $file);
					/* USUARIO - fin */

					$valida = 1;
					$rtn = 'Mensaje enviado!';
				} else {
					$valida = 0;
					$rtn = 'Marca la casilla de verificación para confirmar que no eres un robot';
				}
			} else {
				$valida = 0;
				$rtn = 'Ha ocurrido un error, vuelve a intentarlo';
			}

			$rtnResult = array();
			$rtnResult['estado'] = $valida;
			$rtnResult['mensaje'] = $rtn;
			$rtn = json_encode($rtnResult);
			break;

		case 'formRegistroColegio':
			if ($_SERVER["REQUEST_METHOD"] === "POST") {
				$recaptcha_secret = KEY_CAPTCHA_SECRET_V2;
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
				$response = json_decode($response, true);

				if ($response["success"] === true) {
					$nombre_responsable = trim($nombre_responsable);
					$ci_responsable = trim($ci_responsable);
					$cargo_responsable = trim($cargo_responsable);
					$profesion_responsable = trim($profesion_responsable);
					$telefono_responsable = trim($telefono_responsable);
					$email_responsable = trim($email_responsable);
					$nombre_institucion = trim($nombre_institucion);
					$razon_social_institucion = trim($razon_social_institucion);
					$nit_institucion = trim($nit_institucion);
					$direccion_institucion = trim($direccion_institucion);
					$telefono_institucion = trim($telefono_institucion);
					$email_institucion = trim($email_institucion);
					$nombre_colaborador = trim($nombre_colaborador);
					$ci_colaborador = trim($ci_colaborador);
					$cargo_colaborador = trim($cargo_colaborador);
					$profesion_colaborador = trim($profesion_colaborador);
					$telefono_colaborador = trim($telefono_colaborador);
					$email_colaborador = trim($email_colaborador);

					/* WEBMASTER - inicio */
					$str = 'Hola,<br><br>';
					$str .= 'Te informamos que han escrito desde la sección de <strong>Inscripción de Colegios</strong>:<br><br>';
					$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';

					$formInfo = '<strong>RESPONSABLE DEL EVENTO</strong><br>';
					$formInfo .= '<strong>Nombre completo:</strong> ' . $nombre_responsable . '<br>';
					$formInfo .= '<strong>C.I.:</strong> ' . $ci_responsable . '<br>';
					$formInfo .= '<strong>Cargo en la Institución:</strong> ' . $cargo_responsable . '<br>';
					$formInfo .= '<strong>Profesión o Actividad:</strong> ' . $profesion_responsable . '<br>';
					$formInfo .= '<strong>Tel&eacute;fono:</strong> ' . $telefono_responsable . '<br>';
					$formInfo .= '<strong>Email:</strong> ' . $email_responsable . '<br>';

					$formInfo .= '<hr/>';

					$formInfo .= '<strong>DATOS DE LA INSTITUCIÓN</strong><br>';
					$formInfo .= '<strong>Nombre de la Institución:</strong> ' . $nombre_institucion . '<br>';
					$formInfo .= '<strong>Razón Social:</strong> ' . $razon_social_institucion . '<br>';
					$formInfo .= '<strong>NIT:</strong> ' . $nit_institucion . '<br>';
					$formInfo .= '<strong>direccion_institucion:</strong> ' . $direccion_institucion . '<br>';
					$formInfo .= '<strong>Tel&eacute;fono:</strong> ' . $telefono_institucion . '<br>';
					$formInfo .= '<strong>Email:</strong> ' . $email_institucion . '<br>';

					$formInfo .= '<hr/>';

					$formInfo .= '<strong>COLABORADOR ASIGNADO</strong><br>';
					$formInfo .= '<strong>Nombre completo:</strong> ' . $nombre_colaborador . '<br>';
					$formInfo .= '<strong>C.I.:</strong> ' . $ci_colaborador . '<br>';
					$formInfo .= '<strong>Cargo en la institución:</strong> ' . $cargo_colaborador . '<br>';
					$formInfo .= '<strong>Profesión o Actividad:</strong> ' . $profesion_colaborador . '<br>';
					$formInfo .= '<strong>Tel&eacute;fono:</strong> ' . $telefono_colaborador . '<br>';
					$formInfo .= '<strong>Email:</strong> ' . $email_colaborador . '<br>';

					$str .= $formInfo . '</div>';
					$str .= '<br>Trata de reponderle lo más pronto posible.';
					$retorna = enviaMailAdmin(MAIL_INFO, 'A Leer Bolivia: Inscripción de Colegios', $str, MAIL_WEBMASTER, $file);
					/* WEBMASTER - inicio */

					/* USUARIO - inicio */
					$str = 'Hola,<br><br>';
					$str .= 'Gracias por escribirnos, trateremos de responderte lo más pronto posible.<br><br>';
					$str .= 'Tus datos enviados son:<br><br>';
					$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';
					$str .= $formInfo . '</div>';
					$retorna = enviaMail($email_institucion, 'A Leer Bolivia: Inscripción de Colegios', $str, MAIL_WEBMASTER, $file);
					/* USUARIO - fin */

					$valida = 1;
					$rtn = 'Mensaje enviado!';
				} else {
					$valida = 0;
					$rtn = 'Marca la casilla de verificación para confirmar que no eres un robot';
				}
			} else {
				$valida = 0;
				$rtn = 'Ha ocurrido un error, vuelve a intentarlo';
			}

			$rtnResult = array();
			$rtnResult['estado'] = $valida;
			$rtnResult['mensaje'] = $rtn;
			$rtn = json_encode($rtnResult);
			break;

		case 'contacto':
			if ($_SERVER["REQUEST_METHOD"] === "POST") {
				$recaptcha_secret = KEY_CAPTCHA_SECRET_V2;
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
				$response = json_decode($response, true);

				if ($response["success"] === true) {
					$validaEMail = comprobarEmail($email);

					if ($validaEMail['valida'] == 0) {
						$nombre = trim($nombre);
						$apellidos = trim($apellidos);
						$mensaje = trim($mensaje);

						/* WEBMASTER - inicio */
						$str = 'Hola,<br><br>';
						$str .= 'Te informamos que han escrito desde la sección de <strong>Contacto</strong> el siguiente mensaje:<br><br>';
						$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';
						$str .= '<strong>Nombre:</strong> ' . $nombre . '<br>';
						$str .= '<strong>Apellidos:</strong> ' . $apellidos . '<br>';
						$str .= '<strong>Email:</strong> ' . $email . '<br>';
						$str .= '<strong>Tel&eacute;fono:</strong> ' . $fono . '<br>';
						$str .= '<strong>Ciudad:</strong> ' . $ciudad . '<br>';
						$str .= '<strong>País:</strong> ' . $pais . '<br>';

						$str .= '<strong>Mensaje:</strong> <br>' . $mensaje;
						$str .= '</div>';
						$str .= '<br>Trata de reponderle lo más pronto posible.';
						$retorna = enviaMailAdmin(MAIL_INFO, 'Mensaje de contacto', $str);
						/* WEBMASTER - inicio */

						/* USUARIO - inicio */
						$str = 'Hola ' . $nombre . ',<br><br>';
						$str .= 'Gracias por escribirnos, trateremos de responderte lo más pronto posible.<br><br>';
						$str .= 'Tus datos enviados son:<br><br>';
						$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';
						$str .= '<strong>Tel&eacute;fono:</strong> ' . $fono . '<br>';
						$str .= '<strong>Ciudad:</strong> ' . $ciudad . '<br>';
						$str .= '<strong>País:</strong> ' . $pais . '<br>';
						$str .= '<strong>Mensaje:</strong> <br>' . $mensaje;
						$str .= '</div>';
						$retorna = enviaMail($email, 'Mensaje de contacto', $str);
						/* USUARIO - fin */

						$rst = insertData(
							'resultado',
							array(
								'resnom' => $nombre . "|" . $apellidos,
								'resmail' => $email,
								'restele' => $fono,
								'resciud' => $ciudad,
								'respais' => $pais,
								'rescat' => 'GRAL',
								'restipo' => 'MSJ',
								'reslect' => 'CONTACTO',
								'rescant' => '0',
								'restime' => '0',
								'restmres' => '0',
								'rescomp' => '0',
								'resvel' => '0',
								'rescom' => $mensaje
							)
						);

						$valida = 1;
						$rtn = 'Mensaje enviado!';
					} else {
						$valida = $validaEMail['valida'];
						$rtn = $validaEMail['mensaje'];
					}
				} else {
					$valida = 0;
					$rtn = 'Marca la casilla de verificación para confirmar que no eres un robot';
				}
			} else {
				$valida = 0;
				$rtn = 'Ha ocurrido un error, vuelve a intentarlo';
			}

			$rtnResult = array();
			$rtnResult['estado'] = $valida;
			$rtnResult['mensaje'] = $rtn;
			$rtn = json_encode($rtnResult);
			break;

		case 'contacto2':
			if ($_SERVER["REQUEST_METHOD"] === "POST") {
				$recaptcha_secret = KEY_CAPTCHA_SECRET_V2;
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
				$response = json_decode($response, true);

				if ($response["success"] === true) {
					$validaEMail = comprobarEmail($email);

					if ($validaEMail['valida'] == 0) {
						$nombre = trim($nombre);
						$apellidos = trim($apellidos);
						$mensaje = trim($mensaje);

						$nombre_pru = trim($nombre_pru);
						$apepa_pru = trim($apepa_pru);
						$apema_pru = trim($apema_pru);

						/* WEBMASTER - inicio */
						$str = 'Hola,<br><br>';
						$str .= 'Te informamos que han escrito desde la sección de <strong>Contacto</strong> el siguiente mensaje:<br><br>';
						$str .= '<div style="border-left:3px solid #999; line-height: 20px; padding-left:10px">';
						$str .= '<strong>Nombre:</strong> ' . $nombre . '<br>';
						$str .= '<strong>Apellidos:</strong> ' . $apellidos . '<br>';
						$str .= '<strong>N° de cédula:</strong> ' . $dni . '<br>';
						$str .= '<strong>Fecha de nacimiento:</strong> ' . $fnac . '<br>';
						$str .= '<strong>Edad:</strong> ' . $edad . '<br>';
						$str .= '<strong>Tel&eacute;fono:</strong> ' . $fono . '<br>';
						$str .= '<strong>Email:</strong> ' . $email . '<br>';
						$str .= '<strong>Ciudad:</strong> ' . $ciudad . '<br>';
						$str .= '<strong>País:</strong> ' . $pais . '<br><br>';

						$str .= '<strong>Prueba gratuita para:</strong><br>';
						$str .= '<strong>Nombres:</strong> ' . $nombre_pru . '<br>';
						$str .= '<strong>Apellido paterno:</strong> ' . $apepa_pru . '<br>';
						$str .= '<strong>Apellido materno:</strong> ' . $apema_pru . '<br>';
						$str .= '<strong>N° de cédula:</strong> ' . $dni_pru . '<br>';
						$str .= '<strong>Fecha de nacimiento:</strong> ' . $fnac_pru . '<br>';
						$str .= '<strong>Edad:</strong> ' . $edad_pru . '<br>';
						$str .= '<strong>Tel&eacute;fono:</strong> ' . $fono_pru . '<br>';
						$str .= '<strong>Email:</strong> ' . $email_pru . '<br>';
						$str .= '<strong>Ciudad:</strong> ' . $ciudad_pru . '<br>';
						$str .= '<strong>País:</strong> ' . $pais_pru . '<br>';

						$str .= '</div>';
						$str .= '<br>Trata de reponderle lo más pronto posible.';
						$retorna = enviaMailAdmin(MAIL_INFO, 'Mensaje de contacto (Prueba gratuita)', $str);
						/* WEBMASTER - inicio */

						/* USUARIO - inicio */
						$str = 'Hola ' . $nombre . ',<br><br>';
						$str .= 'Gracias por escribirnos, trateremos de responderte lo más pronto posible.<br><br>';
						$retorna = enviaMail($email, 'Mensaje de contacto (Prueba gratuita)', $str);
						/* USUARIO - fin */

						$rst = insertData(
							'resultado',
							array(
								'resnom' => $nombre,
								'resmail' => $email,
								'restele' => $fono,
								'resciud' => $ciudad,
								'respais' => $pais,
								'rescat' => 'GRAL',
								'restipo' => 'MSJ',
								'reslect' => 'CONTACTO-PRUEBA-GRATUITA',
								'rescant' => '0',
								'restime' => '0',
								'restmres' => '0',
								'rescomp' => '0',
								'resvel' => '0',
								'rescom' => ''
							)
						);

						$valida = 1;
						$rtn = 'Mensaje enviado!';
					} else {
						$valida = $validaEMail['valida'];
						$rtn = $validaEMail['mensaje'];
					}
				} else {
					$valida = 0;
					$rtn = 'Marca la casilla de verificación para confirmar que no eres un robot';
				}
			} else {
				$valida = 0;
				$rtn = 'Ha ocurrido un error, vuelve a intentarlo';
			}

			$rtnResult = array();
			$rtnResult['estado'] = $valida;
			$rtnResult['mensaje'] = $rtn;
			$rtn = json_encode($rtnResult);
			break;

		case 'testiq':
			require_once ('../require/transacciones.php');

			$estado = 0;
			$mensaje = "Se ha producido un error interno, por favor vuelve a intentarlo.";

			if (isset($edad) and $edad != "") {
				$classObj = new ClssTestiQ();
				$edad = $classObj->getEdad($edad);
				$ctaRespOk = 0;
				$ctaRespKo = 0;

				$serieArrs = array();
				$opt = array();

				foreach ($alternativa as $pregunta => $respuestas) {
					$opt[] = explode('|', $respuestas);
				}

				$x = 0;
				$arrFin = array();
				foreach ($opt as $k => $rspta) {
					if ($rspta['2'] == sha1(md5(1))) {
						$ctaRespOk++;
					} else {
						$ctaRespKo++;
					}

					if (!isset($opt[$x + 1][3])) {
						$opt[$x + 1][3] = 0;
					}

					if ($rspta[3] != $opt[$x + 1][3]) {
						$serieArrs[$rspta[3]] = array('ok' => $ctaRespOk, 'ko' => $ctaRespKo);
						$arrFin[] = $serieArrs;
						$ctaRespOk = 0;
						$ctaRespKo = 0;
					}
					$x++;
				}

				$rsptaFinal = max(array_keys($arrFin));

				/* MPC */
				if ($tipoTest == 1) {
					$rsptaOkMPCSerie1 = $arrFin[$rsptaFinal][1]['ok'];
					$rsptaKoMPCSerie1 = $arrFin[$rsptaFinal][1]['ko'];

					$rsptaOkMPCSerie2 = $arrFin[$rsptaFinal][2]['ok'];
					$rsptaKoMPCSerie2 = $arrFin[$rsptaFinal][2]['ko'];

					$rsptaOkMPCSerie3 = $arrFin[$rsptaFinal][3]['ok'];
					$rsptaKoMPCSerie3 = $arrFin[$rsptaFinal][3]['ko'];

					$totalOk = $rsptaOkMPCSerie1 + $rsptaOkMPCSerie2 + $rsptaOkMPCSerie3;
					$totalKo = $rsptaKoMPCSerie1 + $rsptaKoMPCSerie2 + $rsptaKoMPCSerie3;
				}

				/* MPG */
				if ($tipoTest == 2) {
					$rsptaOkMPGSerie1 = $arrFin[$rsptaFinal][4]['ok'];
					$rsptaKoMPGSerie1 = $arrFin[$rsptaFinal][4]['ko'];

					$rsptaOkMPGSerie2 = $arrFin[$rsptaFinal][5]['ok'];
					$rsptaKoMPGSerie2 = $arrFin[$rsptaFinal][5]['ko'];

					$rsptaOkMPGSerie3 = $arrFin[$rsptaFinal][6]['ok'];
					$rsptaKoMPGSerie3 = $arrFin[$rsptaFinal][6]['ko'];

					$rsptaOkMPGSerie4 = $arrFin[$rsptaFinal][7]['ok'];
					$rsptaKoMPGSerie4 = $arrFin[$rsptaFinal][7]['ko'];

					$rsptaOkMPGSerie5 = $arrFin[$rsptaFinal][8]['ok'];
					$rsptaKoMPGSerie5 = $arrFin[$rsptaFinal][8]['ko'];

					$totalOk = $rsptaOkMPGSerie1 + $rsptaOkMPGSerie2 + $rsptaOkMPGSerie3 + $rsptaOkMPGSerie4 + $rsptaOkMPGSerie5;
					$totalKo = $rsptaKoMPGSerie1 + $rsptaKoMPGSerie2 + $rsptaKoMPGSerie3 + $rsptaKoMPGSerie4 + $rsptaKoMPGSerie5;
				}

				/* MPA */
				if ($tipoTest == 3) {
					$rsptaOkMPASerie1 = $arrFin[$rsptaFinal][9]['ok'];
					$rsptaKoMPASerie1 = $arrFin[$rsptaFinal][9]['ko'];

					$rsptaOkMPASerie2 = $arrFin[$rsptaFinal][10]['ok'];
					$rsptaKoMPASerie2 = $arrFin[$rsptaFinal][10]['ko'];

					$rsptaOkMPASerie3 = $arrFin[$rsptaFinal][11]['ok'];
					$rsptaKoMPASerie3 = $arrFin[$rsptaFinal][11]['ko'];

					$rsptaOkMPASerie4 = $arrFin[$rsptaFinal][12]['ok'];
					$rsptaKoMPASerie4 = $arrFin[$rsptaFinal][12]['ko'];

					$totalOk = $rsptaOkMPASerie1 + $rsptaOkMPASerie2 + $rsptaOkMPASerie3 + $rsptaOkMPASerie4;
					$totalKo = $rsptaKoMPASerie1 + $rsptaKoMPASerie2 + $rsptaKoMPASerie3 + $rsptaKoMPASerie4;
				}

				/* calculo */
				$estado = 1;
				$mensaje = "";
				$mensaje .= "<div class='titulo'><h3>¡Test completado!</h3></div>";
				$mensaje .= "<p>Gracias por realizar el Test, a continuación te indicamos tu puntaje:</p>";
				$mensaje .= "<p><strong>Respuestas correctas:</strong> " . $totalOk . "/" . $totalKo . "</p>";

				$datosPercentil = $classObj->getPercentil($edad, $totalOk, $totalKo);
				$datoPercentil = $datosPercentil['result'][0];
				$percentil = ($datoPercentil['valor'] != "") ? $datoPercentil['valor'] : 0;
				$detalle = ($datoPercentil['detalle'] != "") ? $datoPercentil['detalle'] : 'no se pudo calcular';

				$mensaje .= "<p><strong>Percentil:</strong> " . $percentil . "</p>";
				$mensaje .= "<p><strong>Cociente intelectual:</strong> " . $detalle . "</p><br><br>";
				$mensaje .= "<div class='botonera' >";
				$mensaje .= "<button id='btn-restart' name='btn-restart' type='button' onclick='javascript:location.reload()' >Volver a realizar el Test</button>";
				$mensaje .= " </div>";
			} else {
				$mensaje = "Por favor ingresa tu edad.";
			}

			$rtnResult = array();
			$rtnResult['estado'] = $estado;
			$rtnResult['mensaje'] = $mensaje;
			$rtn = json_encode($rtnResult);
			break;

		case 'lectura':

			if ($_SERVER["REQUEST_METHOD"] === "POST") {
				$recaptcha_secret = KEY_CAPTCHA_SECRET_V2;
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
				$response = json_decode($response, true);

				if ($response["success"] === true) {
					$mensajeUsu = '';

					($tipoPersonaForm == 'ninho') ? $tipoPersonaForm = 'NIÑO' : $tipoPersonaForm = strtoupper($tipoPersonaForm);

					//TO USUARIO
					$mensaje = 'Hola ' . $nombreTest . ', <br/><br/>';
					$mensaje .= 'Hemos verificado tus respuestas y éste es el resultado de tu Test: <br/><br/>';
					$mensajeUsu .= 'Este es el resultado de tu Test: <br/><br/>';
					$mensaje .= '<b>IDENTIFICADO COMO: </b>' . $tipoPersonaForm . '<br/>';
					$mensaje .= '<b>TIPO DE TEST: </b>' . strtoupper($tipoTestForm) . '<br/>';
					$mensajeUsu .= '<b>TIPO DE TEST: </b>' . strtoupper($tipoTestForm) . '<br/>';
					$mensaje .= '<b>LECTURA: </b>' . $nomLecturaForm . '<br/>';
					$mensajeUsu .= '<b>LECTURA: </b>' . $nomLecturaForm . '<br/>';
					$mensaje .= '<b>CANTIDAD DE PALABRAS: </b>' . $cantPalabrasForm . '<br/>';
					$mensajeUsu .= '<b>CANT. DE PALABRAS: </b>' . $cantPalabrasForm . '<br/>';
					$mensaje .= '<b>TIEMPO DE LECTURA: </b>' . $tiempoLecturaForm . '<br/>';
					$mensajeUsu .= '<b>TIEMPO DE LECTURA: </b>' . $tiempoLecturaForm . '<br/>';

					$rsptasOk = explode(",", $respuestasOkForm);
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

					$mensaje .= '<b>TU COMPRENSIÓN ES DEL: </b>' . $porcentajeComprension . '%<br/>';
					$mensajeUsu .= '<b>TU COMPRENSIÓN ES DEL: </b>' . $porcentajeComprension . '%<br/>';

					$ctaLecturaTiempo = explode(':', $tiempoLecturaForm);
					$divPalabras = ((ltrim($ctaLecturaTiempo[0], '0') * 60) + ltrim($ctaLecturaTiempo[1], '0'));

					$divPalabras = ($divPalabras == 0) ? 1 : $divPalabras;
					$totalCantPalabras = $cantPalabrasForm / $divPalabras;

					$mensaje .= '<b>TU VELOCIDAD ES: </b>' . number_format($totalCantPalabras * 60, 0) . ' PALABRAS POR MINUTO<br/>';
					$mensajeUsu .= '<b>TU VELOCIDAD ES: </b>' . number_format($totalCantPalabras * 60, 0) . ' PALABRAS POR MINUTO<br/>';

					if ($comentarioTest != "") {
						$mensaje .= '<b>TU COMENTARIO ES: </b>' . nl2br($comentarioTest) . '<br/>';
					}

					$objMsje = array();
					$objMsje['texto'] = $mensaje;
					$objMsje['contacto'] = TRUE;
					$objMsje['tipo'] = 'TEST';

					$rtn = enviaMail($emailTest, 'Resultado de Test', $objMsje);

					//TO CTEX
					$mensaje = 'Hola, <br/><br/>';
					$mensaje .= 'Han realizado un Test: <br/><br/>';
					$mensaje .= '<b>NOMBRE Y APELLIDO: </b>' . $nombreTest . '<br/>';
					$mensaje .= '<b>EMAIL: </b>' . $emailTest . '<br/>';
					$mensaje .= '<b>EDAD: </b>' . $edadTest . '<br/>';
					$mensaje .= '<b>TELÉFONO: </b>' . $fonoTest . '<br/>';
					$mensaje .= '<b>CIUDAD: </b>' . $ciudadTest . '<br/>';
					$mensaje .= '<b>IDENTIFICADO COMO: </b>' . $tipoPersonaForm . '<br/>';
					$mensaje .= '<b>TIPO DE TEST: </b>' . strtoupper($tipoTestForm) . '<br/>';
					$mensaje .= '<b>LECTURA: </b>' . $nomLecturaForm . '<br/>';
					$mensaje .= '<b>CANTIDAD DE PALABRAS: </b>' . $cantPalabrasForm . '<br/>';
					$mensaje .= '<b>TIEMPO DE LECTURA: </b>' . $tiempoLecturaForm . '<br/>';
					$mensaje .= '<b>TIEMPO DE RESPUESTA DEL CUESTIONARIO: </b>' . $tiempoRespuestasForm . '<br/>';
					$mensaje .= '<b>SU COMPRENSIÓN ES DEL: </b>' . $porcentajeComprension . '%<br/>';
					$mensaje .= '<b>SU VELOCIDAD ES: </b>' . number_format($totalCantPalabras * 60, 0) . ' PALABRAS POR MINUTO<br/>';

					if ($comentarioTest != "") {
						$mensaje .= '<b>SU COMENTARIO ES: </b>' . nl2br($comentarioTest) . '<br/>';
					}

					$rst = insertData(
						'resultado',
						array(
							'resnom' => $nombreTest,
							'edad' => $edadTest,
							'resmail' => $emailTest,
							'restele' => $fonoTest,
							'resciud' => $ciudadTest,
							'respais' => 'BOLIVIA',
							'rescat' => $tipoPersonaForm,
							'restipo' => 'LECTURA',
							'reslect' => $nomLecturaForm,
							'rescant' => $cantPalabrasForm,
							'restime' => $tiempoLecturaForm,
							'restmres' => $tiempoRespuestasForm,
							'rescomp' => $porcentajeComprension,
							'resvel' => number_format($totalCantPalabras * 60, 0),
							'rescom' => $comentarioTest,
							'ressoy' => $soyTest,
							'rescarrera' => $carreraTest,
							'ressemestre' => $semestreTest,
							'resinstitucion' => $institucionTest,
						)
					);

					$objMsje = array();
					$objMsje['texto'] = $mensaje;
					$objMsje['contacto'] = FALSE;
					$objMsje['tipo'] = 'TEST';

					$rtnVal = array();
					$rtnVal = enviaMailAdmin(MAIL_INFO, 'Resultado de Test', $objMsje);
					$rtnVal = json_decode($rtnVal);

					$rtnResult = array();
					if ($rtnVal->{'estado'} == 1) {
						$rtnResult['mensaje'] = $mensajeUsu;
						$rtnResult['valor1'] = $porcentajeComprension . "%";
						$rtnResult['valor2'] = number_format($totalCantPalabras * 60, 0) . ' palabras por minuto';
						$rtnResult['valor3'] = 'Lectura y nivel de comprensión';
						$rtnResult['estado'] = 1;
					} else {
						$error = $rtnVal->{'mensaje'};
						$rtnResult['mensaje'] = $error;
						$rtnResult['valor1'] = 0;
						$rtnResult['valor2'] = 0;
						$rtnResult['valor3'] = '';
						$rtnResult['estado'] = 0;
					}
				} else {
					$rtnResult['estado'] = 0;
					$rtnResult['mensaje'] = 'Marca la casilla de verificación para confirmar que no eres un robot';
				}
			} else {
				$rtnResult['estado'] = 0;
				$rtnResult['mensaje'] = 'Ha ocurrido un error, vuelve a intentarlo';
			}

			$rtn = json_encode($rtnResult);
			break;

		case 'razonamiento':

			if ($_SERVER["REQUEST_METHOD"] === "POST") {
				$recaptcha_secret = KEY_CAPTCHA_SECRET_V2;
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" . $_POST['g-recaptcha-response']);
				$response = json_decode($response, true);

				if ($response["success"] === true) {
					($tipoPersonaForm == 'ninho') ? $tipoPersonaForm = 'NIÑO' : $tipoPersonaForm = strtoupper($tipoPersonaForm);

					$mensajeUsu = '';

					//TO USUARIO
					$mensaje = 'Hola ' . $nombreTest . ', <br/><br/>';
					$mensaje .= 'Hemos verificado tus respuestas y éste es el resultado de tu Test: <br/><br/>';
					$mensajeUsu .= 'Este es el resultado de tu Test: <br/><br/>';
					$mensaje .= '<b>IDENTIFICADO COMO: </b>' . $tipoPersonaForm . '<br/>';
					$mensaje .= '<u>' . $nomLecturaForm . '</u><br/>';

					$rsptasOk = explode(",", $respuestasOkForm);
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

					$mensaje .= '<b>TU RAZONAMIENTO ES DEL: </b>' . $porcentajeComprension . '%<br/>';
					$mensajeUsu .= '<b>TU RAZONAMIENTO ES DEL: </b>' . $porcentajeComprension . '%<br/>';

					if ($comentarioTest != "") {
						$mensaje .= '<b>TU COMENTARIO ES: </b>' . nl2br($comentarioTest) . '<br/>';
					}

					$objMsje = array();
					$objMsje['texto'] = $mensaje;
					$objMsje['contacto'] = TRUE;
					$objMsje['tipo'] = 'TEST';

					$rtn = enviaMail($emailTest, 'Resultado de Test', $objMsje);

					//TO CTEX
					$mensaje = 'Hola, <br/><br/>';
					$mensaje .= 'Han realizado un Test: <br/><br/>';
					$mensaje .= '<b>NOMBRE Y APELLIDO: </b>' . $nombreTest . '<br/>';
					$mensaje .= '<b>EDAD: </b>' . $edadTest . '<br/>';
					$mensaje .= '<b>EMAIL: </b>' . $emailTest . '<br/>';
					$mensaje .= '<b>TELÉFONO: </b>' . $fonoTest . '<br/>';
					$mensaje .= '<b>CIUDAD: </b>' . $ciudadTest . '<br/>';
					$mensaje .= '<b>IDENTIFICADO COMO: </b>' . $tipoPersonaForm . '<br/>';
					$mensaje .= '<b>TIEMPO DE RESPUESTA DEL CUESTIONARIO: </b>' . $tiempoRespuestasForm . '<br/>';
					$mensaje .= '<b>SU RAZONAMIENTO ES DEL: </b>' . $porcentajeComprension . '%<br/>';

					if ($comentarioTest != "") {
						$mensaje .= '<b>SU COMENTARIO ES: </b>' . nl2br($comentarioTest) . '<br/>';
					}

					$rst = insertData(
						'resultado',
						array(
							'resnom' => $nombreTest,
							'edad' => $edadTest,
							'resmail' => $emailTest,
							'restele' => $fonoTest,
							'resciud' => $ciudadTest,
							'respais' => 'BOLIVIA',
							'rescat' => $tipoPersonaForm,
							'restipo' => 'RAZONA',
							'reslect' => '',
							'rescant' => '',
							'restime' => '',
							'restmres' => $tiempoRespuestasForm,
							'rescomp' => $porcentajeComprension,
							'resvel' => '',
							'rescom' => $comentarioTest,
							'ressoy' => $soyTest,
							'rescarrera' => $carreraTest,
							'ressemestre' => $semestreTest,
							'resinstitucion' => $institucionTest,
						)
					);

					$objMsje = array();
					$objMsje['texto'] = $mensaje;
					$objMsje['contacto'] = FALSE;
					$objMsje['tipo'] = 'TEST';

					$rtnVal = array();
					$rtnVal = enviaMailAdmin(MAIL_INFO, 'Resultado de Test', $objMsje);
					$rtnVal = json_decode($rtnVal);

					$rtnResult = array();
					if ($rtnVal->{'estado'} == 1) {
						$rtnResult['mensaje'] = $mensajeUsu;
						$rtnResult['valor1'] = $porcentajeComprension . '%';
						$rtnResult['valor2'] = $tiempoRespuestasForm . ' en tiempo de respuesta';
						$rtnResult['valor3'] = 'Razonamiento';
						$rtnResult['estado'] = 1;
					} else {
						$error = $rtnVal->{'mensaje'};
						$rtnResult['mensaje'] = $error;
						$rtnResult['valor1'] = 0;
						$rtnResult['valor2'] = 0;
						$rtnResult['valor3'] = '';
						$rtnResult['estado'] = 0;
					}
				} else {
					$rtnResult['estado'] = 0;
					$rtnResult['mensaje'] = 'Marca la casilla de verificación para confirmar que no eres un robot';
				}
			} else {
				$rtnResult['estado'] = 0;
				$rtnResult['mensaje'] = 'Ha ocurrido un error, vuelve a intentarlo';
			}

			$rtn = json_encode($rtnResult);

			break;

		case 'cerebro':

			$mensajeUsu = '';

			//TO USUARIO
			$mensaje = 'Hola ' . $nombreTest . ', <br/><br/>';
			$mensaje .= 'Hemos verificado tus respuestas y éste es el resultado de tu Test: <br/><br/>';
			$mensaje .= '<b>HEMISFERIO IZQUIERDO: </b>' . $izquierdo . '%<br/>';
			$mensaje .= '<b>HEMISFERIO DERECHO: </b>' . $derecho . '%<br/>';
			$mensaje .= '<b style="text-align:center">' . $txtResultado . '</b><br/>';
			$mensaje .= '<div class="explaination test" id="explaination">';
			$mensaje .= ' <div class="row">';
			$mensaje .= ' <div class="col-md-10 col-md-offset-1 text-left mtop50">';
			$mensaje .= '      <span class="headexplain">Pregunta 1:</span>';
			$mensaje .= '      <span class="headtitle">bailarina</span>';
			$mensaje .= '    </div>  </div>';
			$mensaje .= '  <div class="row text-left mtop20">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/taenzerin.gif"/>';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '      Según funcione su cerebro, la bailarina girará hacia la izquierda o hacia la derecha. Si gira hacia la derecha, significa que utiliza predominantemente el lado derecho de su cerebro; además, tiene más posibilidades de ser diestro.';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row">';
			$mensaje .= '    <div class="col-md-10 col-md-offset-1 text-left mtop20">';
			$mensaje .= '      <span class="headexplain">Pregunta 2: </span>';
			$mensaje .= '      <span class="headtitle">Test de color</span>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/explain_farben.png"/>';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '     Conflicto:El lado derecho del cerebro quiere elegir el color que concuerda con la palabra, mientras que el izquierdo quiere elegir la palabra escrita. Si comete un error, es debido a la acción del lado izquierdo del cerebro.';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row">';
			$mensaje .= '    <div class="col-md-10 col-md-offset-1 text-left mtop20">';
			$mensaje .= '      <span class="headexplain">Pregunta 3: </span>';
			$mensaje .= '      <span class="headtitle">dibujo</span>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/figur01.png">';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '      <h5>Respuesta A:</h5>';
			$mensaje .= '      <p>';
			$mensaje .= '        Si ha elegido este dibujo, el lado izquierdo de su cerebro es más dominante. Esto es debido a que el círculo tiene una forma simple y reconocible que es más fácil de definir.';
			$mensaje .= '      </p>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/figur02.png">';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '      <h5>Respuesta B:</h5>';
			$mensaje .= '      <p>';
			$mensaje .= '        Esta forma es un punto intermedio entre la simplicidad del primer dibujo y la complejidad de la respuesta C. La figura es más compleja y fascinante, aunque autónoma. Por tanto, es elegida mayoritariamente por gente cuyas mitades cerebrales dominan por igual.';
			$mensaje .= '      </p>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/figur03.png">';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '     <h5>Respuesta C:</h5>';
			$mensaje .= '      <p>';
			$mensaje .= '        Si ha elegido este dibujo, el lado derecho de su cerebro es más dominante. La figura aparece incompleta, sin forma o dirección. Ofrece la posibilidad de desarrollo.';
			$mensaje .= '      </p>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div><div class="row">';
			$mensaje .= '    <div class="col-md-10 col-md-offset-1 text-left mtop20">';
			$mensaje .= '      <span class="headexplain">Pregunta 4:</span>';
			$mensaje .= '      <span class="headtitle">Parecido a</span>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/passen01.png">';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '      <h5>Respuesta A:</h5>';
			$mensaje .= '      <p>';
			$mensaje .= '        Aquí, las figuras también son iguales en tamaño. Sin embargo, difieren ampliamente en color. El factor visual es el resultado de la dominancia del lado izquierdo del cerebro.';
			$mensaje .= '      </p>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/passen02.png">';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '      <h5>Respuesta B:</h5>';
			$mensaje .= '      <p>';
			$mensaje .= '        Las figuras son iguales en tamaño y relativamente iguales en color. Si ha elegido la respuesta A, el lado derecho de su cerebro es más dominante.';
			$mensaje .= '      </p>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/passen03.png">';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '      <h5>Respuesta C:</h5>';
			$mensaje .= '      <p>';
			$mensaje .= '        Aquí, el dibujo original estaba fragmentado. Si ha elegido esta respuesta, el lado derecho de su cerebro es más dominante.';
			$mensaje .= '      </p>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row">';
			$mensaje .= '    <div class="col-md-10 col-md-offset-1 text-left mtop20">';
			$mensaje .= '      <span class="headexplain">Pregunta 5:</span>';
			$mensaje .= '      <span class="headtitle">amistad</span>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/freundschaft01.png">';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '      <h5>Respuesta A:</h5>';
			$mensaje .= '      <p>';
			$mensaje .= '        Los círculos en esta figura están agrupados holgadamente, aunque no de manera completamente desestructurada. Si ha elegido esta respuesta, ningún lado de su cerebro domina con claridad.';
			$mensaje .= '      </p>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/freundschaft02.png">';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '      <h5>Respuesta B:</h5>';
			$mensaje .= '      <p>        La disposición de los círculos en esta imagen es la que se espera típicamente de un circulo de amigos. Este factor visual es el resultado de la dominancia del lado izquierdo del cerebro.';
			$mensaje .= '      </p>';
			$mensaje .= '    </div>';
			$mensaje .= '  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <img class="img-responsive col-md-3 col-md-offset-1" src="citex.bo/img/freundschaft03.png">';
			$mensaje .= '    <div class="col-md-7">';
			$mensaje .= '      <h5>Respuesta C:</h5>';
			$mensaje .= '      <p>        En esta imagen, los círculos están igualmente distantes entre sí. La respuesta C es elegida con más frecuencia por aquellos cuya parte derecha del cerebro es dominante.      </p>   </div>  </div>';
			$mensaje .= '  <div class="row">';
			$mensaje .= '    <div class="col-md-10 col-md-offset-1 text-left mtop20">';
			$mensaje .= '      <span class="headexplain">Preguntas 6, 7 y 8:</span>    </div>  </div>';
			$mensaje .= '  <div class="row text-left mtop10">';
			$mensaje .= '    <div class="col-md-10 col-md-offset-1">';
			$mensaje .= '      <p>Si el lado derecho es dominante, utilizará la mano izquierda, la pierna izquierda o el ojo izquierdo.</p>';
			$mensaje .= '      <p>Si el lado izquierdo es dominante, utilizará la mano derecha, la pierna derecha o el ojo derecho. En estos casos, el lado derecho del cuerpo es controlado por el lado izquierdo del cerebro, y viceversa.</p>    </div>  </div>';

			//fin
			$objMsje = array();
			$objMsje['texto'] = $mensaje;
			$objMsje['contacto'] = TRUE;
			$objMsje['tipo'] = 'TEST';

			$rtn = enviaMail($emailTest, 'Resultado de Test', $objMsje);

			//TO CTEX
			$mensaje = 'Hola, <br/><br/>';
			$mensaje .= 'Han realizado un Test: <br/><br/>';
			$mensaje .= '<b>TEST: </b>CEREBRAL<br/>';
			$mensaje .= '<b>NOMBRE Y APELLIDO: </b>' . $nombreTest . '<br/>';
			$mensaje .= '<b>EDAD: </b>' . $edadTest . '<br/>';
			$mensaje .= '<b>EMAIL: </b>' . $emailTest . '<br/>';
			$mensaje .= '<b>TELÉFONO: </b>' . $fonoTest . '<br/>';
			$mensaje .= '<b>CIUDAD: </b>' . $ciudadTest . '<br/>';

			if ($comentarioTest != "") {
				$mensaje .= '<b>SU COMENTARIO ES: </b>' . nl2br($comentarioTest) . '<br/>';
			}

			$mensaje .= '<b>HEMISFERIO IZQUIERDO: </b>' . $izquierdo . '%<br/>';
			$mensaje .= '<b>HEMISFERIO DERECHO: </b>' . $derecho . '%<br/>';

			$rst = insertData(
				'resultado',
				array(
					'resnom' => $nombreTest,
					'edad' => $edadTest,
					'resmail' => $emailTest,
					'restele' => $fonoTest,
					'resciud' => $ciudadTest,
					'respais' => 'BOLIVIA',
					'rescat' => 'GRAL',
					'restipo' => 'TEST_CEREBRAL',
					'reslect' => 'TEST CEREBRAL',
					'rescant' => '0',
					'restime' => '0',
					'restmres' => '0',
					'rescomp' => '0',
					'resvel' => '0',
					'rescom' => $comentarioTest,
					'ressoy' => $soyTest,
					'rescarrera' => $carreraTest,
					'ressemestre' => $semestreTest,
					'resinstitucion' => $institucionTest,
				)
			);

			$objMsje = array();
			$objMsje['texto'] = $mensaje;
			$objMsje['contacto'] = FALSE;
			$objMsje['tipo'] = 'TEST';

			$rtnVal = array();
			$rtnVal = enviaMailAdmin(MAIL_INFO, 'Resultado de Test', $objMsje);
			$rtnVal = json_decode($rtnVal);
			$rtnResult = array();

			if ($rtnVal->{'estado'} == 1) {
				$rtnResult['mensaje'] = $mensajeUsu;
				$rtnResult['valor1'] = $izquierdo;
				$rtnResult['valor2'] = $derecho;
				$rtnResult['valor3'] = 'Cerebral';
				$rtnResult['estado'] = 1;
			} else {
				$error = $rtnVal->{'mensaje'};
				$rtnResult['mensaje'] = $error;
				$rtnResult['valor1'] = 0;
				$rtnResult['valor2'] = 0;
				$rtnResult['valor3'] = '';
				$rtnResult['estado'] = 0;
			}

			$rtn = json_encode($rtnResult);

			break;

		default:
			break;
	}
}

echo $rtn;
?>