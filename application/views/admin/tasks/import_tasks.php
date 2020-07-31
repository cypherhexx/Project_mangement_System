<?= message_box('success'); ?>
<?= message_box('error'); ?>
<div class="panel panel-custom">
    <header class="panel-heading">
        <div class="panel-title"><strong><?= lang('import') . ' ' . lang('tasks') ?></strong>
            <div class="pull-right hidden-print">
                <div class="pull-right "><a href="<?php echo base_url() ?>assets/sample/tasks_sample.xlsx"
                                            class="btn btn-primary"><i
                                class="fa fa-download"> <?= lang('download_sample') ?></i></a>
                </div>
            </div>
        </div>
    </header>
    <div class="panel-body">
        <form role="form" enctype="multipart/form-data" data-parsley-validate="" novalidate=""
              action="<?php echo base_url(); ?>admin/tasks/save_imported" method="post"
              class="form-horizontal  ">
            <div class="panel-body">
                <div class="form-group">
                    <label for="field-1" class="col-sm-2 control-label">
                        <?= lang('choose_file') ?><span class="required">*</span></label>
                    <div class="col-sm-5">
                        <div style="display: inherit;margin-bottom: inherit" class="fileinput fileinput-new"
                             data-provides="fileinput">
                    <span class="btn btn-default btn-file"><span
                                class="fileinput-new"><?= lang('select_file') ?></span>
                                                            <span class="fileinput-exists"><?= lang('change') ?></span>
                                                            <input type="file" name="upload_file">
                                                        </span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput"
                               style="float: none;">&times;</a>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="border-none">
                    <label for="field-1" class="col-sm-2 control-label"><?= lang('task_status') ?> <span
                                class="required">*</span></label>
                    <div class="col-sm-3">
                        <select name="task_status" class="form-control" required>
                            <option
                                    value="not_started" <?= (!empty($task_info->task_status) && $task_info->task_status == 'not_started' ? 'selected' : '') ?>> <?= lang('not_started') ?> </option>
                            <option
                                    value="in_progress" <?= (!empty($task_info->task_status) && $task_info->task_status == 'in_progress' ? 'selected' : '') ?>> <?= lang('in_progress') ?> </option>
                            <option
                                    value="completed" <?= (!empty($task_info->task_status) && $task_info->task_status == 'completed' ? 'selected' : '') ?>> <?= lang('completed') ?> </option>
                            <option
                                    value="deferred" <?= (!empty($task_info->task_status) && $task_info->task_status == 'deferred' ? 'selected' : '') ?>> <?= lang('deferred') ?> </option>
                            <option
                                    value="waiting_for_someone" <?= (!empty($task_info->task_status) && $task_info->task_status == 'waiting_for_someone' ? 'selected' : '') ?>> <?= lang('waiting_for_someone') ?> </option>
                        </select>
                    </div>
                </div>
                <?php
                $permissionL = null;
                if (!empty($task_info->permission)) {
                    $permissionL = $task_info->permission;
                }
                ?>
                <?= get_permission(2, 5, $assign_user, $permissionL, lang('assined_to')); ?>


                <div class="form-group">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-sm btn-primary"></i> <?= lang('upload') ?></button>
                    </div>
                </div>
            </div>
    </div>
</div>
