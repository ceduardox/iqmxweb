<?php

extract($_REQUEST);

?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Materiales</li>
  </ol>
  <h1><i class="fa fa-file"></i> Materiales <small>Listado de materiales</small> </h1>
</section>
<?php

$pagina = (isset($pagina)) ? $pagina  : 1;

$cantidad  = 10;

$cls = new ClssMaterial();



$Paginacion = new Paginacion();

$paginado = $Paginacion->pagina($pagina,$cantidad);

$filas    = $Paginacion->registros($cls->listar('',$paginado,$cantidad));

?>

<!-- Main content -->

<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php if(count($filas)>0) { 

		$registros = $cls->listar('',NULL,NULL);

 		$total   = $Paginacion->totalRegistros($registros);

		$paginas = $Paginacion->calcularPaginas($total,$cantidad);

?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered  table-striped table-hover">
        <thead>
          <tr>
            <th scope="col" class="text-center" width="3%" >Nº</th>
            <th scope="col" width="28%" >Nombres y Apellidos</th>
            <th scope="col"  class="text-center" width="14%">Categoría</th>
            <th scope="col"  class="text-center" width="14%">Tipo</th>
            <th scope="col" class="text-center"  width="8%">Editar</th>
            <th scope="col" class="text-center" width="8%">Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php $num = 0; foreach ($filas as $row) {  $num++; ?>
          <tr>
            <td class="text-center"><?php echo (($pagina*$cantidad)+$num)-$cantidad?></td>
            <td class="text-uppercase" ><?php echo $row['nombre'];?> </td>
            <td class="text-center"><?php echo ($row['categoria']); ?></td>
            <td class="text-center"><?php echo ($row['tipo']); ?></td>
            <td class="text-center"><a href="page-material-<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarMaterial')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix">
      <?php			

	  echo $Paginacion->pintarPaginas($paginas,$pagina,$total,$cantidad,'page-materiales');

	  ?>
      <?php

} else { echo 'Aún no hay materiales registrados.'; } ?>
    </div>
  </div>
</section>

<!-- /.content --> 

