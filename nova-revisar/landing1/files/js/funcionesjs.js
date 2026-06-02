$(function () {

    $('.enviar').click(function () {

        var ruta = $(this).attr('data-url');
        var formulario = $("#formulario").serialize();
        if (formulario != '') {
            $.ajax({
                type: "post",
                url: ruta,
                data: formulario,
                beforeSend: function () {
                },
                success: function (data) {
                    console.log(data);
                    if (data == true)
                    {
                        location.href = $('.url').html() + 'resultado';
                    }
                }
            });
        } else {
            alert('debe seleccionar una respuesta');
        }

    });
//    configurar el tiempo del slider
//            $('#carouselExampleFade').carousel({
//        interval: 1800
//    });

});
function mostrarTexto() {
    $(".box-agenda-desc").show("slow");
    $(".leer-mas").css("display", "none");
    return false;
}