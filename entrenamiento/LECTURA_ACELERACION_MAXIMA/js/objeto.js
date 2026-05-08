var c = $('#slider_juego');
var s = c.find('section');
var n = s.length;
var lf = 0;
var tipoJuego = 0;
function mostrar_slider() {
	//----- slider--------------
	c.wrapInner('<div class="slider_inner_juego" />')
	ci = $('.slider_inner_juego');
	ci.css('width', 100 * n + '%');
	s.css('width', 100 / n + '%');
	//------ fin slider --------
	//ci.css('left','-200%');
}
function reiniciar_slider(argument) {
	lf = 0;
	ci.css('left', '0%');
}
function restablecer_botones(nroBtn, nombreBtn) {
	for (var i = 0; i < nroBtn; i++) {
		document.getElementById(nombreBtn + '' + i).disabled = false;
		document.getElementById(nombreBtn + '' + i).style.backgroundColor = '#E9E9E9';
		document.getElementById(nombreBtn + '' + i).style.color = '#666666';
	}
}
function tiempo() {
	seg = document.getElementById('seg').innerHTML;
	if (seg == 0) {
		clearInterval(hr);
		if (tipoJuego == 1) {
			controlador();
		}
		if (tipoJuego == 2) {
			fin_juego();
		}
	}
	else {
		seg--;
		if (seg < 10)
			seg = "0" + seg;
	}
	document.getElementById("seg").innerHTML = seg;
}
function bien() {
	$("#panelbien").show();
	$("#panelbien").delay(200).hide(150);
}
function mal() {
	$("#panelmal").show();
	$("#panelmal").delay(200).hide(150);
}