<?php
add_action( 'init', 'createSpecialismPostType', 0 );
function createSpecialismPostType() {

	$labels = array(
		'name'                  => 'Specialisms',
		'singular_name'         => 'Specialisms',
		'menu_name'             => 'Specialisms',
		'parent_item_colon'     => 'Specialism',
		'all_items'             => 'All Specialisms',
		'view_item'             => 'View Specialism',
		'add_new_item'          => 'Add New Specialism',
		'add_new'               => 'Add New',
		'edit_item'             => 'Edit Specialism',
		'update_item'           => 'Update Specialism',
		'search_items'          => 'Search Specialism',
		'not_found'             => 'Not Found',
		'not_found_in_trash'    => 'Not found in Trash'
	);

	$args = array(
		'label'                 => 'specialisms',
		'description'           => 'Specialisms list',
		'menu_icon'             => 'dashicons-menu',
		'menu_position'         => 33,
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

	register_post_type( 'specialisms', $args );
}