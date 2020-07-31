<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_200 extends CI_Migration
{
    function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $this->db->query("UPDATE `tbl_config` SET `value` = '2.0.0' WHERE `tbl_config`.`config_key` = 'version';");
        $this->db->query("CREATE TABLE IF NOT EXISTS `tbl_leads_notes` (
  `notes_id` int(11) NOT NULL AUTO_INCREMENT,
  `leads_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `contacted_indicator` varchar(50) DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT current_timestamp(),
  `last_contact` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`notes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE IF NOT EXISTS `tbl_lead_form` (
  `lead_form_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_key` varchar(32) NOT NULL,
  `form_name` varchar(200) NOT NULL,
  `lead_status_id` int(11) NOT NULL,
  `lead_source_id` int(11) NOT NULL,
  `language` varchar(40) DEFAULT NULL,
  `form_recaptcha` int(11) NOT NULL DEFAULT 0,
  `submit_btn_text` varchar(40) DEFAULT NULL,
  `submit_btn_msg` text DEFAULT NULL,
  `allow_duplicate` int(11) NOT NULL DEFAULT 1,
  `track_duplicate_field` varchar(100) DEFAULT NULL,
  `form_data` mediumtext DEFAULT NULL,
  `notify_lead_imported` int(11) NOT NULL DEFAULT 1,
  `permission` text DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`lead_form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;");
        $this->db->query("CREATE TABLE IF NOT EXISTS `tbl_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) DEFAULT NULL,
  `style` text DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;");
        $this->db->query("INSERT INTO `tbl_menu` (`menu_id`, `label`, `link`, `icon`, `parent`, `sort`, `time`, `status`) VALUES (NULL, 'tags', 'admin/settings/tags', 'fa fa-fw fa-tags', '25', '0', '2017-04-27 03:43:41', '2');");
        $this->db->query("ALTER TABLE `tbl_project` ADD `tags` TEXT NULL DEFAULT NULL AFTER `billing_type`;");
        $this->db->query("ALTER TABLE `tbl_task` ADD `tags` TEXT NULL DEFAULT NULL AFTER `index_no`;");
        $this->db->query("ALTER TABLE `tbl_leads` ADD `tags` TEXT NULL DEFAULT NULL AFTER `index_no`;");
        $this->db->query("ALTER TABLE `tbl_purchases` ADD `tags` TEXT NULL DEFAULT NULL AFTER `notes`;");
        $this->db->query("ALTER TABLE `tbl_invoices` ADD `tags` TEXT NULL DEFAULT NULL AFTER `show_quantity_as`;");
        $this->db->query("ALTER TABLE `tbl_credit_note` ADD `tags` TEXT NULL DEFAULT NULL AFTER `show_quantity_as`;");
        $this->db->query("ALTER TABLE `tbl_estimates` ADD `tags` TEXT NULL DEFAULT NULL AFTER `show_quantity_as`;");
        $this->db->query("ALTER TABLE `tbl_proposals` ADD `tags` TEXT NULL DEFAULT NULL AFTER `show_quantity_as`;");
        $this->db->query("ALTER TABLE `tbl_tickets` ADD `tags` TEXT NULL DEFAULT NULL AFTER `permission`;");
        if (empty($this->db->field_exists('tags', 'tbl_transactions'))) {
            $this->db->query("ALTER TABLE `tbl_transactions` ADD `tags` TEXT NULL DEFAULT NULL AFTER `notes`;");
        }
        $this->db->query("ALTER TABLE `tbl_suppliers` ADD `vat` VARCHAR(200) NULL DEFAULT NULL AFTER `address`;");
        $this->db->query("ALTER TABLE `tbl_leads` CHANGE `created_time` `created_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;");
        $this->db->query("ALTER TABLE `tbl_leads` ADD `last_contact` TIMESTAMP NULL DEFAULT NULL AFTER `created_time`;");
        $this->db->query("ALTER TABLE `tbl_leads` ADD `from_form_id` INT(11) NULL DEFAULT NULL AFTER `tags`;");
        $this->db->query("INSERT INTO `tbl_menu` (`menu_id`, `label`, `link`, `icon`, `parent`, `sort`, `time`, `status`) VALUES (NULL, 'lead_form', 'admin/leads/all_lead_form', 'fa fa-fw fa-rocket', '25', '0', '2017-04-27 03:43:41', '2');");
        $this->db->query("ALTER TABLE `tbl_leads` ADD `language` VARCHAR(100) NULL DEFAULT NULL AFTER `facebook`;");
        $this->db->query("ALTER TABLE `tbl_client` ADD `permission` TEXT NULL DEFAULT NULL AFTER `sms_notification`;");
    }
}
