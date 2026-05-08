<?php
extract($_REQUEST);
$objGral = new ClssGeneral();
$cls = new ClssRanking();
if(isset($cod)) {
	$codArr = explode('_',$cod);
	$persona_id = $codArr[0];
	$cod        = isset($codArr[1]) ? $codArr[1] : 0;	
} else {
	die("Error al ingresar a esta sección");
}
$dato = $cls->listarRankingModulo($cod);
validExistData($dato,$cod);
if ($cod == 0) {
	$dato[0]["edad"] = "";
	$dato[0]["anho"] = date("Y");
	$dato[0]["mes"] = date("n");
	$dato[0]["velocidad"] = "";
	$dato[0]["comprension"] = "";
	$dato[0]["persona_id"] = "";
	$dato[0]["tipo_ranking_id"] = "";
	$dato[0]["modulo_id"] = "";
	$dato[0]["categoria_id"] = "";
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
  <input type="hidden" value="guardarRankingModulo" name="accion" />
  <input type="hidden" value="<?php echo $persona_id ?>" name="persona_id" />
  <input type="hidden" value="<?php echo $cod ?>" name="cod" />
  <section class="content ">
    <div class="box ">
      <div class="box-header with-border">
        <h3 class="box-title">Datos de ranking del usuario </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="categoria_id">Categoría </label>
              <select name="categoria_id" id="categoria_id" class="required form-control">
              <option value="">- seleccione -</option>
                <?php echo $objGral->inputSelectList('categoria','id','nombre',$dato[0]["categoria_id"]); ?>
              </select>
            </div>
            <div class="form-group">
              <label for="modulo_id">Módulo </label>
              <select name="modulo_id" id="modulo_id" class="required form-control">
               <option value="">- seleccione -</option>
               <?php echo $objGral->inputSelectList('modulo','id','nombre',$dato[0]["modulo_id"]); ?>
              </select>
            </div>
            <div class="form-group">
              <label for="tipo_ranking_id">Tipo </label>
              <select name="tipo_ranking_id" id="tipo_ranking_id" class="required form-control">
              <option value="">- seleccione -</option>
                <?php echo $objGral->inputSelectList('tipo_ranking','id','nombre',$dato[0]["tipo_ranking_id"]); ?>
              </select>
            </div>
            <div class="form-group">
              <label for="edad">Edad </label>
              <input  name="edad" id="edad" type="text"  class="required form-control" value="<?php echo $dato[0]['edad'] ?>"/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="mes">Mes </label>
              <select name="mes" id="mes" class=" form-control" >
              <option value="">- seleccione -</option>
                <?php 
for ($m=1; $m<=12; $m++) {
	$selected = ($m==$dato[0]['mes']) ? 'selected="selected"' : "";
	echo '  <option value="' . $m . '" '.$selected.' >' . inc_retorna_mes($m) . '</option>' . PHP_EOL;
}
?>
              </select>
            </div>
            <div class="form-group">
              <label for="anho">Año </label>
              <input  name="anho" id="anho" type="text" class="required form-control" value="<?php echo $dato[0]['anho'] ?>"/>
            </div>
            <div class="form-group">
              <label for="velocidad">Velocidad </label>
              <input  name="velocidad" id="velocidad" type="text"  class=" form-control" value="<?php echo $dato[0]['velocidad'] ?>"/>
            </div>
            <div class="form-group">
              <label for="comprension">Comprensión </label>
              <input  name="comprension" id="comprension" type="text"  class="required form-control" value="<?php echo $dato[0]['comprension'] ?>"/>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>
        <button type="button" onclick="javascript:location.href='page-ranking_modulos-<?php echo $persona_id?>'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>
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
