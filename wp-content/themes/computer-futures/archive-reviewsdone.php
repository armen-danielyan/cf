<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

	<main id="dashboard">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
                    <div class="p-4">
                        <div class="cf-page-title">Reviews</div>
                        <a class="cf-blue-btn" href="<?php echo get_the_permalink(84); ?>/?step=1">START A REVIEW</a>
                    </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-lg-8">

					<div class="cf-panel">
						<div class="cf-panel-h">
							<div class="cf-panel-h-title">REVIEW LIST</div>
                            <div id="datatable-searchbar"></div>
						</div>

						<div class="cf-panel-b">
							<table id="d-with-search-list" class="display cf-datatable" style="width: 100%;">
								<thead>
								<tr>
									<th>NAME</th>
									<th>USER</th>
									<th>REVIEWS DONE</th>
									<th>DATE</th>
								</tr>
								</thead>
								<tbody>
                                    <?php if(have_posts()): while(have_posts()): the_post(); ?>
                                        <?php $postId = get_the_ID();
                                        $reviewTargetUserId = get_post_meta($postId, '_cf_review_target_userid', true);
                                        $projectId = get_post_meta($postId, '_cf_review_projectid', true);

	                                    $userData = get_userdata( $reviewTargetUserId );
	                                    $userRole = $userData->roles[0];

	                                    $userRoleTitle = 'Managers';

	                                    if($userRole === 'candidate') {
		                                    $userRoleTitle = 'Candidates';
	                                    } elseif ($userRole === 'project-manager') {
		                                    $userRoleTitle = 'Managers';
                                        } ?>
                                        <tr>
                                            <td><?php the_title(); ?></td>
                                            <td><?php echo $userRoleTitle; ?></td>
                                            <td><?php echo getReviewsCount($projectId); ?></td>
                                            <td><?php the_date('d/m/Y'); ?></td>
                                        </tr>
	                                <?php endwhile; endif; ?>
								</tbody>
							</table>
						</div>
					</div>

				</div>

				<div class="col-md-12 col-lg-4">
					<?php get_template_part( 'components/component', 'your-total' ); ?>
				</div>
			</div>
		</div>
	</main>

<?php get_footer(); ?>