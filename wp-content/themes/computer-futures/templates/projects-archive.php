<?php
/**
 * Template Name: Projects Archive
 */
?>

<?php get_header(); ?>

<?php get_template_part('components/component', 'header'); ?>

<main id="projects">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="p-4">
                    <div class="cf-page-title">Projects</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-8">

                <div class="cf-panel">
                    <div class="cf-panel-h">
                        <div class="cf-panel-h-title">ARCHIVED PROJECTS LIST</div>
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
                            <?php $args = array(
                                'post_type' => 'projects',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'key' => '_cf_project_archive',
                                        'value' => 'archived'
                                    ),
                                    filterByUserRole('_cf_project_consultant')
                                )
                            );
                            $projects = new WP_Query($args);

                            if($projects->have_posts()): while($projects->have_posts()): $projects->the_post(); ?>
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
