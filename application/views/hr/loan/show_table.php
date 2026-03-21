<div class="table-responsive">
   <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?= $this->Company->table_bg_color();?>; color:<?= $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Loan Date</th>
                <th>Emp Code</th>
                <th>Name</th>
                <th>Dept.</th>
                <th>Mobile</th>

                <th>Loan Amount (₹)</th>
                <th>Total EMI</th>
                <th>Paid Amount (₹)</th>
                <th>Remaining Amount (₹)</th>
                <th>Remaining EMI</th>
                <!-- <th>EMI Months</th> -->

                <th>Status</th>
                <th>Statement</th>
                <th>Ledger</th>
                <th>Edit</th>
            </tr>
      </thead>
      <tbody>
        <?php
            $i=1;
            $total_loan = $total_paid = $total_remaining = 0;

            foreach($res2 as $r)
            {
                $loan_date = (!empty($r['created_at']))
                    ? date('d-m-Y', strtotime($r['created_at']))
                    : '';

                $total_loan      += $r['loan_amount'];
                $total_paid      += $r['total_paid_amount'];
                $total_remaining += $r['remaining_amount'];
        ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $loan_date ?></td>
                <td><?= $r['emp_code'] ?></td>
                <td><?= $r['first_name'].' '.$r['last_name'] ?></td>
                <td><?= $r['dname'] ?></td>
                <td><?= $r['mob'] ?></td>

                <td><b><?= number_format($r['loan_amount'],2) ?></b></td>
                <td><?= $r['total_emi_count'] ?></td>
                <td style="color:green">
                    <?= number_format($r['total_paid_amount'],2) ?>
                </td>
                <td style="color:red">
                    <?= number_format($r['remaining_amount'],2) ?>
                </td>
                <td><?= $r['remaining_emi_count'] ?></td>
                <!-- <td><?= $r['emi_months'] ?></td> -->

                <td>
                    <?php if($r['status']=='RUNNING'){ ?>
                        <span class="badge badge-warning">RUNNING</span>
                    <?php } else { ?>
                        <span class="badge badge-success">CLOSED</span>
                    <?php } ?>
                </td>

                <td>
                    <a href="<?= base_url('index.php/Hr/loan_statement/'.$r['loan_id']) ?>"
                        target="_blank"
                        class="btn btn-sm btn-info">
                        <i class="i-File"></i> Statement
                    </a>
                </td>

                <td>
                    <a href="<?= base_url('index.php/Hr/employee_full_loan_ledger/'.$r['emp_code']) ?>"
                        target="_blank"
                        class="btn btn-sm btn-info">
                        <i class="i-File"></i> Emp. Loan Ledger
                    </a>
                </td>

                
                <td>
                    <a  href="<?php base_url()?>home?Hr/add_emp_loan/<?php if(isset($r['loan_id']))echo $r['loan_id']?>" target="_blank"   class="btn btn-warning" >
                        <i class="nav-icon i-Pen-2"></i>
                    </a>
                </td>

            </tr>
        <?php
            $i++;
            }
        ?>

        <!-- TOTAL ROW -->
        <tr style="font-weight:bold; background:#f3f3f3">
            <td colspan="6" align="right">TOTAL</td>
            <td><?= number_format($total_loan,2) ?></td>
            <td></td>
            <td style="color:green"><?= number_format($total_paid,2) ?></td>
            <td style="color:red"><?= number_format($total_remaining,2) ?></td>
            <td colspan="5"></td>
        </tr>
      </tbody>
    </table>
</div>
