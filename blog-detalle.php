<?php
require_once("require/configuracion.php");
require_once("require/util.php");
require_once("require/transacciones.php");
require('constants/index.php');
require('helpers/index.php');

$objBlog = new ClssBlog();
$categoria = (isset($categoria)) ? $categoria : "";
$q = (isset($q)) ? $q : "";
$etiqueta = (isset($etiqueta)) ? $etiqueta : "";

$_PAGE_SLUG = getInfoPage('blog', $_MENU);
$_COLOR = 'C5CC21';

$blog = (isset($blog)) ? $blog : "";
$arrBlogs = $objBlog->blog('', $blog);
$arrBlog = $arrBlogs['result'][0];
$URL_ACTUAL = URL . PAG_ACTUAL . "-" . $blog;

$_META_BLOG = array(
	'title' => $arrBlog['titulo'],
	'description' => substr(html_entity_decode(strip_tags($arrBlog['detalle'])), 0, 100) . "...",
	'image' => URL . PATH_BLOG . $arrBlog['imagen'],
	'link' => $URL_ACTUAL,
);

include('parts/share/header.php');
include('parts/blog/title.php');
?>

<section id="blog-content" class="blog-detail">
	<div class='container'>
		<div class='row'>
			<div class='col-md-8'>
				<?php include("parts/blog/detail.php") ?>
			</div>
			<div class='col-md-4'>
				<?php include("parts/blog/aside.php") ?>
			</div>
		</div>
	</div>
</section>

<?php include('parts/share/contact.php'); ?>
<?php include('parts/share/footer.php'); ?>