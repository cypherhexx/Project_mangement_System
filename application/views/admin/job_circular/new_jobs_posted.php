<div class="panel panel-custom">
    <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                class="sr-only">Close</span></button>
        <h4 class="modal-title"
            id="myModalLabel"><?= lang('new') . ' ' . lang('jobs_posted') ?></h4>
    </div>
    <div class="modal-body wrap-modal wrap">
        <form id="form" role="form" enctype="multipart/form-data" data-parsley-validate="" novalidate=""
              action="<?php echo base_url() ?>admin/job_circular/save_job_posted/<?php
              if (!empty($job_posted->job_circular_id)) {
                  echo $job_posted->job_circular_id;
              }
              ?>" method="post" class="form-horizontal form-groups-bordered">
            <div class="form-group" id="border-none">
                <label for="field-1" class="col-sm-3 control-label"><?= lang('job_title') ?><span
                        class="required"> *</span></label>
                <div class="col-sm-8">
                    <input type="text" name="job_title" value="<?php
                    if (!empty($job_posted->job_title)) {
                        echo $job_posted->job_title;
                    }
                    ?>" class="form-control" required="1" placeholder="<?= lang('enter') . ' ' . lang('job_title') ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('designation') ?>
                    <span class="required">*</span></label>
                <div class="col-sm-5">
                    <select name="designations_id" class="form-control select_box" style="width:100%"
                            required>
                        <option value=""><?= lang('select') . ' ' . lang('designation') ?></option>
                        <?php if (!empty($all_department_info)): foreach ($all_department_info as $dept_name => $v_department_info) : ?>
                            <?php if (!empty($v_department_info)):
                                if (!empty($all_dept_info[$dept_name]->deptname)) {
                                    $deptname = $all_dept_info[$dept_name]->deptname;
                                } else {
                                    $deptname = lang('undefined_department');
                                }
                                ?>
                                <optgroup label="<?php echo $deptname; ?>">
                                    <?php foreach ($v_department_info as $designation) : ?>
                                        <option
                                            value="<?php echo $designation->designations_id; ?>"
                                            <?php
                                            if (!empty($job_posted->designations_id)) {
                                                echo $designation->designations_id == $job_posted->designations_id ? 'selected' : '';
                                            }
                                            ?>><?php echo $designation->designations ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="form-group" id="border-none">
                <label for="field-1" class="col-sm-3 control-label"><?= lang('employment_type') ?><span
                        class="required"> *</span></label>
                <div class="col-sm-5">
                    <select class="form-control" name="employment_type">
                        <option <?= (!empty($job_posted->employment_type) && $job_posted->employment_type == 'contractual' ? 'selected' : '') ?>
                            value="contractual"><?= lang('contractual') ?></option>
                        <option <?= (!empty($job_posted->employment_type) && $job_posted->employment_type == 'full_time' ? 'selected' : '') ?>
                            value="full_time"><?= lang('full_time') ?></option>
                        <option <?= (!empty($job_posted->employment_type) && $job_posted->employment_type == 'part_time' ? 'selected' : '') ?>
                            value="part_time"><?= lang('part_time') ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group" id="border-none">
                <label for="field-1" class="col-sm-3 control-label"><?= lang('experience') ?><span
                        class="required"> *</span></label>
                <div class="col-sm-5">
                    <input type="text" name="experience" value="<?php
                    if (!empty($job_posted->experience)) {
                        echo $job_posted->experience;
                    }
                    ?>" class="form-control" required="1" placeholder="<?= lang('experience_placeholder') ?>">
                </div>
            </div>
            <div class="form-group" id="border-none">
                <label for="field-1" class="col-sm-3 control-label"><?= lang('age') ?><span
                        class="required"> *</span></label>
                <div class="col-sm-5">
                    <input type="text" name="age" value="<?php
                    if (!empty($job_posted->age)) {
                        echo $job_posted->age;
                    }
                    ?>" class="form-control" required="1" placeholder="<?= lang('age_placeholder') ?>">
                </div>
            </div>
            <div class="form-group" id="border-none">
                <label for="field-1" class="col-sm-3 control-label"><?= lang('salary_range') ?><span
                        class="required"> *</span></label>
                <div class="col-sm-5">
                    <input type="text" name="salary_range" value="<?php
                    if (!empty($job_posted->salary_range)) {
                        echo $job_posted->salary_range;
                    }
                    ?>" class="form-control" required="1" placeholder="<?= lang('salary_range_placeholder') ?>">
                </div>
            </div>
            <div class="form-group" id="border-none">
                <label for="field-1" class="col-sm-3 control-label"><?= lang('vacancy_no') ?><span
                        class="required"> *</span></label>
                <div class="col-sm-5">
                    <input type="number" name="vacancy_no" value="<?php
                    if (!empty($job_posted->vacancy_no)) {
                        echo $job_posted->vacancy_no;
                    }
                    ?>" class="form-control" required="1" placeholder="<?= lang('enter') . ' ' . lang('vacancy_no') ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('posted_date') ?> <span
                        class="required"> *</span></label>
                <div class="col-sm-5">
                    <div class="input-group ">
                        <input type="text" required value="<?php
                        if (!empty($job_posted->posted_date)) {
                            echo $job_posted->posted_date;
                        }
                        ?>" class="form-control datepicker" name="posted_date">

                        <div class="input-group-addon">
                            <a href="#"><i class="fa fa-calendar"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?= lang('last_date_to_apply') ?> <span
                        class="required"> *</span></label>
                <div class="col-sm-5">
                    <div class="input-group ">
                        <input type="text" required value="<?php
                        if (!empty($job_posted->last_date)) {
                            echo $job_posted->last_date;
                        }
                        ?>" class="form-control datepicker" name="last_date">

                        <div class="input-group-addon">
                            <a href="#"><i class="fa fa-calendar"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($job_posted)) {
                $job_circular_id = $job_posted->job_circular_id;
            } else {
                $job_circular_id = null;
            }
            ?>
            <?= custom_form_Fields(14, $job_circular_id); ?>
            <div class="form-group" id="border-none">
                <label for="field-1" class="col-sm-3 control-label"><?= lang('description') ?><span
                        class="required"> *</span></label>
                <div class="col-sm-8">
                                    <textarea class="form-control textarea_2" name="description"><?php
                                        if (!empty($job_posted->description)) {
                                            echo $job_posted->description;
                                        }
                                        ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="field-1" class="col-sm-3 control-label"><?= lang('status') ?></label>

                <div class="col-sm-8">
                    <div class="col-sm-4 row">
                        <div class="checkbox-inline c-checkbox">
                            <label>
                                <input <?= (!empty($job_posted->status) && $job_posted->status == 'published' || empty($job_posted) ? 'checked' : ''); ?>
                                    class="select_one" type="checkbox" name="status" value="published">
                                <span class="fa fa-check"></span> <?= lang('published') ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="checkbox-inline c-checkbox">
                            <label>
                                <input <?= (!empty($job_posted->status) && $job_posted->status == 'unpublished' ? 'checked' : ''); ?>
                                    class="select_one" type="checkbox" name="status" value="unpublished">
                                <span class="fa fa-check"></span> <?= lang('unpublished') ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $permissionL = null;
            if (!empty($job_posted->permission)) {
                $permissionL = $job_posted->permission;
            }
            ?>
            <?= get_permission_modal(3, 9, $assign_user, $permissionL, lang('assigned_to')); ?>


            <div class="form-group">
                <div class="col-sm-3"></div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary btn-block"><?= lang('save') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>



