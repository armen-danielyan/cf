<?php
add_action( 'init', 'createCompanyPostType', 0 );
function createCompanyPostType() {

	$labels = array(
		'name'                  => 'Companies',
		'singular_name'         => 'Company',
		'menu_name'             => 'Companies',
		'parent_item_colon'     => 'Company',
		'all_items'             => 'All Companies',
		'view_item'             => 'View Company',
		'add_new_item'          => 'Add New Company',
		'add_new'               => 'Add New',
		'edit_item'             => 'Edit Company',
		'update_item'           => 'Update Company',
		'search_items'          => 'Search Company',
		'not_found'             => 'Not Found',
		'not_found_in_trash'    => 'Not found in Trash'
	);

	$args = array(
		'label'                 => 'companies',
		'description'           => 'Companies list',
		'menu_icon'             => 'dashicons-store',
		'menu_position'         => 28,
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
		'register_meta_box_cb'  => 'addCompanyMetaboxes'
	);

	register_post_type( 'companies', $args );
}

function addCompanyMetaboxes() {
	add_meta_box( 'cf_company_data', 'Information', 'cfCompanyData', 'companies', 'normal', 'high' );
}

function cfCompanyData() {
	global $post; ?>

	<input type="hidden" name="_cf_company_data_nonce" id="_cf_company_data_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />

	<?php $cfAddress = get_post_meta($post->ID, '_cf_company_address', true); ?>
	<label for="_cf_company_address">Address</label>
	<input id="_cf_company_address" type="text" name="_cf_company_address" value="<?php echo $cfAddress; ?>" class="widefat" />

	<?php $cfN = get_post_meta($post->ID, '_cf_company_N', true); ?>
	<label for="_cf_company_N">No. + ext.</label>
	<input id="_cf_company_N" type="text" name="_cf_company_N" value="<?php echo $cfN; ?>" class="widefat" />

	<?php $cfZipCode = get_post_meta($post->ID, '_cf_company_zipcode', true); ?>
	<label for="_cf_company_zipcode">Zip Code</label>
	<input id="_cf_company_zipcode" type="text" name="_cf_company_zipcode" value="<?php echo $cfZipCode; ?>" class="widefat" />

	<?php $cfCity = get_post_meta($post->ID, '_cf_company_city', true); ?>
	<label for="_cf_company_city">City</label>
	<input id="_cf_company_city" type="text" name="_cf_company_city" value="<?php echo $cfCity; ?>" class="widefat" />
<?php }

add_action( 'save_post', 'saveCompanyMetaboxes', 1, 2 );
function saveCompanyMetaboxes($post_id, $post) {
	if ( !wp_verify_nonce($_POST['_cf_company_data_nonce'], plugin_basename(__FILE__)) ) return $post->ID;
	if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;

	$companiesMeta['_cf_company_address'] = $_POST['_cf_company_address'];
    $companiesMeta['_cf_company_N'] = $_POST['_cf_company_N'];
    $companiesMeta['_cf_company_zipcode'] = $_POST['_cf_company_zipcode'];
    $companiesMeta['_cf_company_city'] = $_POST['_cf_company_city'];

	foreach ($companiesMeta as $key => $value) {
		if( $post->post_type == 'revision' ) return;
		$value = implode(',', (array)$value);
		if(get_post_meta($post->ID, $key, FALSE)) {
			update_post_meta($post->ID, $key, $value);
		} else {
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key);
	}
}