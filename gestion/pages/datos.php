<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Mis datos</li>
  </ol>
  <h1><i class="fa fa-user "></i> Mis datos </h1>
</section>

<!-- Main content -->

<section class="content ">
  <div class="box ">
    <div class="box-header with-border">
      <h3 class="box-title">Datos del usuario</h3>
    </div>
    <form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data" >
      <div class="box-body">
        <input type="hidden" value="guardarMisDatos" name="accion" />
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="nombres">Nombres</label>
              <input name="nombres" id="nombres" type="text" class="required form-control" value="<?php echo $_SESSION['NOM_USER_CITEXBO_ADM'] ?>"/>
            </div>
            <div class="form-group">
              <label for="apepa">Apellido Paterno</label>
              <input name="apepa" id="apepa" type="text" class="required form-control" value="<?php echo $_SESSION['APEPA_USER_CITEXBO_ADM'] ?>"/>
            </div>
            <div class="form-group">
              <label for="apema">Apellido Materno </label>
              <input name="apema" id="apema" type="text" class="form-control"  value="<?php echo $_SESSION['APEMA_USER_CITEXBO_ADM'] ?>"/>
            </div>
            <div class="form-group">
              <label for="foto">Foto <span class="text-mini">(Ancho: 160px Alto: 160px)</span></label>
              <input name="foto" id="foto" type="file" />
              <input name="foto_HIDDEN" type="hidden" value="<?php echo $_SESSION['AVATAR_USER_CITEXBO_ADM'] ?>"/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="email">Email</label>
              <input name="email" id="email" type="text" class="required email form-control" value="<?php echo $_SESSION['EMAIL_USER_CITEXBO_ADM'] ?>"/>
            </div>
            <div class="form-group">
              <label for="clave">Contraseña </label>
              <input name="clave" id="clave" type="password" class="form-control"   />
            </div>
            <div class="form-group">
              <label for="reclave">Confirmar contraseña </label>
              <input name="reclave" id="reclave" type="password" class="form-control"   />
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>
        <button type="button" onclick="javascript:location.href='index'"  class="btn btn-default" id="cancelar" name="cancelar"  >Cancelar</button>
        <div class="alert hidden"></div>
      </div>
    </form>
  </div>
</section>

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
