<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$role_list='';
if (!empty($type_search_list) && is_array($type_search_list)) {    
    $role_list = implode(",", $type_search_list);
}


$month_name = date('F Y', strtotime($year.'-'.$month.'-01'));

$rows = $rows ?? [];

?>



<style>
/* ================= PRINT MODE ================= */
@page {
    size: A4 portrait;
    margin: 15mm;
}

@media print {
    body {
        margin: 0;
        padding: 0;
    }

    #print-area {
        display: block;
    }

    .salarySlip {
        width: 100%;
        height: 130mm;
        margin-bottom: 10mm;
        box-sizing: border-box;
        padding-top: 5mm;
        border: none !important;          /* ❌ no outer border */
        page-break-inside: avoid;
        break-inside: avoid;
    }

    .salarySlip:nth-child(2n) {
        page-break-after: always;
    }

    .salarySlip:nth-child(2n+1) {
        margin-top: 5mm;
    }
}

/* ================= PDF MODE ================= */
.pdf-mode{
    width: 210mm;
    box-sizing: border-box;
}

/* slip container */
.pdf-mode .salarySlip{
    padding: 5mm;
    border: none !important;              /* ❌ no outer border */
}

/* table */
.pdf-mode table{
    width: 100% !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    border: none !important;              /* ❌ no table border */
}

/* tr */
.pdf-mode tr{
    border: none !important;              /* ❌ no row border */
}

/* td / th — ONLY PLACE WHERE BORDER EXISTS */
.pdf-mode th,
.pdf-mode td{
    border: 1px solid #000 !important;    /* ✅ single clean border */
    padding: 2px 3px !important;
    text-align: center !important;
    vertical-align: middle !important;
    box-sizing: border-box;
}

/* alignment override */
.pdf-mode .text-left,
.pdf-mode .text-right{
    text-align: center !important;
}

.bold{
    font-weight: bolder;
}
</style>


 <button class="btn btn-info m-1" onclick="savePDFSalary_slip()">📄 PDF Salary Slip</button>


<div id="print-area">

     
            <?php if ($rows): ?>
                <?php $i=1; foreach ($rows as $r): 

                
                //getcompnay details form company_role
                $comp = array();
                if(isset($r['company_role'])){
                    $comp = $this->Base->get_details_contractor_with_id($r['company_role']);
                }
                ?>



               

                    <!-- ================= SLIP 1 ================= -->
                    <div class="salarySlip">

                        <table>
                        <tr>
                            <td colspan="4" class="center no-border">
                                <div class="title"><?php if(!empty($comp))echo $comp[0]['full_name'];?></div>
                                <div class="subtitle"><?php if(!empty($comp))echo $comp[0]['address'];?></div>
                                <div class="subtitle">SALARY SLIP FOR THE MONTH OF <?php echo $month.'/'.$year; ?></div>
                            </td>
                        </tr>
                        </table>

                        <table>
                        <tr class="no-row-border" >
                            <td >Emp Code. | Bio Code.</td>
                            <td >Employee Name</td>
                            <td >Department</td>
                            <td >Designation</td>
                        </tr>
                        <tr class="no-row-border">
                            <td class="bold"><?php if(isset($r['emp_code']))echo $r['emp_code']; echo " | "; if(isset($r['bio_code']))echo $r['bio_code']?></td>
                            <td class="bold"><?php echo $r['first_name'].' '.$r['last_name'];?></td>
                            <td class="bold"><?php if(isset($r['department']))echo $r['department'];?></td>
                            <td class="bold"><?php if(isset($r['designation']))echo $r['designation'];?></td>
                        </tr>
                        <tr class="no-row-border"  >
                            <td></td>    
                            <td >Father / Husband Name</td>
                            <td >Salary (CTC)</td>
                            <td >Date of Joining</td>
                        </tr>
                        <tr class="no-row-border">
                            <td></td>    
                            <td class="bold"><?php if(isset($r['father_name']))echo $r['father_name'];?></td>
                            <td class="bold"><?php if(isset($r['current_ctc']))echo round($r['current_ctc'],2);?></td>
                            <td class="bold"><?php
                                if (!empty($r['doj']) && $r['doj'] != '0000-00-00') {
                                    echo date('d-m-Y', strtotime($r['doj']));
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="no-row-border"  >
                            <td>Total Monthly Days</td>
                            <td>No. of Days Worked</td>
                            <td>Payment Mode</td>
                            <td>NEFT</td>
                        </tr>
                        <tr class="no-row-border">
                            <td class="bold"><?php if(isset($r['total_day_in_month']))echo $r['total_day_in_month'];?></td>
                            <td class="bold"><?php if(isset($r['total_present']))echo $r['total_present'];?></td>
                            <td class="bold"><?php if(isset($r['bank_account']))echo $r['bank_account'];?></td>
                            <td class="bold"><?php if(isset($r['bank_ifsc']))echo $r['bank_ifsc'];?></td>
                        </tr>
                        </table>

                        <table>
                        <tr>
                            <td class="section-title" colspan="2">EARNINGS</td>
                            <td class="section-title" colspan="2">DEDUCTIONS</td>
                        </tr>
                        <tr class="no-row-border">
                            <td >Earned Basic</td>
                            <td class="right" s><?php if(isset($r['basic_salary_payable']))echo round($r['basic_salary_payable'],2);?></td>
                            <td >EPF No:  <?php if(isset($r['emp_uan']))echo $r['emp_uan'];?></td></td>
                            <td class="right" style="border-left: none !important;"><?php if(!empty($r['epf_payable'])){echo round($r['epf_payable'],2);}else{echo "FALSE";}?></td>
                        </tr>
                        <tr class="no-row-border">
                            <td >Earned HRA</td>
                            <td class="right"  s><?php if(isset($r['hra_payable']))echo round($r['hra_payable'],2);?></td>
                            <td >ESI No: <?php if(isset($r['esi_code']))echo $r['esi_code'];?></td>
                            <td class="right"  style="border-left: none !important;"><?php if(!empty($r['esic_payable'])){echo round($r['esic_payable'],2);}else{echo "FALSE";}?></td>
                        </tr>
                        <tr class="no-row-border">
                            <td >Earned Special Allowance</td>
                            <td class="right"  s><?php if(isset($r['other_allow_payable']))echo round($r['other_allow_payable'],2);?></td>
                            <td >Staff Advance</td>
                            <td class="right"  style="border-left: none !important;"><?php if(isset($r['advance_this_month_payable']))echo round($r['advance_this_month_payable'],2);?></td>
                        </tr>
                        <tr class="no-row-border">
                            <td >Education Allowance</td>
                            <td class="right"  s><?php if(isset($r['conv_payable']))echo round($r['conv_payable'],2);?></td>
                            <td >TDS Recovery</td>
                            <td class="right"  style="border-left: none !important;"><?php if(isset($r['lost_3']))echo round($r['lost_3'],2);?></td>
                        </tr>
                        <tr class="no-row-border">
                            <td >Others</td>
                            <td class="right"  s><?php if(isset($r['city_comp_payable']))echo round($r['city_comp_payable'],2);?></td>
                            <td >Other Deduction</td>
                            <td class="right"  style="border-left: none !important;"><?php if(isset($r['lost_canteen_payable']))echo round($r['lost_canteen_payable'],2);?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="bold right" ><?php if(isset($r['current_ctc_payable']))echo round($r['current_ctc_payable'],2);?></td>
                            <td colspan="2" class="bold right"><?php if(isset($r['total_deduction']))echo round($r['total_deduction'],2);?></td>
                        </tr>
                        </table>

                        <table>
                        <tr>
                            <td class="bold" colspan="2">Nett Salary Payable : <?php if(isset($r['current_total_ctc_payable']))echo round($r['current_total_ctc_payable'],2);?> </td>
                            <td class="center">for <?php if(!empty($comp))echo $comp[0]['full_name'];?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><?php if(isset($r['current_total_ctc_payable']))echo $this->Base->convert_number_to_words($r['current_total_ctc_payable']); ?></td>
                            <td class="signature">Authorised Signatory</td>
                        </tr>
                        </table>

                    </div>

                

               
                <?php endforeach; ?>
                <?php else: ?>
                <p>No Records Found</p>
                <?php endif; ?>
          
    
 </div>

<script>
function savePDFSalary_slip(){
    const slips = document.querySelectorAll('.salarySlip');
    if(!slips.length) return;

    const wrapper = document.createElement('div');
    wrapper.className = 'pdf-mode';

    slips.forEach((slip, i) => {
        const clone = slip.cloneNode(true);
        wrapper.appendChild(clone);

        /* 🔥 3 slips per PDF page */
        if ((i + 1) % 3 === 0) {
            const br = document.createElement('div');
            br.style.pageBreakAfter = 'always';
            wrapper.appendChild(br);
        }
    });

    document.body.appendChild(wrapper);

    html2pdf().set({
        margin: 0,
        filename: 'salarySlip.pdf',
        html2canvas: {
            scale: 3,
            useCORS: true,
            backgroundColor: '#ffffff'
        },
        jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait'
        }
    }).from(wrapper).save().then(()=>{
        document.body.removeChild(wrapper);
    });
}
</script>
