<?php
require_once(__DIR__ . "/conecta.php");

class ClssLandingTestimonio extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function eliminar($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE landing_testimonials SET  isDeleted=?  WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						1,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Se eliminó el registro con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardar($REQUEST, $FILES)
	{
		try {
			global $EXTENSIONES_IMAGEN;
			if (isset($FILES['avatar']['name']) and $FILES['avatar']['name'] != "") {
				$foto = subirFichero('avatar', '../' . RUTA_LANDING, $EXTENSIONES_IMAGEN);
				$validation = $foto['error'];
				$avatar = $foto['archivo'];
			} else {
				$validation = true;
				$avatar = $REQUEST['avatar_HIDDEN'];
			}
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO landing_testimonials (names,profile,text,avatar,landing_id) " .
					"VALUES (:names,:profile,:text,:avatar,:landing_id)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':names' => trim($REQUEST['names']),
						':profile' => trim($REQUEST['profile']),
						':text' => trim($REQUEST['text']),
						':avatar' => $avatar,
						':landing_id' => trim($REQUEST['landing_id'])
					)
				);
				$cod = $con->lastInsertId();
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE landing_testimonials SET 
                                `names`=?, 
                                `profile`=?,
                                `text`=?,
                                `avatar`=?
                        WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						trim($REQUEST['names']),
						trim($REQUEST['profile']),
						trim($REQUEST['text']),
						$avatar,
						$cod
					)
				);
			}
			$rtn = 1;
			$msje = 'Guardado con éxito';
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listar($landing_id = '', $cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($landing_id != "") {
			$where .= " and landing_id=" . $landing_id;
		}
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM  landing_testimonials    
                 WHERE isDeleted = 0 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssLandingFAQ extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function eliminar($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE landing_faqs SET  isDeleted=?  WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						1,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Se eliminó el registro con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardar($REQUEST)
	{
		try {
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO landing_faqs (title,text,landing_id) " .
					"VALUES (:title,:text,:landing_id)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':title' => trim($REQUEST['title']),
						':text' => trim($REQUEST['text']),
						':landing_id' => trim($REQUEST['landing_id'])
					)
				);
				$cod = $con->lastInsertId();
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE landing_faqs SET  
                            `title` = ?,
                            `text` = ? 
                        WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						trim($REQUEST['title']),
						trim($REQUEST['text']),
						$cod
					)
				);
			}
			$rtn = 1;
			$msje = 'Guardado con éxito';
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listar($landing_id = '', $cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($landing_id != "") {
			$where .= " and landing_id=" . $landing_id;
		}
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM  landing_faqs    
                 WHERE isDeleted = 0 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssLandingPrecios extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function guardar($REQUEST)
	{
		try {
			$con = $this->pdo;
			$cod = $REQUEST['cod'];
			$sql = "UPDATE landing_prices SET  
                        `title1` = ?,
                        `subtitle1` = ?,
                        `text1` = ?,
                        `price1` = ?,
                        `link1` = ?,
                        `price_text1` = ?,
                        `title2` = ?,
                        `subtitle2` = ?,
                        `text2` = ?,
                        `price2` = ?,
                        `link2` = ?,
                        `price_text2` = ?,
                        `title3` = ?,
                        `subtitle3` = ?,
                        `text3` = ?,
                        `price3` = ?,
                        `link3` = ?,
                        `price_text3` = ?
                    WHERE id=?";
			$q = $con->prepare($sql);
			$rtn = $q->execute(
				array(
					trim($REQUEST['title1']),
					trim($REQUEST['subtitle1']),
					trim($REQUEST['text1']),
					trim($REQUEST['price1']),
					trim($REQUEST['link1']),
					trim($REQUEST['price_text1']),
					trim($REQUEST['title2']),
					trim($REQUEST['subtitle2']),
					trim($REQUEST['text2']),
					trim($REQUEST['price2']),
					trim($REQUEST['link2']),
					trim($REQUEST['price_text2']),
					trim($REQUEST['title3']),
					trim($REQUEST['subtitle3']),
					trim($REQUEST['text3']),
					trim($REQUEST['price3']),
					trim($REQUEST['link3']),
					trim($REQUEST['price_text3']),
					$cod
				)
			);
			$rtn = 1;
			$msje = 'Guardado con éxito';
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listar($landing_id = '', $cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($landing_id != "") {
			$where .= " and landing_id=" . $landing_id;
		}
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM  landing_prices    
                 WHERE 1 = 1 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssLanding extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function guardar($REQUEST, $FILES)
	{
		try {
			global $EXTENSIONES_IMAGEN;
			if ($REQUEST['banner-file-type'] == 'video') {
				$bannerFile = trim($REQUEST['banner-file-video']);
			} else {
				if (isset($FILES['banner-file-image']['name']) and $FILES['banner-file-image']['name'] != "") {
					$foto = subirFichero('banner-file-image', '../' . RUTA_LANDING, $EXTENSIONES_IMAGEN);
					$validation = $foto['error'];
					$bannerFile = $foto['archivo'];
				} else {
					$validation = true;
					$bannerFile = $REQUEST['banner-file_HIDDEN'];
				}
			}
			if ($REQUEST['description-file1-type'] == 'video') {
				$descriptionFile1 = trim($REQUEST['description-file1-video']);
			} else {
				if (isset($FILES['description-file1-image']['name']) and $FILES['description-file1-image']['name'] != "") {
					$foto = subirFichero('description-file1-image', '../' . RUTA_LANDING, $EXTENSIONES_IMAGEN);
					$validation = $foto['error'];
					$descriptionFile1 = $foto['archivo'];
				} else {
					$validation = true;
					$descriptionFile1 = $REQUEST['description-file1_HIDDEN'];
				}
			}
			if ($REQUEST['description-file2-type'] == 'video') {
				$descriptionFile2 = trim($REQUEST['description-file2-video']);
			} else {
				if (isset($FILES['description-file2-image']['name']) and $FILES['description-file2-image']['name'] != "") {
					$foto = subirFichero('description-file2-image', '../' . RUTA_LANDING, $EXTENSIONES_IMAGEN);
					$validation = $foto['error'];
					$descriptionFile2 = $foto['archivo'];
				} else {
					$validation = true;
					$descriptionFile2 = $REQUEST['description-file2_HIDDEN'];
				}
			}
			if ($REQUEST['description-file3-type'] == 'video') {
				$descriptionFile3 = trim($REQUEST['description-file3-video']);
			} else {
				if (isset($FILES['description-file3-image']['name']) and $FILES['description-file3-image']['name'] != "") {
					$foto = subirFichero('description-file3-image', '../' . RUTA_LANDING, $EXTENSIONES_IMAGEN);
					$validation = $foto['error'];
					$descriptionFile3 = $foto['archivo'];
				} else {
					$validation = true;
					$descriptionFile3 = $REQUEST['description-file3_HIDDEN'];
				}
			}
			$con = $this->pdo;
			$cod = $REQUEST['cod'];
			$sql = "UPDATE landing SET 
                            `title`=?,
                            `banner-title`=?,
                            `banner-subtitle`=?,
                            `banner-file`=?,
                            `description-title`=?,
                            `description-text1`=?,
                            `description-file1`=?,
                            `description-text2`=?,
                            `description-file2`=?,
                            `description-text3`=?,
                            `description-file3`=?,
                            `testimonial-title`=?,
                            `testimonial-text`=?,
                            `prices-title`=?,
                            `prices-text`=?,
                            `faq-title`=?,
                            `faq-text`=?,
                            `contact-title`=?,
                            `contact-text`=?
                    WHERE id=?";
			$q = $con->prepare($sql);
			$rtn = $q->execute(
				array(
					trim($REQUEST['title']),
					trim($REQUEST['banner-title']),
					trim($REQUEST['banner-subtitle']),
					$bannerFile,
					trim($REQUEST['description-title']),
					trim($REQUEST['description-text1']),
					$descriptionFile1,
					trim($REQUEST['description-text2']),
					$descriptionFile2,
					trim($REQUEST['description-text3']),
					$descriptionFile3,
					trim($REQUEST['testimonial-title']),
					trim($REQUEST['testimonial-text']),
					trim($REQUEST['prices-title']),
					trim($REQUEST['prices-text']),
					trim($REQUEST['faq-title']),
					trim($REQUEST['faq-text']),
					trim($REQUEST['contact-title']),
					trim($REQUEST['contact-text']),
					$cod
				)
			);
			$rtn = 1;
			$msje = 'Guardado con éxito';
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listar($cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM landing    
                 WHERE isActive = 1 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssContacto extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function eliminar($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE contacto SET  estado=?   WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Se eliminó el registro con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardar($REQUEST, $FILES)
	{
		try {
			if (isset($FILES['imagen']['name']) and $FILES['imagen']['name'] != "") {
				global $EXTENSIONES_IMAGEN;
				$foto = subirFichero('imagen', '../' . PATH_CONTACTO, $EXTENSIONES_IMAGEN, 300, 200);
				$validation = $foto['error'];
				$imagen = $foto['archivo'];
			} else {
				$validation = true;
				$imagen = $REQUEST['imagen_HIDDEN'];
			}
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO contacto (nombre,latitude,longitude,direccion,fono,email,imagen,color,urlMap) " .
					"VALUES (:nombre,:latitude,:longitude,:direccion,:fono,:email,:imagen,:color,:urlMap)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':nombre' => trim($REQUEST['nombre']),
						':latitude' => trim($REQUEST['latitude']),
						':longitude' => trim($REQUEST['longitude']),
						':direccion' => trim($REQUEST['direccion']),
						':fono' => trim($REQUEST['fono']),
						':email' => trim($REQUEST['email']),
						':color' => trim($REQUEST['color']),
						':urlMap' => trim($REQUEST['urlMap']),
						':imagen' => $imagen
					)
				);
				$cod = $con->lastInsertId();
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE contacto SET nombre=?, latitude=?, longitude=?, direccion=?, fono=?, email=?, color=?, urlMap=?, imagen=? WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						trim($REQUEST['nombre']),
						trim($REQUEST['latitude']),
						trim($REQUEST['longitude']),
						trim($REQUEST['direccion']),
						trim($REQUEST['fono']),
						trim($REQUEST['email']),
						trim($REQUEST['color']),
						trim($REQUEST['urlMap']),
						$imagen,
						$cod
					)
				);
			}
			$rtn = 1;
			$msje = 'Guardado con éxito';
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listar($cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM contacto    
                 WHERE estado = 1 " . $where . " ORDER BY position DESC" . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function sorted($REQUEST)
	{
		try {
			$msje = '';
			$con = $this->pdo;
			$ids = json_decode($REQUEST['position'], true);
			$total = count($ids[0]);
			foreach ($ids[0] as $key => $id) {
				$sql = "UPDATE contacto SET position=? WHERE estado = 1 and id = ? ";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$total,
						$id['id']
					)
				);
				$total--;
			}
			$rtn = true;
			$msje = 'Registros ordenados con éxito.';
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = false;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}
}

class ClssNoticia extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function guardarEtiqueta($REQUEST)
	{
		try {
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO blog_etiqueta (nombre,slug) " . "VALUES (:nombre,:slug)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':nombre' => $REQUEST['nombre'],
						':slug' => slug($REQUEST['nombre'])
					)
				);
				$msje = 'Guardado con éxito';
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE blog_etiqueta SET " . " nombre=?, " . " slug = ? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['nombre'],
						slug($REQUEST['nombre']),
						$cod
					)
				);
				$msje = 'Actualizado con éxito';
			}
			$rtn = 1;
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardarCategoria($REQUEST)
	{
		try {
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO blog_categoria (nombre,slug) " . "VALUES (:nombre,:slug)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':nombre' => $REQUEST['nombre'],
						':slug' => slug($REQUEST['nombre'])
					)
				);
				$msje = 'Guardado con éxito';
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE blog_categoria SET " . " nombre=?, " . " slug = ? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['nombre'],
						slug($REQUEST['nombre']),
						$cod
					)
				);
				$msje = 'Actualizado con éxito';
			}
			$rtn = 1;
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminarEtiqueta($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE blog_etiqueta SET " . " estado=? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Se eliminó la etiqueta con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminarCategoria($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE blog_categoria SET " . " estado=? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Se eliminó la categoria con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminar($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE blog SET " . " estado=? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Se eliminó la noticia con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function activoNoticiaComentario($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$estado = ($REQUEST['estado'] == 0) ? 1 : 0;
				$sql = "UPDATE blog_comentario SET " . " aprobado = ? " . " WHERE id = ? ";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$estado,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Se actualizó el estado del comentario con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar actualizar el estado del registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardar($REQUEST, $FILES)
	{
		try {
			if (isset($FILES['imagen']['name']) and $FILES['imagen']['name'] != "") {
				global $EXTENSIONES_IMAGEN;
				$foto = subirFichero('imagen', '../' . RUTA_NOTICIA, $EXTENSIONES_IMAGEN, 820, 500);
				$validation = $foto['error'];
				$imagen = $foto['archivo'];
			} else {
				$validation = true;
				$imagen = $REQUEST['imagen_HIDDEN'];
			}
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO blog (slug,titulo,detalle,imagen,publicado_el) " . "VALUES (:slug,:titulo,:detalle,:imagen,:publicado_el)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':slug' => slug($REQUEST['titulo']),
						':titulo' => $REQUEST['titulo'],
						':detalle' => createEmbedURL($REQUEST['detalle']),
						':imagen' => $imagen,
						':publicado_el' => fechaToMySQL($REQUEST['publicado_el'])
					)
				);
				$cod = $con->lastInsertId();
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE blog SET " . " slug=?, " . " titulo = ?, " . " detalle = ?, " . " imagen = ?, " . " publicado_el = ? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						slug($REQUEST['titulo']),
						$REQUEST['titulo'],
						createEmbedURL($REQUEST['detalle']),
						$imagen,
						fechaToMySQL($REQUEST['publicado_el']),
						$cod
					)
				);
			}
			if (isset($REQUEST['categorias'])) {
				$sql = "DELETE FROM blog_categoria_pub WHERE blog_id =  :blog_id";
				$stmt = $con->prepare($sql);
				$stmt->execute(
					array(
						':blog_id' => $cod
					)
				);
				foreach ($REQUEST['categorias'] as $categoria) {
					$sql = "INSERT INTO blog_categoria_pub (blog_id,blog_categoria_id) " . "VALUES (:blog_id,:blog_categoria_id)";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							':blog_id' => $cod,
							':blog_categoria_id' => $categoria
						)
					);
				}
			}
			if (isset($REQUEST['etiquetas'])) {
				$sql = "DELETE FROM blog_etiqueta_pub WHERE blog_id =  :blog_id";
				$stmt = $con->prepare($sql);
				$stmt->execute(
					array(
						':blog_id' => $cod
					)
				);
				foreach ($REQUEST['etiquetas'] as $etiqueta) {
					$sql = "INSERT INTO blog_etiqueta_pub (blog_id,blog_etiqueta_id) " . "VALUES (:blog_id,:blog_etiqueta_id)";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							':blog_id' => $cod,
							':blog_etiqueta_id' => $etiqueta
						)
					);
				}
			}
			$rtn = 1;
			$msje = 'Guardado con éxito';
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listar($cod = '', $paginado = 0, $cantidad = 10, $buscar = '')
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		if ($buscar != "") {
			$where .= " and (titulo like '%" . $buscar . "%'";
			$where .= " or detalle like '%" . $buscar . "%')";
		}
		$sql = "SELECT * 
                   FROM blog    
                 WHERE estado = 1 " . $where . " ORDER BY id DESC" . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function getCategoriaNoticia($cod = '', $paginado = 0, $cantidad = 10, $buscar = '')
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		if ($buscar != "") {
			$where .= " and (nombre like '%" . $buscar . "%')";
		}
		$sql = "SELECT * 
                   FROM blog_categoria    
                 WHERE estado = 1 " . $where . " ORDER BY id DESC" . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function getNoticiaCategoria($cod = '', $noticia = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		$sql = "SELECT t1.id as id  
                   FROM 
                          blog_categoria t1,    
                        blog_categoria_pub t2 
                 WHERE 
                         t1.id = t2.blog_categoria_id AND 
                         t1.estado = 1 AND 
                        t2.estado = 1 AND 
                        t2.blog_id = " . $noticia . $where;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function getEtiquetaNoticia($cod = '', $paginado = 0, $cantidad = 10, $buscar = '')
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		if ($buscar != "") {
			$where .= " and (nombre like '%" . $buscar . "%')";
		}
		$sql = "SELECT * 
                   FROM blog_etiqueta    
                 WHERE estado = 1 " . $where . " ORDER BY id DESC" . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function getNoticiaEtiqueta($cod = '', $noticia = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and t2.id=" . $cod;
		}
		$sql = "SELECT t1.id as id  
                   FROM 
                          blog_etiqueta t1,    
                        blog_etiqueta_pub t2 
                 WHERE 
                         t1.id = t2.blog_etiqueta_id AND 
                         t1.estado = 1 AND 
                        t2.estado = 1 AND 
                        t2.blog_id = " . $noticia . $where;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function getNoticiaComentario($cod = '', $noticia = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		$sql = "SELECT t2.*, t3.usuario as usuario  
                   FROM 
                          blog t1,    
                        blog_comentario t2,
                        usuario t3  
                 WHERE 
                         t1.estado = 1 AND 
                        t2.estado = 1 AND 
                         t3.estado = 1 AND 
                         t1.id = t2.blog_id AND 
                         t2.usuario_id = t3.id AND 
                        t2.blog_id = " . $noticia . $where;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssRanking extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function guardar($REQUEST, $FILES)
	{
		try {
			if (isset($FILES['foto']['name'])) {
				global $EXTENSIONES_IMAGEN;
				$foto = subirFichero('foto', '../' . PATH_IMG_RANKING, $EXTENSIONES_IMAGEN, 200, 200);
				$validation = $foto['error'];
				$imagen = $foto['archivo'];
			} else {
				$validation = true;
				$imagen = $REQUEST['foto_HIDDEN'];
			}
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO persona (nombres,apepa,apema,ciudad,email,foto) " . "VALUES (:nombres,:apepa,:apema,:ciudad,:email,:foto)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':nombres' => $REQUEST['nombres'],
						':apepa' => $REQUEST['apepa'],
						':apema' => $REQUEST['apema'],
						':ciudad' => $REQUEST['ciudad'],
						':email' => $REQUEST['email'],
						':foto' => $imagen
					)
				);
				$msje = 'Guardado con éxito';
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE persona SET " . " nombres=?, " . " apepa = ?, " . " apema = ?, " . " ciudad = ?, " . " email = ?, " . " foto = ? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['nombres'],
						$REQUEST['apepa'],
						$REQUEST['apema'],
						$REQUEST['ciudad'],
						$REQUEST['email'],
						$imagen,
						$cod
					)
				);
				$msje = 'Actualizado con éxito';
			}
			$rtn = 1;
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminar($cod)
	{
		$rst = $this->updateData(
			'persona',
			array(
				'estado' => 0
			),
			array(
				'id' => $cod
			)
		);
		return $rst;
	}

	function listar($cod = '', $paginado = 0, $cantidad = 10, $buscar = '')
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		if ($buscar != "") {
			$where .= " and (nombres like '%" . $buscar . "%'";
			$where .= " or apepa like '%" . $buscar . "%'";
			$where .= " or apema like '%" . $buscar . "%'";
			$where .= " or ciudad like '%" . $buscar . "%')";
		}
		$sql = "SELECT * 
                   FROM  persona  
                 WHERE estado = 1 and id<>1 " . $where . " ORDER BY id DESC " . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function guardarRankingModulo($REQUEST)
	{
		try {
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO modulo_persona (edad,anho,mes,velocidad,comprension,persona_id,tipo_ranking_id,modulo_id,categoria_id) " . "VALUES (:edad,:anho,:mes,:velocidad,:comprension,:persona_id,:tipo_ranking_id,:modulo_id,:categoria_id)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':edad' => $REQUEST['edad'],
						':anho' => $REQUEST['anho'],
						':mes' => $REQUEST['mes'],
						':velocidad' => $REQUEST['velocidad'],
						':comprension' => $REQUEST['comprension'],
						':persona_id' => $REQUEST['persona_id'],
						':tipo_ranking_id' => $REQUEST['tipo_ranking_id'],
						':modulo_id' => $REQUEST['modulo_id'],
						':categoria_id' => $REQUEST['categoria_id']
					)
				);
				$msje = 'Guardado con éxito';
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE modulo_persona SET " . " edad=?, " . " anho = ?, " . " mes = ?, " . " velocidad = ?, " . " comprension = ?, " . " tipo_ranking_id = ?, " . " modulo_id = ?, " . " categoria_id = ? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['edad'],
						$REQUEST['anho'],
						$REQUEST['mes'],
						$REQUEST['velocidad'],
						$REQUEST['comprension'],
						$REQUEST['tipo_ranking_id'],
						$REQUEST['modulo_id'],
						$REQUEST['categoria_id'],
						$cod
					)
				);
				$msje = 'Actualizado con éxito';
			}
			$rtn = 1;
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminarRankingModulo($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE modulo_persona SET " . " estado=? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Se eliminó la noticia con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listarRankingModulo($cod = '', $persona = '', $paginado = 0, $cantidad = 10, $buscar = '')
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and mp.id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		if ($persona != "") {
			$where .= " and mp.persona_id=" . $persona;
		}
		if ($buscar != "") {
			$where .= " and (c.nombre like '%" . $buscar . "%'";
			$where .= " or mp.edad like '%" . $buscar . "%'";
			$where .= " or mp.anho like '%" . $buscar . "%'";
			$where .= " or mp.edad like '%" . $buscar . "%'";
			$where .= " or mp.velocidad like '%" . $buscar . "%'";
			$where .= " or mp.comprension like '%" . $buscar . "%'";
			$where .= " or m.nombre like '%" . $buscar . "%'";
			$where .= " or tr.nombre like '%" . $buscar . "%'";
			$where .= " or c.nombre like '%" . $buscar . "%')";
		}
		$sql = "SELECT 
                        mp.*,
                        c.nombre as categoria, 
                        m.nombre as modulo,
                        tr.nombre as tipo_ranking,
                        c.nombre as categoria 
                    FROM 
                        modulo_persona mp,
                        categoria c,
                        modulo m,
                        tipo_ranking tr
                     WHERE 
                         mp.categoria_id = c.id 
                        AND mp.modulo_id = m.id 
                        AND mp.tipo_ranking_id = tr.id 
                        AND mp.estado = 1 " . $where . $limit;
		//echo $sql;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssALeerBoliviaTestimonios extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function activate($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE a_leer_bolivia_testimonio SET active=? WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						($REQUEST['active'] == 1 ? 0 : 1),
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Registro actualizado con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar actualizar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminar($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE a_leer_bolivia_testimonio SET estado=? WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Registro eliminado con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardar($REQUEST)
	{
		try {
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO a_leer_bolivia_testimonio (name,detail,video) VALUES (:name,:detail,:video)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':name' => trim($REQUEST['name']),
						':detail' => $REQUEST['detail'],
						':video' => $REQUEST['video']
					)
				);
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE a_leer_bolivia_testimonio SET name =?, detail =?, video = ? WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						trim($REQUEST['name']),
						trim($REQUEST['detail']),
						$REQUEST['video'],
						$cod
					)
				);
			}
			$rtn = 1;
			$msje = 'Guardado con éxito';
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listar($cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM  a_leer_bolivia_testimonio  
                 WHERE estado = 1 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssALeerBoliviaFicha extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function activate($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;

				$sqlType = "SELECT type FROM a_leer_bolivia_ficha WHERE id=?";
				$qType = $con->prepare($sqlType);
				$qType->execute(array($REQUEST['cod']));
				$type = $qType->fetchColumn();

				if ($type !== false) {
					$sqlDeactivate = "UPDATE a_leer_bolivia_ficha SET active=0 WHERE type=?";
					$qDeactivate = $con->prepare($sqlDeactivate);
					$qDeactivate->execute(
						array(
							$type
						)
					);

					$sql = "UPDATE a_leer_bolivia_ficha SET active=? WHERE id=?";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							1,
							$REQUEST['cod']
						)
					);
					$rtn = 1;
					$msje = 'Registro actualizado con éxito.';
					$class = 'alert-success';
				} else {
					$rtn = 0;
					$msje = 'Error al intentar actualizar el registro.';
					$class = 'alert-danger';
				}
			} else {
				$rtn = 0;
				$msje = 'Error al intentar actualizar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminar($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE a_leer_bolivia_ficha SET estado=? WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Registro eliminado con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardar($REQUEST, $FILES)
	{
		try {
			if (isset($FILES['document']['name']) and $FILES['document']['name'] != "") {
				global $EXTENSIONES_FILE;
				$file = subirFichero('document', '../' . PATH_A_LEER_BOLIVIA_FICHAS, $EXTENSIONES_FILE);
				$validation = $file['error'];
				$document = $file['archivo'];
			} else {
				$validation = true;
				$document = $REQUEST['document_HIDDEN'];
			}

			if ($validation === true) {
				$con = $this->pdo;
				if ($REQUEST['cod'] == 0) {
					$sql = "INSERT INTO a_leer_bolivia_ficha (name,document,type,active) VALUES (:name,:document,:type,:active)";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							':name' => trim($REQUEST['name']),
							':document' => $document,
							':type' => $REQUEST['type'],
							':active' => 0,
						)
					);
				} else {
					$cod = $REQUEST['cod'];
					$sql = "UPDATE a_leer_bolivia_ficha SET name =?, document =?, type =?  WHERE id=?";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							trim($REQUEST['name']),
							$document,
							$REQUEST['type'],
							$cod
						)
					);
				}
				$rtn = 1;
				$msje = 'Guardado con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = $validation;
				$class = 'alert-error';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listar($cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM  a_leer_bolivia_ficha  
                 WHERE estado = 1 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssALeerBoliviaLogos extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function activate($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE a_leer_bolivia_logos SET active=? WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						($REQUEST['active'] == 1 ? 0 : 1),
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Registro actualizado con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar actualizar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminar($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE a_leer_bolivia_logos SET estado=? WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Registro eliminado con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardar($REQUEST, $FILES)
	{
		try {
			if (isset($FILES['image']['name']) and $FILES['image']['name'] != "") {
				global $EXTENSIONES_IMAGEN;
				$foto = subirFichero('image', '../' . PATH_A_LEER_BOLIVIA_LOGOS, $EXTENSIONES_IMAGEN);
				$validation = $foto['error'];
				$image = $foto['archivo'];
			} else {
				$validation = true;
				$image = $REQUEST['image_HIDDEN'];
			}

			if ($validation === true) {
				$con = $this->pdo;
				if ($REQUEST['cod'] == 0) {
					$sql = "INSERT INTO a_leer_bolivia_logos (name,type,image) VALUES (:name,:type,:image)";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							':name' => trim($REQUEST['name']),
							':type' => trim($REQUEST['type']),
							':image' => $image,
						)
					);
				} else {
					$cod = $REQUEST['cod'];
					$sql = "UPDATE a_leer_bolivia_logos SET name =?, type =?, image =? WHERE id=?";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							trim($REQUEST['name']),
							trim($REQUEST['type']),
							$image,
							$cod
						)
					);
				}
				$rtn = 1;
				$msje = 'Guardado con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = $validation;
				$class = 'alert-error';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listar($cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM  a_leer_bolivia_logos  
                 WHERE estado = 1 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssPushNoification extends DB
{
	public $pdo;
	public $screens;
	public function __construct()
	{
		$this->pdo = parent::connect();
		$this->screens = [
			['value' => 'app-iq-max://dashboard', 'label' => 'Principal'],
			['value' => 'app-iq-max://conocenos', 'label' => 'Conócenos'],
			['value' => 'app-iq-max://los-programas', 'label' => 'Los programas'],
			['value' => 'app-iq-max://contacto', 'label' => 'Contacto'],
			['value' => 'app-iq-max://entrenamientos', 'label' => 'Entrenamientos'],
			['value' => 'app-iq-max://lectura-categorias', 'label' => 'Test Lectura'],
			['value' => 'app-iq-max://razonamiento-categorias', 'label' => 'Test Razonamiento'],
			['value' => 'app-iq-max://cerebral-intro', 'label' => 'Test Cerebral'],
			['value' => 'app-iq-max://iq-categorias', 'label' => 'Test IQ'],
		];
	}

	function listar($cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM  push_notification_message  
                 WHERE active = 1 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function send($REQUEST)
	{
		$dato = array();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
				$rtn = 0;
				$msje = 'Token inválido al intentar enviar el mensaje';
				$class = 'alert-danger';
			} else {
				$url = URL . 'api/push-notification/send';
				$data = [
					"title" => trim($_POST['title']),
					"message" => trim($_POST['message']),
					"deepLink" => trim($_POST['deepLink']),
					"messageId" => $_POST['messageId']
				];

				$curl = curl_init();

				curl_setopt_array(
					$curl,
					array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => 'utf-8',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30, // Se ajustó a 30 segundos para evitar esperas infinitas
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						//CURLOPT_HEADER => true,
						CURLOPT_SSL_VERIFYPEER => false,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => json_encode($data),
						CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json'
						),
					)
				);

				$response = curl_exec($curl);
				$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

				if ($response === false || $status_code != 200) {
					$rtn = 0;
					if (curl_error($curl) == '') {
						$message = json_decode($response, true);
						$msje = 'Error al intentar enviar el mensaje.<br/>' . $message['message'];
					} else {
						$msje = 'Error al intentar enviar el mensaje.<br/>' . curl_error($curl);
					}
					$class = 'alert-danger';
				} else {
					$rtn = 1;
					$msje = 'Mensaje enviado con éxito';
					$class = 'alert-success';
				}

				curl_close($curl);
			}
		} else {
			$rtn = 0;
			$msje = 'Método no permitido para enviar el mensaje';
			$class = 'alert-danger';
		}

		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminar($REQUEST)
	{
		$rst = $this->updateData(
			'push_notification_message',
			array(
				'active' => 0
			),
			array(
				'id' => $REQUEST['cod']
			)
		);

		$dato = array();
		$dato['estado'] = 1;
		$dato['mensaje'] = 'Guardado con éxito';
		$dato['class'] = 'alert-success';
		return $dato;
	}

	function guardar($REQUEST)
	{
		try {
			$con = $this->pdo;

			// limit the title with no less than 5 characters
			$title = trim($REQUEST['title']);
			if (strlen($title) < 5) {
				$dato = array();
				$dato['estado'] = 0;
				$dato['mensaje'] = 'El título debe tener al menos 5 carácteres.';
				$dato['class'] = 'alert-danger';
				return $dato;
			}

			// limit the title with no more than 50 characters
			if (strlen($title) > 50) {
				$dato = array();
				$dato['estado'] = 0;
				$dato['mensaje'] = 'El título debe tener como máximo 50 carácteres.';
				$dato['class'] = 'alert-danger';
				return $dato;
			}

			// limit the message with no less than 5 characters
			$message = trim($REQUEST['message']);
			if (strlen($message) < 5) {
				$dato = array();
				$dato['estado'] = 0;
				$dato['mensaje'] = 'El mensaje debe tener al menos 5 carácteres.';
				$dato['class'] = 'alert-danger';
				return $dato;
			}

			// limit the message with no more than 200 characters
			if (strlen($message) > 200) {
				$dato = array();
				$dato['estado'] = 0;
				$dato['mensaje'] = 'El mensaje debe tener como máximo 200 carácteres.';
				$dato['class'] = 'alert-danger';
				return $dato;
			}

			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO push_notification_message (title,message,deepLink) VALUES (:title,:message,:deepLink)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':title' => trim($REQUEST['title']),
						':message' => $REQUEST['message'],
						':deepLink' => trim($REQUEST['deepLink'])
					)
				);

				$rtn = 1;
				$msje = 'Guardado con éxito';
				$class = 'alert-success';
			} else {
				$cod = $REQUEST['cod'];

				$rst = $this->selectRowData('push_notification_dispatch', '*', array('id' => $cod));
				if ($rst === false) {
					$sql = "UPDATE push_notification_message SET title =?, message =?, deepLink =?, updated_at=? WHERE id=?";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							trim($REQUEST['title']),
							$REQUEST['message'],
							$REQUEST['deepLink'],
							date('Y-m-d H:i:s'),
							$cod
						)
					);

					$rtn = 1;
					$msje = 'Guardado con éxito';
					$class = 'alert-success';
				} else {
					$rtn = 0;
					$msje = 'No puedes actualizar un mensaje enviado.';
					$class = 'alert-danger';
				}
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function findOptionLabelByValue($value)
	{
		foreach ($this->screens as $option) {
			if ($option['value'] === $value) {
				return $option['label'];
			}
		}
		return null;
	}
}

class ClssVideos extends DB
{
	public $pdo;
	protected $type;  // Add property declaration

	public function __construct($type)
	{
		$this->pdo = parent::connect();
		$this->type = $type;  // Initialize the property
	}

	function activate($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE video SET active=? WHERE slug='" . $this->type . "' and id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						($REQUEST['active'] == 1 ? 0 : 1),
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Registro actualizado con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar actualizar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminar($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE video SET estado=? WHERE slug='" . $this->type . "' and id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Registro eliminado con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardar($REQUEST)
	{
		try {
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO video (name,video,referencia,slug) VALUES (:name,:video,:referencia,:slug)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':name' => trim($REQUEST['name']),
						':video' => $REQUEST['video'],
						':referencia' => $REQUEST['referencia'],
						':slug' => slug($this->type)
					)
				);
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE video SET name =?, video =?, referencia = ? WHERE slug='" . $this->type . "' and id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						trim($REQUEST['name']),
						$REQUEST['video'],
						$REQUEST['referencia'],
						$cod
					)
				);
			}
			$rtn = 1;
			$msje = 'Guardado con éxito';
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
	}

	function listar($cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM  video  
                 WHERE  slug='" . $this->type . "' and estado = 1 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssTest extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function activoLectura($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$estado = ($REQUEST['estado'] == 0) ? 1 : 0;
				$sql = "UPDATE lectura SET " . " activo = ? " . " WHERE id = ? ";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$estado,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Se actualizó el estado de la lectura con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar actualizar el estado del registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function actualizarLectura($REQUEST, $FILE)
	{
		$cod = $REQUEST['cod'];
		global $SUBCATEGORIAS;
		if (in_array($REQUEST['subcategoria'], $SUBCATEGORIAS)) {
			$REQUEST['subtitulo'] = '';
			$REQUEST['texto'] = '';
			$REQUEST['cantidad_palabras'] = 0;
		}
		$rst = $this->updateData(
			'lectura',
			array(
				'subcategoria_id' => $REQUEST['subcategoria'],
				'titulo' => $REQUEST['titulo'],
				'subtitulo' => $REQUEST['subtitulo'],
				'texto' => trim($REQUEST['texto']),
				'cantidad_palabras' => $REQUEST['cantidad_palabras']
			),
			array(
				'id' => $cod
			)
		);
		if ($rst) {
			//ACTUALIZAR PREGUNTAS 
			if (isset($REQUEST['regTextoPregunta'])) {
				foreach ($REQUEST['regTextoPregunta'] as $k => $regTextoPregunta) {
					if ($regTextoPregunta != "") {
						if (isset($FILE['regImgPregunta']['name'][$k]) and $FILE['regImgPregunta']['name'][$k] != "") {
							global $EXTENSIONES_IMAGEN;
							$foto = subirFichero('regImgPregunta', '../' . PATH_IMG_TEST, $EXTENSIONES_IMAGEN);
							$archivoFoto = $foto['archivo'];
						} else {
							$foto = array(
								0,
								"",
								"'" . $REQUEST['regImgPregunta_hidden'][$k] . "'"
							);
							$archivoFoto = $REQUEST['regImgPregunta_hidden'][$k];
						}
						$rstUpd = $this->updateData(
							'pregunta',
							array(
								'lectura_id' => $cod,
								'texto' => trim($regTextoPregunta),
								'imagen' => $archivoFoto
							),
							array(
								'id' => $k
							)
						);
						$pos = 1;
						foreach ($REQUEST['regTextoAlternativa'] as $j => $regTextoAlternativa) {
							$arrAltObj = array();
							$arrAltObj = explode("_", $j);
							if (count($arrAltObj) == 2) {
								$arrAlt[0] = $arrAltObj[0]; //pregunta
								$arrAlt[1] = $arrAltObj[1]; //alternativa
								$arrAlt[2] = 0; //rand
							} else {
								$arrAlt[0] = $j; //pregunta
								$arrAlt[1] = 0; //alternativa
								$arrAlt[2] = $arrAltObj[2]; //rand
							}
							if ($arrAlt[0] == $k) {
								if ($regTextoAlternativa != "") {
									if ($arrAlt[2] == 0) {
										$correcto = (isset($REQUEST['regRbAlternativa'][$k])) ? $REQUEST['regRbAlternativa'][$k] : 0;
										($pos == $correcto) ? $strCorrecto = $correcto : $strCorrecto = "";
										$rstUpd = $this->updateData(
											'alternativa',
											array(
												'texto' => trim($regTextoAlternativa),
												'correcto' => $strCorrecto
											),
											array(
												'id' => $arrAlt[1]
											)
										);
									} else {
										$correcto = (isset($REQUEST['regRbAlternativa'][$k])) ? $REQUEST['regRbAlternativa'][$k] : 0;
										($pos == $correcto) ? $strCorrecto = $correcto : $strCorrecto = "";
										$rstIns = $this->insertData(
											'alternativa',
											array(
												'texto' => trim($regTextoAlternativa),
												'pregunta_id' => $arrAlt[0],
												'correcto' => $correcto
											)
										);
									}
								} else {
									$arrAlt = array();
									$arrAlt = explode("_", $j);
									$rstUpd = $this->updateData(
										'alternativa',
										array(
											'estado' => 0,
											'correcto' => ''
										),
										array(
											'id' => $arrAlt[1]
										)
									);
								}
								$pos++;
							}
						}
					} else {
						$rstUpd = $this->updateData(
							'pregunta',
							array(
								'estado' => 0
							),
							array(
								'id' => $k
							)
						);
						$rstUpd = $this->updateData(
							'alternativa',
							array(
								'estado' => 0
							),
							array(
								'pregunta_id' => $k
							)
						);
					}
				}
			}
			//NUEVAS PREGUNTAS 
			foreach ($REQUEST['textoPregunta'] as $k => $textoPregunta) {
				if ($textoPregunta != "") {
					if (isset($FILE['ImgPregunta']['name'][$k]) and $FILE['ImgPregunta']['name'][$k] != "") {
						global $EXTENSIONES_IMAGEN;
						$foto = subirFichero('ImgPregunta', '../' . PATH_IMG_TEST, $EXTENSIONES_IMAGEN);
						$archivoFoto = $foto['archivo'];
					} else {
						$foto = array(
							0,
							"",
							"'" . $REQUEST['ImgPregunta_hidden'][$k] . "'"
						);
						$archivoFoto = $REQUEST['ImgPregunta_hidden'][$k];
					}
					$rst = $this->insertData(
						'pregunta',
						array(
							'lectura_id' => $cod,
							'texto' => trim($textoPregunta),
							'imagen' => $archivoFoto
						)
					);
					$preguntaId = $rst;
					$pos = 1;
					foreach ($REQUEST['textoAlternativa'] as $j => $regTextoAlternativa) {
						if ($regTextoAlternativa != "") {
							$arrAlt = explode('_', $j);
							if ($k == $arrAlt[0]) {
								$correcto = (isset($REQUEST['rbAlternativa'][$k])) ? $REQUEST['rbAlternativa'][$k] : 0;
								($pos == $correcto) ? $strCorrecto = $correcto : $strCorrecto = "";
								$rstIns = $this->insertData(
									'alternativa',
									array(
										'texto' => trim($regTextoAlternativa),
										'pregunta_id' => $preguntaId,
										'correcto' => $strCorrecto
									)
								);
								$pos++;
							}
						}
					}
				}
			}
		}
		$dato = array();
		$dato['estado'] = 1;
		$dato['mensaje'] = 'Actualizado con éxito';
		$dato['class'] = 'alert-success';
		return $dato;
	}

	function insertarLectura($REQUEST, $FILE)
	{
		global $SUBCATEGORIAS;
		if (in_array($REQUEST['subcategoria'], $SUBCATEGORIAS)) {
			$REQUEST['subtitulo'] = '';
			$REQUEST['texto'] = '';
			$REQUEST['cantidad_palabras'] = 0;
		}
		$rst = $this->insertData(
			'lectura',
			array(
				'subcategoria_id' => $REQUEST['subcategoria'],
				'titulo' => $REQUEST['titulo'],
				'subtitulo' => $REQUEST['subtitulo'],
				'texto' => trim($REQUEST['texto']),
				'cantidad_palabras' => $REQUEST['cantidad_palabras']
			)
		);
		if ($rst) {
			$cod = $rst;
			foreach ($REQUEST['textoPregunta'] as $k => $textoPregunta) {
				if ($textoPregunta != "") {
					if (isset($FILE['ImgPregunta']['name'][$k]) and $FILE['ImgPregunta']['name'][$k] != "") {
						global $EXTENSIONES_IMAGEN;
						$foto = subirFichero('ImgPregunta', '../' . PATH_IMG_TEST, $EXTENSIONES_IMAGEN);
						$archivoFoto = $foto['archivo'];
					} else {
						$foto = array(
							0,
							"",
							"'" . $REQUEST['ImgPregunta_hidden'][$k] . "'"
						);
						$archivoFoto = $REQUEST['ImgPregunta_hidden'][$k];
					}
					$rst = $this->insertData(
						'pregunta',
						array(
							'lectura_id' => $cod,
							'texto' => trim($textoPregunta),
							'imagen' => $archivoFoto
						)
					);
					$preguntaId = $rst;
					$pos = 1;
					foreach ($REQUEST['textoAlternativa'] as $j => $regTextoAlternativa) {
						if ($regTextoAlternativa != "") {
							$arrAlt = explode('_', $j);
							if ($k == $arrAlt[0]) {
								if (isset($REQUEST['rbAlternativa'][$k])) {
									$rbAlternativax = $REQUEST['rbAlternativa'][$k];
									($pos == $rbAlternativax) ? $strCorrecto = $rbAlternativax : $strCorrecto = "";
								} else {
									$strCorrecto = "";
								}
								$rstIns = $this->insertData(
									'alternativa',
									array(
										'texto' => trim($regTextoAlternativa),
										'pregunta_id' => $preguntaId,
										'correcto' => $strCorrecto
									)
								);
								$pos++;
							}
						}
					}
				}
			}
		}
		$dato = array();
		$dato['estado'] = 1;
		$dato['mensaje'] = 'Guardado con éxito';
		$dato['class'] = 'alert-success';
		return $dato;
	}

	function listarResultado($tipo = [], $dateFilter = [])
	{
		$tipos = "'" . implode("','", $tipo) . "'";
		$sql = "SELECT * FROM resultado WHERE restipo IN (" . $tipos . ")";

		if (!empty($dateFilter)) {
			if (isset($dateFilter['month'])) {
				$sql .= " AND MONTH(created_at) = " . $dateFilter['month'];
			}
			if (isset($dateFilter['year'])) {
				$sql .= " AND YEAR(created_at) = " . $dateFilter['year'];
			}
		}

		$sql .= " ORDER BY created_at DESC";
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function listarLectura($cod = '', $categoria = '', $subcategoria = '', $paginado = 0, $cantidad = 10, $buscar = '')
	{
		$where = "";
		$limit = "";
		if ($subcategoria != "") {
			$where .= " and l.subcategoria_id=" . $subcategoria;
		}
		if ($categoria != "") {
			$where .= " and sc.categoria_id=" . $categoria;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		if ($cod != "") {
			$where .= " and l.id=" . $cod;
		}
		if ($buscar != "") {
			$where .= " and (
                            l.texto LIKE '%" . $buscar . "%' OR 
                             c.nombre LIKE '%" . $buscar . "%' OR 
                            sc.nombre LIKE '%" . $buscar . "%')";
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
                       l.estado = 1  
                 " . $where . " ORDER BY l.id DESC " . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function eliminarLectura($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE lectura SET " . " estado=? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$sql = "UPDATE pregunta SET " . " estado=? " . " WHERE lectura_id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Lectura eliminada con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listarSubCategoria($cod = '', $categoria = '', $paginado = 0, $cantidad = 10, $buscar = '')
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		if ($buscar != "") {
			$where .= " and (nombre LIKE '%" . $buscar . "%')";
		}
		$sql = "SELECT * 
                  FROM subcategoria  
                 WHERE categoria_id=" . $categoria . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function listarCategoria($cod = '', $paginado = 0, $cantidad = 10, $buscar = '')
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		if ($buscar != "") {
			$where .= " and (nombre LIKE '%" . $buscar . "%')";
		}
		$sql = "SELECT * 
                   FROM  categoria 
                 WHERE 1 = 1 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function listarPregunta($cod = '', $lectura = '', $paginacion = false)
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		$sql = "SELECT * 
                   FROM  pregunta 
                 WHERE estado = 1 and lectura_id=" . $lectura . $where;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function listarAlternativas($cod = '', $pregunta = '', $paginacion = false)
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		$sql = "SELECT * 
                   FROM  alternativa 
                 WHERE estado = 1 and pregunta_id=" . $pregunta . $where;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}
//////////////////////////////////////////////////////////////////////////
/*                            SISTEMA                                   */
//////////////////////////////////////////////////////////////////////////

class ClssLogeo extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function getLogeo($text_usu, $text_pass)
	{
		$data = $this->selectRowData(
			'usuario',
			'*',
			array(
				'usuario' => $text_usu,
				'clave' => $text_pass,
				'estado' => 1
			)
		);
		if ($data != false) {
			$datax = $this->selectRowData(
				'persona',
				'*',
				array(
					'id' => $data['persona_id'],
					'estado' => 1
				)
			);
			if ($datax != false) {
				$_SESSION['COD_USER_CITEXBO_ADM'] = $data['id'];
				$_SESSION['USER_CITEXBO_ADM'] = $text_usu;
				$_SESSION['CODPER_USER_CITEXBO_ADM'] = $datax['id'];
				$_SESSION['TIPO_USER_CITEXBO_ADM'] = $data['usuario_tipo_id'];
				$_SESSION['GENERO_USER_CITEXBO_ADM'] = 1;
				$_SESSION['NOM_USER_CITEXBO_ADM'] = $datax['nombres'];
				$_SESSION['APEPA_USER_CITEXBO_ADM'] = $datax['apepa'];
				$_SESSION['APEMA_USER_CITEXBO_ADM'] = $datax['apema'];
				$_SESSION['EMAIL_USER_CITEXBO_ADM'] = $datax['email'];
				$_SESSION['AVATAR_USER_CITEXBO_ADM'] = $datax['foto'];
				$rst = 1;
			} else {
				$rst = 0;
			}
		} else {
			$rst = 0;
		}
		return $rst;
	}
}

class ClssUsuario extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function actualizar($REQUEST, $FILES)
	{
		try {
			if (isset($FILES['foto']['name']) and $FILES['foto']['name'] != "") {
				global $EXTENSIONES_IMAGEN;
				$foto = subirFichero('foto', '../' . PATH_IMG_RANKING, $EXTENSIONES_IMAGEN, 160, 160);
				$validation = $foto['error'];
				$imagen = $foto['archivo'];
			} else {
				$validation = true;
				$imagen = $REQUEST['foto_HIDDEN'];
			}
			$rtn = 1;
			$msje = '';
			$class = 'alert-error';
			$con = $this->pdo;
			if (trim($REQUEST['clave'] != "")) {
				if (trim($REQUEST['clave']) == trim($REQUEST['reclave'])) {
					$sql = "UPDATE usuario SET " . " clave=? " . " WHERE id=?";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							trim($REQUEST['clave']),
							$_SESSION['COD_USER_CITEXBO_ADM']
						)
					);
					$rtn = 1;
				} else {
					$rtn = 0;
					$msje = 'La confirmación de la contraseña es incorrecta.';
					$class = 'alert-error';
				}
			} else {
				if ($rtn == 1) {
					$sql = "UPDATE persona SET " . " nombres=?, " . " apepa=?, " . " apema=?, " . " foto=?, " . " email=? " . " WHERE id=?";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							trim($REQUEST['nombres']),
							trim($REQUEST['apepa']),
							trim($REQUEST['apema']),
							$imagen,
							trim($REQUEST['email']),
							$_SESSION['CODPER_USER_CITEXBO_ADM']
						)
					);
					$_SESSION['NOM_USER_CITEXBO_ADM'] = trim($REQUEST['nombres']);
					$_SESSION['APEPA_USER_CITEXBO_ADM'] = trim($REQUEST['apepa']);
					$_SESSION['APEMA_USER_CITEXBO_ADM'] = trim($REQUEST['apema']);
					$_SESSION['EMAIL_USER_CITEXBO_ADM'] = trim($REQUEST['email']);
					$_SESSION['AVATAR_USER_CITEXBO_ADM'] = $imagen;
					$rtn = 1;
					$msje = 'Datos actualizados con éxito.';
					$class = 'alert-success';
				}
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}
}

class ClssGeneral extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function inputSelectList($table, $id, $field, $index, $where = NULL, $orden = "")
	{
		$cont_w = 1;
		$tot_where = ($where !== NULL && is_array($where)) ? count($where) : 0;
		$condition = '';
		if ($where !== NULL && is_array($where)) {
			foreach ($where as $key => $value) {
				($cont_w < $tot_where) ? ($sep = ' AND ') : ($sep = '');
				$condition .= "$key='$value'$sep";
				$cont_w++;
			}
		}
		$sql = "SELECT $id, $field as campo FROM $table";
		if (!empty($condition)) {
			$sql .= " WHERE $condition";
		}
		($orden == "") ? $sql .= " ORDER BY $field asc" : $sql .= " ORDER BY " . $orden;
		$rst = $this->selectDataQuery($sql);
		foreach ($rst as $row) {
			($row[$id] == $index) ? ($select = 'selected="selected"') : ($select = '');
			print '<option value="' . $row["$id"] . '" ' . $select . '>' . ($row["campo"]) . '</option>' . "\n";
		}
	}
}

class ClssMaterial extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function guardarCategoria($REQUEST)
	{
		try {
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO material_categoria (nombre,slug) " . "VALUES (:nombre,:slug)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':nombre' => $REQUEST['nombre'],
						':slug' => slug($REQUEST['nombre'])
					)
				);
				$msje = 'Guardado con éxito';
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE material_categoria SET " . " nombre =?, " . " slug = ? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['nombre'],
						slug($REQUEST['nombre']),
						$cod
					)
				);
				$msje = 'Actualizado con éxito';
			}
			$rtn = 1;
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminarCategoria($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE material_categoria SET " . " estado=? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Categoría eliminada con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminar($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "UPDATE material SET " . " estado=? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						0,
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Material eliminado con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardar($REQUEST, $FILES)
	{
		try {
			if ($REQUEST['material_tipo'] == 2) { //archivo
				if (isset($FILES['archivo']['name']) and $FILES['archivo']['name'] != "") {
					global $EXTENSIONES_FILE;
					$file = subirFichero('archivo', '../' . PATH_MATERIAL, $EXTENSIONES_FILE);
					$validaFile = $file['error'];
					$archivo = $file['archivo'];
				} else {
					$validaFile = true;
					$archivo = $REQUEST['archivo_HIDDEN'];
				}
				$archivo_down = NULL;
			} else {
				$validaFile = true;
				$archivo = $REQUEST['video'];
				//var_dump($_FILES);
				//                print_r($FILES);
				//                die();
				if (isset($FILES['archivo_down']['name']) and $FILES['archivo_down']['name'] != "") {
					global $EXTENSIONES_FILE;
					$file = subirFichero('archivo_down', '../' . RUTA_VIDEO, $EXTENSIONES_FILE);
					$validaFile = $file['error'];
					$archivo_down = $file['archivo'];
				} else {
					$archivo_down = $REQUEST['archivo_down_HIDDEN'];
				}
			}
			if ($validaFile) {
				$con = $this->pdo;
				if ($REQUEST['cod'] == 0) {
					$sql = "INSERT INTO material (material_categoria_id,material_tipo_id,nombre,archivo,archivo_down) " . "VALUES (:material_categoria_id,:material_tipo_id,:nombre,:archivo,:archivo_down)";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							':material_categoria_id' => $REQUEST['material_categoria'],
							':material_tipo_id' => $REQUEST['material_tipo'],
							':nombre' => $REQUEST['nombre'],
							':archivo' => $archivo,
							':archivo_down' => $archivo_down
						)
					);
					$msje = 'Guardado con éxito';
				} else {
					$cod = $REQUEST['cod'];
					$sql = "UPDATE material SET " . " material_categoria_id =?, " . " material_tipo_id = ?, " . " nombre = ?, " . " archivo = ?, " . " archivo_down = ? " . " WHERE id=?";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							$REQUEST['material_categoria'],
							$REQUEST['material_tipo'],
							$REQUEST['nombre'],
							$archivo,
							$archivo_down,
							$cod
						)
					);
					$msje = 'Actualizado con éxito';
				}
				$rtn = 1;
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = $archivo;
				$class = 'alert-error';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function listar($cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and t1.id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT t1.*, t2.nombre as categoria, t3.nombre as tipo 
                   FROM  material t1, material_categoria t2, material_tipo t3  
                 WHERE t1.estado = 1 AND t2.estado = 1 AND t3.estado = 1 AND
                 t1.material_categoria_id = t2.id AND t1.material_tipo_id = t3.id 
                 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function categoria($cod = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM  material_categoria 
                 WHERE estado = 1 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function tipo()
	{
		$sql = "SELECT * 
                   FROM  material_tipo 
                 WHERE estado = 1 ";
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}
}

class ClssTestiQ extends DB
{
	public $pdo;
	public function __construct()
	{
		$this->pdo = parent::connect();
	}

	function tipo($cod = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and t1.id=" . $cod;
		}
		$sql = "SELECT t1.*, t2.nombre as categoria , t2.edad_inicio as edad_min, t2.edad_fin as edad_max  
                   FROM  serie_tipo t1, categoria t2
                 WHERE t1.categoria_id = t2.id " . $where;
		$rst = $this->selectDataQuery($sql);
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
                   FROM  serie  
                 WHERE 1 = 1 " . $where;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function pregunta($cod = '', $serie = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if ($serie != "") {
			$where .= " and serie_id=" . $serie;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT * 
                   FROM  serie_pregunta  
                 WHERE 1 = 1 " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function alternativa($cod = '', $pregunta = '', $serie = '', $paginado = 0, $cantidad = 10)
	{
		$where = "";
		$limit = "";
		if ($cod != "") {
			$where .= " and t1.id=" . $cod;
		}
		if ($pregunta != "") {
			$where .= " and t1.serie_pregunta_id=" . $pregunta;
		}
		if ($serie != "") {
			$where .= " and t2.serie_id=" . $serie;
		}
		if (!is_null($paginado) and !is_null($cantidad)) {
			$limit .= "  LIMIT " . $paginado . "," . $cantidad;
		}
		$sql = "SELECT t1.*  
                   FROM  serie_alternativa t1, serie_pregunta t2  
                 WHERE t1.serie_pregunta_id = t2.id  " . $where . $limit;
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function eliminarPregunta($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "DELETE FROM serie_pregunta WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Pregunta eliminada con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function percentil($tipo = '', $cod = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and id=" . $cod;
		}
		if ($tipo != "") {
			$where .= " and serie_tipo_id=" . $tipo;
		}
		$sql = "SELECT * 
                   FROM percentil  
                 WHERE 1=1 " . $where . " ORDER BY valor ASC";
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function serieEdad($cod = '', $serie = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and t1.id=" . $cod;
		}
		if ($serie != "") {
			$where .= " and t1.id=" . $serie;
		}
		$sql = "SELECT t2.*, t3.id as edad_id, t3.valor as edad, t1.nombre as categoria, t1.id as categoria_id  
                    FROM categoria t1,
                         serie_tipo t2,
                         edad t3
                 WHERE t1.id = t2.categoria_id AND 
                        t2.id = t3.categoria_id
                 " . $where . " ORDER BY t3.valor ASC";
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function percentilEdad($cod = '', $percentil = '')
	{
		$where = "";
		if ($cod != "") {
			$where .= " and t1.id=" . $cod;
		}
		if ($percentil != "") {
			$where .= " and t1.percentil_id=" . $percentil;
		}
		$sql = "SELECT t1.*, t2.valor as edad, t3.nombre as categoria, t3.id as categoria_id  
                   FROM percentil_edad t1,
                         edad t2,
                         categoria t3
                 WHERE t1.edad_id = t2.id AND 
                        t2.categoria_id = t3.id 
                 " . $where . " ORDER BY t3.nombre ASC, t1.valor ASC";
		$rst = $this->selectDataQuery($sql);
		return $rst;
	}

	function eliminarPercentilEdad($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "DELETE FROM percentil_edad WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Edad del percentil eliminado con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminarPercentil($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "DELETE FROM percentil WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Percentil eliminado con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function eliminarAlternativa($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "DELETE FROM serie_alternativa WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Alternativa eliminada con éxito.';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar eliminar el registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardarPregunta($REQUEST, $FILES)
	{
		try {
			if (isset($FILES['archivo']['name']) and $FILES['archivo']['name'] != "") {
				global $EXTENSIONES_IMAGEN;
				$file = subirFichero('archivo', '../' . PATH_TESTIQ, $EXTENSIONES_IMAGEN);
				$validaFile = $file['error'];
				$archivo = $file['archivo'];
			} else {
				$validaFile = true;
				$archivo = $REQUEST['archivo_HIDDEN'];
			}
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO serie_pregunta (serie_id,nombre,file) " . "VALUES (:serie_id,:nombre,:file)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':serie_id' => $REQUEST['serie_id'],
						':nombre' => $REQUEST['nombre'],
						':file' => $archivo
					)
				);
				$msje = 'Guardado con éxito';
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE serie_pregunta SET " . " serie_id = ?, " . " nombre = ?, " . " file = ? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['serie_id'],
						$REQUEST['nombre'],
						$archivo,
						$cod
					)
				);
				$msje = 'Actualizado con éxito';
			}
			$rtn = 1;
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function verdaderoAlternativa($REQUEST)
	{
		try {
			if ($REQUEST['cod'] != 0) {
				$msje = '';
				$con = $this->pdo;
				$sql = "SELECT *  
                          FROM serie_alternativa
                         WHERE id = " . $REQUEST['cod'];
				$rst = $this->selectDataQuery($sql);
				$preguntaId = $rst[0]['serie_pregunta_id'];
				$sql = "UPDATE serie_alternativa SET " . " verdader = 0 " . " WHERE serie_pregunta_id = ? ";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$preguntaId
					)
				);
				$sql = "UPDATE serie_alternativa SET " . " verdader = 1 " . " WHERE id = ? ";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['cod']
					)
				);
				$rtn = 1;
				$msje = 'Se actualizó el estado de la alternativa con éxito';
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Error al intentar actualizar el estado del registro.';
				$class = 'alert-danger';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardarPercentil($REQUEST)
	{
		try {
			$con = $this->pdo;
			$sql = "SELECT * 
                      FROM percentil  
                     WHERE valor = " . $REQUEST['valor'] . " AND 
                            serie_tipo_id = " . $REQUEST['tipo'] . " AND 
                            id <> " . $REQUEST['cod'];
			$rst = $this->selectDataQuery($sql);
			if (count($rst) == 0) {
				if ($REQUEST['cod'] == 0) {
					$sql = "INSERT INTO percentil (serie_tipo_id,nombre,detalle,valor) " . "VALUES (:serie_tipo_id,:nombre,:detalle,:valor)";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							':serie_tipo_id' => $REQUEST['tipo'],
							':nombre' => trim($REQUEST['nombre']),
							':detalle' => trim($REQUEST['detalle']),
							':valor' => $REQUEST['valor']
						)
					);
					$msje = 'Guardado con éxito';
				} else {
					$cod = $REQUEST['cod'];
					$sql = "UPDATE percentil SET " . " nombre = ?, " . " detalle = ?, " . " valor = ? " . " WHERE id=?";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							trim($REQUEST['nombre']),
							trim($REQUEST['detalle']),
							$REQUEST['valor'],
							$REQUEST['cod']
						)
					);
					$msje = 'Actualizado con éxito';
				}
				$rtn = 1;
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Ya existe el valor para este percentil, intenta con otro.';
				$class = 'alert-warning';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardarPercentilEdad($REQUEST)
	{
		try {
			$con = $this->pdo;
			$sql = "SELECT * 
                      FROM percentil_edad  
                     WHERE percentil_id = " . $REQUEST['percentil'] . " AND 
                            edad_id = " . $REQUEST['edad'] . " AND 
                            valor = " . $REQUEST['valor'] . " AND 
                            id <> " . $REQUEST['cod'];
			$rst = $this->selectDataQuery($sql);
			if (count($rst) == 0) {
				if ($REQUEST['cod'] == 0) {
					$sql = "INSERT INTO percentil_edad (percentil_id,edad_id,valor) " . "VALUES (:percentil_id,:edad_id,:valor)";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							':percentil_id' => $REQUEST['percentil'],
							':edad_id' => $REQUEST['edad'],
							':valor' => $REQUEST['valor']
						)
					);
					$msje = 'Guardado con éxito';
				} else {
					$cod = $REQUEST['cod'];
					$sql = "UPDATE percentil_edad SET " . " percentil_id = ?, " . " edad_id = ?, " . " valor = ? " . " WHERE id=?";
					$q = $con->prepare($sql);
					$rtn = $q->execute(
						array(
							$REQUEST['percentil'],
							$REQUEST['edad'],
							$REQUEST['valor'],
							$REQUEST['cod']
						)
					);
					$msje = 'Actualizado con éxito';
				}
				$rtn = 1;
				$class = 'alert-success';
			} else {
				$rtn = 0;
				$msje = 'Ya existe el valor para la edad de este percentil, intenta con otro.';
				$class = 'alert-warning';
			}
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardarAlternativa($REQUEST, $FILES)
	{
		try {
			if (isset($FILES['archivo']['name']) and $FILES['archivo']['name'] != "") {
				global $EXTENSIONES_IMAGEN;
				$file = subirFichero('archivo', '../' . PATH_TESTIQ, $EXTENSIONES_IMAGEN);
				$validaFile = $file['error'];
				$archivo = $file['archivo'];
			} else {
				$validaFile = true;
				$archivo = $REQUEST['archivo_HIDDEN'];
			}
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				$sql = "INSERT INTO serie_alternativa (serie_pregunta_id,nombre,file) " . "VALUES (:serie_pregunta_id,:nombre,:file)";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						':serie_pregunta_id' => $REQUEST['serie_pregunta_id'],
						':nombre' => $REQUEST['nombre'],
						':file' => $archivo
					)
				);
				$msje = 'Guardado con éxito';
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE serie_alternativa SET " . " serie_pregunta_id = ?, " . " nombre = ?, " . " file = ? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['serie_pregunta_id'],
						$REQUEST['nombre'],
						$archivo,
						$cod
					)
				);
				$msje = 'Actualizado con éxito';
			}
			$rtn = 1;
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardarTipo($REQUEST)
	{
		try {
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				//no hay nuevo registro
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE serie_tipo SET " . " nombre = ?, " . " slug = ?  " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['nombre'],
						$REQUEST['slug'],
						$cod
					)
				);
				$sql = "UPDATE categoria SET " . " edad_inicio = ?, " . " edad_fin = ? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['edad_min'],
						$REQUEST['edad_max'],
						$REQUEST['categoria']
					)
				);
				$msje = 'Actualizado con éxito';
			}
			$rtn = 1;
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}

	function guardarSerie($REQUEST)
	{
		try {
			$con = $this->pdo;
			if ($REQUEST['cod'] == 0) {
				//no hay nuevo registro
			} else {
				$cod = $REQUEST['cod'];
				$sql = "UPDATE serie SET " . " nombre = ?, " . " serie_tipo_id = ? " . " WHERE id=?";
				$q = $con->prepare($sql);
				$rtn = $q->execute(
					array(
						$REQUEST['nombre'],
						$REQUEST['serie_tipo_id'],
						$cod
					)
				);
				$msje = 'Actualizado con éxito';
			}
			$rtn = 1;
			$class = 'alert-success';
		} catch (PDOException $e) {
			$rtn = 0;
			$msje = $e->getMessage();
			$class = 'alert-error';
		}
		$dato = array();
		$dato['estado'] = $rtn;
		$dato['mensaje'] = $msje;
		$dato['class'] = $class;
		return $dato;
	}
}
?>
