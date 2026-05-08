<?php
extract($_REQUEST);
$cls  = new ClssLanding();
$cod  = (isset($cod)) ? $cod : 0;
$dato = $cls->listar($cod);
if ($cod == 0) { 
  $dato[0]['title'] = '';
  $dato[0]['banner-title'] = '';
  $dato[0]['banner-subtitle'] = '';
  $dato[0]['banner-file'] = '';
  $dato[0]['description-title'] = '';
  $dato[0]['description-text1'] = '';
  $dato[0]['description-file1'] = '';
  $dato[0]['description-text2'] = '';
  $dato[0]['description-file2'] = '';
  $dato[0]['description-text3'] = '';
  $dato[0]['description-file3'] = '';
  $dato[0]['testimonial-title'] = '';
  $dato[0]['testimonial-text'] = '';
  $dato[0]['prices-title'] = '';
  $dato[0]['prices-text'] = '';
  $dato[0]['faq-title'] = '';
  $dato[0]['faq-text'] = '';
  $dato[0]['contact-title'] = '';
  $dato[0]['contact-text'] = '';
}

function isActiveFileType($value) {
  $rtn = [];
  $rtn['checked']['video'] = '';
  $rtn['display']['video'] = 'none';
  $rtn['is']['video'] = false;

  $rtn['checked']['image'] = 'checked';
  $rtn['display']['image'] = 'block';
  $rtn['is']['image'] = true;

  if ( strpos( $value, 'vimeo.com' ) ) {
    $rtn['checked']['video'] = 'checked';
    $rtn['display']['video'] = 'block';
    $rtn['is']['video'] = true;

    $rtn['checked']['image'] = '';
    $rtn['display']['image'] = 'none';
    $rtn['is']['image'] = false;
  }  
  return $rtn;
}

?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
  </ol>
  <h1><i class="fa fa-file"></i> Landing Page <small>Editar información</small> </h1>
</section>

<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data">
  <input type="hidden" value="saveLanding" name="accion" />
  <input type="hidden" value="<?php echo $cod;?>" name="cod" />
  <section class="content ">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Información</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">

            <div class="form-group">
              <label for="title">Título </label>
              <input name="title" id="title" type="text" class="required form-control"
                value="<?php echo $dato[0]['title']; ?>" />
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!--Banner-->
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Banner</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="banner-title">Título </label>
              <input name="banner-title" id="banner-title" type="text" class="required form-control"
                value="<?php echo $dato[0]['banner-title']; ?>" />
            </div>
            <div class="form-group">
              <label for="banner-subtitle">Sub Título </label>
              <input name="banner-subtitle" id="banner-subtitle" type="text" class="required form-control"
                value="<?php echo $dato[0]['banner-subtitle']; ?>" />
            </div>
            <?php 
              $isActiveFileTypeBanner = isActiveFileType($dato[0]['banner-file']);
            ?>
            <div class="form-group col-md-3 pl0">
              <label for="banner-file-image">Tipo de archivo</label>
              <div class="radio">
                <label><input type="radio" name="banner-file-type" value="image" <?php echo $isActiveFileTypeBanner['checked']['image']?> onChange="javascript:activeFileType('image', 'banner-file')">Imagen</label> &nbsp;&nbsp;&nbsp;
                <label><input type="radio" name="banner-file-type" value="video" <?php echo $isActiveFileTypeBanner['checked']['video']?> onChange="javascript:activeFileType('video', 'banner-file')">Video</label>
              </div>
            </div>
            <div class="form-group col-md-9 banner-file" id="banner-file-image-box" style="display:<?php echo $isActiveFileTypeBanner['display']['image']?>">
              <label for="banner-file-image">Imagen <span class="text-mini">(ancho: 900px - alto: 740px ) 
              <?php if ($dato[0]['banner-file'] != "" && $isActiveFileTypeBanner['is']['image'] == true) { ?>
                (<a href="../<?php echo RUTA_LANDING . $dato[0]['banner-file'] ?>" target="_blank" title="ver imagen">ver imagen</a>)
                <?php } ?>
              </span></label>
              <input type="file" id="banner-file-image" name="banner-file-image" />
            </div>
            <div class="form-group col-md-9 banner-file" id="banner-file-video-box" style="display:<?php echo $isActiveFileTypeBanner['display']['video']?>">
              <label for="banner-file-video">Video <span class="text-mini">(vimeo)</span> </label>
              <input type="text" name="banner-file-video" class="required form-control" value="<?php echo $dato[0]['banner-file'];?>" />
            </div>
            <input type="hidden" name="banner-file_HIDDEN" value="<?php echo $dato[0]['banner-file'];?>" />
          </div>
        </div>
      </div>
    </div>

    
    <!--detalles-->
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Detalles</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="description-title">Título </label>
              <input name="description-title" id="description-title" type="text" class="required form-control"
                value="<?php echo $dato[0]['description-title']; ?>" />
            </div>
            <hr/>
            <!--detalle 1-->
            <div class="form-group">
              <label for="description-text1">Texto 1 </label> 
              <textarea name="description-text1_HIDDEN" id="description-text1_HIDDEN" class="required form-control"><?php echo limpiaTextoAdmin($dato[0]['description-text1']); ?></textarea>
              <textarea name="description-text1" id="description-text1" class="hidden"><?php echo limpiaTextoAdmin($dato[0]['description-text1']); ?></textarea>
            </div>
            <?php 
              $isActiveFileTypeDesc1 = isActiveFileType($dato[0]['description-file1']);
            ?>
            <div class="form-group col-md-3 pl0">
              <label for="description-file1-image">Tipo de archivo</label>
              <div class="radio">
                <label><input type="radio" name="description-file1-type" value="image" <?php echo $isActiveFileTypeDesc1['checked']['image']?> onChange="javascript:activeFileType('image', 'description-file1')">Imagen</label> &nbsp;&nbsp;&nbsp;
                <label><input type="radio" name="description-file1-type" value="video" <?php echo $isActiveFileTypeDesc1['checked']['video']?> onChange="javascript:activeFileType('video', 'description-file1')">Video</label>
              </div>
            </div>
            <div class="form-group col-md-9 description-file1" id="description-file1-image-box" style="display:<?php echo $isActiveFileTypeDesc1['display']['image']?>">
              <label for="description-file1-image">Imagen <span class="text-mini">(ancho: 500px - alto: 500px ) 
              <?php if ($dato[0]['description-file1'] != "" && $isActiveFileTypeDesc1['is']['image'] == true) { ?>
                (<a href="../<?php echo RUTA_LANDING . $dato[0]['description-file1'] ?>" target="_blank" title="ver imagen">ver imagen</a>)
                <?php } ?>
              </span></label>
              <input type="file" id="description-file1-image" name="description-file1-image" />
            </div>
            <div class="form-group col-md-9 description-file1" id="description-file1-video-box" style="display:<?php echo $isActiveFileTypeDesc1['display']['video']?>">
              <label for="description-file1-video">Video <span class="text-mini">(vimeo)</span> </label>
              <input type="text" name="description-file1-video" class="required form-control" value="<?php echo $dato[0]['description-file1'];?>" />
            </div>
            <input type="hidden" name="description-file1_HIDDEN" value="<?php echo $dato[0]['description-file1'];?>" />
          </div>
        </div> 
        <hr/>
        <!--detalle 2-->
        <div class="row">
          <div class="col-md-12">  
            <div class="form-group">
              <label for="description-text2">Texto 2 </label>
              <textarea name="description-text2_HIDDEN" id="description-text2_HIDDEN" class="required form-control"><?php echo limpiaTextoAdmin($dato[0]['description-text2']); ?></textarea>
              <textarea name="description-text2" id="description-text2" class="hidden"><?php echo limpiaTextoAdmin($dato[0]['description-text2']); ?></textarea>
            </div>
            <?php 
              $isActiveFileTypeDesc2 = isActiveFileType($dato[0]['description-file2']);
            ?>
            <div class="form-group col-md-3 pl0">
              <label for="description-file2-image">Tipo de archivo</label>
              <div class="radio">
                <label><input type="radio" name="description-file2-type" value="image" <?php echo $isActiveFileTypeDesc2['checked']['image']?> onChange="javascript:activeFileType('image', 'description-file2')">Imagen</label> &nbsp;&nbsp;&nbsp;
                <label><input type="radio" name="description-file2-type" value="video" <?php echo $isActiveFileTypeDesc2['checked']['video']?> onChange="javascript:activeFileType('video', 'description-file2')">Video</label>
              </div>
            </div>
            <div class="form-group col-md-9 description-file2" id="description-file2-image-box" style="display:<?php echo $isActiveFileTypeDesc2['display']['image']?>">
              <label for="description-file2-image">Imagen <span class="text-mini">(ancho: 500px - alto: 500px ) 
              <?php if ($dato[0]['description-file2'] != "" && $isActiveFileTypeDesc2['is']['image'] == true) { ?>
                (<a href="../<?php echo RUTA_LANDING . $dato[0]['description-file2'] ?>" target="_blank" title="ver imagen">ver imagen</a>)
                <?php } ?>
              </span></label>
              <input type="file" id="description-file2-image" name="description-file2-image" />
            </div>
            <div class="form-group col-md-9 description-file2" id="description-file2-video-box" style="display:<?php echo $isActiveFileTypeDesc2['display']['video']?>">
              <label for="description-file2-video">Video <span class="text-mini">(vimeo)</span> </label>
              <input type="text" name="description-file2-video" class="required form-control" value="<?php echo $dato[0]['description-file2'];?>" />
            </div>
            <input type="hidden" name="description-file2_HIDDEN" value="<?php echo $dato[0]['description-file2'];?>" />
          </div>
        </div> 
        <hr/>
        <!--detalle 3-->
        <div class="row">
          <div class="col-md-12">  
            <div class="form-group">
              <label for="description-text3">Texto 3 </label>
              <textarea name="description-text3_HIDDEN" id="description-text3_HIDDEN" class="required form-control"><?php echo limpiaTextoAdmin($dato[0]['description-text3']); ?></textarea>
              <textarea name="description-text3" id="description-text3" class="hidden"><?php echo limpiaTextoAdmin($dato[0]['description-text3']); ?></textarea>
            </div>
            <?php 
              $isActiveFileTypeDesc3 = isActiveFileType($dato[0]['description-file3']);
            ?>
            <div class="form-group col-md-3 pl0">
              <label for="description-file3-image">Tipo de archivo</label>
              <div class="radio">
                <label><input type="radio" name="description-file3-type" value="image" <?php echo $isActiveFileTypeDesc3['checked']['image']?> onChange="javascript:activeFileType('image', 'description-file3')">Imagen</label> &nbsp;&nbsp;&nbsp;
                <label><input type="radio" name="description-file3-type" value="video" <?php echo $isActiveFileTypeDesc3['checked']['video']?> onChange="javascript:activeFileType('video', 'description-file3')">Video</label>
              </div>
            </div>
            <div class="form-group col-md-9 description-file3" id="description-file3-image-box" style="display:<?php echo $isActiveFileTypeDesc3['display']['image']?>">
              <label for="description-file3-image">Imagen <span class="text-mini">(ancho: 500px - alto: 500px ) 
              <?php if ($dato[0]['description-file3'] != "" && $isActiveFileTypeDesc3['is']['image'] == true) { ?>
                (<a href="../<?php echo RUTA_LANDING . $dato[0]['description-file3'] ?>" target="_blank" title="ver imagen">ver imagen</a>)
                <?php } ?>
              </span></label>
              <input type="file" id="description-file3-image" name="description-file3-image" />
            </div>
            <div class="form-group col-md-9 description-file3" id="description-file3-video-box" style="display:<?php echo $isActiveFileTypeDesc3['display']['video']?>">
              <label for="description-file3-video">Video <span class="text-mini">(vimeo)</span> </label>
              <input type="text" name="description-file3-video" class="required form-control" value="<?php echo $dato[0]['description-file3'];?>" />
            </div>
            <input type="hidden" name="description-file3_HIDDEN" value="<?php echo $dato[0]['description-file3'];?>" />
          </div>
        </div>
      </div>
    </div>

    <!--Tesimonios-->
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Tesimonios</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="testimonial-title">Título </label>
              <input name="testimonial-title" id="testimonial-title" type="text" class="required form-control"
                value="<?php echo $dato[0]['testimonial-title']; ?>" />
            </div>
            <div class="form-group">
              <label for="testimonial-text">Texto </label>
              <textarea name="testimonial-text" id="testimonial-text" rows="5"
                class="required form-control"><?php echo $dato[0]['testimonial-text']; ?></textarea>
            </div> 
          </div>
        </div>
      </div>
    </div>

    <!--prices-->
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Precios</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="prices-title">Título </label>
              <input name="prices-title" id="prices-title" type="text" class="required form-control"
                value="<?php echo $dato[0]['prices-title']; ?>" />
            </div>
            <div class="form-group">
              <label for="prices-text">Texto </label> 
              <textarea name="prices-text" id="prices-text" rows="5"
                class="required form-control"><?php echo $dato[0]['prices-text']; ?></textarea>
            </div> 
          </div>
        </div>
      </div>
    </div>

    <!--faq-->
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Preguntas Frecuentes</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="faq-title">Título </label>
              <input name="faq-title" id="faq-title" type="text" class="required form-control"
                value="<?php echo $dato[0]['faq-title']; ?>" />
            </div>
            <div class="form-group">
              <label for="faq-text">Texto </label>
              <textarea name="faq-text" id="faq-text" rows="5"
                class="required form-control"><?php echo $dato[0]['faq-text']; ?></textarea>
            </div> 
          </div>
        </div>
      </div>
    </div>


    <!--contact-->
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Contacto</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="contact-title">Título </label>
              <input name="contact-title" id="contact-title" type="text" class="required form-control"
                value="<?php echo $dato[0]['contact-title']; ?>" />
            </div>
            <div class="form-group">
              <label for="contact-text">Texto </label>
              <textarea name="contact-text" id="contact-text" rows="5"
                class="required form-control"><?php echo $dato[0]['contact-text']; ?></textarea>
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
  
  var description_text1 = CKEDITOR.replace('description-text1_HIDDEN');   
  description_text1.on( 'change', function( evt ) {
    $('#description-text1').text(evt.editor.getData());
  });
  
  var description_text2 = CKEDITOR.replace('description-text2_HIDDEN');   
  description_text2.on( 'change', function( evt ) {
    $('#description-text2').text(evt.editor.getData());
  });

  var description_text3 = CKEDITOR.replace('description-text3_HIDDEN');  
  description_text3.on( 'change', function( evt ) {
    $('#description-text3').text(evt.editor.getData());
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

function activeFileType(type, field) {
  $('.'+field).css('display', 'none');
  $('#'+field+"-"+type+"-box").css('display', 'block');

  if(type=='video') {
    //$('#'+field+"-"+type+"-box").find('input').val("");
  }
}
</script>
