<?php
echo message_box('success');
echo message_box('error');
$created = can_action('125', 'created');
$edited = can_action('125', 'edited');
?>
<div class="panel panel-custom">
    <header class="panel-heading ">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
        <?= lang('new_account') ?>
    </header>
    <?php if (!empty($created) || !empty($edited)) { ?>
    <form role="form" data-parsley-validate="" novalidate="" enctype="multipart/form-data" id="saved_account"
          action="<?php echo base_url(); ?>admin/account/saved_account" method="post" class="form-horizontal  ">
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
                <input type="text" class="form-control" value="<?php
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

        <?= get_permission_modal(3, 9, $permission_user, $permissionL, ''); ?>
        <div class="form-group mt">
            <label class="col-lg-3"></label>
            <div class="col-lg-3">
                <button type="submit"
                        class="btn btn-sm btn-primary"><?= lang('save') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
        <?php } ?>
</div>

<script type="text/javascript">
    $(document).on("submit", "form", function (event) {
        var form = $(event.target);
        var id = form.attr('id');
        if (form.attr('action') == '<?= base_url('admin/account/saved_account')?>' || form.attr('action') == '<?= base_url('admin/settings/update_payment_method')?>' || form.attr('action') == '<?= base_url('admin/transactions/update_categories/income')?>' || form.attr('action') == '<?= base_url('admin/transactions/update_categories/expense')?>') {
            event.preventDefault();
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize()
            }).done(function (response) {
                response = JSON.parse(response);
                if (response.status == 'success') {
                    if (id == 'saved_account') {
                        if (typeof (response.id) != 'undefined') {
                            var groups = $('select[name="account_id"]');
                            groups.prepend('<option selected value="' + response.id + '">' + response.account_name + '</option>');
                            var select2Instance = groups.data('select2');
                            var resetOptions = select2Instance.options.options;
                            groups.select2('destroy').select2(resetOptions)
                        }
                    } else if (id == 'transaction_modal') {
                        if (typeof (response.id) != 'undefined') {
                            var groups = $('select[name="category_id"]');
                            groups.prepend('<option selected value="' + response.id + '">' + response.categories + '</option>');
                            var select2Instance = groups.data('select2');
                            var resetOptions = select2Instance.options.options;
                            groups.select2('destroy').select2(resetOptions)
                        }

                    } else {
                        if (typeof (response.id) != 'undefined') {
                            var groups = $('select[name="payment_methods_id"]');
                            groups.prepend('<option selected value="' + response.id + '">' + response.method_name + '</option>');
                            var select2Instance = groups.data('select2');
                            var resetOptions = select2Instance.options.options;
                            groups.select2('destroy').select2(resetOptions)
                        }
                    }
                    toastr[response.status](response.message);
                }
                $('#myModal').modal('hide');
            }).fail(function () {
                console.log('There was a problem with AJAX')
            });
        }
    });
</script>