<?php
/**
 * Template Name: PDF Export
 */
?>
<?php require_once(get_template_directory() . '/libs/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('tempDir', get_template_directory() . '/tmp');

$dompdf = new Dompdf($options);

if(isset($_POST['html']) && $_POST['html']) {
	$html = $_POST['html'];

	ob_start(); ?>
	<!DOCTYPE html>
	<html lang="hy">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style>
			body {
                font-family: "Open Sans", sans-serif;
				margin: 0;
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
                margin: 5px 0;
                font-weight: normal;
                font-size: 14px;
            }

            p {
                margin: 5px 0;
            }
            .row {
                margin-bottom: 30px;
            }
            .col-md-6 {
                width: 40%;
                display: inline-block;
            }
            .col-md-12 {
                width: 100%;
                display: block;
            }
            .cf-export-results h5 {
                color: #212529;
            }
            .cf-export-results img {
                height: 200px;
                width: auto;
            }
		</style>
	</head>
	<body>
	    <?php echo html_entity_decode(stripcslashes($html)); ?>
	</body>
	</html>
	<?php $pdfContent = ob_get_contents();
	ob_end_clean();

	$dompdf->set_base_path(get_template_directory() . '/assets');
	$dompdf->loadHtml($pdfContent);
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();
	$dompdf->stream('user_report.pdf');
} else {
	wp_redirect('/');
}