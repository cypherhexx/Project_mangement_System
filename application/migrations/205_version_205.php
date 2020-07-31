<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_205 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $this->db->query("UPDATE `tbl_config` SET `value` = '2.0.5' WHERE `tbl_config`.`config_key` = 'version';");
        $this->db->query("ALTER TABLE `tbl_transactions` ADD `transaction_prefix` VARCHAR(50) NULL DEFAULT NULL AFTER `name`;");
        $this->db->query("ALTER TABLE `tbl_accounts` ADD `account_number` VARCHAR(50) NULL AFTER `balance`, ADD `contact_person` VARCHAR(100) NULL AFTER `account_number`, ADD `contact_phone` VARCHAR(20) NULL AFTER `contact_person`, ADD `bank_details` TEXT NULL AFTER `contact_phone`;");
        $this->db->query("INSERT INTO `tbl_config` (`config_key`, `value`) VALUES ('chat_interval_time', '5');");
    }
}
