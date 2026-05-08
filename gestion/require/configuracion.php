<?php
require_once(__DIR__ . "/../../require/config.runtime.php");

date_default_timezone_set("America/La_Paz");
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(-1);

//EXTENSIONES 
$EXTENSIONES_IMAGEN  = array("JPG","JPEG","GIF","PNG"); 
$EXTENSIONES_VIDEO   = array("MP4","MPEG"); 
$EXTENSIONES_FILE    = array("XLS","XLSX","DOC","DOCX","PPT","PPTX","PDF","RAR","ZIP","TXT"); 
$EXTENSIONES_PDF     = array("PDF"); 

//SUBCATEGORIAS
$SUBCATEGORIAS = array("2","4","6"); 

//RAND
define("RAND", date("ymdHis")); 

//BASE DE DATOS
define("SERVER_GESTION", iqmaximo_config("IQMAXIMO_DB_HOST", "localhost"));
define("BASE_DE_DATOS_GESTION", iqmaximo_config("IQMAXIMO_DB_NAME", "")); 
define("USUARIO_GESTION", iqmaximo_config("IQMAXIMO_DB_USER", "")); 
define("CLAVE_GESTION", iqmaximo_config("IQMAXIMO_DB_PASSWORD", ""));

//PATH
define("RUTA_NOTICIA", "img/blog/");
define("PATH_IMG_RANKING", "img/personas/");
define("RUTA_USUARIO", "img/personas/");
define("PATH_MATERIAL", "img/material/"); 
define("RUTA_FILES", "upload/files/");
define("RUTA_VIDEO", "upload/video/");
define("PATH_TESTIQ", "img/testiq/"); 
define("PATH_CONTACTO", "img/contacto/"); 
define("PATH_A_LEER_BOLIVIA_LOGOS", "uploads/a-leer-bolivia-logos/"); 
define("PATH_A_LEER_BOLIVIA_FICHAS", "uploads/a-leer-bolivia-fichas/"); 
define("RUTA_LANDING", 'landing/registro/assets/img/'); 
 
 //URL 
define("URL", iqmaximo_config("IQMAXIMO_URL", "https://iqmaximo.com/"));
define("URL_ACTUAL", str_replace('.php', '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']));
define("PAG_ACTUAL_FULL", basename($_SERVER['PHP_SELF']));
define("PAG_ACTUAL", str_replace('.php', '', PAG_ACTUAL_FULL));
define("QUERY_ACTUAL", str_replace('.php', '', $_SERVER['QUERY_STRING']));


?>
