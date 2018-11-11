<div class="cf-panel">
	<div class="cf-panel-h">
		<div class="cf-panel-h-title">
			STEPS
		</div>
	</div>

	<div class="cf-panel-b">
        <ul class="list-group cf-steps-widget">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php $reviewIdCookie = isset( $_COOKIE['export-review-id'] ) ? (int)$_COOKIE['export-review-id'] : null; ?>
                <div class="cf-steps-left">
                    STEP 1: REVIEW<br>
                    <?php if($reviewIdCookie) { ?>
                        <a href="<?php echo get_the_permalink(25); ?>"><?php echo get_the_title($reviewIdCookie); ?></a>
                    <?php } ?>
                </div>
	            <?php if($reviewIdCookie) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(25); ?>"><i class="far fa-edit"></i></a>
	            <?php } ?>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php $usersCookie = (isset( $_COOKIE['export-user-id'] ) && $_COOKIE['export-user-id'] && $_COOKIE['export-user-id'] !== 'null')
	                ? $_COOKIE['export-user-id']
	                : '';
                $userData = get_userdata( $usersCookie );
                ?>
                <div class="cf-steps-left">
                    STEP 2: USERS<br>
	                <?php if($usersCookie) { ?>
                        <a href="<?php echo get_the_permalink(25); ?>/?step=2"><?php echo $userData->data->display_name; ?></a>
	                <?php } ?>
                </div>
	            <?php if($usersCookie) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(25); ?>/?step=2"><i class="far fa-edit"></i></a>
	            <?php } ?>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
	            <?php $compareTypeCookie = (isset( $_COOKIE['export-compare-type'] ) && $_COOKIE['export-compare-type'] && $_COOKIE['export-compare-type'] !== 'null')
		            ? $_COOKIE['export-compare-type']
		            : '';

	            $compareType = '';
	            if($compareTypeCookie) {
	                if($compareTypeCookie === 'none') {
	                    $compareType = 'None';
	                } elseif($compareTypeCookie === 'users') {
	                    $userId = (int)$_COOKIE['export-compare-user-id'];
		                $userData = get_userdata( $userId );
                        $compareType = $userData->data->display_name;
                    } elseif($compareTypeCookie === 'average') {
	                    $compareType = 'Average';
	                }
                } ?>
                <div class="cf-steps-left">
                    STEP 3: COMPARE<br>
			        <?php if($compareType) { ?>
                        <a href="<?php echo get_the_permalink(25); ?>/?step=3"><?php echo $compareType; ?></a>
			        <?php } ?>
                </div>
		        <?php if($compareType) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(25); ?>/?step=3"><i class="far fa-edit"></i></a>
		        <?php } ?>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
	            <?php $periodFrom = isset( $_COOKIE['export-period-from'] ) ? $_COOKIE['export-period-from'] : '';
	            $periodTo = isset( $_COOKIE['export-period-to'] ) ? $_COOKIE['export-period-to'] : '';
	            $yearFrom = isset( $_COOKIE['export-year-from'] ) ? $_COOKIE['export-year-from'] : '';
	            $yearTo = isset( $_COOKIE['export-year-to'] ) ? $_COOKIE['export-year-to'] : '';

	            $periodNames = array('First quarter', 'Second quarter', 'Third quarter', 'Fourth quarter'); ?>
                <div class="cf-steps-left">
                    STEP 4: PERIOD<br>
	                <?php if($periodFrom && $periodTo && $yearFrom && $yearTo) { ?>
                        From: <a href="<?php echo get_the_permalink(25); ?>/?step=4"><?php echo $periodNames[$periodFrom - 1] . ' ' . $yearFrom; ?></a><br>
                        To: <a href="<?php echo get_the_permalink(25); ?>/?step=4"><?php echo $periodNames[$periodTo - 1] . ' ' . $yearTo; ?></a>
	                <?php } ?>
                </div>
	            <?php if($periodFrom && $periodTo && $yearFrom && $yearTo) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(25); ?>/?step=4"><i class="far fa-edit"></i></a>
	            <?php } ?>
            </li>
        </ul>

        <div class="col-md-12" style="text-align: center">
            <?php $reviewId = isset( $_COOKIE['export-review-id'] ) ? (int)$_COOKIE['export-review-id'] : '';
            $userId = isset( $_COOKIE['export-user-id'] ) && $_COOKIE['export-user-id'] ? $_COOKIE['export-user-id'] : '';
            $compareType = isset( $_COOKIE['export-compare-type'] ) && $_COOKIE['export-compare-type'] ? $_COOKIE['export-compare-type'] : '';
            $compareUserId = isset( $_COOKIE['export-compare-user-id'] ) && $_COOKIE['export-compare-user-id'] ? $_COOKIE['export-compare-user-id'] : '';

            $periodFrom = isset( $_COOKIE['export-period-from'] ) ? (int)$_COOKIE['export-period-from'] : '';
            $periodTo = isset( $_COOKIE['export-period-to'] ) ? (int)$_COOKIE['export-period-to'] : '';
            $yearFrom = isset( $_COOKIE['export-year-from'] ) ? (int)$_COOKIE['export-year-from'] : '';
            $yearTo = isset( $_COOKIE['export-year-to'] ) ? (int)$_COOKIE['export-year-to'] : '';

            if($periodFrom && $periodTo && $yearFrom && $yearTo && $reviewId && $userId && ($compareType !== 'users' || ($compareType === 'users' && $compareUserId))) {
                $activeToSubmit = 'cf-submit-export-pdf';
            } else {
	            $activeToSubmit = 'cf-btn-disabled';
            } ?>
            <a href="#" class="cf-blue-btn text-center mt-3 mb-3 <?php echo $activeToSubmit; ?>">CREATE PDF</a>
        </div>
	</div>
</div>