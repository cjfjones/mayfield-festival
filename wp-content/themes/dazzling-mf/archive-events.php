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
 * @package dazzling
 */

get_header(); ?>
<div class="sub-page-title">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
                <?php 
        			$page_id = 47; // 47/826 should be replaced with a specific Page's id from your site, which you can find by mousing over the link to edit that Page on the Manage Pages admin page. The id will be embedded in the query string of the URL, e.g. page.php?action=edit&post=123.
        			$page_data = get_page( $page_id ); // You must pass in a variable to the get_page function. If you pass in a value (e.g. get_page ( 123 ); ), WordPress will generate an error. 
        			$content = apply_filters('the_content', $page_data->post_content); // Get Content and retain Wordpress filters such as paragraph tags. Origin from: http://wordpress.org/support/topic/get_pagepost-and-no-paragraphs-problem
        			$title = $page_data->post_title; // Get title
        			//echo $content; // Output Content
        		?>
				<?php if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
				    }
			     ?>
				<h1 class="entry-title"><?php echo $title; ?></h1>
			</div>
		</div>
	</div>
</div>
<div class="container">
    <div class="row">
		<section id="primary" class="content-area col-sm-12">
			<main id="main" class="site-main" role="main">
                <?php 
        			$page_id = 47; // 47/826 should be replaced with a specific Page's id from your site, which you can find by mousing over the link to edit that Page on the Manage Pages admin page. The id will be embedded in the query string of the URL, e.g. page.php?action=edit&post=123.
        			$page_data = get_page( $page_id ); // You must pass in a variable to the get_page function. If you pass in a value (e.g. get_page ( 123 ); ), WordPress will generate an error. 
        			$content = apply_filters('the_content', $page_data->post_content); // Get Content and retain Wordpress filters such as paragraph tags. Origin from: http://wordpress.org/support/topic/get_pagepost-and-no-paragraphs-problem
        			$title = $page_data->post_title; // Get title
        			//echo $content; // Output Content
        		?>

                <div class="entry-content">
                    <?php 
                        $args = array(
                            'post_type' => 'Events',
                            'posts_per_page' => 999,
                            'post_parent' => 0,
                            'orderby' => 'menu_order',
                            'order' => 'ASC',
                            'cat' => 7
                        );
                        $query = new WP_Query( $args );
                        $post_count = $query->post_count;

                    ?>
                 
                        <section class="row row-spacer">
                            <div class="col-sm-12">
                                <?php echo $content; ?>  
                            </div>
                        </section>
                        <section class="row row-spacer row-equal-height">
                            <?php if($post_count == 0) : ?>
                            <div>Coming soon.</div>
                            <?php endif; ?>
                            <?php
                            $counter = 0;     
                            $post_num = 0;
                                while ( $query->have_posts() ) : $query->the_post();
                             ?>
                            <article class="col-sm-4<?php if (($post_num % 2) == 0) : endif; ?>">
                              <div class="event-card">
                              
                                <!-- Thumbnail Image -->
                                <a class="news-post-thumbnail" href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title(); ?>" rel="bookmark">
                                  <div class="event-image-wrapper">
                                    <?php 
                                    if (has_post_thumbnail()) {
                                      if (get_post_meta($post->ID, 'sold_out', true)) {
                                        echo '<div class="sold-out-banner">Sold Out</div>';
                                      }
                                      echo get_the_post_thumbnail($post->ID, array('450,252'), array('class' => 'img-responsive'));
                                    }
                                    ?>
                                  </div>
                                </a>
                            
                                <!-- Body content -->
                                <div class="event-card-body">
                                  <?php 
                                  // Custom Meta Data
                                  $tmp_eventtitle = get_post_meta($post->ID, 'Title', true);							
                                  $tmp_eventdate = get_post_meta($post->ID, 'Date', true);
                                  $tmp_eventbookingurl = get_post_meta($post->ID, 'Booking url', true);													
                                  ?>
                            
                                  <h3 class="event-archive-title"><?php echo esc_html($tmp_eventtitle); ?></h3>
                                  <p class="event-archive-date"><?php echo esc_html($tmp_eventdate); ?></p>
                                  <p><a href="<?php echo esc_url(get_permalink()); ?>">View event details ›</a></p>
                                </div>
                            
                                <!-- Footer with Book Now button -->
                                <?php
                                    $details_url = get_permalink();
                                    $tmp_eventbookingurl = trim((string) $tmp_eventbookingurl);
                                
                                    if (!empty($tmp_eventbookingurl)) {
                                        $button_url    = $tmp_eventbookingurl;
                                        $button_text   = 'Book now';
                                        $button_target = '_blank';
                                    } else {
                                        $button_url    = $details_url;
                                        $button_text   = 'View event details';
                                        $button_target = '';
                                    }
                                ?>
                                <div class="event-card-footer">
                                    <a class="btn btn-lg btn-default event-button"
                                       href="<?php echo esc_url($button_url); ?>"
                                       <?php echo $button_target ? 'target="' . esc_attr($button_target) . '"' : ''; ?>>
                                        <?php echo esc_html($button_text); ?>
                                    </a>
                                </div>
                            
                              </div> <!-- /.event-card -->
                            </article>

                <?php $post_num++; ?>
				<?php $counter++;
					if ($counter % 3 == 0) {
				  	echo '</section><section class="row row-spacer row-equal-height">';
					}
					endwhile; // end of the loop.
				?>
  			</section>
            <section class="row row-spacer">
                <div class="col-sm-12">
                    <hr style="padding-top: 20px;"/>
                    <p class="text-center"><a href="#footer-area">Sign up to our newsletter</a> to be the first to know about upcoming events.</p>
                </div>
            </section>
		</div><!-- .entry-content -->
		</main><!-- .site-main -->
	</div><!-- .content-area -->
</div>
<?php get_footer(); ?>