<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $form->name; ?></title>
    <!-- =============== VENDOR STYLES ===============-->
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/font-awesome.min.css">
    <!-- Toastr-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/toastr.min.css">
    <!-- =============== BOOTSTRAP STYLES ===============-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" id="bscss">
    <!-- =============== APP STYLES ===============-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.min.css" id="maincss">

    <!-- JQUERY-->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/dist/jquery.min.js"></script>

    <?php if (config_item('recaptcha_secret_key') != '' && config_item('recaptcha_site_key') != '') { ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php } ?>


</head>
<body class="<?php echo $form->form_key; ?>">
<div class="mt-lg">

    <div class="">
        <div class="<?php if ($this->input->get('col')) {
            echo $this->input->get('col');
        } else {
            echo 'col-md-12';
        } ?>">
            <?= message_box('success'); ?>
            <?= message_box('error'); ?>
            <div class="error_login">
                <?php
                $validation_errors = validation_errors();
                if (!empty($validation_errors)) { ?>
                    <div class="alert alert-danger"><?php echo $validation_errors; ?></div>
                    <?php
                }
                $error = $this->session->flashdata('error');
                $success = $this->session->flashdata('success');
                if (!empty($error)) {
                    ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>
                <?php if (!empty($success)) { ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php } ?>
            </div>
            <?php echo form_open_multipart($this->uri->uri_string(), array('id' => $form->form_key, 'class' => 'disable-on-submit')); ?>
            <?php echo form_hidden('key', $form->form_key); ?>
            <div class="row">
                <?php foreach ($form_fields as $field) {
                    render_form_builder_field($field);
                } ?>
                <?php if (config_item('recaptcha_secret_key') != '' && config_item('recaptcha_site_key') != '' && $form->form_recaptcha == 1){ ?>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="<?php echo config_item('recaptcha_site_key'); ?>"></div>
                        <div id="recaptcha_response_field" class="text-danger"></div>
                    </div>
                    <?php } ?>

                    <div class="clearfix"></div>
                    <div class="text-left col-md-12 submit-btn-wrapper">
                        <button class="btn btn-success" id="form_submit"
                                type="submit"><?php echo $form->submit_btn_text; ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <!-- =============== Toastr ===============-->
    <script src="<?= base_url() ?>assets/js/toastr.min.js"></script>
    <!-- BOOTSTRAP-->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
