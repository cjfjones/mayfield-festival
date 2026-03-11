<?php
/**
 * The template for displaying 404 pages (Not Found).
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
					?>
				 	<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'dazzling' ); ?></h1>
				</div>
			</div>
		</div>
	</div>
	<div id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main" role="main">
			<section class="error-404 not-found">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<p class="lead">We're really sorry but the page you were trying to get to can't be found - it may have moved or changed.</p>
							<p class="lead">Return to the <a href="/">homepage ›</a></p>
						</div>
					</div>
				</div>
			</section><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>