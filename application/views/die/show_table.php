<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Die Type</th>
                <th>Die No</th>
                <th>Manufacturing No</th>
                <th>Pallet</th>
                <th>Size</th>
                <th>Location</th>
                <th>Machine</th>
                <th>Edit</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
          $i=1;
          foreach($res2 as $r)
          {
            if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
            if($r['location'] == 'Stock'){
                $color="green";
            }
            elseif($r['location'] == 'M/C'){
                $color="red";
            }
            elseif($r['location'] == 'Repair'){
                $color="blue";
            }
            else{
                $color="";
            }
          ?>
              <tr>
                  <td><?php echo $i;?>.</td>
                  <td><?php echo $entry_date;?></td>
                  <td><?php if(isset($r['die_type']))echo $r['die_type'];?></td>
                  <td><?php if(isset($r['die_no']))echo $r['die_no'];?></td>
                  <td><?php if(isset($r['menu_no']))echo $r['menu_no'];?></td>
                  <td><?php if(isset($r['pname']))echo $r['pname'];?></td>
                  <td><?php if(isset($r['size']))echo $r['size'];?></td>
                  <td style="font-weight:bold;color:<?php echo $color;?>"><?php if(isset($r['location']))echo $r['location'];?></td>
                  <td><?php if(isset($r['mname']))echo $r['mname'];?></td>
                  <td>
                      <a  href="<?php base_url()?>home?Ddie/new_die_entry/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                          <i class="nav-icon i-Pen-2"></i>
                      </a>
                  </td>
                  
              </tr>
          <?php
          $i++; 
          }
          ?>
                  
        </tbody>
    </table>
</div>