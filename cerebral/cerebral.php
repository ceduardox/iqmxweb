<script src="cerebral/js/libs/base64.min.js"></script>
<link href="cerebral/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="cerebral/css/min.css">
<div class="container">
	<div class="row">
		<div role="main" id="wrapper">
			<div class="test" id="intro">
				<div id='test-header'>
					<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
				</div>
				<br>
				<br>
				<span class="headall">¿Qué lado de su cerebro es más dominante?</span><br />
				<span class="headall head45">Test Cerebral en 30 segundos</span>
				<div class="row">
					<div class="col-md-6 col-md-offset-3"> <img class="brain img-responsive center-block" alt="cerebro"
							src="cerebral/img/brain_es.png" /> </div>
				</div>
				<div class="row">
					<div class=" " style="vertical-align:top;margin-bottom:30px;"> <a href="javascript:void(0)"
							class=" button link-test">Comenzar</a> </div>
				</div>
			</div>
			<div class="test taenzerin" id="test01">
				<div id='test-header'>
					<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
				</div>
				<br>
				<br>
				<span class="headall">¿En qué dirección gira la bailarina?<br>
					<br>
				</span>
				<div class="row">
					<div class=" "> <img class="img-responsive center-block" alt="dancer" src="cerebral/img/taenzerin.gif"
							style="padding: 10px 10px 10px 10px;border-style: solid;border-width: 1px;border-color:#CACACA;width:40%;">
						<div class="taenzerin-copyright" style="margin-top:10px;">
							<p>Nobuyuki Kayahara ©</p>
						</div>
					</div>
				</div>
				<div class="row answers">
					<div class="col-md-6 text-right"> <a href="javascript:void(0)" type="button" class="btn btn-warning btn-lg"><i
								class="fa fa-3x fa-undo answer left" alt="Circle" src="cerebral/img/circle_left.png" data-pointsleft="4"
								data-pointsright="0" data-name="res_taenzerin"></i></a> </div>
					<div class="col-md-6 text-left"> <a href="javascript:void(0)" type="button" class="btn btn-warning btn-lg"><i
								class="fa fa-3x fa-repeat answer right" alt="Circle" src="cerebral/img/circle_right.png"
								data-pointsleft="0" data-pointsright="4" data-name="res_taenzerin"></i></a> </div>
				</div>
				<br />
				<br />
			</div>
			<div class="test farben" id="test02">
				<div id='test-header'>
					<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
				</div>
				<br>
				<br>
				<div class="headall">Escoja el color, no la palabra. <br>
					Tiene 4 segundos para cada tarea.</div>
				<div class="mbot20 mtop20"> <a href="javascript:void(0)" class="button link-test ">Comenzar</a>
					<p class="vorgabe"></p>
				</div>
				<div class="counter mtop20">
					<div class="bar">
						<div class="inner"></div>
					</div>
					<p class="number">4</p>
				</div>
				<div class="row mbot20">
					<div class="answers">
						<div class="col-md-5 text-center"> <a href="javascript:void(0)"
								class="btn btn-default btn-lg answer left farbe" data-pointsleft="0" data-pointsright="0"
								data-name="res_farben"></a> </div>
						<div class="col-md-5 text-center"> <a href="javascript:void(0)"
								class="btn btn-default btn-lg answer right farbe" data-pointsleft="0" data-pointsright="0"
								data-name="res_farben"></a> </div>
					</div>
				</div>
			</div>
			<div class="test figuren" id="test03">
				<div class="row">
					<div id='test-header'>
						<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
					</div>
					<br>
					<br>
					<div class="headall"> De los siguientes dibujos, ¿cuál le atrae más? </div>
					<div class="row answers_images mtop50">
						<div class="col-md-4"> <img class="answer figur img figur01 img-responsive img-thumbnail" alt="Figur"
								src="cerebral/img/figur01.png" data-pointsleft="4" data-pointsright="0" data-name="res_figuren" /><br>
						</div>
						<div class="col-md-4"> <img class="answer figur img figur02 img-responsive img-thumbnail" alt="Figur"
								src="cerebral/img/figur02.png" data-pointsleft="2" data-pointsright="2" data-name="res_figuren" /><br>
						</div>
						<div class="col-md-4"> <img class="answer figur img figur03 img-responsive img-thumbnail" alt="Figur"
								src="cerebral/img/figur03.png" data-pointsleft="0" data-pointsright="4" data-name="res_figuren" /><br>
						</div>
					</div>
				</div>
			</div>
			<div class="test passen" id="test04">
				<div class="row">
					<div id='test-header'>
						<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
					</div>
					<br>
					<br>
					<img class="mtop20" alt="similaridad" src="cerebral/img/passen_vorgabe.png"
						style="width: auto; margin: 0px auto;" />
					<div class="headall" style="margin-top:0px;">Este dibujo es más parecido a</div>
					<div class="row answers_images mtop20">
						<div class="col-md-4"> <img class="answer passen img passen01 img-responsive img-thumbnail" alt="Passen"
								src="cerebral/img/passen01.png" data-pointsleft="0" data-pointsright="4" data-name="res_passtzu" /><br>
						</div>
						<div class="col-md-4"> <img class="answer passen img passen02 img-responsive img-thumbnail" alt="Passen"
								src="cerebral/img/passen02.png" data-pointsleft="4" data-pointsright="0" data-name="res_passtzu" /><br>
						</div>
						<div class="col-md-4"> <img class="answer passen img passen03 img-responsive img-thumbnail" alt="Passen"
								src="cerebral/img/passen03.png" data-pointsleft="0" data-pointsright="4" data-name="res_passtzu" /><br>
						</div>
					</div>
				</div>
			</div>
			<div class="test freundschaft" id="test05">
				<div class="row">
					<div id='test-header'>
						<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
					</div>
					<br>
					<br>
					<div class="headall"> De los siguientes dibujos, ¿cuál define mejor la amistad? </div>
					<div class="row answers_images mtop20">
						<div class="col-md-4"> <img class="answer freundschaft img freundschaft01 img-responsive img-thumbnail"
								alt="Freundschaft" src="cerebral/img/freundschaft01.png" data-pointsleft="4" data-pointsright="0"
								data-name="res_freundschaft" /><br>
						</div>
						<div class="col-md-4"> <img class="answer freundschaft img freundschaft02 img-responsive img-thumbnail"
								alt="Freundschaft" src="cerebral/img/freundschaft02.png" data-pointsleft="2" data-pointsright="2"
								data-name="res_freundschaft" /><br>
						</div>
						<div class="col-md-4"> <img class="answer freundschaft img freundschaft03 img-responsive img-thumbnail"
								alt="Freundschaft" src="cerebral/img/freundschaft03.png" data-pointsleft="0" data-pointsright="4"
								data-name="res_freundschaft" /><br>
						</div>
					</div>
				</div>
			</div>
			<div class="test kopf" id="test06">
				<div id='test-header'>
					<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
				</div>
				<br>
				<br>
				<div class="headall"> Coloque una mano sobre su cabeza. </div>
				<div class="headall head45" style="margin-top:10px;"> ¿Qué mano ha utilizado? </div>
				<div class="answers text mtop50 mbot20">
					<div class="row flex">
						<div class="col-md-5 text-right"> <a href="javascript:void(0)" class="btn btn-default btn-lg answer  text"
								data-pointsleft="0" data-pointsright="3" data-name="res_kopf">izquierda</a> </div>
						<div class="col-md-5 text-left"> <a href="javascript:void(0)" class="btn btn-default btn-lg answer  text"
								data-pointsleft="3" data-pointsright="0" data-name="res_kopf">derecha</a> </div>
					</div>
				</div>
			</div>
			<div class="test arme" id="test07">
				<div id='test-header'>
					<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
				</div>
				<br>
				<br>
				<div class="headall"> Cruce los brazos sobre el pecho. </div>
				<div class="headall head45" style="margin-top:10px;"> ¿Qué mano está situada encima? </div>
				<div class="answers text mtop50 mbot20">
					<div class="row flex">
						<div class="col-md-5  text-right"> <a href="javascript:void(0)" class="btn btn-default btn-lg answer  text"
								data-pointsleft="0" data-pointsright="3" data-name="res_arme">izquierda</a> </div>
						<div class="col-md-5 text-left"> <a href="javascript:void(0)" class="btn btn-default btn-lg answer  text"
								data-pointsleft="3" data-pointsright="0" data-name="res_arme">derecha</a> </div>
					</div>
				</div>
			</div>
			<div class="test beine" id="test08">
				<div id='test-header'>
					<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
				</div>
				<br>
				<br>
				<div class="headall"> Cruce las piernas. </div>
				<div class="headall head45" style="margin-top:10px;"> ¿Qué pierna está situada encima? </div>
				<div class="answers text mbot20">
					<div class="row flex">
						<div class="col-md-5  text-right"> <a href="javascript:void(0)" class="btn btn-default btn-lg answer  text"
								data-pointsleft="0" data-pointsright="3" data-name="res_beine">izquierda</a> </div>
						<div class="col-md-5 text-left"> <a href="javascript:void(0)" class="btn btn-default btn-lg answer  text"
								data-pointsleft="3" data-pointsright="0" data-name="res_beine">derecha</a> </div>
					</div>
				</div>
			</div>
			<div class="test auge" id="test09">
				<div id='test-header'>
					<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
				</div>
				<br>
				<br>
				<div class="headall"> Mire fijamente un objeto y cierre un ojo. </div>
				<div class="headall head45" style="margin-top:10px;"> ¿Qué ojo tiene abierto? </div>
				<div class="answers text mbot20">
					<div class="row flex">
						<div class="col-md-5 text-right"> <a href="javascript:void(0)" class="btn btn-default btn-lg answer  text"
								data-pointsleft="0" data-pointsright="3" data-name="res_auge">izquierda</a> </div>
						<div class="col-md-5 text-left"> <a href="javascript:void(0)" class="btn btn-default btn-lg answer  text"
								data-pointsleft="3" data-pointsright="0" data-name="res_auge">derecha</a> </div>
					</div>
				</div>
			</div>
			<div class="test result" id="result">
				<div id='test-header'>
					<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
				</div>
				<br>
				<br>
				<div class="contenido"> <span class="texto">Para que puedas conocer tu resultado del Test, completa los
						siguientes datos con información real ya que el resultado se mostrara en pantalla y se enviará a la bandeja
						de entrada del EMAIL que haz colocado en los campos correspondientes: <br />
					</span>
					<div class='container' style='padding: 0px'>
						<div class='row' style="margin-right: -15px!important; margin-left: -15px!important;">
							<div class='form col-md-12'>
								<form name="formTestx" id="formTestx" method="post" action="include/ajax" class="row g-3">
									<div class="col-md-6">
										<label class="form-label" for="nombreTest">NOMBRE:</label>
										<input name="nombreTest" type="text" id="nombreTest" class="required form-control" />
									</div>
									<div class="col-md-6">
										<label class="form-label" for="emailTest">EMAIL:</label>
										<input name="emailTest" type="text" id="emailTest" class="required email form-control" value="" />
									</div>

									<div class="col-md-6">
										<div class="row">
											<div class="col-md-4" style='padding-left: 0px'>
												<label class="form-label" for='edadTest'>EDAD:</label>
												<input name='edadTest' type='text' id='edadTest' class='required form-control' />
											</div>
											<div class="col-md-8" style='padding-left: 0px; padding-right: 0px;'>
												<label class="form-label" for='fonoTest'>TELÉFONO:</label>
												<input name='fonoTest' type='text' id='fonoTest' class='required form-control' />
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<label class="form-label" for="ciudadTest">CIUDAD:</label>
										<input name="ciudadTest" type="text" id="ciudadTest" class="required form-control" />
									</div>

									<div class="col-md-12">
										<label class="form-label" for="comentarioTest">COMENTARIO:</label>
										<textarea name="comentarioTest" id="comentarioTest" rows="3" onpaste="return false"
											class="form-control"></textarea>
									</div>
									<input type="hidden" name="tipo" value="cerebro" />
									<input type="hidden" name="izquierdo" id="izquierdo" value="0" />
									<input type="hidden" name="derecho" id="derecho" value="0" />
									<input type="hidden" name="txtResultado" id="txtResultado" value="" />
									<div class="retorno"></div>
									<div class="botonera">
										<input type="submit" value="Ver puntaje" name="puntaje" class="puntaje" />
										<input type="reset" id="limpiar" name="limpiar" value="Limpiar" class="puntaje">
										<br />
										<br />
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--RESULTADO-->

			<div class="test result" id="resultado" style="text-align:center">
				<div id='test-header'>
					<div class="titulo"><i class="corner-left"></i>TEST CEREBRAL<i class="corner-right"></i></div>
				</div>
				<div id="result_head" class="headall mtop10" style="margin-top:5px;">Felicidades</div>
				<div class="row mtop20">
					<div class="col-md-3 mtop50 izqBrain">
						<div class="hidden-xsx hidden-smxx" style="position: relative;">
							<p style="left: 20px;top: 20px;font-size:26px;position: absolute;" class="keyword left regeln"> reglas
							</p>
							<p style="left: -50px;top: 60px;font-size: 22px;" class="keyword left sprache"> idioma </p>
							<p style="left:-10px;top:100px;font-size:30px;" class="keyword left strategie"> estrategia </p>
							<p style="left:0px;top:230px;font-size:18px" class="keyword left details"> detalles </p>
							<p style="left: -15px;top: 150px;font-size: 32px;" class="keyword left rationalitaet"> racionalidad </p>
							<p style="left: -10px;top: 205px;font-size:30px;" class="keyword left logik"> lógica </p>
						</div>
					</div>
					<div class="col-md-6" style="padding:0px;">
						<div class="row" style="position:relative;margin:0px;overflow:hidden;"> <img id="brain" alt="Gehirn"
								src="cerebral/img/brain_result.png" style="max-width: 100%; height: auto;">
							<div class="col-md-6 text-right"
								style="padding:0;padding-left:1px;position:absolute;left:0;bottom:20px;z-index:0" id="left_bar">
								<p class="leftresult_text resulttext"></p>
								<img src="cerebral/img/result_left_bar_xl.png" style="max-width: 100%; height: auto;">
							</div>
							<div class="col-md-6 text-left"
								style="padding:0;padding-right:1px;position:absolute;right:0;bottom:20px;z-index:0" id="right_bar">
								<p class="rightresult_text resulttext"></p>
								<img src="cerebral/img/result_right_bar_xl.png" style="max-width: 100%; height: auto;">
							</div>
						</div>
					</div>
					<div class="col-md-3 mtop50 derBrain">
						<div class="hidden-xsx hidden-smx" style="position: relative;">
							<p style="right: 10px;top: 30px;font-size: 18px;" class="keyword right bilder">imágenes</p>
							<p style="right: 2px;top: 57px;font-size:28px;" class="keyword right chaos">caos</p>
							<p style="right:-30px;top: 100px;font-size: 32px;" class="keyword right kreativitaet">creatividad</p>
							<p style="right:-20px;top:170px;font-size:40px;" class="keyword right intuition">intuición</p>
							<p style="right: 10px;top:132px;font-size:16px" class="keyword right fantasie">fantasía</p>
							<p style="right: 40px;top: 205px;font-size:20px;" class="keyword right neugierde">curiosidad</p>
						</div>
					</div>
				</div>
				<div id="schoko_result" class="row" style="display:none;">
					<div class="col-md-12 text-center"> <span id="schoko_result_text" class="headall mtop10">Felicidades</span>
					</div>
				</div>

				<!--RESULTADO-->

			</div>
			<div class="row">
				<div class="col-md-12 text-center"> <a class="call button btn btn-lg" href="cerebral.php" id="landing_test"
						style=""> ¿Cuál es su hemisferio cerebral predominante? ¿Derecho o izquierdo? ¡Haga el test! </a> </div>
			</div>
		</div>
	</div>
</div>
<script src="cerebral/js/brain.js"></script>
<script type="text/javascript" src="assets/js/cronometro.js"></script>
<script type="text/javascript">
	$(function () {

		$("#nombreTest").val($.cookie("cookie-nombreTest"));
		$("#edadTest").val($.cookie("cookie-edadTest"));
		$("#emailTest").val($.cookie("cookie-emailTest"));
		$("#fonoTest").val($.cookie("cookie-fonoTest"));
		$("#ciudadTest").val($.cookie("cookie-ciudadTest"));

		$('#btn-info-text').click(function () {
			$('#info-text').toggle('slow');
		});

		$('#test .container a.btn').each(function () {
			$(this).bind('click', function () {
				alert("1")
				//$(this).attr('href',"#test");
			})
		})

		$('#test .answers_images img').each(function () {
			$(this).bind('click', function () {
				//document.location.href="#test";
			})
		})
	});


	url = '<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/test-cerebral' ?>'
</script>