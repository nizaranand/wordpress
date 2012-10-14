<?php
/**
 * The template for displaying all pages.
 *
 * Template Name: Default Page Double SideBar
 * Description: Page template with a content container and right sidebar
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="row">
    <div class="container">
     
     <?php //if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
   </div><!--/.container -->
 </div><!--/.row -->
 <div class="container">

  
 <!-- Masthead
 ================================================== -->
 <header class="jumbotron subhead" id="overview">
  <h1><?php //the_title();?></h1>
</header>

<div class="row content">
  <div class="span9">
    <div class=" hero-unit-page">
      <?php the_content();?>
    <?php endwhile; // end of the loop. ?>
  </div></div><!-- /.span8 -->
  <div class="span3 right">
    <div id="scrollingDiv" class="well sidebar-nav">
      <?php
      if ( function_exists('dynamic_sidebar')) dynamic_sidebar("sidebar-page");
      ?>
    </div><!--/.well .sidebar-nav -->

    <div class="span3 right">
      <div id="scrollingDiv" class="well sidebar-nav">
        bli
      </div>
    </div>

  </div><!-- /.span4 -->
</div><!-- /.row .content -->


<?php get_footer(); ?>