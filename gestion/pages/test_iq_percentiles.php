<?php

extract($_REQUEST);
  
 
$cls = new ClssTestiQ();
$tipo = $cod; 
$tipo_rs = $cls->tipo($tipo);

?>

<!-- Content Header (Page header) -->

<section class="content-header">
   <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="page-test_iq_tipos">Test iQ</a></li>
    <li><a href="page-test_iq_tipos"><?php echo $tipo_rs[0]['nombre']?></a></li>
    <li class="active">Listado</li>
  </ol>
  <h1><i class="fa fa-th-large"></i> Percentiles </h1>
   <button type="button pull-left" onclick="javascript:location.href='page-test_iq_tipos'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
  <button type="button" onclick="javascript:location.href='page-test_iq_percentil-<?php echo $cod?>_0'"  class="btn btn-primary" id="btn-nuevo" name="btn-nuevo"  >Nuevo registro</button>
   
  <div class="clearfix"></div>
</section>

<!-- Main content -->

<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php 
 		$registros = $cls->percentil($cod);
		if(count($registros)>0) {  
 ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th width="12%" scope="col">Nombre</th>
            <th scope="col" class="text-center" width="71%">Descripción</th>
            <th scope="col" class="text-center" width="8%">Valor<br />
            mínimo</th>
            <th scope="col" class="text-center" width="10%">Edad<br />
              percentil</th>
            <th scope="col" class="text-center" width="10%">Editar</th>
            <th scope="col" class="text-center" width="10%">Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $row) { ?>
          <tr>
            <td> <?php echo $row['nombre']; ?>  </td>
            <td> <?php echo $row['detalle']; ?>  </td>
            <td class="text-center"> <?php echo $row['valor']; ?>  </td>
            <td class="text-center"><a href="page-test_iq_percentiles_edad-<?php echo $cod; ?>_<?php echo $row['id']; ?>" title="ir a Edades" class="entrar"><span>Entrar</span></a></td>
            <td class="text-center"><a href="page-test_iq_percentil-<?php echo $cod; ?>_<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarTestiQPercentil')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix"> 
      <?php } else { echo 'Aún no hay percentiles registrados.'; } ?>
    </div>
  </div>
</section>

<!-- /.content --> 

