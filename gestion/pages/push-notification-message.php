<?php
extract($_REQUEST);
$cls = new ClssPushNoification();
$cod = (isset($cod)) ? $cod : 0;
$dato = $cls->listar($cod);

if ($cod == 0) {
  $dato[0]['title'] = '';
  $dato[0]['message'] = '';
  $dato[0]['deepLink'] = '';
}

function displayRadioButtons($options, $default = 'dashboard')
{
  $html = '';
  foreach ($options as $option) {
    // Verificar si el valor actual debe estar seleccionado
    $checked = ($option['value'] === $default) ? 'checked' : '';
    $html .= sprintf(
      '<label><input type="radio" name="deepLink" value="%s" %s> %s</label><br>',
      htmlspecialchars($option['value']),
      $checked,
      htmlspecialchars($option['label'])
    );
  }
  return $html;
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Notificación Push</li>
  </ol>
  <h1><i class="fa fa-mobile"></i> Mensajes <small>Editar información</small> </h1>
</section>
<!-- Main content -->
<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data">
  <section class="content">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos del mensaje</h3>
      </div>
      <div class="box-body">
        <input type="hidden" value="guardarPushNotification" name="accion" />
        <input type="hidden" value="<?php echo $cod ?>" name="cod" />

        <div class="col-md-8">
          <div class="form-group">
            <label for="title">Título</label>
            <input type="text" id="title" name="title" class="required form-control"
              value="<?php echo $dato[0]['title'] ?>" minlength="5" maxlength="50" />
          </div>
          <div class="form-group">
            <label for="message">Mensaje</label>
            <input type="text" id="message" name="message" class="required form-control"
              value="<?php echo $dato[0]['message'] ?>" minlength="5" maxlength="200" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <p><b>Pantalla</b></p>
            <?php echo displayRadioButtons($cls->screens, $dato[0]['deepLink']); ?>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar">Guardar</button>
        <button type="button" onclick="javascript:location.href='page-push-notification-messages'"
          class="btn btn-default" id="btn-cancelar" name="cancelar">Volver</button>
        <div class="alert hidden"></div>
      </div>
    </div>
  </section>
  <div class="clearfix"></div>
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