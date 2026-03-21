<div class="table-responsive">
  <table class="table table-bordered  table-sm" id="printed_table">
    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      <tr>
          <th>#</th>
          
          <th>Complain Date</th>
          <th>Type</th>
          <th>Name</th>
          <th>Qty</th>
          <th>Amount (Rs.)</th>
          <th>Unit</th>

          <th>No of Coils</th>
          <th>Priority</th>
          <th>Status</th>
          <th>Report</th>
          <th>Edit</th>
        </tr>
    </thead>
    <tbody>
      <?php 
        $i=1;
        foreach($res2 as $r)
        {
          if(isset($r['complain_date'])){$complain_date=$this->Base->change_date_dmy($r['complain_date']);}else{$complain_date='';}
          ?>
          <tr>
                <td><?php echo $i;?>.</td>
                
                <td><?php echo $complain_date;?></td>
                <td><?php if(isset($r['type']))echo $r['type'];?></td>
                <td><?php if(isset($r['cname']))echo $r['cname'];?></td>
                <td><?php if(isset($r['defect_qty']))echo $r['defect_qty'];?></td>
                <td><?php if(isset($r['defect_amount']))echo $r['defect_amount'];?></td>
                <td><?php if(isset($r['defect_unit']))echo $r['defect_unit'];?></td>

                <td><?php if(isset($r['defect_bobbin']))echo $r['defect_bobbin'];?></td>
                <td><?php if(isset($r['priority']))echo $r['priority'];?></td>
                <td><?php if(isset($r['status']))echo $r['status'];?></td>
                <td>
                    <a  target="_blank" href="<?php echo base_url();?>index.php/Customer/comp_report/<?php if(isset($r['comp_id']))echo $r['comp_id']?>"  class="btn btn-info" style="width:100%;" >Report</a>
                </td>
                <td>
                  <a href="<?php base_url()?>home?Customer/comp_entry/<?php if(isset($r['comp_id']))echo $r['comp_id']?>" target="_blank"  class="btn btn-warning" style=" float:left;">
                      <i class="nav-icon i-Pen-2"></i>
                    </a>
                </td>
            <tr>
					<?php
        $i++; 
      }
      ?>
    </tbody>
  </table>
</div>