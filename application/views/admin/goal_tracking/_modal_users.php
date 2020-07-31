<div class="panel panel-custom">
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= lang('all_users') ?></h4>
    </div>
    <div class="modal-body wrap-modal wrap">
        <form id="form_validation"
              action="<?php echo base_url() ?>admin/goal_tracking/update_member/<?php if (!empty($goal_info->goal_tracking_id)) echo $goal_info->goal_tracking_id; ?>"
              method="post" class="form-horizontal form-groups-bordered">

            <?php
            $permissionL = null;
            if (!empty($goal_info->permission)) {
                $permissionL = $goal_info->permission;
            }
            ?>
            <?= get_permission(3, 6, $permission_user, $permissionL, ''); ?>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
                <button type="submit" class="btn btn-primary"><?= lang('update') ?></button>
            </div>
        </form>
    </div>
</div>
