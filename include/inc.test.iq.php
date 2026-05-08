<?php
$categoria = (isset($categoria)) ? $categoria : 'coloreada';
//$testArr   = array_column($TESTArr, 'slug');
//$key       = array_search($categoria, $testArr);
$objTest = new ClssTestiQ();  
$tipos = $objTest -> tipo('',$categoria);

$TESTArr   = $tipos['result'][0];
$tipoTest  = $TESTArr['id'];
?>
<form name="formiq" id="formiq" method="post" action="include/ajax" enctype="multipart/form-data">
	<input type="hidden" name="tipo" id="tipo" value="testiq" />
	<input type="hidden" name="tipoTest" id="tipoTest" value="<?php echo $tipoTest?>" />
	<div id="contend-rspta" style="display:none"></div>
	<div id="contend-edad">
		<div class="titulo">
			<h2>Bienvenido</h2>
			<h3><?php echo $TESTArr['nombre'];?></h3>
			<h4>Por favor ingresa tu edad ya que es importante para calcular los resultados. </h4>
		</div>
		<div class="info">
			<div class="col-md-4 offset-md-4">
			<input type="number" class="form-control " name="edad" id="edad" placeholder="ingresa tu edad aquí"
				min="<?php echo $TESTArr['edadMin']?>" max="<?php echo $TESTArr['edadMax']?>" />
				</div>	<br/><br/><p> A continuación se te mostrarán distintas placas, <br />
				tendrás que decidir cuál es la figura que completa a cada una. </p>
			<p> El test consta de diversas placas, te recomendamos que lo hagas con tiempo. </p>
			<p> Al finalizar obtendrás tu coeficiente intelectual en base a los valores estadísticos para tu edad. <br/><br/></p>
			<div id="contend-btn-star" class="botonera">
				<button id="btn-star" name="btn-star" type="button">Comenzar <i class="fa fa-arrow-right"
						aria-hidden="true"></i></button><br/><br/>
			</div></div>
	</div>
	<?php 
$objTest = new ClssTestiQ();  
$series = $objTest -> serie('',$tipoTest);
$x = 1;
foreach($series['result'] as $serie) { 
?>
	<div id="serie-<?php echo $serie['id']?>" class="contend-series" style="display:none">
		<div class="titulo">
			<h3><?php echo $serie['nombre']?></h3>
			<h4>Marca la alternativa que consideres correcta</h4>
		</div>
		<div class="info">
			<?php 
  	$j = 1;
    $preguntas = $objTest -> pregunta('', $serie['id']);
    foreach($preguntas['result'] as $pregunta) { 
    ?>
			<div id="pregunta-<?php echo $pregunta['id']?>" class="contend-preguntas"
				<?php if($j!=1) { echo 'style="display:none"'; } ?>>
				<div class="contend-preguntas-head">
					<h2><?php echo $pregunta['nombre']?></h2>
					<div class="text-center">
						<?php echo imagen(PATH_TESTIQ,$pregunta['file'],'auto','img/testiq/noImageTestPreg.jpg','text-center')?>

					</div>
				</div>
				<div class="contend-alternativas">
					<?php 
		$i=1;
        $alternativas = $objTest -> alternativa('', $pregunta['id']);
        foreach($alternativas['result'] as $alternativa) { 
        ?>
					<span class="contend-item alternativa-<?php echo $i?>">
						<label for="alternativa-<?php echo $alternativa['id']?>">
							<input type="radio" id="alternativa-<?php echo $alternativa['id']?>"
								name="alternativa[<?php echo $pregunta['id']?>]"
								value="<?php echo $i?>|<?php echo $alternativa['id']?>|<?php echo sha1(md5($alternativa['verdader']))?>|<?php echo $serie['id']?>" />
							<span class="text-mini"><?php echo $alternativa['nombre']?>)</span>
							<?php echo imagen(PATH_TESTIQ,$alternativa['file'],'auto','img/testiq/noImageTest.jpg','text-center')?></label>
					</span>
					<?php 
		$i++;
        } 
        ?>
				</div>
			</div>
			<?php 
		$j++;
    } 
    ?>
		</div>
	</div>
	<?php 
$x++;
} 
?><br/><br/>
	<div id="contend-btn-siguiente" class="botonera" style="display:none">
		<button id="btn-siguiente" name="btn-siguiente" type="button" disabled="disabled">Siguiente <i
				class="fa fa-arrow-right" aria-hidden="true"></i></button>
	</div><br/><br/>
	<div id="contend-load"></div>
</form>
<script>
$(function() {

	$('button#btn-star').bind('click', function() {
		var edad = $('#contend-edad').find('input#edad');
		if (edad.val() != "") {
			if (edad.val() >= parseInt(edad.attr('min')) && edad.val() <= parseInt(edad.attr('max'))) {
				$('#contend-edad').fadeOut(100, function() {
					$('.contend-series:eq(0)').fadeIn(100, function() {
						$('#contend-btn-siguiente').fadeIn(100, function() {
							$('#contend-load').html("");
						});
					});
				});
			} else {
				$('#contend-load').fadeIn(100, function() {
					$(this).html("<p class='error'>La edad debe ser mayor a " + edad.attr('min') + " y menor que " +
						edad.attr('max') + " años.</p>");
					edad.focus();
				});
			}
		} else {
			$('#contend-load').fadeIn(100, function() {
				$(this).html("<p class='error'>Para empezar el Test debes completar tu edad.</p>");
				edad.focus();
			});
		}
	});

	$('button#btn-siguiente').bind('click', function() {
		var btn = $(this);
		var ctaSeriesTotal = $('.contend-series').length;
		var ctaPreguntasTotal = $('.contend-series').find('.contend-preguntas').length;

		var idxSerie = parseInt(btn.attr('data-serie'));
		var idxPregunta = parseInt(btn.attr('data-pregunta'));

		var contendSeries = $('.contend-series').eq(idxSerie);
		var idPregunta = contendSeries.find('.contend-preguntas').eq(idxPregunta).attr('id');
		var idPreguntaNext = contendSeries.find('.contend-preguntas').eq(idxPregunta + 1).attr('id');

		if (idxSerie <= ctaSeriesTotal - 1 && idxPregunta <= 35) { //total de preguntas
			if (idxSerie > 0) {
				var serieCurrent = $('.contend-series').eq(idxSerie - 1).attr('id');
				var serieNext = $('.contend-series').eq(idxSerie).attr('id');

				$('#' + serieCurrent + '.contend-series').fadeOut(100, function() {
					$('#' + serieNext + '.contend-series').fadeIn(100);
				});
			}

			contendSeries.find('#' + idPregunta + '.contend-preguntas').fadeOut(100, function() {
				$('button#btn-siguiente').attr('disabled', 'disabled');
				$('html, body').animate({
					scrollTop: $('#test-container').offset().top
				}, 800);
				contendSeries.find('#' + idPreguntaNext + '.contend-preguntas').fadeIn(100);
			});
		} else {
			//calcular resultado 
			enviarRespuestaTest();
		}
	});

	$('.contend-series').each(function(idxContendSerie, element) {
		var serie = $(this);
		var ctaPreguntas = serie.find('.contend-preguntas').length;
		serie.find('.contend-preguntas').each(function(idxContendPregunta, element) {
			var preguntas = $(this);
			preguntas.find('.contend-alternativas').each(function(idxContendAlternativa, element) {
				var alternativas = $(this);
				alternativas.find('span.contend-item').each(function(idxContendItem, element) {
					var item = $(this);
					var label = item.find('label');

					label.find("input:radio").change(function() {
						if ($(this).is(':checked')) {
							alternativas.find('label').removeClass('active');
							label.addClass('active');
							$('button#btn-siguiente').removeAttr('disabled');

							if (idxContendPregunta < ctaPreguntas - 1) {
								$('button#btn-siguiente').attr('data-serie', idxContendSerie);
								$('button#btn-siguiente').attr('data-pregunta', idxContendPregunta);
							} else {
								$('button#btn-siguiente').attr('data-serie', idxContendSerie + 1);
								$('button#btn-siguiente').attr('data-pregunta', idxContendPregunta + 1);
							}
						}
					})
				});
			});
		});
	});
});

function enviarRespuestaTest() {
	$('.contend-series').fadeOut(100, function() {
		$('#contend-rspta').fadeIn(100, function() {
			$(this).html("cargando resultado...");
			var options = {
				success: showResponse
			};
			$('form#formiq').ajaxSubmit(options);
		});
	});
}

function showResponse(responseText, statusText, xhr, $form) {
	var contendLoad = $('#contend-rspta');
	if (statusText == 'success') {
		var objData = JSON.parse(responseText);
		contendLoad.html(objData['mensaje']);
		if (objData['estado'] == 0) {
			contendLoad.html("Lo sentimos ha ocurrido un error. Vuelve a intentarlo.");
		}
	} else {
		contendLoad.html("Lo sentimos ha ocurrido un error al intentar enviar el Test. Vuelve a intentarlo.");
	}

	$('button#btn-siguiente').remove();
	$('.contend-series').remove();
}
</script>