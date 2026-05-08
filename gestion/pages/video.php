<?php

extract($_REQUEST);

$cls = new ClssVideos("videos");

$cod = (isset($cod)) ? $cod : 0;

$dato = $cls->listar($cod);

if ($cod == 0) {

    $dato[0]['name'] = '';
    $dato[0]['video'] = '';

    $dato[0]['referencia'] = ''; 

}

$referenciaDato = $dato[0]['slug'];



 ?>

<!-- Content Header (Page header) -->



<section class="content-header">

  <ol class="breadcrumb">

    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>

    <li class="active">Videos</li>

  </ol>

  <h1><i class="fa fa-video-camera"></i> Videos <small>Editar Video</small> </h1>

</section>



<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data" >

  <section class="content">

    <div class="box ">

      <div class="box-header with-border">

        <h3 class="box-title">Datos del video</h3>

      </div>

      <div class="box-body">

        <input type="hidden" value="guardarVideo" name="accion" />

        <input type="hidden" value="<?php echo $cod ?>" name="cod" />

        <div class="form-group">

          <label for="name">Nombre</label>

          <input type="text" id="name" name="name" class="required form-control" value="<?php echo $dato[0]['name'] ?>" />

        </div>

        <div class="form-group">

          <label for="video">URL del vídeo</label>

          <input type="text" id="video" name="video" class="required form-control" value="<?php echo $dato[0]['video'] ?>" />

        </div>

          <input type="hidden" id="referencia" name="referencia" class="required form-control" value="videos" />

 

      </div>

      <div class="box-footer">

        <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>

        <button type="button" onclick="javascript:location.href='page-videos'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>

        <div class="alert hidden"></div>

      </div>

    </div>

  </section>

  <div class="clearfix"></div>

</form>

<!-- /.content --> 

<script>

      $(function () {

        var options = {beforeSubmit: showRequest, success: showResponse};

        $("#form_").validate({

            submitHandler: function (form) {

                $(form).ajaxSubmit(options);

            }

        });

    });

</script> 

