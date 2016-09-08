var n_pp = jQuery.noConflict();
n_pp(document).ready(function() {
	
	//$('.button').click(function() {
		
		//type = $(this).attr('data-type');
		
		n_pp('.overlay-container').fadeIn(function() {
			
			window.setTimeout(function(){
				n_pp('.window-container.zoomout').addClass('window-container-visible');
			}, 100);
			
		});
	//});
	
	n_pp('.cerrar').click(function() {
		n_pp('.overlay-container').fadeOut().end().find('.window-container').removeClass('window-container-visible');
	});
	
});