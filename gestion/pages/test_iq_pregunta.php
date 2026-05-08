<?php

extract($_REQUEST);

$cls = new ClssTestiQ();

$cod = isset($cod) ? $cod : array();

$cods = explode("_",$cod);  
$tipo = $cods[0];
$serie = $cods[1];
$pregunta = $cods[2];
$dato = $cls->pregunta($pregunta,$serie);

if ($pregunta == 0) {
    $dato[0]['nombre'] = '';
    $dato[0]['file'] = ''; 
}
$tipo_rs = $cls->tipo($tipo);
$serie_rs = $cls->serie($serie);

?>

<!-- Content Header (Page header) -->

<section class="content-header">
   <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="page-test_iq_tipos">Test iQ</a></li>
    <li><a href="page-test_iq_tipos"><?php echo $tipo_rs[0]['nombre']?></a></li>
    <li><a href="page-test_iq_series-<?php echo $tipo?>"><?php echo $serie_rs[0]['nombre']?></a></li>
    <li><a href="page-test_iq_preguntas-<?php echo $tipo?>_<?php echo $serie?>">Listado</a></li>
    <li class="active">Editar</li>
  </ol>
  <h1><i class="fa fa-th-large"></i> Pregunta </h1>
   <button type="button pull-left" onclick="javascript:location.href='page-test_iq_preguntas-<?php echo $tipo?>_<?php echo $serie?>'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
  <button type="button" onclick="javascript:location.href='page-test_iq_pregunta-<?php echo $tipo?>_<?php echo $serie?>_0'"  class="btn btn-primary" id="btn-nuevo" name="btn-nuevo"  >Nuevo registro</button>
  <div class="clearfix"></div>
</section>

<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data" >
  <section class="content">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos del tipo</h3>
      </div>
      <div class="box-body">
        <input type="hidden" value="guardarTestiQPregunta" name="accion" />
        <input type="hidden" value="<?php echo $pregunta ?>" name="cod" />
        <input type="hidden" value="<?php echo $serie ?>" name="serie_id" />
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" class="required form-control" value="<?php echo $dato[0]['nombre'] ?>" />
        </div>

            <div class="form-group">
              <label for="archivo">Imagen <span class="text-mini">(Ancho: 500px Alto: 400px)</span></label>
              <input name="archivo" id="archivo" type="file" />
              <input name="archivo_HIDDEN" type="hidden" value="<?php echo $dato[0]['file'] ?>"/>
            </div>        
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>
        <button type="button" onclick="javascript:location.href='page-test_iq_preguntas-<?php echo $tipo?>_<?php echo $serie?>'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
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
