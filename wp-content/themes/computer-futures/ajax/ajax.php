<?php
/**
 * Remove user from project
 */
add_action( 'wp_ajax_remove_user_from_project', 'removeUserFromProject' );
add_action( 'wp_ajax_nopriv_remove_user_from_project', 'removeUserFromProject' );
function removeUserFromProject() {
	$userId = ( isset( $_POST['user_id'] ) && $_POST['user_id'] ) ? $_POST['user_id'] : false;
	$projectId = ( isset( $_POST['project_id'] ) && $_POST['project_id'] ) ? $_POST['project_id'] : false;

	if ( $userId && $projectId ) {
		$cfUsersRaw = get_post_meta($projectId, '_cf_project_users', true);
		$cfUsers = unserialize($cfUsersRaw);

		$result = [];
		foreach($cfUsers as $key => $value) {
			if($userId != $value) {
				$result[$key] = $value;
			}
		}

		updatePostMeta($projectId, '_cf_project_users', serialize($result));

		echo json_encode( array( 'status' => 1, 'statusMsg' => 'User removed prom the project' ) );
	} else {
		echo json_encode( array( 'status' => 0, 'statusMsg' => 'Something went wrang' ) );
	}

	wp_die();
}

/**
 * Remove user from project
 */
add_action( 'wp_ajax_add_users_to_project', 'addUsersToProject' );
add_action( 'wp_ajax_nopriv_add_users_to_project', 'addUsersToProject' );
function addUsersToProject() {
	$userIds = ( isset( $_POST['user_ids'] ) && $_POST['user_ids'] ) ? $_POST['user_ids'] : false;
	$projectId = ( isset( $_POST['project_id'] ) && $_POST['project_id'] ) ? $_POST['project_id'] : false;

	if ( $userIds && $projectId ) {
		$cfUsersRaw = get_post_meta($projectId, '_cf_project_users', true);
		$cfUsers = unserialize($cfUsersRaw);

		foreach ($userIds as $userId) {
			if(!in_array($userId, $cfUsers)) {
				$cfUsers[] = $userId;
			}
		}

		updatePostMeta($projectId, '_cf_project_users', serialize($cfUsers));

		echo json_encode( array( 'status' => 1, 'statusMsg' => 'User removed prom the project' ) );
	} else {
		echo json_encode( array( 'status' => 0, 'statusMsg' => 'Something went wrang' ) );
	}

	wp_die();
}

/**
 * Create Review Done
 */
add_action( 'wp_ajax_create_review_done', 'createReviewDone' );
add_action( 'wp_ajax_nopriv_create_review_done', 'createReviewDone' );
function createReviewDone() {
	$period = ( isset( $_POST['period'] ) && $_POST['period'] ) ? $_POST['period'] : false;
	$year = ( isset( $_POST['year'] ) && $_POST['year'] ) ? $_POST['year'] : false;
	$reviewId = ( isset( $_POST['reviewId'] ) && $_POST['reviewId'] ) ? $_POST['reviewId'] : false;
	$projectId = ( isset( $_POST['projectId'] ) && $_POST['projectId'] ) ? $_POST['projectId'] : false;
	$users = ( isset( $_POST['users'] ) && $_POST['users'] ) ? explode(',', $_POST['users']) : [];

	$projectConsultantId = get_post_meta($projectId, '_cf_project_consultant', true);

	if ( $period && $year && $reviewId && $projectId && count($users) > 0) {

		$questionsRaw = get_post_meta($reviewId, '_cf_review_questions', true);
		$questions = unserialize($questionsRaw);
		$questionsRates = [];
		foreach($questions as $question) {
			array_push($questionsRates, array('qid' => $question, 'qr' => ''));
		}

		foreach ($users as $user) {
			$myPost = array(
				'post_title' => 'Review Done ' . $user . '-' . date('d-m-Y h:i'),
				'post_type' => 'reviewsdone',
				'post_status' => 'publish',
				'meta_input' => array(
					'_cf_review_done_reviewid' => $reviewId,
					'_cf_review_done_projectid' => $projectId,
					'_cf_review_done_target_userid' => $user,
					'_cf_review_done_consultant' => $projectConsultantId,
					'_cf_reviews_done_questions' => serialize($questionsRates),
					'_cf_select_review_period' => $period,
					'_cf_select_review_year' => $year,
				)
			);

			wp_insert_post( $myPost );
		}



		echo json_encode( array( 'status' => 1, 'statusMsg' => 'Review Done Created' ) );
	} else {
		echo json_encode( array( 'status' => 0, 'statusMsg' => 'Something went wrang' ) );
	}

	wp_die();
}
