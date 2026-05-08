<?php
extract($_REQUEST);

$pagina = (isset($pagina)) ? $pagina  : 1;
$cantidad  = 10;
$cls = new ClssRanking();

$Paginacion = new Paginacion();
$paginado = $Paginacion->pagina($pagina,$cantidad);
$filas    = $Paginacion->registros($cls->listarRankingModulo('',$cod,$paginado,$cantidad));

$persona = $cls->listar($cod);
?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Ranking</li>
  </ol>
  <h1><i class="fa fa-users"></i> Ranking <small>Listado de personas</small> </h1>
  <h2><?php echo $persona[0]['nombres']." ".$persona[0]['apepa']." ".$persona[0]['apema']?> </h2>
  <button type="button pull-left" onclick="javascript:location.href='page-rankings-<?php echo $cod?>'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
  <button type="button" onclick="javascript:location.href='page-ranking_modulo-<?php echo $cod?>'"  class="btn btn-primary" id="btn-nuevo" name="btn-nuevo"  >Nuevo registro</button>
  <div class="clearfix"></div>
</section>
<!-- Main content -->
<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php if(count($filas)>0) { 
		$registros = $cls->listarRankingModulo('',$cod,NULL,NULL);
 		$total   = $Paginacion->totalRegistros($registros);
		$paginas = $Paginacion->calcularPaginas($total,$cantidad);
?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered  table-striped table-hover">
        <thead>
          <tr>
            <th scope="col" class="text-center" width="3%" >Nº</th>
            <th scope="col"  >Ranking</th>
            <th scope="col"  class="text-center" >Módulo</th>
            <th scope="col"  class="text-center" width="8%">Categoría</th>
            <th scope="col"  class="text-center" width="8%">Edad</th>
            <th scope="col"  class="text-center" width="8%">Mes</th>
            <th scope="col"  class="text-center" width="8%">Año</th>
            <th scope="col"  class="text-center" width="8%">Velocidad</th>
            <th scope="col" class="text-center"  width="8%">Editar</th>
            <th scope="col" class="text-center" width="8%">Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php $num = 0; foreach ($filas as $row) {  $num++; ?>
          <tr>
            <td class="text-center"><?php echo (($pagina*$cantidad)+$num)-$cantidad?></td>
            <td class="text-uppercase" ><?php echo $row['tipo_ranking'];?></td>
            <td class="text-center"><?php echo $row['modulo']; ?></td>
            <td class="text-center"><?php echo $row['categoria']; ?></td>
            <td class="text-center"><?php echo $row['edad']; ?></td>
            <td class="text-center"><?php echo getMes($row['mes']); ?></td>
            <td class="text-center"><?php echo $row['anho']; ?></td>
            <td class="text-center"><?php echo $row['velocidad']; ?></td>
            <td class="text-center"><a href="page-ranking_modulo-<?php echo $cod; ?>_<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarRankingModulo')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix">
      <?php			
	  echo $Paginacion->pintarPaginas($paginas,$pagina,$total,$cantidad,'page-ranking_modulos-'.$cod);
	  ?>
      <?php
} else { echo 'Aún no hay usuarios registrados.'; } ?>
    </div>
  </div>
</section>
<!-- /.content --> 
