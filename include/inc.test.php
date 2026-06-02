<script src="./assets/js/jquery.form.js"></script>
<?php 
global $_TEST;
if($tipo!="" and $tipo!="iq" and $categoria=="") { ?>

<div id="test-header">
	<div class="volver"><a href="test" title="volver">volver</a></div>
	<div class="titulo"><i class="corner-left"></i><?php echo $_TEST[$tipo]['nombre_largo']?><i class="corner-right"></i>
	</div>
</div>
<div id="test-contend">
	<div class="titulo">
		<h3>SOY</h3>
		<h4>Elige tu categoría</h4>
	</div>
	<div class="info">
		<ul>
			<li><a href="test-<?php echo $tipo?>-preescolar#start" title="PREESCOLAR" class="nino"><i class="icono "></i><br>
					PREESCOLAR</a></li>
			<li><a href="test-<?php echo $tipo?>-nino#start" title="NIÑO" class="nino"><i class="icono "></i><br>
					NIÑO</a></li>
			<li><a href="test-<?php echo $tipo?>-adolescente#start" title="ADOLESCENTE" class="adolescente"><i
						class="icono "></i><br>
					ADOLESCENTE</a></li>
			<li><a href="test-<?php echo $tipo?>-adulto#start" title="ADULTO" class="adulto"><i class="icono "></i><br>
					ADULTO</a></li>
		</ul>
	</div>
</div>
<?php 
} else if($tipo!="" and $tipo!="iq" and $categoria!="") { 
	//global $_CATEGORIA;
	$objTest = new ClssTest();  
	$categoriaIds = array('adulto' => 1, 'adolescente' => 2, 'nino' => 3, 'preescolar' => 4);
	$categoriaId = isset($categoriaIds[$categoria]) ? $categoriaIds[$categoria] : '';
    $categorias = $objTest -> listarCategoria($categoriaId, $categoriaId == '' ? $categoria : '');
	if(empty($categorias['result'][0])) {
		echo "<h3>AÃºn no hay informaciÃ³n para este Test.</h3>";
		return;
	}
	$NUMERO_DE_PRUEBAS = 99;
?>
<div id="test-header">
	<div class="volver"><a href="test" title="volver">volver</a></div>
	<div class="titulo"><i class="corner-left"></i><?php echo $_TEST[$tipo]['nombre_largo']?><i class="corner-right"></i>
	</div>
</div>
<div id="test-contend">
	<div class="titulo cabecera">
		<h3>SELECCIONA</h3>
		<h4>Haz clic en una prueba</h4>
	</div>
	<div class="info">
		<input type="hidden" name="tipoPersonaNombre" id="tipoPersonaNombre"
			value="<?php echo $categorias['result'][0]['nombre']?>" />
		<input type="hidden" name="tipoPersona" id="tipoPersona" value="" />
		<input type="hidden" name="tipoTest" id="tipoTest" value="<?php echo $_TEST[$tipo]['nombre']?>" />
		<input type="hidden" name="tiempoLectura" id="tiempoLectura" value="00:00" />
		<input type="hidden" name="tiempoRespuestas" id="tiempoRespuestas" value="00:00" />
		<div id="contenido">
			<?php 
	$x = 1;
    $pruebas = $objTest -> listarLectura('',$categorias['result'][0]['id'],$_TEST[$tipo]['subCate-'.$categoria],$NUMERO_DE_PRUEBAS);
	if($pruebas['total'] > 0){
		foreach($pruebas['result'] as $prueba) { 
		?>
				<a href="javascript:void(0)" class="link-test"
					data-name="<?php echo limpiarCadena($categorias['result'][0]['nombre'])?>" data-tipo="<?php echo $tipo?>"
					data-id="<?php echo $prueba['id']?>" title="ir a la PRUEBA"><?php echo $prueba['titulo']?></a>
				<?php 
			$x++; 
		} 
	} else {
		echo "<h3>Aún no hay información para este Test.</h3>";
	}
	?>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	$('a.link-test').each(function(index, element) {
		var btn = $(this);
		btn.bind('click', function() {
			var id = btn.attr("data-id");
			var tipo = btn.attr("data-tipo");
			var name = btn.attr("data-name");
			getContenido(id, tipo, name);
		})
	});
});
</script>
<?php 
} elseif($tipo=="iq") { 
	$objTest = new ClssTestiQ();  
    $tipos = $objTest -> tipo();

	$TESTArr   = $tipos['result'];
//	$TESTArr[] = array('slug'=>'coloreada', 'id'=>1, 'nombre'=>'Test de Raven - Coloreada', 'edadMin'=>5, 'edadMax'=>11);
//	$TESTArr[] = array('slug'=>'general', 'id'=>2, 'nombre'=>'Test de Raven - General', 'edadMin'=>12, 'edadMax'=>65);
//	$TESTArr[] = array('slug'=>'avanzada', 'id'=>3, 'nombre'=>'Test de Raven - Avanzada', 'edadMin'=>12, 'edadMax'=>65);
?>
<div id="test-header">
	<div class="volver"><a href="test-<?php echo $tipo?>" title="volver">volver</a></div>
	<div class="titulo"><i class="corner-left"></i><?php echo $_TEST[$tipo]['nombre_largo']?><i class="corner-right"></i>
	</div>
</div>
<div id="test-contend">
	<?php if($categoria!="") { include('include/inc.test.iq.php'); } else { ?>
	<div class="titulo">
		<h3>SOY</h3>
		<h4>Elige el Test según tu edad</h4>
	</div>
	<div class="info">
		<ul>
			<li><a href="test-<?php echo $tipo?>-<?php echo $TESTArr[0]['slug']?>" title="<?php echo $TESTArr[0]['nombre']?>"
					class="nino"><i class="icono "></i><br>
					Coloreada
					<div style="font-weight:100; font-size:17px; font-family: calibri"><?php echo $TESTArr[0]['edadMin']?> -
						<?php echo $TESTArr[0]['edadMax']?> años</div>
				</a>
			</li>
			<li><a href="test-<?php echo $tipo?>-<?php echo $TESTArr[1]['slug']?>" title="<?php echo $TESTArr[1]['nombre']?>"
					class="adolescente"><i class="icono "></i><br>
					General
					<div style="font-weight:100; font-size:17px; font-family: calibri"><?php echo $TESTArr[1]['edadMin']?> -
						<?php echo $TESTArr[1]['edadMax']?> años</div>
				</a>
			</li>
			<li><a href="test-<?php echo $tipo?>-<?php echo $TESTArr[2]['slug']?>" title="<?php echo $TESTArr[2]['nombre']?>"
					class="adulto"><i class="icono "></i><br>
					Avanzada
					<div style="font-weight:100; font-size:17px; font-family: calibri"><?php echo $TESTArr[2]['edadMin']?> en
						adelante</div>
				</a>
			</li>
	</ul>
	</div>
	<?php } ?>
</div>
<?php } else { ?>
<?php }  ?>
