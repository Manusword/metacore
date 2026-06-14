<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daybook extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('account/Account_model', 'Acc');
        $user_email = $this->session->userdata('login_username');
        if (!$user_email) {
            redirect('Welcome/');
        }
    }

    public function index() {
        $from_date = $this->input->post('from_date') ?: date('Y-m-01');
        $to_date = $this->input->post('to_date') ?: date('Y-m-t');

        $result['from_date'] = $from_date;
        $result['to_date'] = $to_date;
        $result['vouchers'] = $this->Acc->get_daybook($from_date, $to_date);

        $this->load->view('account/daybook', $result);
    }
}
