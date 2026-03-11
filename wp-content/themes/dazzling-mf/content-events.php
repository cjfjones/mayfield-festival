<?php
/**
 * The template part for displaying event posts
 *
 * @package dazzling
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php echo '<p class="entry-subtitle">' . get_the_excerpt() . '</p>'; ?>
	</header>
	<div class="event-image-wrapper">
    <?php 
    if (get_post_meta($post->ID, 'sold_out', true)) {
      echo '<div class="sold-out-banner">Sold Out</div>';
    }
    the_post_thumbnail(array('930,525'), array('class' => 'img-responsive'));
    ?>
  </div>
	<div class="row">
		<div class="entry-content col-sm-3">
			<!--<p style="color: #ad1e22; font-size: 21px; line-height: 24px;"><strong>POSTPONED UNTIL FURTHER NOTICE</strong></p>
			<hr>-->
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
		   <?php if ($tmp_eventprice) { ?>
		        <span class="event-details event-price"><?php echo $tmp_eventprice; ?></span>
		   <?php }  ?>
		   <?php if ($tmp_eventbookingurl) { ?>
		       <span><a class="btn btn-lg btn-default event-button" href="<?php echo $tmp_eventbookingurl; ?>" target="_blank">Book now</a></span>
		   <?php }  ?>
		</div>
		<div class="entry-content col-sm-9">
			<?php the_content(); ?>
		</div>
	</div>
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'dazzling' ), '<i class="fa fa-pencil-square-o"></i><span class="edit-link">', '</span>' ); ?>
	</footer>
</article>