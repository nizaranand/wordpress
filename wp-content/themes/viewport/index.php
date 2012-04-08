<?php get_header(); ?>

	<div id="mid" class="index">
		
		<!-- Start slider -->
		<div class="stripViewer">
			<div class="panelContainer">
			
			<?php if (have_posts()) : ?>
		
				<?php while (have_posts()) : the_post(); ?>
			
				<div class="panel" id="post-<?php the_ID(); ?>" title="<?php the_title() ?>">
					<div class="wrapper">
						<?php $image = get_post_meta($post->ID, 'lead_image', true); ?>
						<img src="<?php echo $image; ?>" alt="" width="940" height="600" />
						<div class="post-title">
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</div>
						<div class="entry">
							<?php the_excerpt(); ?>
						</div>
					</div>
				</div>
				
				<?php endwhile; ?>
				
				<div class="panel" id="nav-panel">
					<div class="wrapper">
						<img src="<?php bloginfo('template_directory'); ?>/images/where.jpg" alt="" width="940" height="600" />
						<div class="post-title">
							Where next?
						</div>
						<div class="entry">
							<span class="big"><a href="<?php bloginfo('comments_rss2_url'); ?>" class="rss-big">Recent Comments</a></span>
							<ul><li></li><?php dp_recent_comments(); ?></ul>
							<span class="big"><span class="left"><?php previous_posts_link('&laquo; Newer Entries') ?></span>
							<span class="right"><?php next_posts_link('Older Entries &raquo;') ?></span></span>
						</div>
					</div>
				</div>
				
			<?php else : ?>
		
			<?php endif; ?>
	
			</div><!-- .panelContainer -->
		</div><!--.stripViewer -->
		
	</div><!-- .mid -->
	
	<div class="stripNavL" id="stripNavL0"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/left.png" alt="Left" /></a></div>
	<div class="stripNavR" id="stripNavR0"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/right.png" alt="Right" /></a></div>

<?php get_footer(); ?>