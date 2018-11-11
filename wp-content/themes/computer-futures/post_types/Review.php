<?php
add_action( 'init', 'createReviewPostType', 0 );
function createReviewPostType() {
	$labels = array(
		'name'                  => 'Reviews',
		'singular_name'         => 'Review',
		'menu_name'             => 'Reviews',
		'parent_item_colon'     => 'Review',
		'all_items'             => 'All Reviews',
		'view_item'             => 'View Review',
		'add_new_item'          => 'Add New Review',
		'add_new'               => 'Add New',
		'edit_item'             => 'Edit Review',
		'update_item'           => 'Update Review',
		'search_items'          => 'Search Review',
		'not_found'             => 'Not Found',
		'not_found_in_trash'    => 'Not found in Trash'
	);

	$args = array(
		'label'                 => 'reviews',
		'description'           => 'Reviews list',
		'menu_icon'             => 'dashicons-star-empty',
		'menu_position'         => 29,
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
		'register_meta_box_cb'  => 'addReviewMetaboxes'
	);

	register_post_type( 'reviews', $args );
}

function addReviewMetaboxes() {
    add_meta_box( 'cf_review_translations', 'Translations', 'cfReviewsTranslations', 'reviews', 'normal', 'high' );
    add_meta_box( 'cf_review_data', 'Data', 'cfReviewData', 'reviews', 'normal', 'high' );
}

function cfReviewsTranslations() {
    global $post; ?>

    <?php foreach(CF_LANG as $lang) : ?>
        <?php $metaKey = '_cf_review_lang_' . $lang;
        $cfReviewLang = get_post_meta($post->ID, $metaKey, true); ?>
        <label for="<?php echo $metaKey; ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/flags/' . $lang . '.png'; ?>" alt=""></label>
        <input id="<?php echo $metaKey; ?>" type="text" name="<?php echo $metaKey; ?>" value="<?php echo $cfReviewLang; ?>" class="widefat" /><br><br>
    <?php endforeach; ?>
<?php }

function cfReviewData() {
	global $post; ?>

	<input type="hidden" name="_cf_review_data_nonce" id="_cf_review_data_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />

	<?php $cfUserType = get_post_meta($post->ID, '_cf_review_target_user_type', true); ?>
    <label for="_cf_review_target_user_type">Target User Type</label><br>
    <select name="_cf_review_target_user_type" id="_cf_review_target_user_type">
        <option value="candidate" <?php selected($cfUserType, 'candidate'); ?>>Candidate</option>
        <option value="project-manager" <?php selected($cfUserType, 'project-manager'); ?>>Manager</option>
    </select>

    <br>
    <br>

	<?php $cfComment = get_post_meta($post->ID, '_cf_review_comment', true); ?>
    <label for="_cf_review_comment">Comment</label>
    <textarea id="_cf_review_comment" name="_cf_review_comment" cols="30" rows="4" class="widefat"><?php echo $cfComment; ?></textarea>

    <br>
    <br>

	<?php $cfQuestionsRaw = get_post_meta($post->ID, '_cf_review_questions', true);
    $cfQuestions = unserialize($cfQuestionsRaw);

    $argsQ = array(
        'post_type' => 'questions',
        'posts_per_page'   => -1,
    );
    $qs = new WP_Query($argsQ); ?>
    <label for="questions_meta_item">Questions</label>
    <div id="questions_meta_item">
        <?php if ( count( $cfQuestions ) > 0 && is_array($cfQuestions)) {
	        foreach( $cfQuestions as $cfQuestion ) { ?>
                <p>
                    <select name="_cf_review_questions[]">
                        <?php if($qs->have_posts()): while($qs->have_posts()): $qs->the_post(); ?>
                            <option value="<?php the_ID(); ?>" <?php selected( $cfQuestion, get_the_ID() ); ?>><?php the_title(); ?></option>
                        <?php endwhile; endif; ?>
                    </select>

                    <a href="#" class="remove-package">Remove</a>
                </p>
	        <?php }
        }
        ?>
        <span id="output-package"></span>
        <a href="#" class="add_package">Add</a>
        <script>
            var $ = jQuery.noConflict();
            $(document).ready(function() {
                $(".add_package").click(function() {

                    $('#output-package').append(
                        '<p>' +
                            '<select name="_cf_review_questions[]">' +
                                <?php if($qs->have_posts()): while($qs->have_posts()): $qs->the_post(); ?>
                                    '<option value="<?php the_ID(); ?>"><?php the_title(); ?></option>' +
                                <?php endwhile; endif; ?>
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
<?php }

add_action( 'save_post', 'saveReviewMetaboxes', 1, 2 );
function saveReviewMetaboxes($post_id, $post) {
	if ( !wp_verify_nonce($_POST['_cf_review_data_nonce'], plugin_basename(__FILE__)) ) return $post->ID;
	if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;

	$reviewsMeta['_cf_review_questions'] = serialize($_POST['_cf_review_questions']);
	$reviewsMeta['_cf_review_comment'] = $_POST['_cf_review_comment'];
	$reviewsMeta['_cf_review_target_user_type'] = $_POST['_cf_review_target_user_type'];

    foreach(CF_LANG as $lang) {
        $metaKey = '_cf_review_lang_' . $lang;
        $reviewsMeta[$metaKey] = $_POST[$metaKey];
    }

	foreach ($reviewsMeta as $key => $value) {
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