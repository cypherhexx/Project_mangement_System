<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admistrator
 *
 * @author pc mart ltd
 */
class Calendar extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('invoice_model');
        $this->load->model('estimates_model');
    }

    public function index($action = NULL)
    {
        $data['title'] = config_item('company_name');
        $data['dataTables'] = true;
        $data['select_2'] = true;
        $data['datepicker'] = true;
        $data['page'] = lang('calendar');
        if (!empty($action) && $action == 'search') {
            $data['searchType'] = $this->uri->segment(5);

        } else {
            $data['searchType'] = 'all';
        }


        $user_id = $this->session->userdata('user_id');
        $user_info = $this->admin_model->check_by(array('user_id' => $user_id), 'tbl_users');
        $data['role'] = $user_info->role_id;

        $data['subview'] = $this->load->view('admin/calendar', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    function invoice_totals_per_currency()
    {
        $invoices_info = $this->db->where('inv_deleted', 'No')->get('tbl_invoices')->result();
        $paid = $due = array();
        $currency = 'USD';
        $symbol = array();
        foreach ($invoices_info as $v_invoices) {
            if (!isset($paid[$v_invoices->currency])) {
                $paid[$v_invoices->currency] = 0;
            }
            if (!isset($due[$v_invoices->currency])) {
                $due[$v_invoices->currency] = 0;
            }
            $paid[$v_invoices->currency] += $this->invoice_model->get_invoice_paid_amount($v_invoices->invoices_id);
            $due[$v_invoices->currency] += $this->invoice_model->get_invoice_due_amount($v_invoices->invoices_id);
            $currency = $this->admin_model->check_by(array('code' => $v_invoices->currency), 'tbl_currencies');
            $symbol[$v_invoices->currency] = $currency->symbol;
        }
        return array("paid" => $paid, "due" => $due, "symbol" => $symbol);
    }


    public function calendar_settings()
    {
        $data['title'] = lang('calendar_settings');
        $data['modal_subview'] = $this->load->view('admin/settings/calendar_settings', $data, FALSE);
        $this->load->view('admin/_layout_modal', $data);
    }

    public function save_settings()
    {
        $input_data = $this->admin_model->array_from_post(array('gcal_api_key', 'gcal_id', 'project_on_calendar', 'milestone_on_calendar', 'tasks_on_calendar', 'bugs_on_calendar', 'invoice_on_calendar', 'payments_on_calendar', 'estimate_on_calendar', 'opportunities_on_calendar', 'leads_on_calendar', 'goal_tracking_on_calendar', 'holiday_on_calendar', 'absent_on_calendar', 'on_leave_on_calendar',
            'project_color', 'milestone_color', 'tasks_color', 'bugs_color', 'invoice_color', 'payments_color', 'estimate_color', 'opportunities_color', 'leads_color', 'goal_tracking_color', 'absent_color', 'on_leave_color'));

        foreach ($input_data as $key => $value) {
            $data = array('value' => $value);
            $this->db->where('config_key', $key)->update('tbl_config', $data);
            $exists = $this->db->where('config_key', $key)->get('tbl_config');
            if ($exists->num_rows() == 0) {
                $this->db->insert('tbl_config', array("config_key" => $key, "value" => $value));
            }
        }
        $activity = array(
            'user' => $this->session->userdata('user_id'),
            'module' => 'settings',
            'module_field_id' => $this->session->userdata('user_id'),
            'activity' => ('activity_save_settings'),
            'value1' => $input_data['gcal_api_key']
        );

        $this->admin_model->_table_name = 'tbl_activities';
        $this->admin_model->_primary_key = 'activities_id';
        $this->admin_model->save($activity);
        // messages for user
        $type = "success";
        $message = lang('save_settings');
        set_message($type, $message);
        if (empty($_SERVER['HTTP_REFERER'])) {
            redirect('admin/calendar');
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}
