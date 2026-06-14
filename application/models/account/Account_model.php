<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // ---------------------------------------------------- Groups
    public function get_groups() {
        $sql = "
            SELECT G.*, P.name as parent_name 
            FROM acc_groups G 
            LEFT JOIN acc_groups P ON G.parent_id = P.id 
            ORDER BY G.id ASC
        ";
        return $this->db->query($sql)->result_array();
    }

    public function add_group($data) {
        return $this->db->insert('acc_groups', $data);
    }

    // ---------------------------------------------------- Ledgers
    public function get_ledgers() {
        $sql = "
            SELECT L.*, G.name as group_name, G.type as group_type 
            FROM acc_ledgers L 
            INNER JOIN acc_groups G ON L.group_id = G.id 
            ORDER BY L.name ASC
        ";
        return $this->db->query($sql)->result_array();
    }

    public function add_ledger($data) {
        return $this->db->insert('acc_ledgers', $data);
    }

    // ---------------------------------------------------- Vouchers (Save with Double Entry check)
    public function save_voucher($date, $type, $narration, $entries) {
        $this->db->trans_start();

        // 1. Generate unique voucher number
        $prefix = strtoupper(substr($type, 0, 3));
        $year = date('Y', strtotime($date));
        $count_sql = "SELECT COUNT(*) as cnt FROM acc_vouchers WHERE type = ?";
        $cnt = $this->db->query($count_sql, array($type))->row()->cnt + 1;
        $voucher_no = $prefix . '-' . str_pad($cnt, 4, '0', STR_PAD_LEFT);

        // 2. Validate debits = credits
        $total_dr = 0;
        $total_cr = 0;
        foreach ($entries as $entry) {
            if ($entry['type'] === 'Dr') {
                $total_dr += floatval($entry['amount']);
            } else {
                $total_cr += floatval($entry['amount']);
            }
        }

        if (abs($total_dr - $total_cr) > 0.001) {
            return array('status' => 'error', 'message' => 'Total Debit must equal Total Credit. Dr: ' . $total_dr . ', Cr: ' . $total_cr);
        }

        if ($total_dr <= 0) {
            return array('status' => 'error', 'message' => 'Voucher amount must be greater than zero.');
        }

        // 3. Insert Voucher Header
        $voucher = array(
            'voucher_no' => $voucher_no,
            'date' => $date,
            'type' => $type,
            'narration' => $narration,
            'total_amount' => $total_dr
        );
        $this->db->insert('acc_vouchers', $voucher);
        $voucher_id = $this->db->insert_id();

        // 4. Insert Entries
        foreach ($entries as $entry) {
            $e_data = array(
                'voucher_id' => $voucher_id,
                'ledger_id' => $entry['ledger_id'],
                'entry_type' => $entry['type'],
                'amount' => floatval($entry['amount'])
            );
            $this->db->insert('acc_voucher_entries', $e_data);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return array('status' => 'error', 'message' => 'Database transaction failed.');
        }

        return array('status' => 'success', 'voucher_no' => $voucher_no);
    }

    // ---------------------------------------------------- Reports
    public function get_daybook($from_date = null, $to_date = null) {
        $where = "";
        $params = array();
        if ($from_date && $to_date) {
            $where = " WHERE V.date BETWEEN ? AND ? ";
            $params = array($from_date, $to_date);
        }

        $sql = "
            SELECT V.*, 
                   GROUP_CONCAT(CONCAT(L.name, ' (', E.entry_type, ': ', E.amount, ')') SEPARATOR '<br>') as entry_details
            FROM acc_vouchers V
            INNER JOIN acc_voucher_entries E ON V.id = E.voucher_id
            INNER JOIN acc_ledgers L ON E.ledger_id = L.id
            $where
            GROUP BY V.id
            ORDER BY V.date DESC, V.id DESC
        ";
        return $this->db->query($sql, $params)->result_array();
    }

    public function get_ledger_statement($ledger_id, $from_date = null, $to_date = null) {
        // Fetch opening balance + sum of Dr/Cr transactions before from_date
        $ledger = $this->db->get_where('acc_ledgers', array('id' => $ledger_id))->row_array();
        if (!$ledger) return array();

        $opening_bal = floatval($ledger['opening_balance']);
        $opening_type = $ledger['opening_type'];

        // Get Dr/Cr sum before $from_date
        if ($from_date) {
            $sql_prev = "
                SELECT 
                    SUM(CASE WHEN entry_type = 'Dr' THEN amount ELSE 0 END) as dr_sum,
                    SUM(CASE WHEN entry_type = 'Cr' THEN amount ELSE 0 END) as cr_sum
                FROM acc_voucher_entries E
                INNER JOIN acc_vouchers V ON E.voucher_id = V.id
                WHERE E.ledger_id = ? AND V.date < ?
            ";
            $prev = $this->db->query($sql_prev, array($ledger_id, $from_date))->row_array();
            
            $dr_prev = floatval($prev['dr_sum']);
            $cr_prev = floatval($prev['cr_sum']);

            // Adjust opening balance with previous transactions
            if ($opening_type === 'Dr') {
                $net = $opening_bal + $dr_prev - $cr_prev;
            } else {
                $net = -$opening_bal + $dr_prev - $cr_prev;
            }
            if ($net >= 0) {
                $opening_bal = $net;
                $opening_type = 'Dr';
            } else {
                $opening_bal = abs($net);
                $opening_type = 'Cr';
            }
        }

        // Fetch transaction entries within date range
        $where = " WHERE E.ledger_id = ? ";
        $params = array($ledger_id);
        if ($from_date && $to_date) {
            $where .= " AND V.date BETWEEN ? AND ? ";
            $params[] = $from_date;
            $params[] = $to_date;
        }

        $sql_entries = "
            SELECT V.date, V.voucher_no, V.type as voucher_type, V.narration, E.entry_type, E.amount
            FROM acc_voucher_entries E
            INNER JOIN acc_vouchers V ON E.voucher_id = V.id
            $where
            ORDER BY V.date ASC, V.id ASC
        ";
        $entries = $this->db->query($sql_entries, $params)->result_array();

        return array(
            'ledger' => $ledger,
            'opening_balance' => $opening_bal,
            'opening_type' => $opening_type,
            'entries' => $entries
        );
    }

    public function get_trial_balance() {
        $sql = "
            SELECT 
                L.id, L.name, L.opening_balance, L.opening_type, G.name as group_name,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Dr' THEN E.amount ELSE 0 END), 0) as dr_total,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Cr' THEN E.amount ELSE 0 END), 0) as cr_total
            FROM acc_ledgers L
            INNER JOIN acc_groups G ON L.group_id = G.id
            LEFT JOIN acc_voucher_entries E ON L.id = E.ledger_id
            GROUP BY L.id
            ORDER BY G.name, L.name
        ";
        $ledgers = $this->db->query($sql)->result_array();

        $rows = array();
        $total_dr = 0;
        $total_cr = 0;

        foreach ($ledgers as $l) {
            $op_dr = ($l['opening_type'] === 'Dr') ? floatval($l['opening_balance']) : 0;
            $op_cr = ($l['opening_type'] === 'Cr') ? floatval($l['opening_balance']) : 0;

            $dr_sum = $op_dr + floatval($l['dr_total']);
            $cr_sum = $op_cr + floatval($l['cr_total']);

            $closing_balance = $dr_sum - $cr_sum;
            $closing_type = ($closing_balance >= 0) ? 'Dr' : 'Cr';
            $closing_amount = abs($closing_balance);

            if ($closing_type === 'Dr') {
                $total_dr += $closing_amount;
            } else {
                $total_cr += $closing_amount;
            }

            $rows[] = array(
                'name' => $l['name'],
                'group' => $l['group_name'],
                'opening' => $l['opening_balance'] . ' ' . $l['opening_type'],
                'dr_total' => $l['dr_total'],
                'cr_total' => $l['cr_total'],
                'closing_amount' => $closing_amount,
                'closing_type' => $closing_type
            );
        }

        return array(
            'rows' => $rows,
            'total_dr' => $total_dr,
            'total_cr' => $total_cr
        );
    }

    public function get_profit_loss() {
        // Fetch all ledgers that belong to Income (type = 'Income') and Expense (type = 'Expense')
        $sql = "
            SELECT 
                L.id, L.name, G.type as group_type, L.opening_balance, L.opening_type,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Dr' THEN E.amount ELSE 0 END), 0) as dr_total,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Cr' THEN E.amount ELSE 0 END), 0) as cr_total
            FROM acc_ledgers L
            INNER JOIN acc_groups G ON L.group_id = G.id
            LEFT JOIN acc_voucher_entries E ON L.id = E.ledger_id
            WHERE G.type IN ('Income', 'Expense')
            GROUP BY L.id
            ORDER BY G.type, L.name
        ";
        $ledgers = $this->db->query($sql)->result_array();

        $incomes = array();
        $expenses = array();
        $total_income = 0;
        $total_expense = 0;

        foreach ($ledgers as $l) {
            $op_dr = ($l['opening_type'] === 'Dr') ? floatval($l['opening_balance']) : 0;
            $op_cr = ($l['opening_type'] === 'Cr') ? floatval($l['opening_balance']) : 0;

            $dr_sum = $op_dr + floatval($l['dr_total']);
            $cr_sum = $op_cr + floatval($l['cr_total']);

            $net = $cr_sum - $dr_sum; // Revenue usually has Cr balance

            if ($l['group_type'] === 'Income') {
                if ($net != 0) {
                    $incomes[] = array('name' => $l['name'], 'amount' => $net);
                    $total_income += $net;
                }
            } else {
                // Expenses usually Dr balance, so Dr - Cr
                $net_exp = $dr_sum - $cr_sum;
                if ($net_exp != 0) {
                    $expenses[] = array('name' => $l['name'], 'amount' => $net_exp);
                    $total_expense += $net_exp;
                }
            }
        }

        $net_profit = $total_income - $total_expense;

        return array(
            'incomes' => $incomes,
            'expenses' => $expenses,
            'total_income' => $total_income,
            'total_expense' => $total_expense,
            'net_profit' => $net_profit
        );
    }

    public function get_balance_sheet() {
        // Assets and Liabilities
        $sql = "
            SELECT 
                L.id, L.name, G.type as group_type, L.opening_balance, L.opening_type,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Dr' THEN E.amount ELSE 0 END), 0) as dr_total,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Cr' THEN E.amount ELSE 0 END), 0) as cr_total
            FROM acc_ledgers L
            INNER JOIN acc_groups G ON L.group_id = G.id
            LEFT JOIN acc_voucher_entries E ON L.id = E.ledger_id
            WHERE G.type IN ('Asset', 'Liability')
            GROUP BY L.id
            ORDER BY G.type, L.name
        ";
        $ledgers = $this->db->query($sql)->result_array();

        $assets = array();
        $liabilities = array();
        $total_assets = 0;
        $total_liabilities = 0;

        foreach ($ledgers as $l) {
            $op_dr = ($l['opening_type'] === 'Dr') ? floatval($l['opening_balance']) : 0;
            $op_cr = ($l['opening_type'] === 'Cr') ? floatval($l['opening_balance']) : 0;

            $dr_sum = $op_dr + floatval($l['dr_total']);
            $cr_sum = $op_cr + floatval($l['cr_total']);

            if ($l['group_type'] === 'Asset') {
                $net = $dr_sum - $cr_sum; // Assets usually Dr
                if ($net != 0) {
                    $assets[] = array('name' => $l['name'], 'amount' => $net);
                    $total_assets += $net;
                }
            } else {
                $net = $cr_sum - $dr_sum; // Liabilities usually Cr
                if ($net != 0) {
                    $liabilities[] = array('name' => $l['name'], 'amount' => $net);
                    $total_liabilities += $net;
                }
            }
        }

        // Add Net Profit from P&L to Capital/Liabilities
        $pl = $this->get_profit_loss();
        $net_profit = $pl['net_profit'];
        $liabilities[] = array('name' => 'Profit & Loss A/c (Current Period Net Profit)', 'amount' => $net_profit);
        $total_liabilities += $net_profit;

        return array(
            'assets' => $assets,
            'liabilities' => $liabilities,
            'total_assets' => $total_assets,
            'total_liabilities' => $total_liabilities
        );
    }

    // ---------------------------------------------------- Dashboard helpers
    public function get_cash_bank_balances() {
        $sql = "
            SELECT 
                L.name, L.opening_balance, L.opening_type,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Dr' THEN E.amount ELSE 0 END), 0) as dr_total,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Cr' THEN E.amount ELSE 0 END), 0) as cr_total
            FROM acc_ledgers L
            INNER JOIN acc_groups G ON L.group_id = G.id
            LEFT JOIN acc_voucher_entries E ON L.id = E.ledger_id
            WHERE G.id IN (12, 13) -- Cash-in-hand (12), Bank Accounts (13)
            GROUP BY L.id
            ORDER BY L.name ASC
        ";
        $results = $this->db->query($sql)->result_array();
        
        $balances = array();
        foreach ($results as $r) {
            $op_dr = ($r['opening_type'] === 'Dr') ? floatval($r['opening_balance']) : 0;
            $op_cr = ($r['opening_type'] === 'Cr') ? floatval($r['opening_balance']) : 0;
            $bal = $op_dr + floatval($r['dr_total']) - $op_cr - floatval($r['cr_total']);
            $balances[] = array('name' => $r['name'], 'balance' => $bal);
        }
        return $balances;
    }

    public function get_recent_vouchers($limit = 5) {
        $sql = "
            SELECT V.*, 
                   GROUP_CONCAT(CONCAT(L.name, ' (', E.entry_type, ': ', E.amount, ')') SEPARATOR '<br>') as entry_details
            FROM acc_vouchers V
            INNER JOIN acc_voucher_entries E ON V.id = E.voucher_id
            INNER JOIN acc_ledgers L ON E.ledger_id = L.id
            GROUP BY V.id
            ORDER BY V.date DESC, V.id DESC
            LIMIT ?
        ";
        return $this->db->query($sql, array($limit))->result_array();
    }

    public function get_chart_totals($from_date, $to_date, $group_by) {
        $group_col = "";
        if ($group_by === 'weekly') {
            $group_col = "DATE_FORMAT(V.date, '%Y-W%u')";
        } elseif ($group_by === 'quarterly') {
            $group_col = "CONCAT(YEAR(V.date), '-Q', QUARTER(V.date))";
        } elseif ($group_by === 'yearly') {
            $group_col = "DATE_FORMAT(V.date, '%Y')";
        } else { // default monthly
            $group_col = "DATE_FORMAT(V.date, '%Y-%m')";
        }

        $sql = "
            SELECT 
                $group_col as label,
                COALESCE(SUM(CASE WHEN G.id = 15 AND E.entry_type = 'Cr' THEN E.amount 
                             WHEN G.id = 15 AND E.entry_type = 'Dr' THEN -E.amount ELSE 0 END), 0) as sales_total,
                COALESCE(SUM(CASE WHEN G.id = 17 AND E.entry_type = 'Dr' THEN E.amount 
                             WHEN G.id = 17 AND E.entry_type = 'Cr' THEN -E.amount ELSE 0 END), 0) as purchase_total,
                COALESCE(SUM(CASE WHEN G.id IN (18, 19) AND E.entry_type = 'Dr' THEN E.amount 
                             WHEN G.id IN (18, 19) AND E.entry_type = 'Cr' THEN -E.amount ELSE 0 END), 0) as expense_total
            FROM acc_voucher_entries E
            INNER JOIN acc_vouchers V ON E.voucher_id = V.id
            INNER JOIN acc_ledgers L ON E.ledger_id = L.id
            INNER JOIN acc_groups G ON L.group_id = G.id
            WHERE V.date BETWEEN ? AND ?
            GROUP BY label
            ORDER BY label ASC
        ";

        return $this->db->query($sql, array($from_date, $to_date))->result_array();
    }

    public function get_expense_breakdown($from_date, $to_date) {
        $sql = "
            SELECT 
                L.name,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Dr' THEN E.amount ELSE -E.amount END), 0) as amount
            FROM acc_voucher_entries E
            INNER JOIN acc_vouchers V ON E.voucher_id = V.id
            INNER JOIN acc_ledgers L ON E.ledger_id = L.id
            INNER JOIN acc_groups G ON L.group_id = G.id
            WHERE G.id IN (18, 19) AND V.date BETWEEN ? AND ?
            GROUP BY L.id
            HAVING amount > 0
            ORDER BY amount DESC
        ";
        return $this->db->query($sql, array($from_date, $to_date))->result_array();
    }

    public function get_suppliers_summary() {
        $sql = "
            SELECT 
                L.id,
                L.name,
                L.opening_balance,
                L.opening_type,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Cr' THEN E.amount ELSE 0 END), 0) as total_purchase,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Dr' THEN E.amount ELSE 0 END), 0) as total_payment
            FROM acc_ledgers L
            INNER JOIN acc_groups G ON L.group_id = G.id
            LEFT JOIN acc_voucher_entries E ON L.id = E.ledger_id
            WHERE G.id = 8 OR G.parent_id = 8
            GROUP BY L.id
            ORDER BY L.name ASC
        ";
        $results = $this->db->query($sql)->result_array();
        foreach ($results as &$r) {
            $op_bal = floatval($r['opening_balance']);
            $op_type = $r['opening_type'];
            $pur = floatval($r['total_purchase']);
            $pay = floatval($r['total_payment']);
            
            if ($op_type === 'Cr') {
                $bal = $op_bal + $pur - $pay;
            } else {
                $bal = -$op_bal + $pur - $pay;
            }
            $r['balance'] = $bal;
        }
        return $results;
    }

    public function get_customers_summary() {
        $sql = "
            SELECT 
                L.id,
                L.name,
                L.opening_balance,
                L.opening_type,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Dr' THEN E.amount ELSE 0 END), 0) as total_sales,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Cr' THEN E.amount ELSE 0 END), 0) as total_received
            FROM acc_ledgers L
            INNER JOIN acc_groups G ON L.group_id = G.id
            LEFT JOIN acc_voucher_entries E ON L.id = E.ledger_id
            WHERE G.id = 11 OR G.parent_id = 11
            GROUP BY L.id
            ORDER BY L.name ASC
        ";
        $results = $this->db->query($sql)->result_array();
        foreach ($results as &$r) {
            $op_bal = floatval($r['opening_balance']);
            $op_type = $r['opening_type'];
            $sal = floatval($r['total_sales']);
            $rec = floatval($r['total_received']);
            
            if ($op_type === 'Dr') {
                $bal = $op_bal + $sal - $rec;
            } else {
                $bal = -$op_bal + $sal - $rec;
            }
            $r['balance'] = $bal;
        }
        return $results;
    }

    public function get_financial_metrics() {
        $sql = "
            SELECT 
                L.group_id, L.opening_balance, L.opening_type,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Dr' THEN E.amount ELSE 0 END), 0) as dr_total,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Cr' THEN E.amount ELSE 0 END), 0) as cr_total
            FROM acc_ledgers L
            LEFT JOIN acc_voucher_entries E ON L.id = E.ledger_id
            GROUP BY L.id
        ";
        $ledgers = $this->db->query($sql)->result_array();
        
        $current_assets = 0;
        $current_liabilities = 0;
        $total_receivables = 0;
        $total_payables = 0;
        
        foreach ($ledgers as $l) {
            $op_dr = ($l['opening_type'] === 'Dr') ? floatval($l['opening_balance']) : 0;
            $op_cr = ($l['opening_type'] === 'Cr') ? floatval($l['opening_balance']) : 0;
            $dr = floatval($l['dr_total']);
            $cr = floatval($l['cr_total']);
            
            $net_dr = ($op_dr + $dr) - ($op_cr + $cr);
            
            if ($l['group_id'] == 11) {
                $total_receivables += $net_dr;
            }
            if ($l['group_id'] == 8) {
                $total_payables += -$net_dr;
            }
            
            if (in_array($l['group_id'], array(10, 11, 12, 13, 14))) {
                $current_assets += $net_dr;
            }
            if (in_array($l['group_id'], array(7, 8, 9))) {
                $current_liabilities += -$net_dr;
            }
        }
        
        return array(
            'current_assets' => $current_assets,
            'current_liabilities' => $current_liabilities,
            'total_receivables' => $total_receivables,
            'total_payables' => $total_payables
        );
    }

    public function get_tax_balance() {
        $sql = "
            SELECT 
                COALESCE(SUM(CASE WHEN E.entry_type = 'Cr' THEN E.amount 
                             WHEN E.entry_type = 'Dr' THEN -E.amount ELSE 0 END), 0) as tax_bal
            FROM acc_voucher_entries E
            INNER JOIN acc_ledgers L ON E.ledger_id = L.id
            WHERE L.group_id = 9 OR L.group_id IN (SELECT id FROM acc_groups WHERE parent_id = 9)
        ";
        $row = $this->db->query($sql)->row_array();
        return floatval($row['tax_bal']);
    }

    public function get_cash_flow($from_date, $to_date) {
        $sql = "
            SELECT 
                COALESCE(SUM(CASE WHEN E.entry_type = 'Dr' THEN E.amount ELSE 0 END), 0) as inflow,
                COALESCE(SUM(CASE WHEN E.entry_type = 'Cr' THEN E.amount ELSE 0 END), 0) as outflow
            FROM acc_voucher_entries E
            INNER JOIN acc_ledgers L ON E.ledger_id = L.id
            INNER JOIN acc_vouchers V ON E.voucher_id = V.id
            WHERE (L.group_id IN (12, 13) OR L.group_id IN (SELECT id FROM acc_groups WHERE parent_id IN (12, 13)))
              AND V.date BETWEEN ? AND ?
        ";
        return $this->db->query($sql, array($from_date, $to_date))->row_array();
    }
}
