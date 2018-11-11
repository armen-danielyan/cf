<div class="cf-panel">
	<div class="cf-panel-h">
		<div class="cf-panel-h-title">
			STEPS
		</div>
	</div>

	<div class="cf-panel-b">
        <ul class="list-group cf-steps-widget">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php $reviewIdCookie = isset( $_COOKIE['review-id'] ) ? (int)$_COOKIE['review-id'] : null; ?>
                <div class="cf-steps-left">
                    STEP 1: REVIEW<br>
                    <?php if($reviewIdCookie) { ?>
                        <a href="<?php echo get_the_permalink(84); ?>/?step=1"><?php echo get_the_title($reviewIdCookie); ?></a>
                    <?php } ?>
                </div>
	            <?php if($reviewIdCookie) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(84); ?>/?step=1"><i class="far fa-edit"></i></a>
	            <?php } ?>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php $projectIdCookie = isset( $_COOKIE['project-id'] ) ? (int)$_COOKIE['project-id'] : null; ?>
                <div class="cf-steps-left">
                    STEP 2: PROJECT<br>
	                <?php if($projectIdCookie) { ?>
                        <a href="<?php echo get_the_permalink(84); ?>/?step=2"><?php echo get_the_title($projectIdCookie); ?></a>
	                <?php } ?>
                </div>
	            <?php if($projectIdCookie) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(84); ?>/?step=2"><i class="far fa-edit"></i></a>
	            <?php } ?>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php $usersCookie = (isset( $_COOKIE['user-ids'] ) && $_COOKIE['user-ids'] && $_COOKIE['user-ids'] !== 'null')
	                ? explode(',', $_COOKIE['user-ids'])
	                : []; ?>
                <div class="cf-steps-left">
                    STEP 3: USERS<br>
	                <?php if(count($usersCookie) > 0) { ?>
                        <a href="<?php echo get_the_permalink(84); ?>/?step=3"><?php echo count($usersCookie); ?></a>
	                <?php } ?>
                </div>
	            <?php if(count($usersCookie) > 0) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(84); ?>/?step=3"><i class="far fa-edit"></i></a>
	            <?php } ?>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
	            <?php $period = isset( $_COOKIE['period'] ) ? $_COOKIE['period'] : '';
	            $year = isset( $_COOKIE['year'] ) ? $_COOKIE['year'] : ''; ?>
                <div class="cf-steps-left">
                    STEP 4: PERIOD<br>
	                <?php if($period && $year) { ?>
                        <a href="<?php echo get_the_permalink(84); ?>/?step=4"><?php echo $period . ' ' . $year; ?></a>
	                <?php } ?>
                </div>
	            <?php if($period && $year) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(84); ?>/?step=4"><i class="far fa-edit"></i></a>
	            <?php } ?>
            </li>
        </ul>

        <div class="col-md-12" style="text-align: center">
            <?php if($period && $year && $reviewIdCookie && $projectIdCookie && count($usersCookie) > 0) {
                $activeToSubmit = 'cf-submit-review-done';
            } else {
	            $activeToSubmit = 'cf-btn-disabled';
            } ?>
            <a href="#" class="cf-blue-btn text-center mt-3 mb-3 <?php echo $activeToSubmit; ?>">CREATE REVIEW</a>
        </div>
	</div>
</div>