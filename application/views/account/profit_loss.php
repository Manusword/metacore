<div class="breadcrumb">
    <h1>Profit & Loss A/c Statement</h1>
    <ul>
        <li><a href="#">Account</a></li>
        <li>Profit & Loss</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12 text-right mb-3">
        <button type="button" class="btn btn-success" onclick="fun_export_xls()">Export Excel</button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Profit & Loss Account</div>
                
                <div class="row">
                    <!-- Left Side: Expenses -->
                    <div class="col-md-6 border-right">
                        <h4 style="font-weight: bold; color: #f44336; border-bottom: 2px solid #eee; padding-bottom: 8px;">Expenses / Outflow</h4>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Particulars</th>
                                    <th class="text-right">Amount (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($expenses as $exp): ?>
                                    <tr>
                                        <td><?= $exp['name'] ?></td>
                                        <td class="text-right" style="font-weight: 500;"><?= ind_money_format($exp['amount'], true) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                
                                <?php if ($net_profit >= 0): ?>
                                    <tr style="font-weight: bold; background-color: #e8f5e9; color: green;">
                                        <td>To Net Profit (Transferred to Balance Sheet)</td>
                                        <td class="text-right"><?= ind_money_format($net_profit, true) ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Right Side: Income -->
                    <div class="col-md-6">
                        <h4 style="font-weight: bold; color: #4caf50; border-bottom: 2px solid #eee; padding-bottom: 8px;">Income / Revenue</h4>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Particulars</th>
                                    <th class="text-right">Amount (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($incomes as $inc): ?>
                                    <tr>
                                        <td><?= $inc['name'] ?></td>
                                        <td class="text-right" style="font-weight: 500;"><?= ind_money_format($inc['amount'], true) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                
                                <?php if ($net_profit < 0): ?>
                                    <tr style="font-weight: bold; background-color: #ffeacc; color: red;">
                                        <td>By Net Loss</td>
                                        <td class="text-right"><?= ind_money_format(abs($net_profit), true) ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Grand Summary Footer (Tally Balanced Sheet Style) -->
                <div class="row mt-4" style="border-top: 2px solid #333; background-color: #f8f9fa; font-weight: bold; padding: 12px 0;">
                    <div class="col-6 text-right" style="font-size: 1.1rem;">
                        Total Expenses: <?= ind_money_format(($net_profit >= 0) ? ($total_expense + $net_profit) : $total_expense, true) ?>
                    </div>
                    <div class="col-6 text-right" style="font-size: 1.1rem;">
                        Total Income: <?= ind_money_format(($net_profit < 0) ? ($total_income + abs($net_profit)) : $total_income, true) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
