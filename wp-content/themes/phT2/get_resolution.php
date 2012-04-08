<?php
/*
Template Name: Resolution helper
*/

//Based on http://www.phpbuddy.com/article.php?id=8
//and http://www.w3schools.com/js/js_cookies.asp
//and http://www.quirksmode.org/js/cookies.html

setcookie("pbr_test_cookies","pbr",time()+3600 ,"/"); //this is set to force a cookie to exists if browser accepts cookies, then we can manage resulotions
//if(!isset($_COOKIE["pbr2_screen_res"]) && phT_autoresolution) {
if(phT_autoresultion) { ?>
	<script language="javascript" type="text/javascript">
	<!--
	if (document.cookie.length>0) {
        var x = readCookie('pbr2_screen_res');
        var rw = false;
        if (x) {
        	if (x!=screen.width+"x"+screen.height) rw = true;
        } else {
            rw = true;
        }
		if (rw) writeCookie();
	}
	
	function writeCookie() {
        var the_date = new Date();
        the_date.setDate(the_date.getDate()+100);
        var the_cookie_date = the_date.toGMTString();
        var the_cookie = "pbr2_screen_res="+ screen.width+"x"+screen.height;
        var the_cookie = the_cookie + "; expires=" + the_cookie_date + "; path=/";
        document.cookie=the_cookie
         
        location = '<?php echo $_SERVER['REQUEST_URI']; ?>';
	}
	
	function readCookie(name) {
    	var nameEQ = name + "=";
    	var ca = document.cookie.split(';');
    	for(var i=0;i < ca.length;i++) {
    		var c = ca[i];
    		while (c.charAt(0)==' ') c = c.substring(1,c.length);
    		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    	}
	return null;
    }
    
	//-->
	</script>
<?php } ?>