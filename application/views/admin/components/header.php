<?php
$user_id = $this->session->userdata('user_id');
$profile_info = $this->db->where('user_id', $user_id)->get('tbl_account_details')->row();
$user_info = $this->db->where('user_id', $user_id)->get('tbl_users')->row();
$languages = $this->db->where('active', 1)->order_by('name', 'ASC')->get('tbl_languages')->result();

?>

<header class="topnavbar-wrapper">
    <!-- START Top Navbar-->
    <nav role="navigation" class="navbar topnavbar">
        <!-- START navbar header-->
        <?php $display = config_item('logo_or_icon'); ?>
        <div class="navbar-header">
            <?php if ($display == 'logo' || $display == 'logo_title') { ?>
                <a href="#/" class="navbar-brand">
                    <div class="brand-logo">
                        <img style="width: 100%;max-height: 42px;"
                             src="<?= base_url() . config_item('company_logo') ?>" alt="App Logo"
                             class="img-responsive">
                    </div>
                    <div class="brand-logo-collapsed">
                        <img style="width: 100%;height: 48px;border-radius: 50px"
                             src="<?= base_url() . config_item('company_logo') ?>" alt="App Logo"
                             class="img-responsive">
                    </div>
                </a>
            <?php }
            ?>
        </div>
        <!-- END navbar header-->
        <!-- START Nav wrapper-->
        <div class="nav-wrapper">
            <!-- START Left navbar-->
            <ul class="nav navbar-nav">
                <li>
                    <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                    <a href="#" data-toggle-state="aside-collapsed" class="hidden-xs">
                        <em class="fa fa-navicon"></em>
                    </a>
                    <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                    <a href="#" data-toggle-state="aside-toggled" data-no-persist="true"
                       class="visible-xs sidebar-toggle">
                        <em class="fa fa-navicon"></em>
                    </a>
                </li>
                <!-- END User avatar toggle-->
                <!-- START lock screen-->
                <li class="hidden-xs">
                    <a href="" class="text-center" style="vertical-align: middle;font-size: 20px;"><?php
                        if ($display == 'logo_title' || $display == 'icon_title') {
                            if (config_item('website_name') == '') {
                                echo config_item('company_name');
                            } else {
                                echo config_item('website_name');
                            }
                        }
                        ?></a>
                </li>
                <!-- END lock screen-->
            </ul>
            <!-- END Left navbar-->
            <!-- START Right Navbar-->
            <ul class="nav navbar-nav navbar-right">

                <!-- Search icon-->
                <li>
                    <a href="#" data-search-open="">
                        <em class="icon-magnifier"></em>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                    <ul class="dropdown-menu animated zoomIn">
                        <li>
                            <a href="<?= base_url('admin/client/manage_client/new') ?>">
                                <?= lang('new') . ' ' . lang('client') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/user/user_list/edit_user/') ?>">
                                <?= lang('new') . ' ' . lang('employee') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/payroll/make_payment') ?>">
                                <?= lang('payment') . ' ' . lang('salary') ?>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target="#myModal"
                               href="<?= base_url('admin/holiday/add_holiday') ?>">
                                <?= lang('new') . ' ' . lang('holiday') ?>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target="#myModal"
                               href="<?= base_url('admin/utilities/add_overtime') ?>">
                                <?= lang('new') . ' ' . lang('overtime') ?>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target="#myModal"
                               href="<?= base_url('admin/payroll/add_advance_salary') ?>">
                                <?= lang('new') . ' ' . lang('advance_salary') ?>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target="#myModal_extra_lg"
                               href="<?= base_url('admin/leave_management/apply_leave') ?>">
                                <?= lang('apply') . ' ' . lang('leave') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/projects/index/new') ?>">
                                <?= lang('new') . ' ' . lang('project') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/tasks/all_task/new') ?>">
                                <?= lang('new') . ' ' . lang('tasks') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/bugs/index/new') ?>">
                                <?= lang('new') . ' ' . lang('bugs') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/opportunities/index/new') ?>">
                                <?= lang('new') . ' ' . lang('opportunities') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/leads/index/new') ?>">
                                <?= lang('new') . ' ' . lang('leads') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/purchase/index/new') ?>">
                                <?= lang('new') . ' ' . lang('purchase') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/invoice/manage_invoice/create_invoice') ?>">
                                <?= lang('new') . ' ' . lang('invoice') ?>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target="#myModal"
                               href="<?= base_url('admin/invoice/make_payment') ?>"><?= lang('make_payment') ?></a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/credit_note/index/edit_credit_note') ?>">
                                <?= lang('new') . ' ' . lang('credit_note') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/estimates/index/edit_estimates') ?>">
                                <?= lang('new') . ' ' . lang('estimates') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('admin/tickets/index/edit_tickets/') ?>">
                                <?= lang('new') . ' ' . lang('tickets') ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php if (config_item('enable_languages') == 'TRUE') { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag"></i> <?= lang('languages') ?>
                        </a>
                        <ul class="dropdown-menu animated zoomIn">
                            <?php
                            foreach ($languages as $lang) :
                                ?>
                                <li>
                                    <a href="<?= base_url() ?>admin/global_controller/set_language/<?= $lang->name ?>"
                                       title="<?= ucwords(str_replace("_", " ", $lang->name)) ?>">
                                        <img src="<?= base_url() ?>asset/images/flags/<?= $lang->icon ?>.gif"
                                             alt="<?= ucwords(str_replace("_", " ", $lang->name)) ?>"/> <?= ucwords(str_replace("_", " ", $lang->name)) ?>
                                    </a>
                                </li>
                            <?php
                            endforeach;
                            ?>
                        </ul>
                    </li>
                <?php } ?>
                <!-- START Alert menu-->
                <li class="dropdown dropdown-list notifications">
                    <?php $this->load->view('admin/components/notifications'); ?>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <img src="<?= base_url() . $profile_info->avatar ?>" class="img-xs user-image"
                             alt="User Image"/>
                        <span class="hidden-xs"><?= $profile_info->fullname ?></span>
                    </a>
                    <ul class="dropdown-menu animated zoomIn">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= base_url() . $profile_info->avatar ?>" class="img-circle" alt="User Image"/>
                            <p>
                                <?= $profile_info->fullname ?>
                                <small><?= lang('last_login') . ':' ?>
                                    <?php
                                    if ($user_info->last_login == '0000-00-00 00:00:00' || empty($user_info->last_login)) {
                                        $login_time = "-";
                                    } else {
                                        $login_time = strftime(config_item('date_format'), strtotime($user_info->last_login)) . ' ' . display_time($user_info->last_login);
                                    }
                                    echo $login_time;
                                    ?>
                                </small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="<?= base_url() ?>admin/settings/activities"><?= lang('activities') ?></a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="<?= base_url('admin/user/user_details/' . $user_id) ?>"><?= lang('my_details') ?></a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="<?= base_url() ?>locked/lock_screen"><?= lang('lock_screen') ?></a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= base_url() ?>admin/settings/update_profile"
                                   class="btn btn-default btn-flat"><?= lang('update_profile') ?></a>
                            </div>
                            <form method="post" action="<?= base_url() ?>login/logout"
                                  class="form-horizontal">

                                <input type="hidden" name="clock_time" value="" id="time">
                                <div class="pull-right">
                                    <button type="submit"
                                            class="btn btn-default btn-flat"><?= lang('logout') ?></button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle-state="offsidebar-open" data-no-persist="true">
                        <em class="icon-notebook"></em>
                    </a>
                </li>
            </ul>
            <!-- END Right Navbar-->
        </div>
        <!-- END Nav wrapper-->
        <!-- START Search form-->
        <div class="navbar-form">
            <div class="form-group has-feedback">
                <div class="input-group">
                    <div class="input-group-btn">
                        <select id="searchType"
                                class="form-control">
                            <option value="projects"><?= lang('projects') ?></option>
                            <option value="tasks"><?= lang('tasks') ?></option>
                            <option value="employee"><?= lang('employee') ?></option>
                            <option value="client"><?= lang('clients') ?></option>
                            <option value="bugs"><?= lang('bugs') ?></option>
                            <option value="opportunities"><?= lang('opportunities') ?></option>
                            <option value="leads"><?= lang('leads') ?></option>
                            <option value="purchase"><?= lang('purchase') ?></option>
                            <option value="invoice"><?= lang('invoices') ?></option>
                            <option value="credit_note"><?= lang('credit_note') ?></option>
                            <option value="estimates"><?= lang('estimates') ?></option>
                            <option value="tickets"><?= lang('tickets') ?></option>
                        </select>
                    </div>
                    <input type="text" id="all_search" placeholder="<?= lang('search_your_needs') ?>"
                           class="form-control search-icon">
                    <div data-search-dismiss="" class="fa fa-times form-control-feedback"></div>
                </div>
            </div>
            <button type="submit" class="hidden btn btn-default">Submit</button>
        </div>
        <!-- END Search form-->
    </nav>
    <!-- END Top Navbar-->
</header>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/awesomplete/awesomplete.css">
<script src="<?= base_url() ?>assets/plugins/awesomplete/awesomplete.min.js"></script>