<script type="text/javascript">
$(document).ready(function() {
    var rowCount = 0;

    // Helper to filter ledgers by category/group selection
    function filterLedgers(rowSelect, category) {
        var optionsHtml = '<option value="">-- Select Ledger --</option>';
        $.each(ledgerOptions, function(index, ledger) {
            var show = false;
            var gid = parseInt(ledger.group_id);

            if (category === '') {
                show = true;
            } else if (category === 'cash_bank') {
                show = (gid === 12 || gid === 13);
            } else if (category === 'debtors') {
                show = (gid === 11);
            } else if (category === 'creditors') {
                show = (gid === 8);
            } else if (category === 'expenses') {
                show = (gid === 18 || gid === 19);
            } else if (category === 'sales') {
                show = (gid === 15);
            } else if (category === 'purchase') {
                show = (gid === 17);
            } else if (category === 'capital') {
                show = (gid === 5);
            }

            if (show) {
                optionsHtml += '<option value="' + ledger.id + '">' + ledger.name + ' (' + ledger.group_name + ')</option>';
            }
        });
        rowSelect.html(optionsHtml);
    }

    // Add first two rows by default (double entry needs at least two lines: one Dr, one Cr)
    addVoucherRow('Dr');
    addVoucherRow('Cr');

    // Add Row click
    $('#btn_add_voucher_row').on('click', function() {
        var lastType = $('#tbody_voucher_rows tr:last-child').find('.row-type').val();
        var nextType = (lastType === 'Dr') ? 'Cr' : 'Dr';
        addVoucherRow(nextType);
    });

    // Add row function
    function addVoucherRow(defaultType) {
        rowCount++;
        
        var rowHtml = `
            <tr id="row_${rowCount}">
                <td>
                    <select class="form-control row-type" required>
                        <option value="Dr" ${defaultType === 'Dr' ? 'selected' : ''}>Dr</option>
                        <option value="Cr" ${defaultType === 'Cr' ? 'selected' : ''}>Cr</option>
                    </select>
                </td>
                <td>
                    <select class="form-control row-group-filter">
                        <option value="">-- All Categories --</option>
                        <option value="cash_bank">Cash / Bank</option>
                        <option value="debtors">Customers (Debtors)</option>
                        <option value="creditors">Suppliers (Creditors)</option>
                        <option value="expenses">Expenses</option>
                        <option value="sales">Sales Accounts</option>
                        <option value="purchase">Purchase Accounts</option>
                        <option value="capital">Capital Account</option>
                    </select>
                </td>
                <td>
                    <select class="form-control row-ledger" required>
                        <!-- Populated by filterLedgers -->
                    </select>
                </td>
                <td>
                    <input type="number" step="0.01" min="0.01" class="form-control row-amount" placeholder="0.00" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-remove-row"><i class="i-Close-Window"></i></button>
                </td>
            </tr>
        `;

        $('#tbody_voucher_rows').append(rowHtml);
        
        // Initial populate of the new ledger dropdown
        var $newRow = $('#row_' + rowCount);
        filterLedgers($newRow.find('.row-ledger'), '');
        
        calculateTotals();
    }

    // Handle Group Category change to filter Ledgers in the same row
    $(document).on('change', '.row-group-filter', function() {
        var category = $(this).val();
        var $rowLedger = $(this).closest('tr').find('.row-ledger');
        filterLedgers($rowLedger, category);
    });

    // Remove row
    $(document).on('click', '.btn-remove-row', function() {
        if ($('#tbody_voucher_rows tr').length <= 2) {
            fun_message('warning', 'Validation', 'An accounting voucher must have at least two entries.', 'toast-bottom-right');
            return;
        }
        $(this).closest('tr').remove();
        calculateTotals();
    });

    // Recalculate totals on input changes
    $(document).on('change keyup', '.row-amount, .row-type', function() {
        calculateTotals();
    });

    function calculateTotals() {
        var totalDr = 0;
        var totalCr = 0;

        $('#tbody_voucher_rows tr').each(function() {
            var type = $(this).find('.row-type').val();
            var amt = parseFloat($(this).find('.row-amount').val()) || 0;

            if (type === 'Dr') {
                totalDr += amt;
            } else {
                totalCr += amt;
            }
        });

        var diff = Math.abs(totalDr - totalCr);

        $('#total_debit_display').val(totalDr.toFixed(2));
        $('#total_credit_display').val(totalCr.toFixed(2));
        $('#difference_display').val(diff.toFixed(2));

        if (diff > 0.001) {
            $('#difference_display').css('color', 'red');
            $('#btn_submit_voucher').prop('disabled', true);
        } else if (totalDr <= 0) {
            $('#btn_submit_voucher').prop('disabled', true);
        } else {
            $('#difference_display').css('color', 'green');
            $('#btn_submit_voucher').prop('disabled', false);
        }
    }

    // Submit form
    $('#form_voucher_entry').on('submit', function(e) {
        e.preventDefault();

        // 1. Gather rows
        var entries = [];
        var isValid = true;

        $('#tbody_voucher_rows tr').each(function() {
            var type = $(this).find('.row-type').val();
            var ledgerId = $(this).find('.row-ledger').val();
            var amt = parseFloat($(this).find('.row-amount').val()) || 0;

            if (!ledgerId) {
                isValid = false;
                return false; // break loop
            }

            entries.push({
                type: type,
                ledger_id: ledgerId,
                amount: amt
            });
        });

        if (!isValid) {
            fun_message('error', 'Validation Error', 'Please select a ledger for all rows.', 'toast-bottom-right');
            return;
        }

        var date = $('#voucher_date').val();
        var type = $('#voucher_type').val();
        var narration = $('#narration').val();

        $('.loader').show();
        $.post('<?= base_url("index.php/account/voucher/save") ?>', {
            date: date,
            type: type,
            narration: narration,
            entries: entries
        }, function(res) {
            $('.loader').hide();
            var parts = res.trim().split('~');
            if (parts[0] === 'Save') {
                fun_message('success', 'Voucher Saved', 'Voucher ' + parts[1] + ' successfully created.', 'toast-bottom-right');
                showPage('Account/voucher');
            } else {
                fun_message('error', 'Error Saving Voucher', res, 'toast-bottom-right');
            }
        });
    });
});
</script>
