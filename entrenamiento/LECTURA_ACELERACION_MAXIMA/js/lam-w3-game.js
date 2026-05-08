var vec = [];
var aux = [];
var txt = "";
var nomtexto = "";
var opt = 0;
var tamanioMarco;
var ini;
ini = $(document);
ini.ready(inicio);
function inicio() {
	lecturainterna();
	FastClick.attach(document.body);
	//document.addEventListener("deviceready", onDeviceReady, false);
	mostrar_slider();
	reiniciar();
	tamanioMarco = $('.cajaLam').height();
	$('#pantalla').text(tamanioMarco);
	ci.css('left', '-100%');
}
function lecturainterna() {
	for (var i = 0; i < lec.length; i++) {
		if (i == 0) {
			$('#lista-lectura ul').append("<li><div><input type='radio' id='a" + i + "' name='lectura' value='" + i + "' checked='checked'/><label for='a" + i + "'><span></span>" + lec[i].titulo + "</label></div></li>");
		}
		else {
			$('#lista-lectura ul').append("<li><div><input type='radio' id='a" + i + "' name='lectura' value='" + i + "' /><label for='a" + i + "'><span></span>" + lec[i].titulo + "</label></div></li>");
		}
	}
}
function reiniciar() {
	ci.css('left', '-100%');
	lg = 0;
	pos = 0;
	act = 0;
	lim = 0;
	lit = 200;
	tmp = 500;
	litm = 600;
	tmpm = 20;
	k = 0; hr = 0; ban = 0; btnpl = 0;
	contAltura = 0;
	$("#play").show();
	$("#pause").hide();
	$("#playm").show();
	$("#pausem").hide();
}
function comenzar(opc) {
	reiniciar();
	sw = 1;
	document.getElementById("masm").disabled = false;
	document.getElementById("menosm").disabled = false;
	txt = $('input:radio[name=lectura]:checked').val();
	txt = obtiene_texto(txt);
	//alert(txt);
	if (opc == 1) {
		ci.css('left', '0%');
		//$("#openlec2").show();		
	}
	else {
		$("#cajaletras").html(txt);
		ci.css('left', '-200%');
		altura = $('#cajaletras').height();
		nuevaAltura = (altura + tamanioMarco);
		$('#cajaletras').css("top", (tamanioMarco) + "px");
		$("#velm").text(litm + " palabras/min.");
	}
}
var contAltura, altura, nuevaAltura;
function obtiene_texto(op) {
	var d = "";
	for (var i = 0; i < lec.length; i++) {
		if (i == op) {
			d = lec[i].texto;
		}
	}
	return d;
}
var sw = 0; //play para activar x 1ra vez
var lg = 0, pos = 0, act = 0, lim = 0, lit = 500, tmp = 500, k, hr, ban = 0, btnpl = 0;
function play() {
	if (sw == 1) {
		vec = txt.split(" ");
		//alert(vec);
		lg = vec.length;
		//alert(lec);
		ban = 1;
		btnpl = 1;
		$("#pause").show();
		$("#play").hide();
		tmp = velpal(lit);
		k = setInterval(leer, tmp);
	}
	else {
		//$("#pause").show();
		//$("#play").hide();
		k = setInterval(leer, tmp);
	}
}
function mas() {
	if (ban == 0) {
		if (tmp > 65) {
			act = 1;
			//tmp=tmp-20;
			lit = lit + 20;
			tmp = velpal(lit);
			$("#vel").text(lit + " palabras/min.");
		}
	}
	else {
		if (tmp > 65) {
			k = clearInterval(k);
			//tmp=tmp-20;
			lit = lit + 20;
			tmp = velpal(lit);
			$("#vel").text(lit + " palabras/min.");
			k = setInterval(leer, tmp);
		}
	}
}
function menos() {
	if (ban == 0) {
		if (tmp < 900) {
			act = 1;
			lit = lit - 20;
			tmp = velpal(lit);
			//tmp=tmp+20;
			$("#vel").text(lit + " palabras/min.");
		}
	}
	else {
		if (tmp < 900) {
			k = clearInterval(k);
			lit = lit - 20;
			tmp = velpal(lit);
			//tmp=tmp+20;
			$("#vel").text(lit + " palabras/min.");
			k = setInterval(leer, tmp);
		}
	}
}
function leer() {
	if (pos < lg) {
		$("#dato").text(vec[pos]);
		pos++;
	}
	else {
		k = clearInterval(k);
		ban = 1;
		btnpl = 0;
		reiniciar();
		$("#dato").text("Observe aquí");
		$("#vel").text("500 palabras/min.");
		//alert("fin");
	}
}
var swM = 0;
var litm = 100, tmpm = 34000, vel = 10;
function playm(argument) {
	if (sw == 1) {
		ban = 1;
		btnpl = 1;
		$("#pausem").show();
		$("#playm").hide();
		k = setInterval(subir, tmpm);
		//$('#cajaletras').animate({top: "-=800px"},8500); 
	}
	else {
		$("#pause").show();
		$("#play").hide();
		k = setInterval(subir, tmpm);
	}
}
function masm() {
	if (ban == 0) {
		if (tmpm > 8) {
			act = 1;
			litm = litm + 50;
			tmpm = tmpm - 2;
			$("#velm").text(litm + " palabras/min.");
		}
	}
	else {
		if (tmpm > 8) {
			k = clearInterval(k);
			//tmp=tmp-20;
			litm = litm + 50;
			tmpm = tmpm - 2;
			$("#velm").text(litm + " palabras/min.");
			k = setInterval(subir, tmpm);
		}
	}
}
function menosm() {
	if (ban == 0) {
		if (tmpm < 40) {
			act = 1;
			litm = litm - 50;
			tmpm = tmpm + 2;
			$("#velm").text(litm + " palabras/min.");
		}
	}
	else {
		if (tmpm < 40) {
			k = clearInterval(k);
			litm = litm - 50;
			tmpm = tmpm + 2;
			//tmp=tmp+20;
			$("#velm").text(litm + " palabras/min.");
			k = setInterval(subir, tmpm);
		}
	}
}
function pausa() {
	if (btnpl == 1) {
		$("#pause").hide();
		$("#play").show();
	}
	ban = 0;
	k = clearInterval(k);
}
function pausem() {
	if (btnpl == 1) {
		$("#pausem").hide();
		$("#playm").show();
	}
	ban = 0;
	k = clearInterval(k);
}
function atras() {
	swM = 0; sw = 0;
	$("#playm").show();
	$("#pausem").hide();
	$("#vel").text("500 palabras/min.");
	$("#velm").text("100 palabras/min.");
	$("#dato").text("Observe aquí");
	k = clearInterval(k);
	reiniciar();
	ci.css('left', '-100%');
}
function velpal(lt) {
	lt = (60 * 1000) / lt;
	return Math.round(lt);
}
function palimil(cantpal) {
	for (var i = 0; i < velocidad[1].nombreV.length; i++) {
		if (velocidad[1].nombreV[i] == cantpal) {
			return velocidad[0].tiempoV[i];
		}
	}
}
function subir() {
	if (contAltura < nuevaAltura) {
		contAltura++;
		$('#cajaletras').css("top", (tamanioMarco - contAltura) + "px");
	}
	else {
		clearInterval(k);
		//hr=setInterval(tiempo,1000)
		resultado();
		//nextAutomatico();
	}
}
function resultado() {
	alertify.alert("<b> Fin de la lectura</b>", function () {
		reiniciar();
		ci.css('left', '-100%');
	});
}