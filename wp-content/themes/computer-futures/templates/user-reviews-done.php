<?php
/**
 * Template Name: User Reviews Done
 */
?>

<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

<main id="dashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="p-4">
					<div class="cf-page-title">Reviews</div>
                    <a style="float:right" class="cf-white-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">BACK</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-8">

				<div class="cf-panel">
					<?php if(isset($_GET['id']) && $_GET['id']) {
						$reviewDoneId = $_GET['id'];
						$projectId = (int) get_post_meta($reviewDoneId, '_cf_review_done_projectid', true);
						$userId = (int) get_post_meta($reviewDoneId, '_cf_review_done_target_userid', true);
						$cfReviewId = get_post_meta($reviewDoneId, '_cf_review_done_reviewid', true);
						$comment = get_post_meta($reviewDoneId, '_cf_review_done_comment', true);
						$questions = unserialize(get_post_meta($reviewDoneId, '_cf_reviews_done_questions', true));

						$userData = get_userdata( $userId );
					} ?>
					<div class="cf-panel-h">
						<div class="cf-panel-h-title"><?php echo get_the_title($cfReviewId); ?></div>
                        <a id="" class="cf-blue-btn cf-panel-h-btn cf-panel-h-btn-no-margin" href="<?php echo get_the_permalink(274) . '?id=' . $reviewDoneId; ?>">Export to PDF</a>
					</div>

					<div class="cf-panel-b">
						<div class="row">
							<div class="col-md-12">
								<div class="cf-user-review-done-info">
                                    <div class="cf-panel-h-text">Created date</div>
                                    <div class="cf-panel-c-text"><?php echo get_the_date('d/m/Y', $reviewDoneId); ?></div>

									<div class="cf-panel-h-text">User information</div>
									<table class="cf-panel-user-info">
										<tbody>
											<tr>
												<td>Name:</td>
												<td><?php echo $userData->data->display_name; ?></td>
											</tr>
											<tr>
												<td>Email address:</td>
												<td><?php echo $userData->data->user_email; ?></td>
											</tr>
											<tr>
												<td>Project:</td>
												<td><?php echo get_the_title($projectId); ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<ul class="list-group">
									<?php foreach($questions as $question) { ?>
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<div>
												<div class="cf-panel-h-text"><?php echo get_the_title($question['qid']); ?></div>
												<div class="cf-panel-c-text">
													<?php $contentPost = get_post($question['qid']);
													$content = $contentPost->post_content;
													$content = apply_filters('the_content', $content);
													$content = str_replace(']]>', ']]&gt;', $content);
													echo $content; ?>
												</div>
											</div>
											<div class="cf-stars">
												<p>
													<?php for($i = 1; $i <= 5; $i++) {
														$starClass = '';
														if($i <= (int)$question['qr']) {
															$starClass = 'cf-star-active';
														} ?>

														<i class="fas fa-star <?php echo $starClass; ?>"></i>
													<?php } ?>
												</p>
											</div>
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="cf-panel-h-text">Comment</div>
								<div class="cf-panel-c-text" style="padding: 10px; background-color: #eeeeee"><?php echo $comment; ?></div>
							</div>
						</div>
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
