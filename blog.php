<?php
require_once("require/configuracion.php");
require_once("require/util.php");
require_once("require/transacciones.php");
$objBlog = new ClssBlog();  
$categoria = (isset($categoria)) ? $categoria : ""; 
$q = (isset($q)) ? $q : ""; 
$etiqueta = (isset($etiqueta)) ? $etiqueta : ""; 
?>
<?php require( 'constants/index.php' ); ?>
<?php require( 'helpers/index.php' ); ?>

<?php $_PAGE_SLUG = getInfoPage('blog', $_MENU); ?>
<?php $_COLOR = 'C5CC21'; ?>
<?php include( 'parts/share/header.php' );?>
<?php include( 'parts/blog/title.php' );?>

<section id="blog-content" class="blog-list" >
	<div class='container'>
		<div class='row'>
			<div class='col-md-8'>
				<?php include("parts/blog/list.php")?>
			</div>
			<div class='col-md-4'>
				<?php include("parts/blog/aside.php")?>
			</div>
		</div>
	</div>
</section>

<?php include( 'parts/share/contact.php' );?>
<?php include( 'parts/share/footer.php' );?>