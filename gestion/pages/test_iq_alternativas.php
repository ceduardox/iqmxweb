<?php

extract($_REQUEST);
  
$cod = isset($cod) ? $cod : array();

$cods = explode("_",$cod);  
$tipo = $cods[0];

$serie = $cods[1];

$pregunta = $cods[2];
 

$cls = new ClssTestiQ();

$tipo_rs = $cls->tipo($tipo);
$serie_rs = $cls->serie($serie);
$pregunta_rs = $cls->pregunta($pregunta,$serie);

?>

<!-- Content Header (Page header) -->

<section class="content-header">
   <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="page-test_iq_tipos">Test iQ</a></li>
    <li><a href="page-test_iq_tipos"><?php echo $tipo_rs[0]['nombre']?></a></li>
    <li><a href="page-test_iq_series-<?php echo $tipo?>"><?php echo $serie_rs[0]['nombre']?></a></li>
    <li><a href="page-test_iq_preguntas-<?php echo $tipo?>_<?php echo $serie?>"><?php echo $pregunta_rs[0]['nombre']?></a></li> 
    <li class="active">Listado</li>
  </ol>
  <h1><i class="fa fa-th-large"></i> Alternativas   </h1>
    <button type="button pull-left" onclick="javascript:location.href='page-test_iq_preguntas-<?php echo $tipo?>_<?php echo $serie?>_<?php echo $pregunta?>'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
  <button type="button" onclick="javascript:location.href='page-test_iq_alternativa-<?php echo $tipo?>_<?php echo $serie?>_<?php echo $pregunta?>_0'"  class="btn btn-primary" id="btn-nuevo" name="btn-nuevo"  >Nuevo registro</button>
  <div class="clearfix"></div>
</section>

<!-- Main content -->

<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php 
 		$registros = $cls->alternativa('',$pregunta,$serie,NULL,NULL);
       if(count($registros)>0) {  
 ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Alternativa</th>
            <th scope="col" class="text-center" width="8%">Correcto</th>
            <th scope="col" class="text-center" width="8%">Editar</th>
            <th scope="col" class="text-center" width="8%">Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $row) { ?>
          <tr>
            <td> <?php echo $row['nombre']; ?>  </td>
            <td class="text-center"><a href="javascript:void(0)" onclick="activo(<?php echo $row['verdader']; ?>,<?php echo $row['id']; ?>, 'verdaderoTestiQAlternativa')" title="<?php echo getActivo($row['verdader'],array('ok'=>'Si','ko'=>'marcar como alternativa correcta')) ?>" class=" "><span><?php echo getActivo($row['verdader'],array('ok'=>'<strong>Si</strong>','ko'=>'<i>No</i>')) ?></span></a></td>
            <td class="text-center"><a href="page-test_iq_alternativa-<?php echo $tipo?>_<?php echo $serie?>_<?php echo $pregunta?>_<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarTestiQAlternativa')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix"> 
      <?php } else { echo 'Aún no hay alternativas registradas.'; } ?>
    </div>
  </div>
</section>

<!-- /.content --> 

