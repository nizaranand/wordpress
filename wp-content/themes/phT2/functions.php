<?php
/*
Template Name: Functions
*/

if (get_option('phT_autoresolution') == "") {
	$pbr_domain_conifg_file=$_SERVER["HTTP_HOST"]."_config.php";
	$pbr_domain_conifg_file=dirname(__FILE__)."/".$pbr_domain_conifg_file;
	if (file_exists($pbr_domain_conifg_file)) {
		require_once($pbr_domain_conifg_file);
	} else {
		require_once('config_default.inc');
	}
	pht_update_options(); 
}
 
require_once('config.php');

phT_check_resolution();

function phT_check_resolution() {
	//This is a function only for making it readable
	if (phT_autoresolution && isset($_COOKIE["pbr2_screen_res"]) ) {
		$res=$_COOKIE["pbr2_screen_res"];	
		$pbr_screen_res_xy=explode("x",$res);
		$y=$pbr_screen_res_xy[1]-250;	
                if ($y<200) $y=200;
		$x=intval($y/2*3);					
        if ($x>phT_Kx) $x=phT_Kx;
        if ($y>phT_Ky) $y=phT_Ky;
        

	} else { // auto resoltion off
		$x=phT_Kx;
		$y=phT_Ky;
	}
	
	define("phT_x",$x);
	define("phT_y",$y);
	setcookie("pbr2_seted_resolution",phT_x."x".phT_y,time()+3600 ,"/");
}

function phT_isMu() {
	return function_exists("is_site_admin");
}

function phT_isYAPB(){
	return class_exists("Yapb");
}

function phT_imgTag($href,$w,$h,$t) {
	$imgtag='<img src="';
	$imgtag.=$href.'" ';
	$imgtag.='width="'.$w.'" ';
	$imgtag.='height="'.$h.'" ';
	$imgtag.='alt="'.$t.'" title="'.$t.'" />';
	return $imgtag;
}
function phT_getImgTag($post,$size="std") {
	
	$t=get_the_title();
	
	$href="none";
	if ($size=="std") {
		$w=$post->image->width;
		$h=$post->image->height;
		if ($w<=phT_x && $h<=phT_y) {
			if (phT_isMU()) { //TODO: isMu AND usa subdirectorios
				$thumbnailConfig=array('w='.phT_x,'h='.phT_y,'q=100');
			} else {
				$href=$post->image->getFullHref();				
			}
		} else {	
			$thumbnailConfig=array('w='.phT_x,'h='.phT_y,'q=100');
		}
	} else {
		if (phT_tx==phT_ty) { //square thumbs 
	        $thumbnailConfig=array('ws='.phT_tx,'hs='.phT_tx,'q=100','zc=C');
	        $href=$post->image->getThumbnailHref($thumbnailConfig);
			$w=phT_tx;
			$h=phT_tx;
		} else {
			$thumbnailConfig=array('w='.phT_tx,'h='.phT_ty,'q=100');
		}
	}	
	if ($href=="none"){	
		$href=$post->image->getThumbnailHref($thumbnailConfig);
		$w=$post->image->getThumbnailWidth($thumbnailConfig);
		$h=$post->image->getThumbnailHeight($thumbnailConfig);
	}	
	
	$imgtag=phT_imgTag($href,$w,$h,$t);
	
	return $imgtag;
}

function phT_showImage() {
	global $post,$wpdb;
	
	if ($post->image) {
		echo '<div class="img-cont">';

	    $imgtag=phT_getImgTag($post,"std");
	    
		$previous = get_previous_post(false);
		if ($previous) { 
			$previous_link = get_permalink($previous);
		} elseif (is_home()) {
		    // This code is only execute on is_home()...
    	    // From Taly's SimpleT theme http://www.taly.com.ar/simplet adding post_type = 'post'
    	    $sql="SELECT ID FROM $wpdb->posts WHERE post_date < '$post->post_date' AND post_type <> 'page' AND post_status = 'publish' ORDER BY post_date DESC LIMIT 0, 1";
    		$previous = @$wpdb->get_var($sql);
    		if ($previous) { // TODO: This query asumes the previous post has una image...
    			$previous_link = get_permalink($previous); 
    		}		    
		}
		
		$next = get_next_post(false);
		if ($next) { 
			$next_link = get_permalink($next);
		}

		//muestra la imagen
		if ($previous_link) {
			echo '<a href="'.$previous_link.'">'.$imgtag."</a>\n" ;
		} else {
			echo $imgtag."\n";
		}
		echo "</div>\n"; //fin del contenedor de imagen
		

        	
		echo '<div id="navigation" class="inside">'."\n";
		if ($previous_link) {
			echo '<div class="prev"><a href="'.$previous_link.'" title="'._("previous image").'">'.phT_prev_arrow."</a></div>\n";
		}
	    if (phT_exif) {
	        echo '<div class="exif">';
    	    $exif = yapb_get_exif();
            foreach ($exif as $key => $value):
                echo "$key:$value ";
            endforeach;	     				 
            echo "</div>\n";
        }
		if ($next_link) echo '<div class="next"><a href="'.$next_link.'" title="'._("next image").'" >'.phT_next_arrow."</a></div>\n";	
			    
	     
	    echo "</div>\n";

	}
	
}









add_action('admin_menu', 'pht_add_admin');

function pht_add_admin() {
	if ( $_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == $_REQUEST['action'] ) {
			check_admin_referer('phT_save_options');
			update_option( 'phT_autoresolution', strip_tags( stripslashes( $_REQUEST['sr_autoresolution'] ) ) );
			update_option( 'phT_Kx', strip_tags( stripslashes( $_REQUEST['sr_Kx'] ) ) );
			update_option( 'phT_Ky', strip_tags( stripslashes( $_REQUEST['sr_Ky'] ) ) );
			update_option( 'phT_tx', strip_tags( stripslashes( $_REQUEST['sr_tx'] ) ) );
			update_option( 'phT_ty', strip_tags( stripslashes( $_REQUEST['sr_ty'] ) ) );			
			update_option( 'phT_body_background', strip_tags( stripslashes( $_REQUEST['sr_body_background'] ) ) );
			update_option( 'phT_body_color', strip_tags( stripslashes( $_REQUEST['sr_body_color'] ) ) );
			update_option( 'phT_page_color_background', strip_tags( stripslashes( $_REQUEST['sr_page_color_background'] ) ) );
			update_option( 'phT_page_color', strip_tags( stripslashes( $_REQUEST['sr_page_color'] ) ) );
			update_option( 'phT_content_background', strip_tags( stripslashes( $_REQUEST['sr_content_background'] ) ) );
			update_option( 'phT_content_color', strip_tags( stripslashes( $_REQUEST['sr_content_color'] ) ) );
			update_option( 'phT_space', strip_tags( stripslashes( $_REQUEST['sr_space'] ) ) );
			update_option( 'phT_border_img', strip_tags( stripslashes( $_REQUEST['sr_border_img'] ) ) );
			update_option( 'phT_border_comment', strip_tags( stripslashes( $_REQUEST['sr_border_comment'] ) ) );
			update_option( 'phT_border_comment_texta', strip_tags( stripslashes( $_REQUEST['sr_border_comment_texta'] ) ) );
			update_option( 'phT_border_content', strip_tags( stripslashes( $_REQUEST['sr_border_content'] ) ) );
			update_option( 'phT_a', strip_tags( stripslashes( $_REQUEST['sr_a'] ) ) );
			update_option( 'phT_a_visited', strip_tags( stripslashes( $_REQUEST['sr_a_visited'] ) ) );
			update_option( 'phT_a_hover', strip_tags( stripslashes( $_REQUEST['sr_a_hover'] ) ) );
			update_option( 'phT_comment_color_background', strip_tags( stripslashes( $_REQUEST['sr_comment_color_background'] ) ) );
			update_option( 'phT_comment_input_color_background', strip_tags( stripslashes( $_REQUEST['sr_comment_color_background'] ) ) );
			update_option( 'phT_comment_color', strip_tags( stripslashes( $_REQUEST['sr_comment_color'] ) ) );
			update_option( 'phT_comment_texta_color_background', strip_tags( stripslashes( $_REQUEST['sr_comment_texta_color_background'] ) ) );
			update_option( 'phT_favicon', strip_tags( stripslashes( $_REQUEST['sr_favicon'] ) ) );
			update_option( 'phT_footer',  stripslashes($_REQUEST['sr_footer']) );
			update_option( 'phT_mosaic', strip_tags( stripslashes( $_REQUEST['sr_mosaic'] ) ) );
			update_option( 'phT_mosaic_string', strip_tags( stripslashes( $_REQUEST['sr_mosaic_string'] ) ) );
			update_option( 'phT_prev_arrow', stripslashes( $_REQUEST['sr_prev_arrow']  ) );
			update_option( 'phT_next_arrow', stripslashes( $_REQUEST['sr_next_arrow']  ) );
			
			header("Location: themes.php?page=functions.php&saved=true");
			die;
		} else if( 'reset' == $_REQUEST['action'] ) {
			check_admin_referer('phT_reset_options');
			delete_option('phT_autoresolution');
			delete_option('phT_Kx');
			delete_option('phT_Ky');
			delete_option('phT_tx');
			delete_option('pht_ty');
			delete_option('phT_body_background');	
			delete_option('phT_body_color');	
			delete_option('phT_page_color_background');	
			delete_option('phT_page_color');
			delete_option('phT_content_background');	
			delete_option('phT_content_color');
			delete_option('phT_space');
			delete_option('phT_border_img');
			delete_option('phT_border_comment');
			delete_option('phT_border_comment_texta');
			delete_option('phT_border_content');
			delete_option('phT_a');
			delete_option('phT_a_visited');
			delete_option('phT_a_hover');
			delete_option('phT_comment_color_background');
			delete_option('phT_comment_input_color_background');
			delete_option('phT_comment_color');
			delete_option('phT_comment_texta_color_background');
			delete_option('phT_favicon');
			delete_option('phT_footer');
			delete_option('phT_mosaic');
			delete_option('phT_mosaic_string');
			delete_option('phT_prev_arrow');
			delete_option('phT_next_arrow');
			
			header("Location: themes.php?page=functions.php&reset=true");
			die;
		}
		
	}
	add_theme_page( __( 'phT Theme Options', 'phT' ), __( 'Theme Options', 'phT' ), 'edit_themes', basename(__FILE__), 'pht_admin' );
}

function pht_admin() { // Theme options menu 
	if ( $_REQUEST['saved'] ) { ?><div id="message1" class="updated fade"><p><?php printf(__('phT theme options saved. <a href="%s">View site.</a>', 'phT'), get_bloginfo('home') . '/'); ?></p></div><?php }
	if ( $_REQUEST['reset'] ) { ?><div id="message2" class="updated fade"><p><?php _e('phT theme options reset.', 'phT'); ?></p></div><?php } ?>

<div class="wrap">
	<h2><?php _e('phT Theme Options', 'phT'); ?></h2>
	

	<form action="<?php echo wp_specialchars( $_SERVER['REQUEST_URI'] ) ?>" method="post">
		<?php wp_nonce_field('phT_save_options'); echo "\n"; ?>
	
		
		<h3><?php _e('Image display configuration', 'pht'); ?></h3>
		<table class="form-table" summary="phT layout options">
			<tr valign="top">
				<th scope="row"><label for="sr_Kx"><?php _e('X Resolution', 'pht'); ?></label></th> 
				<td>
					<input id="sr_Kx" name="sr_Kx" type="text" class="text" value="<?php if ( get_option('pht_Kx') == "" ) { echo "800"; } else { echo attribute_escape( get_option('pht_Kx') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Allawys in pixels. Default is <span>800</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_Ky"><?php _e('Y Resolution', 'pht'); ?></label></th> 
				<td>
					<input id="sr_Ky" name="sr_Ky" type="text" class="text" value="<?php if ( get_option('pht_Ky') == "" ) { echo "600"; } else { echo attribute_escape( get_option('pht_Ky') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Allawys in pixels. Default is <span>600</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_tx"><?php _e('X Thumb resolution', 'pht'); ?></label></th> 
				<td>
					<input id="sr_tx" name="sr_tx" type="text" class="text" value="<?php if ( get_option('pht_tx') == "" ) { echo "100"; } else { echo attribute_escape( get_option('pht_tx') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Allawys in pixels. Default is <span>100</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_ty"><?php _e('Y Thumb resolution', 'pht'); ?></label></th> 
				<td>
					<input id="sr_ty" name="sr_ty" type="text" class="text" value="<?php if ( get_option('pht_ty') == "" ) { echo "100"; } else { echo attribute_escape( get_option('pht_ty') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Allawys in pixels. When X&Y are equals Thumbs will be squares. Default is <span>100</span>.', 'pht'); ?></p>
				</td>
			</tr>
		</table>
		
		<h3><?php _e('phT Advanced options', 'pht'); ?></h3>
		<table class="form-table" summary="phT typography options">
			<tr valign="top">
				<th scope="row"><label for="sr_autoresolution"><?php _e('Image autoresolution', 'pht'); ?></label></th> 
				<td>
					<select id="sr_autoresolution" name="sr_autoresolution" tabindex="21" class="dropdown">
						<option value="true" <?php if ( get_option('phT_autoresolution') == "true" ) { echo 'selected="selected"'; } ?>><?php _e('True', 'pht'); ?> </option>
						<option value="false" <?php if ( get_option('phT_autoresolution') == "false" ) { echo 'selected="selected"'; } ?>><?php _e('Flase', 'pht'); ?> </option>
					</select>
					<p class="info"><?php _e('Autoresolution will cause your picts and theme adapt to visitor\'s screen resolution. Default is <span>true</span>.', 'pht'); ?></p>
				</td>
			</tr>
		</table>	
				
		
		<h3><?php _e('General theme options: colors, backgrounds and icons', 'pht'); ?></h3>
		<table class="form-table" summary="phT layout options">
			<?php $pht_tmp_delafult="#000 url(".get_template_directory_uri()."/images/logo.gif) no-repeat top right"; ?>
			<tr valign="top">
				<th scope="row"><label for="sr_body_background"><?php _e('Background', 'pht'); ?></label></th> 
				<td>
					<input id="sr_body_background" name="sr_body_background" type="text" class="text" value="<?php if ( get_option('phT_body_background') == "" ) { echo $pht_tmp_delafult; } else { echo attribute_escape( get_option('phT_body_background') ); } ?>" tabindex="20" size="100" />
					<p class="info"><?php _e('Default is <span>'.$pht_tmp_delafult.'</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_body_color"><?php _e('Body color', 'pht'); ?></label></th> 
				<td>
					<input id="sr_body_color" name="sr_body_color" type="text" class="text" value="<?php if ( get_option('phT_body_color') == "" ) { echo "#777"; } else { echo attribute_escape( get_option('phT_body_color') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#777</span>.', 'pht'); ?></p>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><label for="sr_page_color_background"><?php _e('Page background color', 'pht'); ?></label></th> 
				<td>
					<input id="sr_page_color_background" name="sr_page_color_background" type="text" class="text" value="<?php if ( get_option('phT_page_color_background') == "" ) { echo "#111"; } else { echo attribute_escape( get_option('phT_page_color_background') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#111</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_page_color"><?php _e('Page color', 'pht'); ?></label></th> 
				<td>
					<input id="sr_page_color" name="sr_page_color" type="text" class="text" value="<?php if ( get_option('phT_page_color') == "" ) { echo "#777"; } else { echo attribute_escape( get_option('phT_page_color') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#777</span>.', 'pht'); ?></p>
				</td>
			</tr>	
			
			<tr valign="top">
				<th scope="row"><label for="sr_content_background"><?php _e('Content background color', 'pht'); ?></label></th> 
				<td>
					<input id="sr_content_background" name="sr_content_background" type="text" class="text" value="<?php if ( get_option('phT_content_background') == "" ) { echo "#DDD"; } else { echo attribute_escape( get_option('phT_content_background') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#DDD</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_content_color"><?php _e('Content color', 'pht'); ?></label></th> 
				<td>
					<input id="sr_content_color" name="sr_content_color" type="text" class="text" value="<?php if ( get_option('phT_content_color') == "" ) { echo "#888"; } else { echo attribute_escape( get_option('phT_content_color') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#888</span>.', 'pht'); ?></p>
				</td>
			</tr>		

			<tr valign="top">
				<th scope="row"><label for="sr_space"><?php _e('Space betwen header and photo', 'pht'); ?></label></th> 
				<td>
					<input id="sr_space" name="sr_space" type="text" class="text" value="<?php if ( get_option('phT_space') == "" ) { echo "5"; } else { echo attribute_escape( get_option('phT_space') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>5</span>.', 'pht'); ?></p>
				</td>
			</tr>
											
			<tr valign="top">
				<th scope="row"><label for="sr_border_img"><?php _e('Images border', 'pht'); ?></label></th> 
				<td>
					<input id="sr_border_img" name="sr_border_img" type="text" class="text" value="<?php if ( get_option('phT_border_img') == "" ) { echo "1px solid #000"; } else { echo attribute_escape( get_option('phT_border_img') ); } ?>" tabindex="20" size="20" />
					<p class="info"><?php _e('Default is <span>1px solid #000</span>.', 'pht'); ?></p>
				</td>
			</tr>	
			
			<tr valign="top">
				<th scope="row"><label for="sr_border_comment"><?php _e('Comment border', 'pht'); ?></label></th> 
				<td>
					<input id="sr_border_comment" name="sr_border_comment" type="text" class="text" value="<?php if ( get_option('phT_border_comment') == "" ) { echo "1px solid #222"; } else { echo attribute_escape( get_option('phT_border_comment') ); } ?>" tabindex="20" size="20" />
					<p class="info"><?php _e('Default is <span>1px solid #222</span>.', 'pht'); ?></p>
				</td>
			</tr>		
			
			<tr valign="top">
				<th scope="row"><label for="sr_border_comment_texta"><?php _e('Comment text area border', 'pht'); ?></label></th> 
				<td>
					<input id="sr_border_comment_texta" name="sr_border_comment_texta" type="text" class="text" value="<?php if ( get_option('phT_border_comment_texta') == "" ) { echo "1px solid #222"; } else { echo attribute_escape( get_option('phT_border_comment_texta') ); } ?>" tabindex="20" size="20" />
					<p class="info"><?php _e('Default is <span>1px solid #222</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_border_content"><?php _e('Content border', 'pht'); ?></label></th> 
				<td>
					<input id="sr_border_content" name="sr_border_content" type="text" class="text" value="<?php if ( get_option('phT_border_content') == "" ) { echo "1px solid #AAA"; } else { echo attribute_escape( get_option('phT_border_content') ); } ?>" tabindex="20" size="20" />
					<p class="info"><?php _e('Default is <span>1px solid #AAA</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_a"><?php _e('a', 'pht'); ?></label></th> 
				<td>
					<input id="sr_a" name="sr_a" type="text" class="text" value="<?php if ( get_option('phT_a') == "" ) { echo "#888"; } else { echo attribute_escape( get_option('phT_a') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#888</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_a_visited"><?php _e('a visited', 'pht'); ?></label></th> 
				<td>
					<input id="sr_a_visited" name="sr_a_visited" type="text" class="text" value="<?php if ( get_option('phT_a_visited') == "" ) { echo "#999"; } else { echo attribute_escape( get_option('phT_a_visited') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#999</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_a_hover"><?php _e('a visited', 'pht'); ?></label></th> 
				<td>
					<input id="sr_a_hover" name="sr_a_hover" type="text" class="text" value="<?php if ( get_option('phT_a_hover') == "" ) { echo "#FFF"; } else { echo attribute_escape( get_option('phT_a_hover') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#FFF</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_comment_color_background"><?php _e('Comment background color', 'pht'); ?></label></th> 
				<td>
					<input id="sr_comment_color_background" name="sr_comment_color_background" type="text" class="text" value="<?php if ( get_option('phT_comment_color_background') == "" ) { echo "#000"; } else { echo attribute_escape( get_option('phT_comment_color_background') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#000</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_comment_input_color_background"><?php _e('Comment input background color', 'pht'); ?></label></th> 
				<td>
					<input id="sr_comment_input_color_background" name="sr_comment_input_color_background" type="text" class="text" value="<?php if ( get_option('phT_comment_input_color_background') == "" ) { echo "#333"; } else { echo attribute_escape( get_option('phT_comment_input_color_background') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#333</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_comment_color"><?php _e('Comment text color', 'pht'); ?></label></th> 
				<td>
					<input id="sr_comment_color" name="sr_comment_color" type="text" class="text" value="<?php if ( get_option('phT_comment_color') == "" ) { echo "#BBB"; } else { echo attribute_escape( get_option('phT_comment_color') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#BBB</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="sr_comment_texta_color_background"><?php _e('Comment text area color', 'pht'); ?></label></th> 
				<td>
					<input id="sr_comment_texta_color_background" name="sr_comment_texta_color_background" type="text" class="text" value="<?php if ( get_option('phT_comment_texta_color_background') == "" ) { echo "#DDD"; } else { echo attribute_escape( get_option('phT_comment_texta_color_background') ); } ?>" tabindex="20" size="10" />
					<p class="info"><?php _e('Default is <span>#DDD</span>.', 'pht'); ?></p>
				</td>
			</tr>
			
			
			<?php $pht_tmp_delafult=get_template_directory_uri()."/images/favicon.ico"; ?>
			<tr valign="top">
				<th scope="row"><label for="sr_favicon"><?php _e('Favicon', 'pht'); ?></label></th> 
				<td>
					<input id="sr_favicon" name="sr_favicon" type="text" class="text" value="<?php if ( get_option('phT_favicon') == "" ) { echo $pht_tmp_delafult; } else { echo attribute_escape( get_option('phT_favicon') ); } ?>" tabindex="20" size="100" />
					<p class="info"><?php _e('Default is <span>'.$pht_tmp_delafult.'</span>.', 'pht'); ?></p>
				</td>
			</tr>

			<?php $pht_tmp_delafult="mosaic"; ?>
			<tr valign="top">
				<th scope="row"><label for="sr_mosaic_string"><?php _e('Mosic string', 'pht'); ?></label></th> 
				<td>
					<input id="sr_mosaic_string" name="sr_mosaic_string" type="text" class="text" value="<?php if ( get_option('phT_mosaic_string') == "" ) { echo $pht_tmp_delafult; } else { echo attribute_escape( get_option('phT_mosaic_string') ); } ?>" tabindex="20" size="40" />
					<p class="info"><?php _e('Default is <span>'.$pht_tmp_delafult.'</span>.', 'pht'); ?></p>
				</td>
			</tr>
			<?php $pht_tmp_delafult="/?cat=".get_option('default_category'); ?>
			<tr valign="top">
				<th scope="row"><label for="sr_mosaic"><?php _e('Mosic link', 'pht'); ?></label></th> 
				<td>
					<input id="sr_mosaic" name="sr_mosaic" type="text" class="text" value="<?php if ( get_option('phT_mosaic') == "" ) { echo $pht_tmp_delafult; } else { echo attribute_escape( get_option('phT_mosaic') ); } ?>" tabindex="20" size="40" />
					<p class="info"><?php _e('Default is <span>'.$pht_tmp_delafult.'</span>.', 'pht'); ?></p>
				</td>
			</tr>

			<?php $pht_tmp_delafult=_("&laquo; Previous"); ?>
			<tr valign="top">
				<th scope="row"><label for="sr_prev_arrow"><?php _e('Prev arrow', 'pht'); ?></label></th> 
				<td>
					<input id="sr_prev_arrow" name="sr_prev_arrow" type="text" class="text" value="<?php if ( get_option('phT_prev_arrow') == "" ) { echo $pht_tmp_delafult; } else { echo attribute_escape( get_option('phT_prev_arrow') ); } ?>" tabindex="20" size="40" />
					<p class="info"><?php _e('Default is <span>'.$pht_tmp_delafult.'</span>.', 'pht'); ?></p>
				</td>
			</tr>
			
			<?php $pht_tmp_delafult=_("Next &raquo;"); ?>
			<tr valign="top">
				<th scope="row"><label for="sr_next_arrow"><?php _e('Prev arrow', 'pht'); ?></label></th> 
				<td>
					<input id="sr_next_arrow" name="sr_next_arrow" type="text" class="text" value="<?php if ( get_option('phT_next_arrow') == "" ) { echo $pht_tmp_delafult; } else { echo attribute_escape( get_option('phT_next_arrow') ); } ?>" tabindex="20" size="40" />
					<p class="info"><?php _e('Default is <span>'.$pht_tmp_delafult.'</span>.', 'pht'); ?></p>
				</td>
			</tr>
			
			<?php $pht_tmp_delafult='<div style="float:center;text-align:center;margin-top:5px;">
<a href="http://photoblogs.org/">
<img src="'.get_template_directory_uri().'/images/photoblogs.gif" alt="photoblogs.org" />
</a></div>'; ?>
			<tr valign="top">
				<th scope="row"><label for="sr_footer"><?php _e('Footer', 'pht'); ?></label></th> 
				<td>
					<textarea id="sr_footer" name="sr_footer" type="text" class="text"  tabindex="20" rows="10" cols="100"><?php if ( get_option('phT_footer') == "" ) { echo $pht_tmp_delafult; } else { echo attribute_escape( get_option('phT_footer') ); } ?>
					</textarea>
				</td>
			</tr>			
			
		</table>
		
		
		
				
		<p class="submit">
			<input name="save" type="submit" value="<?php _e('Save Options', 'pht'); ?>" tabindex="24" accesskey="S" />  
			<input name="action" type="hidden" value="save" />
			<input name="page_options" type="hidden" value="sr_basefontsize,sr_basefontfamily,sr_headingfontfamily,sr_layoutwidth,sr_posttextalignment,sr_sidebarposition,sr_accesslinks,sr_avatarsize" />
		</p>
	</form>
	<h3><?php _e('Reset Options', 'pht'); ?></h3>
	<p><?php _e('Resetting deletes all stored phT options from your database. After resetting, default options are loaded but are not stored until you click <i>Save Options</i>. A reset does not affect the actual theme files in any way. If you are uninstalling phT, please reset before removing the theme files to clear your databse.', 'pht'); ?></p>
	<form action="<?php echo wp_specialchars( $_SERVER['REQUEST_URI'] ) ?>" method="post">
		<?php wp_nonce_field('phT_reset_options'); echo "\n"; ?>
		<p class="submit">
			<input name="reset" type="submit" value="<?php _e('Reset Options', 'pht'); ?>" onclick="return confirm('<?php _e('Click OK to reset. Any changes to these theme options will be lost!', 'pht'); ?>');" tabindex="25" accesskey="R" />
			<input name="action" type="hidden" value="reset" />
			<input name="page_options" type="hidden" value="sr_basefontsize,sr_basefontfamily,sr_headingfontfamily,sr_layoutwidth,sr_posttextalignment,sr_sidebarposition,sr_accesslinks,sr_avatarsize" />
		</p>
	</form>
</div>
<?php
}

function pht_update_options(){
	update_option( 'phT_autoresolution', phT_autoresolution );
	update_option( 'phT_Kx', phT_Kx);
	update_option( 'phT_Ky', phT_Ky );
	update_option( 'phT_tx', phT_tx );
	update_option( 'phT_ty', phT_ty);			
	update_option( 'phT_body_background', phT_body_background );
	update_option( 'phT_body_color', phT_body_color );
	update_option( 'phT_page_color_background', phT_page_color_background );
	update_option( 'phT_page_color', phT_page_color );
	update_option( 'phT_content_background', phT_content_background );
	update_option( 'phT_content_color', phT_content_color );
	update_option( 'phT_space', phT_space );
	update_option( 'phT_border_img', phT_border_img );
	update_option( 'phT_border_comment', phT_border_comment );
	update_option( 'phT_border_comment_texta', phT_border_comment_texta);
	update_option( 'phT_border_content', phT_border_content );
	update_option( 'phT_a', phT_a );
	update_option( 'phT_a_visited',phT_a_visited);
	update_option( 'phT_a_hover', phT_a_hover);
	update_option( 'phT_comment_color_background', phT_comment_color_background );
	update_option( 'phT_comment_input_color_background', phT_comment_input_color_background );
	update_option( 'phT_comment_color', phT_comment_color );
	update_option( 'phT_comment_texta_color_background', phT_comment_texta_color_background );
	update_option( 'phT_favicon', phT_favicon );
	update_option( 'phT_footer',  phT_footer );
	update_option( 'phT_mosaic', phT_mosaic );
	update_option( 'phT_mosaic_string', phT_mosaic_string );
	update_option( 'phT_prev_arrow', phT_prev_arrow );
	update_option( 'phT_next_arrow', phT_next_arrow );
}
?>