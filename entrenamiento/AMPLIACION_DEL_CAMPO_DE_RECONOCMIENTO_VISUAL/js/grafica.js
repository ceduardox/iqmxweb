var semana,
    subNombre,
    codigo,
    nroBotones,
    modulo;


ini=$(document);
ini.ready(inicia);

function inicia()
{
    FastClick.attach(document.body);
    document.addEventListener("deviceready", onDeviceReady, false);    
    mostrar_slider();
    datos_juego();
    iniciobase();
    informacion_juego();
    activarBoton('btn0');
    //ci.css('left','-200%');   
}
function onDeviceReady() {
    // Register the event listener
    document.addEventListener("backbutton", onBackKeyDown, false);
}

function onBackKeyDown() {
    $(location).attr('href',modulo);
}
function atras (argument) {
    $(location).attr('href',modulo);
}
function datos_juego (argument)
{
    var url= window.location.search.substr(1);    
    valor=url.split("=");   
    v=valor[1];
    v=v.split("_");
    semana = v[0];
    codigo = v[1];
    subNombre = v[2];
    nroBotones = v[3];
    modulo = urls (semana,codigo);
    console.log("-->"+modulo);
    mostrarBotones(nroBotones);

}
function mostrarBotones (nro) {
    console.log("======>", nro*100);
    //ci.css('left','-'+(nro*100)+'%');
    for (var i =nro; i < 4; i++) {
        $("#btn-nivel-graf"+i).css('left','-'+(nro*100)+'%');
    }
}
function informacion_juego ()
{
    consulta_grafica(codigo,semana,1);
    console.log(codigo+" "+semana);
}
function nivelGrafica (nivel)
{
    console.log("nivel: "+nivel);
    desactivarBoton(nroBotones+1);
    activarBoton("btn"+(nivel-1));
    consulta_grafica(codigo,semana,nivel);
}
function graficar ()
{
    //alert(123);
    lineChartData = {
            labels : [1,2,3,4,5,6,7,8,9,10],
            datasets : [
                {
                    label: "My First dataset",
                    fillColor : "rgba(220,220,220,0.3)",//fondo grafica
                    strokeColor : "#0080FF",//linea
                    pointColor : "#0080FF",// color puntos 
                    pointStrokeColor : "#fff",// border puntos
                    pointHighlightFill : "#6BCB24",
                    pointHighlightStroke : "#6BCB24",
                    data : pal
                }
            ]
        }  
    ctx = document.getElementById("canvas").getContext("2d");
    myLine = new Chart(ctx).Line(lineChartData, {
            responsive: true
        }); 
       //alert(min);    
}
function activarBoton (btn)
{
    desactivarBoton (nroBotones);
    $('.'+btn).removeClass('botonDesactivo');
    $('.'+btn).addClass('botonActivo');
}
function desactivarBoton (nro)
{
    for (var i = 0; i < nro; i++) {
        $('.btn'+i).addClass('botonDesactivo');
        $('.btn'+i).removeClass('botonActivo');
    }
}
