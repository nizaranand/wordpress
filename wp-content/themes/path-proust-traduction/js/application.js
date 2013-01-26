
var $j = jQuery.noConflict();
$j(document).ready(function(event){

	//liens reseaux sociaux
	$j("#footer p  a img").hover(
		function () {
			$j(this).css("opacity", "1");
		},
		function () {
			$j(this).css("opacity", "0.65");
		}

		);   

	//back to top
	$j('.pull-right [href^=#]').click(function (e) {
		e.preventDefault();
		$j('html, body').animate({scrollTop: '0px'}, 300);
	})


    //hack location href
    if (window.location.pathname.indexOf("/fr") != -1){
    	$j("#select-language").val("fr");
    }
    else if (window.location.pathname.indexOf("/de") != -1){
    	$j("#select-language").val("de");
    }
    else if (window.location.pathname.indexOf("/en") != -1){
    	$j("#select-language").val("en");
    }


	//change language
	$j("#select-language").change(function (){
		var oldLocale;
		if (window.location.pathname.indexOf("/fr/") != -1){
			oldLocale = "fr";
		}
		else if (window.location.pathname.indexOf("/en/") != -1){
			oldLocale = "en";
		}
		else if (window.location.pathname.indexOf("/de/") != -1){
			oldLocale = "de";
		}
		else {
			oldLocale = "fr";

		}
		var host = window.location.href.split(oldLocale)[0];
		var locale =  $j("#select-language").val();
		var query = window.location.href.split(oldLocale)[1];

		if (query != null) {
			window.location.href = host+locale+query;
		}
		else {
			window.location.href = host+locale;
		}

	});

	//liens externes
	$j("#footer a.external").hover(
		function () {
			$j(this).css("background-color", "#EA8916");
			$j(this).append($j("<img style='opacity:0.6;margin-left:5px' class='external' src='/wordpress/wp-content/themes/path-proust-traduction/img/fleche_b.png'>"));
		}, 
		function () {
			$j(this).css("background-color", "#000000");
			$j(this).find("img:last").remove();
		}
		);

	$j("a.external").click(
		function () {
			$j(this).attr('target','_blank');
		}
		);



	//sidebar effect
	var $scrollingDiv = $j("#scrollingDiv");

	$j(window).scroll(function(){      
		$scrollingDiv
	  // chercher sur la doc jquery comment empecher le scroll a l infinii
	  .stop()
	  .animate({"marginTop": ($j(window).scrollTop()) + "px"}, 0 );      
	});


}); 