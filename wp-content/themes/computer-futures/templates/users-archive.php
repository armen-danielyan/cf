<?php
/**
 * Template Name: Users Archive
 */
?>
<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

<main id="dashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="p-4">
					<div class="cf-page-title">Users</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-8">

				<div class="cf-panel">
					<div class="cf-panel-h">
						<div class="cf-panel-h-title">ARCHIVED USER LIST</div>
						<div id="datatable-searchbar"></div>
					</div>

					<div class="cf-panel-b">
						<table id="d-with-search-list" class="display cf-datatable" style="width: 100%;">
							<thead>
							<tr>
								<th>NAME</th>
								<th>SECTOR</th>
								<th>SPECIALISM</th>
								<th>ROLE</th>
								<th>DATE</th>
							</tr>
							</thead>
							<tbody>

							<?php $args = array(
								'role__in' => array('project-manager', 'candidate'),
								'orderby' => 'ID',
								'order' => 'ASC',
								'meta_query' => array(
                                    'relation'  => 'AND',
                                    filterByUserRole('_cf_user_consultant'),
                                    array(
                                        'key' => '_cf_user_archive',
                                        'value' => 'archived'
                                    )
								)
							);
							$users = new WP_User_Query( $args );
							$data = array();

							foreach ($users->get_results() as $user) {
								$userId = $user->data->ID;
								$userData = get_userdata( $userId );
								$userRole = $userData->roles[0];
								$roleClassName = '';
								if($userRole === 'candidate') {
									$roleClassName = 'cf-sm-c-icon';
								} elseif($userRole === 'project-manager') {
									$roleClassName = 'cf-sm-m-icon';
								}

								$primSpecialism = get_the_author_meta( '_cf_user_primspecialism', $userId );
								$sector = get_the_author_meta( '_cf_user_sector', $userId ); ?>
								<tr>
									<td><a href="<?php echo get_the_permalink(104) . '?id=' . $userId; ?>"><?php echo $user->data->display_name; ?></a></td>
									<td><?php echo $sector; ?></td>
									<td><?php echo $primSpecialism; ?></td>
									<td><span class="<?php echo $roleClassName; ?>"></span></td>
									<td><?php echo date('d/m/Y', strtotime($user->data->user_registered)); ?></td>
								</tr>
							<?php } ?>

							</tbody>
						</table>
					</div>
				</div>

			</div>

			<div class="col-md-12 col-lg-4">
				<?php get_template_part( 'components/component', 'your-total' ); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
