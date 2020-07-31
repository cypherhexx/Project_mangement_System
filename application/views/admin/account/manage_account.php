<?= message_box('success'); ?>
<?= message_box('error');
$created = can_action('36', 'created');
$edited = can_action('36', 'edited');
$deleted = can_action('36', 'deleted');
if (!empty($created) || !empty($edited)){
$currency = $this->db->where('code', config_item('default_currency'))->get('tbl_currencies')->row();
?>


<div class="nav-tabs-custom">
    <!-- Tabs within a box -->
    <ul class="nav nav-tabs">
        <li class="<?= $active == 1 ? 'active' : ''; ?>"><a href="#manage"
                                                            data-toggle="tab"><?= lang('manage_account') ?></a></li>
        <li class="<?= $active == 2 ? 'active' : ''; ?>"><a href="#create"
                                                            data-toggle="tab"><?= lang('new_account') ?></a></li>
    </ul>
    <div class="tab-content bg-white">
        <!-- ************** general *************-->
        <div class="tab-pane <?= $active == 1 ? 'active' : ''; ?>" id="manage">
            <?php } else { ?>
            <div class="panel panel-custom">
                <header class="panel-heading ">
                    <div class="panel-title"><strong><?= lang('manage_account') ?></strong></div>
                </header>
                <?php } ?>
                <div class="table-responsive">
                    <table class="table table-striped DataTables " id="DataTables" width="100%">
                        <thead>
                        <tr>
                            <th><?= lang('account') ?></th>
                            <th><?= lang('description') ?></th>
                            <th><?= lang('account_number') ?></th>
                            <th><?= lang('phone') ?></th>
                            <th><?= lang('balance') ?></th>
                            <?php $show_custom_fields = custom_form_table(21, null);
                            if (!empty($show_custom_fields)) {
                                foreach ($show_custom_fields as $c_label => $v_fields) {
                                    if (!empty($c_label)) {
                                        ?>
                                        <th><?= $c_label ?> </th>
                                    <?php }
                                }
                            }
                            ?>
                            <th class="col-options no-sort"><?= lang('action') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <script type="text/javascript">
                            list = base_url + "admin/account/accountList";
                        </script>
                    </table>

                </div>
            </div>
            <?php if (!empty($created) || !empty($edited)){ ?>
                <div class="tab-pane <?= $active == 2 ? 'active' : ''; ?>" id="create">
                    <form role="form" data-parsley-validate="" novalidate="" enctype="multipart/form-data" id="form"
                          action="<?php echo base_url(); ?>admin/account/save_account/<?php
                          if (!empty($account_info)) {
                              echo $account_info->account_id;
                          }
                          ?>" method="post" class="form-horizontal  ">

                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('account_name') ?> <span
                                        class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" value="<?php
                                if (!empty($account_info)) {
                                    echo $account_info->account_name;
                                }
                                ?>" name="account_name" required="">
                            </div>

                        </div>
                        <!-- End discount Fields -->
                        <div class="form-group terms">
                            <label class="col-lg-3 control-label"><?= lang('description') ?> </label>
                            <div class="col-lg-5">
                        <textarea name="description" class="form-control"><?php
                            if (!empty($account_info)) {
                                echo $account_info->description;
                            }
                            ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('initial_balance') ?> <span
                                        class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <input type="text" data-parsley-type="number" class="form-control" value="<?php
                                if (!empty($account_info)) {
                                    echo $account_info->balance;
                                }
                                ?>" name="balance" required="">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('account_number') ?></label>
                            <div class="col-lg-5">
                                <input type="text" data-parsley-type="number" class="form-control" value="<?php
                                if (!empty($account_info)) {
                                    echo $account_info->account_number;
                                }
                                ?>" name="account_number">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('contact_person') ?></label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" value="<?php
                                if (!empty($account_info)) {
                                    echo $account_info->contact_person;
                                }
                                ?>" name="contact_person">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('phone') ?></label>
                            <div class="col-lg-5">
                                <input type="text"  class="form-control" value="<?php
                                if (!empty($account_info)) {
                                    echo $account_info->contact_phone;
                                }
                                ?>" name="contact_phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('bank_details') ?></label>
                            <div class="col-lg-5">
                                <textarea name="bank_details" class="form-control"><?php
                                    if (!empty($account_info)) {
                                        echo $account_info->bank_details;
                                    }
                                    ?></textarea>
                            </div>
                        </div>
                        <?php
                        if (!empty($account_info)) {
                            $account_id = $account_info->account_id;
                            $permissionL = $account_info->permission;
                        } else {
                            $account_id = null;
                            $permissionL = null;
                        }
                        ?>
                        <?= custom_form_Fields(21, $account_id); ?>

                        <?= get_permission(3, 9, $permission_user, $permissionL, ''); ?>

                        <div class="btn-bottom-toolbar text-right">
                            <?php
                            if (!empty($account_info)) { ?>
                                <button type="submit"
                                        class="btn btn-sm btn-primary"><?= lang('updates') ?></button>
                                <button type="button" onclick="goBack()"
                                        class="btn btn-sm btn-danger"><?= lang('cancel') ?></button>
                            <?php } else {
                                ?>
                                <button type="submit"
                                        class="btn btn-sm btn-primary"><?= lang('create_acount') ?></button>
                            <?php }
                            ?>
                        </div>
                    </form>
                </div>
            <?php } else { ?>
        </div>
        <?php } ?>

    </div>
</div>