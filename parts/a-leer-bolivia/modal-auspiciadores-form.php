<div class='form col-md-12'>
  <form class="row g-3" name="formAuspiciadores" id="formAuspiciadores" method="post" action="./include/ajax">
    <input type="hidden" name="tipo" value="formRegistroAuspiciador" />
    <input type="hidden" name="file" value="<?php echo $pathFile ?>" />
    <div class='subtitle'>
      <p>RESPONSABLE DEL EVENTO</p>
      <hr />
    </div>
    <div class="col-md-6">
      <label for="nombre_responsable" class="form-label">Nombre completo</label>
      <input type="text" class="form-control required" id="nombre_responsable" name="nombre_responsable" />
    </div>
    <div class="col-md-6">
      <label for="ci_responsable" class="form-label">C.I.</label>
      <input type="text" class="form-control required" id="ci_responsable" name="ci_responsable" />
    </div>
    <div class="col-md-6">
      <label for="cargo_responsable" class="form-label">Cargo en la
        Institución</label>
      <input type="text" class="form-control required" id="cargo_responsable" name="cargo_responsable" />
    </div>
    <div class="col-md-6">
      <label for="profesion_responsable" class="form-label">Profesión o
        Actividad</label>
      <input type="text" class="form-control required" id="profesion_responsable" name="profesion_responsable" />
    </div>
    <div class="col-md-6">
      <label for="telefono_responsable" class="form-label">Teléfono</label>
      <input type="text" class="form-control required" id="telefono_responsable" name="telefono_responsable" />
    </div>
    <div class="col-md-6">
      <label for="email_responsable" class="form-label">Email</label>
      <input type="email" class="form-control required" id="email_responsable" name="email_responsable" />
    </div>
    <div class='subtitle'>
      <p>DATOS DE LA INSTITUCIÓN</p>
      <hr />
    </div>
    <div class="col-md-12">
      <label for="nombre_institucion" class="form-label">Nombre de la
        Institución</label>
      <input type="text" class="form-control required" id="nombre_institucion" name="nombre_institucion" />
    </div>
    <div class="col-md-6">
      <label for="razon_social" class="form-label">Razón Social</label>
      <input type="text" class="form-control required" id="razon_social" name="razon_social" />
    </div>
    <div class="col-md-6">
      <label for="nit" class="form-label">NIT</label>
      <input type="text" class="form-control required" id="nit" name="nit" />
    </div>
    <div class="col-md-12">
      <label for="direccion" class="form-label">Dirección</label>
      <input type="text" class="form-control required" id="direccion" name="direccion" />
    </div>
    <div class="col-md-6">
      <label for="telefono_institucion" class="form-label">Teléfonos</label>
      <input type="text" class="form-control required" id="telefono_institucion" name="telefono_institucion" />
    </div>
    <div class="col-md-6">
      <label for="email_institucion" class="form-label">Email</label>
      <input type="email" class="form-control required" id="email_institucion" name="email_institucion" />
    </div>
    <div class="status"></div>
    <div class='button-area'>
      <div class="g-recaptcha" data-sitekey="<?php echo KEY_CAPTCHA_PUBLIC_V2; ?>"></div>
      <br />
      <button type='button' onclick='sendFormAuspiciador()'>
        SOLICITAR REGISTRO
      </button>
    </div>
  </form>
</div>

<script type="text/javascript">
function sendFormAuspiciador() {
  $('#formAuspiciadores').submit();
}

function showRequestAuspiciador(formData) {
  $("#formAuspiciadores .status").fadeIn();
  $("#formAuspiciadores .status").html("Estamos enviando tus datos, espera un momento...")
}

function showResponseAuspiciador(responseText) {
  var obj = JSON.parse(responseText);
  habilitarInputs("formAuspiciadores");

  if (obj['estado'] == 1) {
    $("#formAuspiciadores").reset();
  }

  $("#formAuspiciadores .status").fadeOut();
  alert(obj['mensaje'])

  var widgetId = $("#formAuspiciadores").find('.g-recaptcha').attr('data-grecaptcha-id');
  grecaptcha.reset(widgetId);
}

$(document).ready(function() {
  $("#formAuspiciadores").validate({
    submitHandler: function(form) {
      $(form).ajaxSubmit({
        beforeSubmit: showRequestAuspiciador,
        success: showResponseAuspiciador
      });
    }
  });
});
</script>