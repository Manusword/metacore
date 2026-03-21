<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                  <th>Entry Date</th>
                  <th>Dept</th>
                  <th>M/C No</th>
                  <th>Grade</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>Person</th>
                  <th>Shift Incharge</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>Person</th>
                  <th>Shift Incharge</th>
                  <th>Total Qty</th>
                  <th>Edit</th>
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
                  <td><?php echo $entry_date;?></td>
                  <td><?php if(isset($r['dept_name']))echo $r['dept_name'];?></td>
                  <td><?php if(isset($r['mc_name']))echo $r['mc_name'];?></td>
                  <td><?php if(isset($r['grade_name']))echo $r['grade_name'];?></td>
                  
                  <td><?php if(isset($r['qty1']))echo $qty1[] = $r['qty1'];?></td>
                  <td><?php if(isset($r['unit_name1']))echo $r['unit_name1'];?></td>
                  <td><?php if(isset($r['person1']))echo $r['person1'];?></td>
                  <td><?php if(isset($r['shift_inchage1']))echo $r['shift_inchage1'];?></td>

                  <td><?php if(isset($r['qty2']))echo $qty2[] = $r['qty2'];?></td>
                  <td><?php if(isset($r['unit_name2']))echo $r['unit_name2'];?></td>
                  <td><?php if(isset($r['person2']))echo $r['person2'];?></td>
                  <td><?php if(isset($r['shift_inchage2']))echo $r['shift_inchage2'];?></td>
                  <td><?php if(isset($r['total_scrap']))echo $total_scrap[] = $r['total_scrap'];?></td>

                  <td>
                      <a  href="<?php base_url()?>home?Production/add_short/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                          <i class="nav-icon i-Pen-2"></i>
                      </a>
                  </td>
              </tr>
          <?php
          $i++; 
          }
          ?>
          <tr>
              <td>#</td>
                <td colspan="4"></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($qty1))echo $a1 = round(array_sum($qty1));?></td>
                <td colspan="3"></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($qty2))echo $a2 = round(array_sum($qty2));?></td>
                <td colspan="3"></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($total_scrap))echo  round(array_sum($total_scrap));?></td>
                <td></td>                                         
          </tr>            
        </tbody>
    </table>
</div>