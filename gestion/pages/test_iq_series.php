<?php

extract($_REQUEST);
  
$tipo = $cod; 

$cls = new ClssTestiQ();
 
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
  <h1><i class="fa fa-th-large"></i> Series</h1>
   <button type="button pull-left" onclick="javascript:location.href='page-test_iq_tipos'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
   
  <div class="clearfix"></div>
</section>

<!-- Main content -->

<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php 
 		$registros = $cls->serie('',$tipo);
		if(count($registros)>0) {  
 ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Serie</th>
            <th scope="col" class="text-center" width="8%">Preguntas</th>
            <th scope="col" class="text-center" width="8%">Editar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $row) { ?>
          <tr>
            <td> <?php echo $row['nombre']; ?>  </td>
            <td class="text-center"><a href="page-test_iq_preguntas-<?php echo $tipo?>_<?php echo $row['id']; ?>" title="ir a Alternativas" class="editar"><span>Entrar</span></a></td>
            <td class="text-center"><a href="page-test_iq_serie-<?php echo $tipo?>_<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix"> 
      <?php } else { echo 'Aún no hay series registradas.'; } ?>
    </div>
  </div>
</section>

<!-- /.content --> 

