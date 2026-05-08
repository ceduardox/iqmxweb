<?php

extract($_REQUEST);

?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
     <li><a href="page-test_iq_tipos">Listado</a></li>
   </ol>
  <h1><i class="fa fa-th-large"></i> Tipos de Test iQ </h1>
</section>
<?php
$cls = new ClssTestiQ();
$registros = $cls->tipo();
?>

<!-- Main content -->

<section class="content ">
  <div class="box">
    <div class="box-body">
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Tipo</th>
            <th scope="col" class="text-center" width="12%">Categoría</th>
            <th scope="col" class="text-center" width="8%">Percentil</th>
            <th scope="col" class="text-center" width="8%">Serie</th>
            <th scope="col" class="text-center" width="8%">Editar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $row) { ?>
          <tr>
            <td><?php echo $row['nombre']; ?></td>
            <td class="text-center"><?php echo $row['categoria']; ?></td>
            <td class="text-center"><a href="page-test_iq_percentiles-<?php echo $row['id']; ?>" title="ir a Preguntas" class="editar"><span>Entrar</span></a></td>
            <td class="text-center"><a href="page-test_iq_series-<?php echo $row['id']; ?>" title="ir a Preguntas" class="editar"><span>Entrar</span></a></td>
            <td class="text-center"><a href="page-test_iq_tipo-<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div> 
  </div>
</section>

<!-- /.content --> 

