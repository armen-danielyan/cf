<?php
add_action( 'init', 'createReviewsDonePostType', 0 );
function createReviewsDonePostType() {
	$labels = array(
		'name'                  => 'Reviews Done',
		'singular_name'         => 'Review Done',
		'menu_name'             => 'Reviews Done',
		'parent_item_colon'     => 'Review Done',
		'all_items'             => 'All Reviews Done',
		'view_item'             => 'View Review Done',
		'add_new_item'          => 'Add New Review Done',
		'add_new'               => 'Add New',
		'edit_item'             => 'Edit Review Done',
		'update_item'           => 'Update Review Done',
		'search_items'          => 'Search Review Done',
		'not_found'             => 'Not Found',
		'not_found_in_trash'    => 'Not found in Trash'
	);

	$args = array(
		'label'                 => 'reviews done',
		'description'           => 'Reviews Done list',
		'menu_icon'             => 'dashicons-star-filled',
		'menu_position'         => 30,
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
		'register_meta_box_cb'  => 'addReviewDoneMetaboxes'
	);

	register_post_type( 'reviewsdone', $args );
}

function addReviewDoneMetaboxes() {
	add_meta_box( 'cf_review_done_data', 'Data', 'cfReviewsDoneData', 'reviewsdone', 'normal', 'high' );
}

function cfReviewsDoneData() {
	global $post; ?>

	<input type="hidden" name="_cf_reviews_done_data_nonce" id="_cf_reviews_done_data_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />

	<?php $cfTargetUserId = get_post_meta($post->ID, '_cf_review_done_target_userid', true); ?>
    <label for="_cf_review_done_target_userid">Target User ID</label>
    <input id="_cf_review_done_target_userid" type="number" name="_cf_review_done_target_userid" value="<?php echo $cfTargetUserId; ?>" class="widefat" />

    <br>

	<?php $cfReviewId = get_post_meta($post->ID, '_cf_review_done_reviewid', true); ?>
	<label for="_cf_review_done_reviewid">Review: <?php echo '( ' . get_the_title($cfReviewId) . ' )'; ?></label>
	<input id="_cf_review_done_reviewid" type="number" name="_cf_review_done_reviewid" value="<?php echo $cfReviewId; ?>" class="widefat" />

	<br>

	<?php $cfProjectId = get_post_meta($post->ID, '_cf_review_done_projectid', true); ?>
	<label for="_cf_review_done_projectid">Project: <?php echo '( ' . get_the_title($cfProjectId) . ' )'; ?></label>
	<input id="_cf_review_done_projectid" type="number" name="_cf_review_done_projectid" value="<?php echo $cfProjectId; ?>" class="widefat" />

    <br>

	<?php $cfRating = get_post_meta($post->ID, '_cf_review_done_rating', true); ?>
    <label for="_cf_review_done_rating">Rating</label>
    <input id="_cf_review_done_rating" type="number" name="_cf_review_done_rating" value="<?php echo $cfRating; ?>" class="widefat" />

	<br>

	<?php $cfPeriod = get_post_meta($post->ID, '_cf_select_review_period', true); ?>
    <label for="_cf_select_review_period">Period</label>
    <select name="_cf_select_review_period" class="widefat" id="_cf_select_review_period">
        <option value="1" <?php selected( $cfPeriod, '1' ); ?>>First quarter</option>
        <option value="2" <?php selected( $cfPeriod, '2' ); ?>>Second quarter</option>
        <option value="3" <?php selected( $cfPeriod, '3' ); ?>>Third quarter</option>
        <option value="4" <?php selected( $cfPeriod, '4' ); ?>>Fourth quarter</option>
    </select>

    <br>

	<?php $cfYear = get_post_meta($post->ID, '_cf_select_review_year', true); ?>
    <label for="_cf_select_review_year">Year</label>
    <select name="_cf_select_review_year" class="widefat" id="_cf_select_review_year">
	    <?php $currentYear = date('Y');
	    $backYear = $currentYear - 10;
	    for($i = $backYear; $i <= $currentYear; $i++) { ?>
            <option value="<?php echo $i; ?>" <?php selected($cfYear, $i); ?>><?php echo $i; ?></option>
	    <?php } ?>
    </select>

    <br>

	<?php $cfComment = get_post_meta($post->ID, '_cf_review_done_comment', true); ?>
    <label for="_cf_review_done_comment">Comment</label>
    <textarea id="_cf_review_done_comment" name="_cf_review_done_comment" cols="30" rows="4" class="widefat"><?php echo $cfComment; ?></textarea>

    <br>

	<?php $consultantId = get_post_meta($post->ID, '_cf_review_done_consultant', true);
	$argsU = array(
		'role' => 'consultant'
	);
	$userQuery = new WP_User_Query( $argsU ); ?>
    <label for="_cf_review_done_consultant">Consultant</label>
    <select name="_cf_review_done_consultant" id="_cf_review_done_consultant" class="widefat">
        <option value=""></option>
		<?php foreach ( $userQuery->get_results() as $user ) { ?>
            <option value="<?php echo $user->ID; ?>" <?php selected( $consultantId, $user->ID ); ?>><?php echo $user->display_name; ?></option>
		<?php } ?>
    </select>

    <br>
    <br>

	<?php $cfRated = get_post_meta($post->ID, '_cf_review_done_rated', true); ?>
    <label for="_cf_review_done_rated">Rated</label>
    <input id="_cf_review_done_rated" type="checkbox" name="_cf_review_done_rated" value="1" <?php checked( $cfRated, 1 ); ?> />

    <br>
	<br>

	<?php $cfQuestionsRaw = get_post_meta($post->ID, '_cf_reviews_done_questions', true);
	$cfQuestions = unserialize($cfQuestionsRaw);

	$argsQ = array(
		'post_type' => 'questions',
		'posts_per_page'   => -1,
	);
	$qs = new WP_Query($argsQ); ?>
    <label for="_cf_reviews_done_questions">Questions</label>
    <div id="_cf_reviews_done_questions">
		<?php $c = 0;
		if ( count( $cfQuestions ) > 0 && is_array($cfQuestions)) {
			foreach( $cfQuestions as $cfQuestion ) {
				if ( isset( $cfQuestion['qid'] ) || isset( $cfQuestion['qr'] ) ) { ?>
                    <p>
                        <select name="_cf_reviews_done_questions[<?php echo $c; ?>][qid]">
							<?php if($qs->have_posts()): while($qs->have_posts()): $qs->the_post(); ?>
                                <option value="<?php the_ID(); ?>" <?php selected( $cfQuestion['qid'], get_the_ID() ); ?>><?php the_title(); ?></option>
							<?php endwhile; endif; ?>
                        </select>

                        <input type="number" name="_cf_reviews_done_questions[<?php echo $c; ?>][qr]" value="<?php echo $cfQuestion['qr']; ?>">
                        <a href="#" class="remove-package">Remove</a>
                    </p>
					<?php $c++; ?>
				<?php }
			}
		}
		?>
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
                        '<select name="_cf_reviews_done_questions[' + count + '][qid]">' +
						<?php if($qs->have_posts()): while($qs->have_posts()): $qs->the_post(); ?>
                        '<option value="<?php the_ID(); ?>"><?php the_title(); ?></option>' +
						<?php endwhile; endif; ?>
                        '</select>' +
                        '<input type="number" name="_cf_reviews_done_questions[' + count + '][qr]" />' +
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

add_action( 'save_post', 'saveReviewsDoneMetaboxes', 1, 2 );
function saveReviewsDoneMetaboxes($post_id, $post) {
	if ( !wp_verify_nonce($_POST['_cf_reviews_done_data_nonce'], plugin_basename(__FILE__)) ) return $post->ID;
	if ( !current_user_can( 'edit_post', $post->ID )) return $post->ID;

	$reviewsMeta['_cf_review_done_target_userid'] = $_POST['_cf_review_done_target_userid'];
	$reviewsMeta['_cf_review_done_reviewid'] = $_POST['_cf_review_done_reviewid'];
	$reviewsMeta['_cf_review_done_projectid'] = $_POST['_cf_review_done_projectid'];
	$reviewsMeta['_cf_review_done_rating'] = $_POST['_cf_review_done_rating'];
	$reviewsMeta['_cf_review_done_comment'] = $_POST['_cf_review_done_comment'];
	$reviewsMeta['_cf_review_done_consultant'] = $_POST['_cf_review_done_consultant'];
	$reviewsMeta['_cf_review_done_rated'] = $_POST['_cf_review_done_rated'];
	$reviewsMeta['_cf_reviews_done_questions'] = serialize($_POST['_cf_reviews_done_questions']);
	$reviewsMeta['_cf_select_review_period'] = $_POST['_cf_select_review_period'];
	$reviewsMeta['_cf_select_review_year'] = $_POST['_cf_select_review_year'];

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