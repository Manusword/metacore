<div class="breadcrumb">
    <h1>Balance Sheet Statement</h1>
    <ul>
        <li><a href="#">Account</a></li>
        <li>Balance Sheet</li>
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
                <div class="card-title">Balance Sheet (Financial Statement)</div>
                
                <div class="row">
                    <!-- Left Side: Liabilities -->
                    <div class="col-md-6 border-right">
                        <h4 style="font-weight: bold; color: #52495a; border-bottom: 2px solid #eee; padding-bottom: 8px;">Liabilities & Capital</h4>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Particulars</th>
                                    <th class="text-right">Amount (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($liabilities as $lia): ?>
                                    <tr>
                                        <td><?= $lia['name'] ?></td>
                                        <td class="text-right" style="font-weight: 500;">
                                            <?= ind_money_format($lia['amount'], true) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Right Side: Assets -->
                    <div class="col-md-6">
                        <h4 style="font-weight: bold; color: #003473; border-bottom: 2px solid #eee; padding-bottom: 8px;">Assets & Properties</h4>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Particulars</th>
                                    <th class="text-right">Amount (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assets as $ast): ?>
                                    <tr>
                                        <td><?= $ast['name'] ?></td>
                                        <td class="text-right" style="font-weight: 500;">
                                            <?= ind_money_format($ast['amount'], true) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Grand Summary Footer (Balanced Assets & Liabilities) -->
                <div class="row mt-4" style="border-top: 2px solid #333; background-color: #f8f9fa; font-weight: bold; padding: 12px 0;">
                    <div class="col-6 text-right" style="font-size: 1.1rem; color: #111;">
                        Total Liabilities: <?= ind_money_format($total_liabilities, true) ?>
                    </div>
                    <div class="col-6 text-right" style="font-size: 1.1rem; color: #111;">
                        Total Assets: <?= ind_money_format($total_assets, true) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
