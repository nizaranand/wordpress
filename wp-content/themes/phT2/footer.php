<div id="footer">
<?php echo (phT_footer); ?>
<!-- If you'd like to support WordPress, having the "powered by" link someone on your blog is the best way, it's our only promotion or advertising. -->
	<p> 
		<?php bloginfo('name'); ?> is powered by 
		<?php if(phT_isMu()): ?>
			<?php $current_site = get_current_site(); ?>
			<a href="http://mu.wordpress.org/">WordPress MU</a> running on <a href="http://<?php echo $current_site->domain . $current_site->path ?>"><?php echo $current_site->site_name ?></a>. <a href="http://<?php echo $current_site->domain . $current_site->path ?>wp-signup.php" title="Create a new blog">Create a new blog</a> and join in the fun!
		<?php else : ?>
			<a href="http://wordpress.org/">WordPress</a>.
		<?php endif; ?>
		Using <a href="http://johannes.jarolim.com/blog/wordpress/yet-another-photoblog/">YAPB plugin</a> and <a href="http://phT.inhubi.com/">phT</a> theme by <a href="http://justpictures.es">Fran Sim&oacute;</a>.
		<a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a>
		and <a href="<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a>.
		<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
	</p>
</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
