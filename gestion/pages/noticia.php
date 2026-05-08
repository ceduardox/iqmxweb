<?php
extract($_REQUEST);
$cls = new ClssNoticia();
$cod = (isset($cod)) ? $cod : 0;
$dato = $cls->listar($cod);
if ($cod == 0) {
    $dato[0]['slug'] = '';
    $dato[0]['titulo'] = '';
    $dato[0]['detalle'] = '';
    $dato[0]['imagen'] = ''; 
    $dato[0]['publicado_el'] = date('d/m/Y');
}
 ?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Noticias</li>
  </ol>
  <h1><i class="fa fa-newspaper-o"></i> Noticias <small>Editar noticia</small> </h1>
</section>

<!-- Main content -->
<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data" >
        <input type="hidden" value="guardarNoticia" name="accion" />
        <input type="hidden" value="<?php echo $cod ?>" name="cod" />
  <section class="content col-md-9">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos de la noticia</h3>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="titulo">Título</label>
          <input type="text" id="titulo" name="titulo" class="required form-control" value="<?php echo $dato[0]['titulo'] ?>" />
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="input-group">
              <label for="imagen">Imagen <span class="text-mini">(Ancho: 820px Alto: 500px)</span>
                <?php if ($dato[0]['imagen'] != "") { ?>
                (<a href="../<?php echo RUTA_NOTICIA . $dato[0]['imagen'] ?>" target="_blank" title="ver imagen">ver imagen</a>)
                <?php } ?>
              </label>
              <input type="file" id="imagen" name="imagen"  />
              <input type="hidden"  name="imagen_HIDDEN" value="<?php echo $dato[0]['imagen'] ?>" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="publicado_el">Fecha de publicación</label>
              <div class="input-group">
                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                <input type="text" id="publicado_el" name="publicado_el" class="required fecha form-control pull-right" data-mask data-date-format="dd/mm/yyyy"  value="<?php echo setFormatoFecha($dato[0]['publicado_el']) ?>" />
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="detalle">Detalle</label>
          <textarea name="detalle_HIDDEN" id="detalle_HIDDEN"><?php echo limpiaTextoAdmin($dato[0]['detalle']) ?></textarea>
          <textarea name="detalle" class="hidden" id="detalle"><?php echo limpiaTextoAdmin($dato[0]['detalle']) ?></textarea>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>
        <button type="button" onclick="javascript:location.href='page-noticias'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
        <div class="alert hidden"></div>
      </div>
    </div>
  </section>
  <section class="content col-md-3">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Categorías</h3>
      </div>
      <div class="box-body">
        <?php
$cateNoticia = array(); 
$categorias = $cls->getNoticiaCategoria(NULL,$cod);
foreach($categorias as $categoria) {
	array_push($cateNoticia,$categoria['id']);
}
 
$categorias = $cls->getCategoriaNoticia();
foreach($categorias as $categoria) {
	$checked = (in_array($categoria['id'],$cateNoticia)) ? "checked='checked'" : "";
?>
        <label for="categorias-<?php echo $categoria['id']?>" class="chk">
          <input type="checkbox" value="<?php echo $categoria['id']?>" <?php echo $checked?> id="categorias-<?php echo $categoria['id']?>" name="categorias[]" />
          <?php echo $categoria['nombre']?></label>
        <br>
        <?php }
?>
      </div>
    </div>
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Etiquetas</h3>
      </div>
      <div class="box-body">
        <?php
$etiqNoticia = array(); 
$etiquetas = $cls->getNoticiaEtiqueta(NULL,$cod);
foreach($etiquetas as $etiqueta) {
	array_push($etiqNoticia,$etiqueta['id']);
}

$etiquetas = $cls->getEtiquetaNoticia();
foreach($etiquetas as $etiqueta) {
	$checked = (in_array($etiqueta['id'],$etiqNoticia)) ? "checked='checked'" : "";
?>
        <label for="etiquetas-<?php echo $etiqueta['id']?>" class="chk">
          <input type="checkbox" value="<?php echo $etiqueta['id']?>" <?php echo $checked?> id="etiquetas-<?php echo $etiqueta['id']?>" name="etiquetas[]" />
          <?php echo $etiqueta['nombre']?></label>
        <br>
        <?php }
?>
      </div>
    </div>
  </section>
  <div class="clearfix"></div>
</form>
<!-- /.content -->
<link rel="stylesheet" href="plugins/datepicker/css/datepicker.css">
<script src="plugins/datepicker/js/bootstrap-datepicker.js"></script> 
<script src="plugins/ckeditor/ckeditor.js?v=1"></script> 
<script>
      $(function () {
        var editor = CKEDITOR.replace('detalle_HIDDEN'); 
		editor.on( 'change', function( evt ) {
			$('#detalle').text(evt.editor.getData());
		});
  
        $(".fecha").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $('.fecha').datepicker();

        var options = {beforeSubmit: showRequest, success: showResponse};
        $("#form_").validate({
            submitHandler: function (form) {
                $(form).ajaxSubmit(options);
            }
        });
    });
</script> 
