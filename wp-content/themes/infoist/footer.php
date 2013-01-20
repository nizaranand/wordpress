
	<footer id="colophon" role="contentinfo">
		<div id="site-generator">
			<?php do_action( 'infoist_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'infoist' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'infoist' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'infoist' ), 'WordPress' ); ?></a>
            
            <?php if ( is_home() || is_front_page() ) : ?>
			<span class="sep"> | </span>
			<a href="<?php echo esc_url( __( 'http://wpthemes.co.nz/infoist-theme/', 'infoist' ) ); ?>" rel="designer"><?php printf( __( '%s Theme', 'infoist' ), 'Infoist' ); ?></a><?php printf( __( ' by %s', 'infoist' ), 'WPThemes NZ' ); ?>
            <?php endif; ?>
		</div>
	</footer><!-- #colophon -->
</div><!-- #container -->

<?php wp_footer(); ?>

</body>
</html>