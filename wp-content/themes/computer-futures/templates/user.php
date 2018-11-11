<?php
/**
 * Template Name: User
 */
?>
<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

<main id="dashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="p-4">
					<div class="cf-page-title">User</div>
                    <a style="float:right" class="cf-white-btn" onclick="window.history.back();">BACK</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-8">
                <?php if(isset($_GET['id']) && $_GET['id']): ?>
                    <?php $userId = $_GET['id'];
	                $userData = get_userdata( $userId );
	                $userRole = $userData->roles[0];
	                $roleName = '';
	                if($userRole === 'candidate') {
		                $roleName = 'Candidate';
	                } elseif($userRole === 'project-manager') {
		                $roleName = 'Manager';
	                } ?>
                    <div class="cf-panel">
                        <div class="cf-panel-h">
                            <div class="cf-panel-h-title"><?php echo $userData->data->display_name; ?></div>
                            <a href="<?php echo get_the_permalink(161) . '?id=' . $userId; ?>" class="cf-panel-h-icon"><i class="far fa-edit"></i></a>
                        </div>

                        <div class="cf-panel-b">
                            <div id="cf-form-user-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="_cf_user_first_name">User type</label>
                                            <input type="text" class="form-control" id="_cf_user_first_name" value="<?php echo $roleName; ?>" readonly>
                                        </div>
                                    </div>
                                </div>

		                        <?php if($userRole == 'candidate') { ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_first_name">First name</label>
                                                        <input type="text" class="form-control" id="_cf_user_first_name" value="<?php echo $userData->first_name; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_last_name">Last name</label>
                                                        <input type="text" class="form-control" id="_cf_user_last_name" value="<?php echo $userData->last_name; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="_cf_user_address">Address</label>
                                                        <input type="text" class="form-control" id="_cf_user_address" value="<?php echo get_user_meta($userId, '_cf_user_address', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="_cf_user_N">No. + ext.</label>
                                                        <input type="text" class="form-control" id="_cf_user_N" value="<?php echo get_user_meta($userId, '_cf_user_N', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_sector">Sector</label>
                                                        <input type="text" class="form-control" id="_cf_user_sector" value="<?php echo get_user_meta($userId, '_cf_user_sector', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_email">Email</label>
                                                        <input type="email" class="form-control" id="_cf_user_email" value="<?php echo $userData->user_email; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_middle_name">Middle name</label>
                                                        <input type="text" class="form-control" id="_cf_user_middle_name" value="<?php echo get_user_meta($userId, '_cf_user_middle_name', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
	                                                <?php $canGenderNo = get_user_meta($userId, '_cf_user_gender', true);
	                                                $canGender = '';
	                                                if($canGenderNo == 1) {
		                                                $canGender = 'Male';
                                                    } elseif($canGenderNo == 2) {
		                                                $canGender = 'Female';
                                                    }
	                                                ?>
                                                    <div class="form-group">
                                                        <label for="_cf_user_gender">Gender</label>
                                                        <input type="text" class="form-control" id="_cf_user_gender" value="<?php echo $canGender; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="_cf_user_zipcode">Zip code</label>
                                                        <input type="text" class="form-control" id="_cf_user_zipcode" value="<?php echo get_user_meta($userId, '_cf_user_zipcode', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="_cf_user_city">City</label>
                                                        <input type="text" class="form-control" id="_cf_user_city" value="<?php echo get_user_meta($userId, '_cf_user_city', true); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12"><hr></div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="_cf_user_primspecialism">Primair Specialism</label>
                                                        <input type="text" class="form-control" id="_cf_user_primspecialism" value="<?php echo get_user_meta($userId, '_cf_user_primspecialism', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="_cf_user_secspecialism">Secundair Specialism</label>
                                                        <input type="text" class="form-control" id="_cf_user_secspecialism" value="<?php echo get_user_meta($userId, '_cf_user_secspecialism', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
	                                                <?php $canExpNo = get_user_meta($userId, '_cf_user_experience', true); ?>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label for="_cf_user_experience">Experience</label>
                                                            <input type="text" class="form-control" id="_cf_user_experience" value="<?php echo $canExpNo; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <?php $canExpNo = get_user_meta($userId, '_cf_user_secexperience', true); ?>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label for="_cf_user_experience">Experience</label>
                                                            <input type="text" class="form-control" id="_cf_user_experience" value="<?php echo $canExpNo; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-6">
	                                                <?php $canJobNo = get_user_meta($userId, '_cf_user_jobtitle', true);
	                                                $canJob = '';
	                                                if($canJobNo == 1) {
		                                                $canJob = 'Job Title 1';
	                                                } elseif($canJobNo == 2) {
		                                                $canJob = 'Job Title 2';
	                                                } elseif($canJobNo == 3) {
		                                                $canJob = 'Job Title 3';
	                                                } elseif($canJobNo == 4) {
		                                                $canJob = 'Job Title 4';
	                                                }
	                                                ?>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label for="_cf_user_jobtitle">Job title</label>
                                                            <input type="text" class="form-control" id="_cf_user_jobtitle" value="<?php echo $canJob; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
		                                            <?php $canJobLocNo = get_user_meta($userId, '_cf_user_joblocation', true); ?>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label for="_cf_user_joblocation">Job location</label>
                                                            <input type="text" class="form-control" id="_cf_user_joblocation" value="<?php echo get_the_title($canJobLocNo); ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
		                                            <?php $canExpCurrNo = get_user_meta($userId, '_cf_user_curr_experience', true); ?>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label for="_cf_user_curr_experience">Experience</label>
                                                            <input type="text" class="form-control" id="_cf_user_curr_experience" value="<?php echo $canExpCurrNo; ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="_cf_user_hourly_rate">Hourly Rate</label>
                                                        <input type="number" class="form-control" id="_cf_user_hourly_rate" value="<?php echo get_user_meta($userId, '_cf_user_hourly_rate', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="_cf_user_hourly_rate_c">Hourly Rate for Client</label>
                                                        <input type="number" class="form-control" id="_cf_user_hourly_rate_c" value="<?php echo get_user_meta($userId, '_cf_user_hourly_rate_c', true); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: right">
	                                        <?php $canArchived = get_user_meta($userId, '_cf_user_archive', true); ?>
                                            <div class="form-group form-check mr-3" style="display: inline-block">
                                                <input type="checkbox" class="form-check-input" id="_cf_user_archive" <?php checked($canArchived, 'archived'); ?> value="archived" onclick="return false;">
                                                <label class="form-check-label" for="_cf_user_archive">Archived</label>
                                            </div>
                                        </div>
                                    </div>
		                        <?php } elseif ($userRole == 'project-manager') { ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_first_name">First name</label>
                                                        <input type="text" class="form-control" id="_cf_user_first_name" value="<?php echo $userData->first_name; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_last_name">Last name</label>
                                                        <input type="text" class="form-control" id="_cf_user_last_name" value="<?php echo $userData->last_name; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="_cf_user_address">Address</label>
                                                        <input type="text" class="form-control" id="_cf_user_address" value="<?php echo get_user_meta($userId, '_cf_user_address', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="_cf_user_N">No. + ext.</label>
                                                        <input type="text" class="form-control" id="_cf_user_N" value="<?php echo get_user_meta($userId, '_cf_user_N', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_sector">Sector</label>
                                                        <input type="text" class="form-control" id="_cf_user_sector" value="<?php echo get_user_meta($userId, '_cf_user_sector', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_email">Email</label>
                                                        <input type="email" class="form-control" id="_cf_user_email" value="<?php echo $userData->user_email; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_middle_name">Middle name</label>
                                                        <input type="text" class="form-control" id="_cf_user_middle_name" value="<?php echo get_user_meta($userId, '_cf_user_middle_name', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
		                                            <?php $canGenderNo = get_user_meta($userId, '_cf_user_gender', true);
		                                            $canGender = '';
		                                            if($canGenderNo == 1) {
			                                            $canGender = 'Male';
		                                            } elseif($canGenderNo == 2) {
			                                            $canGender = 'Female';
		                                            }
		                                            ?>
                                                    <div class="form-group">
                                                        <label for="_cf_user_gender">Gender</label>
                                                        <input type="text" class="form-control" id="_cf_user_gender" value="<?php echo $canGender; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="_cf_user_zipcode">Zip code</label>
                                                        <input type="text" class="form-control" id="_cf_user_zipcode" value="<?php echo get_user_meta($userId, '_cf_user_zipcode', true); ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="_cf_user_city">City</label>
                                                        <input type="text" class="form-control" id="_cf_user_city" value="<?php echo get_user_meta($userId, '_cf_user_city', true); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: right">
                                            <?php $canArchived = get_user_meta($userId, '_cf_user_archive', true); ?>
                                            <div class="form-group form-check mr-3" style="display: inline-block">
                                                <input type="checkbox" class="form-check-input" id="_cf_user_archive" <?php checked($canArchived, 'archived'); ?> value="archived" onclick="return false;">
                                                <label class="form-check-label" for="_cf_user_archive">Archived</label>
                                            </div>
                                        </div>
                                    </div>
		                        <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
			</div>

			<div class="col-md-12 col-lg-4">
				<?php get_template_part( 'components/component', 'reviews-total' ); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
