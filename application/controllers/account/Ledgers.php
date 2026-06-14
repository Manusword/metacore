<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledgers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('account/Account_model', 'Acc');
        $user_email = $this->session->userdata('login_username');
        if (!$user_email) {
            redirect('Welcome/');
        }
    }

    public function index() {
        $result['ledgers'] = $this->Acc->get_ledgers();
        $result['groups'] = $this->Acc->get_groups();
        $this->load->view('account/ledgers', $result);
    }

    public function save() {
        $name = trim($this->input->post('name'));
        $group_id = $this->input->post('group_id');
        $opening_balance = floatval($this->input->post('opening_balance'));
        $opening_type = $this->input->post('opening_type') ?: 'Dr';
        $description = trim($this->input->post('description'));

        if (empty($name) || empty($group_id)) {
            echo "Ledger name and group are required.";
            return;
        }

        $data = array(
            'name' => $name,
            'group_id' => $group_id,
            'opening_balance' => $opening_balance,
            'opening_type' => $opening_type,
            'description' => $description
        );

        if ($this->Acc->add_ledger($data)) {
            echo "Save";
        } else {
            echo "Error saving ledger.";
        }
    }
}
