<div class="panel panel-custom">
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= lang('all_users') ?></h4>
    </div>
    <div class="modal-body wrap-modal wrap">
        <form id="form_validation"
              action="<?php echo base_url() ?>admin/bugs/update_member/<?php if (!empty($bugs_info->bug_id)) echo $bugs_info->bug_id; ?>"
              method="post" class="form-horizontal form-groups-bordered">
            <?= get_permission_modal(3, 9, $assign_user, $bugs_info->permission, lang('assigned_to')); ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
                <button type="submit" class="btn btn-primary"><?= lang('update') ?></button>
            </div>
        </form>
    </div>
</div>
