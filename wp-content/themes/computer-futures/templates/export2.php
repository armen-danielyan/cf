<?php
/**
 * Template Name: Export2
 */
?>
<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

<main id="dashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="p-4">
					<div class="cf-page-title">Export</div>
                    <a style="float:right" class="cf-white-btn" onclick="window.history.back();">BACK</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-8">

				<div class="cf-panel">

					<?php if(!isset($_GET['step'])) { ?>

						<div class="cf-panel-h">
							<div class="cf-panel-h-title">1. SELECT A REVIEW</div>
							<div id="datatable-searchbar"></div>
							<a id="cf-review-start-s1" class="cf-blue-btn cf-panel-h-btn cf-panel-h-steps" href="#">SUBMIT <i class="fas fa-angle-right"></i></a>
						</div>

						<div class="cf-panel-b">

							<table id="d-with-search-list" class="display cf-datatable" style="width: 100%;">
								<thead>
								<tr>
									<th>NAME</th>
									<th>ROLE</th>
									<th>REVIEWS DONE</th>
									<th>DATE</th>
								</tr>
								</thead>
								<tbody>
								<?php $reviewIdCookie = isset( $_COOKIE['export2-review-id'] ) ? (int)$_COOKIE['export2-review-id'] : null;

								$reviews = getExportReviewDoneReviews();

								foreach($reviews as $review) { ?>
									<?php $postId = $review;
									$targetUserRole = get_post_meta($postId, '_cf_review_target_user_type', true);
									$role = '';
									if($targetUserRole === 'candidate') {
										$role = 'Candidate';
									} elseif($targetUserRole === 'project-manager') {
										$role = 'Manager';
									} ?>
									<tr>
										<td>
											<label class="cf-checkbox-wrapper cf-checkbox-single">
												<a href="<?php echo get_the_permalink($postId); ?>"><?php echo get_the_title($postId); ?></a>
												<input type="checkbox" naem="_cf_review_done_reviews" <?php checked( $postId, $reviewIdCookie ); ?> value="<?php echo $postId; ?>">
												<span class="checkmark"></span>
											</label>
										</td>
										<td><?php echo $role; ?></td>
										<td><?php echo reviewsDoneByReviewId($postId); ?></td>
										<td><?php echo get_the_date('d/m/Y', $postId); ?></td>
									</tr>
								<?php }
								wp_reset_query(); ?>
								</tbody>
							</table>

						</div>

					<?php } else { ?>

						<?php if($_GET['step'] == 2 && isset( $_COOKIE['export2-review-id'] ) && $_COOKIE['export2-review-id']) { ?>

							<div class="cf-panel-h">
								<div class="cf-panel-h-title">2. SELECT USER(S)</div>
								<div id="datatable-searchbar"></div>
								<a id="cf-review-start-s2" class="cf-blue-btn cf-panel-h-btn cf-panel-h-steps" href="#">SUBMIT <i class="fas fa-angle-right"></i></a>
							</div>

							<div class="cf-panel-b">

								<table id="d-with-search-list" class="display cf-datatable" style="width: 100%;">
									<thead>
									<tr>
										<th>NAME</th>
										<th>SECTOR</th>
										<th>SPECIALISM</th>
										<th>ROLL</th>
										<th>DATE</th>
									</tr>
									</thead>
									<tbody>
									<?php $usersCookie = (isset( $_COOKIE['export2-user-id'] ) && $_COOKIE['export2-user-id'] && $_COOKIE['export2-user-id'] !== 'null')
										? $_COOKIE['export2-user-id']
										: '';

									$reviewId = $_COOKIE['export2-review-id'];

									$users = getExportReviewDoneUsers($reviewId);
									foreach ($users as $userId) {
										$userData      = get_userdata( $userId );
										$userRole      = $userData->roles[0];

										if($userRole !== 'candidate') continue;

                                        $roleClassName = 'cf-sm-c-icon'; ?>
										<tr>
											<td>
												<label class="cf-checkbox-wrapper cf-checkbox-single">
													<a href="<?php echo get_the_permalink(104) . '?id=' . $userId; ?>"><?php echo $userData->data->display_name; ?></a>
													<input type="checkbox" naem="_cf_review_done_reviews" <?php checked($userId, $usersCookie); ?> value="<?php echo $userId; ?>">
													<span class="checkmark"></span>
												</label>
											</td>
											<td><?php echo get_the_author_meta( '_cf_user_sector', $userId ); ?></td>
											<td><?php echo get_the_author_meta( '_cf_user_primspecialism', $userId ); ?></td>
											<td><span class="<?php echo $roleClassName; ?>"></span></td>
											<td><?php echo date('d/m/Y', strtotime($userData->data->user_registered)); ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>

							</div>

						<?php } ?>

						<?php if($_GET['step'] == 3 && isset( $_COOKIE['export2-user-id'] ) && $_COOKIE['export2-user-id']) { ?>

							<div class="cf-panel-h">
								<div class="cf-panel-h-title">3. COMPARE</div>
								<div id="datatable-searchbar"></div>
								<a id="cf-review-start-s3" class="cf-blue-btn cf-panel-h-btn cf-panel-h-steps" href="#">SUBMIT <i class="fas fa-angle-right"></i></a>
							</div>

							<div class="cf-panel-b">
								<form id="cf-form-user-info">
									<div class="row">
										<div class="col-md-6">
											<?php $compareTypeCookie = (isset( $_COOKIE['export2-compare-type'] ) && $_COOKIE['export2-compare-type'] && $_COOKIE['export2-compare-type'] !== 'null')
												? $_COOKIE['export2-compare-type']
												: ''; ?>
											<div class="form-group">
												<label for="cf-compare-type">Compare to</label>
												<select class="form-control" id="cf-compare-type" name="cf-compare-type">
													<option value="none" <?php selected($compareTypeCookie, 'none'); ?>>None</option>
													<option value="users" <?php selected($compareTypeCookie, 'users'); ?>>Users</option>
													<option value="average" <?php selected($compareTypeCookie, 'average'); ?>>Average</option>
												</select>
											</div>
										</div>
									</div>
								</form>

								<table id="d-with-search-list" class="display cf-datatable cf-compare-user" style="width: 100%;">
									<thead>
									<tr>
										<th>NAME</th>
										<th>SECTOR</th>
										<th>SPECIALISM</th>
										<th>ROLL</th>
										<th>DATE</th>
									</tr>
									</thead>
									<tbody>
									<?php $usersCookie = (isset( $_COOKIE['export2-compare-user-id'] ) && $_COOKIE['export2-compare-user-id'] && $_COOKIE['export2-compare-user-id'] !== 'null')
										? $_COOKIE['export2-compare-user-id']
										: '';

									$reviewId = $_COOKIE['export2-review-id'];

									$users = getExportReviewDoneUsers($reviewId);

									foreach ($users as $userId) {
										$userData      = get_userdata( $userId );
										$userRole      = $userData->roles[0];
										$roleClassName = '';
										if ( $userRole === 'candidate' ) {
											$roleClassName = 'cf-sm-c-icon';
										} elseif ( $userRole === 'project-manager' ) {
											$roleClassName = 'cf-sm-m-icon';
										} ?>
										<tr>
											<td>
												<label class="cf-checkbox-wrapper cf-checkbox-single">
													<a href="<?php echo get_the_permalink(104) . '?id=' . $userId; ?>"><?php echo $userData->data->display_name; ?></a>
													<input type="checkbox" naem="_cf_review_done_reviews" <?php checked($userId, $usersCookie); ?> value="<?php echo $userId; ?>">
													<span class="checkmark"></span>
												</label>
											</td>
											<td><?php echo get_the_author_meta( '_cf_user_sector', $userId ); ?></td>
											<td><?php echo get_the_author_meta( '_cf_user_primspecialism', $userId ); ?></td>
											<td><span class="<?php echo $roleClassName; ?>"></span></td>
											<td><?php echo date('d/m/Y', strtotime($userData->data->user_registered)); ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>

							</div>

						<?php } ?>

						<?php if($_GET['step'] == 4) { ?>

							<div class="cf-panel-h">
								<div class="cf-panel-h-title">4. SELECT PERIOD</div>
								<a id="cf-review-start-s4" class="cf-blue-btn cf-panel-h-btn" href="#">SUBMIT <i class="fas fa-angle-right"></i></a>
							</div>

							<div class="cf-panel-b">

								<?php $periodFrom = isset( $_COOKIE['export2-period-from'] ) ? $_COOKIE['export2-period-from'] : '';
								$periodTo = isset( $_COOKIE['export2-period-to'] ) ? $_COOKIE['export2-period-to'] : '';
								$yearFrom = (isset( $_COOKIE['export2-year-from'] ) && $_COOKIE['export2-year-from']) ? $_COOKIE['export2-year-from'] : date('Y');
								$yearTo = (isset( $_COOKIE['export2-year-to'] ) && $_COOKIE['export2-year-to']) ? $_COOKIE['export2-year-to'] : date('Y'); ?>

								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="_cf_select_review_period_from" class="cf-select-label">Period</label>
											<select id="_cf_select_review_period_from" name="_cf_select_review_period_from" class="form-control cf-select-select">
												<option value="1" <?php selected($periodFrom, '1'); ?>>First quarter</option>
												<option value="2" <?php selected($periodFrom, '2'); ?>>Second quarter</option>
												<option value="3" <?php selected($periodFrom, '3'); ?>>Third quarter</option>
												<option value="4" <?php selected($periodFrom, '4'); ?>>Fourth quarter</option>
											</select>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group">
											<label for="_cf_select_review_year_from" class="cf-select-label">Year</label>
											<select id="_cf_select_review_year_from" name="_cf_select_review_year_from" class="form-control cf-select-select">
												<?php $currentYear = date('Y');
												$backYear = $currentYear - 10;
												for($i = $backYear; $i <= $currentYear; $i++) { ?>
													<option value="<?php echo $i; ?>" <?php selected($yearFrom, $i); ?>><?php echo $i; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-md-2">
										<div class="cf-select-label text-center" style="margin: 20px 0">Till</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="_cf_select_review_period_to" class="cf-select-label">Period</label>
											<select id="_cf_select_review_period_to" name="_cf_select_review_period_to" class="form-control cf-select-select">
												<option value="1" <?php selected($periodTo, '1'); ?>>First quarter</option>
												<option value="2" <?php selected($periodTo, '2'); ?>>Second quarter</option>
												<option value="3" <?php selected($periodTo, '3'); ?>>Third quarter</option>
												<option value="4" <?php selected($periodTo, '4'); ?>>Fourth quarter</option>
											</select>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group">
											<label for="_cf_select_review_year_to" class="cf-select-label">Year</label>
											<select id="_cf_select_review_year_to" name="_cf_select_review_year_to" class="form-control cf-select-select">
												<?php $currentYear = date('Y');
												$backYear = $currentYear - 10;
												for($i = $backYear; $i <= $currentYear; $i++) { ?>
													<option value="<?php echo $i; ?>" <?php selected($yearTo, $i); ?>><?php echo $i; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>

							</div>

						<?php } ?>

						<?php if($_GET['step'] == 5) { ?>

                            <div class="cf-panel-h">
                                <div class="cf-panel-h-title">5. CHARTS</div>
                            </div>

                            <div id="cf-export-pdf-data" class="cf-panel-b">
								<?php $reviewId = isset( $_COOKIE['export2-review-id'] ) ? (int)$_COOKIE['export2-review-id'] : '';
								$userId = isset( $_COOKIE['export2-user-id'] ) && $_COOKIE['export2-user-id'] ? $_COOKIE['export2-user-id'] : '';
								$compareType = isset( $_COOKIE['export2-compare-type'] ) && $_COOKIE['export2-compare-type'] ? $_COOKIE['export2-compare-type'] : '';
								$compareUserId = isset( $_COOKIE['export2-compare-user-id'] ) && $_COOKIE['export2-compare-user-id'] ? $_COOKIE['export2-compare-user-id'] : '';

                                $periodFrom = isset( $_COOKIE['export2-period-from'] ) ? (int)$_COOKIE['export2-period-from'] : '';
								$periodTo = isset( $_COOKIE['export2-period-to'] ) ? (int)$_COOKIE['export2-period-to'] : '';
								$yearFrom = isset( $_COOKIE['export2-year-from'] ) ? (int)$_COOKIE['export2-year-from'] : '';
								$yearTo = isset( $_COOKIE['export2-year-to'] ) ? (int)$_COOKIE['export2-year-to'] : '';

								if($periodFrom && $periodTo && $yearFrom && $yearTo && $reviewId && $userId && ($compareType !== 'users' || ($compareType === 'users' && $compareUserId))) {
								    $numItems = (4 - ($periodFrom - 1)) + (($yearTo - $yearFrom) - 1) * 4 + $periodTo;
									$numItemsArr = [];
									$numItemsDataArr = [];
									$periodStart = $periodFrom;
									$yearStart = $yearFrom;
								    for($i = 0; $i < $numItems; $i++) {
									    $arrItem = 'Q' . $periodStart . ' ' . $yearStart;
									    array_push($numItemsArr, $arrItem);

								        if($periodStart + 1 > 4) {
									        $periodStart = 1;
									        $yearStart++;
                                        } else {
									        $periodStart++;
                                        }
                                    }

								    $reviewDoneArgs = array(
                                        'post_type' => 'reviewsdone',
                                        'posts_per_page' => -1,
                                        'meta_query' => array(
	                                        'relation'  => 'AND',
	                                        array(
		                                        'key' => '_cf_review_done_rated',
		                                        'value' => '1',
	                                        ),
	                                        array(
		                                        'key' => '_cf_review_done_reviewid',
		                                        'value' => $reviewId,
	                                        ),
                                            array(
		                                        'key' => '_cf_review_done_target_userid',
		                                        'value' => $userId,
	                                        )
                                        )
                                    );

									$reviewsDone = new WP_Query($reviewDoneArgs);
                                    $projectNames = [];
                                    $clientNames = [];
									$projectIds = [];
									if($reviewsDone->have_posts()): while($reviewsDone->have_posts()): $reviewsDone->the_post();
                                        $rDoneId = get_the_id();
                                        $period = get_post_meta($rDoneId, '_cf_select_review_period', true);
                                        $year = get_post_meta($rDoneId, '_cf_select_review_year', true);

                                        $projectId = (int) get_post_meta($rDoneId, '_cf_review_done_projectid', true);
                                        array_push($projectNames, get_the_title($projectId));
                                        array_push($clientNames, get_post_meta($projectId, '_cf_project_client', true));

                                        $periodYear = 'Q' . $period . ' ' . $year;
                                        if(in_array($periodYear, $numItemsArr)) {
	                                        $qIdsRaw = get_post_meta($rDoneId, '_cf_reviews_done_questions', true);
	                                        $qIds = unserialize($qIdsRaw);

	                                        foreach($qIds as $qId) {
		                                        $numItemsDataArr[(string)$qId['qid']][$periodYear] = (int)$qId['qr'];
                                            }
                                        }
                                    endwhile; endif; ?>

                                    <?php $numItemsAvgDataArr = '';
                                    $compareTypeTitle = '';
                                    if($compareType === 'average') {
                                        $numItemsAvgDataArr = getExportAverageData($numItemsArr, $reviewId);
	                                    $compareTypeTitle = 'Average';
									} elseif($compareType === 'users') {
										$numItemsAvgDataArr = getExportUserData($numItemsArr, $reviewId, $compareUserId);
	                                    $userDataCompare = get_userdata( $compareUserId );
	                                    $compareTypeTitle = $userDataCompare->data->display_name;
                                    }
									$userData = get_userdata( $userId );
                                    $middleName = get_user_meta($userId, '_cf_user_middle_name', true);
                                    $userSector = get_user_meta($userId, '_cf_user_sector', true);
                                    $compareMiddleName = get_user_meta($compareUserId, '_cf_user_middle_name', true);
                                    $compareSector = get_user_meta($compareUserId, '_cf_user_sector', true); ?>

                                    <div id="cf-export-content">
                                        <div class="row">
                                            <div class="col-md-12 cf-export-logo">
                                                <img width="200" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo_cf_medium.png" alt="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="cf-user-info">
                                                    <h5>User info</h5>
                                                    <p>Naam kandidaa: <?php echo $userData->data->display_name; ?></p>
                                                    <p>Klantnaam: <?php echo implode(', ', array_unique($clientNames)); ?></p>
                                                    <p>Projectnaam: <?php echo implode(', ', array_unique($projectNames)); ?></p>
                                                    <p>Sector: <?php echo $userSector; ?></p>
                                                    <p>Primaire skill: <?php echo get_user_meta($userId, '_cf_user_primspecialism', true); ?></p>
                                                    <p>Secundair skill: <?php echo get_user_meta($userId, '_cf_user_secspecialism', true); ?></p>
                                                </div>
                                            </div>

                                            <?php if($compareType === 'users'): ?>
                                                <div class="col-md-6">
                                                    <div class="cf-user-info">
                                                        <h5>Compare user info</h5>
                                                        <p>Naam kandidaa: <?php echo $userDataCompare->data->display_name; ?></p>
                                                        <p>Sector: <?php echo get_user_meta($compareUserId, '_cf_user_sector', true); ?></p>
                                                        <p>Primaire skill: <?php echo get_user_meta($compareUserId, '_cf_user_primspecialism', true); ?></p>
                                                        <p>Secundair skill: <?php echo get_user_meta($compareUserId, '_cf_user_secspecialism', true); ?></p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="cf-user-info">
                                                    <h5>Review</h5>
                                                    <?php echo get_the_title($reviewId); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="cf-user-info">
                                                    <h5>Period</h5>
                                                    <?php $periodNames = array('First quarter', 'Second quarter', 'Third quarter', 'Fourth quarter'); ?>
                                                    <p><?php echo $periodNames[$periodFrom - 1] . ' ' . $yearFrom . ' - ' . $periodNames[$periodTo - 1] . ' ' . $yearTo; ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="cf-export-results">
                                                    <?php $qNum = 0;
                                                    foreach($numItemsDataArr as $key => $value) { ?>
                                                        <h5><?php echo ++$qNum . '. ' . get_the_title($key); ?></h5>
                                                        <div style="width: 480px; margin: 0 auto">
                                                            <canvas id="cf-graphs-<?php echo $key; ?>" height="240" width="480"></canvas>
                                                        </div>

                                                        <?php $labels = '';
                                                        $data1 = '';
                                                        $data2 = '';
                                                        if($compareType === 'none') {
	                                                        foreach($numItemsArr as $p) {
		                                                        $v = $value[$p] ? $value[$p] : 0;

		                                                        $labels .= "'{$p}',";
		                                                        $data1 .= "{$v},";
	                                                        };
                                                        } else {
	                                                        foreach($numItemsArr as $p) {
		                                                        $v = $value[$p] ? $value[$p] : 0;
		                                                        $v2 = $numItemsAvgDataArr[$key][$p] ? $numItemsAvgDataArr[$key][$p] : 0;

		                                                        $labels .= "'{$p}',";
		                                                        $data1 .= "{$v},";
		                                                        $data2 .= "{$v2},";
	                                                        };
                                                        } ?>
                                                        <script>
                                                            var ctx = document.getElementById("cf-graphs-<?php echo $key; ?>").getContext('2d');
                                                            var myChart = new Chart(ctx, {
                                                                type: 'bar',
                                                                data: {
                                                                    labels: [<?php echo $labels; ?>],
                                                                    datasets: [
                                                                        {
                                                                            label: '<?php echo $userData->data->display_name; ?>',
                                                                            backgroundColor : "rgba(38, 169, 223, 1)",
                                                                            data : [<?php echo $data1; ?>]
                                                                        },
                                                                        <?php if($compareType && $compareType !== 'none'): ?>
                                                                        {
                                                                            label: '<?php echo $compareTypeTitle; ?>',
                                                                            backgroundColor : "rgba(51, 63, 72, 1)",
                                                                            data : [<?php echo $data2; ?>]
                                                                        }
                                                                        <?php endif; ?>
                                                                    ]
                                                                },
                                                                options: {
                                                                    legend: {
                                                                        position: 'bottom',
                                                                    },
                                                                    scales: {
                                                                        yAxes: [{
                                                                            ticks: {
                                                                                beginAtZero:true,
                                                                                max: 5
                                                                            }
                                                                        }]
                                                                    }
                                                                }
                                                            });
                                                        </script>

                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div id="notitien-tmp">
                                                        <label style="padding-top: 30px;" for="notitien">Notitien</label>
                                                        <textarea class="form-control" id="notitien" rows="5"></textarea>
                                                    </div>

                                                    <div id="notitien-res" style="display:none">
                                                        <h5>Notitien</h5>
                                                        <div id="notitien-rep">
                                                    </div>

                                                    </div>
                                                    <script>
                                                        jQuery("#notitien").on("keyup", function() {
                                                            jQuery("#notitien-rep").text(jQuery(this).val());
                                                        })
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>

                            <script>
                                jQuery(document).ready(function($) {
                                    $("body").on("click", ".cf-submit-export-pdf", function() {
                                        var html = $("#cf-export-pdf-data");
                                        html.find("canvas").each(function(e) {
                                            var image = new Image();
                                            image.src = this.toDataURL("image/png");
                                            $(image).css("display", "none");
                                            $(image).addClass('cf-tmp-img');
                                            $(this).after(image);
                                        });

                                        var htmlClone = html.clone();
                                        html.find(".cf-tmp-img").remove();
                                        htmlClone.find("canvas").remove();
                                        htmlClone.find("script").remove();
                                        htmlClone.find(".chartjs-size-monitor").remove();
                                        htmlClone.find("#notitien-tmp").remove();
                                        htmlClone.find("#notitien-res").css("display", "block");
                                        htmlClone.find("img").css("display", "block");

                                        $('<form>', {
                                            'action': '<?php echo get_the_permalink(299); ?>',
                                            'target': '_blank',
                                            'method': 'POST'
                                        }).append($('<input>', {
                                            'name': 'html',
                                            'value': htmlClone.html(),
                                            'type': 'hidden'
                                        })).appendTo(document.body).submit();
                                    })
                                });
                            </script>

						<?php } ?>

					<?php }; ?>

				</div>
			</div>

			<div class="col-md-12 col-lg-4">
				<?php get_template_part( 'components/component', 'export2-steps' ); ?>
			</div>
		</div>
	</div>
</main>

<script>
    jQuery(document).ready(function($) {
        if($(".cf-checkbox-wrapper input[type='checkbox']:checked").length === 0) {
            $(".cf-panel-h-steps").addClass('cf-btn-disabled');
        }

        $(".cf-checkbox-wrapper.cf-checkbox-single input[type='checkbox']").on('change', function() {
            $(".cf-checkbox-wrapper input[type='checkbox']").not(this).prop('checked', false);

            if($(this).prop('checked')) {
                $(".cf-panel-h-steps").removeClass('cf-btn-disabled');
            } else {
                $(".cf-panel-h-steps").addClass('cf-btn-disabled');
            }
        });

        $(".cf-checkbox-wrapper.cf-checkbox-multi input[type='checkbox']").on('change', function() {
            if($(".cf-checkbox-wrapper input[type='checkbox']:checked").length !== 0) {
                $(".cf-panel-h-steps").removeClass('cf-btn-disabled');
            } else {
                $(".cf-panel-h-steps").addClass('cf-btn-disabled');
            }
        });

        $("#cf-review-start-s1").on('click', function() {
            var selectedReviewId = $(".cf-checkbox-wrapper input[type='checkbox']:checked").val();
            if(selectedReviewId) {
                $.cookie("export2-review-id", selectedReviewId, {path: '/'});
                window.location.href = "<?php echo get_the_permalink(494); ?>/?step=2";
            } else {
                $.cookie("export2-review-id", '', {path: '/'});
            }
        });

        $("#cf-review-start-s2").on('click', function() {
            var selectedUsersId = $(".cf-checkbox-wrapper input[type='checkbox']:checked").val();

            if(selectedUsersId) {
                $.cookie("export2-user-id", selectedUsersId, {path: '/'});
                window.location.href = "<?php echo get_the_permalink(494); ?>/?step=3";
            } else {
                $.cookie("export2-user-id", '', {path: '/'});
            }
        });

        $(window).bind("load", function() {
            if($("#cf-compare-type").length > 0) {
                if($("#cf-compare-type").val() === "users") {
                    $("#d-with-search-list_wrapper").show();
                } else {
                    $("#d-with-search-list_wrapper").hide();
                }
            }
        });
        $("#cf-compare-type").on("change", function() {
            var val = $(this).val();
            if(val === "users") {
                if($(".cf-checkbox-wrapper.cf-checkbox-single input[type='checkbox']").prop('checked')) {
                    $(".cf-panel-h-steps").removeClass('cf-btn-disabled');
                } else {
                    $(".cf-panel-h-steps").addClass('cf-btn-disabled');
                }
                $("#d-with-search-list_wrapper").show();
            } else {
                $(".cf-panel-h-steps").removeClass('cf-btn-disabled');
                $("#d-with-search-list_wrapper").hide();
            }
        });

        $("#cf-review-start-s3").on('click', function() {
            var selectedCompareType = $("#cf-compare-type").val();
            var selectedUsersId = selectedCompareType === 'users'
	            ? $(".cf-checkbox-wrapper input[type='checkbox']:checked").val()
	            : '';

            $.cookie("export2-compare-type", selectedCompareType, {path: '/'});
            if(selectedCompareType !== 'users') {
                $.cookie("export2-compare-user-id", '', {path: '/'});
                window.location.href = "<?php echo get_the_permalink(494); ?>/?step=4";
            } else if(selectedUsersId) {
                $.cookie("export2-compare-user-id", selectedUsersId, {path: '/'});
                window.location.href = "<?php echo get_the_permalink(494); ?>/?step=4";
            }
        });

        $("#cf-review-start-s4").on('click', function() {
            var periodFrom = $("#_cf_select_review_period_from").val();
            var periodTo = $("#_cf_select_review_period_to").val();
            var yearFrom = $("#_cf_select_review_year_from").val();
            var yearTo = $("#_cf_select_review_year_to").val();

            if(periodFrom && periodTo && yearFrom && yearTo) {
                $.cookie("export2-period-from", periodFrom, {path: '/'});
                $.cookie("export2-period-to", periodTo, {path: '/'});
                $.cookie("export2-year-from", yearFrom, {path: '/'});
                $.cookie("export2-year-to", yearTo, {path: '/'});
                window.location.href = "<?php echo get_the_permalink(494); ?>/?step=5";
            } else {
                $.cookie("export2-period-from", '', {path: '/'});
                $.cookie("export2-period-to", '', {path: '/'});
                $.cookie("export2-year-from", '', {path: '/'});
                $.cookie("export2-year-to", '', {path: '/'});
            }
        });

    });
</script>

<?php get_footer(); ?>
