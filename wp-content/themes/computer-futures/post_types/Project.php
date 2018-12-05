<?php
add_action( 'init', 'createProjectPostType', 0 );
function createProjectPostType() {

	$labels = array(
		'name'                  => 'Projects',
		'singular_name'         => 'Project',
		'menu_name'             => 'Projects',
		'parent_item_colon'     => 'Project',
		'all_items'             => 'All Projects',
		'view_item'             => 'View Project',
		'add_new_item'          => 'Add New Project',
		'add_new'               => 'Add New',
		'edit_item'             => 'Edit Project',
		'update_item'           => 'Update Project',
		'search_items'          => 'Search Project',
		'not_found'             => 'Not Found',
		'not_found_in_trash'    => 'Not found in Trash'
	);

	$args = array(
		'label'                 => 'projects',
		'description'           => 'Projects list',
		'menu_icon'             => 'dashicons-feedback',
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
		'register_meta_box_cb'  => 'addProjectMetaboxes'
	);

	register_post_type( 'projects', $args );
}

function addProjectMetaboxes() {
    add_meta_box( 'cf_project_translations', 'Translations', 'cfProjectsTranslations', 'projects', 'normal', 'high' );
	add_meta_box( 'cf_project_data', 'Information', 'cfProjectData', 'projects', 'normal', 'high' );
}

function cfProjectsTranslations() {
    global $post; ?>

    <?php foreach(CF_LANG as $lang) : ?>
        <?php $metaKey = '_cf_project_lang_' . $lang;
        $cfProjectLang = get_post_meta($post->ID, $metaKey, true); ?>
        <label for="<?php echo $metaKey; ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/flags/' . $lang . '.png'; ?>" alt=""></label>
        <input id="<?php echo $metaKey; ?>" type="text" name="<?php echo $metaKey; ?>" value="<?php echo $cfProjectLang; ?>" class="widefat" /><br><br>
    <?php endforeach; ?>
<?php }

function cfProjectData() {
	global $post; ?>

	<input type="hidden" name="_cf_project_data_nonce" id="_cf_project_data_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />

	<?php $cfStarts = get_post_meta($post->ID, '_cf_project_starts', true); ?>
	<label for="_cf_project_starts">Starts</label>
	<input id="_cf_project_starts" type="date" name="_cf_project_starts" value="<?php echo $cfStarts; ?>" class="widefat" />

	<?php $cfEnds = get_post_meta($post->ID, '_cf_project_ends', true); ?>
	<label for="_cf_project_ends">Ends</label>
	<input id="_cf_project_ends" type="date" name="_cf_project_ends" value="<?php echo $cfEnds; ?>" class="widefat" />

	<?php $cfSector = get_post_meta($post->ID, '_cf_project_sector', true);
	$sectors = getCustomItems('sectors'); ?>
	<label for="_cf_project_sector">Sector</label>
	<select name="_cf_project_sector" class="widefat" id="_cf_project_sector">
		<?php foreach($sectors as $s) { ?>
            <option value="<?php echo $s; ?>" <?php selected( $cfSector, $s ); ?>><?php echo $s; ?></option>
		<?php } ?>
	</select>

    <?php $cfCompany = get_post_meta($post->ID, '_cf_project_company', true);
    $cfCompanies = get_posts( array(
        'post_type' => 'companies',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby'  => 'title',
        'order' => 'ASC',
    ) ); ?>
    <label for="_cf_project_company">Company</label>
    <select name="_cf_project_company" class="widefat" id="_cf_project_company">
        <?php foreach($cfCompanies as $s) { ?>
            <option value="<?php echo $s->ID; ?>" <?php selected( $cfCompany, $s->ID ); ?>><?php echo $s->post_title; ?></option>
        <?php } ?>
    </select>

	<?php $cfAddress = get_post_meta($post->ID, '_cf_project_address', true); ?>
	<label for="_cf_project_address">Address</label>
	<input id="_cf_project_address" type="text" name="_cf_project_address" value="<?php echo $cfAddress; ?>" class="widefat" />

	<?php $cfN = get_post_meta($post->ID, '_cf_project_N', true); ?>
	<label for="_cf_project_N">No. + ext.</label>
	<input id="_cf_project_N" type="text" name="_cf_project_N" value="<?php echo $cfN; ?>" class="widefat" />

	<?php $cfZipCode = get_post_meta($post->ID, '_cf_project_zipcode', true); ?>
	<label for="_cf_project_zipcode">Zip Code</label>
	<input id="_cf_project_zipcode" type="text" name="_cf_project_zipcode" value="<?php echo $cfZipCode; ?>" class="widefat" />

	<?php $cfCity = get_post_meta($post->ID, '_cf_project_city', true); ?>
	<label for="_cf_project_city">City</label>
	<input id="_cf_project_city" type="text" name="_cf_project_city" value="<?php echo $cfCity; ?>" class="widefat" />

	<?php $cfTechnique = get_post_meta($post->ID, '_cf_project_technique', true); ?>
	<label for="_cf_project_technique">Technique</label>
	<select name="_cf_project_technique" class="widefat" id="_cf_project_technique">
		<option value="Technique 1" <?php selected( $cfTechnique, 'Technique 1' ); ?>>Technique 1</option>
		<option value="Technique 2" <?php selected( $cfTechnique, 'Technique 2' ); ?>>Technique 2</option>
		<option value="Technique 3" <?php selected( $cfTechnique, 'Technique 3' ); ?>>Technique 3</option>
		<option value="Technique 4" <?php selected( $cfTechnique, 'Technique 4' ); ?>>Technique 4</option>
	</select>

	<?php $cfDescription = get_post_meta($post->ID, '_cf_project_description', true); ?>
	<label for="_cf_project_description">Description</label>
	<textarea id="_cf_project_description" name="_cf_project_description" cols="30" rows="4" class="widefat"><?php echo $cfDescription; ?></textarea>

    <br>

	<?php $consultantId = get_post_meta($post->ID, '_cf_project_consultant', true);
	$argsU = array(
		'role' => 'consultant'
	);
	$userQuery = new WP_User_Query( $argsU ); ?>
    <label for="_cf_project_consultant">Consultant</label>
    <select name="_cf_project_consultant" id="_cf_project_consultant" class="widefat">
        <option value=""></option>
		<?php foreach ( $userQuery->get_results() as $user ) { ?>
            <option value="<?php echo $user->ID; ?>" <?php selected( $consultantId, $user->ID ); ?>><?php echo $user->display_name; ?></option>
		<?php } ?>
    </select>

    <br>

	<?php $cfCompleted = get_post_meta($post->ID, '_cf_project_completed', true); ?>
    <label for="_cf_project_completed">Project Completed</label>
    <select name="_cf_project_completed" class="widefat" id="_cf_project_completed">
        <option value="2" <?php selected( $cfCompleted, 2 ); ?>>No</option>
        <option value="1" <?php selected( $cfCompleted, 1 ); ?>>Yes</option>
    </select>

    <br>
    <br>

    <?php $cfUsersRaw = get_post_meta($post->ID, '_cf_project_users', true);
	$cfUsers = unserialize($cfUsersRaw);

	$argsU = array(
		'role__in' => array('candidate', 'project-manager')
    );
    $userQuery = new WP_User_Query( $argsU ); ?>

    <label for="users_meta_item">Users</label>
    <div id="users_meta_item">
	    <?php $c = 0;
	    if ( is_array($cfUsers) && count( $cfUsers ) > 0 ) {
		    foreach( $cfUsers as $cfUser ) { ?>
                <p>
                    <select name="_cf_project_users[<?php echo $c; ?>]">
                        <?php foreach ( $userQuery->get_results() as $user ) { ?>
                            <option value="<?php echo $user->ID; ?>" <?php selected( $cfUser, $user->ID ); ?>><?php echo $user->display_name; ?> (<?php echo $user->roles[0]; ?>)</option>
                        <?php } ?>
                    </select>

                    <a href="#" class="remove-package">Remove</a>
                </p>
                <?php $c++;
		    }
	    } ?>

        <span id="output-package"></span>
        <a href="#" class="add_package">Add</a>
        <script>
            var $ = jQuery.noConflict();
            $(document).ready(function() {
                var count = <?php echo $c; ?>;
                $(".add_package").click(function() {
                    count++;
                    $('#output-package').append(
                        '<p>' +
                        '<select name="_cf_project_users[' + count + ']">' +
	                    <?php foreach ( $userQuery->get_results() as $user ) { ?>
                        '<option value="<?php echo $user->ID; ?>"><?php echo $user->display_name; ?> (<?php echo $user->roles[0]; ?>)</option>' +
					    <?php } ?>
                        '</select>' +
                        '<a href="#" class="remove-package">Remove</a>' +
                        '</p>'
                    );
                    return false;
                });
                $(document.body).on('click','.remove-package',function() {
                    $(this).parent().remove();
                });
            });
        </script>
    </div>

    <br>
    <br>

	<?php $cfProjectArchive = get_post_meta($post->ID, '_cf_project_archive', true); ?>
    <label for="_cf_project_archive">Archive</label>
    <input id="_cf_project_archive" type="checkbox" name="_cf_project_archive" value="archived" <?php checked( $cfProjectArchive, 'archived' ); ?> />
<?php }

add_action( 'save_post', 'saveProjectMetaboxes', 1, 2 );
function saveProjectMetaboxes($post_id, $post) {
	if ( !wp_verify_nonce($_POST['_cf_project_data_nonce'], plugin_basename(__FILE__)) ) return $post->ID;
	if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;

	$projectsMeta['_cf_project_starts'] = $_POST['_cf_project_starts'];
    $projectsMeta['_cf_project_ends'] = $_POST['_cf_project_ends'];
    $projectsMeta['_cf_project_sector'] = $_POST['_cf_project_sector'];
    $projectsMeta['_cf_project_company'] = $_POST['_cf_project_company'];
    $projectsMeta['_cf_project_address'] = $_POST['_cf_project_address'];
    $projectsMeta['_cf_project_N'] = $_POST['_cf_project_N'];
    $projectsMeta['_cf_project_zipcode'] = $_POST['_cf_project_zipcode'];
    $projectsMeta['_cf_project_city'] = $_POST['_cf_project_city'];
    $projectsMeta['_cf_project_technique'] = $_POST['_cf_project_technique'];
    $projectsMeta['_cf_project_description'] = $_POST['_cf_project_description'];
    $projectsMeta['_cf_project_consultant'] = $_POST['_cf_project_consultant'];
    $projectsMeta['_cf_project_completed'] = $_POST['_cf_project_completed'];
    $projectsMeta['_cf_project_users'] = serialize($_POST['_cf_project_users']);
    $projectsMeta['_cf_project_archive'] = $_POST['_cf_project_archive'] ? $_POST['_cf_project_archive'] : '';

    foreach(CF_LANG as $lang) {
        $metaKey = '_cf_project_lang_' . $lang;
        $projectsMeta[$metaKey] = $_POST[$metaKey];
    }

	foreach ($projectsMeta as $key => $value) {
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