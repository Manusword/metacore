<?php
class Qcmodel extends CI_Model
{


    //get get_sepc1_data_with_id
    public function get_sepc1_data_with_id($id)
    {
        $sql = "SELECT A.*,G.name as grade_name 
                FROM qc_spec1 as A 
                LEFT JOIN product_grade G ON G.id=A.product_grade
                where A.id = '$id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close



    //qc test1 check
    public function get_spec1_details_for_test1_check($grade, $size)
    {
        //change type2 to grade in future
        //$sql = "SELECT * FROM qc_spec1  where product_grade = '$grade' and size = '$size'   ";
        $sql = "SELECT * FROM qc_spec1  where  size = '$size'   ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close

    //qc test1 check
    public function get_spec1_details_from_size_for_patt($size)
    {
        $sql = "SELECT * FROM qc_spec1  where  size = '$size' and product_type=1  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close

     public function get_spec1_details_from_size_for_non_patt($size)
    {
        $sql = "SELECT * FROM qc_spec1  where  size = '$size' and product_type!=1  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close


    //test1 search 
    public function get_all_sepc1_with_search($search)
    {
        $sql = "SELECT A.*,G.name as grade_name 
                FROM qc_spec1 as A 
                LEFT JOIN product_grade G ON G.id=A.product_grade
                where 1=1 $search
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close



















    //get get_sepc1_data_with_id
    public function get_test1_data_with_id($id)
    {
        $sql = "SELECT A.*,G.name as grade_name,M.name as mname,D.name as dname
                FROM qc_test1 as A 
                LEFT JOIN qc_log_test B ON B.id=A.qc_log_test_id
                LEFT JOIN product_grade G ON G.id=B.product_grade
                LEFT JOIN machine_list as M ON B.mc_no = M.mc_id  
                LEFT JOIN department as D ON B.dept = D.department_id
               
                where A.id = '$id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close


  
       //test1 search 
        public function get_all_test1_with_search($search)
        {
           $sql = " SELECT 
                    A.id,A.baseCoilId2,A.issue_to_despatch,A.stock_in_id,A.despatch_to_party,A.stock_out_id,
                    A.qc_log_test_id,A.coil_no,A.finish_size as finish_size_test, A.breaking_load,A.uts,A.torsion_test,A.bend_test,A.ra_per,A.scratch_brigitness,A.remarks,
                    B.product_grade,
                    B.entry_date,B.shift,B.base_size,B.batch_no,B.operator1,B.finish_size as main_finish_size,
                    G.name as grade_name,M.name as mname,D.name as dname,
                    PC.heat_no as baseHeatNo,PC.coil_no as baseCoilNo, PC.breaking_load as baseBl, PC.bl_category as base_bl_category, PC.bl_color as base_bl_color,
                    PG.name as finish_stock_grade_name
                    FROM qc_test1 as A 
                    LEFT JOIN qc_log_test B ON B.id=A.qc_log_test_id
                    LEFT JOIN product_grade G ON G.id=B.product_grade
                    LEFT JOIN machine_list as M ON B.mc_no = M.mc_id  
                    LEFT JOIN department as D ON B.dept = D.department_id
                    LEFT JOIN product_invoice_row_qc_test_coilswise as PC ON PC.coil_test_d = A.baseCoilId
                    LEFT JOIN stock_inout as S ON S.stock_inout_id = A.stock_in_id
                    LEFT JOIN product_grade PG ON PG.id=S.grade_id
                    WHERE 1=1  $search 
                ";
            $query = $this->db->query($sql);
            return $query->result_array();
        } //function close
    
        public function getAllWdCoilsList_from_size_dia_grade($size,$dia,$grade)
        {
            $size = number_format((float) $size, 3);
            $where = "  and issue_to_despatch < 1 and  B.finish_size='$size' and  B.coil_dia='$dia' and  B.product_grade='$grade'  ORDER by B.entry_date,B.dept,B.mc_no,A.coil_no ";
            $coilList = $this->Qcmodel->get_all_test1_with_search($where);
            if(!empty($coilList)){
                //print table
                $this->Qcmodel->getAllWdCoilsList_print_table($coilList);
            }//if(!empty($product_data)){
        } //function close
    
        public function getAllWdCoilsList_from_id($stockInId)
        {
            $where = " and stock_in_id = '$stockInId'  ORDER by B.entry_date,B.dept,B.mc_no,A.coil_no ";
            $coilList = $this->Qcmodel->get_all_test1_with_search($where);
            if(!empty($coilList)){
                //print table
                $this->Qcmodel->getAllWdCoilsList_print_table($coilList);
            }//if(!empty($product_data)){
        } //function close


         public function test_coil_print_table($data)
        {
            ?>
    					<table border="1" width="100%" style="font-size: 13px;;">
    						<tr>
    							<th>Sno</th>
    							<th>Coil No</th>
                                <th>Base Size</th>
                                <th>Finish Size</th>
                                <th>BL</th>
    							<th>UTS</th>
    							<th>TT</th>
    							<th>BT</th>
    							<th>Ra %</th>
    							<th>Scratch</th>
    							<th>Remarks</th>
    
                                <th>Heat No</th>
                                <th>Base Coil No</th>
                                <th>Base BL</th>
                                <th>BL Category</th>
                                <th>Shift</th>
    							<th>Machine</th>
    							<th>Grade</th>
    						</tr>
    						<?php 
    							$i=1;
    							foreach($data as $r){
    								if(isset($r['entry_date']) && $r['entry_date'] != '0000-00-00'){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
    								?>
    									<tr  >
    										<td><?php echo $i;?></td>
    										<td class="coilno"><?php echo $r['coil_no'];?></td>
                                            <td><?php echo $r['base_size'];?></td>
                                            <td><?php echo $r['finish_size_test'];?></td>
    										<td><?php echo $r['breaking_load'];?></td>
    										<td><?php echo $r['uts'];?></td>
    										<td><?php echo $r['torsion_test'];?></td>
    										<td><?php echo $r['bend_test'];?></td>
    										<td><?php echo $r['ra_per'];?></td>
    										<td><?php echo $r['scratch_brigitness'];?></td>
    										<td><?php echo $r['remarks'];?></td>
    
                                            <td><?php echo $r['baseHeatNo'];?></td>
                                            <td><?php echo $r['baseCoilNo'];?></td>
                                            <td style="color:<?php echo $r['base_bl_color'];?>" ><?php echo $r['baseBl'];?></td>
                                            <td style="color:<?php echo $r['base_bl_color'];?>" >  <?php echo $r['base_bl_category'];?></td>
                                            <td><?php echo $r['shift'];?></td>
    										<td><?php echo $r['mname'];?></td>
    										
    										
    										<td><?php echo $r['finish_stock_grade_name'];//grade_name?></td>
    									</tr>
    								<?php
    								$i++;
    							}
    						?>
    					</table>
    					<?php
        } //function close
    
        public function getAllWdCoilsList_print_table($coilList)
        {
            ?>
    						<table border="1" width="100%">
    						<tr>
    							<th>Sno</th>
    							<th>Choose Pickile Coil's</th>
    							<th>Production Date</th>
    							<th>Shift</th>
    							<th>Machine</th>
    							<th>Base Size</th>
    							<th>Finish Size</th>
                                <th>Grade</th>
    							<th>Coil No</th>
                                <th>BL</th>
    							<th>UTS</th>
    							<th>TT</th>
    							<th>BT</th>
    							<th>Ra %</th>
    							<th>Scratch</th>
    							<th>Remarks</th>
    
                                <th>Heat No</th>
                                <th>Base Coil No</th>
                                <th>Base BL</th>
                                <th>BL Category</th>
    						</tr>
    						<?php 
    							$i=1;
    							foreach($coilList as $r){
    								if(isset($r['entry_date']) && $r['entry_date'] != '0000-00-00'){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
    								?>
    									<tr  >
    										<td><?php echo $i;?></td>
    										<td> <input type="checkbox" <?php if($r['issue_to_despatch'] == 1){echo "checked";}?>  name='coilId' value="<?php echo $r['id'];?>"> </td>
    										<td><?php echo $entry_date;?></td>
    										<td><?php echo $r['shift'];?></td>
    										<td><?php echo $r['mname'];?></td>
    										<td><?php echo $r['base_size'];?></td>
    										<td><?php echo $r['finish_size_test'];?></td>
    										<td><?php echo $r['finish_stock_grade_name'];//grade_name?></td>
                                            <td><?php echo $r['coil_no'];?></td>
    										<td><?php echo $r['breaking_load'];?></td>
    										<td><?php echo $r['uts'];?></td>
    										<td><?php echo $r['torsion_test'];?></td>
    										<td><?php echo $r['bend_test'];?></td>
    										<td><?php echo $r['ra_per'];?></td>
    										<td><?php echo $r['scratch_brigitness'];?></td>
    										<td><?php echo $r['remarks'];?></td>
    
                                            <td><?php echo $r['baseHeatNo'];?></td>
                                            <td><?php echo $r['baseCoilNo'];?></td>
                                            <td style="color:<?php echo $r['base_bl_color'];?>" ><?php echo $r['baseBl'];?></td>
                                            <td style="color:<?php echo $r['base_bl_color'];?>" >  <?php echo $r['base_bl_category'];?></td>
    									</tr>
    								<?php
    								$i++;
    							}
    						?>
    					</table>
    					<?php
        } //function close


    public function getAllWdCoilsList_from_base_rodid($baseRodId)
    {
        $where = " and A.baseCoilId = '$baseRodId'  ORDER by B.entry_date,B.dept,B.mc_no,A.coil_no ";
        $coilList = $this->Qcmodel->get_all_test1_with_search($where);
        if(!empty($coilList)){
            //print table
            $this->Qcmodel->getAllWdCoilsList_print_table2($coilList);
        }//if(!empty($product_data)){
    } //function close

    public function getAllWdCoilsList_from_base_rodid_onlycount($baseRodId)
    {
        $sql = " SELECT 
                    count(A.id) as total_coils
                    FROM qc_test1 as A 
                    WHERE  A.baseCoilId = '$baseRodId'
                ";
        $query = $this->db->query($sql);
        $coilList =  $query->result_array();
        //print_r($coilList);

        $count = 0;
        if(!empty($coilList)){
            //print table
            $count = $coilList[0]['total_coils'];
        }//if(!empty($product_data)){
        return $count;
    } //function close


    public function getAllWdCoilsList_print_table2($coilList)
    {
            $total_coil = array();
            ?>
    						<h4>
                                <?php 
                                    if(!empty($coilList)){
                                        echo "Rod No:".$coilList[0]['baseCoilNo'];
                                        echo ", ";
                                        echo "Heat No:".$coilList[0]['baseHeatNo'];
                                        echo ", ";
                                        echo "Size:".$coilList[0]['base_size'];
                                    }
                                ?>
                            </h4>
                            <table border="1" width="100%">
    						<tr>
    							<th>Sno</th>
    							<th>Production Date</th>
    							<th>Shift</th>
    							<th>Machine</th>
    							<th>Base Size</th>
    							<th>Finish Size</th>
                                <th>Actual Size</th>
                                <th>Grade</th>
    							<th>Coil No</th>
                                <th>BL</th>
    							<th>UTS</th>
    							<th>TT</th>
    							<th>BT</th>
    							<th>Ra %</th>
    							<th>Scratch</th>
    							<th>Remarks</th>
                            </tr>
    						<?php 
    							$i=1;
    							foreach($coilList as $r){
    								if(isset($r['entry_date']) && $r['entry_date'] != '0000-00-00'){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
    								?>
    									<tr  >
    										<td><?php echo $i;?></td>
    										<td><?php echo $entry_date;?></td>
    										<td><?php echo $r['shift'];?></td>
    										<td><?php echo $r['mname'];?></td>
                                            <td><?php echo $r['base_size'];?></td>
    										<td><?php echo $r['main_finish_size'];?></td>
                                            <td><?php echo $r['finish_size_test'];?></td>
    										<td><?php echo $r['finish_stock_grade_name'];//grade_name?></td>
                                            <td><?php echo $total_coil[] = $r['coil_no'];?></td>
    										<td><?php echo $r['breaking_load'];?></td>
    										<td><?php echo $r['uts'];?></td>
    										<td><?php echo $r['torsion_test'];?></td>
    										<td><?php echo $r['bend_test'];?></td>
    										<td><?php echo $r['ra_per'];?></td>
    										<td><?php echo $r['scratch_brigitness'];?></td>
    										<td><?php echo $r['remarks'];?></td>
                                        </tr>
    								<?php
    								$i++;
    							}
    						?>
                            
    					</table>
    					<?php
        } //function close


    //get get_test1_data_with_logid
    public function get_test1_data_with_logid($qc_log_test_id)
    {
        $sql = "SELECT * FROM qc_test1  where qc_log_test_id = '$qc_log_test_id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close
















    //get long_test_add_with_id
    public function get_log_test_data_with_id($id)
    {
        $sql = "SELECT A.*,G.name as grade_name,M.name as mname,D.name as dname,T.name as ptname
                FROM qc_log_test as A 
                LEFT JOIN product_grade G ON G.id=A.product_grade
                LEFT JOIN machine_list as M ON A.mc_no = M.mc_id  
                LEFT JOIN department as D ON M.dept = D.department_id
                LEFT JOIN product_type as T ON T.id = A.product_type
                
                where A.id = '$id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close

    //log search 
    public function get_all_log_test_with_search($search)
    {
        $sql = " SELECT A.*,G.name as grade_name,M.name as mname, M.order_list,D.name as dname,T.name as ptname,C.name as cname
                FROM qc_log_test as A 
                LEFT JOIN product_grade G ON G.id=A.product_grade
                LEFT JOIN machine_list as M ON A.mc_no = M.mc_id  
                LEFT JOIN department as D ON M.dept = D.department_id
                LEFT JOIN product_type as T ON T.id = A.product_type
                LEFT JOIN customer as C ON C.id = A.customer_id
                WHERE 1=1  $search 
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close











    //TC
    //qc tc spec form qc.js page 
    public function get_tc_spec_data($product_type, $size)
    {

        $sql = "SELECT * FROM qc_chemical_mech_properties  where product_type = '$product_type' and size = '$size'   ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close



    //get long_test_add_with_id
    public function get_tc_data_with_id($id)
    {
        $sql = "SELECT A.*,C.name as cname,T.name as tname
                FROM qc_tc as A 
                LEFT JOIN customer C ON C.id=A.customer_id
                LEFT JOIN product_type as T ON T.id = A.product_type
                where A.tc_id = '$id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close

    //get long_test_add_with_id
    public function get_tc_spec_data_with_tc_id($id)
    {
        $sql = "SELECT A.*
                FROM qc_tc_spec as A 
                
                where A.tc_id = '$id' ORDER BY qc_tc_spec  ASC
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close


    //log search 
    public function get_all_tc_with_search($search)
    {
        $sql = " SELECT A.*,C.name as cname,T.name as tname
                FROM qc_tc as A 
                
                LEFT JOIN customer as C ON C.id = A.customer_id
                LEFT JOIN product_type as T ON T.id = A.product_type
                WHERE 1=1  $search 
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close







    //Pickling Test
    //get pickling_test_add_with_id
    public function get_pickling_test_data_with_id($id)
    {
        $sql = "SELECT * FROM qc_pickling_test as A  where A.id = '$id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close


    //log search 
    public function get_pickling_test_with_search($search)
    {
        $sql = " SELECT * FROM qc_pickling_test as A   WHERE 1=1  $search   ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close


    //pickling production / pickel rod data with id
    public function get_pickle_rod_data_with_id($id)
    {
        $sql = "SELECT * FROM pickling_production as A  where A.id = '$id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close

    public function get_pickle_rod_data_with_rod_id($coil_test_d)
    {
        $sql = "SELECT * FROM pickling_production as A  where A.coil_test_d = '$coil_test_d' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close

     //furnace_production search 
    public function get_all_pickling_production_with_search($search)
    {
        $sql = " SELECT A.*, P.coil_no,P.heat_no,P.finish_size,P.breaking_load,P.bl_category,P.invoice_deatils_id,
                            P.bl_color,P.uts,P.torsion_test,P.bend_test,P.ra_per,P.rdarea,
                    L.name as lotname,G.name as gname
                FROM pickling_production as A 
                LEFT JOIN product_invoice_row_qc_test_coilswise as P ON P.coil_test_d = A.coil_test_d
                LEFT JOIN product_invoice_row_qc_test as B ON P.invoice_deatils_id = B.invoice_deatils_id
                 LEFT JOIN product_grade as G ON G.id = B.product_grade
                LEFT JOIN product_lotno as L ON L.id = A.lotno
                WHERE 1=1  $search  
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close





    //furnace_production
    public function get_furnace_data_with_id($id)
    {
        $sql = "SELECT A.*, G.name as gname
                FROM furnace_production as A 
                LEFT JOIN product_grade G ON G.id=A.product_grade WHERE A.id = '$id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close

    public function get_furnace_data_with_rod_id($coil_test_d)
    {
        $sql = "SELECT A.*,B.coil_no as wdcoilno
                    FROM furnace_production as A  
                    LEFT JOIN qc_test1 B ON B.id=A.wd_coll_no
                    WHERE A.wd_coll_no = '$coil_test_d' 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close

    public function get_furnace_lotno_with_size_date($fsize,$search_date1,$search_date2)
    {
        $sql = "SELECT A.lotno 
                    FROM furnace_production  
                    WHERE  actual_size = '$fsize' and entry_date between ',$search_date1' and ',$search_date2' 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close

    //furnace_production search 
    public function get_all_furnace_with_search($search)
    {
        $sql = " SELECT A.*, G.name as gname
                FROM furnace_production as A 
                LEFT JOIN product_grade G ON G.id=A.product_grade
                WHERE 1=1  $search  
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close



    //lotno or id 
    public function get_all_lotno_with_coil_from_fur($size,$grade)
	{
        $size = number_format((float) $size, 3);
        $sql = " SELECT A.id,A.new_coil_no,A.lotno,L.name as lotname
                    FROM furnace_production as A 
                    LEFT JOIN product_lotno as L ON L.id = A.lotno
                    -- LEFT JOIN qc_log_test B ON B.lotno=A.lotno
                    WHERE A.actual_size = '$size' and A.product_grade='$grade' and L.hide_in_qc_test <1 and L.status='Active'
                    -- and B.lotno_hide <1
                    ORDER by A.new_coil_no,A.lotno
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

   








    /*
    public function get_all_lotno()
	{
        $sql = " SELECT A.id,A.lotno FROM pickling_production as A 
                    WHERE A.lotno !='' and A.lotno_hide <1
                    ORDER by A.lotno
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    */

   


    //get lotno from finish coil
    public function get_wet_mini_prod_lotno_from_size($fsize,$fdate,$tdate)
	{
        $size = number_format((float) $fsize, 3);
        $sql = " SELECT 
                    A.id,A.coil_no,B.base_size,A.finish_size as finish_size_test, A.breaking_load,A.uts,A.baseCoilId2,
                    A.scratch_brigitness,A.ra_per,A.bend_test,A.torsion_test,B.entry_date,B.product_grade,B.finish_size as original_size,
                    M.name as mc_name,B.product_type,
                    F.id as fid,F.actual_size,F.lotno as lotno,F.new_coil_no,F.finish_size as fur_finish_size, F.bl,F.uts as futs,F.zinc,F.ra,F.temp,
                    F.entry_date as fentry_date,
                    G.name as gname, T.name as tname,L.name as lotname
                    FROM qc_test1 as A 
                    LEFT JOIN qc_log_test B ON B.id=A.qc_log_test_id
                    LEFT JOIN machine_list M ON M.mc_id=B.mc_no
                    LEFT JOIN furnace_production F ON F.id=A.lotno
                    LEFT JOIN product_grade G ON G.id=B.product_grade
                    LEFT JOIN product_type as T ON T.id = B.product_type
                    LEFT JOIN product_lotno as L ON L.id = F.lotno
                    WHERE   B.finish_size='$size'  and B.entry_date BETWEEN '$fdate' and '$tdate' 
                    ORDER by F.lotno,A.coil_no
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_wet_mini_prod_lotno_from_id($qc_test1_id)
	{
         $sql = " SELECT 
                     A.id,A.coil_no,A.finish_size as finish_size_test, A.breaking_load,A.uts,A.baseCoilId2,
                    A.scratch_brigitness,A.ra_per,A.bend_test,A.torsion_test,B.entry_date,B.product_grade,B.finish_size as original_size,
                    M.name as mc_name,B.product_type,
                    F.id as fid,F.actual_size,F.lotno as lotno,F.new_coil_no,F.finish_size as fur_finish_size, F.bl,F.uts as futs,F.zinc,F.ra,F.temp,
                    F.entry_date as fentry_date,
                    G.name as gname, T.name as tname,L.name as lotname
                    FROM qc_test1 as A 
                    LEFT JOIN qc_log_test B ON B.id=A.qc_log_test_id
                    LEFT JOIN machine_list M ON M.mc_id=B.mc_no
                    LEFT JOIN furnace_production F ON F.id=A.lotno
                    LEFT JOIN product_grade G ON G.id=B.product_grade
                    LEFT JOIN product_type as T ON T.id = B.product_type
                    LEFT JOIN product_lotno as L ON L.id = F.lotno
                    WHERE   A.id='$qc_test1_id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_baseCoilId_from_lotno($lotno,$finish_size)
	{
        $sql = " SELECT 
                    A.id,A.coil_no,B.base_size,A.finish_size as finish_size_test, A.breaking_load,A.uts,A.baseCoilId,
                    A.scratch_brigitness,A.ra_per,A.bend_test,A.torsion_test,B.entry_date,B.product_grade,B.finish_size as original_size,
                     M.name as mc_name,B.product_type
                    FROM qc_test1 as A 
                    LEFT JOIN qc_log_test B ON B.id=A.qc_log_test_id
                    LEFT JOIN machine_list M ON M.mc_id=B.mc_no
                    LEFT JOIN pickling_production as P ON P.coil_test_d = A.baseCoilId
                    WHERE   P.lotno='$lotno' and B.finish_size='$finish_size'
                    ORDER by A.baseCoilId,A.coil_no
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_baseCoilId_from_finishSize($finish_size,$fdate,$tdate)
	{
        $sql = " SELECT 
                    A.id,A.coil_no,B.base_size,A.finish_size as finish_size_test, A.breaking_load,A.uts,A.baseCoilId,
                    A.scratch_brigitness,A.ra_per,A.bend_test,A.torsion_test,B.entry_date,B.product_grade,B.finish_size as original_size,
                     M.name as mc_name,B.product_type
                    FROM qc_test1 as A 
                    LEFT JOIN qc_log_test B ON B.id=A.qc_log_test_id
                    LEFT JOIN machine_list M ON M.mc_id=B.mc_no
                    LEFT JOIN pickling_production as P ON P.coil_test_d = A.baseCoilId
                    WHERE   B.finish_size='$finish_size' and B.entry_date BETWEEN '$fdate' and '$tdate'  
                    ORDER by A.baseCoilId,A.coil_no
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    //get rod_wire Base
    public function get_baseCoilId_from_size($fsize,$fdate,$tdate)
	{
        $size = number_format((float) $fsize, 3);
        $sql = " SELECT 
                    A.id,A.coil_no,B.base_size,A.finish_size as finish_size_test, A.breaking_load,A.uts,A.baseCoilId,
                    A.scratch_brigitness,A.ra_per,A.bend_test,A.torsion_test,B.entry_date,B.product_grade,B.finish_size as original_size,
                     M.name as mc_name,B.product_type
                    FROM qc_test1 as A 
                    LEFT JOIN qc_log_test B ON B.id=A.qc_log_test_id
                    LEFT JOIN machine_list M ON M.mc_id=B.mc_no
                    WHERE   B.finish_size='$size' and A.baseCoilId > 0 and B.entry_date BETWEEN '$fdate' and '$tdate' 
                    ORDER by A.coil_no
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_baseCoilId_from_size_wihout_rod($fsize,$fdate,$tdate)
	{
        $size = number_format((float) $fsize, 3);
        $sql = " SELECT 
                    A.id,A.coil_no,B.base_size,A.finish_size as finish_size_test, A.breaking_load,A.uts,A.baseCoilId,
                    A.scratch_brigitness,A.ra_per,A.bend_test,A.torsion_test,B.entry_date,B.product_grade,B.finish_size as original_size,
                     M.name as mc_name,B.product_type
                    FROM qc_test1 as A 
                    LEFT JOIN qc_log_test B ON B.id=A.qc_log_test_id
                    LEFT JOIN machine_list M ON M.mc_id=B.mc_no
                    WHERE   B.finish_size='$size' and B.entry_date BETWEEN '$fdate' and '$tdate' 
                    ORDER by A.coil_no
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    
    public function get_baseCoilId_from_id($qc_test1_id)
	{
        $sql = " SELECT 
                    A.id,A.coil_no,A.finish_size as finish_size_test, A.breaking_load,A.uts,A.baseCoilId,
                    A.scratch_brigitness,A.ra_per,A.bend_test,A.torsion_test,B.entry_date,B.product_grade,B.finish_size as original_size,
                     M.name as mc_name,B.product_type
                    FROM qc_test1 as A 
                    LEFT JOIN qc_log_test B ON B.id=A.qc_log_test_id
                    LEFT JOIN machine_list M ON M.mc_id=B.mc_no
                    WHERE   A.id = '$qc_test1_id'
                    ORDER by A.coil_no
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close




    
    //get Red / ROD data
    public function get_baseCoilID_from_finishid_html_table($rod)
	{
      
        ?>
            <table class="table table-sm table-bordered">
                <tr style="background-color:aliceblue;">
                    <th>Sno.</th>
                    <th>Rod Id</th>
                    <th>Rod No</th>
                    <th>Date </th>
                    <th>Size</th>
                    <th>Grade</th>
                    <th>Heat</th>
                    <th>Lotno</th>
                    
                    <th>UTS</th>
                    <th>Min-Max B.L</th>
                    <th>B.L.</th>
                    <th>B.L Category Range</th>
                    <th>Torsion</th>
                    <th>Bend</th>
                    <th>Ra %</th>
                    <th>RD (mm)</th>
                    
                    
                    <th>Washing</th>
                    <th>HCL</th>
                    <th>Washing</th>
                    <th>PHOS Time</th>
                    <th>PHOS Temp.</th>
                    <th>Borax Time</th>
                    <th>Borax Temp</th>
                    <th>Total Time</th>
                </tr>
                <?php   $i=1;
                 foreach($rod as $r){
                        $rodData = $this->Pomodel->get_all_heatno_colino_from_coil_id($r);
                        $pickle_rod = $this->Qcmodel->get_pickle_rod_data_with_rod_id($r);
                        if(!empty($pickle_rod)){
                             if(!empty($pickle_rod[0]['washing_time1']) and $pickle_rod[0]['washing_time1'] != "0000-00-00 00:00:00"){ $washing_time1 = $this->Base->change_date_dmy_hisa($pickle_rod[0]['washing_time1']);}else{$washing_time1 = ""; }
                            if(!empty($pickle_rod[0]['hcl_in']) and $pickle_rod[0]['hcl_in'] != "0000-00-00 00:00:00"){ $hcl_in = $this->Base->change_datetime_hi($pickle_rod[0]['hcl_in']);}else{$hcl_in = ""; }
                            if(!empty($pickle_rod[0]['hcl_out']) and $pickle_rod[0]['hcl_out'] != "0000-00-00 00:00:00"){ $hcl_out = $this->Base->change_datetime_hi($pickle_rod[0]['hcl_out']);}else{$hcl_out = ""; }

                            if(!empty($pickle_rod[0]['washing_time2']) and $pickle_rod[0]['washing_time2'] != "0000-00-00 00:00:00"){ $washing_time2 = $this->Base->change_datetime_hi($pickle_rod[0]['washing_time2']);}else{$washing_time2 = ""; }
                            if(!empty($pickle_rod[0]['phos_in']) and $pickle_rod[0]['phos_in'] != "0000-00-00 00:00:00"){ $phos_in = $this->Base->change_datetime_hi($pickle_rod[0]['phos_in']);}else{$phos_in = ""; }
                            if(!empty($pickle_rod[0]['phos_out']) and $pickle_rod[0]['phos_out'] != "0000-00-00 00:00:00"){ $phos_out = $this->Base->change_datetime_hi($pickle_rod[0]['phos_out']);}else{$phos_out = ""; }
                            if(!empty($pickle_rod[0]['borax_in']) and $pickle_rod[0]['borax_in'] != "0000-00-00 00:00:00"){ $borax_in = $this->Base->change_datetime_hi($pickle_rod[0]['borax_in']);}else{$borax_in = ""; }
                            if(!empty($pickle_rod[0]['borax_out']) and $pickle_rod[0]['borax_out'] != "0000-00-00 00:00:00"){ $borax_out = $this->Base->change_datetime_hi($pickle_rod[0]['borax_out']);}else{$borax_out = ""; }
                        }
                        if(!empty($rodData)){
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td class="rodList" id="<?php echo $rodData[0]['coil_test_d'];?>"><?php echo $rodData[0]['coil_test_d'];?></td>
                                <td><?php echo $rodData[0]['coil_no'];?></td>
                                <td><?php echo $this->Base->change_date_dmy($rodData[0]['qc_row_test_date']);?></td>
                                <td><?php echo $rodData[0]['finish_size'];?></td>
                                <td><?php echo $rodData[0]['gname'];?></td>
                                <td><?php echo $rodData[0]['heat_no'];?></td>
                                <td><?php echo $rodData[0]['lotname'];?></td>
                                
                                <td><?php echo $rodData[0]['uts'];?></td>
                                <td><?php echo $rodData[0]['min_bl'].'-'.$rodData[0]['max_bl'];?></td>
                                <td><?php echo $rodData[0]['breaking_load'];?></td>
                                <td>
                                    <span class="badge text-light" style="background-color:<?= $rodData[0]['bl_color']; ?>;">
                                        <?= $rodData[0]['bl_category']; ?>
                                    </span>
                                    <?php 
                                    $blres = $this->Base->get_breakingload_category($rodData[0]['min_bl'],$rodData[0]['max_bl'],0);
                                    if(!empty($blres)){
                                        echo $minMaxBL = $this->Base->get_breakingload_min_max($blres[2],$blres[3],$blres[4],$blres[5],$rodData[0]['bl_category']);
                                    }
                                    ?>
                                </td>
                                <td><?php echo $rodData[0]['torsion_test'];?></td>
                                <td><?php echo $rodData[0]['bend_test'];?></td>
                                <td><?php echo $rodData[0]['ra_per'];?></td>
                                <td><?php echo $rodData[0]['rdarea'];?></td>
                                
                                
                                
                                <td>
                                    <?php if(!empty($pickle_rod))echo $washing_time1;?><br> 
                                    Coil Rank: <span style="color:blueviolet"><?php if(!empty($pickle_rod[0]['rank'])) echo $pickle_rod[0]['rank']?></span>
                                </td>
                                <td>   
                                    <?php if(!empty($pickle_rod)){
                                        ?>
                                            <?php echo $hcl_in;?>-<?php echo $hcl_out;?> <br> 
                                            <span style="color:blueviolet"><?php if(!empty($pickle_rod[0]['hcl_total_time'])) echo $pickle_rod[0]['hcl_total_time']?> min</span>
                                        <?php
                                    }?>
                                </td>
                               <td>   
                                    <?php if(!empty($pickle_rod)){
                                        ?>
                                            <?php echo $washing_time2;?> <br> <span style="color:blueviolet">
                                            <?php if(!empty($pickle_rod[0]['washing2_total_time'])) echo $pickle_rod[0]['washing2_total_time']?> min</span>
                                        <?php
                                    }?>
                                </td>
                                <td>   
                                    <?php if(!empty($pickle_rod)){
                                        ?>
                                            <?php echo $phos_in;?>-<?php echo $phos_out;?> <br> 
                                            <span style="color:blueviolet"><?php if(!empty($pickle_rod[0]['phos_total_time'])) echo $pickle_rod[0]['phos_total_time']?> min</span>
                                        <?php
                                    }?>
                                </td>
                                <td>   
                                    <?php if(!empty($pickle_rod)){
                                        ?>
                                            Temp : <br>
                                            <?php if(!empty($pickle_rod[0]['phos_in_temp'])) echo $pickle_rod[0]['phos_in_temp']?>-<?php if(!empty($pickle_rod[0]['phos_out_temp'])) echo $pickle_rod[0]['phos_out_temp']?>
                                            <br> 
                                            <span style="color:blueviolet"><?php if(!empty($pickle_rod[0]['phos_temp_diff'])) echo $pickle_rod[0]['phos_temp_diff']?> °C</span>
                                        <?php
                                    }?>
                                </td>
                                 <td>   
                                    <?php if(!empty($pickle_rod)){
                                        ?>
                                            <?php echo $borax_in;?>-<?php echo $borax_out;?> <br> 
                                            <span style="color:blueviolet"><?php if(!empty($pickle_rod[0]['borax_total_time'])) echo $pickle_rod[0]['borax_total_time']?> min</span>
                                        <?php
                                    }?>
                                </td>
                                <td>   
                                    <?php if(!empty($pickle_rod)){
                                        ?>
                                             Temp : <br>
                                            <?php if(!empty($pickle_rod[0]['borax_in_temp'])) echo $pickle_rod[0]['borax_in_temp']?>-<?php if(!empty($pickle_rod[0]['borax_out_temp'])) echo $pickle_rod[0]['borax_out_temp']?>
                                            <br> 
                                            <span style="color:blueviolet"><?php if(!empty($pickle_rod[0]['borax_temp_diff'])) echo $pickle_rod[0]['borax_temp_diff']?> °C</span>
                                        <?php
                                    }?>
                                </td>
                                <td>   
                                    <?php if(!empty($pickle_rod)){
                                        ?>
                                            <span style="color:blueviolet"><?php if(!empty($pickle_rod[0]['wash_to_borex_out_time'])) echo $pickle_rod[0]['wash_to_borex_out_time']?> min</span> 
                                        <?php
                                    }?>
                                </td>
                            </tr>
                            <?php	
                        }//rodData
                    $i++;
                }//foreach
                ?>
            </table>

           <script>
                (function() {
                const colors = [
                    '#FF6B6B', '#6BCB77', '#4D96FF', '#FFD93D', '#845EC2',
                    '#FF9671', '#00C9A7', '#F9F871', '#C34A36', '#2C73D2',
                    '#F67280', '#17B978', '#FF9F1C', '#3F72AF', '#D7263D'
                ];

                const usedIds = new Map();
                let colorIndex = 0;

                document.querySelectorAll('.rodList').forEach(el => {
                    const id = el.id;
                    if (!usedIds.has(id)) {
                    usedIds.set(id, colors[colorIndex % colors.length]);
                    colorIndex++;
                    }
                    const bgColor = usedIds.get(id);
                    el.style.backgroundColor = bgColor;
                    el.style.color = '#fff';
                });
                })();
            </script>


        <?php
    }//function close

    //Simi wire
    public function get_baseCoilID_from_finishid_table_data($baseCoil)
	{
        //print_r($baseCoil);
        ?>
            <table class="table table-sm table-bordered">
                <tr style="background-color:aliceblue;">
                    <th>Sno.</th>
                    <th>Coil no</th>
                    
                    <th>Date</th>
                    <th>Machine</th>
                    <th>B.Size</th>
                    <th>F.Size</th>
                   
                    
                    <th>Min-Max Size</th>
                    <th>Actual Size</th>
                    <th>Breaking Load</th>
                    
                    <th>Min-Max TS</th>
                    <th>UTS</th>
                    <th>TS Category</th>

                    <th>Torsion</th>
                    <th>Bend</th>
                    <th>Ra %</th>
                    <th>scratch</th>
                    <th>Rod ID</th>
                </tr>
                <?php   
                $i=1;
                foreach ($baseCoil as $b) {
                    $spec = $this->get_specification_1(0, $b['original_size'],$b['finish_size_test'],$b['uts']);
                    ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $b['coil_no'];?></td>
                            <td><?php echo $this->Base->change_date_dmy($b['entry_date']);?></td>
                            <td><?php echo $b['mc_name'];?></td>
                            <td><?php echo $b['base_size'];?></td>
                            <td><?php echo $b['original_size'];?></td>
                            <td> <?php  if(!empty($spec)){ echo $spec['min_size'].'-'.$spec['max_size'];} ?></td>
                            <td><strong class="<?php if(!empty($spec)){ echo $spec['size_color'];} ?>"><?php echo $b['finish_size_test'];?></strong></td>
                            <td><?php echo $b['breaking_load'];?></td>
                            <td> <?php  if(!empty($spec)){ echo $spec['ts_min_ss1'].'-'.$spec['ts_max_ss1'];} ?></strong></td>
                            <td><strong class="<?php if(!empty($spec)){ echo $spec['ts1_color'];} ?>"><?php echo $b['uts'];?></td>
                            <td><strong class="<?php if(!empty($spec)){ echo $spec['ts1_color'];} ?>"><?php if(!empty($spec)){ echo $spec['ts1_category'];} ?></strong></td>
                            <td><?php echo $b['torsion_test'];?></td>
                            <td><?php echo $b['bend_test'];?></td>
                            <td><?php echo $b['ra_per'];?></td>
                            <td><?php echo $b['scratch_brigitness'];?></td>
                            <td class="rodList" id="<?php echo $b['baseCoilId'];?>"><?php echo $b['baseCoilId'];?></td>
                        </tr>
                    <?php
                    $i++;
                }
                ?>
            </table>
        <?php
    }//function close


    
    public function finish_coil_list($data)
    {
        if (empty($data)) {
            return "<p><i>No data available</i></p>";
        }
        ?>
            <table class="table table-bordered table-sm spaced-table">
                <thead>
                    <tr>
                        <td colspan="17" align="center" style="background-color:aliceblue; font-weight:bolder;">Finish</td>
                        <td colspan="12" align="center" style="background-color:antiquewhite; font-weight:bolder;">Furnace</td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>F.Coil No</th>
                        <th>Date</th>
                        <th>Machine</th>
                        <th>Grade</th>
                        <th>Type</th>
                        <th>B.size</th>
                         <th>F.size</th>
                        <th>Min-Max Size</th>
                        <th>Size</th>
                        <th>B.L</th>
                       
                        <th>Min-Max TS</th>
                        <th>UTS</th>
                        <th>TS Category</th>

                        
                        
                        <th>Scratch</th>
                        <th>RA</th>
                        <th>Bend</th>
                        <th>TS</th>
                        <th>Lotno</th>
                        <th>Furnace Date</th> 
                        <th>Furnace Coil No</th>  


                       
                        <th>Min-Max Size</th>
                        <th>Size</th>
                        <th>Min-Max TS</th>
                        <th>UTS</th>
                        <th>TS Category</th>


                        <th>B.L.</th>
                        <th>Zinc</th>
                        <th>Ra %</th>
                        <th>Temp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    foreach ($data as $r) {
                        $spec1 = $this->get_specification_1(0, $r['original_size'],$r['finish_size_test'],$r['uts']);
                        $spec = $this->get_specification_1(1, $r['actual_size'],$r['fur_finish_size'],$r['futs']);
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                           
                            <td><?php echo $r['coil_no']; ?></td>
                            <td><?php echo $this->Base->change_date_dmy($r['entry_date']);?></td>
                            <td><?php echo $r['mc_name']; ?></td>
                             <td><?php echo $r['gname']; ?></td>
                            <td><?php echo $r['tname']; ?></td>
                            <td><?php echo $r['base_size']; ?></td>
                             <td><?php echo $r['original_size']; ?></td>
                            

                            <td> <?php  if(!empty($spec1)){ echo $spec1['min_size'].'-'.$spec1['max_size'];} ?></td>
                            <td><strong class="<?php if(!empty($spec1)){ echo $spec1['size_color'];} ?>"><?php echo $r['finish_size_test'];?></strong></td>
                            <td><?php echo $r['breaking_load']; ?></td>
                            <td> <?php  if(!empty($spec1)){ echo $spec1['ts_min_ss1'].'-'.$spec1['ts_max_ss1'];} ?></strong></td>
                            <td><strong class="<?php if(!empty($spec1)){ echo $spec1['ts1_color'];} ?>"><?php echo $r['uts'];?></td>
                            <td><strong class="<?php if(!empty($spec1)){ echo $spec1['ts1_color'];} ?>"><?php if(!empty($spec1)){ echo $spec1['ts1_category'];} ?></strong></td>

                           
                            
                            <td><?php echo $r['scratch_brigitness']; ?></td>
                            <td><?php echo $r['ra_per']; ?></td>
                            <td><?php echo $r['bend_test']; ?></td>
                            <td><?php echo $r['torsion_test']; ?></td>
                            <td><?php echo $r['lotname']; ?></td>
                            <td><?php if(!empty($r['fentry_date']) and $r['fentry_date'] != '0000-00-00')echo $this->Base->change_date_dmy($r['fentry_date']);?></td>
                            <td><?php echo $r['new_coil_no'];?></td>


                           
                            <td> <?php  if(!empty($spec)){ echo $spec['min_size'].'-'.$spec['max_size'];} ?></td>
                            <td><strong class="<?php if(!empty($spec)){ echo $spec['size_color'];} ?>"><?php echo $r['fur_finish_size'];?></strong></td>
                            <td> <?php  if(!empty($spec)){ echo $spec['ts_min_ss1'].'-'.$spec['ts_max_ss1'];} ?></strong></td>
                            <td><strong class="<?php if(!empty($spec)){ echo $spec['ts1_color'];} ?>"><?php echo $r['futs'];?></td>
                            <td><strong class="<?php if(!empty($spec)){ echo $spec['ts1_color'];} ?>"><?php if(!empty($spec)){ echo $spec['ts1_category'];} ?></strong></td>



                            
                            <td><?php echo $r['bl'];?></td>
                            <td><?php echo $r['zinc'];?></td>
                            <td><?php echo $r['ra'];?></td>
                            <td><?php echo $r['temp'];?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

        <?php
     
    }//function close



    

    // Get Semi-Wire Base Specification
    public function get_specification_1($product_type, $finsh_size, $size, $uts)
    {
        // Get data based on product type
        if ($product_type == 1) {
            $res3 = $this->Qcmodel->get_spec1_details_from_size_for_patt($finsh_size);
        } else {
            $res3 = $this->Qcmodel->get_spec1_details_from_size_for_non_patt($finsh_size);
        }
        $result = array();
        if (!empty($res3)) {
            
            $min_size = $res3[0]['min_size'];
            $max_size = $res3[0]['max_size'];

            $ts_min_ss1 = $res3[0]['ts_min_ss1'];
            $ts_max_ss1 = $res3[0]['ts_max_ss1'];
            $ts_min_ss2 = $res3[0]['ts_min_ss2'];
            $ts_max_ss2 = $res3[0]['ts_max_ss2'];
            $ts_min_ss3 = $res3[0]['ts_min_ss3'];
            $ts_max_ss3 = $res3[0]['ts_max_ss3'];

            $result['min_size'] = $res3[0]['min_size'];
            $result['max_size'] = $res3[0]['max_size'];
            
            $result['ts_min_ss1'] = $res3[0]['ts_min_ss1'];
            $result['ts_max_ss1'] = $res3[0]['ts_max_ss1'];
            
            $result['ts_min_ss2'] = $res3[0]['ts_min_ss2'];
            $result['ts_max_ss2'] = $res3[0]['ts_max_ss2'];
            
            $result['ts_min_ss3'] = $res3[0]['ts_min_ss3'];
            $result['ts_max_ss3'] = $res3[0]['ts_max_ss3'];
           
            

            $size_color = ($size >= $min_size && $size <= $max_size) ? "text-success" : "text-danger";
            $result['size_color'] = $size_color;

            // echo '<div class="mb-2">';
            // echo "Min Size: <strong>$min_size</strong> &nbsp;&nbsp;";
            // echo "Actual: <strong class=\"$size_color\">$size</strong> &nbsp;&nbsp;";
            // echo "Max Size: <strong>$max_size</strong>";
            // echo '</div>';

            if (!empty($uts) && $uts > 0) {
                // Determine which specs the UTS matches
                $ts1_color = ($uts >= $ts_min_ss1 && $uts <= $ts_max_ss1) ? "text-success" : "text-danger";
                $ts2_color = ($uts >= $ts_min_ss2 && $uts <= $ts_max_ss2) ? "text-success" : "text-danger";
                $ts3_color = ($uts >= $ts_min_ss3 && $uts <= $ts_max_ss3) ? "text-success" : "text-danger";

                $result['ts1_color'] = $ts1_color;
                $result['ts2_color'] = $ts2_color;
                $result['ts3_color'] = $ts3_color;

                if($uts < $ts_min_ss1){
                    $result['ts1_category'] = 1;
                }
                elseif($uts > $ts_max_ss1){
                    $result['ts1_category'] = 3;
                }else{
                     $result['ts1_category'] = 2;
                }

                // echo '<div>';
                // echo "UTS: &nbsp;&nbsp;";
                // echo "Spec.1: <span class=\"$ts1_color\">{$ts_min_ss1} - {$ts_max_ss1}</span> &nbsp;&nbsp;";
                // echo "Spec.2: <span class=\"$ts2_color\">{$ts_min_ss2} - {$ts_max_ss2}</span> &nbsp;&nbsp;";
                // echo "Spec.3: <span class=\"$ts3_color\">{$ts_min_ss3} - {$ts_max_ss3}</span>";
                // echo '</div>';
            }else{
                $result['ts1_color'] = '';
                $result['ts2_color'] = '';
                $result['ts3_color'] = '';
                $result['ts1_category'] = '';
             }
        } 
        return $result;
    }








}//class close
