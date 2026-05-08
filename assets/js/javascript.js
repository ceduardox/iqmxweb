//http://tympanus.net/Development/HoverEffectIdeas/index2.html

$(document).ready(function() {
	
	  $('.windowOpen').on('click', function(e) {
		e.preventDefault();
		var el = $(this),
		popup = el.attr('id'),
		link = el.attr('href'),
		w = 700,
		h = 400;
	
		window.open(link, popup, 'width=' + w + ', height=' + h);
	  });
  
    var offset = 200;
    var duration = 500;
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.scroll-to-top').fadeIn(duration);
        } else {
            jQuery('.scroll-to-top').fadeOut(duration);
        }
    });
    jQuery('.scroll-to-top').click(function (event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    }); 
 
  //window and animation items
  var animation_elements = $.find('.animation-element');
  var web_window = $(window);
//check to see if any animation containers are currently in view
function check_if_in_view() {
	//get current window information
	var window_height = web_window.height();
	var window_top_position = web_window.scrollTop();
	var window_bottom_position = (window_top_position + window_height);
	
	//iterate through elements to see if its in view
	$.each(animation_elements, function() {
		//get the element sinformation
		var element = $(this);
		var element_height = $(element).outerHeight();
		var element_top_position = $(element).offset().top;
		var element_bottom_position = (element_top_position + element_height);
		
		//check to see if this current container is visible (its viewable if it exists between the viewable space of the viewport)
		if ((element_bottom_position >= window_top_position) && (element_top_position <= window_bottom_position)) {
			element.addClass('in-view');
		} else {
			element.removeClass('in-view');
		}
	});

}


  //on or scroll, detect elements in view
  $(window).on('scroll resize', function() {
      check_if_in_view(); 
    })
    //trigger our scroll event on initial load
  $(window).trigger('scroll');

    // jQuery.validator.addMethod("alphanumeric", function (value, element) {
    //     return this.optional(element) || /^[a-zA-Z0-9\n\-'àèìòù: <_,. !?()]*$/.test(value);
    // }, "Sólo alfanumérico");

    // jQuery.validator.addMethod("numeric", function (value, element) {
    //     return this.optional(element) || /^[0-9\n\-'àèìòù: <_,. !?()]*$/.test(value);
    // }, "Sólo numérico");

    // jQuery.validator.addMethod("string", function (value, element) {
    //     return this.optional(element) || /^[a-zA-Z ñÑáÁéÉíÍóÓúÚ]*$/.test(value);
    // }, "Sólo texto");


});

function showRequest(formData, jqForm, options) {
    txt = "enviando...";
    var formID = jqForm.attr("id");
    deshabilitarInputs(formID);
    $("#" + formID + " .retorno").html(txt);
    $("#" + formID + " .retorno").fadeIn();
	$("#" + formID + " .retorno").removeClass("error");
	$("#" + formID + " .retorno").removeClass("susses");
}

function showResponse(responseText, statusText, xhr, form) {
    var formID = form.attr('id');
    var obj = JSON.parse(responseText);
    habilitarInputs(formID);
    $("#" + formID + " .retorno").html(obj['mensaje'])
    if (obj['estado'] == 0) {		
        $("#" + formID + " .retorno").addClass("susses");
        $("#" + formID).reset();
		if(typeof(this.redirect)!="undefined" && this.redirect!="") {
 			window.location.href = this.redirect;
		}
    } else if (obj['estado'] == -1) {
        window.location.reload(true);
    } else {
        $("#" + formID + " .retorno").addClass("error");
    } 
}

function deshabilitarInputs(formId) {
    var Forma = document.getElementById(formId);
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

function buscar() {
	var q = $.trim($('#form_q #q').val());
	location.href = 'blog?q='+q;
}

function cargarImagenes(){
    $("img.post-cargador").each(function(){
        $(this).attr('src', $(this).data('src')).load(function(){
            $(this).fadeIn();
        });
    })  
}
