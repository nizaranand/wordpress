<?php
/**
 * The template for displaying all posts.
 *
 * Default Post Template
 *
 * Page template with a fixed 940px container and right sidebar layout
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.1
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="row">
  <div class="container">
   <?php if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
   </div><!--/.container -->
   </div><!--/.row -->
   <div class="container">
     
 <!-- Masthead
      ================================================== -->

        <div class="row content">
<div class="span9 hero-unit-page">
      <header class="jumbotron subhead" id="overview">
        <h2><?php the_title();?></h2>
      </header>
         
   <p class="meta"><?php echo bootstrapwp_posted_on();?></p>
            <?php the_content();?>
            <?php the_tags( '<p>Tags: ', ' ', '</p>'); ?>
<?php endwhile; // end of the loop. ?>
<hr />
<div class="well form-inline">
 <?php comments_template(); ?>
</div>

 <?php bootstrapwp_content_nav('nav-below');?>

          </div><!-- /.span8 -->
          <?php get_sidebar('blog'); ?>


<?php get_footer(); ?>