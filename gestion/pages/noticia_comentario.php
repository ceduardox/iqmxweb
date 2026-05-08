<?php
$cls = new ClssNoticia();
$cod = (isset($_GET['cod'])) ? $_GET['cod'] : 0;
$rows = $cls->getNoticiaComentario('',$cod);
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="page-noticias"><i class="fa fa-newspaper-o"></i> Noticias</a></li>
    <li class="active">Comentarios</li>
  </ol>
  <h1><i class="fa fa-comments-o"></i> Comentarios <small>Listado de comentarios</small> </h1>
</section>

<!-- Main content -->
<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php if(count($rows)>0) { ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Comentario</th>
            <th class="text-center" scope="col" width="15%">Usuario</th>
            <th class="text-center" scope="col" width="8%">Comentado</th>
            <th class="text-center" scope="col" width="8%">Público</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row) { ?>
          <tr>
            <td><?php echo nl2br($row['comentario']); ?></td>
            <td class="text-center"><?php echo $row['usuario']; ?></td>
            <td class="text-center"><?php echo setFormatoFecha($row['creado_el']); ?></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="activo(<?php echo $row['aprobado']; ?>,<?php echo $row['id']; ?>, 'activoNoticiaComentario')" title="<?php echo getActivo($row['aprobado']) ?>" class=" "><span><?php echo getActivo($row['aprobado']) ?></span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php } else { echo 'Aún no hay comentarios registrados.'; } ?>
    </div>
  </div>
</section>
<!-- /.content --> 
