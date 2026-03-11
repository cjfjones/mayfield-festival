<?php
/**
 * Template Name: True-full-width (with hero image)
 *
 * This is the template that displays true full width page without sidebar
 *
 * @package dazzling
 */

get_header(); ?>




<?php
	echo '<section class="wp-block-cover-image" style="background-image: url('.get_the_post_thumbnail_url().'")>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">';
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
				}
	          	if ( get_the_title() != '' ) echo '<h1 class="entry-title">'. get_the_title().'</h1>';
	            echo '</div>
			</div>
        </div>
    </div>
</section>';
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
