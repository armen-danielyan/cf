<?php
/**
 * Template Name: Export4
 */
?>
<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

<main id="dashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="p-4">
					<div class="cf-page-title">Export</div>
                    <a style="float:right" class="cf-white-btn" onclick="window.history.back();">BACK</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-8">

				<div class="cf-panel">

					<?php if(!isset($_GET['step'])) { ?>

						<div class="cf-panel-h">
							<div class="cf-panel-h-title">1. SELECT COMPANY</div>
							<div id="datatable-searchbar"></div>
							<a id="cf-review-start-s1" class="cf-blue-btn cf-panel-h-btn cf-panel-h-steps" href="#">SUBMIT <i class="fas fa-angle-right"></i></a>
						</div>

						<div class="cf-panel-b">

							<table id="d-with-search-list" class="display cf-datatable" style="width: 100%;">
								<thead>
								<tr>
									<th>COMPANY NAME</th>
								</tr>
								</thead>
								<tbody>
								<?php $companyId = isset( $_COOKIE['export4-company-id'] ) ? (int)$_COOKIE['export4-company-id'] : null;

								$companies = $cfCompanies = get_posts( array(
                                    'post_type' => 'companies',
                                    'posts_per_page' => -1,
                                    'post_status' => 'publish',
                                    'orderby'  => 'title',
                                    'order' => 'ASC',
                                ) );;

								foreach($companies as $company) { ?>
									<?php $postId = $company->ID; ?>
                                    <tr>
                                        <td>
                                            <label class="cf-checkbox-wrapper cf-checkbox-single">
                                                <?php echo get_the_title($postId); ?>
                                                <input type="checkbox" name="checkbox" <?php checked( $postId, $companyId ); ?> value="<?php echo $postId; ?>">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
								<?php } ?>
								</tbody>
							</table>

						</div>

					<?php } else { ?>

						<?php if($_GET['step'] == 2) { ?>

							<div class="cf-panel-h">
								<div class="cf-panel-h-title">2. SELECT FIELDS</div>
								<a id="cf-review-start-s2" class="cf-blue-btn cf-panel-h-btn cf-panel-h-steps" href="#">SUBMIT <i class="fas fa-angle-right"></i></a>
							</div>

							<div class="cf-panel-b">
                                <?php $sectorCoockie = isset( $_COOKIE['export4-sector'] ) ? $_COOKIE['export4-sector'] : null;
                                $specialismCoockie = isset( $_COOKIE['export4-specialism'] ) ? $_COOKIE['export4-specialism'] : null;
                                $experienceCoockie = isset( $_COOKIE['export4-experience'] ) ? $_COOKIE['export4-experience'] : null; ?>
								<div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="_cf_sector">Sector</label>
                                            <select name="_cf_sector" class="form-control" id="_cf_sector">
                                                <option <?php selected($sectorCoockie, ''); ?>></option>
                                                <?php $sectors = getCustomItems('sectors');
                                                foreach($sectors as $s) { ?>
                                                    <option value="<?php echo $s; ?>" <?php selected($sectorCoockie, $s); ?>><?php echo $s; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="_cf_specialism">Specialism</label>
                                            <select name="_cf_specialism" class="form-control" id="_cf_specialism">
                                                <option <?php selected($specialismCoockie, ''); ?>></option>
                                                <?php $specialisms = getCustomItems('specialisms');
                                                foreach($specialisms as $s) { ?>
                                                    <option value="<?php echo $s; ?>" <?php selected($specialismCoockie, $s); ?>><?php echo $s; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="_cf_experience">Experience</label>
                                            <select name="_cf_experience" class="form-control" id="_cf_experience">
                                                <option <?php selected($experienceCoockie, ''); ?>></option>
                                                <?php $experiences = getCustomItems('experiences');
                                                foreach($experiences as $s) { ?>
                                                    <option value="<?php echo $s; ?>" <?php selected($experienceCoockie, $s); ?>><?php echo $s; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

							</div>

                            <script>
                                jQuery(document).ready(function($) {
                                    if($("#_cf_sector").val()) {
                                        $(".cf-panel-h-steps").removeClass('cf-btn-disabled');
                                    } else {
                                        $(".cf-panel-h-steps").addClass('cf-btn-disabled');
                                    }
                                    $("#_cf_sector").on("change", function() {
                                        var val = $(this).val();
                                        if(!val) {
                                            $(".cf-panel-h-steps").addClass('cf-btn-disabled');
                                        } else {
                                            $(".cf-panel-h-steps").removeClass('cf-btn-disabled');
                                        }
                                    });
                                });
                            </script>

						<?php } ?>

						<?php if($_GET['step'] == 3) { ?>

                            <div class="cf-panel-h">
                                <div class="cf-panel-h-title">3. SELECT COMPARE COMPANY</div>
                                <div id="datatable-searchbar"></div>
                                <a id="cf-review-start-s3" class="cf-blue-btn cf-panel-h-btn cf-panel-h-steps" href="#">SUBMIT <i class="fas fa-angle-right"></i></a>
                            </div>

                            <div class="cf-panel-b">

                                <table id="d-with-search-list" class="display cf-datatable" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>COMPANY NAME</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $companyId = isset( $_COOKIE['export4-company-cmp-id'] ) ? (int)$_COOKIE['export4-company-cmp-id'] : null;

                                    $companies = get_posts( array(
                                        'post_type' => 'companies',
                                        'posts_per_page' => -1,
                                        'post_status' => 'publish',
                                        'orderby'  => 'title',
                                        'order' => 'ASC',
                                    ) );;

                                    foreach($companies as $company) { ?>
                                        <?php $postId = $company->ID; ?>
                                        <tr>
                                            <td>
                                                <label class="cf-checkbox-wrapper cf-checkbox-single">
                                                    <?php echo get_the_title($postId); ?>
                                                    <input type="checkbox" name="checkbox" <?php checked( $postId, $companyId ); ?> value="<?php echo $postId; ?>">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>

                            </div>
						<?php } ?>

						<?php if($_GET['step'] == 4) { ?>
                            <div class="cf-panel-h">
                                <div class="cf-panel-h-title">4. SELECT COMPARE FIELDS</div>
                                <a id="cf-review-start-s4" class="cf-blue-btn cf-panel-h-btn cf-panel-h-steps" href="#">SUBMIT <i class="fas fa-angle-right"></i></a>
                            </div>

                            <div class="cf-panel-b">
                                <?php $sectorCoockie = isset( $_COOKIE['export4-sector-cmp'] ) ? $_COOKIE['export4-sector-cmp'] : null;
                                $specialismCoockie = isset( $_COOKIE['export4-specialism-cmp'] ) ? $_COOKIE['export4-specialism-cmp'] : null;
                                $experienceCoockie = isset( $_COOKIE['export4-experience-cmp'] ) ? $_COOKIE['export4-experience-cmp'] : null; ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="_cf_sector">Sector</label>
                                            <select name="_cf_sector" class="form-control" id="_cf_sector">
                                                <option <?php selected($sectorCoockie, ''); ?>></option>
                                                <?php $sectors = getCustomItems('sectors');
                                                foreach($sectors as $s) { ?>
                                                    <option value="<?php echo $s; ?>" <?php selected($sectorCoockie, $s); ?>><?php echo $s; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="_cf_specialism">Specialism</label>
                                            <select name="_cf_specialism" class="form-control" id="_cf_specialism">
                                                <option <?php selected($specialismCoockie, ''); ?>></option>
                                                <?php $specialisms = getCustomItems('specialisms');
                                                foreach($specialisms as $s) { ?>
                                                    <option value="<?php echo $s; ?>" <?php selected($specialismCoockie, $s); ?>><?php echo $s; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="_cf_experience">Experience</label>
                                            <select name="_cf_experience" class="form-control" id="_cf_experience">
                                                <option <?php selected($experienceCoockie, ''); ?>></option>
                                                <?php $experiences = getCustomItems('experiences');
                                                foreach($experiences as $s) { ?>
                                                    <option value="<?php echo $s; ?>" <?php selected($experienceCoockie, $s); ?>><?php echo $s; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <script>
                                jQuery(document).ready(function($) {
                                    if($("#_cf_sector").val()) {
                                        $(".cf-panel-h-steps").removeClass('cf-btn-disabled');
                                    } else {
                                        $(".cf-panel-h-steps").addClass('cf-btn-disabled');
                                    }
                                    $("#_cf_sector").on("change", function() {
                                        var val = $(this).val();
                                        if(!val) {
                                            $(".cf-panel-h-steps").addClass('cf-btn-disabled');
                                        } else {
                                            $(".cf-panel-h-steps").removeClass('cf-btn-disabled');
                                        }
                                    });
                                });
                            </script>

						<?php } ?>

						<?php if($_GET['step'] == 5) { ?>

                            <div class="cf-panel-h">
                                <div class="cf-panel-h-title">5. RESULT</div>
                            </div>

                            <div id="cf-export-pdf-data" class="cf-panel-b">
								<?php $companyId = isset( $_COOKIE['export4-company-id'] ) ? (int)$_COOKIE['export4-company-id'] : '';
                                $sectorCoockie = isset( $_COOKIE['export4-sector'] ) ? $_COOKIE['export4-sector'] : '';
                                $specialismCoockie = isset( $_COOKIE['export4-specialism'] ) ? $_COOKIE['export4-specialism'] : '';
                                $experienceCoockie = isset( $_COOKIE['export4-experience'] ) ? $_COOKIE['export4-experience'] : '';

                                $companyCmpId = isset( $_COOKIE['export4-company-cmp-id'] ) ? (int)$_COOKIE['export4-company-cmp-id'] : '';
                                $sectorCmpCoockie = isset( $_COOKIE['export4-sector-cmp'] ) ? $_COOKIE['export4-sector-cmp'] : '';
                                $specialismCmpCoockie = isset( $_COOKIE['export4-specialism-cmp'] ) ? $_COOKIE['export4-specialism-cmp'] : '';
                                $experienceCmpCoockie = isset( $_COOKIE['export4-experience-cmp'] ) ? $_COOKIE['export4-experience-cmp'] : '';

								if($companyId && $sectorCoockie && $companyCmpId && $sectorCmpCoockie) { ?>

                                    <div id="cf-export-content">
                                        <div class="row">
                                            <div class="col-md-12 cf-export-logo">
                                                <img width="200" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo_cf_medium.png" alt="">
                                            </div>
                                        </div>

                                        <div class="row cf-sector">
                                            <div class="col-md-6">
                                                <div class="cf-user-info">
                                                    <p>COMPANY NAME: <?php echo get_the_title($companyId); ?></p>
                                                    <p>SECTOR: <?php echo $sectorCoockie; ?></p>
                                                    <?php if($specialismCoockie) { ?><p> SPECIALISM: <?php echo $specialismCoockie; ?></p><?php } ?>
                                                    <?php if($experienceCoockie) { ?><p> EXPERIENCE: <?php echo $experienceCoockie; ?></p><?php } ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="cf-user-info">
                                                    <p>COMPANY NAME: <?php echo get_the_title($companyCmpId); ?></p>
                                                    <p>SECTOR: <?php echo $sectorCmpCoockie; ?></p>
                                                    <?php if($specialismCmpCoockie) { ?><p> SPECIALISM: <?php echo $specialismCmpCoockie; ?></p><?php } ?>
                                                    <?php if($experienceCmpCoockie) { ?><p> EXPERIENCE: <?php echo $experienceCmpCoockie; ?></p><?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <h2>TARIEF</h2>
                                        <div class="row cf-sector">
                                            <?php $specialismQ = $specialismCoockie ? array('key' => '_cf_user_primspecialism', 'value' => $specialismCoockie) : array();
                                            $experienceQ = $experienceCoockie ? array('key' => '_cf_user_experience', 'value' => $experienceCoockie) : array();

                                            $args = array(
                                                'role'    => 'candidate',
                                                'orderby' => 'ID',
                                                'order'   => 'ASC',
                                                'meta_query' => array(
                                                    'relation' => 'AND',
                                                    array(
                                                        'key'     => '_cf_user_consultant',
                                                        'value'   => get_current_user_id()
                                                    ),
                                                    array(
                                                        'key'     => '_cf_user_sector',
                                                        'value'   => $sectorCoockie
                                                    ),
                                                    $specialismQ,
                                                    $experienceQ
                                                )
                                            );
                                            $users = new WP_User_Query( $args );
                                            $data = array();

                                            $hourlyRateTotal = 0;
                                            $hourlyRateClientTotal = 0;

                                            $htc = 0;
                                            $htcc = 0;

                                            foreach ($users->get_results() as $user) {
                                                $userId = $user->ID;
                                                $hourlyRate = get_user_meta( $userId, '_cf_user_hourly_rate', true );
                                                $hourlyRateClient = get_user_meta( $userId, '_cf_user_hourly_rate_c', true );

                                                if($hourlyRate) {
                                                    $hourlyRateTotal += (float)$hourlyRate;
                                                    $htc++;
                                                }

                                                if($hourlyRateClient) {
                                                    $hourlyRateClientTotal += (float)$hourlyRateClient;
                                                    $htcc++;
                                                }
                                            }
                                            $hourlyRateAvg = $hourlyRateTotal ? $hourlyRateTotal / $htc : 0;
                                            $hourlyRateClientAvg = $hourlyRateClientTotal ? $hourlyRateClientTotal / $htcc : 0; ?>
                                            <div class="col-md-6">
                                                <div class="cf-user-info">
                                                    <p>AMOUNT PAID PER CANDIDATE ON AVERAGE:</p>
                                                    <h5 class="text-center"><?php echo money_format('%i', $hourlyRateAvg); ?> EURO</h5>
                                                    <p>AMOUNT EARNED PER CANDIDATE ON AVERAGE:</p>
                                                    <h5 class="text-center"><?php echo money_format('%i', $hourlyRateClientAvg); ?> EURO</h5>
                                                </div>
                                            </div>

                                            <?php $specialismQ = $specialismCmpCoockie ? array('key' => '_cf_user_primspecialism', 'value' => $specialismCmpCoockie) : array();
                                            $experienceQ = $experienceCmpCoockie ? array('key' => '_cf_user_experience', 'value' => $experienceCmpCoockie) : array();

                                            $args = array(
                                                'role'    => 'candidate',
                                                'orderby' => 'ID',
                                                'order'   => 'ASC',
                                                'meta_query' => array(
                                                    'relation' => 'AND',
                                                    array(
                                                        'key'     => '_cf_user_consultant',
                                                        'value'   => get_current_user_id()
                                                    ),
                                                    array(
                                                        'key'     => '_cf_user_sector',
                                                        'value'   => $sectorCmpCoockie
                                                    ),
                                                    $specialismQ,
                                                    $experienceQ
                                                )
                                            );
                                            $users = new WP_User_Query( $args );
                                            $data = array();

                                            $hourlyRateTotal = 0;
                                            $hourlyRateClientTotal = 0;

                                            $htc = 0;
                                            $htcc = 0;

                                            foreach ($users->get_results() as $user) {
                                                $userId = $user->ID;
                                                $hourlyRate = get_user_meta( $userId, '_cf_user_hourly_rate', true );
                                                $hourlyRateClient = get_user_meta( $userId, '_cf_user_hourly_rate_c', true );

                                                if($hourlyRate) {
                                                    $hourlyRateTotal += (float)$hourlyRate;
                                                    $htc++;
                                                }

                                                if($hourlyRateClient) {
                                                    $hourlyRateClientTotal += (float)$hourlyRateClient;
                                                    $htcc++;
                                                }
                                            }
                                            $hourlyRateAvg = $hourlyRateTotal ? $hourlyRateTotal / $htc : 0;
                                            $hourlyRateClientAvg = $hourlyRateClientTotal ? $hourlyRateClientTotal / $htcc : 0; ?>
                                            <div class="col-md-6">
                                                <div class="cf-user-info">
                                                    <p>AMOUNT PAID PER CANDIDATE ON AVERAGE:</p>
                                                    <h5 class="text-center"><?php echo money_format('%i', $hourlyRateAvg); ?> EURO</h5>
                                                    <p>AMOUNT EARNED PER CANDIDATE ON AVERAGE:</p>
                                                    <h5 class="text-center"><?php echo money_format('%i', $hourlyRateClientAvg); ?> EURO</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <h2>RATING</h2>
                                        <div class="row cf-sector">
                                            <div class="col-md-6">
                                                <div class="cf-user-info">
                                                    <?php $specialismQ = $specialismCoockie ? array('key' => '_cf_user_primspecialism', 'value' => $specialismCoockie) : array();
                                                    $experienceQ = $experienceCoockie ? array('key' => '_cf_user_experience', 'value' => $experienceCoockie) : array();

                                                    $args = array(
                                                        'role'    => 'candidate',
                                                        'orderby' => 'ID',
                                                        'order'   => 'ASC',
                                                        'meta_query' => array(
                                                            'relation' => 'AND',
                                                            array(
                                                                'key'     => '_cf_user_consultant',
                                                                'value'   => get_current_user_id()
                                                            ),
                                                            array(
                                                                'key'     => '_cf_user_sector',
                                                                'value'   => $sectorCoockie
                                                            ),
                                                            $specialismQ,
                                                            $experienceQ
                                                        )
                                                    );
                                                    $users = new WP_User_Query( $args );
                                                    $userIds = [];
                                                    foreach ($users->get_results() as $user) {
                                                        $userIds[] = $user->ID;
                                                    }

                                                    $reviewsDone = new WP_Query(array(
                                                        'post_type' => 'reviewsdone',
                                                        'posts_per_page' => -1,
                                                        'meta_query' => array(
                                                            'relation' => 'AND',
                                                            array(
                                                                'key' => '_cf_review_done_target_userid',
                                                                'value' => $userIds,
                                                                'compare' => 'IN',
                                                            ),
                                                            array(
                                                                'key' => '_cf_review_done_rated',
                                                                'value' => '1',
                                                            ),
                                                            array(
                                                                'key' => '_cf_review_done_consultant',
                                                                'value' => get_current_user_id()
                                                            )
                                                        )
                                                    ));

                                                    $ratingTotal = 0;
                                                    $r = 0;
                                                    foreach ($reviewsDone->get_posts() as $reviewDone) {
                                                        $postId = $reviewDone->ID;
                                                        $rate = get_post_meta($postId, '_cf_review_done_rating', true);

                                                        if($rate) {
                                                            $ratingTotal += (float)$rate;
                                                            $r++;
                                                        }
                                                    }
                                                    $ratingAvg = $ratingTotal ? $ratingTotal / $r : 0; ?>
                                                    <p>AMOUNT PAID PER CANDIDATE ON AVERAGE:</p>
                                                    <h5 class="text-center"><?php echo round($ratingAvg,2); ?></h5>

                                                    <?php $args = array(
                                                        'role'    => 'project-manager',
                                                        'orderby' => 'ID',
                                                        'order'   => 'ASC',
                                                        'meta_query' => array(
                                                            'relation' => 'AND',
                                                            array(
                                                                'key'     => '_cf_user_consultant',
                                                                'value'   => get_current_user_id()
                                                            ),
                                                            array(
                                                                'key'     => '_cf_user_sector',
                                                                'value'   => $sectorCoockie
                                                            )
                                                        )
                                                    );
                                                    $users = new WP_User_Query( $args );
                                                    $userIds = [];
                                                    foreach ($users->get_results() as $user) {
                                                        $userIds[] = $user->ID;
                                                    }

                                                    $reviewsDone = new WP_Query(array(
                                                        'post_type' => 'reviewsdone',
                                                        'posts_per_page' => -1,
                                                        'meta_query' => array(
                                                            'relation' => 'AND',
                                                            array(
                                                                'key' => '_cf_review_done_target_userid',
                                                                'value' => $userIds,
                                                                'compare' => 'IN',
                                                            ),
                                                            array(
                                                                'key' => '_cf_review_done_rated',
                                                                'value' => '1',
                                                            ),
                                                            array(
                                                                'key' => '_cf_review_done_consultant',
                                                                'value' => get_current_user_id()
                                                            )
                                                        )
                                                    ));

                                                    $ratingTotal = 0;
                                                    $r = 0;
                                                    foreach ($reviewsDone->get_posts() as $reviewDone) {
                                                        $postId = $reviewDone->ID;
                                                        $rate = get_post_meta($postId, '_cf_review_done_rating', true);

                                                        if($rate) {
                                                            $ratingTotal += (float)$rate;
                                                            $r++;
                                                        }
                                                    }
                                                    $ratingAvg = $ratingTotal ? $ratingTotal / $r : 0; ?>
                                                    <p>AMOUNT EARNED PER CANDIDATE ON AVERAGE:</p>
                                                    <h5 class="text-center"><?php echo round($ratingAvg,2); ?></h5>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="cf-user-info">
                                                    <?php $specialismQ = $specialismCmpCoockie ? array('key' => '_cf_user_primspecialism', 'value' => $specialismCmpCoockie) : array();
                                                    $experienceQ = $experienceCmpCoockie ? array('key' => '_cf_user_experience', 'value' => $experienceCmpCoockie) : array();

                                                    $args = array(
                                                        'role'    => 'candidate',
                                                        'orderby' => 'ID',
                                                        'order'   => 'ASC',
                                                        'meta_query' => array(
                                                            'relation' => 'AND',
                                                            array(
                                                                'key'     => '_cf_user_consultant',
                                                                'value'   => get_current_user_id()
                                                            ),
                                                            array(
                                                                'key'     => '_cf_user_sector',
                                                                'value'   => $sectorCmpCoockie
                                                            ),
                                                            $specialismQ,
                                                            $experienceQ
                                                        )
                                                    );
                                                    $users = new WP_User_Query( $args );
                                                    $userIds = [];
                                                    foreach ($users->get_results() as $user) {
                                                        $userIds[] = $user->ID;
                                                    }

                                                    $reviewsDone = new WP_Query(array(
                                                        'post_type' => 'reviewsdone',
                                                        'posts_per_page' => -1,
                                                        'meta_query' => array(
                                                            'relation' => 'AND',
                                                            array(
                                                                'key' => '_cf_review_done_target_userid',
                                                                'value' => $userIds,
                                                                'compare' => 'IN',
                                                            ),
                                                            array(
                                                                'key' => '_cf_review_done_rated',
                                                                'value' => '1',
                                                            ),
                                                            array(
                                                                'key' => '_cf_review_done_consultant',
                                                                'value' => get_current_user_id()
                                                            )
                                                        )
                                                    ));

                                                    $ratingTotal = 0;
                                                    $r = 0;
                                                    foreach ($reviewsDone->get_posts() as $reviewDone) {
                                                        $postId = $reviewDone->ID;
                                                        $rate = get_post_meta($postId, '_cf_review_done_rating', true);

                                                        if($rate) {
                                                            $ratingTotal += (float)$rate;
                                                            $r++;
                                                        }
                                                    }
                                                    $ratingAvg = $ratingTotal ? $ratingTotal / $r : 0; ?>
                                                    <p>AMOUNT PAID PER CANDIDATE ON AVERAGE:</p>
                                                    <h5 class="text-center"><?php echo round($ratingAvg,2); ?></h5>

                                                    <?php $args = array(
                                                        'role'    => 'project-manager',
                                                        'orderby' => 'ID',
                                                        'order'   => 'ASC',
                                                        'meta_query' => array(
                                                            'relation' => 'AND',
                                                            array(
                                                                'key'     => '_cf_user_consultant',
                                                                'value'   => get_current_user_id()
                                                            ),
                                                            array(
                                                                'key'     => '_cf_user_sector',
                                                                'value'   => $sectorCmpCoockie
                                                            )
                                                        )
                                                    );
                                                    $users = new WP_User_Query( $args );
                                                    $userIds = [];
                                                    foreach ($users->get_results() as $user) {
                                                        $userIds[] = $user->ID;
                                                    }

                                                    $reviewsDone = new WP_Query(array(
                                                        'post_type' => 'reviewsdone',
                                                        'posts_per_page' => -1,
                                                        'meta_query' => array(
                                                            'relation' => 'AND',
                                                            array(
                                                                'key' => '_cf_review_done_target_userid',
                                                                'value' => $userIds,
                                                                'compare' => 'IN',
                                                            ),
                                                            array(
                                                                'key' => '_cf_review_done_rated',
                                                                'value' => '1',
                                                            ),
                                                            array(
                                                                'key' => '_cf_review_done_consultant',
                                                                'value' => get_current_user_id()
                                                            )
                                                        )
                                                    ));

                                                    $ratingTotal = 0;
                                                    $r = 0;
                                                    foreach ($reviewsDone->get_posts() as $reviewDone) {
                                                        $postId = $reviewDone->ID;
                                                        $rate = get_post_meta($postId, '_cf_review_done_rating', true);

                                                        if($rate) {
                                                            $ratingTotal += (float)$rate;
                                                            $r++;
                                                        }
                                                    }
                                                    $ratingAvg = $ratingTotal ? $ratingTotal / $r : 0; ?>
                                                    <p>AMOUNT EARNED PER CANDIDATE ON AVERAGE:</p>
                                                    <h5 class="text-center"><?php echo round($ratingAvg,2); ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>

                            <script>
                                jQuery(document).ready(function($) {
                                    $("body").on("click", ".cf-submit-export-pdf", function() {
                                        var html = $("#cf-export-pdf-data");
                                        var htmlClone = html.clone();

                                        $('<form>', {
                                            'action': '<?php echo get_the_permalink(299); ?>',
                                            'target': '_blank',
                                            'method': 'POST'
                                        }).append($('<input>', {
                                            'name': 'html',
                                            'value': htmlClone.html(),
                                            'type': 'hidden'
                                        })).appendTo(document.body).submit();
                                    })
                                });
                            </script>

						<?php } ?>
					<?php }; ?>
				</div>
			</div>

			<div class="col-md-12 col-lg-4">
				<?php get_template_part( 'components/component', 'export4-steps' ); ?>
			</div>
		</div>
	</div>
</main>

<script>
    jQuery(document).ready(function($) {
        if($(".cf-checkbox-wrapper").length) {
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
        }

        $("#cf-review-start-s1").on('click', function() {
            var selectedCompanyId = $(".cf-checkbox-wrapper input[type='checkbox']:checked").val();
            if(selectedCompanyId) {
                $.cookie("export4-company-id", selectedCompanyId, {path: '/'});
                window.location.href = "<?php echo get_the_permalink(502); ?>/?step=2";
            } else {
                $.cookie("export4-company-id", '', {path: '/'});
            }
        });

        $("#cf-review-start-s2").on('click', function() {
            var selectedSector = $("#_cf_sector").val();
            var selectedSpecialism = $("#_cf_specialism").val();
            var selectedExperience = $("#_cf_experience").val();

            if(selectedSector) {
                $.cookie("export4-sector", selectedSector, {path: '/'});
            } else {
                $.cookie("export4-sector", '', {path: '/'});
            }

            if(selectedSpecialism) {
                $.cookie("export4-specialism", selectedSpecialism, {path: '/'});
            } else {
                $.cookie("export4-specialism", '', {path: '/'});
            }

            if(selectedExperience) {
                $.cookie("export4-experience", selectedExperience, {path: '/'});
            } else {
                $.cookie("export4-experience", '', {path: '/'});
            }

            if(selectedSector) {
                window.location.href = "<?php echo get_the_permalink(502); ?>/?step=3";
            }
        });

        $("#cf-review-start-s3").on('click', function() {
            var selectedCompanyId = $(".cf-checkbox-wrapper input[type='checkbox']:checked").val();
            if(selectedCompanyId) {
                $.cookie("export4-company-cmp-id", selectedCompanyId, {path: '/'});
                window.location.href = "<?php echo get_the_permalink(502); ?>/?step=4";
            } else {
                $.cookie("export4-company-cmp-id", '', {path: '/'});
            }
        });

        $("#cf-review-start-s4").on('click', function() {
            var selectedSector = $("#_cf_sector").val();
            var selectedSpecialism = $("#_cf_specialism").val();
            var selectedExperience = $("#_cf_experience").val();

            if(selectedSector) {
                $.cookie("export4-sector-cmp", selectedSector, {path: '/'});
            } else {
                $.cookie("export4-sector-cmp", '', {path: '/'});
            }

            if(selectedSpecialism) {
                $.cookie("export4-specialism-cmp", selectedSpecialism, {path: '/'});
            } else {
                $.cookie("export4-specialism-cmp", '', {path: '/'});
            }

            if(selectedExperience) {
                $.cookie("export4-experience-cmp", selectedExperience, {path: '/'});
            } else {
                $.cookie("export4-experience-cmp", '', {path: '/'});
            }

            if(selectedSector) {
                window.location.href = "<?php echo get_the_permalink(502); ?>/?step=5";
            }
        });
    });
</script>

<?php get_footer(); ?>
