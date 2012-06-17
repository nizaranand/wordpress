<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.7
 *
 * Last Revised: January 22, 2012
 */
get_header(); ?>
  <div class="row">
  <div class="container">
   </div><!--/.container -->
   </div><!--/.row -->
   <div class="container">

      
 <!-- Masthead
      ================================================== -->

        <div class="row content">
<div class="span9 hero-unit-page">
      <header class="jumbotron subhead" id="overview">
        <h1><?php _e( 'Page non trouvée', 'bootstrapwp' ); ?></h1>
        <p class="lead"><?php _e( 'Il semble que la page que vous recherchez n&rsquo;existe plus. Vous pouvez vous aider de la recherche ou du plan du site ci-dessous :', 'bootstrapwp' ); ?></p>
      </header>


<div class="well">
					<?php get_search_form(); ?>
	<h2>Plan du site</h2>
					<?php wp_page_menu(); ?>
</div><!--/.well -->


					</div><!--/.span8 -->
 <?php get_sidebar(); ?>

<?php get_footer(); ?>