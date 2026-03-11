<?php
/*
 * Template Name: Right Sidebar
 * The template for displaying all single posts and attachments
 *
 * @package dazzling
*/
get_header(); ?>
<div class="sub-page-title">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
					}
			        if ( get_the_title() != '' ) echo '<h2 class="entry-title">Events</h2>';
				?>
			</div>
		</div>
	</div>
</div>
<div class="entry-content">
    <div class="container">
    	<div class="row">
			<div id="primary" class="content-area col-sm-12 col-md-8">
				<main id="main" class="site-main" role="main">
					<div class="event-content">
						<?php
						// Start the loop.
						while ( have_posts() ) : the_post();
						
				
							// Include the single event content template.
							get_template_part( 'content', 'events' );
							
				
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
				
							if ( is_singular( 'attachment' ) ) {
								// Parent post navigation.
								the_post_navigation( array(
									'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'dazzling' ),
								) );
							} elseif ( is_singular( 'post' ) ) {
								// Previous/next post navigation.
								the_post_navigation( array(
									'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'dazzling' ) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Next post:', 'dazzling' ) . '</span> ' .
										'<span class="post-title">%title</span>',
									'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'dazzling' ) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Previous post:', 'dazzling' ) . '</span> ' .
										'<span class="post-title">%title</span>',
								) );
							}
							
							// End of the loop.
						endwhile;
						?>
					</div>

				</main><!-- #main -->
			</div><!-- #primary -->
			<div id="secondary" class="col-sm-12 col-md-4">
		<?php dynamic_sidebar( 'events' ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>