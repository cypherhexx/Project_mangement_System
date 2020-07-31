<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_201 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $this->db->query("UPDATE `tbl_config` SET `value` = '2.0.1' WHERE `tbl_config`.`config_key` = 'version';");
        $this->db->query("INSERT INTO `tbl_menu` (`menu_id`, `label`, `link`, `icon`, `parent`, `sort`, `time`, `status`) VALUES (NULL, 'transactions_settings', 'admin/settings/transactions', 'fa fa-fw fa-building-o', '25', '0', '2020-05-10 06:10:07', '2');");
    }
}
