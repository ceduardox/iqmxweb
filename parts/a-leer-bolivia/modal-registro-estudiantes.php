<?php
require_once ("require/util.php");
require_once ("require/transacciones.php");

$obj = new ClssALeerBoliviaFicha();
$ficha = "";
$name = "";
$pathFile = "";

$rows = $obj->lista('Estudiantes');

if ($rows['total'] != 0) {
  $ficha = $rows['result'][0]['document'];
  $name = $rows['result'][0]['name'];
  $pathFile = PATH_A_LEER_BOLIVIA_FICHAS . $ficha;
}
?>
<div class="modal fade" id="modalRegistroEstudiantes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="modalRegistroEstudiantes" aria-hidden="true">
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
                <img src='./assets/images/modal-estudiantes.svg' alt='estudiantes' />
              </div>
              <div class='header-text'>
                <h2>INSCRIPCIÓN DE</h2>
                <h1>ESTUDIANTES</h1>
                <h3>¡HOLA, JOVEN EXPLORADOR DEL CONOCIMIENTO!</h3>
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
              <p>Prepárate para sumergirte en historias que despierten tu imaginación, descubrir
                conocimientos que alimenten tu mente<br /> y participar en desafíos que fortalezcan tu
                espíritu. Estamos emocionados de verte crecer y evolucionar en este viaje.</p>
              <br />
              <p class='bold-text'><b>¡Completa el formulario y sé parte de esta gran aventura
                  lectora!</b></p>
              <div class='form col-md-12'>
                <form class="row g-3" name="formEstudiante" id="formEstudiante" method="post" action="./include/ajax">
                  <input type="hidden" name="tipo" value="formRegistroEstudiante" />
                  <input type="hidden" name="file" value="<?php echo $pathFile ?>" />
                  <div class='subtitle'>
                    <p>IDENTIFICACIÓN DEL PADRE/MADRE O TUTOR</p>
                    <hr />
                  </div>
                  <div class="col-md-12">
                    <label for="nombre_tutor" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control required" id="nombre_tutor" name="nombre_tutor" />
                  </div>
                  <div class="col-md-6">
                    <label for="parentesco" class="form-label">Parentesco</label>
                    <input type="text" class="form-control required" id="parentesco" name="parentesco" />
                  </div>
                  <div class="col-md-6">
                    <label for="estudiante_ci" class="form-label">C.I.</label>
                    <input type="text" class="form-control required" id="estudiante_ci" name="estudiante_ci" />
                  </div>
                  <div class="col-md-6">
                    <label for="telefono_tutor" class="form-label">Teléfonos</label>
                    <input type="text" class="form-control required" id="telefono_tutor" name="telefono_tutor" />
                  </div>
                  <div class="col-md-6">
                    <label for="email_tutor" class="form-label">Email</label>
                    <input type="email" class="form-control required" id="email_tutor" name="email_tutor" />
                  </div>
                  <div class='subtitle'>
                    <p>INFORMACIÓN DEL ESTUDIANTE</p>
                    <hr />
                  </div>
                  <div class="col-md-12">
                    <label for="nombre_estudiante" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control required" id="nombre_estudiante" name="nombre_estudiante" />
                  </div>
                  <div class="col-md-6">
                    <label for="nacimiento_estudiante" class="form-label">Fecha de
                      nacimiento</label>
                    <input type="text" class="form-control required" id="nacimiento_estudiante"
                      name="nacimiento_estudiante" />
                  </div>
                  <div class="col-md-6">
                    <label for="edad_estudiante" class="form-label">Edad</label>
                    <input type="number" class="form-control required" id="edad_estudiante" name="edad_estudiante" />
                  </div>
                  <div class="col-md-6">
                    <label for="colegio_estudiante" class="form-label">Colegio</label>
                    <input type="text" class="form-control required" id="colegio_estudiante"
                      name="colegio_estudiante" />
                  </div>
                  <div class="col-md-6">
                    <label for="grado_estudiante" class="form-label">Grado</label>
                    <input type="text" class="form-control required" id="grado_estudiante" name="grado_estudiante" />
                  </div>
                  <div class="col-md-6">
                    <label for="telefono_estudiante" class="form-label">Teléfono</label>
                    <input type="text" class="form-control required" id="telefono_estudiante"
                      name="telefono_estudiante" />
                  </div>
                  <div class="col-md-6">
                    <label for="email_estudiante" class="form-label">Email</label>
                    <input type="email" class="form-control required" id="email_estudiante" name="email_estudiante" />
                  </div>
                  <div class="status"></div>
                  <div class='button-area'>
                    <div class="g-recaptcha" data-sitekey="<?php echo KEY_CAPTCHA_PUBLIC_V2; ?>"></div>
                    <br />
                    <button type='button' onclick='sendFormEstudiante()'>
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
function sendFormEstudiante() {
  $('#formEstudiante').submit();
}

function showRequestEstudiante(formData) {
  $("#formEstudiante .status").fadeIn();
  $("#formEstudiante .status").html("Estamos enviando tus datos, espera un momento...")
}

function showResponseEstudiante(responseText) {
  var obj = JSON.parse(responseText);
  habilitarInputs("formEstudiante");

  if (obj['estado'] == 1) {
    $("#formEstudiante").reset();
  }

  $("#formEstudiante .status").fadeOut();
  alert(obj['mensaje'])

  var widgetId = $("#formEstudiante").find('.g-recaptcha').attr('data-grecaptcha-id');
  grecaptcha.reset(widgetId);
}

$(document).ready(function() {
  $("#formEstudiante").validate({
    submitHandler: function(form) {
      $(form).ajaxSubmit({
        beforeSubmit: showRequestEstudiante,
        success: showResponseEstudiante
      });
    }
  });
});
</script>