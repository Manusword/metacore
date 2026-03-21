<h3>Employee Loan Ledger</h3>

<p>
    <b>Employee:</b> <?= $emp['emp_name'] ?><br>
    <b>Department:</b> <?= $emp['dname'] ?><br>
    <b>Emp Code:</b> <?= $emp['emp_code'] ?>
</p>

<?php foreach ($ledger as $loan_id => $loan): ?>
<hr>
<h4>Loan ID: <?= $loan_id ?> | Loan Amount: ₹<?= number_format($loan['loan_amount'],2) ?></h4>

<table border="1" width="100%" cellpadding="6">
    <tr>
        <th>Month</th>
        <th>Opening</th>
        <th>Deducted</th>
        <th>Closing</th>
    </tr>

    <?php foreach ($loan['rows'] as $r): ?>
    <tr>
        <td><?= date('F Y', strtotime($r['pay_month'].'-01')) ?></td>
        <td>₹<?= number_format($r['opening_balance'],2) ?></td>
        <td>₹<?= number_format($r['deducted'],2) ?></td>
        <td>₹<?= number_format($r['closing_balance'],2) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endforeach; ?>
