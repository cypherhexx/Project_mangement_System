<style type="text/css">
    .progress-bar-purple {
        background-color: #564aa3 !important
    }
</style>
<?= message_box('success'); ?>
<?= message_box('error');
$created = can_action('69', 'created');
$edited = can_action('69', 'edited');
$deleted = can_action('69', 'deleted');
if (!empty($created) || !empty($edited)){
$goal_type = $this->db->get('tbl_goal_type')->result();
$is_department_head = is_department_head();
if ($this->session->userdata('user_type') == 1 || !empty($is_department_head)) { ?>
    <div class="btn-group pull-right btn-with-tooltip-group filtered" data-toggle="tooltip"
         data-title="<?php echo lang('filter_by'); ?>">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter" aria-hidden="true"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-left group"
            style="width:300px;">
            <li class="filter_by"><a href="#"><?php echo lang('all'); ?></a></li>
            <li class="divider"></li>
            <?php if (count($goal_type) > 0) { ?>
                <?php foreach ($goal_type as $v_goal_type) {
                    ?>
                    <li class="filter_by" id="<?= $v_goal_type->goal_type_id ?>">
                        <a href="#"><?php echo lang($v_goal_type->type_name); ?></a>
                    </li>
                <?php }
                ?>
                <div class="clearfix"></div>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<div class="nav-tabs-custom">
    <!-- Tabs within a box -->
    <ul class="nav nav-tabs">
        <li class="<?= $active == 1 ? 'active' : ''; ?>"><a href="#manage"
                                                            data-toggle="tab"><?= lang('goal_tracking') ?></a></li>
        <li class="<?= $active == 2 ? 'active' : ''; ?>"><a href="#create"
                                                            data-toggle="tab"><?= lang('new_goal') ?></a></li>
    </ul>
    <div class="tab-content bg-white">
        <!-- ************** general *************-->
        <div class="tab-pane <?= $active == 1 ? 'active' : ''; ?>" id="manage">
            <?php } else { ?>
            <div class="panel panel-custom">
                <header class="panel-heading ">
                    <div class="panel-title"><strong><?= lang('goal_tracking') ?></strong></div>
                </header>
                <?php } ?>
                <div class="table-responsive">
                    <table class="table table-striped DataTables " id="DataTables" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?= lang('subject') ?></th>
                            <th><?= lang('type') ?></th>
                            <th><?= lang('achievement') ?></th>
                            <th><?= lang('start_date') ?></th>
                            <th><?= lang('end_date') ?></th>
                            <th class="col-options no-sort"><?= lang('action') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                list = base_url + "admin/goal_tracking/goal_trackingList";
                                $('.filtered > .dropdown-toggle').on('click', function () {
                                    if ($('.group').css('display') == 'block') {
                                        $('.group').css('display', 'none');
                                    } else {
                                        $('.group').css('display', 'block')
                                    }
                                });
                                $('.filter_by').on('click', function () {
                                    $('.filter_by').removeClass('active');
                                    $('.group').css('display', 'block');
                                    $(this).addClass('active');
                                    var filter_by = $(this).attr('id');
                                    if (filter_by) {
                                        filter_by = filter_by;
                                    } else {
                                        filter_by = '';
                                    }
                                    table_url(base_url + "admin/goal_tracking/goal_trackingList/" + filter_by);
                                });
                            });
                        </script>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if (!empty($created) || !empty($edited)){ ?>
                <div class="tab-pane <?= $active == 2 ? 'active' : ''; ?>" id="create">
                    <form role="form" enctype="multipart/form-data" id="form" data-parsley-validate="" novalidate=""
                          action="<?php echo base_url(); ?>admin/goal_tracking/save_goal_tracking/<?php
                          if (!empty($goal_info)) {
                              echo $goal_info->goal_tracking_id;
                          }
                          ?>" method="post" class="form-horizontal  ">
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('subject') ?> <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control" value="<?php
                                if (!empty($goal_info)) {
                                    echo $goal_info->subject;
                                }
                                ?>" name="subject" required="">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('goal') . ' ' . lang('type') ?> <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <select name="goal_type_id" class="form-control select_box" style="width: 100%"
                                        id="goal_type_id"
                                        required="">
                                    <?php
                                    $goal_type = $this->db->get('tbl_goal_type')->result();
                                    if (!empty($goal_type)) {
                                        foreach ($goal_type as $v_goal_type) {
                                            ?>
                                            <option
                                                value="<?= $v_goal_type->goal_type_id ?>" <?php
                                            if (!empty($goal_info->goal_type_id)) {
                                                echo $v_goal_type->goal_type_id == $goal_info->goal_type_id ? 'selected' : '';
                                            }
                                            ?>><?= lang($v_goal_type->type_name) ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-group " id="account"
                             style="<?php if (!empty($goal_info->goal_type_id) && $goal_info->goal_type_id == 2 || !empty($goal_info->goal_type_id) && $goal_info->goal_type_id == 4) {
                                 echo 'display:block';
                             } else {
                                 echo 'display:none';
                             }; ?>">
                            <label class="col-lg-3 control-label mt-lg"><?= lang('account') ?> <span
                                    class="text-danger">*</span> </label>
                            <div class="col-lg-5 mt-lg">
                                <select class="form-control select_box" style="width: 100%" name="account_id"
                                        id="account_id"
                                    <?php if (empty($goal_info->account_id)) {
                                        echo 'disabled';
                                    }; ?> >
                                    <?php
                                    $account_info = $this->items_model->get_permission('tbl_accounts');

                                    if (!empty($account_info)) {
                                        foreach ($account_info as $v_account) {
                                            ?>
                                            <option value="<?= $v_account->account_id ?>"
                                                <?php
                                                if (!empty($goal_info->account_id)) {
                                                    echo $goal_info->account_id == $v_account->account_id ? 'selected' : '';
                                                }
                                                ?>
                                            ><?= $v_account->account_name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('achievement') ?> <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <input type="number" class="form-control" value="<?php
                                if (!empty($goal_info)) {
                                    echo $goal_info->achievement;
                                }
                                ?>" name="achievement" required="">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('start_date') ?> <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input type="text" name="start_date" class="form-control start_date"
                                           value="<?php
                                           if (!empty($goal_info->start_date)) {
                                               echo $goal_info->start_date;
                                           } else {
                                               echo date('Y-m-d');
                                           }
                                           ?>" data-date-format="<?= config_item('date_picker_format'); ?>">
                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-calendar"></i></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= lang('end_date') ?> <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <input type="text" name="end_date" class="form-control end_date"
                                           value="<?php
                                           if (!empty($goal_info->end_date)) {
                                               echo $goal_info->end_date;
                                           } else {
                                               echo date('Y-m-d', strtotime("+1 days"));
                                           }
                                           ?>" data-date-format="<?= config_item('date_picker_format'); ?>">
                                    <div class="input-group-addon">
                                        <a href="#"><i class="fa fa-calendar"></i></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- End discount Fields -->
                        <div class="form-group terms">
                            <label class="col-lg-3 control-label"><?= lang('description') ?> </label>
                            <div class="col-lg-5">
                        <textarea name="description" class="form-control"><?php
                            if (!empty($goal_info)) {
                                echo $goal_info->description;
                            }
                            ?></textarea>
                            </div>
                        </div>

                        <?php
                        $permissionL = null;
                        if (!empty($goal_info->permission)) {
                            $permissionL = $goal_info->permission;
                        }
                        ?>
                        <?= get_permission(3, 6, $permission_user, $permissionL, ''); ?>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"></label>
                            <div class="col-lg-6">
                                <div class="checkbox c-checkbox">
                                    <label class="needsclick">
                                        <input type="checkbox" <?php
                                        if (!empty($goal_info->notify_goal_achive) && $goal_info->notify_goal_achive == 'on') {
                                            echo "checked=\"checked\"";
                                        }
                                        ?> name="notify_goal_achive">
                                        <span class="fa fa-check"></span>
                                    </label>
                                    <?= lang('notify_goal_achive') ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"></label>
                            <div class="col-lg-6">
                                <div class="checkbox c-checkbox">
                                    <label class="needsclick">
                                        <input type="checkbox" <?php
                                        if (!empty($goal_info->notify_goal_not_achive) && $goal_info->notify_goal_not_achive == 'on') {
                                            echo "checked=\"checked\"";
                                        }
                                        ?> name="notify_goal_not_achive">
                                        <span class="fa fa-check"></span>
                                    </label>
                                    <?= lang('notify_goal_not_achive') ?>
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-toolbar text-right">
                            <?php
                            if (!empty($goal_info)) { ?>
                                <button type="submit"
                                        class="btn btn-sm btn-primary"><?= lang('updates') ?></button>
                                <button type="button" onclick="goBack()"
                                        class="btn btn-sm btn-danger"><?= lang('cancel') ?></button>
                            <?php } else {
                                ?>
                                <button type="submit"
                                        class="btn btn-sm btn-primary"><?= lang('save') ?></button>
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

<!-- end -->