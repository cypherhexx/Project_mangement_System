<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Forms extends MY_Controller
{
    public function index()
    {
        show_404();
    }

    /**
     * Web to lead form
     * User no need to see anything like LEAD in the url, this is the reason the method is named wtl
     * @param string $key web to lead form key identifier
     * @return mixed
     */
    public function leads($key)
    {
        $this->load->model('items_model');
        $form = get_row('tbl_lead_form', ['form_key' => $key]);

        if (!$form) {
            show_404();
        }

        // Change the locale so the validation loader function can load
        // the proper localization file
//        $GLOBALS['locale'] = get_locale_key($form->language);

        $data['form_fields'] = json_decode($form->form_data);
        if (!$data['form_fields']) {
            $data['form_fields'] = [];
        }
        if ($this->input->post('key')) {
            if ($this->input->post('key') == $key) {

                $post_data = $this->input->post();
                $required = [];

                foreach ($data['form_fields'] as $field) {
                    if (isset($field->required)) {
                        $required[] = $field->name;
                    }
                }
                foreach ($required as $field) {
                    if ($field == 'file-input') {
                        continue;
                    }
                    if (!isset($post_data[$field]) || isset($post_data[$field]) && empty($post_data[$field])) {
                        $this->output->set_status_header(422);
                        die;
                    }
                }

                if (config_item('recaptcha_secret_key') != '' && config_item('recaptcha_site_key') != '' && $form->form_recaptcha == 1) {
                    if (!do_recaptcha_validation($post_data['g-recaptcha-response'])) {
                        set_message('error', lang('recaptcha_error'));
                        if (empty($_SERVER['HTTP_REFERER'])) {
                            redirect('forms/leads/' . $key);
                        } else {
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                }

                if (isset($post_data['g-recaptcha-response'])) {
                    unset($post_data['g-recaptcha-response']);
                }

                unset($post_data['key']);

                $regular_fields = [];
                $custom_fields = [];
                foreach ($post_data as $name => $val) {
                    if (strpos($name, 'form-cf-') !== false) {
                        array_push($custom_fields, [
                            'name' => $name,
                            'value' => $val,
                        ]);
                    } else {
                        if ($this->db->field_exists($name, 'tbl_leads')) {
//                            if ($name == 'country') {
//                                if (!is_numeric($val)) {
//                                    if ($val == '') {
//                                        $val = 0;
//                                    } else {
//                                        $this->db->where('iso2', $val);
//                                        $this->db->or_where('short_name', $val);
//                                        $this->db->or_where('long_name', $val);
//                                        $country = $this->db->get(db_prefix() . 'countries')->row();
//                                        if ($country) {
//                                            $val = $country->country_id;
//                                        } else {
//                                            $val = 0;
//                                        }
//                                    }
//                                }
//                            } elseif ($name == 'address') {
//                                $val = trim($val);
//                                $val = nl2br($val);
//                            }

                            $regular_fields[$name] = $val;
                        }
                    }
                }

                $success = false;
                $insert_to_db = true;

                if ($form->allow_duplicate == 0) {
                    $where = [];
                    if (!empty($form->track_duplicate_field) && isset($regular_fields[$form->track_duplicate_field])) {
                        $where[$form->track_duplicate_field] = $regular_fields[$form->track_duplicate_field];
                    }


//                    if (!empty($form->track_duplicate_field_and) && isset($regular_fields[$form->track_duplicate_field_and])) {
//                        $where[$form->track_duplicate_field_and] = $regular_fields[$form->track_duplicate_field_and];
//                    }

                    if (count($where) > 0) {
                        $total = total_rows('tbl_leads', $where);

                        $duplicateLead = false;
                        /**
                         * Check if the lead is only 1 time duplicate
                         * Because we wont be able to know how user is tracking duplicate and to send the email template for
                         * the request
                         */
                        if ($total == 1) {
                            $this->db->where($where);
                            $duplicateLead = $this->db->get('tbl_leads')->row();
                            $msg = "<strong style='color:#000'>" . $duplicateLead->lead_name . '</strong>  ' . lang('already_exist');
                            set_message('error', $msg);
                            if (empty($_SERVER['HTTP_REFERER'])) {
                                redirect('forms/leads/' . $key);
                            } else {
                                redirect($_SERVER['HTTP_REFERER']);
                            }
                        }

                        if ($total > 0) {
                            // Success set to true for the response.
                            $success = true;
                            $insert_to_db = false;
                        }
                    }
                }

                if ($insert_to_db == true) {
                    $regular_fields['lead_status_id'] = $form->lead_status_id;
                    if ((isset($regular_fields['lead_name']) && empty($regular_fields['lead_name'])) || !isset($regular_fields['lead_name'])) {
                        $regular_fields['lead_name'] = 'Unknown';
                    }
                    $regular_fields['lead_source_id'] = $form->lead_source_id;
//                    $regular_fields['addedfrom'] = 0;
                    $regular_fields['last_contact'] = null;
                    $regular_fields['permission'] = $form->permission;
                    $regular_fields['created_time'] = date('Y-m-d H:i:s');
                    $regular_fields['from_form_id'] = $form->lead_form_id;

                    $this->items_model->_table_name = 'tbl_leads';
                    $this->items_model->_primary_key = 'leads_id';
                    $lead_id = $this->items_model->save($regular_fields);
//
//                    $this->db->insert('tbl_leads', $regular_fields);
//                    $lead_id = $this->db->insert_id();

                    $success = false;
                    if ($lead_id) {
                        $success = true;

                        $activity = array(
                            'user' => '0',
                            'module' => 'leads',
                            'module_field_id' => $lead_id,
                            'activity' => 'activity_added_leads_from_lead_from',
                            'icon' => 'fa-rocket',
                            'link' => 'admin/leads/leads_details/' . $lead_id,
                            'value1' => $regular_fields['lead_name']
                        );
                        $this->items_model->_table_name = 'tbl_activities';
                        $this->items_model->_primary_key = 'activities_id';
                        $this->items_model->save($activity);

                        // /handle_custom_fields_post
//                        $custom_fields_build['leads'] = [];
//                        foreach ($custom_fields as $cf) {
//                            $cf_id = strafter($cf['name'], 'form-cf-');
//                            $custom_fields_build['leads'][$cf_id] = $cf['value'];
//                        }

//                        handle_custom_fields_post($lead_id, $custom_fields_build);

//                        $this->leads_model->lead_assigned_member_notification($lead_id, $form->responsible, true);

//                        handle_lead_attachments($lead_id, 'file-input', $form->form_name);

                        if ($form->notify_lead_imported != 0) {
                            $notifiedUsers = array();
                            if (!empty($form->permission) && $form->permission != 'all') {
                                $permissionUsers = json_decode($form->permission);
                                foreach ($permissionUsers as $user => $v_permission) {
                                    array_push($notifiedUsers, $user);
                                }
                            } else {
                                $notifiedUsers = $this->items_model->allowed_user_id('55');
                            }
                            if (!empty($notifiedUsers)) {
                                foreach ($notifiedUsers as $users) {
                                    add_notification(array(
                                        'to_user_id' => $users,
                                        'from_user_id' => true,
                                        'description' => 'not_added_leads_from_lead_from',
                                        'link' => 'admin/leads/leads_details/' . $lead_id,
                                        'value' => lang('lead') . ' ' . $regular_fields['lead_name'],
                                    ));
                                }
                                show_notification($notifiedUsers);
                            }
                        }
//                        if (isset($regular_fields['email']) && $regular_fields['email'] != '') {
//                            $lead = $this->leads_model->get($lead_id);
//                            send_mail_template('lead_web_form_submitted', $lead);
//                        }
                    }
                } // end insert_to_db

                if ($success == true) {

//                    hooks()->do_action('web_to_lead_form_submitted', [
//                        'lead_id' => $lead_id,
//                        'form_id' => $form->id,
//                        'task_id' => $task_id,
//                    ]);
                    set_message('success', $form->submit_btn_msg);
                } else {
                    set_message('error', 'there is an issue on your form');
                }
                if (empty($_SERVER['HTTP_REFERER'])) {
                    redirect('forms/leads/' . $key);
                } else {
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }

        $data['form'] = $form;
        $this->load->view('forms/lead_form', $data);
    }

    /**
     * Web to lead form
     * User no need to see anything like LEAD in the url, this is the reason the method is named eq lead
     * @param string $hash lead unique identifier
     * @return mixed
     */
    public function l($hash)
    {
        if (get_option('gdpr_enable_lead_public_form') == '0') {
            show_404();
        }
        $this->load->model('leads_model');
        $this->load->model('gdpr_model');
        $lead = $this->leads_model->get('', ['hash' => $hash]);

        if (!$lead || count($lead) > 1) {
            show_404();
        }

        $lead = array_to_object($lead[0]);
        load_lead_language($lead->id);

        if ($this->input->post('update')) {
            $data = $this->input->post();
            unset($data['update']);
            $this->leads_model->update($data, $lead->id);
            redirect($_SERVER['HTTP_REFERER']);
        } elseif ($this->input->post('export') && get_option('gdpr_data_portability_leads') == '1') {
            $this->load->library('gdpr/gdpr_lead');
            $this->gdpr_lead->export($lead->id);
        } elseif ($this->input->post('removal_request')) {
            $success = $this->gdpr_model->add_removal_request([
                'description' => nl2br($this->input->post('removal_description')),
                'request_from' => $lead->name,
                'lead_id' => $lead->id,
            ]);
            if ($success) {
                send_gdpr_email_template('gdpr_removal_request_by_lead', $lead->id);
                set_alert('success', _l('data_removal_request_sent'));
            }
            redirect($_SERVER['HTTP_REFERER']);
        }

        $lead->attachments = $this->leads_model->get_lead_attachments($lead->id);
        $this->disableNavigation();
        $this->disableSubMenu();
        $data['title'] = $lead->name;
        $data['lead'] = $lead;
        $this->view('forms/lead');
        $this->data($data);
        $this->layout(true);
    }

    public function public_ticket($key)
    {
        $this->load->model('tickets_model');

        if (strlen($key) != 32) {
            show_error('Invalid ticket key.');
        }

        $ticket = $this->tickets_model->get_ticket_by_id($key);

        if (!$ticket) {
            show_404();
        }

        if (!is_client_logged_in() && $ticket->userid) {
            load_client_language($ticket->userid);
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('message', _l('ticket_reply'), 'required');

            if ($this->form_validation->run() !== false) {
                $replyData = ['message' => $this->input->post('message')];

                if ($ticket->userid && $ticket->contactid) {
                    $replyData['userid'] = $ticket->userid;
                    $replyData['contactid'] = $ticket->contactid;
                } else {
                    $replyData['name'] = $ticket->from_name;
                    $replyData['email'] = $ticket->ticket_email;
                }

                $replyid = $this->tickets_model->add_reply($replyData, $ticket->ticketid);

                if ($replyid) {
                    set_alert('success', _l('replied_to_ticket_successfully', $ticket->ticketid));
                }

                redirect(get_ticket_public_url($ticket));
            }
        }

        $data['title'] = $ticket->subject;
        $data['ticket_replies'] = $this->tickets_model->get_ticket_replies($ticket->ticketid);
        $data['ticket'] = $ticket;
        hooks()->add_action('app_customers_footer', 'ticket_public_form_customers_footer');
        $data['single_ticket_view'] = $this->load->view($this->createThemeViewPath('single_ticket'), $data, true);

        $navigationDisabled = hooks()->apply_filters('disable_navigation_on_public_ticket_view', true);
        if ($navigationDisabled) {
            $this->disableNavigation();
        }

        $this->disableSubMenu();

        $this->data($data);

        $this->view('forms/public_ticket');
        no_index_customers_area();
        $this->layout(true);
    }

    public function ticket()
    {
        $form = new stdClass();
        $form->language = get_option('active_language');
        $form->recaptcha = 1;

        $this->lang->load($form->language . '_lang', $form->language);
        if (file_exists(APPPATH . 'language/' . $form->language . '/custom_lang.php')) {
            $this->lang->load('custom_lang', $form->language);
        }

        $form->submit_btn_msg = _l('submit_btn_msg');

        $form = hooks()->apply_filters('ticket_form_settings', $form);

        if ($this->input->post() && $this->input->is_ajax_request()) {
            $post_data = $this->input->post();

            $required = ['subject', 'department', 'email', 'name', 'message', 'priority'];

            if (is_gdpr() && get_option('gdpr_enable_terms_and_conditions_ticket_form') == 1) {
                $required[] = 'accept_terms_and_conditions';
            }

            foreach ($required as $field) {
                if (!isset($post_data[$field]) || isset($post_data[$field]) && empty($post_data[$field])) {
                    $this->output->set_status_header(422);
                    die;
                }
            }

            if (get_option('recaptcha_secret_key') != '' && get_option('recaptcha_site_key') != '' && $form->recaptcha == 1) {
                if (!do_recaptcha_validation($post_data['g-recaptcha-response'])) {
                    echo json_encode([
                        'success' => false,
                        'message' => _l('recaptcha_error'),
                    ]);
                    die;
                }
            }

            $post_data = [
                'email' => $post_data['email'],
                'name' => $post_data['name'],
                'subject' => $post_data['subject'],
                'department' => $post_data['department'],
                'priority' => $post_data['priority'],
                'service' => isset($post_data['service']) && is_numeric($post_data['service'])
                    ? $post_data['service']
                    : null,
                'custom_fields' => isset($post_data['custom_fields']) && is_array($post_data['custom_fields'])
                    ? $post_data['custom_fields']
                    : [],
                'message' => $post_data['message'],
            ];

            $success = false;

            $this->db->where('email', $post_data['email']);
            $result = $this->db->get(db_prefix() . 'contacts')->row();

            if ($result) {
                $post_data['userid'] = $result->userid;
                $post_data['contactid'] = $result->id;
                unset($post_data['email']);
                unset($post_data['name']);
            }

            $this->load->model('tickets_model');

            $post_data = hooks()->apply_filters('ticket_external_form_insert_data', $post_data);
            $ticket_id = $this->tickets_model->add($post_data);

            if ($ticket_id) {
                $success = true;
            }

            if ($success == true) {
                hooks()->do_action('ticket_form_submitted', [
                    'ticket_id' => $ticket_id,
                ]);
            }

            echo json_encode([
                'success' => $success,
                'message' => $form->submit_btn_msg,
            ]);

            die;
        }

        $this->load->model('tickets_model');
        $this->load->model('departments_model');
        $data['departments'] = $this->departments_model->get();
        $data['priorities'] = $this->tickets_model->get_priority();

        $data['priorities']['callback_translate'] = 'ticket_priority_translate';
        $data['services'] = $this->tickets_model->get_service();

        $data['form'] = $form;
        $this->load->view('forms/ticket', $data);
    }
}
