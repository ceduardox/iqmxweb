<?php

extract($_REQUEST);

$cls = new ClssTestiQ();

$cod = (isset($cod)) ? $cod : 0;

$dato = $cls->tipo($cod);
  


 ?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="page-test_iq_tipos">Listado</a></li>
    <li class="active">Editar</li>
  </ol>
  <h1><i class="fa fa-newspaper-o"></i> Tipo  </h1>
</section>

<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data" >
  <section class="content">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos del tipo</h3>
      </div>
      <div class="box-body">
        <input type="hidden" value="guardarTestiQTipo" name="accion" />
        <input type="hidden" value="<?php echo $cod ?>" name="cod" />
        <input type="hidden" value="<?php echo $dato[0]['categoria_id'] ?>" name="categoria" />
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" class="required form-control" value="<?php echo $dato[0]['nombre'] ?>" />
        </div>
        <div class="form-group">
          <label for="slug">Slug</label>
          <input type="text" id="slug" name="slug" class="required form-control" value="<?php echo $dato[0]['slug'] ?>" />
        </div>
        <div>Categoría: <strong><?php echo $dato[0]['categoria'] ?></strong></div><br />

        <div class="form-group">
          <label for="edad_min">Edad Mínima</label>
          <input type="text" id="edad_min" name="edad_min" class="required form-control" value="<?php echo $dato[0]['edad_min'] ?>" />
        </div>
        <div class="form-group">
          <label for="edad_max">Edad máxima</label>
          <input type="text" id="edad_max" name="edad_max" class="required form-control" value="<?php echo $dato[0]['edad_max'] ?>" />
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>
        <button type="button" onclick="javascript:location.href='page-test_iq_tipos'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
        <div class="alert hidden"></div>
      </div>
    </div>
  </section>
  <div class="clearfix"></div>
</form>

<!-- /.content --> 

<script>

      $(function () {

        var options = {beforeSubmit: showRequest, success: showResponse};

        $("#form_").validate({

            submitHandler: function (form) {

                $(form).ajaxSubmit(options);

            }

        });

    });

</script> 
