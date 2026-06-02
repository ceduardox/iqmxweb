<?php
class ClssLandingPrice
{
	function detail()
	{
		$sql = "SELECT * 
				FROM  landing_prices 
				WHERE  landing_id = 1 ";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssLandingFAQ
{
	function lista()
	{
		$sql = "SELECT * 
				FROM  landing_faqs 
				WHERE  isDeleted = 0 AND  landing_id = 1";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssTestimonios
{
	function lista()
	{
		$sql = "SELECT * 
				FROM  video 
				WHERE estado = 1 AND  slug = 'testimonios' AND active = 1";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssALeerBoliviaFicha
{
	function lista($type)
	{
		$sql = "SELECT * 
				FROM  a_leer_bolivia_ficha 
				WHERE estado = 1 AND active = 1 and type = '" . $type . "'";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssALeerBoliviaTestimonios
{
	function lista()
	{
		$sql = "SELECT * 
				FROM  a_leer_bolivia_testimonio 
				WHERE estado = 1 AND active = 1";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssALeerBoliviaLogos
{
	function lista($type)
	{
		$sql = "SELECT * 
				FROM  a_leer_bolivia_logos 
				WHERE estado = 1 AND active = 1 AND type = '" . $type . "'";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssLandingTestimonio
{
	function lista()
	{
		$sql = "SELECT * 
				FROM  landing_testimonials 
				WHERE  isDeleted = 0 AND  landing_id = 1";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssLanding
{
	function detail()
	{
		$sql = "SELECT * 
				FROM  landing 
				WHERE isActive = 1 and isDeleted = 0 ";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssPushNotification
{
	function lista()
	{
		$sql = "SELECT * 
				FROM  push_notification_token 
				WHERE  active = 1 ORDER BY created_at DESC";
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function deactivate($token, $detail)
	{
		$rst = updateData(
			'push_notification_token',
			array(
				'detail' => $detail,
				'active' => 0,
				'updated_at' => date('Y-m-d H:i:s')
			),
			array('token' => $token)
		);
		return $rst;
	}

	function create($token, $deviceInfo)
	{
		$rst = true;
		$exists = selectRowData('push_notification_token', '*', array('token' => $token));
		if (!$exists) {
			// if not exists, create it
			$rst = insertData(
				'push_notification_token',
				array(
					'token' => $token,
					'deviceInfo' => $deviceInfo,
					'active' => 1,
					'created_at' => date('Y-m-d H:i:s')
				)
			);
		}
		return $rst;
	}

	function dispatch($receipt_id, $status, $push_notification_message_id)
	{
		$rst = insertData(
			'push_notification_dispatch',
			array(
				'receipt_id' => $receipt_id,
				'status' => $status,
				'push_notification_message_id' => $push_notification_message_id,
				'created_at' => date('Y-m-d H:i:s')
			)
		);
		return $rst;
	}

	function getMessage($messageId)
	{
		$rst = selectRowData('push_notification_message', '*', array('id' => $messageId));
		return $rst;
	}
}

class ClssContacto
{
	function lista()
	{
		$sql = "SELECT * 
				FROM  contacto 
				WHERE  estado = 1 ORDER BY position DESC";
		$rst = selectDataQuery($sql);
		return $rst;
	}

}

class ClssRanking
{
	function top($mes, $ANHO, $tipoRanking, $tipo = '', $categoria = '', $personasID = '')
	{
		$where = $limit = "";

		if ($personasID != "") {
			$personasID = substr($personasID, 0, -1);
			$where .= " AND p.id NOT IN (" . $personasID . ")";
		}
		if ($tipoRanking != "") {
			$where .= " AND tr.id = " . $tipoRanking;
		}
		if ($categoria != "") {
			$where .= " AND mp.categoria_id = " . $categoria;
		}

		if ($tipo == 'top10') {
			$limit = ' ORDER BY velocidad DESC LIMIT 10';
			$mesW = ' AND mp.mes = ' . $mes;
			$anhoW = 'AND mp.anho = ' . $ANHO;
		} else if ($tipo == 'top3') {
			$limit = ' ORDER BY velocidad DESC LIMIT 1';
			$mesW = ' AND mp.mes = ' . $mes;
			$anhoW = 'AND mp.anho = ' . $ANHO;
		} else if ($tipo == 'top1') {
			$limit = ' ORDER BY velocidad DESC LIMIT 0,1';
			$mesW = '';
			$anhoW = '';
		}

		$sql = "SELECT mp.*, c.nombre as categoria, p.*, m.nombre as modulo  
				FROM  
					persona p,
					modulo_persona mp,
					modulo m,
					tipo_ranking tr,
					categoria c 
				WHERE 
					mp.estado = 1 AND
					p.id = mp.persona_id AND
					m.id = mp.modulo_id AND 
					mp.tipo_ranking_id = tr.id AND
					mp.categoria_id = c.id 
 					" . $mesW . "
					" . $anhoW . "
					" . $where . $limit;
		//	echo $sql;
		$rst = selectDataQuery($sql);
		return $rst;
	}

}

class ClssUsuario
{
	function getUsuarioEmail($email)
	{
		$sql = "SELECT t2.nombres, t2.apepa, t2.apema, t2.email, t1.usuario, t1.id as usuario_id, t2.id as persona_id 
 				  FROM usuario t1, persona t2
 				 WHERE 
				 t1.estado = 1 AND 
				 t2.estado = 1 AND 
				 t1.persona_id = t2.id AND 
				 t1.usuario_tipo_id = 2 AND 
				 t2.email = '" . trim($email) . "'";
		$rsts = selectDataQuery($sql);
		if ($rsts['total'] > 0) {
			$rst = $rsts['result'][0];
			$clave = generaClave(8);
			$rstUpd = updateData(
				'usuario',
				array('clave' => $clave),
				array('id' => $rst['usuario_id'], 'estado' => 1)
			);

			$rtn['@RTN_NUMESTADO'] = 1;
			$rtn['nombres'] = $rst['nombres'];
			$rtn['usuario'] = $rst['usuario'];
			$rtn['clave'] = $clave;
		} else {
			$rtn['@RTN_NUMESTADO'] = -1;
			$rtn['@RTN_NOMESTADO'] = 'Datos incorrectos.';
		}
		return $rtn;
	}

	//	function getUsuarioClave($email,$clave) {
// 		$sql = "SELECT t2.nombres, t2.apepa, t2.apema, t2.email, t1.usuario, t1.id as usuario_id, t2.id as persona_id 
// 				  FROM usuario t1, persona t2
// 				 WHERE 
//				 t1.estado = 1 AND 
//				 t2.estado = 1 AND 
//				 t1.persona_id = t2.id AND 
//				 t1.usuario_tipo_id = 2 AND 
//				 sha1(md5(LOWER(t2.email))) = '".generarSeguridad($email)."'";
//  		$rsts = selectDataQuery($sql);
//		if($rsts['total']>0) {
//			$rst = $rsts['result'][0]; 
//			$rtn['@RTN_NUMESTADO'] = 1;										
//			$rtn['nombres'] = $rst['nombres'];
//			$rtn['usuario'] = $rst['usuario'];
//			$rtn['email']   = $rst['email'];
//		} else {
//			$rtn['@RTN_NUMESTADO'] = -1;										
//			$rtn['@RTN_NOMESTADO'] = 'Datos incorrectos.';
//		}  
// 		return $rtn;	
//	}

	function login($REQUEST)
	{
		$sql = "SELECT t2.nombres, t2.apepa, t2.apema, t2.email, t1.usuario, t1.id as usuario_id, t2.id as persona_id 
 				  FROM usuario t1, persona t2
 				 WHERE 
				 t1.estado = 1 AND 
				 t2.estado = 1 AND 
				 t1.persona_id = t2.id AND 
				 t1.usuario_tipo_id = 2 AND 
				 t1.usuario = '" . trim($REQUEST['usuario']) . "' AND 
				 t1.clave = '" . trim($REQUEST['clave']) . "'";
		$rsts = selectDataQuery($sql);
		if ($rsts['total'] > 0) {
			$rst = $rsts['result'][0];
			$_SESSION['USER_CITEX_WEB'] = $rst['usuario'];
			$_SESSION['COD_USER_CITEX_WEB'] = $rst['usuario_id'];
			$_SESSION['CODPER_USER_CITEX_WEB'] = $rst['persona_id'];
			$_SESSION['NOM_USER_CITEX_WEB'] = $rst['nombres'];
			$_SESSION['APEPA_USER_CITEX_WEB'] = $rst['apepa'];
			$_SESSION['APEMA_USER_CITEX_WEB'] = $rst['apema'];
			$_SESSION['EMAIL_USER_CITEX_WEB'] = $rst['email'];

			$rtn['@RTN_NUMESTADO'] = 0;
			$rtn['@RTN_NOMESTADO'] = 'Hola ' . $_SESSION['NOM_USER_CITEX_WEB'];
		} else {
			$rtn['@RTN_NUMESTADO'] = 1;
			$rtn['@RTN_NOMESTADO'] = 'Datos incorrectos.';
		}
		return $rtn;
	}

	function registro($REQUEST)
	{
		$row = selectRowData('persona', '*', array('email' => $REQUEST['email']));
		if ($row !== false) {
			$rtn['@RTN_NUMESTADO'] = 1;
			$rtn['@RTN_NOMESTADO'] = 'Lo sentimos, el email ya se encuentra registrado, intenta con otro.';
		} else {
			$row = selectRowData('usuario', '*', array('usuario' => $REQUEST['usuario']));
			if ($row !== false) {
				$rtn['@RTN_NUMESTADO'] = 1;
				$rtn['@RTN_NOMESTADO'] = 'Lo sentimos, el usuario ya se encuentra registrado, intenta con otro.';
			} else {
				$rst = insertData(
					'persona',
					array(
						'nombres' => $REQUEST['nombres'],
						'apepa' => $REQUEST['apepa'],
						'apema' => $REQUEST['apema'],
						'email' => $REQUEST['email']
					)
				);

				$rstx = insertData(
					'usuario',
					array(
						'usuario_tipo_id' => 2,
						'persona_id' => $rst,
						'usuario' => $REQUEST['usuario'],
						'clave' => $REQUEST['clave']
					)
				);

				$rtn['@RTN_NUMESTADO'] = 0;
				$rtn['@RTN_NOMESTADO'] = 'Gracias por registrarte.';
			}
		}
		return $rtn;
	}

	function actualizar($REQUEST)
	{
		$row = selectRowData('persona', '*', array('email' => $REQUEST['email'], '1' => '1\' AND id<>\'' . $_SESSION['CODPER_USER_CITEX_WEB']));
		if ($row !== false) {
			$rtn['@RTN_NUMESTADO'] = 1;
			$rtn['@RTN_NOMESTADO'] = 'Lo sentimos, el email ya se encuentra registrado, intenta con otro.';
		} else {
			$rst = updateData(
				'persona',
				array(
					'nombres' => $REQUEST['nombres'],
					'apepa' => $REQUEST['apepa'],
					'apema' => $REQUEST['apema'],
					'email' => $REQUEST['email']
				),
				array('id' => $_SESSION['CODPER_USER_CITEX_WEB'], 'estado' => 1)
			);

			$rtn['@RTN_NUMESTADO'] = 0;
			if ($REQUEST['clave'] != "") {
				if ($REQUEST['clave'] != $REQUEST['clave_repetir']) {
					$rtn['@RTN_NUMESTADO'] = 1;
					$rtn['@RTN_NOMESTADO'] = 'La confirmación de la contraseña no coincide.';
				} else {
					$rstx = updateData(
						'usuario',
						array('clave' => $REQUEST['clave']),
						array(
							'persona_id' => $_SESSION['CODPER_USER_CITEX_WEB'],
							'id' => $_SESSION['COD_USER_CITEX_WEB'],
							'estado' => 1
						)
					);
					$rtn['@RTN_NUMESTADO'] = 0;
				}
			}
			if ($rtn['@RTN_NUMESTADO'] == 0) {
				$rtn['@RTN_NOMESTADO'] = 'Datos actualizados.';
			}

			$_SESSION['NOM_USER_CITEX_WEB'] = $REQUEST['nombres'];
			$_SESSION['APEPA_USER_CITEX_WEB'] = $REQUEST['apepa'];
			$_SESSION['APEMA_USER_CITEX_WEB'] = $REQUEST['apema'];
			$_SESSION['EMAIL_USER_CITEX_WEB'] = $REQUEST['email'];

		}
		return $rtn;
	}
}

class ClssBlog
{

	function comentar($REQUEST)
	{
		if (!isset($_SESSION['COD_USER_CITEX_WEB']) and $_SESSION['COD_USER_CITEX_WEB'] == "") {
			$rtn['@RTN_NUMESTADO'] = 1;
			$rtn['@RTN_NOMESTADO'] = 'Lo sentimos, tienes que iniciar sesión para comentar.';
		} else {
			if (validaTextIn(trim($REQUEST['comentario']))) {
				$row = selectRowData('blog', '*', array('estado' => 1, 'slug' => trim($REQUEST['slug'])));
				if ($row !== false) {
					$rst = insertData(
						'blog_comentario',
						array(
							'usuario_id' => $_SESSION['COD_USER_CITEX_WEB'],
							'blog_id' => $row['id'],
							'comentario' => trim($REQUEST['comentario']),
							'aprobado' => 1
						)
					);
					$rtn['@RTN_NUMESTADO'] = 0;
					$rtn['@RTN_NOMESTADO'] = 'Gracias por comentar.';
				} else {
					$rtn['@RTN_NUMESTADO'] = 1;
					$rtn['@RTN_NOMESTADO'] = 'Lo sentimos, la noticia no se encuentra activa o no existe.';
				}
			} else {
				$rtn['@RTN_NUMESTADO'] = 1;
				$rtn['@RTN_NOMESTADO'] = 'Error, estas tratando de colocar texto que no esta permitido, asegurate de ingresar sólo texto plano.';
			}
		}
		return $rtn;
	}

	function blog($id = "", $slug = "", $categoria = "", $etiqueta = "", $q = "", $limitar = "")
	{
		$where = "";
		$limit = "";
		if ($id != "") {
			$where .= " and t1.id = " . $id;
		}

		if ($categoria != "") {
			$categorias = explode(",", $categoria);
			$where .= " AND (";
			$cates = "";
			foreach ($categorias as $categoria) {
				$cates .= " t3.slug = '" . $categoria . "' OR ";
			}
			$where .= substr($cates, 0, -3) . " ) AND t1.slug <> '" . $slug . "'";
		} else {
			if ($slug != "") {
				$where .= " and t1.slug = '" . $slug . "'";
			}
		}

		if ($etiqueta != "") {
			$where .= " and t5.slug = '" . $etiqueta . "'";
		}
		if ($q != "") {
			$where .= " and (
										t1.titulo LIKE '%" . $q . "%' OR 
										t1.detalle LIKE '%" . $q . "%' OR 
										t3.nombre LIKE '%" . $q . "%' OR 
										t5.nombre LIKE '%" . $q . "%'   
									 ) ";
		}
		if ($limitar != "") {
			$limit = " LIMIT " . $limitar;
		}
		// $sql = "SELECT t1.*, GROUP_CONCAT(DISTINCT t3.slug ORDER BY t3.id DESC) as categoria 
		// 		  FROM 
		// 			  blog t1 ,
		// 			  blog_categoria_pub t2 , 
		// 			  blog_categoria t3, 
		// 			  blog_etiqueta_pub t4 , 
		// 			  blog_etiqueta t5 
		// 		 WHERE  t1.estado = 1 AND 
		// 				t2.estado = 1 AND 
		// 				t3.estado = 1 AND 
		// 				t4.estado = 1 AND 
		// 				t5.estado = 1 AND 

		// 		  		t1.id = t2.blog_id AND 
		// 				t2.blog_categoria_id = t3.id AND 

		// 		  		t1.id = t4.blog_id AND 
		// 				t4.blog_etiqueta_id = t5.id   

		// 				".$where." 
		// 		 GROUP BY t1.id  
		// 		 ORDER BY t1.publicado_el desc ".$limit;
		//	 echo $sql;
		$sql = "SELECT t1.*, GROUP_CONCAT(DISTINCT t3.slug ORDER BY t3.id DESC) as categoria FROM blog t1 
                    LEFT JOIN blog_categoria_pub t2 ON t2.estado = 1 AND t1.id = t2.blog_id   
                    LEFT JOIN blog_categoria t3 ON t3.estado = 1 AND t2.blog_categoria_id = t3.id   
                    LEFT JOIN blog_etiqueta_pub t4 ON t4.estado = 1 AND t1.id = t4.blog_id   
                    LEFT JOIN blog_etiqueta t5 ON t5.estado = 1 AND t4.blog_etiqueta_id = t5.id 
                    WHERE 
                    t1.estado = 1 AND 
                    t1.imagen <> '' " . $where . " 
                    GROUP BY t1.id 
                    ORDER BY t1.publicado_el desc " . $limit;
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function categoria($id = "")
	{
		$where = "";
		if ($id != "") {
			$where .= " and id=" . $id;
		}
		$sql = "SELECT *
 				  FROM blog_categoria
 				 WHERE estado = 1 " . $where . " ORDER BY id DESC ";
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function etiqueta($id = "")
	{
		$where = "";
		$order = "";
		if ($id != "") {
			$where .= " and id=" . $id;
		}
		$sql = "SELECT *
 				  FROM blog_etiqueta
 				 WHERE estado = 1 " . $where . " ORDER BY id DESC ";
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function comentario($blog)
	{
		$where = " and t1.slug='" . $blog . "'";
		$sql = "SELECT t3.usuario, t4.foto, t2.comentario, t2.creado_el as publicado_el 
 				  FROM blog t1, 
				  	   blog_comentario t2,
					   usuario t3,
					   persona t4
 				 WHERE 
				 t1.estado = 1 AND 
				 t2.estado = 1 AND 
				 t3.estado = 1 AND 
				 t4.estado = 1 AND 
				 t2.aprobado = 1 AND 
				 t1.id = t2.blog_id AND 
				 t2.usuario_id = t3.id AND 
				 t3.persona_id = t4.id 
				 " . $where . " ORDER BY t2.id ASC ";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}


class ClssMaterial
{

	function material($id = "", $slug = "", $categoria = "", $tipo = "")
	{
		$where = "";
		if ($id != "") {
			$where .= " and t1.id = " . $id;
		}

		if ($categoria != "") {
			$categorias = explode(",", $categoria);
			$where .= " AND (";
			$cates = "";
			foreach ($categorias as $categoria) {
				$cates .= " t2.slug = '" . $categoria . "' OR ";
			}
			$where .= substr($cates, 0, -3) . " ) AND t2.slug <> '" . $slug . "'";
		} else {
			if ($slug != "") {
				$where .= " and t1.slug = '" . $slug . "'";
			}
		}

		if ($tipo != "") {
			$where .= " and t3.slug = '" . $tipo . "'";
		}

		$sql = "SELECT t1.*, t2.nombre as categoria, t3.nombre as tipo, t3.slug as tiposlug  
 				  FROM 
					  material t1 , 
					  material_categoria t2, 
					  material_tipo  t3  
 				 WHERE  t1.estado = 1 AND 
						t2.estado = 1 AND 
						t3.estado = 1 AND  
						
				  		t1.material_categoria_id = t2.id AND 
						t1.material_tipo_id = t3.id  
						
						" . $where . " 
				 GROUP BY t1.id   ";
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function categoria($id = "")
	{
		$where = "";
		if ($id != "") {
			$where .= " and id=" . $id;
		}
		$sql = "SELECT *
 				  FROM material_categoria
 				 WHERE estado = 1 " . $where . " ORDER BY id DESC ";
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function tipo($id = "")
	{
		$where = "";
		$order = "";
		if ($id != "") {
			$where .= " and id=" . $id;
		}
		$sql = "SELECT *
 				  FROM material_tipo
 				 WHERE estado = 1 " . $where . " ORDER BY id DESC ";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssVideo
{
	function video($slug)
	{
		$sql = "SELECT *
 				  FROM video
 				 WHERE slug = '" . $slug . "' AND estado = 1";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssTestiQ
{
	function tipo($cod = '', $slug = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and t1.id=" . $cod;
		}
		if ($slug != "") {
			$where .= " and t1.slug='" . $slug . "'";
		}
		$sql = "SELECT t1.*, t2.nombre as categoria , 
						t2.edad_inicio as edad_min, t2.edad_fin as edad_max,  
						t2.edad_inicio as edadMin, t2.edad_fin as edadMax  
 				  FROM  serie_tipo t1, categoria t2
				 WHERE t1.categoria_id = t2.id " . $where . " ORDER BY t1.id ASC";
		$rst = selectDataQuery($sql);
		return $rst;
	}
	function serieTipo($cod = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		$sql = "SELECT * 
 				  FROM serie_tipo  
				 WHERE 1=1 " . $where;
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function serie($cod = '', $tipo = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if ($tipo != "") {
			$where .= " and serie_tipo_id=" . $tipo;
		}
		$sql = "SELECT * 
 				  FROM serie 
				 WHERE 1=1 " . $where;
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function pregunta($cod = '', $serie = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if ($serie != "") {
			$where .= " and serie_id=" . $serie;
		}
		$sql = "SELECT * 
 				  FROM serie_pregunta  
				 WHERE 1=1 " . $where;
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function alternativa($cod = '', $pregunta = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if ($pregunta != "") {
			$where .= " and serie_pregunta_id=" . $pregunta;
		}
		$sql = "SELECT * 
 				  FROM serie_alternativa   
				 WHERE 1=1 " . $where;
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function getEdad($edad)
	{
		$rtnEdad = $edad;
		//		if($edad < 12) {
//			$rtnEdad = 12; //edad_id
//		} elseif($edad > 22 and $edad <= 65) {
//			$rtnEdad = 65; //edad_id
//		} elseif($edad > 65) {
//			$rtnEdad = 65; //edad_id
//		}
		return $rtnEdad;
	}

	function getPercentil($edad = 5, $totalOk = 0, $totalKo = 0, $tipo = "")
	{
		$where = "";
		if ($tipo != "") {
			$where .= " and t3.serie_tipo_id=" . $tipo;
		}
		$sql = "SELECT t3.*  
				FROM 
					percentil_edad t1,
					edad t2 , 
					percentil t3 
				WHERE 
					t1.edad_id = t2.id AND 
					t1.percentil_id = t3.id AND 
					t2.valor >= " . $edad . " AND 
					t1.valor >= " . $totalOk . " " . $where . " order by t2.valor DESC limit 1";
		$rst = selectDataQuery($sql);
		return $rst;
	}
}

class ClssTest
{
	function listarLectura($cod = '', $categoria = '', $subcategoria = '', $limite = '')
	{
		$where = "";
		$order = "";
		if ($subcategoria != "" or $subcategoria == "0") {
			$where .= " and l.subcategoria_id=" . $subcategoria;
		}
		if ($categoria != "") {
			$where .= " and sc.categoria_id=" . $categoria;
		}
		if ($cod != "") {
			$where .= " and l.id=" . $cod;
		} else {
			// $order = " ORDER BY RAND(" . time() . "*" . time() . ") LIMIT " . $limite;
			# Order by date asc
			$order = " ORDER BY l.id DESC LIMIT " . $limite;
		}

		$sql = "SELECT l.*, 
						l.id as id, 
						sc.nombre as nombreSubCategoria ,
						sc.id as subcategoria,
						c.nombre as nombreCategoria,
						c.id as categoria 
 				  FROM 
				  	   categoria c , 
					   subcategoria sc ,
					   lectura l					   
 				 WHERE 
				 	   c.id = sc.categoria_id AND 
				 	   sc.id = l.subcategoria_id AND 
					   l.estado = 1 AND 
					   l.activo = 1
				 " . $where . $order;
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function listarSubCategoria($cod = '', $categoria = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		$sql = "SELECT * 
 				  FROM subcategoria   
				 WHERE categoria_id=" . $categoria . $where;
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function listarCategoria($cod = '', $slug = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if ($slug != "") {
			$where .= " and nombre LIKE '%" . $slug . "%'";
		}
		$sql = "SELECT * 
 				  FROM  categoria 
				 WHERE 1 = 1 " . $where;
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function listarPregunta($cod = '', $lectura = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		$sql = "SELECT * 
 				  FROM  pregunta 
				 WHERE estado = 1 and lectura_id=" . $lectura . $where;
		//echo $sql;
		$rst = selectDataQuery($sql);
		return $rst;
	}

	function listarAlternativas($cod = '', $pregunta = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		$sql = "SELECT * 
 				  FROM  alternativa 
				 WHERE estado = 1 and pregunta_id=" . $pregunta . $where;
		$rst = selectDataQuery($sql);
		return $rst;
	}


}

class Billing
{
	function insert($request)
	{
		$rst = insertData(
			'billing',
			array(
				"req_transaction_type" => $request['req_transaction_type'],
				"req_reference_number" => $request['req_reference_number'],
				"req_card_expiry_date" => $request['req_card_expiry_date'],
				"req_merchant_defined_data90" => $request['req_merchant_defined_data90'],
				"req_bill_to_surname" => $request['req_bill_to_surname'],
				"req_merchant_defined_data9" => $request['req_merchant_defined_data9'],
				"req_transaction_uuid" => $request['req_transaction_uuid'],
				"req_bill_to_email" => $request['req_bill_to_email'],
				"req_currency" => $request['req_currency'],
				"req_merchant_defined_data4" => $request['req_merchant_defined_data4'],
				"req_bill_to_address_line1" => $request['req_bill_to_address_line1'],
				"req_card_number" => $request['req_card_number'],
				"req_merchant_defined_data91" => $request['req_merchant_defined_data91'],
				"req_bill_to_forename" => $request['req_bill_to_forename'],
				"req_bill_to_address_city" => $request['req_bill_to_address_city'],
				"req_bill_to_address_postal_code" => $request['req_bill_to_address_postal_code'],
				"req_bill_to_address_state" => $request['req_bill_to_address_state'],
				"req_merchant_defined_data11" => $request['req_merchant_defined_data11'],
				"req_card_type" => $request['req_card_type'],
				"card_type_name" => $request['card_type_name'],
				"req_profile_id" => $request['req_profile_id'],
				"req_payment_method" => $request['req_payment_method'],
				"auth_amount" => $request['auth_amount'],
				"auth_time" => $request['auth_time'],
				"decision" => $request['decision'],
				"decision_reason_code" => $request['decision_reason_code'],
				"payer_authentication_eci" => $request['payer_authentication_eci'],
				"payer_authentication_transaction_id" => $request['payer_authentication_transaction_id'],
				"score_device_fingerprint_true_ipaddress_city" => $request['score_device_fingerprint_true_ipaddress_city'],
				"score_time_local" => $request['score_time_local'],
				"score_card_issuer" => $request['score_card_issuer'],
				"score_device_fingerprint_screen_resolution" => $request['score_device_fingerprint_screen_resolution'],
				"score_card_scheme" => $request['score_card_scheme'],
				"score_device_fingerprint_true_ipaddress_country" => $request['score_device_fingerprint_true_ipaddress_country'],
				"score_device_fingerprint_true_ipaddress" => $request['score_device_fingerprint_true_ipaddress'],
				"score_reason_code" => $request['score_reason_code'],
				"transaction_id" => $request['transaction_id'],
				"signature" => $request['signature'],
				"bill_trans_ref_no" => $request['bill_trans_ref_no'],
				"signed_date_time" => $request['signed_date_time'],
				"reason_code" => $request['reason_code'],
				"message" => $request['message'],
				"verified" => $request['verified']
			)
		);
		return $rst;
	}
}
?>
