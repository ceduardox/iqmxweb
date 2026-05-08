<?php
global $objBlog,$etiqueta,$categoria,$q;
?>
<aside>
	<div class="card mb-3">
		<div class="card-header">
			BUSCADOR
		</div>
		<div class="card-body">
			<form name="form_q" id="form_q" method="get" action="blog">
				<div class="input-group ">
					<input type="text" id="q" class="form-control" placeholder="Buscar" name="q"
						value="<?php echo ($q!="") ? $q : ""?>">
					<button class="q" class="btn btn-outline-secondary" type="button" style="    border: 1px solid #ced4da;
    color: #fff!important; background-color: rgb(28, 63, 112);"
						onClick="javascript:buscar()">Buscar</button>
				</div>
			</form>
		</div>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			CATEGOR&Iacute;AS
		</div>
		<div class="card-body">
			<ul class="arrow">
				<li><a href="blog">Todos</a></li>
				<?php 
	$arrCategorias = $objBlog -> categoria();
	if($arrCategorias['total']!=0) {
		foreach($arrCategorias['result'] as $arrCategoria) {
			$activo = ($arrCategoria['slug']==$categoria) ? "activo" : "";
     ?>
				<li><a href="blog-categoria-<?php echo $arrCategoria['slug']?>"
						class="<?php echo $activo?>"><?php echo $arrCategoria['nombre']?></a></li>
				<?php }
  } 
  ?>
			</ul>
		</div>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			ETIQUETAS
		</div>
		<div class="card-body">
			<ul class="tag">
				<?php 
	$arrEtiquetas = $objBlog -> etiqueta();
	if($arrEtiquetas['total']!=0) {
		foreach($arrEtiquetas['result'] as $arrEtiqueta) {
			$activo = ($arrEtiqueta['slug']==$etiqueta) ? "activo" : "";
     ?>
				<li><a href="blog-tag-<?php echo $arrEtiqueta['slug']?>"
						class="<?php echo $activo?>"><?php echo $arrEtiqueta['nombre']?></a></li>
				<?php }
  } 
  ?>
			</ul>
		</div>
	</div>
</aside>