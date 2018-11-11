<?php
/**
 * Template Name: Add User
 */
?>

<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

    <?php $cfUsers = [];
    if(isset($_GET['project-id']) && $_GET['project-id']) {
        $projectId = $_GET['project-id'];
        $cfUsersRaw = get_post_meta($projectId, '_cf_project_users', true);
        $cfUsers = unserialize($cfUsersRaw);
    } ?>
	<main id="dashboard">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="p-4">
						<div class="cf-page-title"><?php echo get_the_title($projectId); ?></div>
                        <a style="float:right" class="cf-white-btn" href="<?php echo get_the_permalink($projectId); ?>">BACK</a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-lg-8">

					<div class="cf-panel">
						<div class="cf-panel-h">
							<div class="cf-panel-h-title">USER LIST</div>
							<div id="datatable-searchbar"></div>
							<a id="cf-add-user" style="height: 40px; margin: -5px 20px -5px 15px; float: right; line-height: 30px" class="cf-blue-btn" href="#">ADD USER(S) TO PROJECT</a>
						</div>

						<div class="cf-panel-b">
							<table id="d-with-search-list" class="display cf-datatable" style="width: 100%;">
								<thead>
								<tr>
									<th>SELECT</th>
									<th>NAME</th>
									<th>SECTOR</th>
									<th>SPECIALISM</th>
									<th>ROLL</th>
								</tr>
								</thead>
								<tbody>

                                <?php $args = array(
									'role__in' => array('project-manager', 'candidate'),
									'orderby' => 'ID',
									'order' => 'ASC',
									'meta_query' => array(
										array(
											'key'     => '_cf_user_consultant',
											'value'   => get_current_user_id()
										)
									)
								);
								$users = new WP_User_Query( $args );
								$data = array();

								foreach ($users->get_results() as $user) {
									$userId = $user->data->ID;
									if (in_array($userId, $cfUsers)) {
										continue;
									}

									$userData = get_userdata( $userId );
									$userRole = $userData->roles[0];
									$roleName = '';
									if($userRole === 'candidate') {
										$roleName = 'Candidate';
									} elseif($userRole === 'project-manager') {
										$roleName = 'Manager';
									}
									$sector = get_the_author_meta( '_cf_user_sector', $userId );
									$primSpecialism = get_the_author_meta( '_cf_user_primspecialism', $userId ); ?>
									<tr>
										<td><input class="cf-selected-users" type="checkbox" value="<?php echo $userId; ?>"></td>
										<td><?php echo $user->data->display_name; ?></td>
										<td><?php echo $sector; ?></td>
										<td><?php echo $primSpecialism; ?></td>
										<td><?php echo $roleName; ?></td>
									</tr>
								<?php } ?>
							</table>
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
        jQuery(document).ready(function($) {
            $('#cf-add-user').on('click', function() {
                var userIds = [];
                $('.cf-selected-users:checked').each(function() {
                    userIds.push($(this).val());
                });
                if(userIds.length > 0) {
                    $.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        type: 'POST',
                        data: {
                            action: 'add_users_to_project',
                            user_ids: userIds,
                            project_id: <?php echo $_GET['project-id']; ?>,
                        },
                        success: function(data) {
                            var parsedData = JSON.parse(data);
                            if(parsedData.status) {
                                location.reload();
                            }
                        }
                    });
                }

            });

            function removeUser(userId, projectId) {

            }
        });
	</script>

<?php get_footer(); ?>