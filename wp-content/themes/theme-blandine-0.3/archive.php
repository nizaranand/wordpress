<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage WP-Bootstrap
 * @since WP-Bootstrap 0.6
 */

get_header(); 
if (have_posts() ) ;?>
<div class="row">
	<div class="container">
		<?php //if (function_exists('bootstrapwp_breadcrumbs')) bootstrapwp_breadcrumbs(); ?>
	</div><!--/.container -->
</div><!--/.row -->
<div class="container">

<div class="row content">
	<div class="span9">
		<div class="hero-unit-page">
		<?php while ( have_posts() ) : the_post(); ?>
		<div <?php post_class(); ?>>
			<a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><h3><?php the_title();?></h3></a>
			<p class="meta"><?php echo bootstrapwp_posted_on();?></p>
			<div class="row">              
				<div class="span2">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
						<?php echo catch_that_image();?></a>
					</div><!-- /.span2 -->
					<div class="span9">
						<?php the_excerpt();?>
					</div><!-- /.span6 -->
				</div><!-- /.row -->   

			            <?php the_tags( '<p>Tags: ', ' ', '</p>'); ?>
				<hr />  
			</div><!-- /.post_class -->

		<?php endwhile; ?>
		<?php bootstrapwp_content_nav('nav-below');?>
		</div>
	</div><!-- /.span9 -->
	<?php //get_sidebar(); ?>
	<?php get_sidebar('blog'); ?>

	<?php get_footer(); ?>