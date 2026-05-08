<?php require_once('require/configuracion.php'); ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<section id='contacto-form2'>
  <div class='container'>
    <div class='row'>

      <div class='col-md-5 title'>
        <h2><strong>IQ</strong>MÁXIMO, </h2>
        <P>te invita a tener una PRUEBA <br />
          GRATUITA, estamos seguros que <br />
          te encantará visitar nuestra <br />
          plataforma, ver la metodología, el <br />
          desarrollo de nuestros ejercicios de <br />
          entrenamiento y el seguimiento de <br />
          nuestros Educadores, Psicólogos y <br />
          Pedagogos.
        </P>
        <p><strong>Anímate no te arrepentirás.</strong></p>
        <br/>
      </div>

      <div class='content-form col-md-7'>
        <form class=" g-3" name="formContactTest" id="formContactTest" method="post" action="./include/ajax" >
          <input type="hidden" name="tipo" id="tipo" value="contacto2" />
          <div class='form row'>
            <h3>DATOS DE <strong>CONTACTO</strong> (mayor de edad)</h3>
            <div class="col-md-6">
              <label for="nombre" class="form-label">Nombres</label>
              <input type="text" class="form-control required" id="nombre" name="nombre" />
            </div>
            <div class="col-md-6">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" class="form-control required" id="apellidos" name="apellidos" />
            </div>
            <div class="col-md-12">
              <label for="dni" class="form-label">N° de cédula</label>
              <input type="text" class="form-control required" id="dni" name="dni" />
            </div>
            <div class="col-md-6">
              <label for="fnac" class="form-label">Fecha de nacimiento</label>
              <input type="text" class="form-control required" id="fnac" name="fnac" />
            </div>
            <div class="col-md-6">
              <label for="edad" class="form-label">Edad</label>
              <input type="text" class="form-control required" id="edad" name="edad" />
            </div>
            <div class="col-md-12">
              <label for="fono" class="form-label">Teléfono</label>
              <input type="text" class="form-control required" id="fono" name="fono" />
            </div>
            <div class="col-md-12">
              <label for="email" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control required" id="email" name="email" />
            </div>

            <div class="col-md-6">
              <label for="ciudad" class="form-label">Ciudad</label>
              <input type="text" class="form-control required" id="ciudad" name="ciudad" />
            </div>
            <div class="col-md-6">
              <label for="pais" class="form-label">País</label>
              <input type="text" class="form-control required" id="pais" name="pais" />
            </div>

          </div>
          
          <div class='form row'>
            <h3>¿QUIÉN TOMARÁ <strong>LA PRUEBA GRATUITA</strong>?</h3>
            <div class="col-md-6">
              <label for="nombre_pru" class="form-label">Nombres</label>
              <input type="text" class="form-control required" id="nombre_pru" name="nombre_pru" />
            </div>
            <div class="col-md-6">
              <label for="apepa_pru" class="form-label">Apellido paterno</label>
              <input type="text" class="form-control required" id="apepa_pru" name="apepa_pru" />
            </div>
            <div class="col-md-6">
              <label for="apema_pru" class="form-label">Apellido materno</label>
              <input type="text" class="form-control required" id="apema_pru" name="apema_pru" />
            </div>
            <div class="col-md-6">
              <label for="dni_pru" class="form-label">N° de cédula</label>
              <input type="text" class="form-control required" id="dni_pru" name="dni_pru" />
            </div>
            <div class="col-md-6">
              <label for="fnac_pru" class="form-label">Fecha de nacimiento</label>
              <input type="text" class="form-control required" id="fnac_pru" name="fnac_pru" />
            </div>
            <div class="col-md-6">
              <label for="edad_pru" class="form-label">Edad</label>
              <input type="text" class="form-control required" id="edad_pru" name="edad_pru" />
            </div>
            <div class="col-md-12">
              <label for="fono_pru" class="form-label">Teléfono</label>
              <input type="text" class="form-control required" id="fono_pru" name="fono_pru" />
            </div>
            <div class="col-md-12">
              <label for="email_pru" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control required" id="email_pru" name="email_pru" />
            </div>

            <div class="col-md-6">
              <label for="ciudad_pru" class="form-label">Ciudad</label>
              <input type="text" class="form-control required" id="ciudad_pru" name="ciudad_pru" />
            </div>
            <div class="col-md-6">
              <label for="pais_pru" class="form-label">País</label>
              <input type="text" class="form-control required" id="pais_pru" name="pais_pru" />
            </div>

            <div class="status"></div>
            <div class="col-md-12 text-right botonerax"> 
            <div class="g-recaptcha" data-sitekey="<?php echo KEY_CAPTCHA_PUBLIC_V2; ?>"></div>

              <button 
                type="button" 
                class="btn btn-blue right"
                onclick='sendFormContactTest()' 
                >COMIENZA AHORA</button>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
function sendFormContactTest() {
  $('#formContactTest').submit();
}

function showRequestTestFree(formData){
	$("#formContactTest .status").fadeIn();
 	$("#formContactTest .status").html("Estamos enviando tus datos, espera un momento...")
}

function showResponseTestFree(responseText){
	var obj = JSON.parse(responseText);
	habilitarInputs("formContactTest");
	
 	if(obj['estado']==1) {
		$("#formContactTest .status").fadeOut();
 		alert(obj['mensaje'])
		$("#formContactTest").reset();	
		location.reload();
	} else { 
		$("#formContactTest .status").fadeOut();
		alert(obj['mensaje'])
		//alert("Ha ocurrido un error al intentar enviar los datos.\nVuelva a intentarlo o intente mas tarde.\nGracias."); 
	}
}

$(document).ready(function() {  
	$("#formContactTest").validate({
		submitHandler: function (form) {
			$(form).ajaxSubmit({beforeSubmit: showRequestTestFree, success: showResponseTestFree});
		}
	});
});

</script>