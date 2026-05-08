<?php
require_once("require/util.php");
require_once("require/transacciones.php");

$obj = new ClssALeerBoliviaFicha();  
$ficha = "";
$name = "";
$pathFile = "";

$rows = $obj -> lista('Auspiciadores');

if($rows['total']!=0) {
  $ficha = $rows['result'][0]['document'];
  $name = $rows['result'][0]['name'];
  $pathFile = PATH_A_LEER_BOLIVIA_FICHAS.$ficha;
}
?>
<div class="modal fade" id="modalRegistroAuspiciadores" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="modalRegistroAuspiciadores" aria-hidden="true">
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
                <img src='./assets/images/modal-auspiciadores.svg' alt='auspiciadores' />
              </div>
              <div class='header-text'>
                <h2>INSCRIPCIÓN DE</h2>
                <h1>AUSPICIADORES</h1>
              </div>
            </div>
            <div class='container-main'>
              <?php if($ficha!="") { ?>
              <div class='descarga'>
                <a href='<?php echo PATH_A_LEER_BOLIVIA_FICHAS.$ficha; ?>' target='blank' download="<?php echo $ficha?>"
                  title="Descargar <?php echo $name?>">
                  <img src='./assets/images/modal-descarga-icono.svg' alt='descarga' />
                  <p class='descarga-text'>DESCARGA CONVOCATORIA</p>
                </a>
              </div>
              <?php } ?>
              <p class='title-and-main-text'>Estimado(a) Auspiciador,
                <br />
                <br />
                Es con gran entusiasmo que le extendemos la invitación a ser parte de un movimiento
                que
                está marcando la diferencia en la educación y la cultura lectora en Bolivia: el
                evento
                intercolegial <b>"A Leer Bolivia por un Futuro Mejor"</b> organizado por
                <b>IQMAXIMO</b>. Este
                concurso, que tendrá lugar durante un período de aproximadamente 3 meses desde el
                proceso de selección, concientización y preparación de los estudiantes, nos dedicamos
                incansablemente a guiarlos en su camino hacia el concurso.
                <br />
                <br />
                Entendiendo la importancia de alinear nuestros esfuerzos con marcas que comparten
                nuestros valores y objetivos, hemos diseñado <b>tres niveles de auspicio</b>, cada uno
                con
                un
                conjunto de beneficios diseñados para <b>maximizar la visibilidad y el impacto de su
                  marca</b>:
              </p>

              <div class="btn-group" role="group" aria-label="Elige">
                <input type="radio" class="btn-check" name="btnradio" id="btn_tipos" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="btn_tipos">Tipos de Auspicio</label>

                <input type="radio" class="btn-check" name="btnradio" id="btn_form" autocomplete="off">
                <label class="btn btn-outline-primary" for="btn_form">Solicitar Registro</label>
              </div>

              <div id="content_accordionRegistro">
                <?php include( 'parts/a-leer-bolivia/modal-auspiciadores-acordion.php' );?>
              </div>

              <div class="d-none" id="content_formAuspiciadores">
                <?php include( 'parts/a-leer-bolivia/modal-auspiciadores-form.php' );?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#modalRegistroAuspiciadores #btn_tipos').click(function() {
    $('#content_accordionRegistro').removeClass('d-none');
    $('#content_formAuspiciadores').addClass('d-none');
  });

  $('#modalRegistroAuspiciadores #btn_form').click(function() {
    $('#content_accordionRegistro').addClass('d-none');
    $('#content_formAuspiciadores').removeClass('d-none');
  });
});
</script>