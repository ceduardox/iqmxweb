function getContenido(lectura, tipoTest, tipoPersona) {
  $('#tipoPersona').val(tipoPersona);
  $('#test-contend .titulo h3').css('display', 'none');
  if (tipoTest == 'lectura') {
    $.get('include/lectura-test', { tipo: 'test', tipoPersona: tipoPersona, tipoTest: tipoTest, lecturaIDCitex: lectura, tipoMuestra: 'lectura' }, function (data) {
      $('#test-contend #contenido').html(data);
      $('#test-contend #contenido')
        .find('a.cuestionario')
        .bind('click', function () {
          getCuestionario(lectura, tipoTest, tipoPersona);
        });

      $('#test-contend .titulo.cabecera').prepend('<div class="mensaje estado"><span id="tipo-persona"></span><span class="separaVertical"></span><span id="display">00:00</span></div>');

      IniciarCrono('tiempoLectura');
    });
  } else if (tipoTest == 'razonamiento') {
    $('#test-container #test-body #test-contend .titulo h4').html('selecciona la respuesta correcta');
    $.get('include/razonamiento-test', { tipo: 'test', tipoPersona: tipoPersona, tipoTest: tipoTest, lecturaIDCitex: lectura, tipoMuestra: 'preguntas' }, function (data) {
      $('#test-contend #contenido').html(data);
      $('#test-contend .titulo.cabecera').prepend('<div class="mensaje estado"><span id="tipo-persona"></span><span class="separaVertical"></span><span id="display">00:00</span></div>');
      IniciarCrono('tiempoRespuestas');
      setRespuesta();
      $('#test-contend #contenido')
        .find('.puntaje')
        .bind('click', function () {
          setPuntaje();
        });
    });
  }
}

function getCuestionario(lectura, categoria, subcategoria) {
  DetenerCrono();
  var tipoPersona = $('input#tipoPersona').val();
  var tipoTest = $('input#tipoTest').val();
  $('#test-contend .titulo.cabecera .mensaje.estado').remove();
  $.get(
    'include/lectura-test',
    { categoria: categoria, subcategoria: subcategoria, tipo: 'test', tipoPersona: tipoPersona, lecturaIDCitex: lectura, tipoTest: tipoTest, tipoMuestra: 'preguntas' },
    function (data) {
      $('#test-contend #contenido').html(data);
      $('#test-contend .titulo.cabecera').prepend('<div class="mensaje estado"><span id="tipo-persona"></span><span class="separaVertical"></span><span id="display">00:00</span></div>');
      IniciarCrono('tiempoRespuestas');
      setRespuesta();
      $('#test-contend #contenido')
        .find('.puntaje')
        .bind('click', function () {
          setPuntaje();
        });
    }
  );
}

function setRespuesta() {
  var x = 1;
  var rb = '';
  var cta = $('#test-contend #contenido .lectura').find('.pregunta').length;
  $('#test-contend #contenido .lectura')
    .find('.pregunta')
    .each(function () {
      var div = $(this);
      div.find('input').bind('click', function () {
        rb += $(this).val() + ','; //+$('#respuestasForm').val();
        $('#respuestasForm').val(rb);
        x++;
        div.addClass('ocultar');
        div.next('div').removeClass('ocultar');
        if (x == cta + 1) {
          var rbsv = $('#respuestasForm').val();
          var ctax = rbsv.substring(0, rbsv.length - 1);
          $('#respuestasForm').val(ctax);
          $('.btn').removeClass('ocultar');
          $('#otralectura').addClass('ocultar');
          DetenerCrono();
          $('#test-container #test-body #test-contend .titulo h4').css('display', 'none');
        }
      });
    });
}

function showRequestTest(formData) {
  $('.retorno').fadeIn();
  $('.retorno').html('Estamos enviando tus datos, espera un momento...');
}

function showResponseTest(responseText) {
  var obj = JSON.parse(responseText);
  habilitarInputs('formTest');
  $('.btn').html('');

  if (obj['estado'] == 1) {
    $('.retorno').fadeOut();
    $('.btn').append(obj['mensaje']);
    $('.btn').append(
      '<div class="centrar"><br/><iframe width="81px" src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fcitex.bo%2Ftest&amp;width&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65&amp;appId=664328430259949" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:65px;" allowTransparency="true"></iframe></div>'
    );
    $('.btn').append("<br/><a href='test' class='aceptar btn btn-blue'><span>Aceptar</span></a>");
    $('#formTest').reset();
  } else {
    $('.retorno').fadeOut();
    $('.btn').append("<a href='test' class='aceptar btn btn-blue'><span>Aceptar</span></a>");
    alert('Ha ocurrido un error al intentar enviar los datos.\nVuelva a intentarlo o intente mas tarde.\nGracias.');
  }
}

function setPuntaje() {
  $('#tipoPersonaForm').val($('#tipoPersona').val());
  $('#tipoTestForm').val($('#tipoTest').val());
  $('#tiempoLecturaForm').val($('#tiempoLectura').val());
  $('#tiempoRespuestasForm').val($('#tiempoRespuestas').val());
}

function showResponseTestCerebralx(responseText) {
  var obj = JSON.parse(responseText);
  //habilitarInputs("formTestx");
  if (obj['estado'] == 1) {
    $('#result').fadeOut();
    $('#resultado').fadeIn();
  } else {
    $('.retorno').fadeOut();
    alert(obj['mensaje'] || 'Ha ocurrido un error al intentar enviar los datos.');
  }
}

//CRONOMETRO
var CronoID = null;
var CronoEjecutandose = false;
var decimas, segundos, minutos;

function DetenerCrono() {
  if (CronoEjecutandose) clearTimeout(CronoID);
  CronoEjecutandose = false;
}

function InicializarCrono() {
  //inicializa contadores globales
  decimas = 0;
  segundos = 0;
  minutos = 0;

  //pone a cero los marcadores
  $('#display').html('00:00');
}

function MostrarCrono(tipo) {
  //incrementa el crono
  decimas++;
  if (decimas > 9) {
    decimas = 0;
    segundos++;
    if (segundos > 59) {
      segundos = 0;
      minutos++;
      if (minutos > 99) {
        alert('Fin de la cuenta');
        DetenerCrono();
        return true;
      }
    }
  }

  //configura la salida
  var ValorCrono = '';
  ValorCronom = minutos < 10 ? '0' + minutos : minutos;
  ValorCronos = segundos < 10 ? ':0' + segundos : ':' + segundos;
  ValorCrono = ValorCronom + ValorCronos;

  $('#display').html(ValorCrono);
  $('#' + tipo).val(ValorCrono);

  CronoID = setTimeout("MostrarCrono('" + tipo + "')", 100);
  CronoEjecutandose = true;
  return true;
}

function IniciarCrono(tipo) {
  DetenerCrono();
  InicializarCrono();
  MostrarCrono(tipo);
  $('#test-body #test-contend .titulo .mensaje.estado span#tipo-persona').html($('#tipoPersonaNombre').val());
  $('#test-body #test-contend .titulo.cabecera h4').css('display', 'none');
}

$(document).ready(function () {
  var optionsx = { beforeSubmit: showRequestTest, success: showResponseTestCerebralx };
  $('#formTestx').validate({
    submitHandler: function (form) {
      $(form).ajaxSubmit(optionsx);
    },
  });
});
