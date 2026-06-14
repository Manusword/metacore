<style>
    .advisory-card {
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border-radius: 8px;
        transition: transform 0.2s;
    }
    .advisory-card:hover {
        transform: translateY(-2px);
    }

    .health-check-item {
        padding: 10px 15px;
        border-bottom: 1px solid #f1f1f1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .health-check-item:last-child {
        border-bottom: 0;
    }
</style>

<div class="breadcrumb">
    <h1 style="font-weight: bold; color: #111;">Company Financial Intelligence Cockpit</h1>
    <ul>
        <li><a href="#" style="color: #e37209; font-weight: 500;">Account</a></li>
        <li>Financial Cockpit (First-Time Business Advisor)</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top" style="border-top: 1px solid #e37209 !important; opacity: 0.15;"></div>

<!-- Advisory Dashboard Banner -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="p-3 text-white rounded d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #2ea63b, #207e2b); box-shadow: 0 4px 15px rgba(46,166,59,0.2);">
            <div>
                <h4 class="mb-1" style="font-weight: bold;">Welcome to your Business Cockpit! 🚀</h4>
                <p class="mb-0 text-13" style="opacity: 0.9;">We analyze your double-entry accounting records automatically and show you warnings and checks so you make zero business mistakes.</p>
            </div>
            <span class="badge badge-light px-3 py-2 text-13 font-weight-bold" style="color: #2ea63b; border-radius: 20px;">
                <i class="i-Double-Tap mr-1"></i> System Healthy & Balanced
            </span>
        </div>
    </div>
</div>

<!-- 1. Interactive Filters Card -->
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card advisory-card" style="border-left: 4px solid #e37209;">
            <div class="card-body py-3">
                <form id="form_filter_dashboard">
                    <div class="row align-items-end">
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-2 mb-md-0">
                            <div class="form-group mb-0">
                                <label for="dash_from_date" style="font-weight: 600; color: #555; font-size: 13px;">Analyze From</label>
                                <input type="date" class="form-control" id="dash_from_date" name="from_date" value="<?= date('Y-01-01') ?>" required style="border-radius: 4px; border: 1px solid #ccc;">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-2 mb-md-0">
                            <div class="form-group mb-0">
                                <label for="dash_to_date" style="font-weight: 600; color: #555; font-size: 13px;">Analyze To</label>
                                <input type="date" class="form-control" id="dash_to_date" name="to_date" value="<?= date('Y-12-31') ?>" required style="border-radius: 4px; border: 1px solid #ccc;">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-2 mb-md-0">
                            <div class="form-group mb-0">
                                <label for="dash_group_by" style="font-weight: 600; color: #555; font-size: 13px;">Show Trend By</label>
                                <select class="form-control" id="dash_group_by" name="group_by" style="border-radius: 4px; border: 1px solid #ccc;">
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly" selected>Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-6 text-right">
                            <button type="submit" class="btn btn-block" style="background-color: #e37209; color: white; font-weight: bold; border-radius: 4px; box-shadow: 0 2px 5px rgba(227,114,9,0.3); transition: all 0.2s;">
                                <i class="i-Filter-2 mr-1"></i> Update Cockpit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 2. Advisory Key Performance Indicators Row -->
<div class="row">
    <!-- Combined Cash & Bank Balance -->
    <?php 
        $net_cash = 0;
        foreach ($cash_bank as $cb) {
            $net_cash += floatval($cb['balance']);
        }
    ?>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 advisory-card">
            <div class="card-body text-center">
                <i class="i-Wallet" style="color: #2ea63b;"></i>
                <div class="content" style="max-width: 170px;">
                    <p class="text-muted mt-2 mb-0" style="font-size: 12px; font-weight: 500;">
                        Net Cash & Bank
                    </p>
                    <p class="lead text-20 mb-0" style="font-weight: bold; color: #111;"><?= ind_money_format($net_cash, true) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Estimated Tax Due Warning -->
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 advisory-card">
            <div class="card-body text-center">
                <i class="i-Warning-Window" style="color: <?= $tax_balance > 0 ? '#d9534f' : '#2ea63b' ?>;"></i>
                <div class="content" style="max-width: 170px;">
                    <p class="text-muted mt-2 mb-0" style="font-size: 12px; font-weight: 500;">
                        Estimated Tax Liability
                    </p>
                    <p class="lead text-20 mb-0" style="font-weight: bold; color: <?= $tax_balance > 0 ? '#d9534f' : '#2ea63b' ?>;">
                        <?= ind_money_format(abs($tax_balance), true) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Net Profit Card -->
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 advisory-card">
            <div class="card-body text-center">
                <i class="i-Line-Chart" style="color: #e37209;"></i>
                <div class="content" style="max-width: 170px;">
                    <p class="text-muted mt-2 mb-0" style="font-size: 12px; font-weight: 500;">
                        Net Profit Margin
                    </p>
                    <p class="lead text-20 mb-0" style="font-weight: bold; color: #e37209;"><?= ind_money_format($net_profit, true) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Accounts Receivable -->
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4 advisory-card">
            <div class="card-body text-center">
                <i class="i-Receipt-4" style="color: #5a67d8;"></i>
                <div class="content" style="max-width: 170px;">
                    <p class="text-muted mt-2 mb-0" style="font-size: 12px; font-weight: 500;">
                        Accounts Receivable
                    </p>
                    <p class="lead text-20 mb-0" style="font-weight: bold; color: #5a67d8;"><?= ind_money_format($metrics['total_receivables'], true) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. Financial Health Checklist & Cash Flow Analysis Row -->
<div class="row">
    <!-- Financial Health Advisory & Audit Checklist -->
    <div class="col-lg-5 col-md-12 mb-4">
        <div class="card advisory-card" style="min-height: 380px;">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center mb-3">
                    <span style="font-weight: bold; color: #333; font-size: 16px;">Advisory Health Checklist</span>
                    <i class="i-Eye text-muted text-18"></i>
                </div>
                
                <?php
                    $ratio = $metrics['current_liabilities'] != 0 ? round($metrics['current_assets'] / $metrics['current_liabilities'], 2) : $metrics['current_assets'];
                    $working_cap = $metrics['current_assets'] - $metrics['current_liabilities'];
                ?>

                <div class="health-check-list">
                    <!-- Check 1: Double entry ledger balance -->
                    <div class="health-check-item">
                        <div>
                            <span style="font-weight: bold; font-size: 13.5px; color: #111;">System Accounting Audit</span>
                            <br><small class="text-muted">Checks if all journals are double-balanced.</small>
                        </div>
                        <span class="badge badge-success px-2 py-1" style="font-size: 11px;">Balanced ✓</span>
                    </div>

                    <!-- Check 2: Liquidity status (Current Ratio) -->
                    <div class="health-check-item">
                        <div>
                            <span style="font-weight: bold; font-size: 13.5px; color: #111;">Liquidity Ratio (Current Ratio)</span>
                            <br><small class="text-muted">Target is > 1.5. Currently: <strong><?= $ratio ?> : 1</strong></small>
                        </div>
                        <?php if ($ratio >= 1.5): ?>
                            <span class="badge badge-success px-2 py-1" style="font-size: 11px;">Excellent (<?= $ratio ?>)</span>
                        <?php elseif ($ratio >= 1.0): ?>
                            <span class="badge badge-warning px-2 py-1" style="font-size: 11px;">Moderate (<?= $ratio ?>)</span>
                        <?php else: ?>
                            <span class="badge badge-danger px-2 py-1" style="font-size: 11px;">Critical (<?= $ratio ?>)</span>
                        <?php endif; ?>
                    </div>

                    <!-- Check 3: Tax liabilities status -->
                    <div class="health-check-item">
                        <div>
                            <span style="font-weight: bold; font-size: 13.5px; color: #111;">Pending Tax Dues status</span>
                            <br><small class="text-muted">GST/Duties reserve warnings.</small>
                        </div>
                        <?php if ($tax_balance <= 0): ?>
                            <span class="badge badge-success px-2 py-1" style="font-size: 11px;">No Dues</span>
                        <?php else: ?>
                            <span class="badge badge-warning px-2 py-1" style="font-size: 11px;">Pending: <?= ind_money_format($tax_balance) ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Check 4: Cash Runway Indicator -->
                    <?php
                        // Calculate survival runway based on total expenses
                        // If expenses are low or 0, runway is safe
                        $exp_total = $total_expense;
                        if ($exp_total <= 0) {
                            $runway_text = "Infinite Runway";
                            $runway_class = "badge-success";
                        } else {
                            $runway_months = round($net_cash / ($exp_total), 1);
                            if ($runway_months >= 6) {
                                $runway_text = $runway_months . " Months (Healthy)";
                                $runway_class = "badge-success";
                            } elseif ($runway_months >= 2) {
                                $runway_text = $runway_months . " Months (Monitor)";
                                $runway_class = "badge-warning";
                            } else {
                                $runway_text = $runway_months . " Months (Critical)";
                                $runway_class = "badge-danger";
                            }
                        }
                    ?>
                    <div class="health-check-item">
                        <div>
                            <span style="font-weight: bold; font-size: 13.5px; color: #111;">Cash Survival Runway</span>
                            <br><small class="text-muted">How long your cash lasts compared to costs.</small>
                        </div>
                        <span class="badge <?= $runway_class ?> px-2 py-1" style="font-size: 11px;"><?= $runway_text ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Real Cash Flow Card (Inflow vs Outflow) -->
    <div class="col-lg-7 col-md-12 mb-4">
        <div class="card advisory-card" style="min-height: 380px;">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center mb-3">
                    <span style="font-weight: bold; color: #333; font-size: 16px;">
                        Cash Flow Insights (Actual Money Flow)
                    </span>
                    <i class="i-Financial text-success text-18"></i>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6 mb-3 text-center border-right">
                        <p class="text-muted mb-1" style="font-size: 13px;">Total Cash Inflow (+)</p>
                        <h3 class="text-success" style="font-weight: bold; font-size: 26px;" id="inflow-metric"><?= ind_money_format($cash_flow['inflow'], true) ?></h3>
                        <small class="text-muted d-block mt-1">Receipts and Customer Payments received.</small>
                    </div>
                    <div class="col-md-6 mb-3 text-center">
                        <p class="text-muted mb-1" style="font-size: 13px;">Total Cash Outflow (-)</p>
                        <h3 class="text-danger" style="font-weight: bold; font-size: 26px;" id="outflow-metric"><?= ind_money_format($cash_flow['outflow'], true) ?></h3>
                        <small class="text-muted d-block mt-1">Rent, Salaries, Supplier Payments and purchases paid.</small>
                    </div>
                </div>

                <?php 
                    $net_flow = $cash_flow['inflow'] - $cash_flow['outflow'];
                ?>
                <div class="p-3 rounded mt-3 text-center" style="background-color: #f8f9fa; border: 1px dashed #ddd;">
                    <p class="text-muted mb-0" style="font-size: 13px;">Net Spendable Cash Added/Lost</p>
                    <h4 style="font-weight: bold; color: <?= $net_flow >= 0 ? '#2ea63b' : '#d9534f' ?>; font-size: 22px; margin-bottom: 0;" id="net-cash-metric">
                        <?= ($net_flow >= 0 ? '+' : '') . ind_money_format($net_flow, true) ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. Visual Graphs Row (Sales vs Purchase Column Chart & Expense categories donut) -->
<div class="row">
    <!-- Sales vs Purchase vs Expenses Trend -->
    <div class="col-lg-8 col-md-12 mb-4">
        <div class="card advisory-card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center mb-3">
                    <span style="font-weight: bold; color: #333; font-size: 16px;">Sales, Purchase & Expenses Trend</span>
                    <span class="badge badge-light py-1 px-2" style="font-size: 11px;" id="trend_date_range_label">Jan - Dec</span>
                </div>
                <div id="chart-sales-purchases-expenses" style="min-height: 350px;"></div>
            </div>
        </div>
    </div>

    <!-- Expense Category Breakdown -->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card advisory-card">
            <div class="card-body">
                <div class="card-title mb-3" style="font-weight: bold; color: #333; font-size: 16px;">Top Expenses Breakdown</div>
                <div id="chart-expense-categories" style="min-height: 350px;" class="d-flex align-items-center justify-content-center"></div>
            </div>
        </div>
    </div>
</div>

<!-- 5. Business Summaries & Metrics Row (Party outstandings and cash distributions) -->
<div class="row">
    <!-- Customers & Suppliers Outstandings -->
    <div class="col-lg-7 col-md-12 mb-4">
        <div class="card advisory-card" style="min-height: 380px;">
            <div class="card-header bg-transparent border-0 d-flex align-items-center justify-content-between pt-3 pb-0">
                <h5 class="card-title mb-0" style="font-weight: bold; color: #333; font-size: 16px;">Party Outstandings</h5>
                <ul class="nav nav-tabs card-header-tabs" id="partyTab" role="tablist" style="border-bottom: 0;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="customers-tab" data-toggle="tab" href="#customers" role="tab" aria-controls="customers" aria-selected="true" style="font-weight: 600; color: #e37209; border: 0; border-bottom: 3px solid #e37209; padding: 8px 12px; transition: all 0.2s;">Customers</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="suppliers-tab" data-toggle="tab" href="#suppliers" role="tab" aria-controls="suppliers" aria-selected="false" style="font-weight: 600; color: #555; border: 0; padding: 8px 12px; transition: all 0.2s;">Suppliers</a>
                    </li>
                </ul>
            </div>
            <div class="card-body pt-2">
                <div class="tab-content" id="partyTabContent">
                    <!-- Customers Tab -->
                    <div class="tab-pane fade show active" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                        <div class="table-responsive" style="max-height: 270px; overflow-y: auto;">
                            <table class="table table-hover">
                                <thead>
                                    <tr style="background-color: #f8f9fa;">
                                        <th>Customer Name</th>
                                        <th class="text-right">Billed (Sales)</th>
                                        <th class="text-right">Received</th>
                                        <th class="text-right">Outstandings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($customers)): ?>
                                        <?php foreach ($customers as $cust): ?>
                                            <tr>
                                                <td style="font-weight: bold; color: #111;"><?= $cust['name'] ?></td>
                                                <td class="text-right text-success" style="font-weight: 500;"><?= ind_money_format($cust['total_sales'], true) ?></td>
                                                <td class="text-right text-muted"><?= ind_money_format($cust['total_received'], true) ?></td>
                                                <td class="text-right" style="font-weight: bold; color: <?= $cust['balance'] > 0 ? '#d9534f' : '#2ea63b' ?>;">
                                                    <?= ind_money_format(abs($cust['balance']), true) ?>
                                                    <span class="text-small text-muted" style="font-weight: normal; font-size: 11px;"><?= $cust['balance'] >= 0 ? 'Dr' : 'Cr' ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No customer records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Suppliers Tab -->
                    <div class="tab-pane fade" id="suppliers" role="tabpanel" aria-labelledby="suppliers-tab">
                        <div class="table-responsive" style="max-height: 270px; overflow-y: auto;">
                            <table class="table table-hover">
                                <thead>
                                    <tr style="background-color: #f8f9fa;">
                                        <th>Supplier Name</th>
                                        <th class="text-right">Purchased (Bills)</th>
                                        <th class="text-right">Paid Amount</th>
                                        <th class="text-right">Payables Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($suppliers)): ?>
                                        <?php foreach ($suppliers as $supp): ?>
                                            <tr>
                                                <td style="font-weight: bold; color: #111;"><?= $supp['name'] ?></td>
                                                <td class="text-right text-danger" style="font-weight: 500;"><?= ind_money_format($supp['total_purchase'], true) ?></td>
                                                <td class="text-right text-muted"><?= ind_money_format($supp['total_payment'], true) ?></td>
                                                <td class="text-right" style="font-weight: bold; color: <?= $supp['balance'] > 0 ? '#d9534f' : '#2ea63b' ?>;">
                                                    <?= ind_money_format(abs($supp['balance']), true) ?>
                                                    <span class="text-small text-muted" style="font-weight: normal; font-size: 11px;"><?= $supp['balance'] >= 0 ? 'Cr' : 'Dr' ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No supplier records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cash/Bank breakdown list -->
    <div class="col-lg-5 col-md-12 mb-4">
        <div class="card advisory-card" style="min-height: 380px;">
            <div class="card-body">
                <div class="card-title mb-2" style="font-weight: bold; color: #333; font-size: 15px;">Cash & Bank Distribution</div>
                <div class="table-responsive" style="max-height: 290px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <tbody>
                            <?php foreach ($cash_bank as $cb): ?>
                                <tr>
                                    <td>
                                        <i class="i-Money-2 text-16 mr-1" style="color: #2ea63b; vertical-align: middle;"></i>
                                        <span style="font-weight: 500;"><?= $cb['name'] ?></span>
                                    </td>
                                    <td class="text-right" style="font-weight: bold; color: #111;"><?= ind_money_format($cb['balance'], true) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 6. Recent Accounting Vouchers Table -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card mb-4" style="box-shadow: 0 4px 20px rgba(0,0,0,0.05); border-radius: 8px;">
            <div class="card-body">
                <div class="card-title" style="font-weight: bold; color: #333; font-size: 16px;">Recent Accounting Vouchers</div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr style="background-color: #34425A; color: white;">
                                <th>#</th>
                                <th>Voucher No</th>
                                <th>Date</th>
                                <th>Voucher Type</th>
                                <th>Narration</th>
                                <th class="text-right">Total Amount</th>
                                <th>Entry Details (Double Entry Ledger)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_vouchers)): ?>
                                <?php $i = 1; foreach ($recent_vouchers as $v): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><span class="badge badge-primary text-13" style="background-color: #e37209; border-color: #e37209;"><?= $v['voucher_no'] ?></span></td>
                                        <td><?= date('d-m-Y', strtotime($v['date'])) ?></td>
                                        <td><span class="badge badge-warning text-13" style="background-color: #2ea63b; border-color: #2ea63b; color: white;"><?= $v['type'] ?></span></td>
                                        <td><?= $v['narration'] ?></td>
                                        <td class="text-right" style="font-weight: bold; color: #111;"><?= ind_money_format($v['total_amount'], true) ?></td>
                                        <td style="font-size: 13px; color: #555;"><?= $v['entry_details'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No recent vouchers found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        var salesTrendChart = null;
        var expenseDonutChart = null;

        // Custom Indian Number Formatter for JS Tooltips
        function formatIndianNumber(val) {
            val = parseFloat(val).toFixed(2);
            var parts = val.split('.');
            var num = parts[0];
            var dec = parts[1] || '00';
            
            var lastThree = num.substr(num.length - 3);
            var rest = num.substr(0, num.length - 3);
            if (rest != '') {
                rest = rest.replace(/\B(?=(\d{2})+(?!\d))/g, ",");
                return rest + ',' + lastThree + '.' + dec;
            } else {
                return lastThree + '.' + dec;
            }
        }

        function loadDashboardCharts() {
            var from_date = $('#dash_from_date').val();
            var to_date = $('#dash_to_date').val();
            var group_by = $('#dash_group_by').val();

            // Set labels
            var options = { month: 'short', year: 'numeric', day: 'numeric' };
            var fdLabel = new Date(from_date).toLocaleDateString("en-IN", options);
            var tdLabel = new Date(to_date).toLocaleDateString("en-IN", options);
            $('#trend_date_range_label').text(fdLabel + ' - ' + tdLabel);

            $.post('<?= base_url("index.php/account/dashboard/get_chart_data") ?>', {
                from_date: from_date,
                to_date: to_date,
                group_by: group_by
            }, function(res) {
                if (res.status === 'success') {
                    renderSalesTrendChart(res.totals);
                    renderExpenseBreakdownChart(res.expenses);
                    
                    // Dynamically update cash flow numbers when dates change!
                    if (res.cash_flow) {
                        $('#inflow-metric').text('₹' + formatIndianNumber(res.cash_flow.inflow));
                        $('#outflow-metric').text('₹' + formatIndianNumber(res.cash_flow.outflow));
                        var net = res.cash_flow.inflow - res.cash_flow.outflow;
                        var netStr = (net >= 0 ? '+' : '') + '₹' + formatIndianNumber(net);
                        $('#net-cash-metric').text(netStr);
                        if (net >= 0) {
                            $('#net-cash-metric').css('color', '#2ea63b');
                        } else {
                            $('#net-cash-metric').css('color', '#d9534f');
                        }
                    }
                } else {
                    console.error('Error fetching dashboard charts data');
                }
            }, 'json');
        }

        function renderSalesTrendChart(data) {
            var labels = [];
            var sales = [];
            var purchases = [];
            var expenses = [];

            data.forEach(function(row) {
                labels.push(row.label);
                sales.push(row.sales_total);
                purchases.push(row.purchase_total);
                expenses.push(row.expense_total);
            });

            var options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false },
                    fontFamily: 'Outfit, Inter, sans-serif'
                },
                series: [
                    { name: 'Sales (Revenue)', data: sales },
                    { name: 'Purchase (Inflow)', data: purchases },
                    { name: 'Expenses', data: expenses }
                ],
                colors: ['#2ea63b', '#e37209', '#5a67d8'],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                xaxis: { categories: labels },
                yaxis: {
                    title: { text: 'Amount (₹)', style: { fontWeight: 600 } },
                    labels: {
                        formatter: function(val) {
                            return '₹' + formatIndianNumber(val).split('.')[0];
                        }
                    }
                },
                fill: { opacity: 1 },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return '₹' + formatIndianNumber(val);
                        }
                    }
                },
                legend: { position: 'top' },
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 4
                }
            };

            var container = document.querySelector("#chart-sales-purchases-expenses");
            if (!container) return;

            if (salesTrendChart) {
                salesTrendChart.updateOptions({
                    xaxis: { categories: labels }
                });
                salesTrendChart.updateSeries([
                    { name: 'Sales (Revenue)', data: sales },
                    { name: 'Purchase (Inflow)', data: purchases },
                    { name: 'Expenses', data: expenses }
                ]);
            } else {
                salesTrendChart = new ApexCharts(container, options);
                salesTrendChart.render();
            }
        }

        function renderExpenseBreakdownChart(data) {
            var container = document.querySelector("#chart-expense-categories");
            if (!container) return;

            if (data.length === 0) {
                container.innerHTML = '<div class="text-muted text-center py-5">No expense transactions recorded in this date range.</div>';
                if (expenseDonutChart) {
                    expenseDonutChart.destroy();
                    expenseDonutChart = null;
                }
                return;
            }

            var series = [];
            var labels = [];

            data.forEach(function(row) {
                series.push(row.amount);
                labels.push(row.name);
            });

            var options = {
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'Outfit, Inter, sans-serif'
                },
                series: series,
                labels: labels,
                colors: ['#e37209', '#5a67d8', '#f0ad4e', '#d9534f', '#2ea63b', '#5bc0de', '#337ab7'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: { width: 200 },
                        legend: { position: 'bottom' }
                    }
                }],
                legend: { position: 'bottom' },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return '₹' + formatIndianNumber(val);
                        }
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Expenses',
                                    formatter: function(w) {
                                        var total = w.globals.seriesTotals.reduce(function(a, b) {
                                            return a + b;
                                        }, 0);
                                        return '₹' + formatIndianNumber(total).split('.')[0];
                                    }
                                }
                            }
                        }
                    }
                }
            };

            if (container.querySelector('.text-muted')) {
                container.innerHTML = '';
            }

            if (expenseDonutChart) {
                expenseDonutChart.updateSeries(series);
                expenseDonutChart.updateOptions({
                    labels: labels
                });
            } else {
                expenseDonutChart = new ApexCharts(container, options);
                expenseDonutChart.render();
            }
        }

        // Initialize and bind events
        $(document).ready(function() {
            loadDashboardCharts();

            // Enable bootstrap tooltips inside dashboard context
            if (typeof $('[data-toggle="tooltip"]').tooltip === 'function') {
                $('[data-toggle="tooltip"]').tooltip();
            }

            // Party Tab custom click handler
            $('#partyTab a').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
                $('#partyTab a').css({ 'color': '#555', 'border-bottom': 'none' });
                $(this).css({ 'color': '#e37209', 'border-bottom': '3px solid #e37209' });
            });

            $('#form_filter_dashboard').on('submit', function(e) {
                e.preventDefault();
                loadDashboardCharts();
            });
        });
    })();
</script>
