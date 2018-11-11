<?php
/**
 * Template Name: Home
 */
?>
<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

<main id="dashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                <div class="cf-main-title">
                    <?php $currUserId = get_current_user_id();
                    $userData = get_userdata( $currUserId );
                    $themeOptions = get_option( 'theme_options' ); ?>

                    <h3 class="text-center"><?php echo 'Hi ' . $userData->user_login . ', welcome back!'; ?></h3>
                    <p class="text-center"><?php echo $themeOptions['cf_dashboard_greet']; ?></p>
                </div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-8">

                <div class="cf-panel">
                    <div class="cf-panel-h">
                        <div class="cf-panel-h-title">REVIEWS DONE</div>
                    </div>

                    <div class="cf-panel-b">
                        <?php $reviewsDoneArgs = array(
                            'post_type' => 'reviewsdone',
                            'posts_per_page' => -1,
                            'meta_query' => array(
	                            'relation'  => 'AND',
	                            array(
		                            'key' => '_cf_review_done_rated',
		                            'value' => '1',
	                            ),
	                            filterByUserRole('_cf_review_done_consultant')
                            )
                        );
                        $reviewsDone = new WP_Query($reviewsDoneArgs); ?>

                        <table id="d-reviews-done" class="display cf-datatable" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>USERNAME</th>
                                <th>PROJECT</th>
                                <th>DATE</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if($reviewsDone->have_posts()): while ($reviewsDone->have_posts()): $reviewsDone->the_post(); ?>

                                    <?php $postId = get_the_ID();
                                    $projectId = get_post_meta($postId, '_cf_review_done_projectid', true);
	                                $user = get_post_meta($postId, '_cf_review_done_target_userid', true);
                                    $userData = get_userdata( $user );
                                    $userRole = $userData->roles[0];
                                    $roleClassName = '';
                                    if($userRole === 'candidate') {
                                        $roleClassName = 'cf-sm-c-icon';
                                    } elseif($userRole === 'project-manager') {
                                        $roleClassName = 'cf-sm-m-icon';
                                    }
                                    ?>
                                    <tr>
                                        <td><span class="<?php echo $roleClassName; ?>"></span><a href="<?php echo get_the_permalink(135) . '?id=' . $postId; ?>"><?php echo $userData->data->display_name; ?></a></td>
                                        <td><?php echo get_the_title($projectId); ?></td>
                                        <td><?php echo get_the_date('d/m/Y', $postId); ?></td>
                                    </tr>

                                <?php endwhile; endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="cf-panel">
                    <div class="cf-panel-h">
                        <div class="cf-panel-h-title">OPEN REVIEWS</div>
                    </div>

                    <div class="cf-panel-b">
	                    <?php $reviewsDoneArgs = array(
		                    'post_type' => 'reviewsdone',
		                    'posts_per_page' => -1,
		                    'meta_query' => array(
			                    'relation'  => 'AND',
			                    array(
				                    'key' => '_cf_review_done_rated',
				                    'compare' => 'NOT EXISTS',
			                    ),
			                    filterByUserRole('_cf_review_done_consultant')
		                    )
	                    );
	                    $reviewsDone = new WP_Query($reviewsDoneArgs); ?>
                        <table id="o-reviews" class="display cf-datatable" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>USERNAME</th>
                                <th>REVIEWS</th>
                                <th>DATE</th>
                            </tr>
                            </thead>
                            <tbody>

							<?php if($reviewsDone->have_posts()): while ($reviewsDone->have_posts()): $reviewsDone->the_post(); ?>

								<?php $postId = get_the_ID();
								$projectId = get_post_meta($postId, '_cf_review_done_projectid', true);
								$targetUserId = get_post_meta($postId, '_cf_review_done_target_userid', true);
								$reviewId = get_post_meta($postId, '_cf_review_done_reviewid', true);

								$userData = get_userdata( $targetUserId );
								$userRole = $userData->roles[0];
								$roleClassName = '';
								if($userRole === 'candidate') {
									$roleClassName = 'cf-sm-c-icon';
								} elseif($userRole === 'project-manager') {
									$roleClassName = 'cf-sm-m-icon';
								}
								?>
                                <tr>
                                    <td><span class="<?php echo $roleClassName; ?>"></span><a href="<?php echo get_the_permalink(104) . '?id=' . $targetUserId; ?>"><?php echo $userData->data->display_name; ?></a></td>
                                    <td><?php echo get_the_title($reviewId); ?></td>
                                    <td><?php echo get_the_date('d/m/Y', $postId); ?></td>
                                </tr>

							<?php endwhile; endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>

			</div>

			<div class="col-md-12 col-lg-4">
				<?php get_template_part( 'components/component', 'your-total' ); ?>

                <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <h6 class="m-3"><?php echo $themeOptions['cf_your_total_footer']; ?></h6>
                        <a href="mailto:d.mulder@computerfutures.nl?subject=Feedback ComputerFutures Reviews" class="cf-blue-btn text-center">PROVIDE FEEDBACK</a>
                    </div>
                </div>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
