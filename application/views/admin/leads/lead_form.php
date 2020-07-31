<div class="panel panel-custom">
    <?php if (!isset($form)) { ?>
        <div class="panel-heading">
            <h4 class="panel-title"><?= lang('form_builder_create_form_first') ?></h4>
        </div>
    <?php } ?>
    <?php echo form_open('admin/leads/save_form_data/row', array('id' => 'form_info', 'class' => 'form-horizontal')); ?>
    <?php if (isset($form)) {
        echo form_hidden('form_id', $form->lead_form_id);
    } ?>
    <div class="panel-body">
        <?php if (isset($form)) { ?>
            <ul class="nav nav-tabs  navbar-custom-nav" role="tablist">
                <li role="presentation" class="active">
                    <a href="#tab_form_build" aria-controls="tab_form_build" role="tab"
                       data-toggle="tab">
                        <?php echo lang('form_builder'); ?>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#tab_form_information" aria-controls="tab_form_information" role="tab"
                       data-toggle="tab">
                        <?php echo lang('form_information'); ?>
                    </a>
                </li>
            </ul>
        <?php } ?>
        <div class="tab-content">
            <?php if (isset($form)) { ?>
                <div role="tabpanel" class="tab-pane active" id="tab_form_build">
                    <div id="build-wrap"></div>
                </div>
            <?php } ?>
            <div role="tabpanel" class="tab-pane <?php if (!isset($form)) {
                echo ' active';
            } ?>" id="tab_form_information">

                <?php if (isset($form)) { ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading"><?php echo lang('form_integration_code_help'); ?></div>
                        <div class="pl pr pb">
                            <div class="label label-default mb-lg">
                                <a class="mb-lg" href="<?php echo site_url('forms/leads/' . $form->form_key); ?>"
                                   target="_blank">
                                    <?php echo site_url('forms/leads/' . $form->form_key); ?>
                                </a>
                            </div>
                            <textarea class="form-control" id="foo" rows="2"><iframe width="600" height="850" src="<?php echo site_url('forms/leads/' . $form->form_key); ?>" frameborder="0" allowfullscreen></iframe></textarea>
                        </div>
                    </div>
                    <script type="text/javascript">
                        var textBox = document.getElementById("foo");
                        textBox.onfocus = function () {
                            textBox.select();
                            // Work around Chrome's little problem
                            textBox.onmouseup = function () {
                                // Prevent further mouseup intervention
                                textBox.onmouseup = null;
                                return false;
                            };
                        };
                    </script>
                <?php } ?>

                <div class="form-group">
                    <label class="col-lg-2 control-label"><?= lang('form') . ' ' . lang('name') ?></label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" value="<?php
                        if (!empty($form)) {
                            echo $form->form_name;
                        }
                        ?>" name="form_name" required="">
                    </div>

                    <label class="col-lg-2 control-label"><?= lang('lead_status') ?> </label>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <select name="lead_status_id" class="form-control select_box"
                                    style="width: 100%"
                                    required="">
                                <?php

                                if (!empty($status_info)) {
                                    foreach ($status_info as $type => $v_leads_status) {
                                        if (!empty($v_leads_status)) {
                                            ?>
                                            <optgroup label="<?= lang($type) ?>">
                                                <?php foreach ($v_leads_status as $v_l_status) { ?>
                                                    <option
                                                            value="<?= $v_l_status->lead_status_id ?>" <?php
                                                    if (!empty($form->lead_status_id)) {
                                                        echo $v_l_status->lead_status_id == $form->lead_status_id ? 'selected' : '';
                                                    }
                                                    ?>><?= $v_l_status->lead_status ?></option>
                                                <?php } ?>
                                            </optgroup>
                                            <?php
                                        }
                                    }
                                }
                                $created = can_action('127', 'created');
                                ?>
                            </select>
                            <?php if (!empty($created)) { ?>
                                <div class="input-group-addon"
                                     title="<?= lang('new') . ' ' . lang('lead_status') ?>"
                                     data-toggle="tooltip" data-placement="top">
                                    <a data-toggle="modal" data-target="#myModal"
                                       href="<?= base_url() ?>admin/leads/lead_status"><i
                                                class="fa fa-plus"></i></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label"><?= lang('language') ?> </label>
                    <div class="col-lg-4">
                        <select name="language" class="form-control select_box"
                                style="width: 100%">
                            <?php

                            foreach ($languages as $lang) : ?>
                                <option
                                        value="<?= $lang->name ?>"<?php
                                if (!empty($form->language) && $form->language == $lang->name) {
                                    echo 'selected';
                                } elseif (empty($form->language) && $this->config->item('language') == $lang->name) {
                                    echo 'selected';
                                } ?>
                                ><?= ucfirst($lang->name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <label class="col-lg-2 control-label"><?= lang('lead_source') ?> </label>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <select name="lead_source_id" class="form-control select_box"
                                    style="width: 100%"
                                    required="">
                                <?php
                                $lead_source_info = $this->db->order_by('lead_source_id', 'DESC')->get('tbl_lead_source')->result();
                                if (!empty($lead_source_info)) {
                                    foreach ($lead_source_info as $v_lead_source) {
                                        ?>
                                        <option
                                                value="<?= $v_lead_source->lead_source_id ?>" <?= (!empty($form) && $form->lead_source_id == $v_lead_source->lead_source_id ? 'selected' : '') ?>><?= $v_lead_source->lead_source ?></option>
                                        <?php
                                    }
                                }
                                $_created = can_action('128', 'created');
                                ?>
                            </select>
                            <?php if (!empty($_created)) { ?>
                                <div class="input-group-addon"
                                     title="<?= lang('new') . ' ' . lang('lead_source') ?>"
                                     data-toggle="tooltip" data-placement="top">
                                    <a data-toggle="modal" data-target="#myModal"
                                       href="<?= base_url() ?>admin/leads/lead_source"><i
                                                class="fa fa-plus"></i></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                if (config_item('recaptcha_secret_key') != '' && config_item('recaptcha_site_key') != '') { ?>
                    <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo lang('form') . ' ' . lang('recaptcha'); ?></label>
                        <div class="col-lg-4">
                            <input data-toggle="toggle" name="form_recaptcha"
                                   value="1" <?php
                            if (!empty($form) && $form->form_recaptcha == 1) {
                                echo 'checked';
                            }
                            ?> data-on="<?= lang('yes') ?>" data-off="<?= lang('no') ?>"
                                   data-onstyle="success"
                                   data-offstyle="danger" type="checkbox">
                        </div>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <label class="col-lg-2 control-label"><?= lang('submit_btn_text') ?> </label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" value="<?php
                        if (!empty($form)) {
                            echo $form->submit_btn_text;
                        }
                        ?>" name="submit_btn_text" required="">
                    </div>

                    <label class="col-lg-2 control-label"><?= lang('submit_btn_msg') ?> </label>
                    <div class="col-lg-4">
                        <textarea name="submit_btn_msg" class="form-control"><?php
                            if (!empty($form)) {
                                echo $form->submit_btn_msg;
                            }
                            ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label"></label>
                    <div class="col-lg-4">
                        <label class="c-checkbox">
                            <input name="allow_duplicate" id="showhide" <?php
                            if (!empty($form) && $form->allow_duplicate == 1) {
                                echo 'checked';
                            } elseif (empty($form)) {
                                echo 'checked';
                            }
                            ?> type="checkbox" value="1">
                            <span class="fa fa-check"></span></label>
                        <strong><?= lang('allow_duplicate_leads') ?></strong>
                    </div>

                    <div class="" id="shresult" style="display:
                    <?php
                    if (!empty($form) && $form->allow_duplicate != 1) {
                        echo 'block';
                    } else {
                        echo 'none';
                    } ?>
                            ">
                        <label class="col-lg-2 control-label"><?= lang('track_duplicate_field') ?> </label>
                        <div class="col-lg-4">
                            <select name="track_duplicate_field" class="form-control select_box"
                                    style="width: 100%">
                                <option value=""></option>
                                <?php foreach ($db_fields as $field) {
                                    ?>
                                    <option value="<?php echo $field->name; ?>"<?php if (isset($form) && $form->track_duplicate_field == $field->name) {
                                        echo ' selected';
                                    } ?>><?php echo $field->label; ?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>
                    <div class=""">
                        <label class="col-lg-2 control-label"> </label>
                        <div class="col-lg-4">
                            <label class="c-checkbox">
                                <input name="notify_lead_imported" <?php
                                if (!empty($form) && $form->notify_lead_imported == 1) {
                                    echo 'checked';
                                } elseif (empty($form)) {
                                    echo 'checked';
                                }
                                ?> type="checkbox" value="1">
                                <span class="fa fa-check"></span></label>
                            <strong><?= lang('notify_lead_imported') ?></strong>

                        </div>
                    </div>
                </div>



                <?php
                $permissionL = null;
                if (!empty($form->permission)) {
                    $permissionL = $form->permission;
                }
                ?>
                <?= get_permission(2, 4, $assign_user, $permissionL, lang('assigned_to')); ?>

                <div class="btn-bottom-toolbar text-right">
                    <button type="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                </div>
                <?php
                echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-u.js"></script>
<script src="<?php echo base_url('plugins/formbuilder/form-builder.min.js'); ?>"></script>

<script>
    var buildWrap = document.getElementById('build-wrap');
    var formData = <?php echo json_encode($formData); ?>;

    if (formData.length) {
        // If user paste with styling eq from some editor word and the Codeigniter XSS feature remove and apply xss=remove, may break the json.
        formData = formData.replace(/=\\/gm, "=''");
    }
</script>
<?php $this->load->view('admin/leads/_form_js_formatter'); ?>
<script>
    $(function () {
        $('body').on('copy paste', 'input', function (e) {
            e.preventDefault();
        });

        $('body').on('blur', '.form-field.editing', function () {
            $.Shortcuts.start();
        });

        $('body').on('focus', '.form-field.editing', function () {
            $.Shortcuts.stop();
        });

        var formBuilder = $(buildWrap).formBuilder(fbOptions);


        setTimeout(function () {
            $(".form-builder-save").wrap("<div class='btn-bottom-toolbar text-right'></div>");
            $btnToolbar = $('body').find('#tab_form_build .btn-bottom-toolbar');
            $btnToolbar = $('#tab_form_build').append($btnToolbar);
            $btnToolbar.find('.btn').addClass('btn-info');
        }, 100);

        $('body').on('click', '.save_form_data', function () {
            $.post(base_url + 'admin/leads/save_form_data', {
                formData: formBuilder.formData,
                form_id: $('input[name="form_id"]').val()
            }).done(function (response) {
                response = JSON.parse(response);
                if (response.success == true) {
                    toastr['success'](response.message);
                }
            });
        });


    });

</script>