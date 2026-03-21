<?php 
$canEdit = $this->Company->checkPermission3("Hr/emp_edit_access");
?>
<button id="download_epf_btn" class="btn btn-primary no-print">
    Download EPF Text File
</button>
<button id="download_epf_excel_btn" class="btn btn-success no-print">
    Download EPF Excel
</button>

<div class="">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>Sno</th>
                <th>Edit</th>

                <th>UAN</th>
                <!-- <th>Prv Member Id</th> -->
                <th>Member Name</th>
                <th>DOB</th>
                <th>DOJ</th>
                <th>Gender</th>
                <th>Father / Husband Name</th>
                <th>Relation</th>
                <th>Mobile No</th>
                <!-- <th>Email Id</th> -->
                <!-- <th>Nationality</th> -->
                <th>EPF Wages</th>
                <!-- <th>Qualification</th> -->
                <th>Marital Status</th>
                 <!-- <th>International Worker</th> -->
                <!--<th>Country Of Origin</th>
                <th>Passport Number</th>
                <th>Passport Valid From</th>
                <th>Passport Valid Till</th>
                <th>Physical Handicap</th>
                <th>Locomotive</th>
                <th>Hearing</th>
                <th>Visual</th> -->
                <th>Bank Account No</th>
                <th>IFSC</th>
                <th>Name As Per Bank</th>
                <th>PAN</th>
                <th>Name As Per PAN</th>
                <th>Aadhaar No</th>
                <th>Name As Per Aadhaar</th>

                <th>Text File Line</th>
            </tr>

        </thead>

        <tbody>
        <?php 
        $i = 1;
        foreach ($res2 as $r) {

            if($r['pf_ded'] != 'Yes') continue;

            $color = (isset($r['active']) && $r['active'] == 'Deactive') ? 'red' : 'black';

            $dob_fmt = (!empty($r['dob']) && $r['dob'] != '0000-00-00')
                ? $this->Base->change_date_dmy2($r['dob'])
                : '';

            $doj_fmt = (!empty($r['doj']) && $r['doj'] != '0000-00-00')
                ? $this->Base->change_date_dmy2($r['doj'])
                : '';

            $fname = $r['father_name'];
            $frel  = 'F';
            if ($r['gender'] == 'Female') {
                $fname = $r['spouse_name'];
                $frel  = 'H';
            }

            $epfo_string = implode('#~#', [
                $r['emp_uan'],                 // 1  UAN
                '',                             // 2  prvMemberId
                $r['first_name'],               // 3  memberName
                $dob_fmt,                       // 4  DOB
                $doj_fmt,                       // 5  DOJ
                strtoupper($r['gender'][0]),    // 6  Gender
                $fname,                         // 7  fatherHusbandName
                $frel,                          // 8  relation
                '',                             // 9  mobileNo
                '',                             // 10 emailId
                'Indian',                       // 11 nationality
                $r['current_total_ctc'],        // 12 epfWages
                '',                             // 13 qualification
                $this->Base->marital_status($r['emp_marrige_status']), // 14 maritalStatus ✅
                'N',                            // 15 isInternationalWorker
                '',                             // 16 countryOfOrigin
                '',                             // 17 passportNumber
                '',                             // 18 passportValidFrom
                '',                             // 19 passportValidTill
                'N',                            // 20 isPhisicalHandicap
                '',                             // 21 locomotive
                '',                             // 22 hearing
                '',                             // 23 visual
                '',                             // 24 BankAccNo
                '',                             // 25 Ifsc
                '',                             // 26 NameAsPerBank
                '',                             // 27 PAN
                '',                             // 28 NameAsPerPan
                $r['aadhar_no'],                // 29 AadhaarNo
                ''                              // 30 NameAsPerAadhaara
            ]);


        ?>
        <tr>
            <td><?php echo $i; ?></td>

            <td>
                <?php if ($canEdit): ?>
                    <a href="<?php echo base_url('index.php/Welcome/home?Hr/add_emp/'.$r['id']); ?>"
                    target="_blank"
                    class="btn btn-warning">
                        <i class="nav-icon i-Pen-2"></i>
                    </a>
                <?php endif; ?>
            </td>

            <!-- 1 UAN -->
            <td><?php echo $r['emp_uan']; ?></td>

           

            <!-- 3 Member Name -->
            <td style="color:<?php echo $color; ?>;"><?php echo strtoupper($r['first_name']); ?></td>

            <!-- 4 DOB -->
            <td><?php echo $dob_fmt; ?></td>

            <!-- 5 DOJ -->
            <td><?php echo $doj_fmt; ?></td>

            <!-- 6 Gender -->
            <td><?php echo strtoupper($r['gender'][0]); ?></td>

            <!-- 7 Father / Husband Name -->
            <td><?php echo strtoupper($fname); ?></td>

            <!-- 8 Relation -->
            <td><?php echo $frel; ?></td>

            <!-- 9 Mobile No -->
            <td></td>

          
          

            <!-- 12 EPF Wages -->
            <td><?php echo (int)$r['current_total_ctc']; ?></td>

          
            <!-- 14 Marital Status -->
            <td><?php echo strtoupper($this->Base->marital_status($r['emp_marrige_status'])); ?></td>

           
            
            <!-- 24 Bank Account No -->
            <td></td>

            <!-- 25 IFSC -->
            <td></td>

            <!-- 26 Name As Per Bank -->
            <td></td>

            <!-- 27 PAN -->
            <td></td>

            <!-- 28 Name As Per PAN -->
            <td></td>

            <!-- 29 Aadhaar No -->
            <td><?php echo $r['aadhar_no']; ?></td>

            <!-- 30 Name As Per Aadhaar -->
            <td></td>

            <!-- 31 Text File Line -->
            <td class="epf-text-line">
                <?php echo htmlspecialchars($epfo_string, ENT_QUOTES, 'UTF-8'); ?>
            </td>
        </tr>

            
        <?php 
            $i++;
        } 
        ?>
        </tbody>
    </table>
</div>

<br><br>

<script>
document.getElementById('download_epf_excel_btn').addEventListener('click', function () {

    const rows = [];

    // 🔴 ROW 1 : EXACT EPFO HEADER WITH #~# (NO CHANGE)
    rows.push([
        'UAN','#~#','prvMemberId','#~#','memberName','#~#','DOB','#~#','DOJ','#~#','Gender','#~#',
        'fatherHusbandName','#~#','relation','#~#','mobileNo','#~#','emailId','#~#','nationality','#~#',
        'epfWages','#~#','qualification','#~#','maritalStatus','#~#','isInternationalWorker','#~#',
        'countryOfOrigin','#~#','passportNumber','#~#','passportValidFrom','#~#','passportValidTill','#~#',
        'isPhisicalHandicap','#~#','locomotive','#~#','hearing','#~#','visual','#~#',
        'BankAccNo','#~#','Ifsc','#~#','NameAsPerBank','#~#','PAN','#~#',
        'NameAsPerPan','#~#','AadhaarNo','#~#','NameAsPerAadhaar',
        '' // ✅ LAST COLUMN
    ]);

    // 🔴 ROW 2 : YES / NO / NP (NO CHANGE)
    rows.push([
        'NO/YES','','NO','','YES','','YES','','YES','','YES','','YES','','YES','','NO','','NO','','YES','','YES','','NO','','YES (U/M/W/D)','',
        'NO (Y/N)','','YES','','NP','','NO','','NO','','NO (Y/N)','','NO','','NO','','NO','','NO','','NO','','NO','','NO','','NO','','NO','','NO',
        '' // last column empty
    ]);

    // 🔴 DATA ROWS
    document.querySelectorAll('.epf-text-line').forEach(td => {

        const epfoLine = td.textContent.trim();
        if (!epfoLine) return;

        const row = [];

        const parts = epfoLine.split('#~#');

        parts.forEach((val, i) => {
            row.push(val);
            if (i < parts.length - 1) row.push('#~#');
        });

        // ✅ ADD FULL STRING IN LAST COLUMN
        row.push(epfoLine);

        rows.push(row);
    });

    if (rows.length <= 2) {
        alert('No EPF data found');
        return;
    }

    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(rows);

    ws['!cols'] = rows[0].map((_, i) => ({
        wch: Math.max(...rows.map(r => (r[i] ? r[i].length : 0)), 12)
    }));

    XLSX.utils.book_append_sheet(wb, ws, 'EpfMembers');
    XLSX.writeFile(wb, 'EpfMembers.xlsx');
});
</script>



<script>
document.getElementById('download_epf_btn').addEventListener('click', function () {

    let lines = [];
    document.querySelectorAll('.epf-text-line').forEach(function (td) {
        let text = td.textContent.trim();
        if (text !== '') lines.push(text);
    });

    if (!lines.length) {
        alert('No EPF data found');
        return;
    }

    let content = lines.join('\r\n');
    let blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
    let url = URL.createObjectURL(blob);

    let a = document.createElement('a');
    a.href = url;
    a.download = 'EpfMembers.txt';
    document.body.appendChild(a);
    a.click();

    document.body.removeChild(a);
    URL.revokeObjectURL(url);
});
</script>