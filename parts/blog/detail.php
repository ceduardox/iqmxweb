<?php
$objBlog = new ClssBlog();
$blog = (isset($blog)) ? $blog : "";
$arrBlogs = $objBlog->blog('', $blog);
if ($arrBlogs['total'] == 0) {
	header("Location: blog");
	exit();
}

$arrBlog = $arrBlogs['result'][0];
$URL_ACTUAL = updateURL(URL . PAG_ACTUAL . "-" . $blog);
?>
<a href="./blog" title="volver" class="back"><i class="fa fa-angle-left"></i> volver</a>
<article>
	<h1 class="titulo"><?php echo $arrBlog['titulo'] ?></h1>
	<div class="posteado"><i class="icon-time"></i>Publicado el <?php echo formatoFecha($arrBlog['publicado_el']) ?></div>
	<div class="imagen"> <img src="<?php echo PATH_BLOG . $arrBlog['imagen'] ?>" class="img-fluid" /></div>
	<div class="texto">
		<div class="detalle"><?php echo ($arrBlog['detalle']) ?></div>
	</div>
	<div class="socials-links"> <a href="http://www.facebook.com/sharer.php?u=<?php echo $URL_ACTUAL ?>"
			class="fb windowOpen">COMPARTIR</a> <a href="http://twitter.com/share?url=<?php echo $URL_ACTUAL ?>"
			class="tw windowOpen">TWEET</a> <a
			href="mailto:?subject=<?php echo espacioURL($arrBlog['titulo']) ?>&body=<?php echo espacioURL("Hola, te envío esta noticia que me parecio muy interesante") ?>"
			class="email">ENVIAR POR CORREO</a> </div>
</article>