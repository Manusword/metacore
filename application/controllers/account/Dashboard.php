<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('account/Account_model', 'Acc');
        $user_email = $this->session->userdata('login_username');
        if (!$user_email) {
            redirect('Welcome/');
        }
    }

    public function index() {
        $result['cash_bank'] = $this->Acc->get_cash_bank_balances();
        $result['recent_vouchers'] = $this->Acc->get_recent_vouchers(5);
        
        $pl = $this->Acc->get_profit_loss();
        $result['total_income'] = $pl['total_income'];
        $result['total_expense'] = $pl['total_expense'];
        $result['net_profit'] = $pl['net_profit'];

        $result['suppliers'] = $this->Acc->get_suppliers_summary();
        $result['customers'] = $this->Acc->get_customers_summary();
        $result['metrics'] = $this->Acc->get_financial_metrics();

        // New advisory cockpit variables
        $result['tax_balance'] = $this->Acc->get_tax_balance();
        $result['cash_flow'] = $this->Acc->get_cash_flow(date('Y-01-01'), date('Y-12-31'));

        $this->load->view('account/dashboard', $result);
    }

    public function get_chart_data() {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $group_by = $this->input->post('group_by');

        if (empty($from_date)) {
            $from_date = date('Y-01-01');
        }
        if (empty($to_date)) {
            $to_date = date('Y-12-31');
        }
        if (empty($group_by)) {
            $group_by = 'monthly';
        }

        $totals = $this->Acc->get_chart_totals($from_date, $to_date, $group_by);
        $expenses = $this->Acc->get_expense_breakdown($from_date, $to_date);
        $cash_flow = $this->Acc->get_cash_flow($from_date, $to_date);

        foreach ($totals as &$row) {
            $label = $row['label'];
            if ($group_by === 'weekly') {
                $row['label'] = "W" . substr($label, 6) . " " . substr($label, 2, 2);
            } elseif ($group_by === 'quarterly') {
                $row['label'] = substr($label, 5) . " '" . substr($label, 2, 2);
            } elseif ($group_by === 'yearly') {
                $row['label'] = $label;
            } else {
                $time = strtotime($label . "-01");
                if ($time) {
                    $row['label'] = date("M 'y", $time);
                }
            }
            $row['sales_total'] = floatval($row['sales_total']);
            $row['purchase_total'] = floatval($row['purchase_total']);
            $row['expense_total'] = floatval($row['expense_total']);
        }

        foreach ($expenses as &$exp) {
            $exp['amount'] = floatval($exp['amount']);
        }

        $cash_flow['inflow'] = floatval($cash_flow['inflow']);
        $cash_flow['outflow'] = floatval($cash_flow['outflow']);

        $response = array(
            'status' => 'success',
            'totals' => $totals,
            'expenses' => $expenses,
            'cash_flow' => $cash_flow
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
