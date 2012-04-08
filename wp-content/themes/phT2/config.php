<?php
/*
Template Name: Configuration options
*/

$pht_tmp=(get_option("phT_autoresolution")=="true") ;
define("phT_autoresolution", $pht_tmp); 

define("phT_Kx",get_option("phT_Kx")); 
define("phT_Ky",get_option("phT_Ky")); 


define("phT_tx",get_option("phT_tx")); 
define("phT_ty",get_option("phT_ty")); 


define("phT_body_background",get_option("phT_body_background"));
define("phT_body_color",get_option("phT_body_color"));

define("phT_page_color_background",get_option("phT_page_color_background"));
define("phT_page_color",get_option("phT_page_color"));

define("phT_content_background",get_option("phT_content_background"));
define("phT_content_color",get_option("phT_content_color"));

define("phT_space",get_option("phT_space"));
define("phT_border_img",get_option("phT_border_img"));
define("phT_border_comment",get_option("phT_border_comment"));
define("phT_border_comment_texta",get_option("phT_border_comment_texta"));
define("phT_border_content",get_option("phT_border_content"));

define("phT_a",get_option("phT_a"));
define("phT_a_visited",get_option("phT_a_visited"));
define("phT_a_hover",get_option("phT_a_hover"));

define("phT_comment_color_background",get_option("phT_comment_color_background"));
define("phT_comment_input_color_background",get_option("phT_comment_input_color_background"));
define("phT_comment_color",get_option("phT_comment_color"));
define("phT_comment_texta_color_background",get_option("phT_comment_texta_color_background"));

define("phT_favicon", get_option("phT_favicon"));

define("phT_mosaic",get_option("phT_mosaic"));
define("phT_mosaic_string",get_option("phT_mosaic_string"));
define("phT_prev_arrow",get_option("phT_prev_arrow"));
define("phT_next_arrow",get_option("phT_next_arrow"));


define("phT_footer",get_option("phT_footer"));


define("phT_exif",false); // don't use...
?>