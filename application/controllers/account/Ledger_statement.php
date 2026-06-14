<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger_statement extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('account/Account_model', 'Acc');
        $user_email = $this->session->userdata('login_username');
        if (!$user_email) {
            redirect('Welcome/');
        }
    }

    public function index() {
        $ledger_id = $this->input->post('ledger_id');
        $from_date = $this->input->post('from_date') ?: date('Y-m-01');
        $to_date = $this->input->post('to_date') ?: date('Y-m-t');

        $result['ledgers'] = $this->Acc->get_ledgers();
        $result['ledger_id'] = $ledger_id;
        $result['from_date'] = $from_date;
        $result['to_date'] = $to_date;
        
        $result['statement'] = array();
        if (!empty($ledger_id)) {
            $result['statement'] = $this->Acc->get_ledger_statement($ledger_id, $from_date, $to_date);
        }

        $this->load->view('account/ledger_statement', $result);
    }
}
