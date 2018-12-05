<div class="cf-panel">
	<div class="cf-panel-h">
		<div class="cf-panel-h-title">
			STEPS
		</div>
	</div>

	<div class="cf-panel-b">
        <ul class="list-group cf-steps-widget">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php $companyId = isset( $_COOKIE['export4-company-id'] ) ? (int) $_COOKIE['export4-company-id'] : null; ?>
                <div class="cf-steps-left">
                    STEP 1: COMPANY<br>
                    <?php if($companyId) { ?>
                        <a href="<?php echo get_the_permalink(502); ?>"><?php echo get_the_title($companyId); ?></a>
                    <?php } ?>
                </div>
	            <?php if($companyId) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(502); ?>"><i class="far fa-edit"></i></a>
	            <?php } ?>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php $sectorCookie = (isset( $_COOKIE['export4-sector'] ) && $_COOKIE['export4-sector'] && $_COOKIE['export4-sector'] !== 'null')
	                ? $_COOKIE['export4-sector']
	                : '';

                $specialismCookie = (isset( $_COOKIE['export4-specialism'] ) && $_COOKIE['export4-specialism'] && $_COOKIE['export4-specialism'] !== 'null')
                    ? $_COOKIE['export4-specialism']
                    : '';

                $experienceCookie = (isset( $_COOKIE['export4-experience'] ) && $_COOKIE['export4-experience'] && $_COOKIE['export4-experience'] !== 'null')
                    ? $_COOKIE['export4-experience']
                    : ''; ?>
                <div class="cf-steps-left">
                    STEP 2: FIELDS<br>
	                <?php if($sectorCookie) { ?>
                        <a href="<?php echo get_the_permalink(502); ?>/?step=2">
                            <span><?php echo $sectorCookie; ?></span>
                            <?php if($specialismCookie) { ?>
                                <br><span><?php echo $specialismCookie; ?></span>
                            <?php } ?>
                            <?php if($experienceCookie) { ?>
                                <br><span><?php echo $experienceCookie; ?></span>
                            <?php } ?>
                        </a>
	                <?php } ?>
                </div>
	            <?php if($sectorCookie) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(502); ?>/?step=2"><i class="far fa-edit"></i></a>
	            <?php } ?>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php $companyCmpId = isset( $_COOKIE['export4-company-cmp-id'] ) ? (int) $_COOKIE['export4-company-cmp-id'] : null; ?>
                <div class="cf-steps-left">
                    STEP 3: COMPANY COMPARE<br>
                    <?php if($companyCmpId) { ?>
                        <a href="<?php echo get_the_permalink(502); ?>/?step=3"><?php echo get_the_title($companyCmpId); ?></a>
                    <?php } ?>
                </div>
                <?php if($companyCmpId) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(502); ?>/?step=3"><i class="far fa-edit"></i></a>
                <?php } ?>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php $sectorCmpCookie = (isset( $_COOKIE['export4-sector-cmp'] ) && $_COOKIE['export4-sector-cmp'] && $_COOKIE['export4-sector-cmp'] !== 'null')
                    ? $_COOKIE['export4-sector-cmp']
                    : '';

                $specialismCmpCookie = (isset( $_COOKIE['export4-specialism-cmp'] ) && $_COOKIE['export4-specialism-cmp'] && $_COOKIE['export4-specialism-cmp'] !== 'null')
                    ? $_COOKIE['export4-specialism-cmp']
                    : '';

                $experienceCmpCookie = (isset( $_COOKIE['export4-experience-cmp'] ) && $_COOKIE['export4-experience-cmp'] && $_COOKIE['export4-experience-cmp'] !== 'null')
                    ? $_COOKIE['export4-experience-cmp']
                    : ''; ?>
                <div class="cf-steps-left">
                    STEP 4: FIELDS COMPARE<br>
                    <?php if($sectorCmpCookie) { ?>
                        <a href="<?php echo get_the_permalink(502); ?>/?step=4">
                            <span><?php echo $sectorCmpCookie; ?></span>
                            <?php if($specialismCmpCookie) { ?>
                                <br><span><?php echo $specialismCmpCookie; ?></span>
                            <?php } ?>
                            <?php if($experienceCmpCookie) { ?>
                                <br><span><?php echo $experienceCmpCookie; ?></span>
                            <?php } ?>
                        </a>
                    <?php } ?>
                </div>
                <?php if($sectorCmpCookie) { ?>
                    <a class="cf-steps-right" href="<?php echo get_the_permalink(502); ?>/?step=4"><i class="far fa-edit"></i></a>
                <?php } ?>
            </li>
        </ul>

        <div class="col-md-12" style="text-align: center">
            <?php $companyId = isset( $_COOKIE['export4-company-id'] ) ? (int)$_COOKIE['export4-company-id'] : '';
            $sectorCoockie = isset( $_COOKIE['export4-sector'] ) ? $_COOKIE['export4-sector'] : '';
            $specialismCoockie = isset( $_COOKIE['export4-specialism'] ) ? $_COOKIE['export4-specialism'] : '';
            $experienceCoockie = isset( $_COOKIE['export4-experience'] ) ? $_COOKIE['export4-experience'] : '';

            $companyCmpId = isset( $_COOKIE['export4-company-cmp-id'] ) ? (int)$_COOKIE['export4-company-cmp-id'] : '';
            $sectorCmpCoockie = isset( $_COOKIE['export4-sector-cmp'] ) ? $_COOKIE['export4-sector-cmp'] : '';
            $specialismCmpCoockie = isset( $_COOKIE['export4-specialism-cmp'] ) ? $_COOKIE['export4-specialism-cmp'] : '';
            $experienceCmpCoockie = isset( $_COOKIE['export4-experience-cmp'] ) ? $_COOKIE['export4-experience-cmp'] : '';

            if($companyId && $sectorCoockie && $companyCmpId && $sectorCmpCoockie) {
                $activeToSubmit = 'cf-submit-export-pdf';
            } else {
	            $activeToSubmit = 'cf-btn-disabled';
            } ?>
            <a href="#" class="cf-blue-btn text-center mt-3 mb-3 <?php echo $activeToSubmit; ?>">CREATE PDF</a>
        </div>
	</div>
</div>