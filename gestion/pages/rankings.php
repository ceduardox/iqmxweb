<?php
extract($_REQUEST);
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Ranking</li>
  </ol>
  <h1><i class="fa fa-users"></i> Ranking <small>Listado de personas</small> </h1>
</section>
<?php
$pagina = (isset($pagina)) ? $pagina  : 1;
$cantidad  = 10;
$cls = new ClssRanking();

$Paginacion = new Paginacion();
$paginado = $Paginacion->pagina($pagina,$cantidad);
$filas    = $Paginacion->registros($cls->listar(NULL,$paginado,$cantidad));
?>

<!-- Main content -->
<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php if(count($filas)>0) { 
		$registros = $cls->listar(NULL,NULL,NULL);
 		$total   = $Paginacion->totalRegistros($registros);
		$paginas = $Paginacion->calcularPaginas($total,$cantidad);
?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered  table-striped table-hover">
        <thead>
          <tr>
            <th scope="col" class="text-center" width="3%" >Nº</th>
            <th scope="col" width="28%" >Nombres y Apellidos</th>
            <th scope="col"  class="text-center" width="14%">Ciudad</th>
            <th scope="col"  class="text-center" width="8%">Módulo</th>
            <th scope="col" class="text-center"  width="8%">Editar</th>
            <th scope="col" class="text-center" width="8%">Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php $num = 0; foreach ($filas as $row) {  $num++; ?>
          <tr>
            <td class="text-center"><?php echo (($pagina*$cantidad)+$num)-$cantidad?></td>
            <td class="text-uppercase" ><?php echo $row['nombres'];?> <?php echo $row['apepa'];?> <?php echo $row['apema'];?></td>
            <td class="text-center"><?php echo ($row['ciudad']); ?></td>
            <td class="text-center"><a href="page-ranking_modulos-<?php echo $row['id']; ?>" title="ir a Módulos" class="entrar"><span>Entrar</span></a></td>
            <td class="text-center"><a href="page-ranking-<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarRanking')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix">
      <?php			
	  echo $Paginacion->pintarPaginas($paginas,$pagina,$total,$cantidad,'page-rankings');
	  ?>
      <?php
} else { echo 'Aún no hay usuarios registrados.'; } ?>
    </div>
  </div>
</section>
<!-- /.content --> 
