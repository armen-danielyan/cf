<?php
add_action( 'show_user_profile', 'addExtraUserProfileFields' );
add_action( 'edit_user_profile', 'addExtraUserProfileFields' );

function addExtraUserProfileFields( $user ) { ?>
	<h3>Extra profile information</h3>

	<table class="form-table">
        <tr>
            <th><label for="_cf_user_consultant">Consultant</label></th>
            <td>
	            <?php $consultantId = esc_attr( get_the_author_meta( '_cf_user_consultant', $user->ID ) );
	            $argsU = array(
		            'role' => 'consultant'
	            );
	            $userQuery = new WP_User_Query( $argsU ); ?>
                <select name="_cf_user_consultant" id="_cf_user_consultant" class="regular-text">
                    <option value=""></option>
	                <?php foreach ( $userQuery->get_results() as $userData ) { ?>
                        <option value="<?php echo $userData->ID; ?>" <?php selected( $consultantId, $userData->ID ); ?>><?php echo $userData->display_name; ?></option>
	                <?php } ?>
                </select><br/>
            </td>
        </tr>
		<tr>
			<th><label for="_cf_user_middle_name">Middle Name</label></th>
			<td>
				<input type="text" name="_cf_user_middle_name" id="_cf_user_middle_name"
				       value="<?php echo esc_attr( get_the_author_meta( '_cf_user_middle_name', $user->ID ) ); ?>"
				       class="regular-text"/><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_gender">Gender</label></th>
			<td>
				<?php $gender = esc_attr( get_the_author_meta( '_cf_user_gender', $user->ID ) ); ?>
				<select name="_cf_user_gender" id="_cf_user_gender" class="regular-text">
					<option value="0" <?php selected( $gender, 0 ); ?>></option>
					<option value="1" <?php selected( $gender, 1 ); ?>>Male</option>
					<option value="2" <?php selected( $gender, 2 ); ?>>Female</option>
				</select><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_address">Address</label></th>
			<td>
				<input type="text" name="_cf_user_address" id="_cf_user_address"
				       value="<?php echo esc_attr( get_the_author_meta( '_cf_user_address', $user->ID ) ); ?>"
				       class="regular-text"/><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_N">No. + ext.</label></th>
			<td>
				<input type="text" name="_cf_user_N" id="_cf_user_N"
				       value="<?php echo esc_attr( get_the_author_meta( '_cf_user_N', $user->ID ) ); ?>"
				       class="regular-text"/><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_zipcode">Zip Code</label></th>
			<td>
				<input type="text" name="_cf_user_zipcode" id="_cf_user_zipcode"
				       value="<?php echo esc_attr( get_the_author_meta( '_cf_user_zipcode', $user->ID ) ); ?>"
				       class="regular-text"/><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_city">City</label></th>
			<td>
				<input type="text" name="_cf_user_city" id="_cf_user_city"
				       value="<?php echo esc_attr( get_the_author_meta( '_cf_user_city', $user->ID ) ); ?>"
				       class="regular-text"/><br/>
			</td>
		</tr>
        <tr>
			<th><label for="_cf_user_company_name">Company name</label></th>
			<td>
				<input type="text" name="_cf_user_company_name" id="_cf_user_company_name"
				       value="<?php echo esc_attr( get_the_author_meta( '_cf_user_company_name', $user->ID ) ); ?>"
				       class="regular-text"/><br/>
			</td>
		</tr>
        <tr>
            <th><label for="_cf_user_sector">Sector</label></th>
            <td>
				<?php $sector = esc_attr( get_the_author_meta( '_cf_user_sector', $user->ID ) );
				$sectors = getCustomItems('sectors'); ?>
                <select name="_cf_user_sector" id="_cf_user_sector" class="regular-text">
                    <option value="" <?php selected( $sector, '' ); ?>></option>
                    <?php foreach($sectors as $s) { ?>
                        <option value="<?php echo $s; ?>" <?php selected( $sector, $s ); ?>><?php echo $s; ?></option>
                    <?php } ?>
                </select><br/>
            </td>
        </tr>
		<tr>
			<th><label for="_cf_user_primspecialism">Primair Specialism</label></th>
			<td>
				<?php $primSpecialism = esc_attr( get_the_author_meta( '_cf_user_primspecialism', $user->ID ) );
				$specialisms = getCustomItems('specialisms'); ?>
				<select name="_cf_user_primspecialism" id="_cf_user_primspecialism" class="regular-text">
					<option value="" <?php selected( $primSpecialism, '' ); ?>></option>
					<?php foreach($specialisms as $s) { ?>
                        <option value="<?php echo $s; ?>" <?php selected( $primSpecialism, $s ); ?>><?php echo $s; ?></option>
					<?php } ?>
				</select><br/>
			</td>
		</tr>
        <tr>
            <th><label for="_cf_user_experience">Experience</label></th>
            <td>
                <?php $experience = esc_attr( get_the_author_meta( '_cf_user_experience', $user->ID ) );
                $experiences = getCustomItems('experiences'); ?>
                <select name="_cf_user_experience" id="_cf_user_experience" class="regular-text">
                    <option value="" <?php selected( $experience, '' ); ?>></option>
                    <?php foreach($experiences as $s) { ?>
                        <option value="<?php echo $s; ?>" <?php selected( $experience, $s ); ?>><?php echo $s; ?></option>
                    <?php } ?>
                </select><br/>
            </td>
        </tr>
		<tr>
			<th><label for="_cf_user_secspecialism">Secundair Specialism</label></th>
			<td>
				<?php $secSpecialism = esc_attr( get_the_author_meta( '_cf_user_secspecialism', $user->ID ) );
				$specialisms = getCustomItems('specialisms'); ?>
				<select name="_cf_user_secspecialism" id="_cf_user_secspecialism" class="regular-text">
					<option value="" <?php selected( $secSpecialism, '' ); ?>></option>
					<?php foreach($specialisms as $s) { ?>
                        <option value="<?php echo $s; ?>" <?php selected( $secSpecialism, $s ); ?>><?php echo $s; ?></option>
					<?php } ?>
				</select><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_secexperience">Experience</label></th>
			<td>
				<?php $experience = esc_attr( get_the_author_meta( '_cf_user_secexperience', $user->ID ) );
				$experiences = getCustomItems('experiences'); ?>
				<select name="_cf_user_secexperience" id="_cf_user_secexperience" class="regular-text">
                    <option value="" <?php selected( $experience, '' ); ?>></option>
					<?php foreach($experiences as $s) { ?>
                        <option value="<?php echo $s; ?>" <?php selected( $experience, $s ); ?>><?php echo $s; ?></option>
					<?php } ?>
				</select><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_jobtitle">Job Title</label></th>
			<td>
				<?php $jobTitle = esc_attr( get_the_author_meta( '_cf_user_jobtitle', $user->ID ) );
				$jobTitles = getCustomItems('jobtitles'); ?>
				<select name="_cf_user_jobtitle" id="_cf_user_jobtitle" class="regular-text">
                    <option value="" <?php selected( $jobTitle, '' ); ?>></option>
					<?php foreach($jobTitles as $s) { ?>
                        <option value="<?php echo $s; ?>" <?php selected( $jobTitle, $s ); ?>><?php echo $s; ?></option>
					<?php } ?>
				</select><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_joblocation">Job Location</label></th>
			<td>
				<?php $jobLocation = esc_attr( get_the_author_meta( '_cf_user_joblocation', $user->ID ) );
				$projects = getConsultantProjects(); ?>
				<select name="_cf_user_joblocation" id="_cf_user_joblocation" class="regular-text">
                    <?php foreach($projects as $key => $value): ?>
                        <option value="<?php echo $key; ?>" <?php selected($jobLocation, $key); ?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
				</select><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_curr_experience">Experience</label></th>
			<td>
				<?php $currExperience = esc_attr( get_the_author_meta( '_cf_user_curr_experience', $user->ID ) );
				$experiences = getCustomItems('experiences'); ?>
				<select name="_cf_user_curr_experience" id="_cf_user_curr_experience" class="regular-text">
                    <option value="" <?php selected( $currExperience, '' ); ?>></option>
					<?php foreach($experiences as $s) { ?>
                        <option value="<?php echo $s; ?>" <?php selected( $currExperience, $s ); ?>><?php echo $s; ?></option>
					<?php } ?>
				</select><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_hourly_rate">Hourly Rate</label></th>
			<td>
				<input type="number" step="any" min="0" name="_cf_user_hourly_rate" id="_cf_user_hourly_rate"
				       value="<?php echo esc_attr( get_the_author_meta( '_cf_user_hourly_rate', $user->ID ) ); ?>"
				       class="regular-text"/><br/>
			</td>
		</tr>
		<tr>
			<th><label for="_cf_user_hourly_rate_c">Hourly Rate for Client</label></th>
			<td>
				<input type="number" step="any" min="0" name="_cf_user_hourly_rate_c" id="_cf_user_hourly_rate_c"
				       value="<?php echo esc_attr( get_the_author_meta( '_cf_user_hourly_rate_c', $user->ID ) ); ?>"
				       class="regular-text"/><br/>
			</td>
		</tr>
        <tr>
			<th><label for="_cf_user_archive">Archive</label></th>
			<td>
                <?php $cfUserArchive = esc_attr( get_the_author_meta( '_cf_user_archive', $user->ID ) ); ?>
                <input id="_cf_user_archive" type="checkbox" name="_cf_user_archive" value="archived" <?php checked( $cfUserArchive, 'archived' ); ?> /><br/>
			</td>
		</tr>
	</table>
<?php }

add_action( 'personal_options_update', 'saveExtraUserProfileFields' );
add_action( 'edit_user_profile_update', 'saveExtraUserProfileFields' );

function saveExtraUserProfileFields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	$archive = $_POST['_cf_user_archive'] ? $_POST['_cf_user_archive'] : '';

	update_user_meta( $user_id, '_cf_user_consultant', $_POST['_cf_user_consultant'] );
	update_user_meta( $user_id, '_cf_user_middle_name', $_POST['_cf_user_middle_name'] );
	update_user_meta( $user_id, '_cf_user_gender', $_POST['_cf_user_gender'] );
	update_user_meta( $user_id, '_cf_user_address', $_POST['_cf_user_address'] );
	update_user_meta( $user_id, '_cf_user_N', $_POST['_cf_user_N'] );
	update_user_meta( $user_id, '_cf_user_zipcode', $_POST['_cf_user_zipcode'] );
	update_user_meta( $user_id, '_cf_user_city', $_POST['_cf_user_city'] );
	update_user_meta( $user_id, '_cf_user_sector', $_POST['_cf_user_sector'] );
	update_user_meta( $user_id, '_cf_user_company_name', $_POST['_cf_user_company_name'] );
	update_user_meta( $user_id, '_cf_user_primspecialism', $_POST['_cf_user_primspecialism'] );
    update_user_meta( $user_id, '_cf_user_experience', $_POST['_cf_user_experience'] );
    update_user_meta( $user_id, '_cf_user_secspecialism', $_POST['_cf_user_secspecialism'] );
    update_user_meta( $user_id, '_cf_user_secexperience', $_POST['_cf_user_secexperience'] );
    update_user_meta( $user_id, '_cf_user_jobtitle', $_POST['_cf_user_jobtitle'] );
	update_user_meta( $user_id, '_cf_user_joblocation', $_POST['_cf_user_joblocation'] );
	update_user_meta( $user_id, '_cf_user_curr_experience', $_POST['_cf_user_curr_experience'] );
	update_user_meta( $user_id, '_cf_user_hourly_rate', $_POST['_cf_user_hourly_rate'] );
	update_user_meta( $user_id, '_cf_user_hourly_rate_c', $_POST['_cf_user_hourly_rate_c'] );
	update_user_meta( $user_id, '_cf_user_archive', $archive );
}