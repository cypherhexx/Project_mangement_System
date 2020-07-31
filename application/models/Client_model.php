<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of client_model
 *
 * @author NaYeM
 */
class Client_Model extends MY_Model
{

    public $_table_name;
    public $_order_by;
    public $_primary_key;

    function get_primary_contatc($user, $field)
    {

        $this->db->where('user_id', $user);
        $this->db->select($field);
        $query = $this->db->get('tbl_account_details');

        if ($query->num_rows() > 0) {
            $row = $query->row();

            return $row->$field;
        }
    }

    public function client_paid($client_id)
    {
        $query = $this->db->where('paid_by', $client_id)->select_sum('amount')->get('tbl_payments')->row();
        return $query->amount;
    }

    public function get_client_contacts($client_id)
    {
        $primary_contact = get_any_field('tbl_client', array('client_id' => $client_id), 'primary_contact');

        $this->db->select('tbl_account_details.*', FALSE);
        $this->db->select('tbl_users.*', FALSE);
        $this->db->from('tbl_account_details');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_account_details.user_id', 'left');
        $this->db->where('tbl_account_details.company', $client_id);
        if (!empty($_POST["length"]) && $_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();
        if (!empty($result) && $primary_contact == 0 || empty($primary_contact)) {
            $client_data['primary_contact'] = $result[0]->user_id;
            $this->_table_name = 'tbl_client';
            $this->_primary_key = 'client_id';
            $this->save($client_data, $client_id);
        }
        return $result;
    }

    public function get_client($filterBy = null)
    {
        if (empty($filterBy)) {
            return get_result('tbl_client');
        } else {
            $where = array('customer_group_id' => $filterBy);
            return get_result('tbl_client', $where);
        }
    }


}
