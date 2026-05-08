<?php
extract($_REQUEST);
$cls = new ClssPushNoification();
$cod = (isset($cod)) ? $cod : 0;

if ($cod == 0) {
  echo "<script>location.href='page-push-notification-messages'</script>";
}

$row = $cls->listar($cod);

if (!isset($_SESSION['csrf_token'])) {
  if (function_exists('openssl_random_pseudo_bytes')) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
  } else {
    $_SESSION['csrf_token'] = bin2hex(mt_rand());
  }
}

$label = $cls->findOptionLabelByValue($row[0]['deepLink']);
$screen = $label ? $label : 'No encontrado';
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Notificación Push</li>
  </ol>
  <h1><i class="fa fa-mobile"></i> Enviar mensaje </h1>
</section>
<!-- Main content -->
<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data">
  <section class="content">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos del mensaje</h3>
      </div>
      <div class="box-body">
        <input type="hidden" value="sendPushNotification" name="accion" />
        <input type="hidden" value="<?php echo $cod ?>" name="messageId" />
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?>">
        <div class="form-group">
          <label for="title"><b>Título</b></label>
          <p><?php echo $row[0]['title'] ?></p>
        </div>
        <div class="form-group">
          <label for="message"><b>Mensaje</b></label>
          <p><?php echo $row[0]['message'] ?></p>
        </div>
        <div class="form-group">
          <label for="deepLink"><b>Link</b></label>
          <p><?php echo $screen ?></p>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="enviar" name="enviar">Enviar</button>
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