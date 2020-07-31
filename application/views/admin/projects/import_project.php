<?= message_box('success'); ?>
<?= message_box('error'); ?>
<div class="panel panel-custom">
    <header class="panel-heading">
        <div class="panel-title"><strong><?= lang('import') . ' ' . lang('project') ?></strong>
            <div class="pull-right hidden-print">
                <div class="pull-right "><a href="<?php echo base_url() ?>assets/sample/project_sample.xlsx"
                                            class="btn btn-primary"><i
                            class="fa fa-download"> <?= lang('download_sample') ?></i></a>
                </div>
            </div>
        </div>
    </header>
    <div class="panel-body">
        <form role="form" enctype="multipart/form-data" id="form"
              action="<?php echo base_url(); ?>admin/projects/save_imported" method="post"
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
                                                            <input type="file" name="upload_file" >
                                                        </span>
                            <span class="fileinput-filename"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput"
                               style="float: none;">&times;</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label"><?= lang('select_client') ?> <span
                            class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <select name="client_id" class="form-control select_box" style="width: 100%" required="">
                            <option value=""><?= lang('select_client') ?></option>
                            <?php
                            $all_client = $this->db->get('tbl_client')->result();
                            if (!empty($all_client)) {
                                foreach ($all_client as $v_client) {
                                    ?>
                                    <option value="<?= $v_client->client_id ?>" <?php
                                    if (!empty($project_info) && $project_info->client_id == $v_client->client_id) {
                                        echo 'selected';
                                    }
                                    ?>><?= $v_client->name ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <?php
                $permissionL = null;
                if (!empty($credit_note_info->permission)) {
                    $permissionL = $credit_note_info->permission;
                }
                ?>
                <?= get_permission(2, 4, $assign_user, $permissionL, lang('assined_to')); ?>

                <div class="form-group">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-sm btn-primary"> <?= lang('upload') ?></button>
                    </div>
                </div>
            </div>
    </div>
</div>
