<?php
require_once(__DIR__ . "/config.runtime.php");

//URL
define("URL", iqmaximo_config("IQMAXIMO_URL", "https://iqmaximo.com/")); 
define("URL_ACTUAL",'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']); 
define("PAG_ACTUAL",str_replace(".php","",basename($_SERVER['PHP_SELF']))); 

//SECCION CONTACTO
define("MAIL_INFO", iqmaximo_config("IQMAXIMO_MAIL_INFO", "info@iQmaximo.com"));  
define("MAIL_WEBMASTER", iqmaximo_config("IQMAXIMO_MAIL_WEBMASTER", "info@iQmaximo.com"));

//CAPTCHA
define("KEY_CAPTCHA_PUBLIC", iqmaximo_config("IQMAXIMO_RECAPTCHA_PUBLIC", ""));
define("KEY_CAPTCHA_SECRET", iqmaximo_config("IQMAXIMO_RECAPTCHA_SECRET", ""));  

//CAPTCHA v2
define("KEY_CAPTCHA_PUBLIC_V2", iqmaximo_config("IQMAXIMO_RECAPTCHA_PUBLIC_V2", ""));
define("KEY_CAPTCHA_SECRET_V2", iqmaximo_config("IQMAXIMO_RECAPTCHA_SECRET_V2", ""));  

//BASE DE DATOS
$link = false; 

define("SERVER", iqmaximo_config("IQMAXIMO_DB_HOST", "localhost")); 
define("BASE_DE_DATOS", iqmaximo_config("IQMAXIMO_DB_NAME", ""));
define("USUARIO", iqmaximo_config("IQMAXIMO_DB_USER", "")); 
define("CLAVE", iqmaximo_config("IQMAXIMO_DB_PASSWORD", ""));

//IMGS  
define("PATH_RANKING", "img/personas/"); 
define("PATH_BLOG", "img/blog/"); 
define("PATH_USUARIO", "img/usuarios/"); 
define("PATH_MATERIAL", "img/material/"); 
define("PATH_TESTIQ", "img/testiq/"); 
define("RUTA_LANDING", 'landing/registro/assets/img/'); 
define("PATH_A_LEER_BOLIVIA_LOGOS", "uploads/a-leer-bolivia-logos/"); 
define("PATH_A_LEER_BOLIVIA_FICHAS", "uploads/a-leer-bolivia-fichas/"); 

//RAND
define("RAND",date("ymdHis")); 

//SOCIALMEDIA
$SOCIAL_MEDIA = array();
$SOCIAL_MEDIA['fb'] = array('url'=>'https://www.facebook.com/IQmaxBo','nombre'=>'Facebook');
$SOCIAL_MEDIA['tw'] = array('url'=>'https://twitter.com/IQmaxBo','nombre'=>'Twitter');
$SOCIAL_MEDIA['yt'] = array('url'=>'https://www.youtube.com/channel/UCd7TzLXg1uXNtQqd1oYOGfA','nombre'=>'YouTube');

//TEST
$_TEST = array();
$_TEST['cerebral'] = array('nombre'=>'CEREBRAL','nombre_largo'=>'TEST DE ','link'=>'test-cerebral','imagen'=>'testIconos1.png');
$_TEST['razonamiento'] = array('nombre'=>'RAZONAMIENTO','nombre_largo'=>'TEST DE RAZONAMIENTO','link'=>'test-razonamiento','imagen'=>'testIconos2.png', 'subCate-nino' => 6, 'subCate-adolescente' => 4, 'subCate-adulto' => 2, 'subCate-preescolar' => 8);
$_TEST['lectura'] = array('nombre'=>'LECTURA','nombre_largo'=>'TEST DE LECTURA','link'=>'test-lectura','imagen'=>'testIconos3.png', 'subCate-nino' => 5, 'subCate-adolescente' => 3, 'subCate-adulto' => 1, 'subCate-preescolar' => 7);
$_TEST['iq'] = array('nombre'=>'iQ','nombre_largo'=>'TEST iQ','link'=>'test-iq','imagen'=>'testIconos4.png');

?>
