<div class="cf-panel">
	<div class="cf-panel-h">
		<div class="cf-panel-h-title">
			USERS ON THIS PROJECT
		</div>
	</div>

	<div class="cf-panel-b">
        <?php
        if(isset($_GET['project-id']) && $_GET['project-id']) {
            $projectId = $_GET['project-id'];
        } else {
	        $projectId = get_the_ID();
        }

        $cfUsersRaw = get_post_meta($projectId, '_cf_project_users', true);
	    $cfUsers = unserialize($cfUsersRaw); ?>
        <ul class="list-group">
            <?php foreach($cfUsers as $cfUser) {
	            $userData = get_userdata( $cfUser );
	            $userRole = $userData->roles[0];
	            $roleClassName = '';
	            if($userRole === 'candidate') {
		            $roleClassName = 'cf-sm-c-icon';
	            } elseif($userRole === 'project-manager') {
		            $roleClassName = 'cf-sm-m-icon';
	            }

                ?>
                <li class="list-group-item d-flex align-items-center cf-user-list">
                    <span class="<?php echo $roleClassName; ?>"></span>
                    <div class="cf-user-list-item"><?php echo $userData->data->display_name; ?></div>
                    <div class="ml-auto cf-remove-user" data-projectid="<?php echo $projectId; ?>" data-userid="<?php echo $cfUser; ?>"><i class="far fa-trash-alt"></i></div>
                </li>
            <?php } ?>
        </ul>

        <?php $addUsers = isset($_GET['project-id']) && $_GET['project-id'];
        if($addUsers) {
	        $href = 'javascript: void(0)';
        } else {
	        $href = get_the_permalink(78) . '?project-id=' . $projectId;
        } ?>

        <div class="col-md-12" style="text-align: center">
            <?php if(!$addUsers) { ?>
                <a class="cf-blue-btn mt-4 mb-4" href="<?php echo $href; ?>"><i class="fas fa-plus" style="margin-right: 10px"></i> ADD USER</a>
            <?php } else { ?>
                <div class="mt-4 mb-4"></div>
            <?php } ?>
        </div>

        <div class="row cf-user-role-info">
            <div class="col-sm-6"><span class="cf-sm-m-icon"></span> Manager</div>
            <div class="col-sm-6"><span class="cf-sm-c-icon"></span> Candidate</div>
        </div>
	</div>
</div>


<div class="modal" id="remove-user-from-project" tabindex="-1" role="dialog" aria-labelledby="remove-user-from-project" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">MESSAGE</h5>
            </div>
            <div class="modal-body">
                Remove user from this project?
            </div>
            <div class="modal-footer">
                <button type="button" class="cf-blue-btn" style="background-color: #323f48" data-dismiss="modal">NO</button>
                <button type="button" class="cf-blue-btn btn-accept">YES</button>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        var userId = $(this).data('userid');
        var projectId = $(this).data('projectid');

        $('.cf-remove-user').on('click', function() {
            userId = $(this).data('userid');
            projectId = $(this).data('projectid');

            $('#remove-user-from-project').modal('show');
        });

        $('#remove-user-from-project .btn-accept').on('click', function() {
            removeUser(userId, projectId);
        });

        function removeUser(userId, projectId) {
            $.ajax({
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                type: 'POST',
                data: {
                    action: 'remove_user_from_project',
                    user_id: userId,
                    project_id: projectId,
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
</script>