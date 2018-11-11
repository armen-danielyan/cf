<div class="cf-panel">
	<div class="cf-panel-h">
		<div class="cf-panel-h-title">LAST REVIEW</div>
	</div>

	<div class="cf-panel-b">
		<?php $argsR = array(
			'post_type' => 'reviewsdone',
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order' => 'DESC',
			'meta_query' => array(
				array(
					'key' => '_cf_review_done_consultant',
					'value'  => get_current_user_id(),
				)
			)
		);
		$reviews = new WP_Query($argsR);
		$lastReview = $reviews->posts[0];

		$lastReviewId = $lastReview->ID;
		$reviewTargetUserId = (int) get_post_meta($lastReviewId, '_cf_review_done_target_userid', true);
		$reviewProjectId = (int) get_post_meta($lastReviewId, '_cf_review_done_projectid', true);
		$userData = get_userdata( $reviewTargetUserId );
		$userRole = $userData->roles[0];
		$roleClassName = '';
		if($userRole === 'candidate') {
			$roleClassName = 'cf-sm-c-icon';
		} elseif($userRole === 'project-manager') {
			$roleClassName = 'cf-sm-m-icon';
		} ?>
		<ul class="list-group cf-last-review">
			<li class="list-group-item d-flex align-items-center">
				<div>
					<div>PROJECT:</div>
					<div style="font-weight: normal"><?php echo get_the_title($reviewProjectId); ?></div>
				</div>
			</li>
			<li class="list-group-item d-flex align-items-center">
				<div>
					<span>USER:</span>
					<div style="font-weight: normal"><?php echo $userData->user_login; ?></div>
				</div>

				<span class="cf-sidebar-counts ml-auto"><span class="<?php echo $roleClassName; ?>"></span></span>
			</li>
			<li class="list-group-item d-flex align-items-center">
				<div>
					<span>DATE:</span>
					<div style="font-weight: normal"><?php echo date('d M Y', strtotime($lastReview->post_date)); ?></div>
				</div>
			</li>
		</ul>

		<hr class="col-xs-12">

		<div class="row cf-user-role-info">
			<div class="col-sm-6"><span class="cf-sm-m-icon"></span> Manager</div>
			<div class="col-sm-6"><span class="cf-sm-c-icon"></span> Candidate</div>
		</div>
	</div>
</div>