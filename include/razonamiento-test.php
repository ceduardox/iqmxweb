<?php
session_start();
extract($_REQUEST);
header('Content-Type: text/html; charset=utf-8');
require_once(__DIR__ . "/../require/configuracion.php");
require_once(__DIR__ . "/../require/util.php");
require_once(__DIR__ . "/../require/transacciones.php");
$objeto = new ClssTest();

$arrClss = $objeto->listarLectura($lecturaIDCitex);
$arrLect = $arrClss['result'][0];
$_SESSION['lecturaIDCitex'] = $arrLect['id'];
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php if ($tipo == 'test') { ?>

  <div class="lectura">
    <?php if ($tipoMuestra == 'preguntas') { ?>
      <?php
      $arrClssPregs = $objeto->listarPregunta('', $arrLect['id']);
      $cta = 1;
      $sCtaAlt = "";
      foreach ($arrClssPregs['result'] as $preguntasx) {
        ($cta == 1) ? $ocultar = "" : $ocultar = "ocultar";
        ?>
        <div id="preg<?php echo $cta ?>" class="pregunta <?php echo $ocultar ?>"> <?php echo $cta ?>.
          <?php echo nl2br(trim($preguntasx['texto'])) ?><br />
          <?php
          if ($preguntasx['imagen'] != "") {
            echo "<br/><img src='img/test/" . $preguntasx['imagen'] . "' /><br/><br/>";
          }
          ?>
          <?php
          $arrClssAlt = $objeto->listarAlternativas('', $preguntasx['id']);
          $ctaAlt = 1;
          foreach ($arrClssAlt['result'] as $alternativasx) {
            if ($alternativasx['correcto'] != "") {
              $sCtaAlt .= $alternativasx['correcto'] . ",";
            }
            ?>
            <label for="preg<?php echo $ctaAlt . "-" . $cta ?>">
              <input type="radio" name="preg<?php echo $ctaAlt ?>" id="preg<?php echo $ctaAlt . "-" . $cta ?>"
                value="<?php echo $ctaAlt ?>" />
              <span>
                <?php echo $alternativasx['texto'] ?>
              </span></label>
            <?php
            $ctaAlt++;
          }
          ?>
        </div>
        <?php
        $cta++;
      }
      ?>
      <div class="ocultar" id='info-form'>
        <p>Para que puedas conocer tu resultado del Test, completa los siguientes datos con información real ya
          que el resultado se mostrara en pantalla y se enviará a la bandeja de entrada del EMAIL que haz colocado en los
          campos correspondientes:</p> <br />
        <div class='container'>
          <div class='row'>
            <div class='form col-md-12'>
              <form name="formTest" id="formTest" method="post" action="include/ajax" class="row g-3">
                <div class="col-md-6">
                  <label class="form-label" for="nombreTest">NOMBRE:</label>
                  <input name="nombreTest" type="text" id="nombreTest" class="required form-control" />
                </div>

                <div class="col-md-2">
                  <label class="form-label" for='edadTest'>EDAD:</label>
                  <input name='edadTest' type='number' min='1' max='99' maxlength='2' id='edadTest' class='required form-control' />
                </div>

                <div class="col-md-4">
                  <label class="form-label" for="ciudadTest">CIUDAD:</label>
                  <input name="ciudadTest" type="text" id="ciudadTest" class="required form-control" />
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="emailTest">EMAIL:</label>
                  <input name="emailTest" type="text" id="emailTest" class="required email form-control" />
                </div>

                <div class="col-md-6">
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label" for='fonoTest'>TELÉFONO:</label>
                      <input name='fonoTest' type='text' id='fonoTest' class='required form-control' />
                    </div>
                    <div class="col-md-8">
                      <label class="form-label" for='soyTest'>SOY:</label>
                      <select name='soyTest' id='soyTest' class='required form-control'
                        onchange="javascript:soy(this.value)">
                        <option value='soy_estudiante_colegio'>Estudiante de colegio</option>
                        <option value='estudiante_universitario'>Estudiante universitario</option>
                        <option value='profesional'>Profesional</option>
                        <option value='ninguno'>Ninguno</option>
                      </select>
                    </div>
                  </div>
                </div>


                <!-- soy_estudiante_colegio -->
                <div class="col-md-5 soyTestSelector soy_estudiante_colegio">
                  <label class="form-label" for='semestreTest_soy_estudiante_colegio'>GRADO ESCOLAR:</label>
                  <select name='semestreTest_soy_estudiante_colegio' id='semestreTest_soy_estudiante_colegio'
                    class='required form-control'>
                    <optgroup label='Primaria'>
                      <option value='1ro_de_Primaria'>1ro de Primaria</option>
                      <option value='2do_de_Primaria'>2do de Primaria</option>
                      <option value='3ro_de_Primaria'>3ro de Primaria</option>
                      <option value='4to_de_Primaria'>4to de Primaria</option>
                      <option value='5to_de_Primaria'>5to de Primaria</option>
                      <option value='6to_de_Primaria'>6to de Primaria</option>
                    </optgroup>
                    <optgroup label='Secundaria'>
                      <option value='1ro_de_Secundaria'>1ro de Secundaria</option>
                      <option value='2do_de_Secundaria'>2do de Secundaria</option>
                      <option value='3ro_de_Secundaria'>3ro de Secundaria</option>
                      <option value='4to_de_Secundaria'>4to de Secundaria</option>
                      <option value='5to_de_Secundaria'>5to de Secundaria</option>
                      <option value='6to_de_Secundaria'>6to de Secundaria</option>
                  </select>
                </div>
                <div class="col-md-7 soyTestSelector soy_estudiante_colegio">
                  <label class="form-label" for='institucionTest_soy_estudiante_colegio'>INSTITUCIÓN:</label>
                  <input name='institucionTest_soy_estudiante_colegio' type='text'
                    id='institucionTest_soy_estudiante_colegio' class='required form-control' />
                </div>

                <!-- estudiante_universitario -->
                <div class="col-md-4 soyTestSelector estudiante_universitario" style='display: none'>
                  <label class="form-label" for='semestreTest_estudiante_universitario'>SEMESTRE:</label>
                  <select name='semestreTest_estudiante_universitario' id='semestreTest_estudiante_universitario'
                    class='required form-control'>
                    <option value='1er_semestre'>1er. Semestre</option>
                    <option value='2do_semestre'>2do. Semestre</option>
                    <option value='3er_semestre'>3er. Semestre</option>
                    <option value='4to_semestre'>4to. Semestre</option>
                    <option value='5to_semestre'>5to. Semestre</option>
                    <option value='6to_semestre'>6to. Semestre</option>
                    <option value='7mo_semestre'>7mo. Semestre</option>
                    <option value='8vo_semestre'>8vo. Semestre</option>
                    <option value='9no_semestre'>9no. Semestre</option>
                    <option value='10mo_semestre'>10mo. Semestre</option>
                  </select>
                </div>
                <div class="col-md-4 soyTestSelector estudiante_universitario" style='display: none'>
                  <label class="form-label" for='carreraTest_estudiante_universitario'>CARRERA:</label>
                  <input name='carreraTest_estudiante_universitario' type='text' id='carreraTest_estudiante_universitario'
                    class='required form-control' />
                </div>
                <div class="col-md-4 soyTestSelector estudiante_universitario" style='display: none'>
                  <label class="form-label" for='institucionTest_estudiante_universitario'>INSTITUCIÓN:</label>
                  <input name='institucionTest_estudiante_universitario' type='text'
                    id='institucionTest_estudiante_universitario' class='required form-control' />
                </div>

                <!-- soy_profesional -->
                <div class="col-md-6 soyTestSelector profesional" style='display: none'>
                  <label class="form-label" for='carreraTest_profesional'>OCUPACIÓN O PROFESIÓN:</label>
                  <input name='carreraTest_profesional' type='text' id='carreraTest_profesional'
                    class='required form-control' />
                </div>
                <div class="col-md-6 soyTestSelector profesional" style='display: none'>
                  <label class="form-label" for='institucionTest_profesional'>INSTITUCIÓN:</label>
                  <input name='institucionTest_profesional' type='text' id='institucionTest_profesional'
                    class='required form-control' />
                </div>

                <div class="col-md-12">
                  <label class="form-label" for="comentarioTest">COMENTARIO:</label>
                  <textarea name="comentarioTest" id="comentarioTest" onpaste="return false" rows="3"
                    class="form-control"></textarea>
                </div>


                <input type='hidden' name='carreraTest' value="" />
                <input type='hidden' name='semestreTest' value="" />
                <input type='hidden' name='institucionTest' value="" />

                <input type="hidden" name="nomLecturaForm" id="nomLecturaForm" value="EVALUACIÓN PSICOTÉCNICA" />
                <input type="hidden" name="tipoPersonaForm" id="tipoPersonaForm" value="" />
                <input type="hidden" name="tipoTestForm" id="tipoTestForm" value="" />
                <input type="hidden" name="tiempoRespuestasForm" id="tiempoRespuestasForm" value="00:00" />
                <input type="hidden" name="respuestasOkForm" id="respuestasOkForm"
                  value="<?php echo substr($sCtaAlt, 0, -1) ?>" />
                <input type="hidden" name="respuestasForm" id="respuestasForm" value="" />
                <input type="hidden" name="tipo" value="razonamiento" />
                <div class="botonera">
                  <div class="g-recaptcha" data-sitekey="<?php echo KEY_CAPTCHA_PUBLIC_V2; ?>"></div>
                  <div class='status'></div>
                  <br />
                  <button type="button" name="puntaje" class="puntaje" onclick='sendFormTest()'>Ver Puntaje</button>
                  <button type='reset' id='limpiar' name='limpiar' class='btn-reset'>Limpiar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div id='info-result'></div>
      <script>
        function soy(valor) {
          $(".soyTestSelector").fadeOut();
          if (valor == 'ninguno') {
            $("." + valor).fadeOut();
          } else {
            $("." + valor).fadeIn();
          }
        }

        function setForm() {
          if ($('#soyTest').val() == 'soy_estudiante_colegio') {
            $('input[name="carreraTest"]').val('');
            $('input[name="semestreTest"]').val($('#semestreTest_soy_estudiante_colegio').val());
            $('input[name="institucionTest"]').val($('#institucionTest_soy_estudiante_colegio').val());
          } else if ($('#soyTest').val() == 'estudiante_universitario') {
            $('input[name="carreraTest"]').val($('#carreraTest_estudiante_universitario').val());
            $('input[name="semestreTest"]').val($('#semestreTest_estudiante_universitario').val());
            $('input[name="institucionTest"]').val($('#institucionTest_estudiante_universitario').val());
          } else if ($('#soyTest').val() == 'profesional') {
            $('input[name="carreraTest"]').val($('#carreraTest_profesional').val());
            $('input[name="semestreTest"]').val('');
            $('input[name="institucionTest"]').val($('#institucionTest_profesional').val());
          } else {
            $('input[name="carreraTest"]').val('');
            $('input[name="semestreTest"]').val('');
            $('input[name="institucionTest"]').val('');
          }
        }

        function sendFormTest() {
          setForm();
          $('#formTest').submit();
        }

        function showRequestTest(formData) {
          $("#formTest .status").fadeIn();
          $("#formTest .status").html("Estamos enviando procesando la respuesta, espera un momento...")
        }

        function showResponseTest(responseText) {
          var obj = JSON.parse(responseText);
          habilitarInputs("formTest");

          if (obj['estado'] == 1) {
            $("#info-form").fadeOut();
            $("#formTest .status").html('')
            $("#formTest").reset();

            $("#info-result").html(obj['mensaje'])
            $("#info-result").fadeIn();
          } else {
            $("#formTest .status").fadeOut();
            alert(obj['mensaje'])
            grecaptcha.reset();
          }
        }

        $(document).ready(function () {
          $("#nombreTest").val($.cookie("cookie-nombreTest"));
          $("#emailTest").val($.cookie("cookie-emailTest"));
          $('#edadTest').val($.cookie('cookie-edadTest'));
          $("#fonoTest").val($.cookie("cookie-fonoTest"));
          $("#ciudadTest").val($.cookie("cookie-ciudadTest"));
          $("#paisTest").val($.cookie("cookie-paisTest"));


          $("#formTest").validate({
            submitHandler: function (form) {
              $(form).ajaxSubmit({
                beforeSubmit: showRequestTest,
                success: showResponseTest
              });
            }
          });
        });
      </script>
    <?php } ?>
  </div>
<?php } ?>
