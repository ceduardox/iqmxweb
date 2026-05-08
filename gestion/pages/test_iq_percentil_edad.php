<?php

extract($_REQUEST);

$cls = new ClssTestiQ();

$cod = isset($cod) ? $cod : array();

$cods = explode("_",$cod);  
$tipo = $cods[0];
$percentil = $cods[1];
$percentil_edad = $cods[2];

$dato = $cls->percentilEdad($percentil_edad,$percentil);
  
if ($percentil == 0) {
    $dato[0]['percentil_id'] = 0;
    $dato[0]['edad_id'] = 0; 
    $dato[0]['valor'] = 0; 
}

$tipo_rs = $cls->tipo($tipo); 
$percentil_rs = $cls->percentil($tipo,$percentil);

?>

<!-- Content Header (Page header) -->

<section class="content-header">
   <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="page-test_iq_tipos">Test iQ</a></li>
    <li><a href="page-test_iq_tipos"><?php echo $tipo_rs[0]['nombre']?></a></li>
    <li><a href="page-test_iq_percentiles-<?php echo $tipo?>"><?php echo $percentil_rs[0]['nombre']?></a></li>
    <li><a href="page-test_iq_percentiles_edad-<?php echo $tipo?>_<?php echo $percentil?>">Listado</a></li>
    <li class="active">Editar</li>
  </ol>
  <h1><i class="fa fa-th-large"></i> Edad   </h1>
  <button type="button pull-left" onclick="javascript:location.href='page-test_iq_percentiles_edad-<?php echo $tipo?>_<?php echo $percentil?>'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
  <button type="button" onclick="javascript:location.href='page-test_iq_percentil_edad-<?php echo $tipo?>_<?php echo $percentil?>_0'"  class="btn btn-primary" id="btn-nuevo" name="btn-nuevo"  >Nuevo registro</button>
  <div class="clearfix"></div>
</section>

<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data" >
  <section class="content">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos de la edad</h3>
      </div>
      <div class="box-body">
        <input type="hidden" value="guardarTestiQPercentilEdad" name="accion" />
         <input type="hidden" value="<?php echo $percentil ?>" name="percentil" /> 
         <input type="hidden" value="<?php echo $percentil_edad ?>" name="cod" /> 
       <input type="hidden" value="<?php echo $tipo ?>" name="tipo" /> 
       <div class="form-group">
          <label for="edad">Edad</label>
          <select id="edad" name="edad" class="required form-control" >
          <option value="">- seleccione -</option>
          <?php
		  $filas = $cls->serieEdad('',$tipo);
          foreach($filas as $fila) { 
		  	$selected = ($fila['edad_id']==$dato[0]['edad_id']) ? "selected='selected'" : "";
		  ?>
          <option <?php echo $selected?> value="<?php echo $fila['edad_id'] ?>"><?php echo $fila['edad'] ?> años</option>
          <?php
		  }
		  ?>
          </select>
        </div>
       <div class="form-group">
          <label for="valor">Valor 
mínimo</label>
          <input type="number" id="valor" name="valor" class="required form-control" value="<?php echo $dato[0]['valor'] ?>" />
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>
        <button type="button" onclick="javascript:location.href='page-test_iq_percentiles_edad-<?php echo $tipo?>_<?php echo $percentil?>'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
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
