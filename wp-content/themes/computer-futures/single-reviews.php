<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

	<main id="dashboard">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="p-4">
						<div class="cf-page-title">Review</div>
                        <a style="float:right" class="cf-white-btn" onclick="window.history.back();">BACK</a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-lg-8">

					<div class="cf-panel">
						<div class="cf-panel-h">
							<div class="cf-panel-h-title"><?php the_title(); ?></div>
						</div>

						<div class="cf-panel-b">
                            <?php $postId = get_the_ID(); ?>
                            <div class="row">
                                <dic class="col-md-12">
                                    <div class="cf-inputs-title">COMMENT</div>

                                    <div class="form-group">
			                            <?php $cfComment = get_post_meta($postId, '_cf_review_comment', true); ?>
                                        <textarea style="width: 100%;padding: 10px;" class="cf-input" cols="30" rows="4" readonly><?php echo $cfComment; ?></textarea>
                                    </div>
                                </dic>

                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php $cfUserType = get_post_meta($postId, '_cf_review_target_user_type', true);
                                            if($cfUserType === 'candidate') {
                                                $roleClassName = 'cf-sm-c-icon';
                                                $roleName = 'Candidate';
                                            } elseif($cfUserType === 'project-manager') {
                                                $roleClassName = 'cf-sm-m-icon';
	                                            $roleName = 'Manager';
                                            } ?>
                                            <div class="cf-panel-b-sec-wrapper">
                                                <span class="cf-panel-b-sec-title mr-3">REVIEW FOR:</span><span class="<?php echo $roleClassName; ?>"></span><?php echo $roleName; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="cf-panel-b-sec-wrapper">
                                                <span class="cf-panel-b-sec-title mr-3">Created on:</span><?php the_date('d/m/Y'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="cf-inputs-title">QUESTIONS</div>

	                                <?php $cfQuestionsRaw = get_post_meta($post->ID, '_cf_review_questions', true);
	                                $cfQuestions = unserialize($cfQuestionsRaw);
	                                if ( count( $cfQuestions ) > 0 && is_array($cfQuestions)) {
		                                foreach( $cfQuestions as $cfQuestion ) { ?>
                                            <div class="form-group">
                                                <input type="text" class="form-control cf-input" value="<?php echo get_the_title($cfQuestion); ?>" readonly>
                                            </div>
		                                <?php }
	                                } ?>
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