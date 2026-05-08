function slug(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/,:;";
    var to = "aaaaaeeeeeiiiiooooouuuunc-----";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '_') // collapse whitespace and replace by -
            .replace(/-+/g, '_'); // collapse dashes

    return str;
}

function trim(myString) {
    return myString.replace(/^\s+/g, '').replace(/\s+$/g, '')
}

function validaEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test($email);
}

function showRequest(formData, jqForm, options) {
    txt = '<i class="fa fa-refresh  fa-spin fa-1x fa-fw"></i> enviando...';
    var formID = jqForm.attr("id");
    deshabilitarInputs(formID);
    $("#" + formID + " .alert").html(txt);
    $("#" + formID + " .alert").fadeIn();
    $("#" + formID + " .alert").removeClass("bg-danger");
    $("#" + formID + " .alert").removeClass("hidden");
    $("#" + formID + " .alert").addClass("alert-warning");
    $("#" + formID + " .alert").removeClass("bg-susses");
}


function setTextArea(FORM, T_DETALLE_HIDDEN, T_DETALLE) {
    var ed = tinymce.get(T_DETALLE_HIDDEN);
    $('#' + T_DETALLE).val(ed.getContent());
    $('#' + FORM).submit();
}

function showResponseSesion(responseText, statusText, xhr, form) {
    var formID = form.attr('id');
    var obj = JSON.parse(responseText);
    habilitarInputs(formID);
	//alert(obj['mensaje'])
    $("#" + formID + " .alert").addClass(obj['class']);
    $("#" + formID + " .alert").removeClass('hidden');
    $("#" + formID + " .alert").html(obj['mensaje']);
    $("#" + formID).reset();
    if (obj['estado'] == 1) {
        location.href = 'index';
    }
}

function showResponse(responseText, statusText, xhr, form) {
    var formID = form.attr('id');
    var obj = JSON.parse(responseText);
    var msje = '';
    habilitarInputs(formID);

    if (obj['estado'] == 0) {
        $("#" + formID).reset();
    } else if (obj['estado'] == -1) {
        window.location.reload(true);
    } else if (obj['estado'] == true) {
        //obj['mensaje'] = "Guardado con éxito"; 
        $("#" + formID).find("button[name=cancelar]").click();
    } else {
        msje = 'Error:<br>';
    }
    $("#" + formID + " .alert").removeClass('alert-success');
    $("#" + formID + " .alert").removeClass('alert-info');
    $("#" + formID + " .alert").removeClass('alert-warning');
    $("#" + formID + " .alert").removeClass('alert-danger');
    $("#" + formID + " .alert").addClass(obj['class']);
    $("#" + formID + " .alert").removeClass('hidden');
    $("#" + formID + " .alert").html(msje + obj['mensaje']); 
}

function deshabilitarInputs(formId) {
    Forma = document.getElementById(formId);
    Elementos_input = Forma.getElementsByTagName("input");
    Elementos_textarea = Forma.getElementsByTagName("textarea");

    for (i = 0; i < Elementos_input.length; i++) {
        if (Elementos_input[i].type == "button" || Elementos_input[i].type == "submit" || Elementos_input[i].type == "checkbox") {
            Elementos_input[i].disabled = true;
        } else {
            Elementos_input[i].readOnly = true;
        }
    }

    for (j = 0; j < Elementos_textarea.length; j++) {
        Elementos_textarea[j].readOnly = true;
    }
}

function habilitarInputs(formId) {
    Forma = document.getElementById(formId);
    Elementos_input = Forma.getElementsByTagName("input");
    Elementos_textarea = Forma.getElementsByTagName("textarea");

    for (i = 0; i < Elementos_input.length; i++) {
        if (Elementos_input[i].type == "button" || Elementos_input[i].type == "submit" || Elementos_input[i].type == "checkbox") {
            Elementos_input[i].disabled = false;
        } else {
            Elementos_input[i].readOnly = false;
        }
    }

    for (j = 0; j < Elementos_textarea.length; j++) {
        Elementos_textarea[j].readOnly = false;
    }
}

jQuery.fn.reset = function () {
    $(this).each(function () {
        this.reset();
    });
}

function settingCalendar() {
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        changeMonth: true,
        changeYear: true
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
}

function eliminar(cod, accion) {
    if (confirm('¿Eliminar el registro?')) {
        $.get('ajax', {cod: cod, accion: accion}, function (data) {
            var obj = JSON.parse(data);
            if (obj['estado'] == true) {
                window.location.reload(true);
            } else {
				alert(obj['mensaje']);
			}
        });
    }
}

function activo(estado, cod, accion) {
    if (confirm('¿Desea realizar el cambio de estado?')) {
        $.get('ajax', {estado: estado, cod: cod, accion: accion}, function (data) {
            var obj = JSON.parse(data);
            if (obj['estado'] == true) {
                window.location.reload(true);
            } else {
				alert(obj['mensaje']);	
			}
        });
    }
}

function activate(cod, accion, active) {
    if (confirm('¿Desea realizar el cambio de estado?')) {
        $.get('ajax', {active: active, cod: cod, accion: accion}, function (data) {
            var obj = JSON.parse(data);
            if (obj['estado'] == true) {
                window.location.reload(true);
            } else {
				alert(obj['mensaje']);	
			}
        });
    }
}