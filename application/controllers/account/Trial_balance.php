<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trial_balance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('account/Account_model', 'Acc');
        $user_email = $this->session->userdata('login_username');
        if (!$user_email) {
            redirect('Welcome/');
        }
    }

    public function index() {
        $result = $this->Acc->get_trial_balance();
        $this->load->view('account/trial_balance', $result);
    }
}
