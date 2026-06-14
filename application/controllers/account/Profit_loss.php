<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profit_loss extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('account/Account_model', 'Acc');
        $user_email = $this->session->userdata('login_username');
        if (!$user_email) {
            redirect('Welcome/');
        }
    }

    public function index() {
        $result = $this->Acc->get_profit_loss();
        $this->load->view('account/profit_loss', $result);
    }
}
