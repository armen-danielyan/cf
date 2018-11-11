<?php
add_action( 'init', 'createQuestionPostType', 0 );
function createQuestionPostType() {

	$labels = array(
		'name'                  => 'Questions',
		'singular_name'         => 'Question',
		'menu_name'             => 'Questions',
		'parent_item_colon'     => 'Question',
		'all_items'             => 'All Questions',
		'view_item'             => 'View Question',
		'add_new_item'          => 'Add New Question',
		'add_new'               => 'Add New',
		'edit_item'             => 'Edit Question',
		'update_item'           => 'Update Question',
		'search_items'          => 'Search Question',
		'not_found'             => 'Not Found',
		'not_found_in_trash'    => 'Not found in Trash'
	);

	$args = array(
		'label'                 => 'questions',
		'description'           => 'Questions list',
		'menu_icon'             => 'dashicons-testimonial',
		'menu_position'         => 31,
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
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
		'register_meta_box_cb'  => 'addQuestionMetaboxes'
	);

	register_post_type( 'questions', $args );
}

function addQuestionMetaboxes() {
    add_meta_box( 'cf_questions_translations', 'Translations', 'cfQuestionsTranslations', 'questions', 'normal', 'high' );
}

function cfQuestionsTranslations() {
    global $post; ?>

    <input type="hidden" name="_cf_questions_nonce" id="_cf_questions_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />

    <?php foreach(CF_LANG as $lang) : ?>
        <?php $metaKey = '_cf_question_lang_' . $lang;
        $cfQuestionLang = get_post_meta($post->ID, $metaKey, true); ?>
        <label for="<?php echo $metaKey; ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/flags/' . $lang . '.png'; ?>" alt=""></label>
        <input id="<?php echo $metaKey; ?>" type="text" name="<?php echo $metaKey; ?>" value="<?php echo $cfQuestionLang; ?>" class="widefat" /><br><br>
    <?php endforeach; ?>
<?php }

add_action( 'save_post', 'saveQuestionMetaboxes', 1, 2 );
function saveQuestionMetaboxes($post_id, $post) {
    if ( !wp_verify_nonce($_POST['_cf_questions_nonce'], plugin_basename(__FILE__)) ) return $post->ID;
    if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;

    $questionsMeta = [];
    foreach(CF_LANG as $lang) {
        $metaKey = '_cf_question_lang_' . $lang;
        $questionsMeta[$metaKey] = $_POST[$metaKey];
    }

    foreach ($questionsMeta as $key => $value) {
        if( $post->post_type == 'revision' ) return;
        $value = implode(',', (array)$value);
        if(get_post_meta($post->ID, $key, false)) {
            update_post_meta($post->ID, $key, $value);
        } else {
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key);
    }
}