<h3>Loan Statement</h3>

<p>
    <b>Employee:</b> <?= $loan['emp_code'] ?><br>
    <b>Loan Amount:</b> ₹<?= number_format($loan['loan_amount'],2) ?><br>
    <b>Status:</b> <?= $loan['status'] ?>
</p>

<table border="1" width="100%" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>Month</th>
            <th>Opening Balance</th>
            <th>EMI Deducted</th>
            <th>Closing Balance</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($emis)): ?>
            <tr>
                <td colspan="4" align="center">No EMI deducted yet</td>
            </tr>
        <?php else: ?>
            <?php foreach ($emis as $e): ?>
            <tr>
                <td><?= date('F Y', strtotime($e['pay_month'].'-01')) ?></td>
                <td>₹<?= number_format($e['opening_balance'],2) ?></td>
                <td>₹<?= number_format($e['deducted_amount'],2) ?></td>
                <td>₹<?= number_format($e['closing_balance'],2) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
