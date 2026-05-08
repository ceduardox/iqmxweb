<?php
extract($_REQUEST);
$cls  = new ClssContacto();
$cod  = (isset($cod)) ? $cod : 0;
$dato = $cls->listar($cod);
if ($cod == 0) {
    $dato[0]['nombre'] = '';
    $dato[0]['latitude'] = '-15.2232380212186';
    $dato[0]['longitude'] = '-64.80028140747072';
    $dato[0]['direccion'] = '';
    $dato[0]['fono'] = '';
    $dato[0]['email'] = '';
    $dato[0]['imagen'] = '';
    $dato[0]['color'] = '';
    $dato[0]['urlMap'] = '';
}
?>

<!-- Content Header (Page header) -->

<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Contactos</li>
    </ol>
    <h1><i class="fa fa-map-marker"></i> Contactos <small>Editar información</small> </h1>
</section>

<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data">
    <input type="hidden" value="guardarContacto" name="accion" />
    <input type="hidden" value="<?php
echo $cod;
?>" name="cod" />
    <section class="content ">
        <div class="box ">
            <div class="box-header with-border">
                <h3 class="box-title">Datos del contacto</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">


                        <div class="form-group">
                            <label for="nombre">Nombre </label>
                            <input name="nombre" id="nombre" type="text" class="required form-control"
                                value="<?php echo $dato[0]['nombre']; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="fono">Teléfono </label>
                            <input name="fono" id="fono" type="text" class="required form-control"
                                value="<?php echo $dato[0]['fono']; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email </label>
                            <input name="email" id="email" type="text" class="required form-control"
                                value="<?php echo $dato[0]['email']; ?>" />
                        </div>

                        <div class="form-group">
                            <label for="color">Color </label>
                            <input name="color" id="color" type="color" class="required form-control"
                                value="<?php echo $dato[0]['color']; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="imagen">Foto del local </label>
                            <input type="file" id="imagen" name="imagen" />
                            <input type="hidden" name="imagen_HIDDEN" value="<?php echo $dato[0]['imagen'];?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección </label>
                    <textarea name="direccion" id="direccion"
                        class="required form-control"><?php echo $dato[0]['direccion']; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="urlMap">Google Maps </label>
                    <input type="text" name="urlMap" class="form-control" value="<?php echo $dato[0]['urlMap'];?>" placeholder="https://maps.app.goo.gl/..."  />
                </div>

            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="guardar" name="guardar">Guardar</button>
                <button type="button" onclick="javascript:location.href='page-contactos'" class="btn btn-default"
                    id="btn-cancelar" name="cancelar">Volver</button>
                <div class="alert hidden"></div>
            </div>
        </div>
    </section>
</form>

<!-- /.content -->

<script>
$(function() {
    var options = {
        beforeSubmit: showRequest,
        success: showResponse
    };

    $("#form_").validate({
        submitHandler: function(form) {
            $(form).ajaxSubmit(options);
        }
    });
});
</script>