<?php

extract($_REQUEST);

?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Categorías</li>
  </ol>
  <h1><i class="fa fa-newspaper-o"></i> Categorías <small>Listado de categorías</small> </h1>
   <button type="button" onclick="javascript:location.href='page-materiales_categoria'"  class="btn btn-primary" id="btn-nuevo" name="btn-nuevo"  >Nuevo registro</button>
</section>
<?php

$pagina = (isset($pagina)) ? $pagina  : 1;

$cantidad  = 10;

$cls = new ClssMaterial();

$Paginacion = new Paginacion();

$paginado = $Paginacion->pagina($pagina,$cantidad);

$noticias = $Paginacion->registros($cls->categoria('',$paginado,$cantidad));

?>

<!-- Main content -->

<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php if(count($noticias)>0) { 

		$registros = $cls->categoria('',NULL,NULL);

 		$total   = $Paginacion->totalRegistros($registros);

		$paginas = $Paginacion->calcularPaginas($total,$cantidad);

?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Categoría</th>
            <th scope="col" class="text-center" width="8%">Editar</th>
            <th scope="col" class="text-center" width="8%">Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($noticias as $row) { ?>
          <tr>
            <td><?php echo $row['nombre']; ?></td>
            <td class="text-center"><a href="page-materiales_categoria-<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarMaterialCategoria')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix">
      <?php			

	  echo $Paginacion->pintarPaginas($paginas,$pagina,$total,$cantidad,'page-materiales_categorias');

	  ?>
      <?php } else { echo 'Aún no hay categorías registradas.'; } ?>
    </div>
  </div>
</section>

<!-- /.content --> 

