<section class="ranking-resultados">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<a id="resultados" name="resultados"></a>
				<h1>Los mejores resultados <strong>del mes de <?php echo getMes($mes,'nombre') ?> del
						<?php echo $ANHO?>
					</strong></h1>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-12 col-md-3">
				<select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="selecMes"
					id="selecMes">
					<?php 
for ($m=1; $m<=12; $m++) {
	$selected = ($m==$mes) ? 'selected="selected"' : "";
	echo '  <option value="' . $m . '" '.$selected.' >' . getMes($m) . '</option>' . PHP_EOL;
}
?>
				</select>
			</div>
			<div class="col-12 col-md-3">
				<select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="selecAnho"
					id="selecAnho">
					<?php 
for ($m=2014; $m<=date('Y'); $m++) {
	$selected = ($m==$ANHO) ? 'selected="selected"' : "";
	echo '  <option value="' . $m . '" '.$selected.' >' . $m . '</option>' . PHP_EOL;
}
?>
				</select>
			</div>
			<div class="col-12 col-md-2">
				<a href="javascript:void(0)" id="btnVer" class="btnVer btn btn-blue" title="VER">VER</a>
			</div>
		</div>


		<div class="row">
			<div class="destacados pages-olimpiadas col-md-6">
				<div class="titulo">OLIMPIADAS PRESENCIALES</div>
				<?php 
		$tipoTop = 'top3';
		$tipoRanking = 1; //BD-OLIMPIADAS PRESENCIALES
  include( 'parts/ranking/inc.ranking.php' ); 
		?>
			</div>
			<div class="destacados pages-olimpiadas col-md-6">
				<div class="titulo">OLIMPIADAS VIRTUALES</div>
				<?php 
		$tipoTop = 'top3';
		$tipoRanking = 2; //BD-OLIMPIADAS VIRTUA
		include( 'parts/ranking/inc.ranking.php' ); 
		?>
			</div>
		</div>
	</div>
	</div>
</section>
<script>
$(function() {
	$('a#btnVer').bind('click', function() {
		var selecMes = $('#selecMes').val();
		var selecAnho = $('#selecAnho').val();
		location.href = 'ranking?mes=' + selecMes + '&anho=' + selecAnho + '#resultados';
	})
});
</script>