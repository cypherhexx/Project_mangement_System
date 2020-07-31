<?= message_box('success'); ?>
<?= message_box('error'); ?>
<style type="text/css">
    .input-group-btn {
        width: 50% !important;
    }
</style>
<div class="panel panel-custom">
    <header class="panel-heading "><?= lang('tags') ?></header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped ">
                <thead>
                <tr>
                    <th><?= lang('name') ?></th>
                    <th><?= lang('action') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($all_method_info)) {
                    foreach ($all_method_info as $v_method_info) {
                        ?>
                        <tr id="tags_<?= $v_method_info->tag_id ?>">
                            <td>
                                <?php
                                $id = $this->uri->segment(5);
                                if (!empty($id) && $id == $v_method_info->tag_id) { ?>
                                <form method="post"
                                      action="<?= base_url() ?>admin/settings/tags/update_tags/<?php
                                      if (!empty($method_info)) {
                                          echo $method_info->tag_id;
                                      }
                                      ?>" class="form-horizontal">
                                    <div class="input-group">
                                        <input type="text" name="name" value="<?php
                                        if (!empty($method_info)) {
                                            echo $method_info->name;
                                        }
                                        ?>" class="form-control result" placeholder="<?= lang('name') ?>" required>
                                        <div class="input-group-btn">
                                            <button type="button"
                                                    style="margin-right:1px;<?= $method_info->style ?>"
                                                    class="btn btn-default me_name"><?php
                                                if (!empty($method_info)) {
                                                    echo $method_info->name;
                                                }
                                                ?></button>
                                            <input type="text" name="border" style="width: 25%"
                                                   class="btn btn-default colorborder"
                                                   value="<?= get_style($method_info->style, 'border') ?>">
                                            <input type="text" name="background" style="width: 25%"
                                                   class="btn btn-default colorbackground"
                                                   value="<?= get_style($method_info->style, 'background') ?>">
                                            <input type="text" name="color" style="width: 25%"
                                                   class="btn btn-default colorpickerinput"
                                                   value="<?= get_style($method_info->style, 'color') ?>">
                                        </div>
                                    </div>
                                    <?php } else {
                                        echo '<span class="label" style="' . $v_method_info->style . '">' . $v_method_info->name . '</span>';
                                    }
                                    ?>
                            </td>
                            <td>
                                <?php
                                $id = $this->uri->segment(5);
                                if (!empty($id) && $id == $v_method_info->tag_id) { ?>
                                    <?= btn_update() ?>
                                    </form>
                                    <?= btn_cancel('admin/settings/tags/') ?>
                                <?php } else { ?>
                                    <?= btn_edit('admin/settings/tags/edit_tags/' . $v_method_info->tag_id) ?>
                                    <?php echo ajax_anchor(base_url("admin/settings/delete_tags/" . $v_method_info->tag_id), "<i class='btn btn-xs btn-danger fa fa-trash-o'></i>", array("class" => "", "title" => lang('delete'), "data-fade-out-on-success" => "#tags_" . $v_method_info->tag_id)); ?>
                                <?php }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <form method="post" action="<?= base_url() ?>admin/settings/tags/update_tags/<?php
                if (!empty($method_info)) {
                    echo $method_info->tag_id;
                }
                ?>" class="form-horizontal">
                    <tr>
                        <td>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control result" required/>
                                <div class="input-group-btn">
                                    <button type="button"
                                            class="btn btn-default me_name"
                                            style="margin-right:1px"><?= lang('result') ?></button>
                                    <input type="text" name="border" style="width: 25%"
                                           class="btn btn-default colorborder" value="<?= lang('border') ?>">
                                    <input type="text" name="background" style="width: 25%"
                                           class="btn btn-default colorbackground" value="<?= lang('background') ?>">
                                    <input type="text" name="color" style="width: 25%"
                                           class="btn btn-default colorpickerinput" value="<?= lang('color') ?>">
                                </div>
                            </div>
                        </td>
                        <td><?= btn_add() ?></td>
                    </tr>
                </form>
                </tbody>
            </table>
        </div>
    </div>
</div>
<link href="<?php echo base_url() ?>assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.css"
      rel="stylesheet">
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
<script>
    $(function () {
        $(document).on("keyup", '.result', function () {
            $('.me_name').html($(this).val());
        });
        var sliders = {
            saturation: {
                maxLeft: 200,
                maxTop: 200
            },
            hue: {
                maxTop: 200
            },
            alpha: {
                maxTop: 200
            }
        };
        $('.colorborder').colorpicker({
            customClass: 'colorpicker-2x',
            align: 'left',
            sliders: sliders
        }).on('changeColor', function (e) {
            // $(this).attr('value', e.color);
            $('.me_name')
                .css('border', '1px solid' + e.color);
        });
        $('.colorbackground').colorpicker({
            customClass: 'colorpicker-2x',
            align: 'left',
            sliders: sliders
        }).on('changeColor', function (e) {
            // $(this).attr('value', e.color);
            $('.me_name')
                .css('background', e.color);
        });
        $('.colorpickerinput').colorpicker({
            customClass: 'colorpicker-2x',
            align: 'left',
            sliders: sliders
        }).on('changeColor', function (e) {
            // $(this).attr('value', e.color);
            $('.me_name')
                .css('color', e.color);
        });
    });
</script>