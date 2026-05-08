<?php require_once("require/configuracion.php");?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<section id='contacto-form'>
  <div class='container'>
    <div class='row' style='margin: 2px'>
      <div class='form col-md-8 order-2 order-md-1'>
        <form class="row g-3" name="formContact" id="formContact" method="post" action="./include/ajax">
          <input type="hidden" name="tipo" id="tipo" value="contacto" />

          <div class="col-md-6">
            <label for="nombre" class="form-label">Nombres</label>
            <input type="text" class="form-control required" id="nombre" name="nombre" />
          </div>
          <div class="col-md-6">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control required" id="apellidos" name="apellidos" />
          </div>
          <div class="col-md-6">
            <label for="fono" class="form-label">Teléfono</label>
            <input type="text" class="form-control required" id="fono" name="fono" />
          </div>
          <div class="col-md-6">
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

          <div class="col-md-12">
            <label for="mensaje" class="form-label">Comentario</label>
            <textarea class="form-control required" id="mensaje" name="mensaje" rows="3"></textarea>
          </div>
          <div class="status"></div>
          <div class="col-md-12 text-right botonera">
            <div class="g-recaptcha" data-sitekey="<?php echo KEY_CAPTCHA_PUBLIC_V2; ?>"></div>
            <br/>
            <button  
                type="button" 
                class="btn btn-blue right"
                onclick='sendFormContact()' 
                >ENVIAR</button>
          </div>
        </form>
      </div>
      
      <div class='col-md-4 title order-1 order-md-2'>
        <h2>ESCRIBENOS</h2>
        <P><strong>Déjanos tu mensaje</strong> y <br/>trataremos de responderte <br/>lo más pronto posible</P><br/>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
function sendFormContact() {
  $('#formContact').submit();
} 

function showRequestContact(formData){
	$("#formContact .status").fadeIn();
 	$("#formContact .status").html("Estamos enviando tus datos, espera un momento...")
}

function showResponseContact(responseText){
	var obj = JSON.parse(responseText);
	habilitarInputs("formContact");
	
 	if(obj['estado']==1) {
		$("#formContact .status").fadeOut();
 		alert(obj['mensaje'])
		$("#formContact").reset();	
		location.reload();
	} else { 
		$("#formContact .status").fadeOut();
		alert(obj['mensaje'])
		//alert("Ha ocurrido un error al intentar enviar los datos.\nVuelva a intentarlo o intente mas tarde.\nGracias."); 
	}
}

$(document).ready(function() {  
	$("#formContact").validate({
		submitHandler: function (form) {
			$(form).ajaxSubmit({beforeSubmit: showRequestContact, success: showResponseContact});
		}
	});
});

</script>