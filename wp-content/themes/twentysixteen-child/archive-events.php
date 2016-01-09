<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
        <?php 
			$page_id = 1381; // 123 should be replaced with a specific Page's id from your site, which you can find by mousing over the link to edit that Page on the Manage Pages admin page. The id will be embedded in the query string of the URL, e.g. page.php?action=edit&post=123.
			$page_data = get_page( $page_id ); // You must pass in a variable to the get_page function. If you pass in a value (e.g. get_page ( 123 ); ), WordPress will generate an error. 
			$content = apply_filters('the_content', $page_data->post_content); // Get Content and retain Wordpress filters such as paragraph tags. Origin from: http://wordpress.org/support/topic/get_pagepost-and-no-paragraphs-problem
			$title = $page_data->post_title; // Get title
			//echo $content; // Output Content
		?>
        
		<!-- PJA Addition -->
        <h1 class="center"><?php echo $title; ?></h1>
		<h2 class="center"><?php echo get_post_meta($page_id, 'sub_title', true); ?></h2>
		<div class="taster">
			<p class="intro center"><?php echo $content; ?></p>
		</div>		
		<section class="thumb-content-block clearfix">
			<?php if($post_count == 0) : ?>
			<div>Nobody found.</div>
			<?php endif; ?>
			<?php 
			$post_num = 0;
				while ( $query->have_posts() ) : $query->the_post();
				
			 ?>
	  
			<article class="col <?php  if(($post_num % 3) == 0) : echo ' firstOfThree'; endif; ?> <?php  if(($post_num % 2) == 0) : echo ' firstOfTwo'; endif; ?>">
				<a class="news-post-thumbnail" href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark">
					<h3>
						<?php 
							if ( has_post_thumbnail() ) {
								echo get_the_post_thumbnail( $post->ID, array( 360,240 ));
								//$alt = get_post_meta($post->ID, '_wp_attachment_image_alt', true);
								//echo '<img alt="'.$alt.'" src="'.$src[0].'"/>'; 
						
							//the_post_thumbnail( array(360,240) );
							} 
							the_title(); 
						?>
					</h3>
				</a>
				<div class="thumb-taster"><p><?php echo get_post_meta($post->ID, 'taster', true); ?></p></div>
			</article>

			

	  		<?php 
			$post_num++;
			endwhile; // end of the loop. ?>
  		</section>
        <!-- PJA Addition -->
        
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentysixteen' ),
				'next_text'          => __( 'Next page', 'twentysixteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
