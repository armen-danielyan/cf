<?php
/**
 * Template Name: PDF User Review Done
 */
?>
<?php require_once(get_template_directory() . '/libs/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('tempDir', get_template_directory() . '/tmp');

$dompdf = new Dompdf($options);

if(isset($_GET['id']) && $_GET['id']) {
	$reviewDoneId = $_GET['id'];

	$projectId = (int) get_post_meta($reviewDoneId, '_cf_review_done_projectid', true);
	$userId = (int) get_post_meta($reviewDoneId, '_cf_review_done_target_userid', true);
	$cfReviewId = get_post_meta($reviewDoneId, '_cf_review_done_reviewid', true);
	$comment = get_post_meta($reviewDoneId, '_cf_review_done_comment', true);
	$questions = unserialize(get_post_meta($reviewDoneId, '_cf_reviews_done_questions', true));

	$userData = get_userdata( $userId );
	$role = $userData->roles[0]; ?>

	<?php ob_start(); ?>
	<!DOCTYPE html>
	<html lang="hy">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style>
			body {
                font-family: "Open Sans", sans-serif;
				margin: 0;
                padding: 0;
                font-size: 12px;
			}

            h5, h4, h3 {
                color: #26a9df;
            }

            h3 {
                font-size: 20px;
                margin: 30px 0 10px 0;
            }

            h4 {
                margin: 10px 0 25px 0;
                font-size: 14px;
            }

            h5 {
                margin: 10px 0 5px 0;
                font-weight: normal;
                font-size: 14px;
            }

            p {
                margin: 5px 0;
            }

            ul {
                padding: 0;
                margin: 0;
            }

            ul li {
                padding: 15px 0 48px 0;
                list-style-type: none;
                border-bottom: 1px solid #ccc;
            }

            ul li:last-child {
                border: none;
            }

            table td {
                padding-right: 15px;
            }

            .splitter-hor {
                background-color: #ccc;
                height: 1px;
            }

            .cf-row-half {
                width: 48%;
                display: inline-block;
            }

            .cf-wrapper {
                width: 100%;
                display: inline-block;
            }

            .cf-questions-l, .cf-questions-r {
                display: inline-block;
            }

            .cf-questions-r img {
                margin-left: 5px;
            }

            .cf-questions-l {
                width: 70%;
            }

            .cf-questions-r {
                width: 29.5%;
            }

            .cf-date-l, .cf-date-r {
                display: inline-block;
            }

            .cf-date-l {
                width: 30%;
            }

            .cf-date-r {
                width: 68%;
            }
		</style>
	</head>
	<body>
	<header>
        <img width="200" src="images/logo_cf_medium.png" alt="">
	</header>
	<main>
		<section>
			<h3><?php echo get_the_title($cfReviewId); ?></h3>
            <?php $period = get_post_meta($reviewDoneId, '_cf_select_review_period', true);
            $year = get_post_meta($reviewDoneId, '_cf_select_review_year', true); ?>

            <div class="cf-date-l"><span>Created date: <?php echo get_the_date('d/m/Y', $reviewDoneId); ?></span></div>
            <div class="cf-date-r"><span>Period: <?php echo $period . ' ' . $year; ?></span></div>
		</section>
        <div class="splitter-hor"></div>
        <section>
            <h4><?php echo $userData->data->display_name; ?></h4>
            <div class="cf-wrapper">
                <div class="cf-row-half">
                    <table>
                        <tbody>
                            <tr>
                                <td>Email address:</td>
                                <td><?php echo $userData->data->user_email; ?></td>
                            </tr>
                            <tr>
                                <td>User role:</td>
                                <td><?php if($role === 'candidate') echo 'Candidate'; elseif($role === 'project-manager') echo 'Manager'; ?></td>
                            </tr>
                            <tr>
                                <td>Sector:</td>
                                <td><?php echo get_user_meta($userId, '_cf_user_sector', true); ?></td>
                            </tr>
                            <tr>
                                <td>Project:</td>
                                <td><?php echo get_the_title($projectId); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="cf-row-half">
                    <table>
                        <tbody>
                        <?php if($role === 'project-manager') { ?>
                            <tr>
                                <td>Company:</td>
                                <td><?php echo get_user_meta($userId, '_cf_user_company_name', true); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>Address:</td>
                            <td><?php echo get_user_meta($userId, '_cf_user_address', true) . ' ' . get_user_meta($userId, '_cf_user_N', true); ?></td>
                        </tr>
                        <tr>
                            <td>zip code:</td>
                            <td><?php echo get_user_meta($userId, '_cf_user_zipcode', true); ?></td>
                        </tr>
                        <tr>
                            <td>City:</td>
                            <td><?php echo get_user_meta($userId, '_cf_user_city', true); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <div class="splitter-hor"></div>
        <section>
            <ul>
		        <?php foreach($questions as $question) { ?>
                    <li>
                        <div class="cf-questions-l">
                            <h5><?php echo get_the_title($question['qid']); ?></h5>
                            <div>
						        <?php $contentPost = get_post($question['qid']);
						        $content = $contentPost->post_content;
						        $content = apply_filters('the_content', $content);
						        $content = str_replace(']]>', ']]&gt;', $content);
						        echo $content; ?>
                            </div>
                        </div>
                        <div class="cf-questions-r">

                            <div style="width:145px;margin-left:auto;font-size:0">
                                <div style="font-size: 11px; padding:0 0 10px 5px">Score:</div>
						        <?php for($i = 1; $i <= 5; $i++) {
							        if($i <= (int)$question['qr']) { ?>
								        <img width="24" src="images/star_active.png" alt="">
							        <?php } else { ?>
                                        <img width="24" src="images/star_inactive.png" alt="">
                                    <?php } ?>
						        <?php } ?>
                            </div>
                        </div>
                    </li>
		        <?php } ?>
            </ul>
        </section>
        <div class="splitter-hor"></div>
        <section>
            <h5>Comment</h5>
            <p><?php echo get_post_meta($reviewDoneId, '_cf_review_done_comment', true); ?></p>
        </section>
	</main>
	</body>
	</html>
	<?php $pdfContent = ob_get_contents();
	ob_end_clean();

	// echo $pdfContent; exit;

	$dompdf->set_base_path(get_template_directory() . '/assets');
	$dompdf->loadHtml($pdfContent);
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();
	$dompdf->stream('user_review.pdf');
} else {
	wp_redirect('/');
}