<?php
/**
 * Template Name: Create Project
 */
?>
<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

<main id="dashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="p-4">
					<div class="cf-page-title">Projects</div>
					<a style="float:right" class="cf-white-btn" href="<?php echo get_the_permalink( 344 ); ?>">BACK</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-8">

				<div class="cf-panel">
					<div class="cf-panel-h">
						<div class="cf-panel-h-title">PROJECT INFORMATION</div>
					</div>

					<div class="cf-panel-b">
						<?php
						$projectName = $_POST['_cf_project_name'];
						$projectMeta['_cf_project_starts'] = $_POST['_cf_project_starts'];
						$projectMeta['_cf_project_ends'] = $_POST['_cf_project_ends'];
						$projectMeta['_cf_project_sector'] = $_POST['_cf_project_sector'];
						$projectMeta['_cf_project_client'] = $_POST['_cf_project_client'];
						$projectMeta['_cf_project_address'] = $_POST['_cf_project_address'];
						$projectMeta['_cf_project_N'] = $_POST['_cf_project_N'];
						$projectMeta['_cf_project_zipcode'] = $_POST['_cf_project_zipcode'];
						$projectMeta['_cf_project_city'] = $_POST['_cf_project_city'];
						$projectMeta['_cf_project_technique'] = $_POST['_cf_project_technique'];
						$projectMeta['_cf_project_description'] = $_POST['_cf_project_description'];
						$projectMeta['_cf_project_archive'] = '';
						$projectMeta['_cf_project_consultant'] = get_current_user_id();

						if(isset($_POST['_cf_project_name']) && $_POST['_cf_project_name'] &&
						   isset($_POST['_cf_project_starts']) && $_POST['_cf_project_starts'] &&
						   isset($_POST['_cf_project_ends']) && $_POST['_cf_project_ends'] &&
						   isset($_POST['_cf_project_sector']) && $_POST['_cf_project_sector'] &&
						   isset($_POST['_cf_project_client']) && $_POST['_cf_project_client'] &&
						   isset($_POST['_cf_project_address']) && $_POST['_cf_project_address'] &&
						   isset($_POST['_cf_project_zipcode']) && $_POST['_cf_project_zipcode'] &&
						   isset($_POST['_cf_project_city']) && $_POST['_cf_project_city']) {

							$myPost = array(
								'post_title' => $projectName,
								'post_type' => 'projects',
								'post_status' => 'publish',
								'meta_input' => $projectMeta
							);
							$newProjectId = wp_insert_post( $myPost );
							if($newProjectId) { ?>
                                <script>
                                    window.location.replace("<?php echo get_post_permalink($newProjectId); ?>");
                                </script>
                            <?php } ?>

							<div class="row">
								<div class="col-md-12">
									<div class="jumbotron">
										<h1 class="display-4 text-center">Great!</h1>
										<p class="lead text-center">New project is created!</p>
									</div>
								</div>
							</div>

						<?php } ?>

						<form method="post" id="cf-form-project-info">
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="_cf_project_name">Project name*</label>
												<input type="text" class="form-control" name="_cf_project_name" id="_cf_project_name" value="" required>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="_cf_project_starts">Starts*</label>
												<input type="text" class="form-control cf-date-picker" name="_cf_project_starts" id="_cf_project_starts" value="" required>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label for="_cf_project_ends">Ends*</label>
												<input type="text" class="form-control cf-date-picker" name="_cf_project_ends" id="_cf_project_ends" value="" required>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<label for="_cf_project_sector">Sector*</label>
												<select id="_cf_project_sector" name="_cf_project_sector" class="form-control" required>
                                                    <?php $sectors = getCustomItems('sectors');
                                                    foreach($sectors as $s) { ?>
                                                        <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                                                    <?php } ?>
												</select>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group">
												<label for="_cf_project_technique">Technique</label>
												<select id="_cf_project_technique" name="_cf_project_technique" class="form-control">
													<option value="Technique 1">Technique 1</option>
													<option value="Technique 2">Technique 2</option>
													<option value="Technique 3">Technique 3</option>
													<option value="Technique 4">Technique 4</option>
												</select>
											</div>
										</div>
									</div>

								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="_cf_project_client">Client*</label>
												<input type="text" class="form-control" name="_cf_project_client" id="_cf_project_client" value="" required>
											</div>
										</div>

										<div class="col-md-8">
											<div class="form-group">
												<label for="_cf_project_address">Address*</label>
												<input type="text" class="form-control" name="_cf_project_address" id="_cf_project_address" value="" required>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="_cf_project_N">No. + ext.</label>
												<input type="text" class="form-control" name="_cf_project_N"  id="_cf_project_N" value="">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label for="_cf_project_zipcode">Zip code*</label>
												<input type="text" class="form-control" name="_cf_project_zipcode" id="_cf_project_zipcode" value="" required>
											</div>
										</div>

										<div class="col-md-8">
											<div class="form-group">
												<label for="_cf_project_city">City*</label>
												<input type="text" class="form-control" name="_cf_project_city" id="_cf_project_city" value="" required>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="_cf_project_description">Description</label>
										<textarea class="form-control" id="_cf_project_description" name="_cf_project_description" rows="3"></textarea>
									</div>
								</div>

								<div class="col-md-12"><span class="cf-required">*</span> required</div>

								<div class="col-md-12" style="text-align: right">
									<button type="submit" class="cf-blue-btn">CREATE PROJECT</button>
								</div>
							</div>
						</form>

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
    jQuery(document).ready(function ($) {
        $(function() {
            $( ".cf-date-picker" ).datepicker({ dateFormat: 'yy-mm-dd' });
        });
    });
</script>

<?php get_footer(); ?>
