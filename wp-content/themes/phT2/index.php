<?php get_header(); ?>
<?php $break=false; ?>
<?php if (have_posts()) : ?>
<?php while (have_posts() && !$break) : the_post(); ?>
			<div id="content">
			<div class="post" id="post-<?php the_ID(); ?>">

				<div class="entry">
  					
					<?php phT_showImage() ?>

					<div id="img-title">
						<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title();?>"><?php the_title();?></a></h2>
						<h3><?php the_date();?></h3>
						<div style="clear:both;"></div>
					</div>
										                 	
					<div id="the_content"><?php the_content(); ?></div>
					<?php if(function_exists('polyglot_other_langs')) polyglot_other_langs(' ','<center>', '</center>', '[', '] ');?>
					<div class="comment"><?php comments_template(); ?></div>
				</div>

				<p class="postmetadata">Posted in <?php the_category(', ') ?> 
				<?php the_tags('| Tagged:', ', ', ''); ?>
				<?php edit_post_link('Edit', ' | ', ' | '); ?> 
				<?php wp_register(""," | "); ?> 
				<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
			</div>
			<?php $break=true; ?>
		<?php endwhile; ?>
	<?php else : ?>
		<div id="content">		
		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
	<?php endif; ?>
	</div>
<?php get_footer(); ?>