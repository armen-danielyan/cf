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
                                        $reviewTargetUserType = get_post_meta($postId, '_cf_review_target_user_type', true);

	                                    $userRoleTitle = '';
	                                    if($reviewTargetUserType === 'candidate') {
		                                    $userRoleTitle = 'Candidates';
	                                    } elseif ($reviewTargetUserType === 'project-manager') {
		                                    $userRoleTitle = 'Managers';
                                        } ?>
                                        <tr>
                                            <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                                            <td><?php echo $userRoleTitle; ?></td>
                                            <td><?php echo reviewsDoneByReviewId($postId); ?></td>
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
				</div>
			</div>
		</div>
	</main>

<?php get_footer(); ?>