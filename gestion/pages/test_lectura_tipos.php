<?php

extract($_REQUEST);

?>

<!-- Content Header (Page header) -->



<section class="content-header">

  <ol class="breadcrumb">

    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>

    <li class="active">Test de Lectura</li>

  </ol>

  <h1><i class="fa fa-book"></i> Test de Lectura <small>Listado de tipos</small> </h1>

</section>

<?php

$pagina = (isset($pagina)) ? $pagina  : 1;

$cantidad  = 10;

$cls = new ClssTest();

$Paginacion = new Paginacion();

$paginado = $Paginacion->pagina($pagina,$cantidad);

$noticias = $Paginacion->registros($cls->listarSubCategoria('',$cod,$paginado,$cantidad));

?>



<!-- Main content -->

<section class="content ">

  <div class="box">

    <div class="box-body">

      <?php if(count($noticias)>0) { 

		$registros = $cls->listarSubCategoria('',$cod,NULL,NULL);

 		$total   = $Paginacion->totalRegistros($registros);

		$paginas = $Paginacion->calcularPaginas($total,$cantidad);

?>

      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">

        <thead>

          <tr>

            <th scope="col">Tipo</th>

            <th scope="col" class="text-center" width="8%">Lectura</th>

          </tr>

        </thead>

        <tbody>

          <?php foreach ($noticias as $row) { ?>

          <tr>

            <td><?php echo $row['nombre']; ?></td>

            <td class="text-center"><a href="page-test_lectura_tipos_lecturas-<?php echo $cod; ?>_<?php echo $row['id']; ?>" title="ir a Lectura" class="entrar"><span>Entrar</span></a></td>

          </tr>

          <?php } ?>

        </tbody>

      </table>

    </div>

    <div class="box-footer clearfix">

      <?php			

	  echo $Paginacion->pintarPaginas($paginas,$pagina,$total,$cantidad,'page-test_lectura');

	  ?>

      <?php } else { echo 'Aún no hay lecturas registradas.'; } ?>

    </div>

  </div>

</section>

<!-- /.content --> 

