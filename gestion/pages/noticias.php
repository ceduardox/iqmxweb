<?php
extract($_REQUEST);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Noticias</li>
  </ol>
  <h1><i class="fa fa-newspaper-o"></i> Noticias <small>Listado de noticias</small> </h1>
</section>
<?php
$pagina = (isset($pagina)) ? $pagina  : 1;
$cantidad  = 10;
$cls = new ClssNoticia();
$Paginacion = new Paginacion();
$paginado = $Paginacion->pagina($pagina,$cantidad);
$noticias = $Paginacion->registros($cls->listar('',$paginado,$cantidad));
?>

<!-- Main content -->
<section class="content ">
  <div class="box">
    <div class="box-body">
  <?php if(count($noticias)>0) { 
		$registros = $cls->listar('',NULL,NULL);
 		$total   = $Paginacion->totalRegistros($registros);
		$paginas = $Paginacion->calcularPaginas($total,$cantidad);
?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Título</th>
            <th scope="col" class="text-center" width="15%">Publicado</th>
            <th scope="col" class="text-center" width="8%">Comentarios</th>
            <th scope="col" class="text-center" width="8%">Editar</th>
            <th scope="col" class="text-center" width="8%">Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($noticias as $row) { ?>
          <tr>
            <td><?php echo $row['titulo']; ?></td>
            <td class="text-center"><?php echo setFormatoFecha($row['publicado_el']); ?></td>
            <td class="text-center"><a href="page-noticia_comentario-<?php echo $row['id']; ?>" title="Ver comentario" class="ver"><span>Ver</span></a></td>
            <td class="text-center"><a href="page-noticia-<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarNoticia')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix">
      <?php			
	  echo $Paginacion->pintarPaginas($paginas,$pagina,$total,$cantidad,'page-noticias');
	  ?>
<?php } else { echo 'Aún no hay noticias registradas.'; } ?>
    </div>
  </div>
</section>
<!-- /.content --> 
