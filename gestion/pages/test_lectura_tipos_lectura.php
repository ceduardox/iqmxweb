<?php

extract($_REQUEST);

$objeto = new ClssTest();

$cod = (isset($cod)) ? $cod : array();



$codArr = explode("_",$cod); 

$categoria = $codArr[0];

$subcategoria = $codArr[1];

$cod = (isset($codArr[2])) ? $codArr[2]:0;



global $SUBCATEGORIAS;

$dato = array();

$dato["titulo"] = "";

$dato["subtitulo"] = "";

$dato["texto"] = "";

$dato["cantidad_palabras"] = "";



if($cod!="") {

	$arr_getClss = array();

	$arr_getClss = $objeto -> listarLectura($cod,$categoria,$subcategoria,NULL,NULL);

	$dato = $arr_getClss[0];

}



 ?>

<!-- Content Header (Page header) -->

<style>

tbody .num {

    background: #ccc none repeat scroll 0 0;

    font-weight: bold;

    text-align: center;

}

thead tr th {

    background: #016bb8 none repeat scroll 0 0;

    color: #fff;

padding: 4px}

a.add,

a.del{ font-size:0; color:transparent}



a.add::before{ content:"\f055"; color:green}

a.del::before{ content:"\f056"; color:red}



a.add::before,

a.del::before{ font-family:FontAwesome; font-size:25px}



.ocultar{ display:none}

</style>

<section class="content-header">

  <ol class="breadcrumb">

    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>

    <li class="active">Test de Lectura</li>

  </ol>

  <h1><i class="fa fa-book"></i> Test de Lectura <small>Editar lectura</small> </h1>

</section>



<!-- Main content -->

<form method="post" name="form_" id="form_" action="ajax" enctype="multipart/form-data" >

  <input type="hidden" value="guardarLectura" name="accion" />

  <input type="hidden" value="<?php echo $cod ?>" name="cod" />

  <input type="hidden" value="<?php echo $subcategoria ?>" name="subcategoria" />

  <input type="hidden" value="<?php echo $categoria ?>" name="categoria" />

  <section class="content">

    <div class="box ">

      <div class="box-header with-border">

        <h3 class="box-title">Datos de la lectura</h3>

      </div>

      <div class="box-body">

      <?php

$arrCategoria = array();

$arrCategoria = $objeto -> listarCategoria('',NULL,NULL);

$arrSubCategoria = array();

$arrSubCategoria = $objeto -> listarSubCategoria('',$categoria,NULL,NULL);

?>

      <?php if(!in_array($subcategoria,$SUBCATEGORIAS)) { ?>

      <fieldset >

        <div class="ocultar">

        <div class="col-md-6" style="padding-left:0">

          <div class="form-group">

            <label for="categoria_id">Categoría: </label>

            <select name="categoria_id" id="categoria_id"  class="required form-control"  onchange="javascript:getSubcategoria(this.value)">

              <option value="">- Seleccione -</option>

              <?php 

			foreach($arrCategoria as $arrCategoria) { 

				($arrCategoria["id"]==$categoria) ? $selected = 'selected="selected"' : $selected = "";

		?>

              <option value="<?php echo $arrCategoria["id"];?>" <?php echo $selected?> ><?php echo $arrCategoria["nombre"];?></option>

              <?php } ?>

            </select>

          </div></div>

        <div class="col-md-6">

          <div class="form-group">

            <label for="subcategoria_id">Subcategoría: </label>

            <span id="subcategoriaContend">

            <select name="subcategoria_id" id="subcategoria_id"  class=" form-control required" >

              <option value="">- Seleccione -</option>

              <?php 

			foreach($arrSubCategoria as $arrSubcategoria) { 

				($arrSubcategoria["id"]==$subcategoria) ? $selected = 'selected="selected"' : $selected = "";

		?>

              <option value="<?php echo $arrSubcategoria["id"];?>" <?php echo $selected?> ><?php echo $arrSubcategoria["nombre"];?></option>

              <?php } ?>

            </select>

            </span> </div></div>

        </div>

        <div class="form-group">

          <label for="titulo">Título: </label>

          <input type="text" id="titulo" name="titulo" class="required form-control" value="<?php echo $dato["titulo"]?>" style="width:99%"/>

        </div>

        <div class="form-group">

          <label for="subtitulo">Subtítulo: </label>

          <input type="text" id="subtitulo" name="subtitulo"  class=" form-control" value="<?php echo $dato["subtitulo"]?>"  />

        </div>

        <div class="form-group">

          <label for="texto">Lectura: </label>

          <textarea id="texto" name="texto" class="required  form-control" rows="10"  onkeyup="contar_palabras()"><?php echo $dato["texto"]?></textarea>

        </div>

        <div class="form-group">

          <label for="cantidad_palabras">Cantidad de palabras: </label>

          <input type="text" id="cantidad_palabras" name="cantidad_palabras" class="required form-control" style="width:20%" value="<?php echo $dato["cantidad_palabras"]?>" />

        </div>

      </fieldset> 

      <?php } ?></div>

    </div>

    <div class="box ">

      <div class="box-header with-border">

        <h3 class="box-title">Datos de las preguntas y alternativas</h3>

      </div>

       <div class="box-body">

     <fieldset >

        <?php if(in_array($subcategoria,$SUBCATEGORIAS)) { ?>

        <label for="titulo">Nombre: </label>

         <input type="text" id="titulo" name="titulo" class="required form-control" value="<?php echo $dato["titulo"]?>" style="width:40%"/>

        <?php } ?>

        <div class="derecha"><a href="javascript:void(0)" class="verMas" onclick="javascript:addPregunta(<?php echo $cod?>)" title="AGREGAR NUEVA PREGUNTA"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i> AGREGAR NUEVA PREGUNTA</a></div>

        <div class="limpiar">&nbsp;</div>

        <?php

		$arrPreguntas = $objeto -> listarPregunta('',$cod,false);

	  	if(count($arrPreguntas)>0) {

		  $x = 1;

		  foreach($arrPreguntas as $arrPregunta) {

		  ?>

        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableLista" id="tableLista">

          <thead >

            <tr>

              <th colspan="2" scope="col" style="text-align:left"> PREGUNTA NRO. <span class="cuenta"><?php echo $x?></span></th>

              <th width="6%" scope="col">OPCIÓN</th>

            </tr>

          </thead>

          <tbody  >

            <tr>

              <td width="4%" rowspan="2" class="num" ><span class="cuenta"><?php echo $x?></span></td>

              <td class="bbottom"><textarea name="regTextoPregunta[<?php echo $arrPregunta['id']?>]" class="required  form-control" ><?php echo $arrPregunta['texto']?></textarea>

                <div class="contendImg"> &nbsp;Incluir imagen: (ancho:260px alto:270px)

                  <input name="regImgPregunta[<?php echo $arrPregunta['id']?>]" type="file" class=" form-control" />

                  <input name="regImgPregunta_hidden[<?php echo $arrPregunta['id']?>]" type="hidden" value="<?php echo $arrPregunta['imagen']?>" />

                  <?php if($arrPregunta['imagen']!="") { ?>

                  <a href="<?php echo PATH_IMG_TEST.$arrPregunta['imagen']?>" target="_blank" title="ver Imagen" style="padding:3px 7px; text-decoration:none; display:inline-block; background:#666; color:#FFF" >ver Imagen</a>

                  <?php } ?>

                </div></td>

              <td class="text-center bbottom"><a href="javascript:void(0)" class="delPregunta del" title="eliminar pregunta" >ELIMINAR</a>&nbsp;&nbsp;<a href="javascript:void(0)" class="addAlternativa add" title="agregar alternativa" onclick="javascript:addAlternativa(this,<?php echo $arrPregunta['id']?>,'')" >AGREGAR ALTERNATIVAS</a></td>

            </tr>

            <tr>

              <td colspan="2" class="bbottom" id="alternativas"><?php

				$arrAlternativas = $objeto -> listarAlternativas('',$arrPregunta['id'],false);

				if(count($arrAlternativas)>0) {

					?>

                <table width="100%" border="0" cellpadding="0" cellspacing="0"  >

                  <thead >

                    <tr>

                      <th width="6%"  scope="col">CORRECTA</th>

                      <th scope="col">ALTERNATIVAS</th>

                      <th width="6%" scope="col">OPCIÓN</th>

                    </tr>

                  </thead>

                  <tbody  >

                    <?php

					$y = 1;

				  foreach($arrAlternativas as $arrAlternativa) {

					  ($arrAlternativa['correcto']==$y) ? $selected = "checked='checked'" : $selected = "";

				  ?>

                    <tr>

                      <td class="text-center"><b><span class="numAlternativa"><?php echo setNumAlternativa($y); ?></span>. </b>

                        <input type="radio"  class="required " name="regRbAlternativa[<?php echo $arrPregunta['id']?>]" value="<?php echo $y?>" <?php echo $selected?> /></td>

                      <td><textarea name="regTextoAlternativa[<?php echo $arrPregunta['id']?>_<?php echo $arrAlternativa['id']?>]" class="required  form-control" ><?php echo $arrAlternativa['texto']?></textarea></td>

                      <td class="text-center"><a href="javascript:void(0)" class="delAlternativa del" title="eliminar alternativa" >ELIMINAR</a></td>

                    </tr>

                    <?php

					  $y++;

                  }

				  ?>

                  </tbody>

                </table>

                <?php

              }

              ?></td>

            </tr>

          </tbody>

        </table>

        <?php

		  $x++;

		  }

	  }

	  ?>

        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ocultar" id="tableListaPlantilla">

          <thead >

            <tr>

              <th colspan="2" scope="col" style="text-align:left"> PREGUNTA NRO. <span class="cuenta">1</span></th>

              <th width="6%" scope="col">OPCIÓN</th>

            </tr>

          </thead>

          <tbody  >

            <tr>

              <td width="4%" rowspan="2" class="num" ><span class="cuenta">1</span></td>

              <td class="bbottom"><textarea name="textoPregunta[]" class="required  form-control" ></textarea>

                <div class="contendImg"> &nbsp;Incluir imagen: (ancho:260px alto:270px)

                  <input name="ImgPregunta[]" type="file" class=" form-control" />

                  <input name="ImgPregunta_hidden[]" type="hidden" value="" />

                </div></td>

              <td class="text-center bbottom"><a href="javascript:void(0)" class="delPregunta del" title="eliminar pregunta" >ELIMINAR</a>&nbsp;&nbsp;<a href="javascript:void(0)" class="addAlternativa add" title="agregar alternativa" onclick="javascript:addAlternativa(this,0,0)">AGREGAR ALTERNATIVAS</a></td>

            </tr>

            <tr>

              <td colspan="2" class="bbottom" id="alternativas"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >

                  <thead >

                    <tr>

                      <th width="6%"  scope="col">CORRECTA</th>

                      <th scope="col">ALTERNATIVAS</th>

                      <th width="6%" scope="col">OPCIÓN</th>

                    </tr>

                  </thead>

                  <tbody  >

                    <tr>

                      <td class="text-center"><b><span class="numAlternativa">A</span>. </b>

                        <input type="radio" name="rbAlternativa[]" value="" class="required " /></td>

                      <td><textarea name="textoAlternativa[]" class="required form-control" ></textarea></td>

                      <td class="text-center"><a href="javascript:void(0)" class="delAlternativa del" title="eliminar alternativa" >ELIMINAR</a></td>

                    </tr>

                  </tbody>

                </table></td>

            </tr>

          </tbody>

        </table>

        <div id="contendPreguntas"></div>

      </fieldset>

    </div>

    <div class="box-footer">

      <button type="submit" class="btn btn-primary" id="guardar" name="guardar" >Guardar</button>

      <button type="button" onclick="javascript:location.href='page-test_lectura_tipos_lecturas-<?php echo $categoria?>_<?php echo $subcategoria?>'"  class="btn btn-default" id="btn-cancelar" name="cancelar"  >Volver</button>

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

		delPregunta();

		delAlternativa();

    });



function getSubcategoria(categoria){

	$("#subcategoriaContend").html('carganbo...');

	$("#subcategoriaContend").load( "principal.php?app=lectura&accion=edit_lectura&categoria="+categoria+" #subcategoria_id", function() {});

} 	



function contar_palabras(){

	var formcontent = trim($('#texto').val());

	var tokens      = formcontent.split(" ");

	$('#cantidad_palabras').val(tokens.length);

}



function addPregunta(lectura) {

	var cuentaPreguntas           = $(".tableLista").length;

	var cuentaPreguntasEliminadas = $(".tableLista.ocultar").length;

 

	var contendPreguntas = $("#tableListaPlantilla").clone().appendTo("#contendPreguntas");

	contendPreguntas.attr('id','tableLista');

	contendPreguntas.addClass('tableLista');

	contendPreguntas.find('.cuenta').html((cuentaPreguntas-cuentaPreguntasEliminadas)+1);

	contendPreguntas.removeClass('ocultar')

	var alternativas = contendPreguntas.find('#alternativas');



	var myrand=parseInt(Math.random()*99999999);

	contendPreguntas.find('textarea[name="textoPregunta[]"]').attr('name','textoPregunta['+myrand+']');

	contendPreguntas.find('textarea[name="textoPregunta['+myrand+']"]').attr('id',myrand);

	

	contendPreguntas.find('input[type="file"]').attr('name','ImgPregunta['+myrand+']');

	contendPreguntas.find('input[name="ImgPregunta_hidden[]"]').attr('name','ImgPregunta_hidden['+myrand+']');

	



	alternativas.html('')

	

	delPregunta();

}



function delPregunta() {

	$('a.delPregunta').each(function() {

        $(this).bind('click', function() {

			$(this).parent().parent().parent().parent().addClass('ocultar');

			$(this).parent().parent().parent().parent().find('textarea').html("");

			$(this).parent().parent().parent().parent().find('textarea').val("");

			contarPreguntas();

			$("#form_").validate();

		});

    });

}



function contarPreguntas() {

	var i = 1;

 	$("table.tableLista").each(function(){

		if(!$(this).hasClass('ocultar')) {

			$(this).find('.cuenta').html(i);

			i++;

		} 

	});

}



function addAlternativa(obj,pregunta,parm){

 	var permitidos   = 5;

	var objAlt       = $(obj).parent().parent().parent().parent().find('#alternativas');

	var cuentaAlt    = objAlt.find('table').length;

	var contarobjAlt = objAlt.find('tbody').find('tr').length;

	var contarobjAltN= objAlt.find('tbody').find('tr.ocultar').length;

	

	if((contarobjAlt-contarobjAltN)<permitidos) {

		var celAlt;

		if(cuentaAlt==0) {

			celAlt = objAlt.append($("#tableListaPlantilla").find('#alternativas').html());

		} else {

			celAlt = objAlt.find('tbody').append($("#tableListaPlantilla").find('#alternativas').find('tbody').html());

		}



		delAlternativa(celAlt);

				

		var myrand=parseInt(Math.random()*99999999);

		

		if(pregunta>0 && parm=="") {

			var addRand = 1;

			celAlt.find('input[type="radio"]').each(function(){

				$(this).attr('name','regRbAlternativa['+pregunta+']');

				addRand++;

			}); 



			var addRand = 1;

			celAlt.find('textarea').each(function(){

				if($(this).attr('name').split('_').length==1) {

					$(this).attr('name','regTextoAlternativa['+pregunta+'_0_'+(myrand+addRand)+']')

					addRand++;

				}

			}); 

		} 

		

 		if(parm=="0") {

			myrand=$(obj).parent().parent().parent().parent().find('textarea').attr('id');

			

			var addRand = 1;

			celAlt.find('input[type="radio"]').each(function(){

				$(this).attr('name','rbAlternativa['+myrand+']');

				addRand++;

 			}); 



			var addRand = 1;

			celAlt.find('textarea').each(function(){

				$(this).attr('name','textoAlternativa['+myrand+'_'+(myrand+addRand)+']')

				addRand++;

			}); 

		}

		

		contarAlternativas(celAlt);

		$("#form_").validate();

	} else { alert("Sólo puede registrar hasta "+permitidos+" alternativas por pregunta.\nElimine una y vuelva a crear."); return; }

}





function delAlternativa(celAlt) {

	celAlt = celAlt || "";

	if(celAlt!="") {

		celAlt.find('a.delAlternativa').each(function(){

			$(this).bind('click',function(){

				$(this).parent().parent().addClass('ocultar')

				$(this).parent().parent().find('textarea').html("");

				$(this).parent().parent().find('textarea').val("");

				contarAlternativas(celAlt);

			})

		}); 

	} else {

		$('a.delAlternativa').each(function(){

			$(this).bind('click',function(){

				$(this).parent().parent().addClass('ocultar')

				$(this).parent().parent().find('textarea').html("");

				$(this).parent().parent().find('textarea').val("");

				contarAlternativas($(this).parent().parent().parent());

			})

		}); 

	}

	$("#form_").validate();

}



function setNumAlternativa(num) {

	var alpha = Array('A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');

	return alpha[num-1];

}



function contarAlternativas(celAlt) {

	var i = 1;

 	celAlt.find('.numAlternativa').each(function(){

		if(!$(this).parent().parent().parent().hasClass('ocultar')) {

			$(this).html(setNumAlternativa(i));

			i++;

		}

	}); 

	contarRBAlternativa(celAlt);

	$("#form_").validate();

}



function contarRBAlternativa(celAlt){

	var cuentaRb = 1;

	celAlt.find('input[type="radio"]').each(function(){

		if(!$(this).parent().parent().hasClass('ocultar')) {

			$(this).attr('value',cuentaRb);

			cuentaRb++;

		}

	}); 

}



</script> 

