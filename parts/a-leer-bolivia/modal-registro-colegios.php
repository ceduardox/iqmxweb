<?php
require_once ("require/util.php");
require_once ("require/transacciones.php");

$obj = new ClssALeerBoliviaFicha();
$ficha = "";
$name = "";
$pathFile = "";

$rows = $obj->lista('Colegios');

if ($rows['total'] != 0) {
  $ficha = $rows['result'][0]['document'];
  $name = $rows['result'][0]['name'];
  $pathFile = PATH_A_LEER_BOLIVIA_FICHAS . $ficha;
}
?>
<div class="modal fade" id="modalRegistroColegios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="modalRegistroColegios" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class='header'>
              <div class='header-image'>
                <img src='./assets/images/modal-colegios.svg' alt='colegios' />
              </div>
              <div class='header-text'>
                <h2>INSCRIPCIÓN DE</h2>
                <h1>COLEGIOS</h1>
                <h3>¡SÉ PARTE DE LA REVOLUCIÓN EDUCATIVA!</h3>
              </div>
            </div>
            <div class='container-main'>
              <?php if ($ficha != "") { ?>
              <div class='descarga'>
                <a href='<?php echo $pathFile; ?>' target='blank' download="<?php echo $ficha ?>"
                  title="Descargar <?php echo $name ?>">
                  <img src='./assets/images/modal-descarga-icono.svg' alt='descarga' />
                  <p class='descarga-text'>DESCARGA CONVOCATORIA</p>
                </a>
              </div>
              <?php } ?>
              <p>Al completar este formulario, tu colegio dará el primer paso hacia un futuro donde la
                educación y la lectura van de la mano, transformando no solo a estudiantes, sino también
                a comunidades.</p>

              <div class='form col-md-12'>
                <form class="row g-3" name="formColegio" id="formColegio" method="post" action="./include/ajax">
                  <input type="hidden" name="tipo" value="formRegistroColegio" />
                  <input type="hidden" name="file" value="<?php echo $pathFile ?>" />
                  <div class='subtitle'>
                    <p>RESPONSABLE DEL EVENTO</p>
                    <hr />
                  </div>
                  <div class="col-md-6">
                    <label for="nombre_responsable" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control required" id="nombre_responsable"
                      name="nombre_responsable" />
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
                    <input type="text" class="form-control required" id="profesion_responsable"
                      name="profesion_responsable" />
                  </div>
                  <div class="col-md-6">
                    <label for="telefono_responsable" class="form-label">Teléfono</label>
                    <input type="text" class="form-control required" id="telefono_responsable"
                      name="telefono_responsable" />
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
                    <input type="text" class="form-control required" id="nombre_institucion"
                      name="nombre_institucion" />
                  </div>
                  <div class="col-md-6">
                    <label for="razon_social_institucion" class="form-label">Razón Social</label>
                    <input type="text" class="form-control required" id="razon_social_institucion"
                      name="razon_social_institucion" />
                  </div>
                  <div class="col-md-6">
                    <label for="nit_institucion" class="form-label">NIT</label>
                    <input type="text" class="form-control required" id="nit_institucion" name="nit_institucion" />
                  </div>
                  <div class="col-md-12">
                    <label for="direccion_institucion" class="form-label">Dirección</label>
                    <input type="text" class="form-control required" id="direccion_institucion"
                      name="direccion_institucion" />
                  </div>
                  <div class="col-md-6">
                    <label for="telefono_institucion" class="form-label">Teléfonos</label>
                    <input type="text" class="form-control required" id="telefono_institucion"
                      name="telefono_institucion" />
                  </div>
                  <div class="col-md-6">
                    <label for="email_institucion" class="form-label">Email</label>
                    <input type="email" class="form-control required" id="email_institucion" name="email_institucion" />
                  </div>
                  <div class='subtitle'>
                    <p>COLABORADOR ASIGNADO</p>
                    <hr />
                  </div>
                  <div class="col-md-6">
                    <label for="nombre_colaborador" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control required" id="nombre_colaborador"
                      name="nombre_colaborador" />
                  </div>
                  <div class="col-md-6">
                    <label for="ci_colaborador" class="form-label">C.I.</label>
                    <input type="text" class="form-control required" id="ci_colaborador" name="ci_colaborador" />
                  </div>
                  <div class="col-md-6">
                    <label for="cargo_colaborador" class="form-label">Cargo en la
                      institución</label>
                    <input type="text" class="form-control required" id="cargo_colaborador" name="cargo_colaborador" />
                  </div>
                  <div class="col-md-6">
                    <label for="profesion_colaborador" class="form-label">Profesión o
                      Actividad</label>
                    <input type="text" class="form-control required" id="profesion_colaborador"
                      name="profesion_colaborador" />
                  </div>
                  <div class="col-md-6">
                    <label for="telefono_colaborador" class="form-label">Teléfono</label>
                    <input type="text" class="form-control required" id="telefono_colaborador"
                      name="telefono_colaborador" />
                  </div>
                  <div class="col-md-6">
                    <label for="email_colaborador" class="form-label">Email</label>
                    <input type="email" class="form-control required" id="email_colaborador" name="email_colaborador" />
                  </div>
                  <div class="status"></div>
                  <div class='button-area'>
                    <div class="g-recaptcha" data-sitekey="<?php echo KEY_CAPTCHA_PUBLIC_V2; ?>"></div>
                    <br />
                    <button type='button' onclick='sendFormColegio()'>
                      SOLICITAR REGISTRO
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
function sendFormColegio() {
  $('#formColegio').submit();
}

function showRequestColegio(formData) {
  $("#formColegio .status").fadeIn();
  $("#formColegio .status").html("Estamos enviando tus datos, espera un momento...")
}

function showResponseColegio(responseText) {
  var obj = JSON.parse(responseText);
  habilitarInputs("formColegio");

  if (obj['estado'] == 1) {
    $("#formColegio").reset();
  }

  $("#formColegio .status").fadeOut();
  alert(obj['mensaje'])

  var widgetId = $("#formColegio").find('.g-recaptcha').attr('data-grecaptcha-id');
  grecaptcha.reset(widgetId);
}

$(document).ready(function() {
  $("#formColegio").validate({
    submitHandler: function(form) {
      $(form).ajaxSubmit({
        beforeSubmit: showRequestColegio,
        success: showResponseColegio
      });
    }
  });
});
</script>