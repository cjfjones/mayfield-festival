<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
		
			// Add custom meta data (PJA)
			$tmp_eventdate = get_post_meta($post->ID, 'Date', true);							
			$tmp_eventlocation = get_post_meta($post->ID, 'Location', true);							
			$tmp_eventprice = get_post_meta($post->ID, 'Ticket Prices', true);							
			$tmp_eventbookingurl = get_post_meta($post->ID, 'Booking url', true);							
			// End custom meta data (PJA)

   <!-- Add custom meta data (PJA) -->
        <footer class="entry-footer event-entry">
			<?php if (get_post_meta($post->ID, 'Date', true)) : ?>
            <span class="date"><?php echo $tmp_eventdate ?></span>
            <?php endif; ?>
            <?php if (get_post_meta($post->ID, 'Location', true)) : ?>
			<span class="location"><?php echo $tmp_eventlocation ?></span>
			<?php endif; ?>
            <?php if (get_post_meta($post->ID, 'Ticket Prices', true)) : ?>
            <span class="ticket-price">Tickets - <?php echo $tmp_eventprice ?></span>
			<?php endif; ?>
            <?php if (get_post_meta($post->ID, 'Booking url', true)) : ?>
            <span class="booking-url"><a href="<?php echo $tmp_eventbookingurl ?>">Book now</a></span>
            <?php endif; ?>
        </footer>
		<!-- End custom meta data (PJA) -->

			// Include the single post content template.
			//get_template_part( 'template-parts/content', 'single' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'twentysixteen' ),
				) );
			} elseif ( is_singular( 'post' ) ) {
				// Previous/next post navigation.
				the_post_navigation( array(
					'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentysixteen' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Next post:', 'twentysixteen' ) . '</span> ' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentysixteen' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Previous post:', 'twentysixteen' ) . '</span> ' .
						'<span class="post-title">%title</span>',
				) );
			}
			
			// End of the loop.
		endwhile;
		?>
        
     
        
	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>