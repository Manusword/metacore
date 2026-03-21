<div class="table-responsive">
  <table class="table table-bordered table-striped table-sm" id="printed_table">
    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      <tr>
          <th>#</th>
          <th>Name</th>
          <th>Approved No.</th>
          <th>Type</th>
          <th>Product Type</th>
          <th>Telphone</th>
          <th>Person 1</th>
          <th>Person 2</th>
          <th>City</th>
          <th>State</th>
          <th>GST</th>
          <th>Payment Terms</th>
          <th>Place Of Delivery</th>
          <th>Mode Of Dispatch</th>
          <th>ID</th>
          <th>Option</th>
      </tr>
    </thead>
    <tbody>
      <?php 
          $i=1;
          foreach($res2 as $r)
          {
          ?>
            <tr <?php  if(isset($r['status'])){if($r['status']=='Banned'){?>style="color:red" <?php }}?>>
                <td>
                  <?php echo $i;?>.
                  <?php  if(isset($r['status'])){if($r['status']=='Active'){?><span class="badge badge-success">A</span> <?php }}?>
                  <?php  if(isset($r['status'])){if($r['status']=='Deactive'){?><span class="badge badge-danger">D</span> <?php }}?>
                  <?php  if(isset($r['status'])){if($r['status']=='Pending'){?><span class="badge badge-warning">P</span> <?php }}?>
                  <?php  if(isset($r['status'])){if($r['status']=='Banned'){?><span class="badge badge-danger">Banned</span> <?php }}?>
                </td>
							  
                <td><?php if(isset($r['name']))echo $r['name'];?></td>
                <td><?php if(!empty($r['approved_no'])){echo $r['approved_no'];}?></td>
								<td><?php if(isset($r['type']))echo $r['type'];?></td>
                <td><?php if(isset($r['product_type']))echo $r['product_type'];?></td>
                <td><a href="tel<?php if(isset($r['telphone']))echo $r['telphone'];?>:"><?php if(isset($r['telphone']))echo $r['telphone'];?></a></td>
								<td>
                  <?php if(isset($r['con_name1']))echo $r['con_name1'];?>,
                  <?php if(isset($r['con_mob1']))echo $r['con_mob1'];?>,
                  <?php if(isset($r['con_email1']))echo $r['con_email1'];?>
                </td>
                <td>
                  <?php if(isset($r['con_name2']))echo $r['con_name2'];?>
                  <?php if(isset($r['con_mob2']))echo $r['con_mob2'];?>,
                  <?php if(isset($r['con_email2']))echo $r['con_email2'];?>
                </td>
								<td><?php if(isset($r['city']))echo $r['city'];?></td>
                <td><?php if(isset($r['state']))echo $r['state'];?></td>
                <td><?php if(isset($r['gst_no']))echo $r['gst_no'];?></td>
                <td><?php if(isset($r['payment_terms']))echo $r['payment_terms'];?></td>
                <td><?php if(isset($r['del_place']))echo $r['del_place'];?></td>
                <td><?php if(isset($r['mod_of_dis']))echo $r['mod_of_dis'];?></td>
                <td><?php if(isset($r['id']))echo $r['id'];?></td>
								<td>
                    <a href="<?php base_url()?>home?Supplier/add/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"  class="btn btn-warning" style=" float:left;">
                      <i class="nav-icon i-Pen-2"></i>
                    </a>
                    <?php /*
                    <a style=" margin-left:10px; float:left; margin-left:1px;" href="<?php echo base_url()?>index.php/Ajex/supplier_ledger/<?php echo $r['id']?>" target="_blank" title="Supplier Ledger" class="btn btn-primary "  >
                        <span class="fa fa-book"></span>
                    </a>
                    <a style=" margin-left:10px; float:left; margin-left:1px;" href="<?php echo base_url()?>index.php/Supplier/supplier_rate_list/<?php echo $r['id']?>" target="_blank" title="Supplier Rate List" class="btn btn-success " >
                        <span class="fa fa-book"></span>
                    </a>
                    */?>
                </td>
              </tr>
						<?php
            $i++; 
          }//foreach
          ?>
        </tbody>
    </table>
</div>
                               
            