<?php
/**
 *
 * Search Template
 *
 *
 * @package WP-Bootstrap
 * @subpackage Default_Theme
 * @since WP-Bootstrap 0.7
 *
 * Last Revised: January 22, 2012
 */
get_header(); ?>
 <div class="container">
<?php if ( have_posts() ) : ?>
  
    <!-- Masthead
      ================================================== -->
      <header class="jumbotron subhead" id="overview">
        <h1><?php printf( __( 'Résultats pour la recherche: %s', 'bootstrapwp' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
       
      </header>
              <div class="row content">
<div class="span9 hero-unit-page">
					<?php while ( have_posts() ) : the_post(); ?>
<h2><?php the_title();?></h2>
<p><?php the_excerpt();?></p>
<hr />

				<?php endwhile; ?>
			<?php else : ?>
 <!-- Masthead
      ================================================== -->


      <header class="jumbotron subhead" id="overview">
        <h1><?php _e( 'Aucun résultat', 'bootstrapwp' ); ?></h1>
     <p class="lead"><?php _e( 'Il semble que la page que vous recherchez n&rsquo;existe plus. Vous pouvez vous aider de la recherche ou du plan du site ci-dessous :', 'bootstrapwp' ); ?></p>
      </header>
					

<div class="well">
					<?php get_search_form(); ?>

</div><!--/.well -->
<?php endif ;?>
				<?php bootstrapwp_content_nav( 'nav-below' ); ?>

			

		</div><!--/.span8 -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>