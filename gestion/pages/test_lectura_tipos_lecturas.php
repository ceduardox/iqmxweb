<?php

extract($_REQUEST);



$cod = isset($cod) ? $cod : array();

$cods = explode("_",$cod);  

$categoria_id = $cods[0];

$subCategoria_id = $cods[1];



$pagina = (isset($pagina)) ? $pagina  : 1;

$cantidad  = 10;

$cls = new ClssTest();

$Paginacion = new Paginacion();

$paginado = $Paginacion->pagina($pagina,$cantidad);

$rows = $Paginacion->registros($cls->listarLectura('',$categoria_id,$subCategoria_id,$paginado,$cantidad));

?>

<!-- Content Header (Page header) -->



<section class="content-header">
  <ol class="breadcrumb">

    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>

    <li class="active">Test de Lectura</li>

  </ol>

  <h1><i class="fa fa-book"></i> Test de Lectura <small>Listado de categorías</small> </h1>
  <button type="button pull-left" onclick="javascript:location.href='page-test_lectura_tipos-<?php echo $categoria_id?>'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
  <button type="button" onclick="javascript:location.href='page-test_lectura_tipos_lectura-<?php echo $categoria_id?>_<?php echo $subCategoria_id; ?>_0'"  class="btn btn-primary" id="btn-nuevo" name="btn-nuevo"  >Nuevo registro</button>
   
  <div class="clearfix"></div>
</section>



<!-- Main content -->

<section class="content ">

  <div class="box">

    <div class="box-body">

      <?php if(count($rows)>0) { 

		$registros = $cls->listarLectura('',$categoria_id,$subCategoria_id,NULL,NULL);

 		$total   = $Paginacion->totalRegistros($registros);

		$paginas = $Paginacion->calcularPaginas($total,$cantidad);

?>

      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">

        <thead>

          <tr>

            <th scope="col">Lectura</th>

            <th scope="col" class="text-center" width="8%">Activo</th>

            <th scope="col" class="text-center" width="8%">Editar</th>

            <th scope="col" class="text-center" width="8%">Eliminar</th>

          </tr>

        </thead>

        <tbody>

          <?php foreach ($rows as $row) { ?>

          <tr>

            <td><strong><?php echo $row['titulo']; ?></strong><br />

              <?php echo ($row['subtitulo']!="") ? '<i>'.$row['subtitulo'].'</i><br />' : '' ?> <?php echo ($row['texto']!="") ? setCortarTextoLimpio($row['texto'],350) :'' ?></td>

            <td class="text-center"><a href="javascript:void(0)" onclick="activo(<?php echo $row['activo']; ?>,<?php echo $row['id']; ?>, 'activoLectura')" title="<?php echo getActivo($row['activo']) ?>" class=" "><span><?php echo getActivo($row['activo']) ?></span></a></td>

            <td class="text-center"><a href="page-test_lectura_tipos_lectura-<?php echo $cod?>_<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>

            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarLectura')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>

          </tr>

          <?php } ?>

        </tbody>

      </table>

    </div>

    <div class="box-footer clearfix">

      <?php			

	  echo $Paginacion->pintarPaginas($paginas,$pagina,$total,$cantidad,'page-test_lectura_tipos_lecturas-'.$cod);

	  ?>

      <?php } else { echo 'Aún no hay categorías registradas.'; } ?>

    </div>

  </div>

</section>

<!-- /.content --> 

