<?php
/**
 * Template Name: Default Template Path Child
 *
 * Displays blog archives.
 *
 * @package PathChild
 * @subpackage Template
 * @since 0.1.0
 */


get_header(); // Loads the header.php template. ?>

	<?php do_atomic( 'before_content' ); // path_before_content ?>

	<div id="content">

		<?php do_atomic( 'open_content' ); // path_open_content ?>

		<div class="hfeed">

			<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) ); ?>


					<?php if ( is_singular() ) { ?>
					
						<?php do_atomic( 'after_singular' ); // path_after_singular ?>
					
						<?php get_sidebar( 'after-singular' ); // Loads the sidebar-after-singular.php template. ?>

						<?php // comments_template( '/comments.php', true ); // Loads the comments.php template. ?>

					<?php } ?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // path_close_content ?>

		<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // path_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>