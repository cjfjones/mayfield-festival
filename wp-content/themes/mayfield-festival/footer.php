<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mayfield-festival
 */

?>

	</div><!-- #content -->
</div><!-- #page -->
</div><!-- .container -->
<div class="container">
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://ferguson.financial/', 'mayfield-festival' ) ); ?>">Ferguson Financial Solicitors</a>
			<span class="sep"> | </span>
			<a href="<?php echo esc_url( __( 'http://www.omni.co.uk/', 'mayfield-festival' ) ); ?>">Omni Partners</a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	</div><!-- #container -->


<?php wp_footer(); ?>

</body>
</html>
