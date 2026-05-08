<?php

extract($_REQUEST);

$cls = new ClssMaterial();

$cod = (isset($cod)) ? $cod : 0;

$dato = $cls->categoria($cod);

if ($cod == 0) {

    $dato[0]['nombre'] = '';

}

$referenciaDato = $dato[0]['slug'];



 ?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Categorías</li>
  </ol>
  <h1><i class="fa fa-newspaper-o"></i> Categorías <small>Editar categoría</small> </h1>
</section>

<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data" >
  <section class="content">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos de la categoría</h3>
      </div>
      <div class="box-body">
        <input type="hidden" value="guardarMaterialCategoria" name="accion" />
        <input type="hidden" value="<?php echo $cod ?>" name="cod" />
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" class="required form-control" value="<?php echo $dato[0]['nombre'] ?>" />
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>
        <button type="button" onclick="javascript:location.href='page-materiales_categorias'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
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
