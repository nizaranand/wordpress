<?php
/*
Template Name: Configuration options
*/

define("phT_autoresolution", true); // autoresolution will cause your picts and theme adapt to visitor's screen resolution


define("phT_Kx",800); //x_resolution for final image, the css and images will change based on this setting
define("phT_Ky",600); //y_resolution for final image
//phT_K setting sets the maximum resolution you wolud like to show your photos, even autoresolution is on

define("phT_tx",100); //thumbs resolution the css will change based on this setting
define("phT_ty",100); //thumbs resolution the css will change based on this setting
//if tx & tx are equals pht will generate square thumbs

define("phT_body_background","#000 url(".get_template_directory_uri()."/images/logo.gif) no-repeat top right");
define("phT_body_color","#777");

define("phT_page_color_background","#111");
define("phT_page_color","#777");

define("phT_content_background","#DDD");
define("phT_content_color","#888");

define("phT_space","5");
define("phT_border_img","1px solid #000");
define("phT_border_comment","1px solid #222");
define("phT_border_comment_texta","1px solid #222");
define("phT_border_content","1px solid #AAA");

define("phT_a","#888");
define("phT_a_visited","#999");
define("phT_a_hover","#FFF");

define("phT_comment_color_background","#000");
define("phT_comment_input_color_background","#333");
define("phT_comment_color","#BBB");
define("phT_comment_texta_color_background","#DDD");

define("phT_favicon", get_template_directory_uri()."/images/favicon.ico");



define("phT_footer",'
<div style="float:center;text-align:center;margin-top:5px;">
<a href="http://photoblogs.org/">
<img src="'.get_template_directory_uri().'/images/photoblogs.gif" alt="photoblogs.org" />
</a></div>');
define("phT_mosaic_string","mosaic");
define("phT_mosaic","/?cat=".get_option('default_category'));
define("phT_prev_arrow",_("&laquo; Previous"));
define("phT_next_arrow",_("Next &raquo;"));

define("phT_exif",true); // don't use...
?>