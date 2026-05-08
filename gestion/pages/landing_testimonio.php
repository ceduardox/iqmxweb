<?php
extract($_REQUEST);
$cls  = new ClssLandingTestimonio();

$cods  = (isset($cod)) ? $cod : array();
$codArr = explode("_",$cods); 
$landing_id = $codArr[0];
$cod = $codArr[1];

$dato = $cls->listar($landing_id,$cod);
if ($cod == 0) { 
  $dato = array();
  $dato[0]['names'] = ''; 
  $dato[0]['profile'] = '';  
  $dato[0]['text'] = ''; 
  $dato[0]['avatar'] = '';  
  $dato[0]['landing_id'] = '';  
}
 
?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
  </ol>
  <h1><i class="fa fa-file"></i> Landing Page / Testimonio <small>Editar información</small> </h1>
</section>

<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data">
  <input type="hidden" value="saveLandingTestimonio" name="accion" />
  <input type="hidden" value="<?php echo $landing_id;?>" name="landing_id" /> 
  <input type="hidden" value="<?php echo $cod;?>" name="cod" /> 
  <section class="content ">
 
    <!--Precio 1-->
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Información</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="names">Nombres y Apellidos </label>
              <input name="names" id="names" type="text" class="required form-control" value="<?php echo $dato[0]['names']; ?>" />
            </div>    </div> 
          <div class="col-md-6">
            <div class="form-group">
              <label for="profile">Perfil </label>
              <input name="profile" id="profile" type="text" class="required form-control" value="<?php echo $dato[0]['profile']; ?>" />
            </div>    </div> 
          <div class="col-md-12">
            <div class="form-group">
              <label for="text">Comentario </label>
              <textarea name="text" id="text" rows="5"
                class="required form-control"><?php echo $dato[0]['text']; ?></textarea>
            </div> 
          </div> 
          
          <div class="col-md-6">
            <div class="input-group">
              <label for="avatar">Avatar <span class="text-mini">(Ancho: 400px Alto: 400px)</span>
                <?php if ($dato[0]['avatar'] != "") { ?>
                (<a href="../<?php echo RUTA_LANDING . $dato[0]['avatar'] ?>" target="_blank" title="ver avatar">ver avatar</a>)
                <?php } ?>
              </label>
              <input type="file" id="avatar" name="avatar"  />
              <input type="hidden"  name="avatar_HIDDEN" value="<?php echo $dato[0]['avatar'] ?>" />
            </div>
          </div>
        </div>  

      </div> 
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar">Guardar</button>
        <button type="button" onclick="javascript:location.href='page-landing_testimonios-<?php echo $landing_id;?>'" class="btn btn-default"
          id="btn-cancelar" name="cancelar">Volver</button>
        <div class="alert hidden"></div>
      </div>
    </div>
  </section>
</form>

<!-- /.content -->

<script src="plugins/ckeditor/ckeditor.js"></script> 
<script>
$(function() { 

  var options = {
    beforeSubmit: showRequest,
    success: showResponse
  };

  $("#form_").validate({
    submitHandler: function(form) {
      $(form).ajaxSubmit(options);
    }
  });
}); 
</script>
