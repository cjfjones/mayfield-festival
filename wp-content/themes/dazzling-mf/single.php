<?php
/**
 * The Template for displaying all single posts.
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
				        if ( get_the_title() != '' ) echo '<h2 class="entry-title">News</h2>';
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
						<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'single' ); ?>
						<?php dazzling_post_nav(); ?>
						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() ) :
								comments_template();
							endif;
						?>				
						<?php endwhile; // end of the loop. ?>

					</main><!-- #main -->
				</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>