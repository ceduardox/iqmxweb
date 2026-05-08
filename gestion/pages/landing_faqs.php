<?php

extract($_REQUEST);

$landing_id  = (isset($cod)) ? $cod : 0;
?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
     <li><a href="page-test_iq_tipos">Listado</a></li>
   </ol>
  <h1><i class="fa fa-file"></i> Landing Page / F.A.Q.</h1>
 <br />
    <button type="button pull-left" onclick="javascript:location.href='page-landings'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
   <button type="button" onclick="javascript:location.href='page-landing_faq-<?php echo $landing_id?>_0'"  class="btn btn-primary" id="btn-nuevo" name="btn-nuevo"  >Nuevo registro</button>
</section>
<?php
$cls = new ClssLandingFAQ();
$registros = $cls->listar();
?>

<!-- Main content -->

<section class="content ">
  <div class="box">
    <div class="box-body">
       <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">Pregunta</th>
            <th scope="col" class="text-center" width="8%">Editar</th>
            <th scope="col" class="text-center" width="8%">Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $row) { ?>
          <tr>
            <td><?php echo $row['title']; ?></td>
            <td class="text-center"><a href="page-landing_faq-<?php echo $landing_id."_".$row['id']; ?>" title="ir a F.A.Q" class="editar"><span>Entrar</span></a></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row[ 'id' ];?>, 'eliminarFAQ')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>
         </tr>
          <?php } ?>
        </tbody>
      </table>
    </div> 
  </div>
</section>

<!-- /.content --> 

