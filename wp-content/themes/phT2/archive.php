<?php get_header(); ?>

	<div id="content">
	<div id="sidebar">
	  <ul>
	     <?php wp_list_cats(); ?>
	  </ul>	  
	  <ul>
	    <?php wp_get_archives('type=monthly'); ?>
	  </ul>
	</div>
	
	<div id="thumbs">
		<?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle">Archive for the '<?php echo single_cat_title(); ?>' Category</h2>
		
		  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
		
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
		
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
		
		 <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2 class="pagetitle">Search Results</h2>
		
		 <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle">Author Archive</h2>
		
		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle">Blog Archives</h2>
		
		<?php } ?>	
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>              
		               	<?php if ($post->image): ?>
		               	<div class="img-cont-thumb">
		               	<a href="<?php the_permalink(); ?>"> <?php echo phT_getImgTag($post,"thumb"); ?></a>
		               	</div>
		               	<?php endif; ?>
			<?php endwhile; ?>
			<div style="clear:both;"></div>
			<div id="navigation" >
				<div class="prev"><?php next_posts_link(phT_prev_arrow) ?></div>
				<div class="next"><?php previous_posts_link(phT_next_arrow) ?></div>
			</div>
		    
		<?php else : ?>
		
			<h2 class="center">Not Found</h2>
			<p class="center">Sorry, but you are looking for something that isn't here.</p>
		
		<?php endif; ?>
		
		</div>	
		<div style="clear:both;"></div>
		
	</div>
<?php get_footer(); ?>