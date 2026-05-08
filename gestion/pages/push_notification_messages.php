<?php
extract($_REQUEST);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Notificación Push</li>
  </ol>
  <h1><i class="fa fa-mobile"></i> Mensajes <small>Listado</small> </h1>
</section>
<?php
$pagina = (isset($pagina)) ? $pagina : 1;
$cantidad = 10;
$cls = new ClssPushNoification();
$Paginacion = new Paginacion();
$paginado = $Paginacion->pagina($pagina, $cantidad);
$rows = $Paginacion->registros($cls->listar('', $paginado, $cantidad));
?>
<!-- Main content -->
<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php if (count($rows) > 0) {
        $registros = $cls->listar('', NULL, NULL);
        $total = $Paginacion->totalRegistros($registros);
        $paginas = $Paginacion->calcularPaginas($total, $cantidad);
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0"
          class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Titulo</th>
              <th scope="col" class="text-center" width="12%">Pantalla</th>
              <th scope="col" class="text-center" width="8%">Enviar</th>
              <th scope="col" class="text-center" width="8%">Editar</th>
              <th scope="col" class="text-center" width="8%">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $row) {
              $label = $cls->findOptionLabelByValue($row['deepLink']);
              $screen = $label ? $label : 'No encontrado';
              ?>
              <tr>
                <td><?php echo $row['title']; ?></td>
                <td class="text-center"><?php echo $screen; ?></td>
                <td class="text-center"><a href="page-push_notification_message_enviar-<?php echo $row['id']; ?>"
                    title="ir a Enviar" class="enviar"><span>Enviar</span></a></td>
                <td class="text-center"><a href="page-push_notification_message-<?php echo $row['id']; ?>"
                    title="ir a Editar" class="editar"><span>Editar</span></a></td>
                <td class="text-center"><a href="javascript:void(0)"
                    onclick="eliminar(<?php echo $row['id']; ?>, 'eliminarPushNotification')" title="Eliminar"
                    class="eliminar"><span>Eliminar</span></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="box-footer clearfix">
        <?php
        echo $Paginacion->pintarPaginas($paginas, $pagina, $total, $cantidad, 'page-push_notification_messages');
        ?>
      <?php } else {
        echo 'Aún no hay registros.';
      } ?>
    </div>
  </div>
</section>
<!-- /.content -->