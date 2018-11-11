<?php
/**
 * Template Name: Start Review
 */
?>

<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

        <main id="dashboard">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="p-4">
                            <div class="cf-page-title">Start a reviews</div>
                            <a style="float:right" class="cf-white-btn" href="<?php echo get_post_type_archive_link( 'reviews' ); ?>">BACK</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-8">

                        <div class="cf-panel">

	                        <?php if(isset($_GET['step'])) : ?>

	                            <?php if($_GET['step'] == 1) { ?>

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
                                            <?php $reviewIdCookie = isset( $_COOKIE['review-id'] ) ? (int)$_COOKIE['review-id'] : null;
                                            $argsR = array(
                                                'post_type' => 'reviews',
                                                'posts_per_page' => -1
                                            );

                                            $reviews = new WP_Query($argsR);

                                            if($reviews->have_posts()): while($reviews->have_posts()): $reviews->the_post(); ?>
                                                <?php $postId = get_the_ID();
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
                                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                            <input type="checkbox" naem="_cf_review_done_reviews" <?php checked( $postId, $reviewIdCookie ); ?> value="<?php echo $postId; ?>">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td><?php echo $role; ?></td>
                                                    <td><?php echo reviewsDoneByReviewId($postId); ?></td>
                                                    <td><?php echo get_the_date('d/m/Y', $postId); ?></td>
                                                </tr>
                                            <?php endwhile; endif;
                                            wp_reset_query(); ?>
                                            </tbody>
                                        </table>

                                    </div>

		                        <?php } ?>

		                        <?php if($_GET['step'] == 2) { ?>

                                    <div class="cf-panel-h">
                                        <div class="cf-panel-h-title">2. SELECT A PROJECT</div>
                                        <div id="datatable-searchbar"></div>
                                        <a id="cf-review-start-s2" class="cf-blue-btn cf-panel-h-btn cf-panel-h-steps" href="#">SUBMIT <i class="fas fa-angle-right"></i></a>
                                    </div>

                                    <div class="cf-panel-b">

                                        <table id="d-with-search-list" class="display cf-datatable" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>USERS</th>
                                                <th>REVIEWS</th>
                                                <th>START DATE</th>
                                                <th>END DATE</th>
                                            </tr>
                                            </thead>
                                            <tbody>
					                        <?php $projectIdCookie = isset( $_COOKIE['project-id'] ) ? (int)$_COOKIE['project-id'] : null;
					                        $argsP = array(
						                        'post_type' => 'projects',
						                        'posts_per_page' => -1,
						                        'meta_query' => array(
                                                    'relation' => 'AND',
                                                    array(
                                                        'relation' => 'OR',
                                                        array(
                                                            'key' => '_cf_project_archive',
                                                            'compare' => 'NOT EXISTS'
                                                        ),
                                                        array(
                                                            'key' => '_cf_project_archive',
                                                            'value' => '',
                                                        ),
                                                    ),
                                                    filterByUserRole('_cf_project_consultant')
						                        )
					                        );

					                        $projects = new WP_Query($argsP);

					                        if($projects->have_posts()): while($projects->have_posts()): $projects->the_post(); ?>
						                        <?php $postId = get_the_ID();
						                        $startDate = get_post_meta($postId, '_cf_project_starts', true);
						                        $endDate = get_post_meta($postId, '_cf_project_ends', true); ?>
                                                <tr>
                                                    <td>
                                                        <label class="cf-checkbox-wrapper cf-checkbox-single">
                                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                            <input type="checkbox" naem="_cf_review_done_reviews" <?php checked( $postId, $projectIdCookie ); ?> value="<?php echo $postId; ?>">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td><?php echo projectUsersByProjectId($postId); ?></td>
                                                    <td><?php echo projectReviewsDoneByProjectId($postId); ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($startDate)); ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($endDate)); ?></td>
                                                </tr>
					                        <?php endwhile; endif;
					                        wp_reset_query(); ?>
                                            </tbody>
                                        </table>

                                    </div>

		                        <?php } ?>

		                        <?php if($_GET['step'] == 3 && isset( $_COOKIE['project-id'] ) && $_COOKIE['project-id']) { ?>

                                    <div class="cf-panel-h">
                                        <div class="cf-panel-h-title">3. SELECT USER(S)</div>
                                        <div id="datatable-searchbar"></div>
                                        <a id="cf-review-start-s3" class="cf-blue-btn cf-panel-h-btn cf-panel-h-steps" href="#">SUBMIT <i class="fas fa-angle-right"></i></a>
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
					                        <?php $usersCookie = (isset( $_COOKIE['user-ids'] ) && $_COOKIE['user-ids'] && $_COOKIE['user-ids'] !== 'null')
                                                ? explode(',', $_COOKIE['user-ids'])
                                                : [];

					                        $projectId = (int)$_COOKIE['project-id'];
					                        $cfUsersRaw = get_post_meta($projectId, '_cf_project_users', true);
					                        $cfUsers = unserialize($cfUsersRaw);

					                        foreach($cfUsers as $cfUser) {
                                                $canArchived = get_user_meta($cfUser, '_cf_user_archive', true);
                                                if($canArchived && $canArchived === 'archived') continue;

						                        $userData = get_userdata( $cfUser );
						                        $userRole = $userData->roles[0];
						                        $roleClassName = '';
						                        if($userRole === 'candidate') {
							                        $roleClassName = 'cf-sm-c-icon';
						                        } elseif($userRole === 'project-manager') {
							                        $roleClassName = 'cf-sm-m-icon';
						                        } ?>
                                                <tr>
                                                    <td>
                                                        <label class="cf-checkbox-wrapper cf-checkbox-multi">
                                                            <a href="<?php echo get_the_permalink(104) . '?id=' . $cfUser; ?>"><?php echo $userData->data->display_name; ?></a>
                                                            <input type="checkbox" naem="_cf_review_done_reviews" <?php if(in_array($cfUser, $usersCookie)) echo 'checked="checked"'; ?> value="<?php echo $cfUser; ?>">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td><?php echo get_the_author_meta( '_cf_user_sector', $cfUser ); ?></td>
                                                    <td><?php echo get_the_author_meta( '_cf_user_primspecialism', $cfUser ); ?></td>
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

                                        <?php $period = isset( $_COOKIE['period'] ) ? $_COOKIE['period'] : '';
                                        $year = (isset( $_COOKIE['year'] ) && $_COOKIE['year']) ? $_COOKIE['year'] : date('Y'); ?>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="_cf_select_review_period" class="cf-select-label">Period</label>
                                                    <select id="_cf_select_review_period" name="_cf_select_review_period" class="form-control cf-select-select">
                                                        <option value="1" <?php selected($period, '1'); ?>>First quarter</option>
                                                        <option value="2" <?php selected($period, '2'); ?>>Second quarter</option>
                                                        <option value="3" <?php selected($period, '3'); ?>>Third quarter</option>
                                                        <option value="4" <?php selected($period, '4'); ?>>Fourth quarter</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="_cf_select_review_year" class="cf-select-label">Year</label>
                                                    <select id="_cf_select_review_year" name="_cf_select_review_year" class="form-control cf-select-select">
                                                        <?php $currentYear = date('Y');
                                                        $backYear = $currentYear - 10;
                                                        for($i = $backYear; $i <= $currentYear; $i++) { ?>
                                                            <option value="<?php echo $i; ?>" <?php selected($year, $i); ?>><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

		                        <?php } ?>

		                        <?php if($_GET['step'] == 'done') { ?>

                                    <div class="cf-panel-h">
                                        <div class="cf-panel-h-title">Done</div>
                                    </div>

                                    <div class="cf-panel-b">

				                        <?php $period = isset( $_COOKIE['period'] ) ? $_COOKIE['period'] : '';
				                        $year = isset( $_COOKIE['year'] ) ? $_COOKIE['year'] : '';
				                        $reviewIdCookie = isset( $_COOKIE['review-id'] ) ? (int)$_COOKIE['review-id'] : null;
				                        $projectIdCookie = isset( $_COOKIE['project-id'] ) ? (int)$_COOKIE['project-id'] : null;
				                        $usersCookie = (isset( $_COOKIE['user-ids']) && $_COOKIE['user-ids'] !== null)
					                        ? explode(',', $_COOKIE['user-ids'])
					                        : [];

				                        if($period && $year && $reviewIdCookie && $projectIdCookie && count($usersCookie) > 0): ?>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h2 class="text-center">SUMMARY</h2>
                                                    <p><strong>Review: </strong><?php echo get_the_title($reviewIdCookie); ?></p>
                                                    <p><strong>Project: </strong><?php echo get_the_title($projectIdCookie); ?></p>
                                                    <p><strong>Users: </strong></p>
                                                    <ul>
                                                        <?php foreach($usersCookie as $userCookie): ?>
                                                            <?php $userData = get_userdata( $userCookie ); ?>
                                                            <li><?php echo $userData->data->display_name; ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                    <p><strong>Period: </strong><?php echo $period . ' ' . $year; ?></p>
                                                </div>
                                            </div>

                                        <?php endif; ?>

                                    </div>

		                        <?php } ?>

		                        <?php if($_GET['step'] == 'complated') { ?>

                                    <div class="cf-panel-h">
                                        <div class="cf-panel-h-title">Review Created</div>
                                    </div>

                                    <div class="cf-panel-b">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="jumbotron">
                                                    <h1 class="display-4 text-center">Great!</h1>
                                                    <p class="lead text-center">This review is created.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

		                        <?php } ?>

	                        <?php endif; ?>

                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4">
                        <?php get_template_part( 'components/component', 'start-review-steps' ); ?>
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
                        $.cookie("review-id", selectedReviewId, {path: '/'});
                        window.location.href = "<?php echo get_the_permalink(84); ?>/?step=2";
                    } else {
                        $.cookie("review-id", '', {path: '/'});
                    }
                });

                $("#cf-review-start-s2").on('click', function() {
                    var selectedProjectId = $(".cf-checkbox-wrapper input[type='checkbox']:checked").val();
                    if(selectedProjectId) {
                        $.cookie("project-id", selectedProjectId, {path: '/'});
                        $.cookie("user-ids", '', {path: '/'});
                        window.location.href = "<?php echo get_the_permalink(84); ?>/?step=3";
                    } else {
                        $.cookie("project-id", '', {path: '/'});
                    }
                });

                $("#cf-review-start-s3").on('click', function() {
                    var selectedUsersIds = [];
                    $(".cf-checkbox-wrapper input[type='checkbox']:checked").each(function(index) {
                        selectedUsersIds.push($(this).val());
                    });

                    if(selectedUsersIds.length > 0) {
                        $.cookie("user-ids", selectedUsersIds.join(','), {path: '/'});
                        window.location.href = "<?php echo get_the_permalink(84); ?>/?step=4";
                    } else {
                        $.cookie("user-ids", '', {path: '/'});
                    }
                });

                $("#cf-review-start-s4").on('click', function() {
                    var period = $("#_cf_select_review_period").val();
                    var year = $("#_cf_select_review_year").val();

                    if(period && year) {
                        $.cookie("period", period, {path: '/'});
                        $.cookie("year", year, {path: '/'});
                        window.location.href = "<?php echo get_the_permalink(84); ?>/?step=done";
                    } else {
                        $.cookie("period", '', {path: '/'});
                        $.cookie("year", '', {path: '/'});
                    }
                });

                $(".cf-submit-review-done").on('click', function() {
                    $.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        type: 'POST',
                        data: {
                            action: 'create_review_done',
                            period: '<?php echo $_COOKIE['period']; ?>',
                            year: '<?php echo $_COOKIE['year']; ?>',
                            reviewId: '<?php echo $_COOKIE['review-id']; ?>',
                            projectId: '<?php echo $_COOKIE['project-id']; ?>',
                            users: '<?php echo $_COOKIE['user-ids']; ?>'
                        },
                        success: function(data) {
                            var parsedData = JSON.parse(data);
                            if(parsedData.status) {
                                $.cookie("period", '', {path: '/'});
                                $.cookie("year", '', {path: '/'});
                                $.cookie("user-ids", '', {path: '/'});
                                $.cookie("review-id", '', {path: '/'});
                                $.cookie("project-id", '', {path: '/'});

                                window.location.href = "<?php echo get_the_permalink(84); ?>/?step=complated";
                            }
                        }
                    });
                })
            });
        </script>

<?php get_footer(); ?>
