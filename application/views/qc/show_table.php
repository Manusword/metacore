<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Edit</th>
                <th>Type 1</th>
                <th>Type 2</th>
                <th>Grade</th>
                <th>Size</th>
                <th>Min-Max Tol</th>
                <th>Min-Max Size</th>
                
                <th>Min-Max Ovality</th>
                <th>Min-Max TS SS-I</th>
                <th>Min-Max TS SS-II</th>
                <th>Min-Max TS SS-III</th>
                <th>Remarks</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
          $i=1;
          foreach($res2 as $r)
          {
              
          ?>
              <tr>
                  <td><?php echo $i;?>.</td>
                  <td>
                      <a  href="<?php base_url()?>home?Qc/spec1_add/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                          <i class="nav-icon i-Pen-2"></i>
                      </a>
                  </td>
                  <td><?php if(isset($r['type1']))echo $r['type1'];?></td>
                  <td><?php if(isset($r['type2']))echo $r['type2'];?></td>
                  <td><?php if(isset($r['grade_name']))echo $r['grade_name'];?></td>
                  <td><?php if(isset($r['size']))echo $r['size'];?></td>
                  <td><?php if(isset($r['min_tole']) and isset($r['max_tole']))echo $r['min_tole'].' - '.$r['max_tole'];?></td>
                  <td><?php if(isset($r['min_size']) and isset($r['max_size']))echo $r['min_size'].' - '.$r['max_size'];?></td>
                 
                  <td><?php if(isset($r['ovality_max']) and isset($r['ovality_size_max']))echo $r['ovality_max'].' ('.$r['ovality_size_max'].')';?></td>

                  <td><?php if(isset($r['ts_min_ss1']) and isset($r['ts_max_ss1']))echo $r['ts_min_ss1'].' - '.$r['ts_max_ss1'];?></td>
                  <td><?php if(isset($r['ts_min_ss2']) and isset($r['ts_max_ss2']))echo $r['ts_min_ss2'].' - '.$r['ts_max_ss2'];?></td>
                  <td><?php if(isset($r['ts_min_ss3']) and isset($r['ts_max_ss3']))echo $r['ts_min_ss3'].' - '.$r['ts_max_ss3'];?></td>
                  <td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
                  
              </tr>
          <?php
          $i++; 
          }
          ?>
                  
        </tbody>
    </table>
</div>