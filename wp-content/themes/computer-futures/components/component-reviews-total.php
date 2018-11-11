<div class="cf-panel">
	<div class="cf-panel-h">
		<div class="cf-panel-h-title">
			REVIEWS TOTAL
		</div>
	</div>

	<div class="cf-panel-b">
		<?php if(isset($_GET['id']) && $_GET['id']) {
			$userId = $_GET['id'];

            $reviewsDoneArgs = array(
                'post_type' => 'reviewsdone',
                'posts_per_page' => -1,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => '_cf_review_done_target_userid',
                        'value' => $userId
                    ),
                    array(
                        'key' => '_cf_review_done_rated',
                        'value' => '1',
                    )
                )
            );
            $reviewsDone = new WP_Query($reviewsDoneArgs);
			$reviewsDoneCount = $reviewsDone->post_count;

			$reviewsToDoArgs = array(
				'post_type' => 'reviewsdone',
				'posts_per_page' => -1,
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => '_cf_review_done_target_userid',
						'value' => $userId
					),
					array(
                        'relation' => 'OR',
                        array(
                            'key' => '_cf_review_done_rated',
                            'compare' => 'NOT EXISTS',
                        ),
                        array(
                            'key' => '_cf_review_done_rated',
                            'value' => '',
                        )
                    )

				)
			);
			$reviewsToDo = new WP_Query($reviewsToDoArgs);
			$reviewsToDoCount = $reviewsToDo->post_count; ?>

            <ul class="list-group">
                <li class="list-group-item d-flex align-items-center cf-js-clickable">
                    <span class="cf-lg-checked-icon"><i class="fas fa-check"></i></span>
                    REVIEWS DONE
                    <span class="cf-sidebar-counts ml-auto"><?php echo $reviewsDoneCount; ?></span>
                </li>
                <li class="list-group-item d-flex align-items-center cf-js-clickable">
                    <span class="cf-lg-star-icon"><i class="fas fa-star"></i></span>
                    REVIEWS TO DO
                    <span class="cf-sidebar-counts ml-auto"><?php echo $reviewsToDoCount; ?></span>
                </li>
            </ul>
            <script>
                jQuery(document).ready(function ($) {
                    $(".cf-js-clickable").on("click", function() {
                        window.location.href = "<?php echo get_the_permalink(180) . '/?id=' . $userId; ?>";
                    })
                })
            </script>
		<?php } ?>
	</div>
</div>