<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php twentysixteen_excerpt(); ?>

	<?php twentysixteen_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'template-parts/biography' );
			}
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
        
        <?php
        	// Add custom meta data (PJA)
			$tmp_eventdate = get_post_meta($post->ID, 'Date', true);							
			$tmp_eventlocation = get_post_meta($post->ID, 'Location', true);							
			$tmp_eventprice = get_post_meta($post->ID, 'Ticket Prices', true);							
			$tmp_eventbookingurl = get_post_meta($post->ID, 'Booking url', true);							
			// End custom meta data (PJA)
       ?>
            
       <span class="event-details event-date"><?php echo $tmp_eventdate; ?></span>
       <span class="event-details event-location"><?php echo $tmp_eventlocation; ?></span>
       <span class="event-details event-price"><?php echo $tmp_eventprice; ?></span>
       <span><a class="event-button" href="<?php echo $tmp_eventbookingurl; ?>">Book now</a></span>

       <?php echo "<a class='event-button' href='$tmp_eventbookingurl; >Book now</a>" ?>

		<?php twentysixteen_entry_meta(); ?>
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
