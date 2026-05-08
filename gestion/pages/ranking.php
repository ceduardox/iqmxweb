<?php

extract($_REQUEST);

$cls = new ClssRanking();

$cod = (isset($cod)) ? $cod : 0;

$dato = $cls->listar($cod);

validExistData($dato,$cod);

if ($cod == 0) {

    $dato[0]['nombres'] = '';

    $dato[0]['apepa'] = '';

    $dato[0]['apema'] = '';

    $dato[0]['ciudad'] = '';

    $dato[0]['foto'] = '';

    $dato[0]['email'] = '';

}

 ?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Ranking</li>
  </ol>
  <h1><i class="fa fa-users"></i> Ranking <small>Editar datos</small> </h1>
</section>

<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data" >
  <input type="hidden" value="guardarRanking" name="accion" />
  <input type="hidden" value="<?php echo $cod ?>" name="cod" />
  <section class="content ">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos del usuario</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="nombres">Nombres </label>
              <input  name="nombres" id="nombres" type="text" class="required form-control" value="<?php echo $dato[0]['nombres'] ?>"/>
            </div>
            <div class="form-group">
              <label for="apepa">Apellido Paterno </label>
              <input  name="apepa" id="apepa" type="text" class="required form-control" value="<?php echo $dato[0]['apepa'] ?>"/>
            </div>
            <div class="form-group">
              <label for="apema">Apellido Materno </label>
              <input  name="apema" id="apema" type="text"  class=" form-control" value="<?php echo $dato[0]['apema'] ?>"/>
            </div>
            <div class="form-group">
              <label for="ciudad">Ciudad </label>
              <input  name="ciudad" id="ciudad" type="text"  class="required form-control" value="<?php echo $dato[0]['ciudad'] ?>"/>
            </div>
            <div class="form-group">
              <label for="email">Email </label>
              <input  name="email" id="email" type="email"  class="required form-control" value="<?php echo $dato[0]['email'] ?>"/>
            </div>
            <div class="form-group">
              <label for="foto">Foto <span class="text-mini">(Ancho: 200px Alto: 200px)</span>
                <?php if($dato[0]['foto']!="") { ?>
                (<a href="../<?php echo PATH_IMG_RANKING.$dato[0]['foto'] ?>" target="_blank">VER</a>)
                <?php } ?>
              </label>
              <input type="file" id="foto" name="foto"  />
              <input type="hidden"  name="foto_HIDDEN" value="<?php echo $dato[0]['foto'] ?>" />
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>
        <button type="button" onclick="javascript:location.href='page-rankings'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
        <div class="alert hidden"></div>
      </div>
    </div>
  </section>
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
