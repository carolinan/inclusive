/**
 *  custom js for the theme
 * 
 */
jQuery(document).ready(function ($) {
	if ( $('#toTop').length > 0 ) {
	    $("#toTop").css("display", "none");
	      $(window).scroll(function(){
	        if($(window).scrollTop() > 0){
	          $("#toTop").fadeIn("slow");
	      }
	      else {
	          $("#toTop").fadeOut("slow");
	      }
	  	});
		jQuery("#toTop").click(function(event){
			event.preventDefault();
			jQuery("html, body").animate({
				scrollTop:0
			},"slow");
		});
  	}
} );