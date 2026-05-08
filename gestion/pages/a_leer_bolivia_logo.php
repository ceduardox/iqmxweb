<?php
extract($_REQUEST);
$cls = new ClssALeerBoliviaLogos();
$cod = (isset($cod)) ? $cod : 0;
$dato = $cls->listar($cod);
if ($cod == 0) {
  $dato[0]['name'] = '';
  $dato[0]['image'] = '';
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li>A Leer Bolivia</li>
    <li class="active">Logos</li>
  </ol>
  <h1><i class="fa fa-file-image-o"></i> Auspiciadores <small>Editar información</small> </h1>
</section>
<!-- Main content -->
<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data">
  <input type="hidden" value="guardarALeerBoliviaLogo" name="accion" />
  <input type="hidden" value="<?php echo $cod; ?>" name="cod" />
  <section class="content ">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos del Auspiciador</h3>
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
              <label for="type">Tipo </label>
              <select name="type" id="type" class="form-control">
                <option value="Auspiciador" <?php echo ($dato[0]['type'] == 'Auspiciador') ? 'selected' : ''; ?>>
                  Auspiciador</option>
                <option value="Colegio" <?php echo ($dato[0]['type'] == 'Colegio') ? 'selected' : ''; ?>>Colegio
                </option>
              </select>
            </div>
            <div class="form-group">
              <label for="image">Logo </label>
              <input type="file" id="image" name="image" />
              <input type="hidden" name="image_HIDDEN" value="<?php echo $dato[0]['image']; ?>" />
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar">Guardar</button>
        <button type="button" onclick="javascript:location.href='page-a_leer_bolivia_logos'" class="btn btn-default"
          id="btn-cancelar" name="cancelar">Volver</button>
        <div class="alert hidden"></div>
      </div>
    </div>
  </section>
</form>
<!-- /.content -->
<script>
  $(function () {
    var options = {
      beforeSubmit: showRequest,
      success: showResponse
    };
    $("#form_").validate({
      submitHandler: function (form) {
        $(form).ajaxSubmit(options);
      }
    });
  });
</script>