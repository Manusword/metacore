<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('account/Account_model', 'Acc');
        $user_email = $this->session->userdata('login_username');
        if (!$user_email) {
            redirect('Welcome/');
        }
    }

    public function index() {
        $result['groups'] = $this->Acc->get_groups();
        $this->load->view('account/groups', $result);
    }

    public function save() {
        $name = trim($this->input->post('name'));
        $parent_id = $this->input->post('parent_id') ?: null;
        $type = $this->input->post('type');

        if (empty($name) || empty($type)) {
            echo "Group name and type are required.";
            return;
        }

        $data = array(
            'name' => $name,
            'parent_id' => $parent_id,
            'type' => $type
        );

        if ($this->Acc->add_group($data)) {
            echo "Save";
        } else {
            echo "Error saving group.";
        }
    }
}
