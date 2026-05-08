var ini;
var tc, fecha, hora;
var interv;
var posc = 0, sw = 0;
var vectorA = [];
var vectorR = [];
var vectorRP = [];
var posR = 0;
var ale, ptje = 0;
var control = 3;
var gral = 0;
var nota = 200;
var conteo = 0;
var bienC = 0, malC = 0;
var posVeloc = 1;
var cantPal = 9;
var time;
ini = $(document);
ini.ready(inicia);
function inicia() {
	FastClick.attach(document.body);
	document.addEventListener("deviceready", onDeviceReady, false);
	/* inicair base de datos */
	iniciobase();
	var url = window.location.search.substr(1);
	valor = url.split("=");
	elec = parseInt(valor[1]);
	cantPalabra(cantPal, posVeloc);
	document.getElementById("seg").innerHTML = time;
	$('#panelbien').hide();
	$('#panelmal').hide();
	esconderTabla();
	$('#tabla_juego' + elec).show();
	$("#respuestas").hide();
}
function onDeviceReady() {
	// Register the event listener
	document.addEventListener("backbutton", onBackKeyDown, false);
}
function onBackKeyDown() {
	$(location).attr('href', 'palabras.html');
}
function reiniciarJuego() {
	posR = 0;
	ale, ptje = 0;
	posVeloc = 1;
	bienC = 0, malC = 0;
	cantPal = 9;
	conteo = 0;
	niv = 2;
	var gral = 0;
	cantPalabra(cantPal, posVeloc);
	document.getElementById("aciertos").innerHTML = bienC;
	document.getElementById("vida").innerHTML = malC;
	document.getElementById("seg").innerHTML = time;
	window.clearInterval(tc);
	esconderTabla();
	$('#tabla_juego' + elec).show();
	$("#respuestas").hide();
	Limpiar(1, datos[0].col[elec], elec);
	reiniciarPalabras(datos[0].col[elec], elec);
	reiniciar_img(datos[0].col[elec], elec);
}
function esconderTabla() {
	for (var i = 1; i <= 4; i++) { $("#tabla_juego" + i).hide(); }
}
function reiniciar_img(tope, colx) {
	for (var i = 1; i <= tope; i++) { $('#img' + colx + '_' + i).hide(); }
}
function reiniciarPalabras(tope, colx) {
	for (var i = 1; i <= tope; i++) { $('#col' + colx + '_' + i).html("<img id='img" + colx + "_" + i + "'  src='../../img/punto2.png'/>"); }
}
function juego() {
	reiniciarJuego();
	min = 0;
	seg = 2;
	$('#img' + elec + '_1').show();
	tc = setInterval(Inijuego, 400);
}
function Inijuego() {
	if (seg < datos[2].lims[elec]) {
		$('#img' + elec + '_' + (seg - 1)).hide();
		$('#img' + elec + '_' + seg).show();
	}
	if (seg > datos[3].minseg[elec] && seg < datos[4].maxseg[elec]) {
		$('#img' + elec + '_' + (seg - datos[2].lims[elec])).hide();
		$('#img' + elec + '_' + (seg - datos[3].minseg[elec])).show();
	}
	if (seg > datos[5].camseg[elec]) {
		window.clearInterval(tc);
		gral = 0;
		prueba3();
	}
	seg++;
}
function MostrarPal(minx, mayx, vel) {
	interv = Math.floor(Math.random() * (mayx - minx + 1)) + minx;
	posc = 0;
	seg = 2; min = 0;
	vectorA = [];
	vector(interv);
	window.clearInterval(tc);
	tc = setInterval(jugar, vel);
}
function prueba3() {
	var aciertos = document.getElementById("aciertos").innerHTML;
	var fallas = document.getElementById("vida").innerHTML;
	if (gral < 20) {
		$('#respuestas').hide();
		Limpiar(1, datos[0].col[elec], elec);
		$('#tabla_juego' + elec).show();
		MostrarPal((cantPal - 1), cantPal, datos[1].velocidad[posVeloc]);
		posR++;
	}
	else {
		img = "";
		let pathImg = "../../img/";
		if (time <= 500) {
			img = pathImg + "semilla.svg";
		}
		if (time > 500 && time <= 800) {
			img = pathImg + "brote.svg";
		}
		if (time > 800 && time <= 1000) {
			img = pathImg + "premio.svg";
		}
		obtener_fecha();
		insertarptje("prp", 1, elec, fecha, hora, aciertos, 60, $("#seg").text());
		alertify.alert("<img/ src='" + img + "' width='80' height='80'><br>" +
			"<ul id='alertify'>" +
			"<li class='iconbien'><span class='fa fa-check'></span> Aciertos: " + aciertos + " </li>" +
			"<li class='iconmal'><span class='fa fa-times'></span> Fallos : " + fallas + "</li>" +
			"<li class='icontiempo'><span class='fa fa-clock-o'></span> VL : " + $("#seg").text() + " pal/min</li>" +
			"</ul>", function () {
				/* time_total=seg;
				 ct_ok=1;
				 obtener_fecha();*/
				//consulta_id("Gimnasia visual","2",elec+"");
				//obtener_ptje("Gimnasia visual","2",elec+"");
				// window.location.href = 'visual-s1.html';
				reiniciarJuego();
			});
	}
	gral++;
}
function Limpiar(ini, fin, col) {
	for (var i = ini; i <= fin; i++) {
		document.getElementById("col" + (col + "_" + i)).innerHTML = "";
	}
}
function jugar() {
	if (min != 1) {
		if (seg > interv - 1) {
			min++;
			Limpiar(1, datos[0].col[elec], elec);
		}
		else {
			if (posc == 0) {
				document.getElementById("col" + elec + "_" + datos[0].col[elec]).innerHTML = "";
				document.getElementById("col" + elec + "_1").innerHTML = vectorA[seg];
			}
			if (posc > 0 && posc < datos[0].col[elec]) {
				document.getElementById("col" + elec + "_" + posc).innerHTML = "";
				document.getElementById("col" + elec + "_" + (posc + 1)).innerHTML = vectorA[seg];
			}
			if (posc == (datos[0].col[elec] - 1)) {
				posc = 0;
			}
			else {
				posc++;
			}
			seg++;
		}
	}
	else {
		$("#tabla_juego" + elec + "").hide();
		$('#respuestas').show();
		window.clearInterval(tc);
		dibuja(1, 1);
	}
}
function datop(valor) {
	cadena = document.getElementById(valor).innerHTML;
	if (cadena == vectorR[posR - 1]) {
		bien();
		conteo++;
		bienC++;
		document.getElementById("aciertos").innerHTML = bienC;
		if (posVeloc >= 0 && posVeloc < 18) {
			posVeloc++;
			if (posVeloc % 2 != 0 || posVeloc == 0) {
				cantPal = cantPal + 2;
			}
		}
	}
	else {
		mal();
		malC++;
		document.getElementById("vida").innerHTML = malC;
		if (posVeloc > 0 && posVeloc <= 18) {
			posVeloc--;
			if (posVeloc % 2 != 0) {
				cantPal = cantPal - 2;
			}
		}
	}
	cantPalabra(cantPal, posVeloc);
	document.getElementById("seg").innerHTML = time;
	prueba3();
}
function vector(cant) {
	for (var i = 0; i < cant; i++) {
		vectorA[i] = dato[0].vec1[Math.floor(Math.random() * (299 - 0 + 1)) + 0];
	}
	vectorR[posR] = vectorA[cant - 1];
}
function respProb() {
	ale = Math.floor(Math.random() * (5 - 0 + 1)) + 0;
	var numv1 = Math.floor(Math.random() * (293 - 0 + 1)) + 0;
	for (var i = 0; i < 6; i++) {
		if (i != ale) {
			if (dato[0].vec1[numv1 + i] == vectorR[posR - 1]) {
				vectorRP[i] = dato[0].vec1[Math.floor(Math.random() * (299 - 0 + 1)) + 0];
			}
			else {
				vectorRP[i] = dato[0].vec1[numv1 + i];
			}
		}
		else {
			vectorRP[ale] = vectorR[posR - 1];
		}
	}
}
function dibuja(inix, colx) {
	respProb();
	for (var i = inix; i <= 6; i++) { document.getElementById("btn" + i + "_" + colx).innerHTML = vectorRP[i - 1]; }
}
function bien() {
	$("#panelbien").show();
	$("#panelbien").delay(200).hide(150);
}
function mal() {
	$("#panelmal").show();
	$("#panelmal").delay(200).hide(150);
}
function cantPalabra(cant, velo) {
	time = datos[6].velocidadNominal[velo];
}
function obtener_fecha(argument) {
	var f = new Date();
	hora = f.getHours() + ":" + f.getMinutes() + ":" + f.getSeconds();
	fecha = f.getDate() + "/" + (f.getMonth() + 1) + "/" + f.getFullYear();
	//alert(hora+"-"+fecha);
}