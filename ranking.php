<?php require( 'constants/index.php' ); ?>
<?php require( 'helpers/index.php' ); ?>

<?php 
require_once("require/configuracion.php");
require_once("require/util.php");
require_once("require/transacciones.php");

extract($_REQUEST);
$ANHO = (isset($anho) and $anho!="") ? $anho : date("Y");
$mes = (!isset($mes)) ? date("n") : $mes;
$mes = ($mes==0) ? 1 : $mes;
$personasID = "";
$objRanking = new ClssRanking();  
?>

<?php $_PAGE_SLUG = getInfoPage('ranking', $_MENU); ?>
<?php $_COLOR = '229F73'; ?>
<?php include( 'parts/share/header.php' );?>
<?php include( 'parts/ranking/title.php' );?>
<?php include( 'parts/ranking/top.php' );?>
<?php include( 'parts/ranking/destacados.php' );?>
<?php include( 'parts/share/contact.php' );?>
<?php include( 'parts/share/footer.php' );?>