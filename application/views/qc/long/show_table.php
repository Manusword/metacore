<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                    <th>#</th>
                    <th>Edit</th>
                    <th>Process</th>
                    <th>Production Date</th>
                    <th>Shift</th>
                    <th>Dept</th>
                    <th>M/C No</th>
                    <th>Base Size (mm)</th>
                    <th>Grade</th>
                    <th>Heat No</th>
                    <th>Product</th>
                    <th>Finish Size (mm)</th>

                    <th>Coil Dia (mm)</th>
                    <th>Coil From - To</th>
                    
                    <th>No of Coils Test</th>
                    <th>Pass Coils</th>
                    <th>NC Coils</th>
                    <th>Reason</th>
                    <th>OP</th>
                    <th>Customer</th>
                   
                    <th>Diversion</th>
            </tr>
      </thead>
      <tbody>
		<?php 
         
          $i=1;
          foreach($res2 as $r)
          {
            
            if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
            ?>
              <tr>
                  <td><?php echo $i;?>.</td>
                  <td>
                      <a  href="<?php base_url()?>home?Qc/long_test_add/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                          <i class="nav-icon i-Pen-2"></i>
                      </a>
                  </td>
                  <td>
                      <a  href="<?php base_url()?>home?Qc/test1_add/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-info" >
                          <i class="nav-icon i-Pen-2"></i>
                      </a>
                  </td>
                  <td><?php echo $entry_date;?></td>
                  <td><?php if(isset($r['shift']))echo $r['shift'];?></td>
                  <td><?php if(isset($r['dname']))echo $r['dname'];?></td>
                  <td><?php if(isset($r['mname']))echo $r['mname'];?></td>
                  <td><?php if(isset($r['base_size']))echo $r['base_size'];?></td>
                  <td><?php if(isset($r['grade_name']))echo $r['grade_name'];?></td>
                  <td><?php if(isset($r['batch_no']))echo $r['batch_no'];?></td>
                  <td><?php if(isset($r['ptname']))echo $r['ptname'];?></td>
                  <td><?php if(isset($r['finish_size']))echo $r['finish_size'];?></td>
                  
                  <td><?php if(isset($r['coil_dia']))echo $r['coil_dia'];?></td>
                  <td><?php if(!empty($r['coil_dia_from']))echo $t2[] =  $r['coil_dia_from'];echo " - "; if(!empty($r['coil_dia_to']))echo $t3[] = $r['coil_dia_to'];?></td>
                  <td><?php if(!empty($r['total_coils']))echo $t4[] = $r['total_coils'];?></td>
                  <td><?php if(!empty($r['total_pass_coils']))echo $t5[] = $r['total_pass_coils'];?></td>
                  <td><?php if(!empty($r['total_nc_coils']))echo $t6[] = $r['total_nc_coils'];?></td>
                  <td><?php if(isset($r['nc_reason']))echo $r['nc_reason'];?></td>
                  <td><?php if(isset($r['operator1']))echo $r['operator1'];?></td>
                  <td><?php if(isset($r['cname']))echo $r['cname'];?></td>
                  <td><?php if(isset($r['diversion']))echo $r['diversion'];?></td>
                  
              </tr>
          <?php
          $i++; 
          }
          ?>

            <tr>
                <td>#</td>
             
                <td colspan="12"></td>
                <td><?php //if(!empty($t2))echo array_sum($t2); echo " - ";  if(!empty($t3))echo array_sum($t3);?></td>
                <td><?php if(!empty($t4))echo array_sum($t4);?></td>
                <td><?php if(!empty($t5))echo array_sum($t5);?></td>
                <td><?php if(!empty($t6))echo array_sum($t6);?></td>
                <td colspan="4"></td>
                                                     
            </tr>   
        </tbody>
    </table>
</div>