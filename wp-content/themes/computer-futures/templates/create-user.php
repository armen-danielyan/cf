<?php
/**
 * Template Name: Create User
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
                        <a style="float:right" class="cf-white-btn" href="<?php echo get_the_permalink( 23 ); ?>">BACK</a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-lg-8">

					<div class="cf-panel">
						<div class="cf-panel-h">
							<div class="cf-panel-h-title">CREATE NEW USER</div>
						</div>

						<div class="cf-panel-b">
							<?php $submittedRole = (isset($_POST['_cf_user_role']) && $_POST['_cf_user_role']) ? sanitize_text_field($_POST['_cf_user_role']) : '';
							$statusSubmitted = false;
							$statusError = false;

                            if($submittedRole == 'project-manager') {
                                $statusSubmitted = true;

                                $_cf_user_first_name = (isset($_POST['_cf_user_first_name']) && $_POST['_cf_user_first_name']) ? sanitize_text_field($_POST['_cf_user_first_name']) : '';
                                $_cf_user_last_name = (isset($_POST['_cf_user_last_name']) && $_POST['_cf_user_last_name']) ? sanitize_text_field($_POST['_cf_user_last_name']) : '';
                                $_cf_user_company_name = (isset($_POST['_cf_user_company_name']) && $_POST['_cf_user_company_name']) ? sanitize_text_field($_POST['_cf_user_company_name']) : '';
                                $_cf_user_address = (isset($_POST['_cf_user_address']) && $_POST['_cf_user_address']) ? sanitize_text_field($_POST['_cf_user_address']) : '';
                                $_cf_user_sector = (isset($_POST['_cf_user_sector']) && $_POST['_cf_user_sector']) ? sanitize_text_field($_POST['_cf_user_sector']) : '';
                                $_cf_user_email = (isset($_POST['_cf_user_email']) && $_POST['_cf_user_email'] && is_email($_POST['_cf_user_email'])) ? sanitize_text_field($_POST['_cf_user_email']) : '';
                                $_cf_user_zipcode = (isset($_POST['_cf_user_zipcode']) && $_POST['_cf_user_zipcode']) ? sanitize_text_field($_POST['_cf_user_zipcode']) : '';
                                $_cf_user_city = (isset($_POST['_cf_user_city']) && $_POST['_cf_user_city']) ? sanitize_text_field($_POST['_cf_user_city']) : '';
                                $_cf_user_project_name = (isset($_POST['_cf_user_project_name']) && $_POST['_cf_user_project_name']) ? sanitize_text_field($_POST['_cf_user_project_name']) : '';

                                $_cf_user_gender = (isset($_POST['_cf_user_gender']) && $_POST['_cf_user_gender']) ? sanitize_text_field($_POST['_cf_user_gender']) : '';
                                $_cf_user_N = (isset($_POST['_cf_user_N']) && $_POST['_cf_user_N']) ? sanitize_text_field($_POST['_cf_user_N']) : '';
                                $_cf_user_middle_name = (isset($_POST['_cf_user_middle_name']) && $_POST['_cf_user_middle_name']) ? sanitize_text_field($_POST['_cf_user_middle_name']) : '';


                                if( $_cf_user_first_name && $_cf_user_last_name && $_cf_user_company_name &&
                                    $_cf_user_address && $_cf_user_sector && $_cf_user_email &&
                                    $_cf_user_zipcode && $_cf_user_city && $_cf_user_project_name ) {

                                    $displayName = $_cf_user_middle_name
                                        ? $_cf_user_first_name . ' ' . $_cf_user_middle_name . ' ' . $_cf_user_last_name
                                        : $displayName = $_cf_user_first_name . ' ' . $_cf_user_last_name;

                                    if(username_exists( $_cf_user_email ) || email_exists( $_cf_user_email )) {
                                        $statusError = true; ?>
                                        <div class="alert alert-danger" role="alert">
                                            Email is already exists.
                                        </div>
                                    <?php } else {
                                        $userId = wp_insert_user(array(
                                            'user_login' => $_cf_user_email,
                                            'user_email' => $_cf_user_email,
                                            'display_name' => $displayName,
                                            'user_pass' => wp_generate_password(6, true),
                                            'role' => 'project-manager',
                                            'first_name' => $_cf_user_first_name,
                                            'last_name' => $_cf_user_last_name,
                                        ));

                                        if(!is_wp_error($userId)) {
                                            update_user_meta( $userId, '_cf_user_middle_name', $_cf_user_middle_name );
                                            update_user_meta( $userId, '_cf_user_gender', $_cf_user_gender );
                                            update_user_meta( $userId, '_cf_user_address', $_cf_user_address );
                                            update_user_meta( $userId, '_cf_user_N', $_cf_user_N );
                                            update_user_meta( $userId, '_cf_user_zipcode', $_cf_user_zipcode );
                                            update_user_meta( $userId, '_cf_user_city', $_cf_user_city );
                                            update_user_meta( $userId, '_cf_user_sector', $_cf_user_sector );
                                            update_user_meta( $userId, '_cf_user_company_name', $_cf_user_company_name );
                                            update_user_meta( $userId, '_cf_user_consultant', get_current_user_id() );

                                            $projectId = $_cf_user_project_name;
                                            $usersIds = unserialize(get_post_meta($projectId, '_cf_project_users', true));
                                            $usersIds[] = $userId;
                                            update_post_meta($projectId, '_cf_project_users' , serialize($usersIds)); ?>

                                            <div class="alert alert-success" role="alert">
                                                Great! New user has been created.
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $userId->get_error_message(); ?>
                                            </div>
                                        <?php }
                                    }
	                            } else {
                                    $statusError = true; ?>
                                    <div class="alert alert-danger" role="alert">
                                        Please fill in all the required fields.
                                    </div>
	                            <?php }
                            } elseif($submittedRole == 'candidate') {
                                $statusSubmitted = true;

                                $_cf_user_first_name = (isset($_POST['_cf_user_first_name']) && $_POST['_cf_user_first_name']) ? sanitize_text_field($_POST['_cf_user_first_name']) : '';
                                $_cf_user_last_name = (isset($_POST['_cf_user_last_name']) && $_POST['_cf_user_last_name']) ? sanitize_text_field($_POST['_cf_user_last_name']) : '';
                                $_cf_user_address = (isset($_POST['_cf_user_address']) && $_POST['_cf_user_address']) ? sanitize_text_field($_POST['_cf_user_address']) : '';
                                $_cf_user_sector = (isset($_POST['_cf_user_sector']) && $_POST['_cf_user_sector']) ? sanitize_text_field($_POST['_cf_user_sector']) : '';
                                $_cf_user_email = (isset($_POST['_cf_user_email']) && $_POST['_cf_user_email'] && is_email($_POST['_cf_user_email'])) ? sanitize_text_field($_POST['_cf_user_email']) : '';
                                $_cf_user_zipcode = (isset($_POST['_cf_user_zipcode']) && $_POST['_cf_user_zipcode']) ? sanitize_text_field($_POST['_cf_user_zipcode']) : '';
                                $_cf_user_city = (isset($_POST['_cf_user_city']) && $_POST['_cf_user_city']) ? sanitize_text_field($_POST['_cf_user_city']) : '';
                                $_cf_user_primspecialism = (isset($_POST['_cf_user_primspecialism']) && $_POST['_cf_user_primspecialism']) ? sanitize_text_field($_POST['_cf_user_primspecialism']) : '';
                                $_cf_user_secspecialism = (isset($_POST['_cf_user_secspecialism']) && $_POST['_cf_user_secspecialism']) ? sanitize_text_field($_POST['_cf_user_secspecialism']) : '';
                                $_cf_user_experience = (isset($_POST['_cf_user_experience']) && $_POST['_cf_user_experience']) ? sanitize_text_field($_POST['_cf_user_experience']) : '';
                                $_cf_user_jobtitle = (isset($_POST['_cf_user_jobtitle']) && $_POST['_cf_user_jobtitle']) ? sanitize_text_field($_POST['_cf_user_jobtitle']) : '';
                                $_cf_user_joblocation = (isset($_POST['_cf_user_joblocation']) && $_POST['_cf_user_joblocation']) ? sanitize_text_field($_POST['_cf_user_joblocation']) : '';
                                $_cf_user_curr_experience = (isset($_POST['_cf_user_curr_experience']) && $_POST['_cf_user_curr_experience']) ? sanitize_text_field($_POST['_cf_user_curr_experience']) : '';
                                $_cf_user_hourly_rate = (isset($_POST['_cf_user_hourly_rate']) && $_POST['_cf_user_hourly_rate']) ? sanitize_text_field($_POST['_cf_user_hourly_rate']) : '';
                                $_cf_user_hourly_rate_c = (isset($_POST['_cf_user_hourly_rate_c']) && $_POST['_cf_user_hourly_rate_c']) ? sanitize_text_field($_POST['_cf_user_hourly_rate_c']) : '';

                                $_cf_user_gender = (isset($_POST['_cf_user_gender']) && $_POST['_cf_user_gender']) ? sanitize_text_field($_POST['_cf_user_gender']) : '';
                                $_cf_user_N = (isset($_POST['_cf_user_N']) && $_POST['_cf_user_N']) ? sanitize_text_field($_POST['_cf_user_N']) : '';
                                $_cf_user_middle_name = (isset($_POST['_cf_user_middle_name']) && $_POST['_cf_user_middle_name']) ? sanitize_text_field($_POST['_cf_user_middle_name']) : '';
                                $_cf_user_archive = (isset($_POST['_cf_user_archive']) && $_POST['_cf_user_archive']) ? sanitize_text_field($_POST['_cf_user_archive']) : '';

                                if( $_cf_user_first_name && $_cf_user_last_name && $_cf_user_address &&
                                    $_cf_user_sector && $_cf_user_email && $_cf_user_zipcode &&
                                    $_cf_user_city && $_cf_user_primspecialism && $_cf_user_secspecialism &&
                                    $_cf_user_experience && $_cf_user_jobtitle && $_cf_user_joblocation &&
                                    $_cf_user_curr_experience && $_cf_user_hourly_rate && $_cf_user_hourly_rate_c ) {

                                    $displayName = $_cf_user_middle_name
                                        ? $_cf_user_first_name . ' ' . $_cf_user_middle_name . ' ' . $_cf_user_last_name
                                        : $displayName = $_cf_user_first_name . ' ' . $_cf_user_last_name;

                                    if(username_exists( $_cf_user_email ) || email_exists( $_cf_user_email )) {
                                        $statusError = true; ?>
                                        <div class="alert alert-danger" role="alert">
                                            Email is already exists.
                                        </div>
                                    <?php } else {

                                        $userId = wp_insert_user(array(
                                            'user_login' => $_cf_user_email,
                                            'user_email' => $_cf_user_email,
                                            'display_name' => $displayName,
                                            'user_pass' => wp_generate_password(6, true),
                                            'role' => 'candidate',
                                            'first_name' => $_cf_user_first_name,
                                            'last_name' => $_cf_user_last_name,
                                        ));

                                        if (!is_wp_error($userId)) {
                                            update_user_meta($userId, '_cf_user_middle_name', $_cf_user_middle_name);
                                            update_user_meta($userId, '_cf_user_gender', $_cf_user_gender);
                                            update_user_meta($userId, '_cf_user_address', $_cf_user_address);
                                            update_user_meta($userId, '_cf_user_N', $_cf_user_N);
                                            update_user_meta($userId, '_cf_user_zipcode', $_cf_user_zipcode);
                                            update_user_meta($userId, '_cf_user_city', $_cf_user_city);
                                            update_user_meta($userId, '_cf_user_sector', $_cf_user_sector);
                                            update_user_meta($userId, '_cf_user_primspecialism', $_cf_user_primspecialism);
                                            update_user_meta($userId, '_cf_user_secspecialism', $_cf_user_secspecialism);
                                            update_user_meta($userId, '_cf_user_experience', $_cf_user_experience);
                                            update_user_meta($userId, '_cf_user_jobtitle', $_cf_user_jobtitle);
                                            update_user_meta($userId, '_cf_user_joblocation', $_cf_user_joblocation);
                                            update_user_meta($userId, '_cf_user_curr_experience', $_cf_user_curr_experience);
                                            update_user_meta($userId, '_cf_user_hourly_rate', $_cf_user_hourly_rate);
                                            update_user_meta($userId, '_cf_user_hourly_rate_c', $_cf_user_hourly_rate_c);
                                            update_user_meta($userId, '_cf_user_archive', $_cf_user_archive);
                                            update_user_meta($userId, '_cf_user_consultant', get_current_user_id()); ?>

                                            <div class="alert alert-success" role="alert">
                                                Great! New user has been created.
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $userId->get_error_message(); ?>
                                            </div>
                                        <?php }
                                    }
	                            } else {
                                    $statusError = true; ?>
                                    <div class="alert alert-danger" role="alert">
			                            Please fill in all the required fields.
                                    </div>
	                            <?php }
                            } ?>

                            <?php if(!$statusSubmitted || ($statusSubmitted && $statusError)) : ?>

                                <form method="post" id="cf-form-user-info">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <?php $role = '';
                                            $roleClassName = '';
                                            if(isset($_GET['role']) && $_GET['role']) {
                                                if($_GET['role'] == 'candidate') {
                                                    $role = 'candidate';
                                                    $roleClassName = 'cf-role-option-c';
                                                } elseif($_GET['role'] == 'project-manager') {
                                                    $role = 'project-manager';
                                                    $roleClassName = 'cf-role-option-m';
                                                }
                                            } ?>
                                            <div class="form-group">
                                                <label for="_cf_user_role">Select user type</label>
                                                <select id="_cf_user_role" name="_cf_user_role" class="form-control <?php echo $roleClassName; ?>" required>
                                                    <option value=""></option>
                                                    <option value="candidate" <?php selected( $role, 'candidate' ); ?>>Candidate</option>
                                                    <option value="project-manager" <?php selected( $role, 'project-manager' ); ?>>Manager</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if($role == 'candidate') { ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_first_name">First name*</label>
                                                            <input type="text" class="form-control" name="_cf_user_first_name" id="_cf_user_first_name" value="<?php echo $_cf_user_first_name; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_last_name">Last name*</label>
                                                            <input type="text" class="form-control" name="_cf_user_last_name" id="_cf_user_last_name" value="<?php echo $_cf_user_last_name; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="_cf_user_address">Address*</label>
                                                            <input type="text" class="form-control" name="_cf_user_address" id="_cf_user_address" value="<?php echo $_cf_user_address; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="_cf_user_N">No. + ext.</label>
                                                            <input type="text" class="form-control" name="_cf_user_N" id="_cf_user_N" value="<?php echo $_cf_user_N; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_sector">Sector*</label>
                                                            <select id="_cf_user_sector" name="_cf_user_sector" class="form-control" required>
                                                                <option <?php selected($_cf_user_sector, ''); ?> disabled>Choose a Sector</option>
                                                                <?php $sectors = getCustomItems('sectors');
                                                                foreach($sectors as $s) { ?>
                                                                    <option value="<?php echo $s; ?>" <?php selected($_cf_user_sector, $s); ?>><?php echo $s; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_email">Email*</label>
                                                            <input type="email" class="form-control" name="_cf_user_email" id="_cf_user_email" value="<?php echo $_cf_user_email; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_middle_name">Middle name</label>
                                                            <input type="text" class="form-control" name="_cf_user_middle_name" id="_cf_user_middle_name" value="<?php echo $_cf_user_middle_name; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_gender">Gender</label>
                                                            <select id="_cf_user_gender" name="_cf_user_gender" class="form-control">
                                                                <option <?php selected($_cf_user_gender, ''); ?> disabled>Choose a Gender</option>
                                                                <option value="1" <?php selected($_cf_user_gender, 1); ?>>Male</option>
                                                                <option value="2" <?php selected($_cf_user_gender, 2); ?>>Female</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="_cf_user_zipcode">Zip code*</label>
                                                            <input type="text" class="form-control" name="_cf_user_zipcode" id="_cf_user_zipcode" value="<?php echo $_cf_user_zipcode; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="_cf_user_city">City*</label>
                                                            <input type="text" class="form-control" name="_cf_user_city" id="_cf_user_city" value="<?php echo $_cf_user_city; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12"><hr></div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="_cf_user_primspecialism">Primair Specialism*</label>
                                                            <select id="_cf_user_primspecialism" name="_cf_user_primspecialism" class="form-control" required>
                                                                <option <?php selected($_cf_user_primspecialism, ''); ?> disabled>Choose a Specialism</option>
                                                                <?php $specialisms = getCustomItems('specialisms');
                                                                foreach($specialisms as $s) { ?>
                                                                    <option value="<?php echo $s; ?>" <?php selected($_cf_user_primspecialism, $s); ?>><?php echo $s; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="_cf_user_secspecialism">Secundair Specialism*</label>
                                                            <select id="_cf_user_secspecialism" name="_cf_user_secspecialism" class="form-control" required>
                                                                <option <?php selected($_cf_user_secspecialism, ''); ?> disabled>Choose a Specialism</option>
                                                                <?php $specialisms = getCustomItems('specialisms');
                                                                foreach($specialisms as $s) { ?>
                                                                    <option value="<?php echo $s; ?>" <?php selected($_cf_user_secspecialism, $s); ?>><?php echo $s; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="_cf_user_experience">Experience*</label>
                                                            <select id="_cf_user_experience" name="_cf_user_experience" class="form-control" required>
                                                                <option <?php selected($_cf_user_experience, ''); ?> disabled>Choose an Experience</option>
                                                                <?php $experiences = getCustomItems('experiences');
                                                                foreach($experiences as $s) { ?>
                                                                    <option value="<?php echo $s; ?>" <?php selected($_cf_user_experience, $s); ?>><?php echo $s; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="_cf_user_jobtitle">Job Title*</label>
                                                            <select id="_cf_user_jobtitle" name="_cf_user_jobtitle" class="form-control" required>
                                                                <option <?php selected($_cf_user_jobtitle, ''); ?> disabled>Choose a Job Title</option>
                                                                <?php $jobTitles = getCustomItems('jobtitles');
                                                                foreach($jobTitles as $s) { ?>
                                                                    <option value="<?php echo $s; ?>" <?php selected($_cf_user_jobtitle, $s); ?>><?php echo $s; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="_cf_user_joblocation">Job location*</label>
                                                            <select id="_cf_user_joblocation" name="_cf_user_joblocation" class="form-control" required>
                                                                <option <?php selected($_cf_user_joblocation, ''); ?> disabled>Choose a Job Location</option>
                                                                <option value="1" <?php selected($_cf_user_joblocation, 1); ?>>Job Location 1</option>
                                                                <option value="2" <?php selected($_cf_user_joblocation, 2); ?>>Job Location 2</option>
                                                                <option value="3" <?php selected($_cf_user_joblocation, 3); ?>>Job Location 3</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="_cf_user_curr_experience">Experience*</label>
                                                            <select id="_cf_user_curr_experience" name="_cf_user_curr_experience" class="form-control" required>
                                                                <option <?php selected($_cf_user_curr_experience, ''); ?> disabled>Choose an Experience</option>
                                                                <?php $experiences = getCustomItems('experiences');
                                                                foreach($experiences as $s) { ?>
                                                                    <option value="<?php echo $s; ?>" <?php selected($_cf_user_curr_experience, $s); ?>><?php echo $s; ?></option>
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
                                                            <input type="number" class="form-control" name="_cf_user_hourly_rate" id="_cf_user_hourly_rate" value="<?php echo $_cf_user_hourly_rate; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="_cf_user_hourly_rate_c">Hourly Rate for Client*</label>
                                                            <input type="number" class="form-control" name="_cf_user_hourly_rate_c" id="_cf_user_hourly_rate_c" value="<?php echo $_cf_user_hourly_rate_c; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12"><span class="cf-required">*</span> required</div>

                                            <div class="col-md-12" style="text-align: right">
                                                <div class="form-group form-check mr-3" style="display: inline-block">
                                                    <input type="checkbox" class="form-check-input" name="_cf_user_archive" id="_cf_user_archive" value="archived">
                                                    <label class="form-check-label" for="_cf_user_archive">Archive this candidate</label>
                                                </div>

                                                <button type="submit" class="cf-blue-btn">SUBMIT USER</button>
                                            </div>
                                        </div>
                                    <?php } elseif ($role == 'project-manager') { ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_first_name">First name*</label>
                                                            <input type="text" class="form-control" name="_cf_user_first_name" id="_cf_user_first_name" value="<?php echo $_cf_user_first_name; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_last_name">Last name*</label>
                                                            <input type="text" class="form-control" name="_cf_user_last_name" id="_cf_user_last_name" value="<?php echo $_cf_user_last_name; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_company_name">Company name*</label>
                                                            <input type="text" class="form-control" name="_cf_user_company_name" id="_cf_user_company_name" value="<?php echo $_cf_user_company_name; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="_cf_user_address">Address*</label>
                                                            <input type="text" class="form-control" name="_cf_user_address" id="_cf_user_address" value="<?php echo $_cf_user_address; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="_cf_user_N">No. + ext.</label>
                                                            <input type="text" class="form-control" name="_cf_user_N" id="_cf_user_N" value="<?php echo $_cf_user_N; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_sector">Sector*</label>
                                                            <select id="_cf_user_sector" name="_cf_user_sector" class="form-control" required>
                                                                <option <?php selected($_cf_user_sector, ''); ?> disabled>Choose a Sector</option>
                                                                <?php $sectors = getCustomItems('sectors');
                                                                foreach($sectors as $s) { ?>
                                                                    <option value="<?php echo $s; ?>" <?php selected($_cf_user_sector, $s); ?>><?php echo $s; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_email">Email*</label>
                                                            <input type="email" class="form-control" name="_cf_user_email" id="_cf_user_email" value="<?php echo $_cf_user_email; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_middle_name">Middle name</label>
                                                            <input type="text" class="form-control" name="_cf_user_middle_name" id="_cf_user_middle_name" value="<?php echo $_cf_user_middle_name; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_gender">Gender</label>
                                                            <select id="_cf_user_gender" name="_cf_user_gender" class="form-control">
                                                                <option <?php selected($_cf_user_gender, ''); ?> disabled>Choose a Gender</option>
                                                                <option value="1" <?php selected($_cf_user_gender, 1); ?>>Male</option>
                                                                <option value="2" <?php selected($_cf_user_gender, 2); ?>>Female</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="_cf_user_zipcode">Zip code*</label>
                                                            <input type="text" class="form-control" name="_cf_user_zipcode" id="_cf_user_zipcode" value="<?php echo $_cf_user_zipcode; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="_cf_user_city">City*</label>
                                                            <input type="text" class="form-control" name="_cf_user_city" id="_cf_user_city" value="<?php echo $_cf_user_city; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="_cf_user_project_name">Project Name*</label>
                                                            <select id="_cf_user_project_name" name="_cf_user_project_name" class="form-control" required>
                                                                <option <?php selected($_cf_user_gender, ''); ?> disabled>Choose a Project Name</option>
                                                                <?php $projectArgs = array(
                                                                    'post_type' => 'projects',
                                                                    'posts_per_page' => -1,
                                                                    'meta_query' => array(
                                                                        array(
                                                                            'key' => '_cf_project_consultant',
                                                                            'value' => get_current_user_id()
                                                                        )
                                                                    )
                                                                );
                                                                $projects = new WP_Query($projectArgs);
                                                                if($projects->have_posts()): while($projects->have_posts()): $projects->the_post(); ?>
                                                                    <option value="<?php echo get_the_ID(); ?>" <?php selected($_cf_user_gender, get_the_ID()); ?>><?php the_title(); ?></option>
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
                                                <button type="submit" class="cf-blue-btn">SUBMIT USER</button>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </form>
                            <?php endif; ?>

						</div>
					</div>

				</div>

				<div class="col-md-12 col-lg-4">
					<?php get_template_part( 'components/component', 'your-total' ); ?>
				</div>
			</div>
		</div>
	</main>

    <script>
        jQuery(document).ready(function($) {
            var url = "<?php echo get_the_permalink(80); ?>";
            var param = '';
            $('#_cf_user_role').on('change', function() {
                if($(this).val() === 'candidate') {
                    param = 'role=candidate';
                } else if($(this).val() === 'project-manager') {
                    param = 'role=project-manager';
                }

                if(param) {
                    if (url.indexOf('?') > -1) {
                        url += '&' + param;
                    } else {
                        url += '?' + param;
                    }
                }

                window.location.href = url;
            })
        })
    </script>

<?php get_footer(); ?>