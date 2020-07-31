<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Version_162 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $this->db->query("ALTER TABLE `tbl_customer_group` CHANGE `customer_group_id` `customer_group_id` BIGINT(20) NOT NULL AUTO_INCREMENT;");
        $this->db->query("ALTER TABLE `tbl_project` ADD `category_id` INT(11) NULL DEFAULT NULL AFTER `project_name`;");
        $this->db->query("ALTER TABLE `tbl_task` ADD `category_id` INT(11) NULL DEFAULT NULL AFTER `transactions_id`;");
        $this->db->query("UPDATE `tbl_config` SET `value` = '1.6.2' WHERE `tbl_config`.`config_key` = 'version';");
    }
}
