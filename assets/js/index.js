const mediaQuery = window.matchMedia('(max-width: 576px)');

$(document).ready(function () {

	var nav = $("header nav.navbar");
	console.log('mediaQuery.matches ',mediaQuery.matches);
	if (mediaQuery.matches) {
		nav.css({
			'width': '100%',
			'z-index': '99',
			'top': '0',
			'position': 'fixed'
		});
	} else {
		nav.css({
			'width': '100%',
			'top': 'auto',
			'position': 'relative'
		});
	}
});