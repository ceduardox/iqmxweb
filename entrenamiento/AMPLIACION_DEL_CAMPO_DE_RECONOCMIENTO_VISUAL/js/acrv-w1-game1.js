var ini;
var res = [];
var fallos = [];
var aciertos = [];
var turno, acierto = "", fecha, hora;
var tc, cont = 0, contF = 0, nroF = 0, contA = 0, nroA = 0, pos;
var elec;
var VecAle = [];
var numv1;
ini = $(document);
ini.ready(inicia);
function inicia() {
	FastClick.attach(document.body);
	document.addEventListener("deviceready", onDeviceReady, false);
	iniciobase();
	var url = window.location.search.substr(1);
	valor = url.split("=");
	elec = parseInt(valor[1]);
	document.getElementById('boton1').disabled = true;
	document.getElementById('boton2').disabled = true;
	$("#panelbien").hide();
	$("#panelmal").hide();
	aleatorio();
}
function onDeviceReady() {
	// Register the event listener
	document.addEventListener("backbutton", onBackKeyDown, false);
}
function onBackKeyDown() {
	$(location).attr('href', 'visual.html');
}
function juego() {
	document.getElementById('boton1').disabled = false;
	document.getElementById('boton2').disabled = false;
	reiniciar();
	seg = 60;
	pos = 0;
	window.clearInterval(tc);
	cont = 0;
	if (elec == 1)
		armar_fallo(0, 3);
	else
		armar_fallo(0, 7);
	fallos = []; contF = 0; nroF = 0;
	aciertos = []; contA = 0;
	for (var i = 0; i < 7; i++) {
		for (var j = 0; j < 9; j++) {
			if (i != 3 && j != 4) {
				p = i + "" + j;
				$("#col-" + p).text(String.fromCharCode(Math.floor(65 + Math.random() * 26)));
			}
		}
	}
	jugar();
	tc = setInterval(tiempo_respuesta, 1000);
}
function reiniciar() {
	clearInterval(tc);
	document.getElementById("aciertos").innerHTML = 0;
	document.getElementById("vida").innerHTML = 0;
	document.getElementById("seg").innerHTML = 60;
	pos = 0;
}
function armar_fallo(min, max) {
	res = [];
	for (var i = 0; i < 60; i++) {
		res[i] = {
			'letra': String.fromCharCode(Math.floor(VecAle[i])),
			'dis': Math.floor(Math.random() * (1 - 0 + 1)) + 0,
			'lado': Math.floor(Math.random() * (max - min + 1)) + min,
			'estado': 0
		};
	}
}
function aleatorio() {
	c = 0;
	numv1 = Math.floor(65 + Math.random() * 26);
	while (c < 60) {
		if (VecAle[(c - 1)] == numv1) {
			numv1 = Math.floor(65 + Math.random() * 26);;
		}
		else {
			VecAle[c] = numv1;
			c++;
		}
	}
}
function tiempo_respuesta() {
	document.getElementById('boton1').disabled = false;
	document.getElementById('boton2').disabled = false;
	if (elec == 1) {
		if (seg == 0) {
			window.clearInterval(tc);
			notas();
		}
		else {
			seg--;
			pos++;
			jugar();
		}
	}
	else {
		if (seg == 0) {
			window.clearInterval(tc);
			notas();
		}
		else {
			seg--;
			pos++;
			nivel2();
		}
	}
	document.getElementById("seg").innerHTML = (seg);
}
function jugar() {
	if (pos < 60) {
		if (res[pos].dis == 1) {
			nroF++;
			letra = res[pos].letra;
			abc = asignar_letra(letra);
			if (res[pos].lado == 0) {
				$("#col-04").text(abc);
				$("#col-30").text(res[pos].letra);
				$("#col-38").text(res[pos].letra);
				$("#col-64").text(res[pos].letra);
			}
			if (res[pos].lado == 1) {
				$("#col-04").text(res[pos].letra);
				$("#col-30").text(abc);
				$("#col-38").text(res[pos].letra);
				$("#col-64").text(res[pos].letra);
			}
			if (res[pos].lado == 2) {
				$("#col-04").text(res[pos].letra);
				$("#col-30").text(res[pos].letra);
				$("#col-38").text(abc);
				$("#col-64").text(res[pos].letra);
			}
			if (res[pos].lado == 3) {
				$("#col-04").text(res[pos].letra);
				$("#col-30").text(res[pos].letra);
				$("#col-38").text(res[pos].letra);
				$("#col-64").text(abc);
			}
		}
		else {
			$("#col-04").text(res[pos].letra);
			$("#col-30").text(res[pos].letra);
			$("#col-38").text(res[pos].letra);
			$("#col-64").text(res[pos].letra);
		}
	}
}
function asignar_letra(letra) {
	nro = Math.floor(65 + Math.random() * 26);
	abc = String.fromCharCode(nro);
	//abc=String.fromCharCode(a);
	if (abc == letra) {
		if (nro == 90) {
			nro = 1;
		}
		else {
			nro++;
		}
	}
	abc = String.fromCharCode(nro);
	return abc;
}
function respuestaMal() {
	document.getElementById('boton1').disabled = true;
	document.getElementById('boton2').disabled = true;
	if (res[pos].dis == 1) {
		aciertos[contA] = seg;
		contA++;
		$("#panelbien").show();
		$("#panelbien").delay(200).hide(150);
		document.getElementById("aciertos").innerHTML = contA;
	}
	else {
		fallos[contF] = seg;
		contF++;
		$("#panelmal").show();
		$("#panelmal").delay(200).hide(150);
		document.getElementById("vida").innerHTML = contF;
	}
}
function respuestaBien() {
	document.getElementById('boton1').disabled = true;
	document.getElementById('boton2').disabled = true;
	if (res[pos].dis == 0) {
		aciertos[contA] = seg;
		contA++;
		$("#panelbien").show();
		$("#panelbien").delay(200).hide(150);
		document.getElementById("aciertos").innerHTML = contA;
	}
	else {
		fallos[contF] = seg;
		contF++;
		$("#panelmal").show();
		$("#panelmal").delay(200).hide(150);
		document.getElementById("vida").innerHTML = contF;
	}
}
function notas() {
	obtener_fecha();
	insertarptje("acrv", 1, elec, fecha, hora, aciertos.length, 60, 0);
	alertify.alert("<img src='" + resultado_imagen() + "' width='80' height='80'/><br>" +
		"<ul id='alertify'>" +
		"<li class='iconbien'><span class='fa fa-check'></span> Aciertos: " + aciertos.length + "</li>" +
		"<li class='iconmal'><span class='fa fa-times'></span> Fallos : " + fallos.length + "</li>" +
		"<li class='iconalert'><span class='fa fa-exclamation-triangle'></span> No respondio: " + (60 - (aciertos.length + fallos.length)) + "</li>" +
		"<li class='icontiempo'><span class='fa fa-clock-o'></span> Tiempo: 60 seg.</li>" +
		"</ul>", function () {
			reiniciar();
		});
}
function resultado_imagen() {
	img = "";
	let pathImg = "../../img/";
	if (aciertos.length >= 0 && aciertos.length <= 20) {
		img = pathImg + 'semilla.svg';
	}
	if (aciertos.length >= 21 && aciertos.length <= 50) {
		img = pathImg + 'brote.svg';
	}
	if (aciertos.length >= 51 && aciertos.length <= 60) {
		img = pathImg + 'premio.svg';
	}
	return img;
}
/// juego nivel dos
function nivel2() {
	if (res[pos].dis == 1) {
		nroF++;
		letra = res[pos].letra;
		abc = asignar_letra(letra);
		if (res[pos].lado == 0) {
			$("#col-00").text(res[pos].abc);
			$("#col-04").text(res[pos].letra);
			$("#col-08").text(res[pos].letra);
			$("#col-30").text(res[pos].letra);
			$("#col-38").text(res[pos].letra);
			$("#col-60").text(res[pos].letra);
			$("#col-64").text(res[pos].letra);
			$("#col-68").text(res[pos].letra);
		}
		if (res[pos].lado == 1) {
			$("#col-00").text(res[pos].letra);
			$("#col-04").text(abc);
			$("#col-08").text(res[pos].letra);
			$("#col-30").text(res[pos].letra);
			$("#col-38").text(res[pos].letra);
			$("#col-60").text(res[pos].letra);
			$("#col-64").text(res[pos].letra);
			$("#col-68").text(res[pos].letra);
		}
		if (res[pos].lado == 2) {
			$("#col-00").text(res[pos].letra);
			$("#col-04").text(res[pos].letra);
			$("#col-08").text(abc);
			$("#col-30").text(res[pos].letra);
			$("#col-38").text(res[pos].letra);
			$("#col-60").text(res[pos].letra);
			$("#col-64").text(res[pos].letra);
			$("#col-68").text(res[pos].letra);
		}
		if (res[pos].lado == 3) {
			$("#col-00").text(res[pos].letra);
			$("#col-04").text(res[pos].letra);
			$("#col-08").text(res[pos].letra);
			$("#col-30").text(abc);
			$("#col-38").text(res[pos].letra);
			$("#col-60").text(res[pos].letra);
			$("#col-64").text(res[pos].letra);
			$("#col-68").text(res[pos].letra);
		}
		if (res[pos].lado == 4) {
			$("#col-00").text(res[pos].letra);
			$("#col-04").text(res[pos].letra);
			$("#col-08").text(res[pos].letra);
			$("#col-30").text(res[pos].letra);
			$("#col-38").text(abc);
			$("#col-60").text(res[pos].letra);
			$("#col-64").text(res[pos].letra);
			$("#col-68").text(res[pos].letra);
		}
		if (res[pos].lado == 5) {
			$("#col-00").text(res[pos].letra);
			$("#col-04").text(res[pos].letra);
			$("#col-08").text(res[pos].letra);
			$("#col-30").text(res[pos].letra);
			$("#col-38").text(res[pos].letra);
			$("#col-60").text(abc);
			$("#col-64").text(res[pos].letra);
			$("#col-68").text(res[pos].letra);
		}
		if (res[pos].lado == 6) {
			$("#col-00").text(res[pos].letra);
			$("#col-04").text(res[pos].letra);
			$("#col-08").text(res[pos].letra);
			$("#col-30").text(res[pos].letra);
			$("#col-38").text(res[pos].letra);
			$("#col-60").text(res[pos].letra);
			$("#col-64").text(abc);
			$("#col-68").text(res[pos].letra);
		}
		if (res[pos].lado == 7) {
			$("#col-00").text(res[pos].letra);
			$("#col-04").text(res[pos].letra);
			$("#col-08").text(res[pos].letra);
			$("#col-30").text(res[pos].letra);
			$("#col-38").text(res[pos].letra);
			$("#col-60").text(res[pos].letra);
			$("#col-64").text(res[pos].letra);
			$("#col-68").text(abc);
		}
	}
	else {
		$("#col-00").text(res[pos].letra);
		$("#col-04").text(res[pos].letra);
		$("#col-08").text(res[pos].letra);
		$("#col-30").text(res[pos].letra);
		$("#col-38").text(res[pos].letra);
		$("#col-60").text(res[pos].letra);
		$("#col-64").text(res[pos].letra);
		$("#col-68").text(res[pos].letra);
	}
}
function obtener_fecha(argument) {
	var f = new Date();
	hora = f.getHours() + ":" + f.getMinutes() + ":" + f.getSeconds();
	fecha = f.getDate() + "/" + (f.getMonth() + 1) + "/" + f.getFullYear();
	//alert(hora+"-"+fecha);
}