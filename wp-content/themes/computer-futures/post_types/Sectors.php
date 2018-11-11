<?php
add_action( 'init', 'createSectorPostType', 0 );
function createSectorPostType() {

	$labels = array(
		'name'                  => 'Sectors',
		'singular_name'         => 'Sectors',
		'menu_name'             => 'Sectors',
		'parent_item_colon'     => 'Sector',
		'all_items'             => 'All Sectors',
		'view_item'             => 'View Sector',
		'add_new_item'          => 'Add New Sector',
		'add_new'               => 'Add New',
		'edit_item'             => 'Edit Sector',
		'update_item'           => 'Update Sector',
		'search_items'          => 'Search Sector',
		'not_found'             => 'Not Found',
		'not_found_in_trash'    => 'Not found in Trash'
	);

	$args = array(
		'label'                 => 'sectors',
		'description'           => 'Sectors list',
		'menu_icon'             => 'dashicons-menu',
		'menu_position'         => 32,
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

	register_post_type( 'sectors', $args );
}