<?php
/**
 * Template Name: User Reviews
 */
?>

<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

<main id="dashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="p-4">
					<div class="cf-page-title">Users</div>
					<a style="float:right" class="cf-white-btn" href="<?php echo get_the_permalink(23); ?>">BACK</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-8">

				<div class="cf-panel">
					<?php if(isset($_GET['id']) && $_GET['id']) {
						$userId = $_GET['id'];
						$userData = get_userdata( $userId );
					} ?>
					<div class="cf-panel-h">
						<div class="cf-panel-h-title">REVIEW LIST <?php echo $userData->data->display_name; ?></div>
					</div>

					<div class="cf-panel-b">
						<table id="d-with-search-list" class="display cf-datatable" style="width: 100%;">
							<thead>
							<tr>
								<th>NAME</th>
								<th>PROJECT NAME</th>
								<th>REVIEW DONE</th>
								<th>DATE</th>
							</tr>
							</thead>
							<tbody>
							<?php $reviewsDoneArgs = array(
								'post_type' => 'reviewsdone',
								'posts_per_page' => -1,
								'meta_query' => array(
									'relation'  => 'AND',
									array(
										'key' => '_cf_review_done_target_userid',
										'value' => $userId,
									),
									filterByUserRole('_cf_review_done_consultant')
								)
							);
							$reviewsDone = new WP_Query($reviewsDoneArgs);
							if($reviewsDone->have_posts()): while($reviewsDone->have_posts()): $reviewsDone->the_post(); ?>
								<?php $postId = get_the_ID();
								$reviewId = get_post_meta($postId, '_cf_review_done_reviewid', true);
								$projectId = get_post_meta($postId, '_cf_review_done_projectid', true);
								$reviewDone = get_post_meta($postId, '_cf_review_done_rated', true); ?>
								<tr>
									<td><?php echo get_the_title($reviewId); ?></td>
									<td><?php echo get_the_title($projectId); ?></td>
									<td><span class="cf-review-rated"><?php if($reviewDone) echo '<i class="fas fa-check"></i>'; ?></span></td>
									<td><?php echo get_the_date('d/m/Y', $postId); ?></td>
								</tr>
							<?php endwhile; endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-md-12 col-lg-4">
				<?php get_template_part( 'components/component', 'reviews-total' ); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
