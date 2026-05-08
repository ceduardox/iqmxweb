<?php
extract($_REQUEST);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li>A Leer Bolivia</li>
    <li class="active">Fichas</li>
  </ol>
  <h1><i class="fa fa-file-text"></i> Fichas <small>Listado</small> </h1>
</section>
<?php
$pagina = (isset($pagina)) ? $pagina : 1;
$cantidad = 10;
$cls = new ClssALeerBoliviaFicha();
$Paginacion = new Paginacion();
$paginado = $Paginacion->pagina($pagina, $cantidad);
$noticias = $Paginacion->registros($cls->listar('', $paginado, $cantidad));
?>
<!-- Main content -->
<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php if (count($noticias) > 0) {
        $registros = $cls->listar('', NULL, NULL);
        $total = $Paginacion->totalRegistros($registros);
        $paginas = $Paginacion->calcularPaginas($total, $cantidad);
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0"
          class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col" class="text-center" width="8%">Tipo</th>
              <th scope="col" class="text-center" width="8%">Editar</th>
              <th scope="col" class="text-center" width="8%">Activar</th>
              <th scope="col" class="text-center" width="8%">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($noticias as $row) {
              $activeLabel = $row['active'] == 1 ? 'Activado' : 'Desactivado';
              ?>
              <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td class="text-center"><a href="page-a_leer_bolivia_ficha-<?php echo $row['id']; ?>" title="ir a Editar"
                    class="editar"><span>Editar</span></a></td>
                <td class="text-center"><a href="javascript:void(0)"
                    onclick="activate(<?php echo $row['id']; ?>, 'activateALeerBoliviaFicha', <?php echo $row['active']; ?>)"
                    title="<?php echo $activeLabel ?>" class="eliminar"><span><?php echo $activeLabel ?></span></a></td>
                <td class="text-center"><a href="javascript:void(0)"
                    onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarALeerBoliviaFicha')" title="Eliminar"
                    class="eliminar"><span>Eliminar</span></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="box-footer clearfix">
        <?php
        echo $Paginacion->pintarPaginas($paginas, $pagina, $total, $cantidad, 'page-a_leer_bolivia_fichas');
        ?>
      <?php } else {
        echo 'Aún no hay registros.';
      } ?>
    </div>
  </div>
</section>
<!-- /.content -->