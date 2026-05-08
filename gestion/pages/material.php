<?php

extract($_REQUEST);

$cls = new ClssMaterial();

$cod = (isset($cod)) ? $cod : 0;

$dato = $cls->listar($cod);

if ($cod == 0) {

    $dato[0]['nombre'] = '';

    $dato[0]['material_categoria_id'] = '';

    $dato[0]['material_tipo_id'] = '';

    $dato[0]['archivo'] = '';
    $dato[0]['archivo_down'] = '';

}

 ?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Materiales</li>
  </ol>
  <h1><i class="fa fa-file"></i> Materiales <small>Editar material</small> </h1>
</section>

<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data" >
  <input type="hidden" value="guardarMaterial" name="accion" />
  <input type="hidden" value="<?php echo $cod ?>" name="cod" />
  <section class="content ">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos del material</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6 pl0">
              <div class="form-group">
                <label for="material_tipo">Tipo </label>
                <select  name="material_tipo" id="material_tipo"  class="required form-control" onchange="javascript:setTipo(this.value)">
                  <option value="">- seleccione -</option>
                  <?php 
					$tipos = $cls->tipo();
					foreach($tipos as $tipo) {
						$selected = ($dato[0]['material_tipo_id']==$tipo['id']) ? "selected='selected'" : "";
					?>
                  <option value="<?php echo $tipo['id']?>" <?php echo $selected?>><?php echo $tipo['nombre']?></option>
                  <?php 
				  	}
				  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6 pr0">
              <div class="form-group">
                <label for="material_categoria">Categoría </label>
                <select  name="material_categoria" id="material_categoria"  class="required form-control">
                  <option value="">- seleccione -</option>
                  <?php 
					$categorias = $cls->categoria();
					foreach($categorias as $categoria) {
						$selected = ($dato[0]['material_categoria_id']==$categoria['id']) ? "selected='selected'" : "";
					?>
                  <option value="<?php echo $categoria['id']?>" <?php echo $selected?>><?php echo $categoria['nombre']?></option>
                  <?php 
				  	}
				  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="nombre">Nombre </label>
              <input  name="nombre" id="nombre" type="text" class="required form-control" value="<?php echo $dato[0]['nombre'] ?>"/>
            </div>
            <div class="tipos" id="tipo-1" style=" display:none">
                <div class="form-group" >
                  <label for="video">Video </label>
                  <input  name="video" id="video" type="text" class="required form-control" value="<?php echo $dato[0]['archivo'] ?>"/>
                </div>
                <div class="form-group " >
                  <label for="archivo_down">Archivo de descarga</label>
                  <input type="file" id="archivo_down" name="archivo_down"  />
                  <input type="hidden"  name="archivo_down_HIDDEN" value="<?php echo $dato[0]['archivo_down'] ?>" />
                </div>
            </div>
            <div class="form-group tipos" id="tipo-2" style=" display:none">
              <label for="archivo">Archivo </label>
              <input type="file" id="archivo" name="archivo"  />
              <input type="hidden"  name="archivo_HIDDEN" value="<?php echo $dato[0]['archivo'] ?>" />
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>
        <button type="button" onclick="javascript:location.href='page-materiales'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
        <div class="alert hidden"></div>
      </div>
    </div>
  </section>
</form>

<!-- /.content --> 

<script>
var FILE_SIZE = 20971520; //20MB
var FILE_EXT_OK = ["zip" , "rar"];
$(function () {
	$('#archivo_down').change(function () {
		validaExtension(this,FILE_EXT_OK);
	})
	
	var options = {beforeSubmit: showRequest, success: showResponse};
	
	$("#form_").validate({
		submitHandler: function (form) {
			$(form).ajaxSubmit(options);
		}
	});
	setTipo(<?php echo $dato[0]['material_tipo_id']?>);
});

function calculateSize(f) {
	if (f.files[0].size > FILE_SIZE || f.files[0].fileSize > FILE_SIZE){
	   f.value = null;
	   alert("El tamaño del archivo es demasiado (Max. "+((FILE_SIZE/1024)/1024)+" MB)")
	}
}

function validaExtension(f,extOk) {
	var file= f.value;
	var ext = file.split(".");
	ext = ext[ext.length-1].toLowerCase();      
	var arrayExtensions = extOk;

    if (arrayExtensions.lastIndexOf(ext) == -1) {
	   f.value = null;
	   alert("El formato del archivo es incorrecto, sólo se permiten archivos con extesión: "+arrayExtensions.toString())
    } else {
		calculateSize(f);
	}	
}

function setTipo(value) {
	$('.tipos').fadeOut(100,function(){
		$('#tipo-'+value+'.tipos').fadeIn(100);
	})
}
</script> 
