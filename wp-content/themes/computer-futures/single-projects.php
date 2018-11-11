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
							<?php $postId = get_the_ID();
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
							$projectMeta['_cf_project_archive'] = $_POST['_cf_project_archive'];

							if(isset($_POST['_cf_project_name']) && $_POST['_cf_project_name'] &&
							isset($_POST['_cf_project_starts']) && $_POST['_cf_project_starts'] &&
							isset($_POST['_cf_project_ends']) && $_POST['_cf_project_ends'] &&
							isset($_POST['_cf_project_sector']) && $_POST['_cf_project_sector'] &&
							isset($_POST['_cf_project_client']) && $_POST['_cf_project_client'] &&
							isset($_POST['_cf_project_address']) && $_POST['_cf_project_address'] &&
							isset($_POST['_cf_project_zipcode']) && $_POST['_cf_project_zipcode'] &&
							isset($_POST['_cf_project_city']) && $_POST['_cf_project_city']) {
								wp_update_post( array('ID' => $postId, 'post_title' => $projectName) );
								foreach ($projectMeta as $key => $value) {
									$value = implode(',', (array)$value);
									if(get_post_meta($post->ID, $key, FALSE)) {
										update_post_meta($post->ID, $key, $value);
									} else {
										add_post_meta($post->ID, $key, $value);
									}
									if(!$value) delete_post_meta($post->ID, $key);
								}
							} ?>

							<form method="post" id="cf-form-project-info">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="_cf_project_name">Project name*</label>
													<input type="text" class="form-control" name="_cf_project_name" id="_cf_project_name" value="<?php echo get_the_title($postId); ?>" required>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="_cf_project_starts">Starts*</label>
													<input type="text" class="form-control cf-date-picker" name="_cf_project_starts" id="_cf_project_starts" value="<?php echo get_post_meta($postId, '_cf_project_starts', true); ?>" required>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label for="_cf_project_ends">Ends*</label>
													<input type="text" class="form-control cf-date-picker" name="_cf_project_ends" id="_cf_project_ends" value="<?php echo get_post_meta($postId, '_cf_project_ends', true); ?>" required>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<?php $cfSector = get_post_meta($postId, '_cf_project_sector', true);
													$sectors = getCustomItems('sectors'); ?>
													<label for="_cf_project_sector">Sector*</label>
													<select id="_cf_project_sector" name="_cf_project_sector" class="form-control" required>
														<?php foreach($sectors as $s) { ?>
                                                            <option value="<?php echo $s; ?>" <?php selected( $cfSector, $s ); ?>><?php echo $s; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<?php $cfTechnique = get_post_meta($postId, '_cf_project_technique', true); ?>
													<label for="_cf_project_technique">Technique</label>
													<select id="_cf_project_technique" name="_cf_project_technique" class="form-control">
														<option value="Technique 1" <?php selected( $cfTechnique, 'Technique 1' ); ?>>Technique 1</option>
														<option value="Technique 2" <?php selected( $cfTechnique, 'Technique 2' ); ?>>Technique 2</option>
														<option value="Technique 3" <?php selected( $cfTechnique, 'Technique 3' ); ?>>Technique 3</option>
														<option value="Technique 4" <?php selected( $cfTechnique, 'Technique 4' ); ?>>Technique 4</option>
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
													<input type="text" class="form-control" name="_cf_project_client" id="_cf_project_client" value="<?php echo get_post_meta($postId, '_cf_project_client', true); ?>" required>
												</div>
											</div>

											<div class="col-md-8">
												<div class="form-group">
													<label for="_cf_project_address">Address*</label>
													<input type="text" class="form-control" name="_cf_project_address" id="_cf_project_address" value="<?php echo get_post_meta($postId, '_cf_project_address', true); ?>" required>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label for="_cf_project_N">No. + ext.</label>
													<input type="text" class="form-control" name="_cf_project_N"  id="_cf_project_N" value="<?php echo get_post_meta($postId, '_cf_project_N', true); ?>">
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label for="_cf_project_zipcode">Zip code*</label>
													<input type="text" class="form-control" name="_cf_project_zipcode" id="_cf_project_zipcode" value="<?php echo get_post_meta($postId, '_cf_project_zipcode', true); ?>" required>
												</div>
											</div>

											<div class="col-md-8">
												<div class="form-group">
													<label for="_cf_project_city">City*</label>
													<input type="text" class="form-control" name="_cf_project_city" id="_cf_project_city" value="<?php echo get_post_meta($postId, '_cf_project_city', true); ?>" required>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="_cf_project_description">Description</label>
											<textarea class="form-control" id="_cf_project_description" name="_cf_project_description" rows="3"><?php echo get_post_meta($postId, '_cf_project_description', true); ?></textarea>
										</div>
									</div>

									<div class="col-md-12"><span class="cf-required">*</span> required</div>

									<div class="col-md-12" style="text-align: right">
										<?php $cfProjectArchive = get_post_meta($post->ID, '_cf_project_archive', true); ?>
										<div class="form-group form-check mr-3" style="display: inline-block">
											<input type="checkbox" class="form-check-input" name="_cf_project_archive" id="_cf_project_archive" value="archived" <?php checked( $cfProjectArchive, 'archived' ); ?>>
											<label class="form-check-label" for="_cf_project_archive">Archive this project</label>
										</div>

										<button type="submit" class="cf-blue-btn">SAVE CHANGES</button>
									</div>
								</div>
							</form>

						</div>
					</div>

				</div>

				<div class="col-md-12 col-lg-4">
					<?php get_template_part( 'components/component', 'project-users' ); ?>
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