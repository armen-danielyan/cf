<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

	<main id="dashboard">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
                    <div class="p-4">
                        <div class="cf-page-title">Projects</div>
                        <a class="cf-blue-btn" href="<?php echo get_the_permalink(33); ?>"><i class="fas fa-plus" style="margin-right: 10px"></i> NEW PROJECT</a>
                    </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-lg-8">

					<div class="cf-panel">
						<div class="cf-panel-h">
							<div class="cf-panel-h-title">PROJECTS LIST</div>
                            <div id="datatable-searchbar"></div>
						</div>

						<div class="cf-panel-b">
							<table id="d-with-search-list" class="display cf-datatable" style="width: 100%;">
								<thead>
								<tr>
									<th>NAME</th>
									<th>USERS</th>
									<th>REVIEWS</th>
									<th>START DATE</th>
									<th>END DATE</th>
								</tr>
								</thead>
								<tbody>
                                    <?php if(have_posts()): while(have_posts()): the_post(); ?>
                                        <?php $postId = get_the_ID();
                                        $users = unserialize(get_post_meta($postId, '_cf_project_users', true));
                                        $startDate = get_post_meta($postId, '_cf_project_starts', true);
                                        $endDate = get_post_meta($postId, '_cf_project_ends', true);

                                        $count = $users ? count($users) : 0; ?>
                                        <tr>
                                            <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo reviewsDoneByprojectId($postId); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($startDate)); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($endDate)); ?></td>
                                        </tr>
	                                <?php endwhile; endif; ?>
								</tbody>
							</table>
						</div>
					</div>

				</div>

				<div class="col-md-12 col-lg-4">
					<?php get_template_part( 'components/component', 'your-total' ); ?>
					<?php get_template_part( 'components/component', 'last-review' ); ?>
				</div>
			</div>
		</div>
	</main>

<?php get_footer(); ?>