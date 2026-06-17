<?php
class Ddiemodel extends CI_Model
{
	
    
    //get get_die_data_with_ die no
	public function get_die_data_with_dieno($die_no)
	{
        $sql = "SELECT  A.id,A.entry_date,A.die_no,A.die_type,A.menu_no,A.size,A.location,A.mc_id,A.re_mc_no,
                P.pallet as pname,P.code as pcode,
                M.name as mname
                FROM ddie as A 
                LEFT JOIN ddie_pallet P ON P.id=A.pallet_id
                LEFT JOIN machine_list M ON M.mc_id=A.mc_id
                where die_no='$die_no' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


     //get get_die_data_with_id
	public function get_die_data_with_id($id)
	{
        $sql = "SELECT * FROM ddie  where id='$id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    // search 
    public function get_die_data_with_dieno_search($search)
    {
        $sql=" SELECT A.id,A.entry_date,A.die_no,A.die_type,A.menu_no,A.size,A.location,A.mc_id,A.re_mc_no,
                P.pallet as pname,P.code as pcode,
                M.name as mname
                FROM ddie as A 
                LEFT JOIN ddie_pallet P ON P.id=A.pallet_id
                LEFT JOIN machine_list M ON M.mc_id=A.mc_id
                where 1=1  $search 
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //get get_die_data_with_ die no
	public function get_die_data_with_size($size,$location)
	{
        $sql = "SELECT  A.id,A.entry_date,A.die_no,A.die_type,A.menu_no,A.size,A.location,A.mc_id,A.re_mc_no,
                P.pallet as pname,P.code as pcode,
                M.name as mname
                FROM ddie as A 
                LEFT JOIN ddie_pallet P ON P.id=A.pallet_id
                LEFT JOIN machine_list M ON M.mc_id=A.mc_id
                where A.size='$size' and A.location='$location' GROUP BY A.die_no  ORDER BY A.size ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get get_die_data_with_ machine id no
	public function get_die_data_with_mc_id($mc_id,$location)
	{
        $sql = "SELECT  A.id,A.entry_date,A.die_no,A.die_type,A.menu_no,A.size,A.location,A.mc_id,A.re_mc_no,
                P.pallet as pname,P.code as pcode,
                M.name as mname
                FROM ddie as A 
                LEFT JOIN ddie_pallet P ON P.id=A.pallet_id
                LEFT JOIN machine_list M ON M.mc_id=A.mc_id
                where A.mc_id='$mc_id' and A.location='$location' GROUP BY A.die_no ORDER BY A.size ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close




    // Group by size 
    public function get_all_die_group_by_size($location)
    {
        $sql=" SELECT size FROM ddie  where  location = '$location' GROUP BY size ORDER BY size ASC";
        $query = $this->db->query($sql);
        $out = $query->result_array();
        //print_r($out);
        ?>
            <table border=1 width="100%">
                    <tr>
                        <td>#</td>
                        <td>Size</td>
                        <td>Details</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                                <table  width="100%">
                                    <tr>
                                        <th  width="30">#</th>
                                        <th width="100">Die No</th>
                                        <th width="100">Size</th>
                                        <th width="100">Date</th>
                                        <th width="100">Die Type</th>
                                        <th width="100">Manuf. No</th>
                                        <th width="100">Pallet</th>
                                        <th width="100">Location</th>
                                        <th width="100">Machine</th>
                                    </tr>
                                </table>
                        </td>
                    </tr>
                    <?php 
                    $i=1;
                    foreach($out as $o)
                    {
                        $size = $o['size'];
                        $out2 = $this->get_die_data_with_size($size,$location);
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $size;?></td>
                            <td>
                                <table  width="100%" >
                                    
                                    <?php 
                                        $j=1;
                                        foreach($out2 as $r)
                                        {
                                            if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
                                        ?>
                                             <tr>
                                                <td  width="30"><?php echo $j;?>.</td>
                                                <td  width="100"><?php if(isset($r['die_no']))echo $r['die_no'];?></td>
                                                <td  width="100"><?php if(isset($r['size']))echo $r['size'];?></td>
                                                <td  width="100"><?php echo $entry_date;?></td>
                                                <td  width="100"><?php if(isset($r['die_type']))echo $r['die_type'];?></td>
                                                <td  width="100"><?php if(isset($r['menu_no']))echo $r['menu_no'];?></td>
                                                <td  width="100"><?php if(isset($r['pname']))echo $r['pname'];?></td>
                                                <td  width="100"><?php if(isset($r['location']))echo $r['location'];?></td>
                                                <td  width="100"><?php if(isset($r['mname']))echo $r['mname'];?></td>
                                            </tr>
                                        <?php
                                        $j++; 
                                        }
                                    ?>
                                </table>
                                
                            </td>
                        </tr>
                        <?php 
                        $i++;
                    }
                    ?>
            </table>
        <?php
    }//function close


    // Group by machine 
    public function get_all_die_group_by_machine($location)
    {
        $sql = "SELECT A.mc_id,M.name as mname  FROM ddie as A LEFT JOIN machine_list M ON M.mc_id=A.mc_id
                WHERE A.location = '$location' GROUP BY A.mc_id ORDER BY M.name ASC";
        $query = $this->db->query($sql);
        $out = $query->result_array();
        //print_r($out);
        ?>
            <table border=1 width="100%">
                    <tr>
                        <td>#</td>
                        <td>Size</td>
                        <td>Details</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                                <table  width="100%">
                                    <tr>
                                        <th  width="30">#</th>
                                        <th width="100">M/C</th>
                                        <th width="100">Size</th>
                                        <th  width="100">Reduction (%)</th>
                                        <th width="100">Date</th>
                                        <th width="100">Die No</th>
                                        <!--
                                        <th width="100">Die Type</th>
                                        <th width="100">Manuf. No</th>
                                        <th width="100">Pallet</th>
                                        -->
                                    </tr>
                                </table>
                        </td>
                    </tr>
                    <?php 
                    $i=1;
                    
                    foreach($out as $o)
                    {
                        $mc_id = $o['mc_id'];
                        $mname = $o['mname'];
                        $out2 = $this->get_die_data_with_mc_id($mc_id,$location);
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $mname;?></td>
                            <td>
                                <table  width="100%" class="table table-sm table-hover">
                                    
                                    <?php 
                                        $j=1;
                                        $n = count($out2);
                                        foreach($out2 as $r)
                                        {
                                            //geting reduction
                                            $red = "";
                                            $red_color = "";
                                            if($j < $n ){
                                                $last_size = (float)$out2[$j]['size'];
                                                $red = round(100-(((float)$r['size'] / $last_size)*100));
                                                if($red <10 || $red > 25){ $red_color ="red";}
                                            }

                                            
                                            
                                            if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
                                        ?>
                                            <tr style="color:<?php echo $red_color;?>">
                                                <td  width="30"><?php echo $j;?>.</td>
                                                <td  width="100"><?php if(isset($r['mname']))echo $r['mname'];?></td>
                                                <td  width="100"><?php if(isset($r['size']))echo $r['size'];?></td>
                                                <td  width="100" ><?php if(!empty($red))echo $red.'%';?></td>
                                                <td  width="100"><?php echo $entry_date;?></td>
                                                <td  width="100"><?php if(isset($r['die_no']))echo $r['die_no'];?></td>
                                                <!--
                                                <td  width="100"><?php if(isset($r['die_type']))echo $r['die_type'];?></td>
                                                <td  width="100"><?php if(isset($r['menu_no']))echo $r['menu_no'];?></td>
                                                <td  width="100"><?php if(isset($r['pname']))echo $r['pname'];?></td>
                                                -->
                                            </tr>
                                        <?php
                                        $j++; 
                                        }
                                    ?>
                                </table>
                                
                            </td>
                        </tr>
                        <?php 
                        $i++;
                    }
                    ?>
            </table>
        <?php
    }//function close



    

















    














    //get die history data with date
    public function get_today_die_history_list($date)
    {
        $sql=" SELECT A.die_no,A.die_type,A.menu_no,
                H.size,H.location,A.mc_id,A.re_mc_no,H.entry_date,
                P.pallet as pname,P.code as pcode,
                M.name as mname
                FROM ddie_his as H 
                LEFT JOIN ddie A ON A.id=H.ddie_id
                LEFT JOIN machine_list M ON M.mc_id=H.mc_id
                LEFT JOIN ddie_pallet P ON P.id=A.pallet_id
                where H.entry_date = '$date' ORDER BY H.id DESC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


     //get die history data with dieno
     public function get_die_history_list_with_dieno($die_no)
     {
         $sql=" SELECT A.die_no,A.die_type,A.menu_no,
                 H.size,H.location,A.mc_id,A.re_mc_no,H.entry_date,
                 P.pallet as pname,P.code as pcode,
                 M.name as mname
                 FROM ddie_his as H 
                 LEFT JOIN ddie A ON A.id=H.ddie_id
                 LEFT JOIN machine_list M ON M.mc_id=H.mc_id
                 LEFT JOIN ddie_pallet P ON P.id=A.pallet_id
                 where A.die_no = '$die_no' ORDER BY H.entry_date,H.id ASC
             ";
         $query = $this->db->query($sql);
         return $query->result_array();
     }//function close



    //get die history data with date
    public function get_die_history_with_search($search)
    {
        $sql=" SELECT A.die_no,A.die_type,A.menu_no,
                H.size,H.location,A.mc_id,A.re_mc_no,H.entry_date,
                P.pallet as pname,P.code as pcode,
                M.name as mname
                FROM ddie_his as H 
                LEFT JOIN ddie A ON A.id=H.ddie_id
                LEFT JOIN machine_list M ON M.mc_id=H.mc_id
                LEFT JOIN ddie_pallet P ON P.id=A.pallet_id
                where 1=1  $search 
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    // die_ledger
    public function die_ledger($die_no)
    {
        $out = $this->get_die_history_list_with_dieno($die_no);
        //print_r($out);
        ?>
                <table class="table-hover" border=1 width="100%" id="printed_table">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Die Type</th>
                        <th>Die No</th>
                        <th>Manufacturing No</th>
                        <th>Pallet</th>
                        <th>Current Size</th>
                        <th>Location</th>
                        <th>Machine</th>
                    </tr>
					
					<?php 
					$i=1;
					foreach($out as $r)
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
								<td align="center"><?php if(isset($r['die_type']))echo $r['die_type'];?></td>
								<td><?php if(isset($r['die_no']))echo $r['die_no'];?></td>
								<td><?php if(isset($r['menu_no']))echo $r['menu_no'];?></td>
								<td><?php if(isset($r['pname']))echo $r['pname'];?></td>
								<td><?php if(isset($r['size']))echo $r['size'];?></td>
								<td style="font-weight:bold;color:<?php echo $color;?>"><?php if(isset($r['location']))echo $r['location'];?></td>
								<td><?php if(isset($r['mname']))echo $r['mname'];?></td>
							</tr>
						<?php
						$i++; 
					}
					?>
				
				</table>
        <?php
    }//function close



   









    











    




}//class close



