<?php
add_action( 'init', 'createJobTitlesPostType', 0 );
function createJobTitlesPostType() {

	$labels = array(
		'name'                  => 'Job Titles',
		'singular_name'         => 'Job Title',
		'menu_name'             => 'Job Titles',
		'parent_item_colon'     => 'Job Title',
		'all_items'             => 'All Job Titles',
		'view_item'             => 'View Job Title',
		'add_new_item'          => 'Add New Job Title',
		'add_new'               => 'Add New',
		'edit_item'             => 'Edit Job Titles',
		'update_item'           => 'Update Job Titles',
		'search_items'          => 'Search Job Titles',
		'not_found'             => 'Not Found',
		'not_found_in_trash'    => 'Not found in Trash'
	);

	$args = array(
		'label'                 => 'jobtitles',
		'description'           => 'Job Titles list',
		'menu_icon'             => 'dashicons-menu',
		'menu_position'         => 34,
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

	register_post_type( 'jobtitles', $args );
}