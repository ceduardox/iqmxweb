var v = [];
var niv, hr, bien, mal, elem, sw_prn_s1, seg, time, lim;
var fecha;
var ini;
ini = $(document);
ini.ready(inicio);
function inicio() {
	FastClick.attach(document.body);
	//crea base de datos 
	iniciobase();
	document.addEventListener("deviceready", onDeviceReady, false);
	nivel();
}
function onDeviceReady() {
	// Register the event listener
	document.addEventListener("backbutton", onBackKeyDown, false);
}
function onBackKeyDown() {
	$(location).attr('href', 'percepcion-s1.html');
}
function nivel() {
	var url = window.location.search.substr(1);
	valor = url.split("=");
	niv = valor[1];
	mostrar(niv);
}
function mostrar(niv) {
	time = 20;
	lim = 25;
	$("#seg").text(time);
}
function comenzar() {
	reiniciar();
	llenar(niv - 1);
	sw_prn_s1 = 1;
	hr = setInterval(tiempo, 1000);
}
function reiniciar() {
	elem = 1;
	seg = time;
	$("#aciertos").text(0);
	$("#vida").text(0);
	$("#seg").text(seg);
	$(".buscar").text("?");
	sw_prn_s1 = 0;
	clearInterval(hr);
	bien = mal = 0;
}
function llenar(op) {
	barajear(dato[op].vec, dato[op].vec.length);
	for (var i = 0; i < dato[op].vec.length; i++) {
		$("#a1" + i).text(dato[op].vec[i]);
	}
	x = obtener_abc(elem);
	elem++;
	$(".buscar").text(x);
}
function barajear(vecDato, longitud) {
	for (var i = 0; i < longitud * 3; i++) {
		x = Math.floor(Math.random() * longitud);
		y = Math.floor(Math.random() * longitud);
		aux = vecDato[x];
		vecDato[x] = vecDato[y];
		vecDato[y] = aux;
	}
}
function tiempo() {
	seg = document.getElementById('seg').innerHTML;
	if (seg == 0) {
		//reiniciar();
		resultado();
	}
	else {
		seg--;
		if (seg < 10)
			seg = "0" + seg;
	}
	document.getElementById("seg").innerHTML = seg;
}
function datop(op) {
	//alert(op);
	if (sw_prn_s1 == 1) {
		valor = $('#' + op).text();
		//alert(valor);
		//$('#buscar').toggleClass('color-cuadro');
		if (verifica(valor)) {
			$("#" + op).addClass("verde").delay(150);
			$("#" + op).queue(function () {
				$(this).removeClass("verde");
				$(this).dequeue();
			});
			bien++;
			$("#aciertos").text(bien);
			if (bien == lim) {
				//reiniciar();
				resultado();
			}
			else {
				x = obtener_abc(elem);
				$(".buscar").text(x);
				elem++;
			}
		}
		else {
			$("#" + op).addClass("rojo").delay(150).queue(function () {
				$(this).removeClass("rojo");
				$(this).dequeue();
			});
			mal++;
			vidas(mal);
		}
	}
}
function quitar(op) {
	$("#" + op).removeClass("rojo");
}
function verifica(valor) {
	vv = $(".buscar").text();
	//alert(valor+"-"+elem);
	if (valor == vv) {
		return true;
	}
	return false;
}
function vidas(op) {
	//document.getElementById('start'+op).src='../img/start-2.png';
	$("#vida").text(op);
	if (op < 3) {
		//mal++;
		//aleatorio(niv-1);
	}
	else {
		resultado();
		//alert("fin sin vidas");		
	}
}
function resultado() {
	hr = clearInterval(hr);
	obtener_fecha();
	insertarptje("prn", 1, niv, fecha, hora, bien, time, 0);
	ct_ok = bien;
	time_total = time - seg;
	//alert("si");
	alertify.alert("<img/ src='" + resultado_imagen(ct_ok) + "' width='80' height='80'><br>" +
		"<ul id='alertify'>" +
		"<li class='iconbien'><span class='fa fa-check'></span> Aciertos: " + ct_ok + " </li>" +
		"<li class='iconmal'><span class='fa fa-times'></span> Fallos : " + $("#vida").text() + "</li>" +
		"<li class='icontiempo'><span class='fa fa-clock-o'></span> Tiempo: " + time_total + " seg. </li>" +
		"</ul>", function () {
			//obtener_ptje(des,sem,nivel);
			reiniciar();
		});
}
function resultado_imagen(cant) {
	let pathImg = "../../img/";
	x = (cant * 100) / lim;
	img = "";
	if (x < 50) {
		img = pathImg + "semilla.svg";
	}
	else {
		if (x < 90) {
			img = pathImg + "brote.svg";
		}
		else {
			if (x < 99) {
				img = pathImg + "flor.svg";
			}
			else {
				img = pathImg + "premio.svg";
			}
		}
	}
	return img;
}
function obtener_fecha(argument) {
	var f = new Date();
	hora = f.getHours() + ":" + f.getMinutes() + ":" + f.getSeconds();
	fecha = f.getDate() + "/" + (f.getMonth() + 1) + "/" + f.getFullYear();
	//alert(hora+"-"+fecha);
}
function obtener_abc(nro) {
	z = "";
	if (niv == 1) {
		z = nro;
	}
	if (niv == 2) {
		nro--;
		z = String.fromCharCode(nro + 65);
	}
	if (niv == 3) {
		while (nro >= 10) {
			z = z + "X";
			nro = nro - 10;
		}
		if (nro == 9) {
			z = z + "IX";
			nro = nro - 9;
		}
		if (nro >= 5) {
			z = z + "V";
			nro = nro - 5;
		}
		if (nro == 4) {
			z = z + "IV";
			nro = nro - 4;
		}
		while (nro > 0) {
			z = z + "I";
			nro = nro - 1;
		}
	}
	return z;
	//alert(dato);
}