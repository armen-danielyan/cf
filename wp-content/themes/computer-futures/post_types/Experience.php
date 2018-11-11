<?php
add_action( 'init', 'createExperiencePostType', 0 );
function createExperiencePostType() {

	$labels = array(
		'name'                  => 'Experiences',
		'singular_name'         => 'Experience',
		'menu_name'             => 'Experiences',
		'parent_item_colon'     => 'Experience',
		'all_items'             => 'All Experiences',
		'view_item'             => 'View Experience',
		'add_new_item'          => 'Add New Experience',
		'add_new'               => 'Add New',
		'edit_item'             => 'Edit Experience',
		'update_item'           => 'Update Experience',
		'search_items'          => 'Search Experience',
		'not_found'             => 'Not Found',
		'not_found_in_trash'    => 'Not found in Trash'
	);

	$args = array(
		'label'                 => 'experiences',
		'description'           => 'Experiences list',
		'menu_icon'             => 'dashicons-menu',
		'menu_position'         => 35,
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'show_in_admin_bar'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'map_meta_cap'          => true,
		'capability_type'       => 'page',
		'register_meta_box_cb'  => ''
	);

	register_post_type( 'experiences', $args );
}