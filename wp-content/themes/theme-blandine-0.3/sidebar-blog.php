<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */
?>
<div class="span2">
		<div class="well sidebar-nav">
            <?php
    if ( function_exists('dynamic_sidebar')) dynamic_sidebar("sidebar-posts");
?>
	</div><!--/.well .sidebar-nav -->
		<div class="well sidebar-nav">
            <?php
    if ( function_exists('dynamic_sidebar')) dynamic_sidebar("sidebar-page");
?>
	</div>
         </div><!-- /.span4 -->
          </div><!-- /.row .content -->

