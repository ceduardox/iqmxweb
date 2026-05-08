<?php
extract($_REQUEST);
$cls  = new ClssLandingPrecios();
$cod  = (isset($cod)) ? $cod : 0;
$dato = $cls->listar($cod);
if ($cod == 0) { 
  $dato[0]['title1'] = ''; 
  $dato[0]['subtitle1'] = ''; 
  $dato[0]['text1'] = ''; 
  $dato[0]['price1'] = ''; 
  $dato[0]['link1'] = ''; 
  $dato[0]['price_text1'] = ''; 
  $dato[0]['title2'] = ''; 
  $dato[0]['subtitle2'] = ''; 
  $dato[0]['text2'] = ''; 
  $dato[0]['price2'] = ''; 
  $dato[0]['link2'] = ''; 
  $dato[0]['price_text2'] = ''; 
  $dato[0]['title3'] = ''; 
  $dato[0]['subtitle3'] = ''; 
  $dato[0]['text3'] = ''; 
  $dato[0]['price3'] = ''; 
  $dato[0]['link3'] = ''; 
  $dato[0]['price_text3'] = ''; 
}
 
?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
  </ol>
  <h1><i class="fa fa-file"></i> Landing Page / Precios <small>Editar información</small> </h1>
</section>

<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data">
  <input type="hidden" value="saveLandingPrecios" name="accion" />
  <input type="hidden" value="<?php echo $cod;?>" name="landing_id" />
  <input type="hidden" value="<?php echo $dato[0]['id'];?>" name="cod" />
  <section class="content ">
 
    <!--Precio 1-->
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Precio 1</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title1">Título </label>
              <input name="title1" id="title1" type="text" class="required form-control" value="<?php echo $dato[0]['title1']; ?>" />
            </div> 
          </div>
            
          <div class="col-md-6">
            <div class="form-group">
              <label for="subtitle1">Sub-Título </label>
              <input name="subtitle1" id="subtitle1" type="text" class="  form-control" value="<?php echo $dato[0]['subtitle1']; ?>" />
            </div> 
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label for="text1">Detalle </label> 
              <textarea name="text1_HIDDEN" id="text1_HIDDEN" class="required form-control"><?php echo limpiaTextoAdmin($dato[0]['text1']); ?></textarea>
              <textarea name="text1" id="text1" class="hidden"><?php echo limpiaTextoAdmin($dato[0]['text1']); ?></textarea>
            </div> 
          </div>
          
          <div class="col-md-2">
            <div class="form-group">
              <label for="price1">Precio </label>
              <input name="price1" id="price1" type="text" class="required form-control" value="<?php echo $dato[0]['price1']; ?>" />
            </div> 
          </div>
          
          <div class="col-md-4">
            <div class="form-group">
              <label for="price_text1">Texto </label>
              <input name="price_text1" id="price_text1" type="text" class="required form-control" value="<?php echo $dato[0]['price_text1']; ?>" />
            </div> 
          </div>
            
          <div class="col-md-6">
            <div class="form-group">
              <label for="link1">Link </label>
              <input name="link1" id="link1" type="text" class="  form-control" value="<?php echo $dato[0]['link1']; ?>" />
            </div> 
          </div> 
        </div>  

      </div>
    </div>
 
    <!--Precio 2-->
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Precio 2 (Destacado)</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title2">Título </label>
              <input name="title2" id="title2" type="text" class="required form-control" value="<?php echo $dato[0]['title2']; ?>" />
            </div> 
          </div>
            
          <div class="col-md-6">
            <div class="form-group">
              <label for="subtitle2">Sub-Título </label>
              <input name="subtitle2" id="subtitle2" type="text" class="  form-control" value="<?php echo $dato[0]['subtitle2']; ?>" />
            </div> 
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label for="text2">Detalle </label> 
              <textarea name="text2_HIDDEN" id="text2_HIDDEN" class="required form-control"><?php echo limpiaTextoAdmin($dato[0]['text2']); ?></textarea>
              <textarea name="text2" id="text2" class="hidden"><?php echo limpiaTextoAdmin($dato[0]['text2']); ?></textarea>
            </div> 
          </div>
          
          <div class="col-md-2">
            <div class="form-group">
              <label for="price2">Precio </label>
              <input name="price2" id="price2" type="text" class="required form-control" value="<?php echo $dato[0]['price2']; ?>" />
            </div> 
          </div>
          
          <div class="col-md-4">
            <div class="form-group">
              <label for="price_text2">Texto </label>
              <input name="price_text2" id="price_text2" type="text" class="required form-control" value="<?php echo $dato[0]['price_text2']; ?>" />
            </div> 
          </div>
            
          <div class="col-md-6">
            <div class="form-group">
              <label for="link2">Link </label>
              <input name="link2" id="link2" type="text" class="  form-control" value="<?php echo $dato[0]['link2']; ?>" />
            </div> 
          </div> 
        </div>  

      </div>
    </div>
 
     <!--Precio 3-->
     <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Precio 3</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="title3">Título </label>
              <input name="title3" id="title3" type="text" class="required form-control" value="<?php echo $dato[0]['title3']; ?>" />
            </div> 
          </div>
            
          <div class="col-md-6">
            <div class="form-group">
              <label for="subtitle3">Sub-Título </label>
              <input name="subtitle3" id="subtitle3" type="text" class="  form-control" value="<?php echo $dato[0]['subtitle3']; ?>" />
            </div> 
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label for="text3">Detalle </label> 
              <textarea name="text3_HIDDEN" id="text3_HIDDEN" class="required form-control"><?php echo limpiaTextoAdmin($dato[0]['text3']); ?></textarea>
              <textarea name="text3" id="text3" class="hidden"><?php echo limpiaTextoAdmin($dato[0]['text3']); ?></textarea>
            </div> 
          </div>
          
          <div class="col-md-2">
            <div class="form-group">
              <label for="price3">Precio </label>
              <input name="price3" id="price3" type="text" class="  form-control" value="<?php echo $dato[0]['price3']; ?>" />
            </div> 
          </div>
          
          <div class="col-md-4">
            <div class="form-group">
              <label for="price_text3">Texto </label>
              <input name="price_text3" id="price_text3" type="text" class="  form-control" value="<?php echo $dato[0]['price_text3']; ?>" />
            </div> 
          </div>
            
          <div class="col-md-6">
            <div class="form-group">
              <label for="link3">Link </label>
              <input name="link3" id="link3" type="text" class="  form-control" value="<?php echo $dato[0]['link3']; ?>" />
            </div> 
          </div> 
        </div>  

      </div>
    </div>
 

    <div class="box ">
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar">Guardar</button>
        <button type="button" onclick="javascript:location.href='page-landings'" class="btn btn-default"
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
  
  var text1 = CKEDITOR.replace('text1_HIDDEN');   
  text1.on( 'change', function( evt ) {
    $('#text1').text(evt.editor.getData());
  });
  
  var text2 = CKEDITOR.replace('text2_HIDDEN');   
  text2.on( 'change', function( evt ) {
    $('#text2').text(evt.editor.getData());
  });

  var text3 = CKEDITOR.replace('text3_HIDDEN');  
  text3.on( 'change', function( evt ) {
    $('#text3').text(evt.editor.getData());
  }); 

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
