<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 99 );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

/**
 * Featured image slider, displayed on front page for static page and blog
 */
function dazzling_featured_slider() {
  if ( is_front_page() && of_get_option( 'dazzling_slider_checkbox' ) == 1 ) {
    echo '<div class="flexslider">';
      echo '<ul class="slides">';

        $count = of_get_option( 'dazzling_slide_number' );
        // $slidecat =of_get_option( 'dazzling_slide_categories' );

        $query = new WP_Query( array( 'posts_per_page' =>$count, 'post_type' => 'page', 'meta_key' => 'slider_page' ) );
        if ($query->have_posts()) :
          while ($query->have_posts()) : $query->the_post();

          echo '<li><a href="'. get_permalink() .'">';
            if ( (function_exists( 'has_post_thumbnail' )) && ( has_post_thumbnail() ) ) :
              echo get_the_post_thumbnail();
            endif;

$post=get_post();
              echo '<div class="flex-caption">';
                  if ( get_the_title() != '' ) echo '<h2 class="entry-title">'. get_post_meta(get_the_ID(), 'page_title', true) .'</h2>';
                  echo '<div class="excerpt">'. get_post_meta(get_the_ID(), 'page_excerpt', true) .'</div>';
              echo '</div>';
              echo '</a></li>';
              endwhile;
            endif;

      echo '</ul>';
    echo ' </div>';
  } 
  
}

/*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  add_theme_support( 'post-thumbnails' );

  add_image_size( 'dazzling-featured', 930, 526, true );
  add_image_size( 'tab-small', 60, 60 , true); // Small Thumbnail

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'primary'      => __( 'Primary Menu', 'dazzling' ),
    'footer-links' => __( 'Footer Links', 'dazzling' ) // secondary menu in footer
  ) );
  
/** Custom post type for Events **/
add_action('init', 'events_init');

function events_init() 
    {
	   $labels = array(
					'name' => _x('Events', 'post type general name'),
					'singular_name' => _x('Event', 'post type singular name'),
					'add_new' => _x('Add New', 'event'),
					'add_new_item' => __('Add New Event'),
					'edit_item' => __('Edit This Event'),
					'new_item' => __('New Event'),
					'view_item' => __('View This Event'),
					'search_items' => __('Search Events'),
					'not_found' => __('No Event found'),
					'not_found_in_trash' => __('No Event found in Trash'),
					'menu_name' => __('Events')
					);
	   $args = array(
				  'labels' => $labels,
				  'public' => true,
				  'publicly_queryable' => true,
				  'query_var' => true,
          'rewrite' => array('slug' => 'events', 'with_front'=> false ),
				  'capability_type' => 'post',
				  'hierarchical' => true,
				  'taxonomies' => array('category'),				  
				  'menu_postition' => null,
				  'has_archive' => true,
				  'show_in_menu' => true,
  				'supports' => array('title','category','editor','excerpt','custom-fields','thumbnail','page-attributes','post-formats','site_layouts','site_layout'),
				  'show_in_nav_menus' => true,
          'can_export' => TRUE,
          'show_ui' => TRUE
				  );
	   register_post_type('events',$args);
    }


/** Custom sidebar for Events **/

add_action( 'widgets_init', 'ci_register_sidebar' );

function ci_register_sidebar(){
 register_sidebar(array(
 'id' => 'events',
 'name' => 'Events sidebar',
 'description' => 'Events sidebar',
 'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
 'after_widget' => '</aside>',
 'before_title' => '<h3 class="widget-title">',
 'after_title' => '</h3>',
 ));
}

/** Removes parent class from Posts for custom post type **/
function theme_current_type_nav_class($css_class, $item) {
    static $custom_post_types, $post_type, $filter_func;

    if (empty($custom_post_types))
        $custom_post_types = get_post_types(array('_builtin' => false));

    if (empty($post_type))
        $post_type = get_post_type();

    if ('page' == $item->object && in_array($post_type, $custom_post_types)) {
        $css_class = array_filter($css_class, function($el) {
            return $el !== "current_page_parent";
        });

        $template = get_page_template_slug($item->object_id);
        if (!empty($template) && preg_match("/^page(-[^-]+)*-$post_type/", $template) === 1)
            array_push($css_class, 'current_page_parent');

    }

    return $css_class;
}
add_filter('nav_menu_css_class', 'theme_current_type_nav_class', 1, 2);



/** Adds class to custom post type menu for styling menu item **/

add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2 );
	
	function add_current_nav_class($classes, $item) {
		
		// Getting the current post details
		global $post;
		
		// Getting the post type of the current post
		$current_post_type = get_post_type_object(get_post_type($post->ID));
		$current_post_type_slug = $current_post_type->rewrite[slug];
			
		// Getting the URL of the menu item
		$menu_slug = strtolower(trim($item->url));
		
		// If the menu item URL contains the current post types slug add the current-menu-item class
		if (strpos($menu_slug,$current_post_type_slug) !== false) {
		
		   $classes[] = 'current-menu-item';
		
		}
		
		// Return the corrected set of classes to be added to the menu item
		return $classes;
	
	}
  
  /** Change slug for past events **/
function custom_event_permalink($url, $post) {
    if ('events' === $post->post_type) { // Notice the lowercase 'events'
        $past_events_category_id = 10;
        $has_past_events_category = has_category($past_events_category_id, $post->ID);

        if ($has_past_events_category) {
            $url = home_url('/past-events/' . $post->post_name); // The structure you desire for past events
        }
    }
    return $url;
}
add_filter('post_type_link', 'custom_event_permalink', 10, 2);

function custom_event_rewrite_rule() {
    add_rewrite_rule(
        '^past-events/([^/]+)/?',
        'index.php?post_type=events&name=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_event_rewrite_rule');

/** Upcoming Events Shortcode */
function mf_upcoming_events_shortcode($atts) {
    ob_start();

    $args = array(
        'post_type' => 'Events',
        'posts_per_page' => 3,
        'post_parent' => 0,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'cat' => 7 // assuming 7 is your "Events" category ID
    );
    $event_query = new WP_Query($args);
    ?>

    <section class="upcoming-events-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2>Upcoming Events</h2>
                    <hr class="half-rule">
                </div>
            </div>
            <div class="row row-spacer row-equal-height">
                <?php
                if ($event_query->have_posts()) :
                    while ($event_query->have_posts()) : $event_query->the_post();
                        $event_title = get_post_meta(get_the_ID(), 'Title', true);
                        $event_date = get_post_meta(get_the_ID(), 'Date', true);
                        $booking_url = get_post_meta(get_the_ID(), 'Booking url', true);
                ?>
                <article class="col-sm-4">
                    <div class="event-card">
                        <div class="event-image-wrapper">
                            <a href="<?php the_permalink(); ?>" class="news-post-thumbnail">
                                <?php 
                                if (has_post_thumbnail()) {
                                    if (get_post_meta(get_the_ID(), 'sold_out', true)) {
                                        echo '<div class="sold-out-banner">Sold Out</div>';
                                    }
                                    echo get_the_post_thumbnail(get_the_ID(), array(450, 252), array('class' => 'img-responsive'));
                                }
                                ?>
                            </a>
                        </div>

                        <div class="event-card-body">
                            <h3 class="event-archive-title"><?php echo esc_html($event_title); ?></h3>
                            <p class="event-archive-date"><?php echo esc_html($event_date); ?></p>
                            <p><a href="<?php the_permalink(); ?>">View event details ›</a></p>
                        </div>
                        
                        <?php
                            $details_url = get_permalink();
                            $booking_url = trim((string) $booking_url);
                        
                            if (!empty($booking_url)) {
                                $button_url    = $booking_url;
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
                        
                    </div>
                </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <div class="col-sm-12">
                    <p class="text-center">No upcoming events at the moment. Please check back later!</p>
                </div>
                <?php endif; ?>
            </div>

            <?php 
            // Count all Events assigned to the "Events" category
            $events_count_query = new WP_Query(array(
                'post_type' => 'Events',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'cat' => 7
            ));
            $total_events = $events_count_query->found_posts;

            if ($total_events > 3) :
                $events_archive_link = get_post_type_archive_link('events');
            ?>
            <div class="row">
                <div class="col-sm-12 text-center" style="margin-bottom: 20px;">
                    <a class="btn btn-lg cfa-button-pink" style="width: 100%; font-size: 21px; padding-top: 20px; padding-bottom: 20px;" href="<?php echo esc_url($events_archive_link); ?>">View All Events ›</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php
    return shortcode_unautop(ob_get_clean());
}
add_shortcode('upcoming_events', 'mf_upcoming_events_shortcode');


/** 
 * Remove random <p> and <br> tags around shortcodes on the homepage only
 */
function mf_disable_wpautop_on_home($content) {
    if (is_front_page()) {
        remove_filter('the_content', 'wpautop');
        remove_filter('the_content', 'shortcode_unautop');
        add_filter('the_content', 'do_shortcode', 11); // Ensure shortcodes are parsed later
    }

    return $content;
}
add_filter('the_content', 'mf_disable_wpautop_on_home', 0);

/** 
 * Mobile Nav
 */

add_action('wp_enqueue_scripts', function () {
  // Ensure jQuery is present
  wp_enqueue_script('jquery');

  // Enqueue our tiny toggle script in the footer
  wp_enqueue_script(
    'mf-mobile-nav',
    get_stylesheet_directory_uri() . '/js/mobile-nav.js',
    array('jquery'),
    '1.0',
    true
  );
}, 30);

 
?>