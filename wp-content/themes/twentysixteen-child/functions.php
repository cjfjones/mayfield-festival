<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}
?>

<?php
/** Custom post type for Events **/
add_action('init', 'events_init');

function events_init() {
	$labels = array(
					'name' => __('Events', 'post type general name'),
					'singular_name' => __('Event', 'post type singular name'),
					'add_new' => __('Add New', 'event'),
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
				  'rewrite' => array('slug' => 'events'),
				  'capability_type' => 'post',
				  'hierarchical' => true,
				  'taxonomies' => array('category'),				  
				  'menu_postition' => null,
				  'has_archive' => true,
				  'show_in_menu' => true,
				  'supports' => array('title','category','editor','excerpt','custom-fields','thumbnail','page-attributes'),
				  'show_in_nav_menus' => true
				  );
	register_post_type('events',$args);
}
?>