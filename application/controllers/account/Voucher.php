<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher extends CI_Controller {

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
        $this->load->view('account/voucher', $result);
    }

    public function save() {
        $date = $this->input->post('date');
        $type = $this->input->post('type');
        $narration = $this->input->post('narration');
        $entries = $this->input->post('entries'); // Array: [['ledger_id'=>1, 'type'=>'Dr', 'amount'=>100], ...]

        if (empty($date) || empty($type) || empty($entries) || !is_array($entries)) {
            echo "Invalid voucher data or missing entries.";
            return;
        }

        $res = $this->Acc->save_voucher($date, $type, $narration, $entries);
        if ($res['status'] === 'success') {
            echo "Save~" . $res['voucher_no'];
        } else {
            echo $res['message'];
        }
    }
}
