var c=$('#slider_juego');
var s=c.find('section');
var n=s.length;
var lf=0;
var tipoJuego=0;

var fecha,
	hora,
	vl,
	audio;

var sound1;
var my_media = null;
var mediaTimer = null;

function mostrar_slider ()
{
	//----- slider--------------
	c.wrapInner('<div class="slider_inner_juego" />')
	ci = $('.slider_inner_juego');
	ci.css('width',100*n+'%');
	s.css('width',100/n+'%');
	//------ fin slider --------

	//ci.css('left','-200%');
} 
function reiniciar_slider (argument)
{
	lf=0;
	ci.css('left','0%');	
}
function restablecer_botones (nroBtn,nombreBtn)
{
	for (var i = 0; i < nroBtn; i++)
	{
		document.getElementById(nombreBtn+''+i).disabled=false;
		document.getElementById(nombreBtn+''+i).style.backgroundColor='#E9E9E9';
		document.getElementById(nombreBtn+''+i).style.color='#666666';
	}
}
function tiempo()
{
	seg = document.getElementById('seg').innerHTML;
	if(seg==0)
	{
		clearInterval(hr);
		resultado();		
	}
	else
	{
		seg--;
	}
	document.getElementById("seg").innerHTML=seg;
}
function bien()
 { 
 	$("#panelbien").show();
	$("#panelbien").delay(200).hide(150);
 }
 function mal()
{
 	$("#panelmal").show();
	$("#panelmal").delay(200).hide(150);
}
function sonido ()
{
	
}
function onStatus (estado) {
	//alert("estado");
	if(estado == Media.MEDIA_STOPPED) {
		 my_media.play();
		 my_media.loop = true;
    }
}
function playAudio (argument)
{
	// my_media = new Media('/android_asset/www/audio/ranita.mp3', onSuccess, onError,onStatus);
	my_media = new Audio('../audio/ranita.mp3', onSuccess, onError,onStatus);
	my_media.play();
	my_media.loop = true;	
}
function pauseAudio() {
    if (my_media) {
        my_media.pause();
        //alert("pausadoooo");  
    }
     
}
function stopAudio() {
    if (my_media) {
        my_media.stop();
        //alert("stopppp");
    }
    //mediaTimer = null;   
}
function onSuccess() {
    console.log("playAudio():Audio Success");
}
function onError(error) {
    console.log('code: '    + error.code    + '\n' +
         'message: ' + error.message + '\n');
}
function aleatorio(min, max, tope,vec)
{
	contv=0;
	vec=[];
	var num= Math.floor(Math.random()*(max-min+1))+min;

	while(contv<tope)
	{
		if (vec.indexOf(num)==-1) 
		{
			vec[contv]=num; contv++;
		}
		else
		{
			num= Math.floor(Math.random()*(max-min+1))+min;	
		}
	}
	// alert(vec);
	 return vec;
}
function restablecerPanel(tiporef,cant,nombre,letra)
{
	for (var i = 0; i < cant; i++)
	{
		$(""+tiporef+nombre+i).text(letra);
	}
}
function restablecerColorBtn (tiporef,cant,nombre)
{
	for (var i = 0; i < cant; i++)
	{		
		$(''+tiporef+nombre+i).css({'background':'#9BCDFF','color':'#fff'});
	}
	//console.log("colr defecto");	
}
function restablecerColorBoton (tiporef,nombre){
	$(''+tiporef+nombre).css({'background':'#9BCDFF','color':'#fff'});
}
function desbloqueoBoton (tiporef,cant,nombreId)
{
	for (var i = 0; i < cant; i++) {
		$(""+tiporef+nombreId+i).attr('disabled',false);
	}
}
function pintarBoton(tiporef,idbtnColor,color)
{
	$(''+tiporef+idbtnColor).css({'background':color,'color':'#fff'});
}
function bloqueoBoton (tipoid,nombreId)
{
	$(""+tipoid+nombreId).attr('disabled',true);
}
function desbloqueo_x_Boton (tipoid,nombreId)
{
	$(""+tipoid+nombreId).attr('disabled',false);
}

function mostrarImagen(tipoRef,idimg,tiempoMostrar,tiempoOcultar)
{
	//console.log('--> '+tipoRef+idimg);
	$(''+tipoRef+idimg).show();
	$(""+tipoRef+idimg).delay(250).hide(150);	
}
function obtener_fecha (argument)
{
	var f=new Date();
	hora=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds();
	fecha=f.getDate()+"/"+f.getMonth()+1+"/"+f.getFullYear();
}

function resultado_imagen (cantTotal,cantAcierto)
{
	porcentaje = (cantAcierto*100)/cantTotal;
	img="";
	if (porcentaje < 50)
	{
		img="../img/mal_res.png";
	}
	else
	{
		if (porcentaje < 70)
		{
			img="../img/reg_res.png";
		}
		else
		{
			if (porcentaje <= 90)
			{
				img="../img/bien_res.png";
			}
			else
			{
				img="../img/ex_res.png";
			}
		}		
	}	
	return img;	
}

function velpal (vl)
{
	vl=(100*60)/((100*vl)/1000);
 	vl=Math.round(vl);
	return vl;
}
/*--------------------------------------------*/

function Prog (){

   	
	seg++;
	if(seg<10)
		seg="0"+seg;
	document.getElementById("seg").innerHTML=seg;
	if (seg>99) 
   	{
   		fin_tiempo();
   		
   	}
}

function Ini_Prog(segx) {

  	seg=segx;
  	hr=setInterval(Prog,1000);
}

function Regre () {
	if(seg==0)
	{
		if(min==0)
		{
           fin_tiempo();
           if (bandera==1) 
           {
           	mostrar_resp();
           }       		
		}
		else
		{
			seg=59;
			min=min-1;			
		}
	}
	else
	{
		seg--;
		if(seg<10)
			seg="0"+seg;
	}
	document.getElementById("seg").innerHTML=seg;
}
function Ini_Regre(minx,segx) {
  min=minx;
  seg=segx;
  hr=setInterval(Regre,1000);
}
function fin_tiempo()
{
	clearInterval(hr);
	clearInterval(hrj);
	hr=0;
	hrj=0;
	
	document.getElementById("seg").innerHTML="20";
	if (bandera==2) 
	{	fin_juego();
	}
	if (bandera==3) 
	{
	fin_juego();
	}
	if (bandera==4) 
	{
	fin_juego();
	}
	if (bandera==5) 
	{//alert("syii");
	fin_juego();
	}
}

function hora_juego()
{
  	if(segj==59)
	{
		minj++;
		segj=0;		
	}
	else
	{
		segj++;
		if(segj<10)
			segj="0"+segj;
	}
   	mostrar_s2ej2_1();
}

function Ini_juego(miny,segy,timex){
  minj=miny;
  segj=segy;
  hrj=setInterval(hora_juego,timex);
}
function deshabilitar_boton(ini,lim, letra)
 {
 	for (var i = ini; i < lim; i++) 
 	{
 		document.getElementById(letra+i).disabled=false;
 		document.getElementById(letra+i).style.backgroundColor='#E9E9E9';
		document.getElementById(letra+i).style.color='#000000';
 	}
}
function mostrarNota (tiempo,tiempoJuego,resptotal,respEchas)
{
	alertify.alert("<img/ src='"+puntaje(respEchas,resptotal)+"'><br>"+
					"<ul id='alertify'>"+
						"<li class='iconbien'><span class='fa fa-check'></span> Aciertos: "+respEchas+'/'+resptotal+" </li>"+
						"<li class='iconmal'><span class='fa fa-times'></span> Fallos : "+$('#vida').text()+"</li>"+
						"<li class='icontiempo'><span class='fa fa-clock-o'></span> Tiempo: "+tiempoJuego+" seg. </li>"+						
					"</ul>", function () { 
    	reiniciar();       
   });
}
function puntaje (nota,cant)
{
	x=(nota*100)/cant;

	img="";
	if (x<50)
	{
		img="../img/mal_res.png";
	}
	else
	{
		if (x<90)
		{
			img="../img/reg_res.png";
		}
		else
		{
			if (x<99)
			{
				img="../img/bien_res.png";
			}
			else
			{
				img="../img/ex_res.png";
			}
		}		
	}	
	return img;
}
function barajear (vecDato,longitud)
{
	for (var i = 0; i < longitud*3; i++) {
		x = Math.floor(Math.random()*longitud);
		y = Math.floor(Math.random()*longitud);

		aux = vecDato[x];
		vecDato[x] = vecDato[y];
		vecDato[y]= aux; 
	}
}