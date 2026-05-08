				<?php
      	if($categoria!="") {
			$strSeccion = "<h2>Categoría: </h2>";
			$noDatos = "Lo sentimos, no hay registros con la categoría seleccionada.";
		} else if($q!="") {
			$strSeccion = "<h2>Resultado: ".$q."</h2>";
			$noDatos = "Lo sentimos, no hay registros con el texto buscado.";
		} else if($etiqueta!="") {
			$strSeccion = "<h2>Etiqueta: </h2>";
			$noDatos = "Lo sentimos, no hay registros con la etiqueta seleccionada.";
		} else {
			$strSeccion = "";
			$noDatos = "Lo sentimos, aún no hay registros.";
		}
	  ?>
				<div class="row list ">
					<div class="col-md-12">
						<?php echo $strSeccion?>
					</div>
					<?php 
	$arrBlogs = $objBlog -> blog("","",$categoria,$etiqueta,$q);
	if($arrBlogs['total']!=0) {
		foreach($arrBlogs['result'] as $arrBlog) {
      ?>
					<div class="col-md-12" style=" margin-bottom: 16px">
						<div class="card ">
							<img src="<?php echo PATH_BLOG.$arrBlog['imagen']?>" class="img-fluid" />
							<div class="card-body">
								<div class="card-date">Publicado el <?php echo formatoFecha($arrBlog['publicado_el'])?></div>
								<div class="card-title"><?php echo $arrBlog['titulo']?></div>
								<div class="card-text"><?php echo substr( html_entity_decode(strip_tags($arrBlog['detalle'])), 0, 250)."..."; ?></div>
							</div>
							<a href="blog-detalle-<?php echo $arrBlog['slug']?>" class="card-link" title="ver">Leer más</a>
						</div>
					</div>
					<?php }
  } else { ?>

					<div class="col-md-12">
						<?php echo $noDatos; ?>
					</div>
					<?php  }
  ?>
	</div>