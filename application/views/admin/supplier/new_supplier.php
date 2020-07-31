<?php
echo message_box('success');
echo message_box('error');
$created = can_action('149', 'created');
$edited = can_action('149', 'edited');
?>
<div class="panel panel-custom">
    <header class="panel-heading ">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
        <?= $title ?></header>

    <?php
    if (!empty($created) || !empty($edited)) {
        ?>
        <form method="post" id="lead_statuss" action="<?= base_url() ?>admin/supplier/saved_supplier/inline"
              class="form-horizontal" data-parsley-validate="" novalidate="">
            <div class="form-group">
                <label class="col-lg-3 control-label"><?= lang('name') ?> <span
                            class="text-danger">*</span></label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" value="<?php
                    if (!empty($supplier_info)) {
                        echo $supplier_info->name;
                    }
                    ?>" name="name" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label"><?= lang('mobile') ?> <span
                            class="text-danger">*</span></label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" value="<?php
                    if (!empty($supplier_info)) {
                        echo $supplier_info->mobile;
                    }
                    ?>" name="mobile" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label"><?= lang('phone') ?></label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" value="<?php
                    if (!empty($supplier_info)) {
                        echo $supplier_info->phone;
                    }
                    ?>" name="phone">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label"><?= lang('email') ?> <span
                            class="text-danger">*</span></label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" value="<?php
                    if (!empty($supplier_info)) {
                        echo $supplier_info->email;
                    }
                    ?>" name="email" required="">
                </div>
            </div>
            <!-- End discount Fields -->
            <div class="form-group terms">
                <label class="col-lg-3 control-label"><?= lang('address') ?> </label>
                <div class="col-lg-5">
                        <textarea name="address" class="form-control"><?php
                            if (!empty($supplier_info)) {
                                echo $supplier_info->address;
                            }
                            ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label
                        class="col-lg-3 control-label"><?= lang('company_vat') ?></label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" value="<?php
                    if (!empty($supplier_info->vat)) {
                        echo $supplier_info->vat;
                    }
                    ?>" name="vat">
                </div>
            </div>
            <?php
            $permissionL = null;
            if (!empty($supplier_info->permission)) {
                $permissionL = $supplier_info->permission;
            }
            ?>
            <?= get_permission_modal(3, 9, $permission_user, $permissionL, ''); ?>
            <div class="modal-footer">
                <button type="submit"
                        class="btn btn-sm btn-primary"><?= lang('save') ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
            </div>
        </form>
    <?php } ?>
</div>
<script type="text/javascript">
    $(document).on("submit", "form", function (event) {
        var form = $(event.target);
        if (form.attr('action') == '<?= base_url('admin/supplier/saved_supplier/inline')?>') {
            event.preventDefault();
        }
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: form.serialize()
        }).done(function (response) {
            response = JSON.parse(response);
            if (response.status == 'success') {
                if (typeof (response.id) != 'undefined') {
                    var groups = $('select[name="supplier_id"]');
                    groups.prepend('<option selected value="' + response.id + '">' + response.name + '</option>');
                    var select2Instance = groups.data('select2');
                    var resetOptions = select2Instance.options.options;
                    groups.select2('destroy').select2(resetOptions)
                }
                toastr[response.status](response.message);
            }
            $('#myModal').modal('hide');
        }).fail(function () {
            alert('There was a problem with AJAX');
        });
    });
</script>