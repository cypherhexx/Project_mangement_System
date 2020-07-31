<div class="panel panel-custom">

    <div class="panel-heading">
        <div class="panel-title"><?= lang('all') . ' ' . lang('lead_form') ?>
            <?php
            $created = can_action('161', 'created');
            if (!empty($created)) { ?>
                <div class="pull-right hidden-print" style="padding-top: 0px;padding-bottom: 8px">
                    <a href="<?= base_url() ?>admin/leads/lead_form" class="btn btn-xs btn-info">
                        <i class="fa fa-plus "></i> <?= ' ' . lang('new') . ' ' . lang('lead_form') ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <style type="text/css">
        .custom-bulk-button {
            display: initial;
        }
    </style>
    <div class="table-responsive">
        <table class="table table-striped DataTables bulk_table" id="DataTables" cellspacing="0" width="100%">
            <thead>
            <tr>
                <?php
                $deleted = can_action('161', 'deleted');
                if (!empty($deleted)) { ?>
                    <th data-orderable="false">
                        <div class="checkbox c-checkbox">
                            <label class="needsclick">
                                <input id="select_all" type="checkbox">
                                <span class="fa fa-check"></span></label>
                        </div>
                    </th>
                <?php } ?>
                <th><?= lang('form').' '.lang('id') ?></th>
                <th><?= lang('form') . ' ' . lang('name') ?></th>
                <th><?= lang('total_submissions') ?></th>
                <th><?= lang('created') ?></th>
                <th class="col-options no-sort"><?= lang('action') ?></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <script type="text/javascript">
                $(document).ready(function () {
                    list = base_url + "admin/leads/leadFormList";
                    bulk_url = base_url + "admin/leads/bulkLeadFormDelete";
                });
            </script>
        </table>
    </div>
</div>
