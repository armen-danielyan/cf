<?php

class CF_API extends WP_REST_Controller {
	public function register_routes() {
		$version = '1';
		$namespace = 'cf/v' . $version;

		register_rest_route( $namespace, '/forgot', array(
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'forgotPassword' ),
				'args'                => array(

				),
			),
		) );

		register_rest_route( $namespace, '/managers', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'getManagers' ),
				'permission_callback' => array( $this, 'user_loggedin_permissions_check' ),
				'args'                => array(

				),
			),
		) );

		register_rest_route( $namespace, '/candidates', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'getCandidates' ),
				'permission_callback' => array( $this, 'user_loggedin_permissions_check' ),
				'args'                => array(

				),
			),
		) );

		register_rest_route( $namespace, '/reviews', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'getReviewsByManager' ),
				'permission_callback' => array( $this, 'user_loggedin_permissions_check' ),
				'args'                => array(

				),
			),
		) );

		register_rest_route( $namespace, '/reviews/(?P<id>\d+)', array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'getReview' ),
				'permission_callback' => array( $this, 'user_loggedin_permissions_check' ),
				'args'                => array(

				),
			),
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'setReview' ),
				'permission_callback' => array( $this, 'user_loggedin_permissions_check' ),
				'args'                => array(

				),
			),
		) );
	}

	public function forgotPassword(WP_REST_Request $request) {
		$error = '';
		$success = '';

		$bodyParams = $request->get_json_params();
		$email = trim($bodyParams['username']);

		if( empty( $email ) ) {
			$error = 'Enter a username or e-mail address..';
		} else if( ! is_email( $email )) {
			$error = 'Invalid username or e-mail address.';
		} else if( ! email_exists($email) ) {
			$error = 'There is no user registered with that email address.';
		} else {
			$random_password = wp_generate_password( 12, false );
			$user = get_user_by( 'email', $email );

			$update_user = wp_update_user( array (
					'ID' => $user->ID,
					'user_pass' => $random_password
				)
			);

			if( $update_user ) {
				$to = $email;
				$subject = 'Your new password';
				$sender = get_option('name');

				$message = 'Your new password is: ' . $random_password;

				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers[] = "X-Mailer: PHP \r\n";
				$headers[] = 'From: '.$sender.' < '.$email.'>' . "\r\n";

				$mail = wp_mail( $to, $subject, $message, $headers );
				if( $mail )
					$success = 'Password change requested.';
			} else {
				$error = 'Oops something went wrong updaing your account.';
			}
		}

		if( ! empty( $success ) )
			return new WP_REST_Response( array('message' => 'Password change requested'), 200 );
		elseif( ! empty( $error ) )
			return new WP_Error( 500, $error, array( 'status' => 500 ) );
	}

	public function getManagers() {
		$args = array(
			'role'    => 'project-manager',
			'orderby' => 'ID',
			'order'   => 'ASC',
			'meta_query' => array(
				array(
					'key'     => '_cf_user_consultant',
					'value'   => get_current_user_id()
				)
			)
		);
		$users = new WP_User_Query( $args );
		$data = array();

		foreach ($users->get_results() as $user) {
			$data[] = (object) array('id' => $user->data->ID, 'name' => $user->data->display_name);
		}

		return new WP_REST_Response( $data, 200 );
	}

	public function getCandidates() {
		$args = array(
			'role'    => 'candidate',
			'orderby' => 'ID',
			'order'   => 'ASC',
			'meta_query' => array(
				array(
					'key'     => '_cf_user_consultant',
					'value'   => get_current_user_id()
				)
			)
		);
		$users = new WP_User_Query( $args );
		$data = array();

		foreach ($users->get_results() as $user) {
			$data[] = (object) array('id' => $user->data->ID, 'name' => $user->data->display_name);
		}

		return new WP_REST_Response( $data, 200 );
	}

	public function getReview(WP_REST_Request $request) {
	    $lang = $request->get_header('X-CF-Lang');
		$postId = (int) $request['id'];

		$userId = (int) get_post_meta($postId, '_cf_review_done_target_userid', true);
		$projectId = (int) get_post_meta($postId, '_cf_review_done_projectid', true);
		$projectComplated = (int) get_post_meta($projectId, '_cf_project_completed', true);
		$notes = get_post_meta($postId, '_cf_review_done_comment', true);
		$rating = (int) get_post_meta($postId, '_cf_review_done_rating', true);
		$questions = unserialize(get_post_meta($postId, '_cf_reviews_done_questions', true));

		$userMeta = get_userdata( $userId );
		$questionsData = [];

		foreach ($questions as $question) {
			$qId = (int)$question['qid'];
            $content = $this->questionTranslate($qId, $lang);

			$questionsData[] = array(
				'id' => $qId,
                'title' => get_the_title($qId),
                'description' => $content,
                'rating' => (int)$question['qr'],
			);
		}

		$output = (object) array(
			'id' => $postId,
			'date' => get_the_date( 'Y-m-d', $postId ),
			'targetName' => $userMeta->display_name,
			'targetType' => $userMeta->roles[0],
			'project' => get_the_title($projectId),
			'projectCompleted' => $projectComplated === 1 ? true : false,
			'rating' => $rating,
			'questions' => $questionsData,
			'notes' => $notes,
		);

		return new WP_REST_Response( $output, 200 );
	}

	public function setReview(WP_REST_Request $request) {
        $lang = $request->get_header('X-CF-Lang');
		$bodyParams = $request->get_json_params();
		$postId = (int) $request['id'];
		$notes = $bodyParams['notes'];
		$questions = (array) $bodyParams['review'];

		$questionsMetaRaw = get_post_meta($postId, '_cf_reviews_done_questions', true);
		$questionsMeta = (array) unserialize($questionsMetaRaw);

		$questionsSum = 0;
		$questionsNew = [];
		foreach ($questionsMeta as $questionMeta) {
			$_questionMeta = $questionMeta;

			foreach ($questions as $question) {
				if($questionMeta['qid'] == $question['id']) {
					$_questionMeta['qr'] = $question['rating'];
					break;
				}
			}
			$questionsSum += (int) $_questionMeta['qr'];
			$questionsNew[] = $_questionMeta;
		}

		$questionsAvg = count($questionsNew) === 0 ? 0 : $questionsSum / count($questionsNew);

		update_post_meta($postId, '_cf_review_done_comment', $notes);
		update_post_meta($postId, '_cf_review_done_rating', $questionsAvg);
		update_post_meta($postId, '_cf_reviews_done_questions', serialize($questionsNew));

		$_userId = (int) get_post_meta($postId, '_cf_review_done_target_userid', true);
		$_projectId = (int) get_post_meta($postId, '_cf_review_done_projectid', true);
		$_rating = (float) get_post_meta($postId, '_cf_review_done_rating', true);
		$_notes = get_post_meta($postId, '_cf_review_done_comment', true);
		$_questions = unserialize(get_post_meta($postId, '_cf_reviews_done_questions', true));

		$_userMeta = get_userdata( $_userId );
		$_questionsData = [];

		$rated = true;
		foreach ($_questions as $_question) {
			$_qId = (int) $_question['qid'];
            $_content = $this->questionTranslate($_qId, $lang);

			$_questionsData[] = array(
				'id' => $_qId,
				'title' => get_the_title($_qId),
				'description' => $_content,
				'rating' => (int)$_question['qr'],
			);

			if(!$_question['qr']) {
				$rated = false;
			}
		}

		if($rated) {
			update_post_meta($postId, '_cf_review_done_rated', 1);
		} else {
			update_post_meta($postId, '_cf_review_done_rated', '');
		}

		$_rated = (int) get_post_meta($postId, '_cf_review_done_rated', true);

		$output = (object) array(
			'id' => $postId,
			'date' => get_the_date( 'Y-m-d', $postId ),
			'targetName' => $_userMeta->display_name,
			'targetType' => $_userMeta->roles[0],
			'project' => get_the_title($_projectId),
			'projectCompleted' => $_rated === 1 ? true : false,
			'rating' => $_rating,
			'questions' => $_questionsData,
			'notes' => $_notes,
		);

		return new WP_REST_Response( $output, 200 );
	}

	public function getReviewsByManager(WP_REST_Request $request) {
		global $wpdb;
		$qweryParams = $request->get_query_params();

		if(!empty($qweryParams['managerId']))
			$sourceId = (int) $qweryParams['managerId'];
		elseif(!empty($qweryParams['candidateId'])) {
			$sourceId = (int) $qweryParams['candidateId'];
		} else {
			$sourceId = 0;
		}

		$projectId = (int) $qweryParams['projectId'];
		$limit = (int) $qweryParams['limit'];
		$offset = (int) $qweryParams['offset'];
		$currentUserId = get_current_user_id();

		$qpStr = '';
		if($projectId) {
			$qp = "meta_key = '_cf_review_done_projectid' AND meta_value = {$projectId}";
			$qpStr = " JOIN ( SELECT * FROM {$wpdb->prefix}postmeta WHERE {$qp}) AS pmq ON (pr.ID = pmq.post_id) ";
		};

		$q = "meta_key = '_cf_review_done_target_userid' AND meta_value = {$sourceId}";
		$qu = "meta_key = '_cf_review_done_consultant' AND meta_value = {$currentUserId}";

		$qrated = "meta_key = '_cf_review_done_rated'";

		$reviews = $wpdb->get_results("SELECT pr.ID as ID, pqr.meta_value as rated
												FROM (SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'reviewsdone' AND post_status = 'publish') AS pr
												JOIN ( SELECT * FROM {$wpdb->prefix}postmeta WHERE {$q}) AS pm ON (pr.ID = pm.post_id)
												JOIN ( SELECT * FROM {$wpdb->prefix}postmeta WHERE {$qu}) AS pmu ON (pr.ID = pmu.post_id)" . $qpStr . "
												LEFT JOIN ( SELECT * FROM {$wpdb->prefix}postmeta WHERE {$qrated}) AS pqr ON (pr.ID = pqr.post_id)
												ORDER BY rated ASC
												LIMIT {$limit}
												OFFSET {$offset}");

		$reviewsForCount = $wpdb->get_results("SELECT *
												FROM (SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'reviewsdone' AND post_status = 'publish') AS pr
												JOIN ( SELECT * FROM {$wpdb->prefix}postmeta WHERE {$q}) AS pm ON (pr.ID = pm.post_id)
												JOIN ( SELECT * FROM {$wpdb->prefix}postmeta WHERE {$qu}) AS pmu ON (pr.ID = pmu.post_id)" . $qpStr);

		$total = count($reviewsForCount);
		$elements = [];
		foreach($reviews as $review):
			$postId = $review->ID;
			$sourceUserId = (int) get_post_meta($postId, '_cf_review_done_target_userid', true);
			$projectId = (int) get_post_meta($postId, '_cf_review_done_projectid', true);
			$rated = (int) get_post_meta($postId, '_cf_review_done_rated', true);
			$rating = (int) get_post_meta($postId, '_cf_review_done_rating', true);

			$userMeta = get_userdata( $sourceUserId );

			$element = array(
				'id' => (int) $postId,
				'date' => get_the_date( 'Y-m-d', $postId ),
				'targetName' => $userMeta->display_name,
				'targetType' => $userMeta->roles[0],
				'project' => get_the_title($projectId),
				'projectCompleted' => $rated === 1 ? true : false,
				'rating' => $rating,
			);
			$elements[] = $element;
		endforeach;

		$result = array(
			'total' => $total,
            'limit' => $limit,
            'offset' => $offset,
            'elements' => $elements,
		);

		return new WP_REST_Response( $result, 200 );
	}

	public function user_loggedin_permissions_check() {
		return is_user_logged_in();
	}

	protected function prepare_item_for_database( $request ) {
		return array();
	}

	private function questionTranslate($qId, $lang) {
        $metaKey = '_cf_question_lang_' . $lang;

        if($lang === 'en') {
            $contentPost = get_post($qId);
            $content = $contentPost->post_content;
        } else {
            $cfQuestionLang = get_post_meta($qId, $metaKey, true);
            if($cfQuestionLang) {
                $content = $cfQuestionLang;
            } else {
                $contentPost = get_post($qId);
                $content = $contentPost->post_content;
            }
        }

        return $content;
    }
}