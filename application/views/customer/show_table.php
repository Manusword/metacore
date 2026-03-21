<div class="table-responsive">
  <table class="table table-bordered table-striped table-sm" id="printed_table">
    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      <tr>
          <th>#</th>
          <th>Edit</th>
          <th>Name</th>
          <th>Vender Code</th>
          <th>Type</th>
          <th>Telphone</th>
          <th>Person Details 1</th>
          <th>Person Details 2</th>
          <th>City</th>
          <th>State</th>
          <th>GST</th>
          <th>Sales Person</th>
          <th>Area / Loaction</th>
          
        </tr>
    </thead>
    <tbody>
      <?php 
        $i=1;
        foreach($res2 as $r)
        {
          ?>
          <tr>
                <td><?php echo $i;?>.
                  <?php  if(isset($r['status'])){if($r['status']=='Active'){?><span class="badge badge-success">A</span> <?php }}?>
                  <?php  if(isset($r['status'])){if($r['status']=='Deactive'){?><span class="badge badge-danger">D</span> <?php }}?>
                  <?php  if(isset($r['status'])){if($r['status']=='Pending'){?><span class="badge badge-warning">P</span> <?php }}?>
                  <?php  if(isset($r['status'])){if($r['status']=='Banned'){?><span class="badge badge-info">B</span> <?php }}?>
                </td>
                <td>
                  <a href="<?php base_url()?>home?Customer/add/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"  class="btn btn-warning" style=" float:left;">
                      <i class="nav-icon i-Pen-2"></i>
                    </a>
                </td>
                <td><?php if(isset($r['name']))echo $r['name'];?></td>
                <td><?php if(isset($r['vender_code']))echo $r['vender_code'];?></td>
                <td <?php if(isset($r['type']) and $r['type']=='Supplier'){?> style="background-color:pink" <?php }?>><?php if(isset($r['type']))echo $r['type'];?></td>
                <td><a href="tel<?php if(isset($r['telphone']))echo $r['telphone'];?>:"><?php if(isset($r['telphone']))echo $r['telphone'];?></a></td>
                <td>
                    <?php if(isset($r['con_name1']))echo $r['con_name1'];?>,
                    <?php if(isset($r['con_mob1']))echo $r['con_mob1'];?>,
                    <?php if(isset($r['con_email1']))echo $r['con_email1'];?>
                </td>
                <td>
                    <?php if(isset($r['con_name2']))echo $r['con_name2'];?>,
                    <?php if(isset($r['con_mob2']))echo $r['con_mob2'];?>,
                    <?php if(isset($r['con_email2']))echo $r['con_email2'];?>
                </td>
                <td><?php if(isset($r['city']))echo $r['city'];?></td>
                <td><?php if(isset($r['state']))echo $r['state'];?></td>
                <td><?php if(isset($r['gst_no']))echo $r['gst_no'];?></td>
                <td><?php if(isset($r['sales_person']))echo $r['sales_person'];?></td>
                <td><?php if(isset($r['area_location']))echo $r['area_location'];?></td>
                
            <tr>
					<?php
        $i++; 
      }
      ?>
    </tbody>
  </table>
</div>