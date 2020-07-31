<?= message_box('success'); ?>
<?= message_box('error'); ?>
<div class="panel panel-custom">
    <header class="panel-heading">
        <div class="panel-title"><strong><?= lang('import_leads') ?></strong>
            <div class="pull-right hidden-print">
                <div class="pull-right "><a href="<?php echo base_url() ?>assets/sample/leads_sample.xlsx"
                                            class="btn btn-primary"><i
                            class="fa fa-download"> <?= lang('download_sample') ?></i></a>
                </div>
            </div>

        </div>
    </header>
    <div class="panel-body">
        <form role="form" enctype="multipart/form-data" id="form"
              action="<?php echo base_url(); ?>admin/leads/save_imported" method="post"
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
                    <label class="col-lg-2 control-label"><?= lang('lead_source') ?> </label>
                    <div class="col-lg-4">
                        <select name="lead_source_id" class="form-control select_box" style="width: 100%"
                                required="">
                            <?php
                            $lead_source_info = $this->db->get('tbl_lead_source')->result();
                            if (!empty($lead_source_info)) {
                                foreach ($lead_source_info as $v_lead_source) {
                                    ?>
                                    <option
                                        value="<?= $v_lead_source->lead_source_id ?>" <?= (!empty($leads_info) && $leads_info->lead_source_id == $v_lead_source->lead_source_id ? 'selected' : '') ?>><?= $v_lead_source->lead_source ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label"><?= lang('lead_status') ?> </label>
                    <div class="col-lg-4">
                        <select name="lead_status_id" class="form-control select_box" style="width: 100%"
                                required="">
                            <?php

                            if (!empty($status_info)) {
                                foreach ($status_info as $type => $leads_status) {
                                    if (!empty($leads_status)) {
                                        ?>
                                        <optgroup label="<?= lang($type) ?>">
                                            <?php foreach ($leads_status as $v_status) { ?>
                                                <option
                                                    value="<?= $v_status->lead_status_id ?>" <?php
                                                if (!empty($leads_info->lead_status_id)) {
                                                    echo $v_status->lead_status_id == $leads_info->lead_status_id ? 'selected' : '';
                                                }
                                                ?>><?= $v_status->lead_status ?></option>
                                            <?php } ?>
                                        </optgroup>
                                        <?php
                                    }
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <?php
                $permissionL = null;
                if (!empty($leads_info->permission)) {
                    $permissionL = $leads_info->permission;
                }
                ?>
                <?= get_permission(2, 4, $assign_user, $permissionL, lang('assigned_to')); ?>


                <div class="form-group">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-sm btn-primary"></i> <?= lang('upload') ?></button>
                    </div>
                </div>
            </div>
    </div>
</div>
