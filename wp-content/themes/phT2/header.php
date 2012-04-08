<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<meta name="title" content="<?php wp_title(); ?>" />
<title><?php bloginfo('name'); ?> &raquo; <?php bloginfo('description'); ?> <?php wp_title(); ?></title>

<meta name="description" content="<?php bloginfo('name'); ?> <?php bloginfo('description'); ?> <?php wp_title(); ?> " />
<meta name="keywords" content="<?php $posttags = get_the_tags(); foreach($posttags as $tag) { echo htmlspecialchars($tag->name).", "; }; ?>" />

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Comments Feed" href="<?php bloginfo('comments_rss2_url'); ?>" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<style type="text/css" media="screen">

<!--
.img-cont {
    background: url(<?php echo get_template_directory_uri() ?>/images/loading.gif) no-repeat center;
}

body {
	background: <?php echo phT_body_background; ?>;
	color: <?php echo phT_body_color; ?>;
}

#page {
	background: <?php echo phT_page_color_background; ?>;
	color: <?php echo phT_page_color; ?>;
	width: <?php echo phT_x+14; ?>px;
}

#content, #header {
	width: <?php echo phT_x+2; ?>px;	
	background: <?php echo phT_content_background; ?>;
	color: <?php echo phT_content_color; ?>;
}

.img-cont-thumb {
	width: <?php echo phT_tx; ?>px;
	height: <?php echo phT_ty; ?>px;		
}

.inside {
	width: <?php echo phT_x; ?>px;		
}

#commentform textarea {
	width: <?php echo phT_x-10; ?>px;
}

a {
	color: <?php echo phT_a; ?>;
}

a:visited {
	color: <?php echo phT_a_visited; ?>;
}

a:hover {
	color: <?php echo phT_a_hover; ?>;
}

#content a, #header a {
	color: <?php echo phT_a; ?>;
}

#content a:visited, #header a:visited{
	color: <?php echo phT_a_visited; ?>;
}

#content a:hover, #header a:hover  {
	color: <?php echo phT_a_hover; ?>;
}

#commentform  {
    background: <?php echo phT_comment_color_background; ?>;	
    color:<?php echo phT_comment_color; ?>;
}

#commentform input {
    background: <?php echo phT_comment_input_color_background; ?>;;
    border: <?php echo phT_border_comment; ?>;
    color:<?php echo phT_comment_color; ?>;
}

#commentform textarea {
    background: <?php echo phT_comment_texta_color_background; ?>;
    border: <?php echo phT_border_comment_texta; ?>;
}

#space{
	height: <?php echo phT_space; ?>px;	
}

.img-cont img {
    border: <?php echo phT_border_img; ?>; 
}

.img-cont-thumb img {
    border: <?php echo phT_border_img; ?>; 
}

#content, #header {
    border: <?php echo phT_border_content; ?>; 
}
-->    
</style>

<link rel="shortcut icon" href="<?php echo phT_favicon ?>" />
<?php require_once('get_resolution.php'); ?>
<?php wp_head(); ?>
</head>
<body>
<div id="page">

<div id="header">
	
	<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
	
	<ul>
		<?php wp_list_pages('depth=0&title_li=&sort_column=post_title&sort_order=ASC');?>
		<?php if (defined("phT_mosaic")) {echo '<li><a href="'.phT_mosaic.'">'.phT_mosaic_string.'</a></li>'; } ?>
	</ul>
	<div style="clear:both;"></div>
</div>

<?php if (!phT_isYAPB()) :?>
	NOTICE: This theme is designed for <a href="http://johannes.jarolim.com/yapb">Yapb plugin</a>!
<?php endif;?>

<div id="space">
</div>