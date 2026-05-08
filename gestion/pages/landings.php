<?php

extract($_REQUEST);

?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
     <li><a href="page-test_iq_tipos">Listado</a></li>
   </ol>
  <h1><i class="fa fa-file"></i> Landing Page </h1>
</section>
<?php
$cls = new ClssLanding();
$registros = $cls->listar();
?>

<!-- Main content -->

<section class="content ">
  <div class="box">
    <div class="box-body">
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col" class="text-center" width="8%">Testimonios</th>
            <th scope="col" class="text-center" width="8%">Precios</th>
            <th scope="col" class="text-center" width="8%">F.A.Q.</th>
            <th scope="col" class="text-center" width="8%">Editar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $row) { ?>
          <tr>
            <td><?php echo $row['title']; ?></td>
            <td class="text-center"><a href="page-landing_testimonios-<?php echo $row['id']; ?>" title="ir a Testimonios" class="editar"><span>Entrar</span></a></td>
            <td class="text-center"><a href="page-landing_precios-<?php echo $row['id']; ?>" title="ir a Precios" class="editar"><span>Entrar</span></a></td>
            <td class="text-center"><a href="page-landing_faqs-<?php echo $row['id']; ?>" title="ir a F.A.Q" class="editar"><span>Entrar</span></a></td>
            <td class="text-center"><a href="page-landing-<?php echo $row['id']; ?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div> 
  </div>
</section>

<!-- /.content --> 

