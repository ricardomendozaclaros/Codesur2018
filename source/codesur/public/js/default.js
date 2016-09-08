var n = jQuery.noConflict();
n(document).ready(function(){
n('.countdown').final_countdown({
               'start': 1470682320,
            'end': 1525852800,
            'now': 1470682320        
   });
});
/******mapa******/
	jQuery( document ).ready(function() {
   var info_title = null;
   var info_content = null;
   var inx =null ;
   
	jQuery( "svg polygon" ).mouseover(function() {
		inx = jQuery(this).attr("inx");
		info_title = jQuery("#info_"+inx).attr("title");
		info_content = jQuery("#info_"+inx).html();
		 
		jQuery(".pais-title").show(100);
	}).mouseout(function() {
		jQuery(".pais-title").hide(100);
	}).mousemove(function( event ) {
		var pageCoords = "( " + event.pageX + ", " + event.pageY + " )";
		var clientCoords = "( " + event.clientX + ", " + event.clientY + " )";
		jQuery(".pais-title").css("top",(event.pageY +20)+"px");
		jQuery(".pais-title").css("left",(event.pageX +20)+"px");
		jQuery(".pais-title").html(" <b style='font-weight:bold'>"+info_title+"</b>");

	}).click(function() {
		var inx = jQuery(this).attr("inx");
		
		jQuery(".info_item").hide();
		jQuery("#info_"+inx).show();
		
		//jQuery("svg polygon").removeClass("info_selected");
		//jQuery(this).addClass("info_selected");
		
		jQuery("svg polygon").css("fill","transparent");
		jQuery("svg polygon").css("stroke-width","0");
		
		jQuery(this).css("fill","rgba(56, 255, 1, 0.86)");
		jQuery(this).css("stroke","#FFFFFF");
		jQuery(this).css("stroke-width","3");
		
		_scrollTo("des_mapa");
		
		//alert(jQuery(this));
		
		
	});;
	
	
});


function _scrollTo(anchor){
	var aTag = jQuery("a[name='"+ anchor +"']");
    jQuery('html, body').animate({
        scrollTop: jQuery(aTag).offset().top
    }, 500);
}

/******mapa******/