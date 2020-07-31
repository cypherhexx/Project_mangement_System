<?php echo message_box('success') ?>
<div class="row">
    <!-- Start Form -->
    <div class="col-lg-12">
        <form action="<?php echo base_url() ?>admin/settings/save_transactions" enctype="multipart/form-data"
              class="form-horizontal" method="post">
            <div class="panel panel-custom">
                <header class="panel-heading"><?= lang('transactions') . ' ' . lang('settings') ?></header>
                <div class="panel-body">
                    <input type="hidden" name="settings" value="<?= $load_setting ?>">

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?= lang('deposit_prefix') ?> <span
                                    class="text-danger">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" name="deposit_prefix" class="form-control" style="width:260px"
                                   value="<?= config_item('deposit_prefix') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?= lang('deposit_start_no') ?> <span
                                    class="text-danger">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" name="deposit_start_no" class="form-control" style="width:260px"
                                   value="<?= config_item('deposit_start_no') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?= lang('deposit') . ' ' . lang('number_format') ?></label>
                        <div class="col-lg-5">
                            <input type="text" name="deposit_number_format" class="form-control" style="width:260px"
                                   value="<?php
                                   if (empty(config_item('deposit_number_format'))) {
                                       echo '[' . config_item('deposit_prefix') . ']' . '[yyyy][mm][dd][number]';
                                   } else {
                                       echo config_item('deposit_number_format');
                                   } ?>">
                            <small>ex [<?= config_item('deposit_prefix') ?>] = <?= lang('deposit_prefix') ?>,[yyyy] =
                                'Current Year (<?= date('Y') ?>)'[yy] ='Current Year (<?= date('y') ?>)',[mm] =
                                'Current Month(<?= date('M') ?>)',[m] =
                                'Current Month(<?= date('m') ?>)',[dd] = 'Current Date (<?= date('d') ?>)',[number] =
                                'Invoice Number (<?= sprintf('%04d', config_item('deposit_start_no')) ?>)'
                            </small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?= lang('expense_prefix') ?> <span
                                    class="text-danger">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" name="expense_prefix" class="form-control" style="width:260px"
                                   value="<?= config_item('expense_prefix') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?= lang('expense_start_no') ?> <span
                                    class="text-danger">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" name="expense_start_no" class="form-control" style="width:260px"
                                   value="<?= config_item('expense_start_no') ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?= lang('expense') . ' ' . lang('number_format') ?></label>
                        <div class="col-lg-5">
                            <input type="text" name="expense_number_format" class="form-control" style="width:260px"
                                   value="<?php
                                   if (empty(config_item('expense_number_format'))) {
                                       echo '[' . config_item('expense_prefix') . ']' . '[yyyy][mm][dd][number]';
                                   } else {
                                       echo config_item('expense_number_format');
                                   } ?>">
                            <small>ex [<?= config_item('expense_prefix') ?>] = <?= lang('expense_prefix') ?>,[yyyy] =
                                'Current Year (<?= date('Y') ?>)'[yy] ='Current Year (<?= date('y') ?>)',[mm] =
                                'Current Month(<?= date('M') ?>)',[m] =
                                'Current Month(<?= date('m') ?>)',[dd] = 'Current Date (<?= date('d') ?>)',[number] =
                                'Invoice Number (<?= sprintf('%04d', config_item('expense_start_no')) ?>)'
                            </small>
                        </div>
                    </div>


                </div>
                <div class="form-group">
                    <div class="col-lg-3 control-label"></div>
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-sm btn-primary"><?= lang('save_changes') ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- End Form -->
</div>
