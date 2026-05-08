<?php
extract($_REQUEST);
$cls  = new ClssALeerBoliviaFicha();
$cod  = (isset($cod)) ? $cod : 0;
$dato = $cls->listar($cod);
if ($cod == 0) {
    $dato[0]['name'] = '';
    $dato[0]['document'] = '';
    $dato[0]['type'] = '';
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li>A Leer Bolivia</li>
    <li class="active">Fichas</li>
  </ol>
  <h1><i class="fa fa-file-text"></i> Fichas <small>Editar información</small> </h1>
</section>
<!-- Main content -->
<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data">
  <input type="hidden" value="guardarALeerBoliviaFicha" name="accion" />
  <input type="hidden" value="<?php echo $cod;?>" name="cod" />
  <section class="content ">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos de la Ficha</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="name">Nombre </label>
              <input name="name" id="name" type="text" class="required form-control"
                value="<?php echo $dato[0]['name']; ?>" />
            </div>
            <div class="form-group">
              <label for="document">Documento </label>
              <input type="file" id="document" name="document" />
              <input type="hidden" name="document_HIDDEN" value="<?php echo $dato[0]['document'];?>" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="type">Tipo </label>
              <select name="type" id="type" class="required form-control">
                <option value="">Seleccione</option>
                <option value="Colegios" <?php echo ($dato[0]['type'] == 'Colegios') ? 'selected' : ''; ?>>Colegios
                </option>
                <option value="Auspiciadores" <?php echo ($dato[0]['type'] == 'Auspiciadores') ? 'selected' : ''; ?>>
                  Auspiciadores</option>
                <option value="Estudiantes" <?php echo ($dato[0]['type'] == 'Estudiantes') ? 'selected' : ''; ?>>
                  Estudiantes</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar">Guardar</button>
        <button type="button" onclick="javascript:location.href='page-a_leer_bolivia_fichas'" class="btn btn-default"
          id="btn-cancelar" name="cancelar">Volver</button>
        <div class="alert hidden"></div>
      </div>
    </div>
  </section>
</form>
<!-- /.content -->
<script>
$(function() {
  var options = {
    beforeSubmit: showRequest,
    success: showResponse
  };
  $("#form_").validate({
    submitHandler: function(form) {
      $(form).ajaxSubmit(options);
    }
  });
});
</script>