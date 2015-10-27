$(document).ready( function() {	
	$( "#rwdMenuButton" ).click( function() {
		if( $( "#menuRWD" ).css( "display" ) == "none" ) {
			$( "#menuRWD" ).fadeIn( 'medium' );
		}
		else {
			$( "#menuRWD" ).fadeOut( 'medium' );
		}
	});
	  
	$( "#footer-content-footer-middle-up" ).click( function() {
		$('html,body').animate({
		  scrollTop: 0
		}, 1000);
	});
});
/*$(document).keyup(function(e){if(e.which==49)alert($(window).width()+20);});*/