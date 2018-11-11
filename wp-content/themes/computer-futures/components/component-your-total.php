<div class="cf-panel">
	<div class="cf-panel-h">
		<div class="cf-panel-h-title">
			<?php $totalsMonthTitle = '1 MONTH';

			if(isset($_GET['totals-months'])) {
				if($_GET['totals-months'] == 1) {
					$totalsMonthTitle = '1 MONTH';
				} elseif($_GET['totals-months'] == 3) {
					$totalsMonthTitle = '3 MONTHS';
				} elseif($_GET['totals-months'] == 6) {
					$totalsMonthTitle = '6 MONTHS';
				} elseif($_GET['totals-months'] == 12) {
					$totalsMonthTitle = '12 MONTHS';
				};
			}
			echo 'YOUR TOTALS LAST ' . $totalsMonthTitle; ?>
		</div>
		<div class="dropdown cf-change-month">
			<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownReviewLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-angle-down"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownReviewLink">
				<a class="dropdown-item" href="?totals-months=1">1 MONTH</a>
				<a class="dropdown-item" href="?totals-months=3">3 MONTHS</a>
				<a class="dropdown-item" href="?totals-months=6">6 MONTHS</a>
				<a class="dropdown-item" href="?totals-months=12">12 MONTHS</a>
			</div>
		</div>
	</div>

	<div class="cf-panel-b">
		<?php wp_reset_query();
		$canCount = 0;
		$argsC = array(
			'role' => 'candidate',
			'meta_query' => array(
                filterByUserRole('_cf_user_consultant')
			)
		);
		$users = new WP_User_Query( $argsC );
		foreach ($users->get_results() as $user) {
			$archive = get_the_author_meta( '_cf_user_archive', $user->ID );
			if($archive !== 'archived') {
				$canCount++;
            }
        }

		$activeCandidates = 0;
		$argsP = array(
			'post_type' => 'projects',
			'posts_per_page' => -1,
			'meta_query' => array(
				'relation'  => 'AND',
				array(
					'key' => '_cf_project_starts',
					'value' => date('Y-m-d', strtotime('-' . $totalsMonthTitle)),
					'compare' => '>=',
					'type' => 'DATE'
				),
                filterByUserRole('_cf_project_consultant')
			)
		);
		$projects = new WP_Query($argsP);
		if($projects->have_posts()): while($projects->have_posts()): $projects->the_post();
			$postId = get_the_ID();
			$projectUsers = unserialize(get_post_meta($postId, '_cf_project_users', true));
			foreach($projectUsers as $projectUser) {
				$userData = get_userdata( $projectUser );
				$userRole = $userData->roles[0];
				if($userRole === 'candidate') {
					$activeCandidates++;
				}
			}
		endwhile; endif; ?>
		<ul class="list-group">
			<li class="list-group-item d-flex align-items-center">
				<span class="cf-lg-c-icon"></span>
				ACTIVE CANDIDATES
				<span class="cf-sidebar-counts ml-auto"><?php echo $canCount; ?></span>
			</li>
			<li class="list-group-item d-flex align-items-center">
				<span class="cf-lg-pr-icon"></span>
				PROJECTS RUNNING
				<span class="cf-sidebar-counts ml-auto"><?php echo $projects->post_count; ?></span>
			</li>
			<li class="list-group-item d-flex align-items-center">
				<?php $argsR = array(
					'post_type' => 'reviewsdone',
					'posts_per_page' => -1,
					'date_query' => array(
						array(
							'column' => 'post_date_gmt',
							'after'  => $totalsMonthTitle . ' ago',
						)
					),
                    'meta_query' => array(
	                    'relation'  => 'AND',
	                    array(
		                    'key' => '_cf_review_done_rated',
		                    'value' => '1',
	                    ),
                        filterByUserRole('_cf_review_done_consultant')
                    )
				);
				$reviewsDone = new WP_Query($argsR); ?>
				<span class="cf-lg-rd-icon"></span>
				REVIEWS DONE
				<span class="cf-sidebar-counts ml-auto"><?php echo $reviewsDone->post_count; ?></span>
			</li>
		</ul>
	</div>
</div>