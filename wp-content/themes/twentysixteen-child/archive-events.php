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
        <header class="entry-header">
		        <h1 class="entry-title"><?php echo $title; ?></h1>
		</header>
        <div class="entry-content">
        
			<?php echo $content; ?>
            
            <?php 
                $args = array(
                'post_type' => 'Events',
                'posts_per_page' => 999,
                'post_parent' => 0,
                'orderby' => 'menu_order',
                'order' => ASC
                );
                $query = new WP_Query( $args ); 
                $post_count = $query->post_count;
            ?>

            <section class="row">
                <?php if($post_count == 0) : ?>
                <div>Coming soon.</div>
                <?php endif; ?>
                <?php 
                $post_num = 0;
                    while ( $query->have_posts() ) : $query->the_post();
                    
                 ?>
                <article class="event-two-col<?php if(($post_num % 2) == 0) : echo ' first-col'; endif; ?>">
                    <a class="news-post-thumbnail" href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark">
                        <?php 
                            if ( has_post_thumbnail() ) {
                                echo get_the_post_thumbnail( $post->ID, array( 399,266 ));
                                //$alt = get_post_meta($post->ID, '_wp_attachment_image_alt', true);
                                //echo '<img alt="'.$alt.'" src="'.$src[0].'"/>'; 
                        
                            //the_post_thumbnail( array(360,240) );
                            } 
    
                            // Add custom meta data (PJA)
                            $tmp_eventtitle = get_post_meta($post->ID, 'Title', true);							
                            $tmp_eventdate = get_post_meta($post->ID, 'Date', true);							
                            // End custom meta data (PJA)
                        ?>
                        <h3 class="event-archive-title"><?php echo $tmp_eventtitle; ?></h3>
                        <span class="event-archive-date"><?php echo $tmp_eventdate; ?></span>
                    </a>
                    <a class="event-button" href="<?php esc_url( the_permalink() ); ?>">View event details</a>
                </article>
    
            <?php $counter++;
          if ($counter % 2 == 0) {
          echo '</section><section class="row">';
        }
        ?>
  </section><!-- /row -->

                <?php 
                $post_num++;
                endwhile; // end of the loop. ?>
            
            
            
  

            <!-- PJA Addition -->
        

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
