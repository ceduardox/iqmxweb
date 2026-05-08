<?php

extract($_REQUEST);
  
$cod = isset($cod) ? $cod : array();

$cods = explode("_",$cod);  

$tipo = $cods[0];

$serie = $cods[1];

$cls = new ClssTestiQ();
 
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
    <li class="active">Listado</li>
  </ol>
  <h1><i class="fa fa-th-large"></i> Preguntas  </h1>
   <button type="button pull-left" onclick="javascript:location.href='page-test_iq_series-<?php echo $tipo?>'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
  <button type="button" onclick="javascript:location.href='page-test_iq_pregunta-<?php echo $tipo?>_<?php echo $serie?>_0'"  class="btn btn-primary" id="btn-nuevo" name="btn-nuevo"  >Nuevo registro</button>
  <div class="clearfix"></div>
</section>

<!-- Main content -->

<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php 
 		$registros = $cls->pregunta('',$serie,NULL,NULL);
		if(count($registros)>0) {  
 ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Pregunta</th>
            <th scope="col" class="text-center" width="8%">Alternativas</th>
            <th scope="col" class="text-center" width="8%">Editar</th>
            <th scope="col" class="text-center" width="8%">Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $row) { ?>
          <tr>
            <td> <?php echo $row['nombre']; ?>  </td>
            <td class="text-center"><a href="page-test_iq_alternativas-<?php echo $cod?>_<?php echo $row['id']; ?>" title="ir a Alternativas" class="editar"><span>Entrar</span></a></td>
            <td class="text-center"><a href="page-test_iq_pregunta-<?php echo $cod?>_<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarTestiQPregunta')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix"> 
      <?php } else { echo 'Aún no hay preguntas registradas.'; } ?>
    </div>
  </div>
</section>

<!-- /.content --> 

