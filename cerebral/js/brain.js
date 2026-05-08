window.log = function f() {
    log.history = log.history || [];
    log.history.push(arguments);
    if (this.console) {
        var args = arguments,
            newarr;
        args.callee = args.callee.caller;
        newarr = [].slice.call(args);
        if (typeof console.log === 'object') log.apply.call(console.log, console, newarr);
        else console.log.apply(console, newarr);
    }
};
(function(a) {
    function b() {}
    for (var c = "assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","), d; !!(d = c.pop());) {
        a[d] = a[d] || b;
    }
})
(function() {
    try {
        console.log();
        return window.console;
    } catch (a) {
        return (window.console = {});
    }
}());

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [, ""])[1].replace(/\+/g, '%20')) || null;
}
var result_data = {};
var d = getURLParameter('data');
if (d) {
    x = Base64.decode(d);
    var intRegex = /^\d+$/;
    var left = d.split(',')[0];
    if (intRegex.test(left) && left < 101) {
        $(".test.result").attr('data-resultleft', left);
        $(".test.result").attr('data-resultright', 100 - left);
    } else {
        $(".test.result").attr('data-resultleft', 30);
        $(".test.result").attr('data-resultright', 70);
    }
    $("#wrapper").addClass('showresult');
}
var d = getURLParameter('schoko');
result_data.schoko = false;
if (d) {
    result_data.schoko = true;
    $("#left_bar img").attr('src', 'img/result_left_schoko_bar.png');
    $("#right_bar img").attr('src', 'img/result_right_schoko_bar.png');
    $('#test01').fadeIn(0);
} else {
    if (!$('#wrapper').hasClass('showresult')) {
        $('#intro').fadeIn(0);
    }
}
var shareurl = 'es.sommer-sommer.com/test-cerebral/';
//shareit(shareurl);
result_data.wronganswers = 0;
result_data.notanswered = 0;
var color = 0;
var o = 0;
result_data.points_left = 0;
result_data.points_right = 0;
var functionstopped = false;
result_data.res_taenzerin = '';
result_data.res_farben = '4';
result_data.res_figuren = '';
result_data.res_passtzu = '';
result_data.res_freundschaft = '';
result_data.res_kopf = '';
result_data.res_arme = '';
result_data.res_beine = '';
result_data.res_auge = '';
$('#intro .button').click(function(event) {
	event.preventDefault();
    $('#intro').fadeOut(0, function() {
        $('#test01').fadeIn(0);
    });
});
$('.answer').click(function(event) {
	event.preventDefault();
    if (!$(this).hasClass('farbe')) {
        result_data.points_left = result_data.points_left + parseFloat($(this).attr('data-pointsleft'));
        result_data.points_right = result_data.points_right + parseFloat($(this).attr('data-pointsright'));
        question_name = $(this).attr('data-name');
        if (question_name == 'res_taenzerin') {
            result_data.res_taenzerin = parseFloat($(this).attr('data-pointsleft')) + ',' + parseFloat($(this).attr('data-pointsright'));
        }
        if (question_name == 'res_figuren') {
            result_data.res_figuren = parseFloat($(this).attr('data-pointsleft')) + ',' + parseFloat($(this).attr('data-pointsright'));
        }
        if (question_name == 'res_passtzu') {
            result_data.res_passtzu = parseFloat($(this).attr('data-pointsleft')) + ',' + parseFloat($(this).attr('data-pointsright'));
        }
        if (question_name == 'res_freundschaft') {
            result_data.res_freundschaft = parseFloat($(this).attr('data-pointsleft')) + ',' + parseFloat($(this).attr('data-pointsright'));
        }
        if (question_name == 'res_kopf') {
            result_data.res_kopf = parseFloat($(this).attr('data-pointsleft')) + ',' + parseFloat($(this).attr('data-pointsright'));
        }
        if (question_name == 'res_arme') {
            result_data.res_arme = parseFloat($(this).attr('data-pointsleft')) + ',' + parseFloat($(this).attr('data-pointsright'));
        }
        if (question_name == 'res_beine') {
            result_data.res_beine = parseFloat($(this).attr('data-pointsleft')) + ',' + parseFloat($(this).attr('data-pointsright'));
        }
        if (question_name == 'res_auge') {
            result_data.res_auge = parseFloat($(this).attr('data-pointsleft')) + ',' + parseFloat($(this).attr('data-pointsright'));
        }
        test = $(this).closest('.test');
        if ($(test).next('.test').hasClass('result')) {
            $(test).fadeOut(0, function() {
                $('.result').fadeIn(0);
                $('#resultado').hide();
                hidebar();
            });
            getresult();
        } else {
            $(test).fadeOut(0, function() {
                $(test).next('.test').fadeIn(0);
                hidebar();
            });
        }
    }
});
$('.button.why').click(function() {
    $(this).closest('.test').fadeOut(0, function() {
        $('#wrapper').height('auto');
        $('.explaination').fadeIn(0);
        hidebar();
        $('#stext').fadeOut(0);
    })
});
$('.explaination .button').click(function() {
    $(this).closest('.test').fadeOut(0, function() {
        $('.danke').fadeIn(0);
        hidebar();
        $('#stext').fadeIn(0);
    })
});

function hidebar() {
   // window.scrollTo(0, 0);
}
setTimeout(hidebar, 100);
$('.farben .button').click(function(event ) {
	event.preventDefault();
    $(this).fadeOut(0);
    nextcolor();
});
$('.farben .answer').live('click', function() {
    $('.counter .bar .inner').stop(true, true);
    i = 4;
    if ($(this).hasClass('wrong')) result_data.wronganswers++;
    clearnumber();
    clearInterval(shownext);
    nextcolor();
});

function changenumber() {
    i--;
    if (i == 0) {
        result_data.notanswered++;
    }
    $('.counter .number').html(i);
}

function clearnumber() {
    clearInterval(refreshnumber);
}

function farbencounter() {
    i = 4;
    refreshnumber = setInterval(changenumber, 1000);
    $('.counter .bar .inner').animate({
        'width': '0px'
    }, 4000, 'linear');
    setTimeout(clearnumber, 4000);
}

function nextcolor() {
    $('.farben .answer').css({
        'display': 'block'
    });
    color++;
    $('.answer.farbe').removeClass('wrong');
    if (color == 1) {
        $('.farben .left').html('rojo');
        $('.farben .right').html('azul');
        $('.farben .left').css({
            'color': '#ff0000'
        });
        $('.farben .right').addClass('wrong');
        $('.farben .right').css({
            'color': '#00c5fe'
        });
        $('.farben .vorgabe').html('rojo');
        $('.farben .vorgabe').css({
            'color': '#ff0000'
        });
    }
    if (color == 2) {
        $('.farben .left').html('naranja');
        $('.farben .right').html('fucsia');
        $('.farben .left').css({
            'color': '#ff8a00'
        });
        $('.farben .right').addClass('wrong');
        $('.farben .right').css({
            'color': '#fe00f5'
        });
        $('.farben .vorgabe').html('fucsia');
        $('.farben .vorgabe').css({
            'color': '#ff8a00'
        });
    }
    if (color == 3) {
        $('.farben .left').html('fucsia');
        $('.farben .right').html('verde');
        $('.farben .left').css({
            'color': '#fe00f5'
        });
        $('.farben .right').addClass('wrong');
        $('.farben .right').css({
            'color': '#05e000'
        });
        $('.farben .vorgabe').html('verde');
        $('.farben .vorgabe').css({
            'color': '#fe00f5'
        });
    }
    if (color == 4) {
        $('.farben .left').html('marrón');
        $('.farben .right').html('rojo');
        $('.farben .left').css({
            'color': '#a86f00'
        });
        $('.farben .right').css({
            'color': '#ff0000'
        });
        $('.farben .left').addClass('wrong');
        $('.farben .vorgabe').html('marrón');
        $('.farben .vorgabe').css({
            'color': '#ff0000'
        });
    }
    if (color == 5) {
        $('.farben .left').html('verde');
        $('.farben .right').html('amarillo');
        $('.farben .left').css({
            'color': '#05e000'
        });
        $('.farben .right').addClass('wrong');
        $('.farben .right').css({
            'color': '#f6ff00'
        });
        $('.farben .vorgabe').html('verde');
        $('.farben .vorgabe').css({
            'color': '#05e000'
        });
    }
    if (color == 6) {
        $('.farben .left').html('naranja');
        $('.farben .right').html('fucsia');
        $('.farben .left').css({
            'color': '#ff8a00'
        });
        $('.farben .right').addClass('wrong');
        $('.farben .right').css({
            'color': '#fe00f5'
        });
        $('.farben .vorgabe').html('fucsia');
        $('.farben .vorgabe').css({
            'color': '#ff8a00'
        });
    }
    if (color == 7) {
        $('.farben .left').html('rojo');
        $('.farben .right').html('azul');
        $('.farben .left').css({
            'color': '#ff0000'
        });
        $('.farben .right').addClass('wrong');
        $('.farben .right').css({
            'color': '#00c5fe'
        });
        $('.farben .vorgabe').html('azul');
        $('.farben .vorgabe').css({
            'color': '#ff0000'
        });
    }
    if (color == 8) {
        $('.farben .left').html('verde');
        $('.farben .right').html('rojo');
        $('.farben .left').css({
            'color': '#05e000'
        });
        $('.farben .right').css({
            'color': '#ff0000'
        });
        $('.farben .left').addClass('wrong');
        $('.farben .vorgabe').html('verde');
        $('.farben .vorgabe').css({
            'color': '#ff0000'
        });
    }
    if (color < 9) {
        $('.counter .number').html(4);
        counterwidth = '200px';
        if ($('html').hasClass('mobile')) {
            counterwidth = '135px';
        }
        $('.counter .bar .inner').css({
            'width': counterwidth
        });
        farbencounter();
        shownext = setTimeout(nextcolor, 4100);
    } else {
        hidebar();
        $('.farben').fadeOut(0, function() {
            $('.figuren').fadeIn(0);
        });
        farbenresult = result_data.notanswered + result_data.wronganswers;
        if (farbenresult > 0) {
            result_data.points_left = result_data.points_left + 4;
            result_data.res_farben = '4,0';
        } else {
            result_data.points_right = result_data.points_right + 4;
            result_data.res_farben = '0,4';
        }
    }
}

function showkeywords(key) {
    prestyle = $(key).css('font-size');
    $(key).css({
        'font-size': '1px'
    });
    $(key).delay(500).animate({
        'font-size': prestyle,
        'opacity': '100'
    }, 300);
}

var txtResultado = "";
function getresult() {
    $('#share-buttons-bottom').fadeOut(0);
    $('#left_bar').css('height', '0%');
    $('#right_bar').css('height', '0%');
    if (!$('#wrapper').hasClass('showresult')) {
        allpoints = result_data.points_left + result_data.points_right;
        onepoint = 100 / allpoints;
        prozent_links = Math.round(result_data.points_left * onepoint);
        prozent_rechts = 100 - prozent_links;
        $('ul.share').fadeIn(500);
        if (!result_data.schoko) {
            $('a.study.button').fadeIn(500);
            $('#result-why').fadeIn(0);
        } else {
            $('#result-why').fadeOut(0);
            $('#schoko-result').fadeIn(0);
        }
        result_data.language = 'es';
        //$.post('http://api.sommer-sommer.com/brain/', result_data);
    } else {
        prozent_links = $('.test.result').attr('data-resultleft');
        prozent_rechts = $('.test.result').attr('data-resultright');
        $('a.call.button').fadeIn(500);
    }


    if (prozent_rechts > 59) {
        faktorleft = 2000;
        faktorright = 1000;
        $('#result_head').html("¡Felicidades!<br>El lado derecho de su cerebro es más dominante.");
		txtResultado = "¡Felicidades!<br>El lado derecho de su cerebro es más dominante.";
        if (result_data.schoko) {
            $('#schoko_result_text').html("Boost your brainpower with white chocolate and enjoy your personal happy moment of bridging the gap.");
            $('#schoko_result').fadeIn(0);
        }
    }
    if (prozent_links > 59) {
        faktorleft = 1000;
        faktorright = 2000;
        $('#result_head').html("¡Felicidades!<br>El lado izquierdo de su cerebro es más dominante.");
		txtResultado = "¡Felicidades!<br>El lado izquierdo de su cerebro es más dominante.";
        if (result_data.schoko) {
            $('#schoko_result_text').html("Boost your brainpower with dark chocolate and enjoy your personal happy moment of bridging the gap.");
            $('#schoko_result').fadeIn(0);
        }
    }
    if (prozent_links <= 59 && prozent_rechts <= 59) {
        faktorleft = 1000;
        faktorright = 1000;
        $('#result_head').html("¡Felicidades!<br>Utiliza equitativamente ambos lados del cerebro.");
		txtResultado = "¡Felicidades!<br>Utiliza equitativamente ambos lados del cerebro.";
        if (result_data.schoko) {
            $('#schoko_result_text').html("Boost your brainpower with white and dark chocolate and enjoy your personal happy moment of bridging the gap.");
            $('#schoko_result').fadeIn(0);
        }
    }
    if (document.getElementById("cantPalabrasForm")) {
        document.formTest.tiempoLecturaForm.value = prozent_rechts;
        document.getElementById("cantPalabrasForm").value = prozent_links;
    }
    b = 5;
    n = 0.864;
    leftheight = (b + n * prozent_links) + "%"
    rightheight = (b + n * prozent_rechts) + "%"
    $('.leftresult_text').html(prozent_links + "%");
    $('.rightresult_text').html(prozent_rechts + "%");
    $('#left_bar').delay(500).animate({
        'height': leftheight
    }, 2000);
    $('#right_bar').delay(500).animate({
        'height': rightheight
    }, 2000);
    $('.resulttext').fadeIn(0);
    setTimeout(function() {
        showkeywords('.regeln')
    }, 100 + faktorleft);
    setTimeout(function() {
        showkeywords('.strategie')
    }, 250 + faktorleft);
    setTimeout(function() {
        showkeywords('.logik')
    }, 400 + faktorleft);
    setTimeout(function() {
        showkeywords('.rationalitaet')
    }, 500 + faktorleft);
    setTimeout(function() {
        showkeywords('.details')
    }, 650 + faktorleft);
    setTimeout(function() {
        showkeywords('.sprache')
    }, 700 + faktorleft);
    setTimeout(function() {
        showkeywords('.intuition')
    }, 800 + faktorright);
    setTimeout(function() {
        showkeywords('.neugierde')
    }, 950 + faktorright);
    setTimeout(function() {
        showkeywords('.kreativitaet')
    }, 100 + faktorright);
    setTimeout(function() {
        showkeywords('.fantasie')
    }, 200 + faktorright);
    setTimeout(function() {
        showkeywords('.chaos')
    }, 400 + faktorright);
    setTimeout(function() {
        showkeywords('.bilder')
    }, 550 + faktorright);
	
	$("#izquierdo").val(prozent_links);
	$("#derecho").val(prozent_rechts);
	$("#txtResultado").val(txtResultado);


    if (!$('#wrapper').hasClass('showresult')) {
        gen_base64();
    } else {
        $('.test.result').fadeIn(0);
    }
}

function gen_base64() {
    BRAIN_RESULT = prozent_links + ',' + prozent_rechts;
    data = Base64.encode(BRAIN_RESULT);
    x = 'es.sommer-sommer.com/test-cerebral/?data=' + data;
    shareit(x);
}

function shareit(surl) {
    $('.share li a').each(function() {
        share = $(this).attr('data-original-href');
        if ($(this).hasClass("sharereplace")) {
            share = share.replace(/%24SHAREURL/, 'http://' + surl);
        } else {
            share = share + surl;
        }
        if ($(this).hasClass("addpiixemto")) {
            share = share + " @piixemto";
        }
        $(this).attr('href', share);
    });
}
if ($('#wrapper').hasClass('showresult')) {
    getresult();
}
$('#schoko-result a').click(function() {
//    $('#result').fadeOut(0, function() {
//        $('#schoko_video').fadeIn(0);
//    });
});
$('#schoko-video-continue').click(function() {
    $('#schoko_video').fadeOut(0, function() {
        $('#schoko_email').fadeIn(0);
    });
});
$('#email-submit').click(function() {
//    $.post('http://api.sommer-sommer.com/schoko-email/', {
//        email: $('#exampleInputEmail1').val()
//    });
    $('#schoko_email').fadeOut(0, function() {
        $('#schoko_danke').fadeIn(0);
    });
});

//function deshabilitarInputs(formId){
//	Forma = document.getElementById(formId);
//	Elementos_input = Forma.getElementsByTagName("input"); 
//	Elementos_textarea = Forma.getElementsByTagName("textarea"); 
//	
//	for (i=0;i<Elementos_input.length;i++){
//		if(Elementos_input[i].type=="button" || Elementos_input[i].type=="submit" || Elementos_input[i].type=="checkbox"){ 
//		Elementos_input[i].disabled = true;
//		} else { Elementos_input[i].readOnly = true; } 
//	}
//	
//	for (j=0;j<Elementos_textarea.length;j++){
//		Elementos_textarea[j].readOnly  = true;
//	}
//}
//
//function habilitarInputs(formId){
//	Forma = document.getElementById(formId);
//	Elementos_input = Forma.getElementsByTagName("input"); 
//	Elementos_textarea = Forma.getElementsByTagName("textarea"); 
//	
//	for (i=0;i<Elementos_input.length;i++){
//		if(Elementos_input[i].type=="button" || Elementos_input[i].type=="submit" || Elementos_input[i].type=="checkbox"){ 
//		Elementos_input[i].disabled = false;
//		} else { Elementos_input[i].readOnly = false; } 
//	}
//	
//	for (j=0;j<Elementos_textarea.length;j++){
//		Elementos_textarea[j].readOnly  = false;
//	}
//}

jQuery.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}


function setTargetBlank(){
	$('a._blank').each(function(){
		$(this).bind('click',function(e){
			e.preventDefault();
			$("meta[name='og:title']").attr('content', "Tengo una comprensión de "+valor1+" (Hemisferio Izquierdo) y "+valor2+" (Hemisferio Derecho) en el Test de "+valor3);
			openSocial($(this));
 		})
	});
 
}

function openSocial(obj) {
	window.parent.open(obj.attr('href'), obj.attr('title'), 'width=600, height=400, toolbar=0, scrollbars=0 ,location=0');
}
