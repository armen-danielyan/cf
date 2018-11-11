<?php
/**
 * Template Name: Edit User
 */
?>
<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

<main id="dashboard">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="p-4">
                    <div class="cf-page-title">Users</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-8">

                <div class="cf-panel">
                    <div class="cf-panel-h">
                        <div class="cf-panel-h-title">EDIT USER</div>
                    </div>

                    <div class="cf-panel-b">
						<?php if(isset($_GET['id']) && $_GET['id']):
							$userId = $_GET['id'];
							$userData = get_userdata( $userId );
							$userRole = $userData->roles[0];

                            if($userRole == 'project-manager') {
                                $_cf_user_first_name = (isset($_POST['_cf_user_first_name']) && $_POST['_cf_user_first_name']) ? sanitize_text_field($_POST['_cf_user_first_name']) : '';
                                $_cf_user_last_name = (isset($_POST['_cf_user_last_name']) && $_POST['_cf_user_last_name']) ? sanitize_text_field($_POST['_cf_user_last_name']) : '';
                                $_cf_user_company_name = (isset($_POST['_cf_user_company_name']) && $_POST['_cf_user_company_name']) ? sanitize_text_field($_POST['_cf_user_company_name']) : '';
                                $_cf_user_address = (isset($_POST['_cf_user_address']) && $_POST['_cf_user_address']) ? sanitize_text_field($_POST['_cf_user_address']) : '';
                                $_cf_user_sector = (isset($_POST['_cf_user_sector']) && $_POST['_cf_user_sector']) ? sanitize_text_field($_POST['_cf_user_sector']) : '';
                                $_cf_user_zipcode = (isset($_POST['_cf_user_zipcode']) && $_POST['_cf_user_zipcode']) ? sanitize_text_field($_POST['_cf_user_zipcode']) : '';
                                $_cf_user_city = (isset($_POST['_cf_user_city']) && $_POST['_cf_user_city']) ? sanitize_text_field($_POST['_cf_user_city']) : '';
                                $_cf_user_project_name = (isset($_POST['_cf_user_project_name']) && $_POST['_cf_user_project_name']) ? sanitize_text_field($_POST['_cf_user_project_name']) : '';

                                $_cf_user_gender = (isset($_POST['_cf_user_gender']) && $_POST['_cf_user_gender']) ? sanitize_text_field($_POST['_cf_user_gender']) : '';
                                $_cf_user_N = (isset($_POST['_cf_user_N']) && $_POST['_cf_user_N']) ? sanitize_text_field($_POST['_cf_user_N']) : '';
                                $_cf_user_middle_name = (isset($_POST['_cf_user_middle_name']) && $_POST['_cf_user_middle_name']) ? sanitize_text_field($_POST['_cf_user_middle_name']) : '';

                                if($_cf_user_first_name && $_cf_user_last_name && $_cf_user_company_name &&
                                    $_cf_user_address && $_cf_user_sector &&
                                    $_cf_user_zipcode && $_cf_user_city && $_cf_user_project_name) {

                                    $displayName = $_cf_user_middle_name
                                        ? $_cf_user_first_name . ' ' . $_cf_user_middle_name . ' ' . $_cf_user_last_name
                                        : $displayName = $_cf_user_first_name . ' ' . $_cf_user_last_name;

	                                wp_update_user(array(
									    'ID' => (int) $userId,
    									'display_name' => $displayName,
    									'first_name' => $_cf_user_first_name,
    									'last_name' => $_cf_user_last_name,
    								));

                                    if($userId) {
                                        update_user_meta( $userId, '_cf_user_middle_name', $_cf_user_middle_name );
                                        update_user_meta( $userId, '_cf_user_gender', $_cf_user_gender );
                                        update_user_meta( $userId, '_cf_user_address', $_cf_user_address );
                                        update_user_meta( $userId, '_cf_user_N', $_cf_user_N );
                                        update_user_meta( $userId, '_cf_user_zipcode', $_cf_user_zipcode );
                                        update_user_meta( $userId, '_cf_user_city', $_cf_user_city );
                                        update_user_meta( $userId, '_cf_user_sector', $_cf_user_sector );
                                        update_user_meta( $userId, '_cf_user_company_name', $_cf_user_company_name );
                                        update_user_meta( $userId, '_cf_user_project_name', $_cf_user_project_name );
                                        update_user_meta( $userId, '_cf_user_archive', $_POST['_cf_user_archive'] );
                                    }
                                }
                            } elseif($userRole == 'candidate') {
                                $_cf_user_first_name = (isset($_POST['_cf_user_first_name']) && $_POST['_cf_user_first_name']) ? sanitize_text_field($_POST['_cf_user_first_name']) : '';
                                $_cf_user_last_name = (isset($_POST['_cf_user_last_name']) && $_POST['_cf_user_last_name']) ? sanitize_text_field($_POST['_cf_user_last_name']) : '';
                                $_cf_user_address = (isset($_POST['_cf_user_address']) && $_POST['_cf_user_address']) ? sanitize_text_field($_POST['_cf_user_address']) : '';
                                $_cf_user_sector = (isset($_POST['_cf_user_sector']) && $_POST['_cf_user_sector']) ? sanitize_text_field($_POST['_cf_user_sector']) : '';
                                $_cf_user_zipcode = (isset($_POST['_cf_user_zipcode']) && $_POST['_cf_user_zipcode']) ? sanitize_text_field($_POST['_cf_user_zipcode']) : '';
                                $_cf_user_city = (isset($_POST['_cf_user_city']) && $_POST['_cf_user_city']) ? sanitize_text_field($_POST['_cf_user_city']) : '';
                                $_cf_user_primspecialism = (isset($_POST['_cf_user_primspecialism']) && $_POST['_cf_user_primspecialism']) ? sanitize_text_field($_POST['_cf_user_primspecialism']) : '';
                                $_cf_user_experience = (isset($_POST['_cf_user_experience']) && $_POST['_cf_user_experience']) ? sanitize_text_field($_POST['_cf_user_experience']) : '';
                                $_cf_user_secspecialism = (isset($_POST['_cf_user_secspecialism']) && $_POST['_cf_user_secspecialism']) ? sanitize_text_field($_POST['_cf_user_secspecialism']) : '';
                                $_cf_user_secexperience = (isset($_POST['_cf_user_secexperience']) && $_POST['_cf_user_secexperience']) ? sanitize_text_field($_POST['_cf_user_secexperience']) : '';
                                $_cf_user_jobtitle = (isset($_POST['_cf_user_jobtitle']) && $_POST['_cf_user_jobtitle']) ? sanitize_text_field($_POST['_cf_user_jobtitle']) : '';
                                $_cf_user_joblocation = (isset($_POST['_cf_user_joblocation']) && $_POST['_cf_user_joblocation']) ? sanitize_text_field($_POST['_cf_user_joblocation']) : '';
                                $_cf_user_curr_experience = (isset($_POST['_cf_user_curr_experience']) && $_POST['_cf_user_curr_experience']) ? sanitize_text_field($_POST['_cf_user_curr_experience']) : '';
                                $_cf_user_hourly_rate = (isset($_POST['_cf_user_hourly_rate']) && $_POST['_cf_user_hourly_rate']) ? sanitize_text_field($_POST['_cf_user_hourly_rate']) : '';
                                $_cf_user_hourly_rate_c = (isset($_POST['_cf_user_hourly_rate_c']) && $_POST['_cf_user_hourly_rate_c']) ? sanitize_text_field($_POST['_cf_user_hourly_rate_c']) : '';

                                $_cf_user_gender = (isset($_POST['_cf_user_gender']) && $_POST['_cf_user_gender']) ? sanitize_text_field($_POST['_cf_user_gender']) : '';
                                $_cf_user_N = (isset($_POST['_cf_user_N']) && $_POST['_cf_user_N']) ? sanitize_text_field($_POST['_cf_user_N']) : '';
                                $_cf_user_middle_name = (isset($_POST['_cf_user_middle_name']) && $_POST['_cf_user_middle_name']) ? sanitize_text_field($_POST['_cf_user_middle_name']) : '';
                                $_cf_user_archive = (isset($_POST['_cf_user_archive']) && $_POST['_cf_user_archive']) ? sanitize_text_field($_POST['_cf_user_archive']) : '';

                                if( $_cf_user_first_name &&  $_cf_user_last_name && $_cf_user_address &&
                                    $_cf_user_sector && $_cf_user_zipcode &&
                                    $_cf_user_city && $_cf_user_primspecialism && $_cf_user_secspecialism &&
                                    $_cf_user_experience && $_cf_user_secexperience && $_cf_user_jobtitle && $_cf_user_joblocation &&
                                    $_cf_user_curr_experience && $_cf_user_hourly_rate && $_cf_user_hourly_rate_c ) {

                                    $displayName = $_cf_user_middle_name
                                        ? $_cf_user_first_name . ' ' . $_cf_user_middle_name . ' ' . $_cf_user_last_name
                                        : $displayName = $_cf_user_first_name . ' ' . $_cf_user_last_name;

	                                wp_update_user(array(
		                                'ID' => (int) $userId,
		                                'display_name' => $displayName,
		                                'first_name' => $_cf_user_first_name,
		                                'last_name' => $_cf_user_last_name,
	                                ));

                                    if($userId) {
                                        update_user_meta( $userId, '_cf_user_middle_name', $_cf_user_middle_name );
                                        update_user_meta( $userId, '_cf_user_gender', $_cf_user_gender );
                                        update_user_meta( $userId, '_cf_user_address', $_cf_user_address );
                                        update_user_meta( $userId, '_cf_user_N', $_cf_user_N );
                                        update_user_meta( $userId, '_cf_user_zipcode', $_cf_user_zipcode );
                                        update_user_meta( $userId, '_cf_user_city', $_cf_user_city );
                                        update_user_meta( $userId, '_cf_user_sector', $_cf_user_sector );
                                        update_user_meta( $userId, '_cf_user_primspecialism', $_cf_user_primspecialism );
                                        update_user_meta( $userId, '_cf_user_secspecialism', $_cf_user_secspecialism );
                                        update_user_meta( $userId, '_cf_user_experience', $_cf_user_experience );
                                        update_user_meta( $userId, '_cf_user_secexperience', $_cf_user_secexperience );
                                        update_user_meta( $userId, '_cf_user_jobtitle', $_cf_user_jobtitle );
                                        update_user_meta( $userId, '_cf_user_joblocation', $_cf_user_joblocation );
                                        update_user_meta( $userId, '_cf_user_curr_experience', $_cf_user_curr_experience );
                                        update_user_meta( $userId, '_cf_user_hourly_rate', $_cf_user_hourly_rate );
                                        update_user_meta( $userId, '_cf_user_hourly_rate_c', $_cf_user_hourly_rate_c );
                                        update_user_meta( $userId, '_cf_user_archive', $_cf_user_archive );
                                    }
                                }
                            } ?>

                            <form method="post" id="cf-form-user-info">
                                <div class="row">
                                    <div class="col-md-6">

                                        <?php if($userRole == 'candidate') {
                                                $roleName = 'Candidate';
                                                $roleClassName = 'cf-role-option-c';
                                            } elseif($userRole == 'project-manager') {
                                                $roleName = 'Manager';
                                                $roleClassName = 'cf-role-option-m';
                                            } ?>
                                        <div class="form-group">
                                            <label for="_cf_user_role">User type</label>
                                            <input type="text" class="form-control <?php echo $roleClassName; ?>" id="_cf_user_role" value="<?php echo $roleName; ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <?php if($userRole == 'candidate') { ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_first_name">First name*</label>
                                                        <input type="text" class="form-control" name="_cf_user_first_name" id="_cf_user_first_name" value="<?php echo $userData->first_name; ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_last_name">Last name*</label>
                                                        <input type="text" class="form-control" name="_cf_user_last_name" id="_cf_user_last_name" value="<?php echo $userData->last_name; ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="_cf_user_address">Address*</label>
                                                        <input type="text" class="form-control" name="_cf_user_address" id="_cf_user_address" value="<?php echo get_user_meta($userId, '_cf_user_address', true); ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="_cf_user_N">No. + ext.</label>
                                                        <input type="text" class="form-control" name="_cf_user_N" id="_cf_user_N" value="<?php echo get_user_meta($userId, '_cf_user_N', true); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
	                                                    <?php $cfSector = get_user_meta($userId, '_cf_user_sector', true);
	                                                    $sectors = getCustomItems('sectors'); ?>
                                                        <label for="_cf_user_sector">Sector*</label>
                                                        <select id="_cf_user_sector" name="_cf_user_sector" class="form-control" required>
	                                                        <?php foreach($sectors as $s) { ?>
                                                                <option value="<?php echo $s; ?>" <?php selected( $cfSector, $s ); ?>><?php echo $s; ?></option>
	                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_middle_name">Middle name</label>
                                                        <input type="text" class="form-control" name="_cf_user_middle_name" id="_cf_user_middle_name" value="<?php echo get_user_meta($userId, '_cf_user_middle_name', true); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <?php $canGenderNo = get_user_meta($userId, '_cf_user_gender', true); ?>
                                                        <label for="_cf_user_gender">Gender</label>
                                                        <select id="_cf_user_gender" name="_cf_user_gender" class="form-control">
                                                            <option value="1" <?php selected($canGenderNo, '1'); ?>>Male</option>
                                                            <option value="2" <?php selected($canGenderNo, '2'); ?>>Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="_cf_user_zipcode">Zip code*</label>
                                                        <input type="text" class="form-control" name="_cf_user_zipcode" id="_cf_user_zipcode" value="<?php echo get_user_meta($userId, '_cf_user_zipcode', true); ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="_cf_user_city">City*</label>
                                                        <input type="text" class="form-control" name="_cf_user_city" id="_cf_user_city" value="<?php echo get_user_meta($userId, '_cf_user_city', true); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12"><hr></div>

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
	                                                    <?php $primSpec = get_user_meta($userId, '_cf_user_primspecialism', true);
	                                                    $specialisms = getCustomItems('specialisms'); ?>
                                                        <label for="_cf_user_primspecialism">Primair Specialism*</label>
                                                        <select id="_cf_user_primspecialism" name="_cf_user_primspecialism" class="form-control" required>
	                                                        <?php foreach($specialisms as $s) { ?>
                                                                <option value="<?php echo $s; ?>" <?php selected( $primSpec, $s ); ?>><?php echo $s; ?></option>
	                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
	                                                    <?php $secSpec = get_user_meta($userId, '_cf_user_secspecialism', true);
	                                                    $specialisms = getCustomItems('specialisms'); ?>
                                                        <label for="_cf_user_secspecialism">Secundair Specialism*</label>
                                                        <select id="_cf_user_secspecialism" name="_cf_user_secspecialism" class="form-control" required>
	                                                        <?php foreach($specialisms as $s) { ?>
                                                                <option value="<?php echo $s; ?>" <?php selected( $secSpec, $s ); ?>><?php echo $s; ?></option>
	                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php $canExpNo = get_user_meta($userId, '_cf_user_experience', true);
                                                        $experiences = getCustomItems('experiences'); ?>
                                                        <label for="_cf_user_experience">Experience*</label>
                                                        <select id="_cf_user_experience" name="_cf_user_experience" class="form-control" required>
	                                                        <?php foreach($experiences as $s) { ?>
                                                                <option value="<?php echo $s; ?>" <?php selected( $canExpNo, $s ); ?>><?php echo $s; ?></option>
	                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php $canExpNo = get_user_meta($userId, '_cf_user_secexperience', true);
                                                        $experiences = getCustomItems('experiences'); ?>
                                                        <label for="_cf_user_secexperience">Experience*</label>
                                                        <select id="_cf_user_secexperience" name="_cf_user_secexperience" class="form-control" required>
                                                            <?php foreach($experiences as $s) { ?>
                                                                <option value="<?php echo $s; ?>" <?php selected( $canExpNo, $s ); ?>><?php echo $s; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php $canJobNo = get_user_meta($userId, '_cf_user_jobtitle', true);
                                                        $jobTitles = getCustomItems('jobtitles'); ?>
                                                        <label for="_cf_user_jobtitle">Job Title*</label>
                                                        <select id="_cf_user_jobtitle" name="_cf_user_jobtitle" class="form-control" required>
	                                                        <?php foreach($jobTitles as $s) { ?>
                                                                <option value="<?php echo $s; ?>" <?php selected( $canJobNo, $s ); ?>><?php echo $s; ?></option>
	                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php $canJobLocNo = get_user_meta($userId, '_cf_user_joblocation', true);
                                                        $projects = getConsultantProjects(); ?>
                                                        <label for="_cf_user_joblocation">Job location*</label>
                                                        <select id="_cf_user_joblocation" name="_cf_user_joblocation" class="form-control" required>
                                                            <?php foreach($projects as $key => $value): ?>
                                                                <option value="<?php echo $key; ?>" <?php selected($canJobLocNo, $key); ?>><?php echo $value; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php $canExpCurrNo = get_user_meta($userId, '_cf_user_curr_experience', true);
                                                        $experiences = getCustomItems('experiences'); ?>
                                                        <label for="_cf_user_curr_experience">Experience*</label>
                                                        <select id="_cf_user_curr_experience" name="_cf_user_curr_experience" class="form-control" required>
	                                                        <?php foreach($experiences as $s) { ?>
                                                                <option value="<?php echo $s; ?>" <?php selected( $canExpCurrNo, $s ); ?>><?php echo $s; ?></option>
	                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="_cf_user_hourly_rate">Hourly Rate*</label>
                                                        <input type="number" class="form-control" name="_cf_user_hourly_rate" id="_cf_user_hourly_rate" value="<?php echo get_user_meta($userId, '_cf_user_hourly_rate', true); ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="_cf_user_hourly_rate_c">Hourly Rate for Client*</label>
                                                        <input type="number" class="form-control" name="_cf_user_hourly_rate_c" id="_cf_user_hourly_rate_c" value="<?php echo get_user_meta($userId, '_cf_user_hourly_rate_c', true); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12"><span class="cf-required">*</span> required</div>

                                        <div class="col-md-12" style="text-align: right">
	                                        <?php $canArchived = get_user_meta($userId, '_cf_user_archive', true); ?>
                                            <div class="form-group form-check mr-3" style="display: inline-block">
                                                <input type="checkbox" class="form-check-input" name="_cf_user_archive" id="_cf_user_archive" <?php checked($canArchived, 'archived'); ?> value="archived">
                                                <label class="form-check-label" for="_cf_user_archive">Archive this candidate</label>
                                            </div>

                                            <button type="submit" class="cf-blue-btn">SAVE USER</button>
                                        </div>
                                    </div>
                                <?php } elseif ($userRole == 'project-manager') { ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_first_name">First name*</label>
                                                        <input type="text" class="form-control" name="_cf_user_first_name" id="_cf_user_first_name" value="<?php echo $userData->first_name; ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_last_name">Last name*</label>
                                                        <input type="text" class="form-control" name="_cf_user_last_name" id="_cf_user_last_name" value="<?php echo $userData->last_name; ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_company_name">Company name*</label>
                                                        <input type="text" class="form-control" name="_cf_user_company_name" id="_cf_user_company_name" value="<?php echo get_user_meta($userId, '_cf_user_company_name', true); ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="_cf_user_address">Address*</label>
                                                        <input type="text" class="form-control" name="_cf_user_address" id="_cf_user_address" value="<?php echo get_user_meta($userId, '_cf_user_address', true); ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="_cf_user_N">No. + ext.</label>
                                                        <input type="text" class="form-control" name="_cf_user_N" id="_cf_user_N" value="<?php echo get_user_meta($userId, '_cf_user_N', true); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
	                                                    <?php $cfSector = get_user_meta($userId, '_cf_user_sector', true);
	                                                    $sectors = getCustomItems('sectors'); ?>
                                                        <label for="_cf_user_sector">Sector*</label>
                                                        <select id="_cf_user_sector" name="_cf_user_sector" class="form-control" required>
		                                                    <?php foreach($sectors as $s) { ?>
                                                                <option value="<?php echo $s; ?>" <?php selected( $cfSector, $s ); ?>><?php echo $s; ?></option>
		                                                    <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="_cf_user_middle_name">Middle name</label>
                                                        <input type="text" class="form-control" name="_cf_user_middle_name" id="_cf_user_middle_name" value="<?php echo get_user_meta($userId, '_cf_user_middle_name', true); ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
	                                                    <?php $canGenderNo = get_user_meta($userId, '_cf_user_gender', true); ?>
                                                        <label for="_cf_user_gender">Gender</label>
                                                        <select id="_cf_user_gender" name="_cf_user_gender" class="form-control">
                                                            <option value="1" <?php selected($canGenderNo, '1'); ?>>Male</option>
                                                            <option value="2" <?php selected($canGenderNo, '2'); ?>>Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="_cf_user_zipcode">Zip code*</label>
                                                        <input type="text" class="form-control" name="_cf_user_zipcode" id="_cf_user_zipcode" value="<?php echo get_user_meta($userId, '_cf_user_zipcode', true); ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="_cf_user_city">City*</label>
                                                        <input type="text" class="form-control" name="_cf_user_city" id="_cf_user_city" value="<?php echo get_user_meta($userId, '_cf_user_city', true); ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
	                                                    <?php $projectName = get_user_meta($userId, '_cf_user_project_name', true); ?>
                                                        <label for="_cf_user_project_name">Project Name*</label>
                                                        <select id="_cf_user_project_name" name="_cf_user_project_name" class="form-control" required>
                                                            <?php $projectArgs = array(
                                                                'post_type' => 'projects',
                                                                'posts_per_page' => -1,
                                                            );
                                                            $projects = new WP_Query($projectArgs);
                                                            if($projects->have_posts()): while($projects->have_posts()): $projects->the_post(); ?>
                                                                <option value="<?php echo get_the_ID(); ?>" <?php selected($projectName, get_the_ID()); ?>><?php the_title(); ?></option>
                                                            <?php endwhile; endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12"><span class="cf-required">*</span> required</div>

                                        <div class="col-md-12" style="text-align: right">
                                            <?php $canArchived = get_user_meta($userId, '_cf_user_archive', true); ?>
                                            <div class="form-group form-check mr-3" style="display: inline-block">
                                                <input type="checkbox" class="form-check-input" name="_cf_user_archive" id="_cf_user_archive" <?php checked($canArchived, 'archived'); ?> value="archived">
                                                <label class="form-check-label" for="_cf_user_archive">Archive this candidate</label>
                                            </div>

                                            <button type="submit" class="cf-blue-btn">SAVE USER</button>
                                        </div>
                                    </div>
                                <?php } ?>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-4">
				<?php get_template_part( 'components/component', 'reviews-total' ); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
