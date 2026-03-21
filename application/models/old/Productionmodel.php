<?php
class Productionmodel extends CI_Model
{
	//get production details form id
	public function get_production_data_with_id($id)
	{
        $sql = "SELECT * FROM production_entry where production_id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_rope_production_data_with_id($id)
	{
        $sql = "SELECT * FROM production_entry_rope where production_id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get last production details of this machine
	public function fun_get_last_machine_production($mc_id)
	{
        $sql = "SELECT A.*,B.name as bname,C.name as cname
        FROM production_entry as A 
        LEFT JOIN product as B ON B.product_id = A.in_product_id 
        LEFT JOIN product as C ON C.product_id = A.out_product_id 
        where A.mc_id = '$mc_id' ORDER BY A.entry_date DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //rope
    public function fun_get_last_machine_production_rope($mc_id,$size)
	{
        $sql = "SELECT * FROM production_entry_rope as A 
        where A.mc_id = '$mc_id' and size = '$size' ORDER BY A.entry_date DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    


    //get production qty date and dept wise
	public function get_total_production_dept_wise($dept,$entry_date)
	{
        if($dept == "All")
        {
            //get only main dept data
            $sql = "SELECT sum(total_qty) as qty 
                    FROM production_entry as A 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    where A.entry_date='$entry_date' 
                    ";
        }
        else
        {
            $sql = "SELECT sum(total_qty) as qty 
                    FROM production_entry as A 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    where A.entry_date='$entry_date' and  J.department_id ='$dept' 
                    ";
        }
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){return $res[0]['qty'];}
    }//function close


    
    public function get_pro_on_emp_dept_date($emp_code,$dept,$from_date,$to_date,$field)
	{
        if($field == 'Operator'){$col1 = "A.operator_id_1";$col2 = "A.operator_id_2";}else{$col1 = "A.helper1";$col2 = "A.helper2";}

        $sql = "SELECT sum(qty1) as qty,avg(effi1) as effi1
                    FROM production_entry as A 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    where A.entry_date between '$from_date' and '$to_date' and  J.department_id ='$dept' and $col1='$emp_code'
                    ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ $qty1 = $res[0]['qty'];  $effi1 = $res[0]['effi1'];}else{$qty1 = 0;$effi1 =0;}

        $sql = "SELECT sum(qty2) as qty,avg(effi2) as effi2
                    FROM production_entry as A 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    where A.entry_date between '$from_date' and '$to_date' and  J.department_id ='$dept' and $col2 = '$emp_code'
                    ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ $qty2 = $res[0]['qty']; $effi2 = $res[0]['effi2'];}else{$qty2 = 0;$effi2 = 0;}

        if($effi1>0 and $effi2>0)
        {
            $total_eff = round(($effi1+$effi2)/2);
        }
        elseif($effi1>0 and $effi2 < 1)
        {
            $total_eff = round($effi1);
        }
        elseif($effi1<1 and $effi2>0)
        {
            $total_eff = round($effi2);
        }
        else
        {
            $total_eff = 0;
        }
        
        $result['qty']=$qty1+$qty2;
        $result['eff']=$total_eff;
        return $result;
    }//function close


    //get_pro_of_emp_machine_name_in_given_date
	public function get_pro_of_emp_machine_name_in_given_date($dept,$from_date,$to_date,$emp_code)
	{
        $sql = "SELECT A.mc_id,I.name as mc_name
            FROM production_entry as A 
            LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
            LEFT JOIN department as J ON J.department_id = I.dept 
            where  A.entry_date between '$from_date' and '$to_date' and  J.department_id ='$dept' and 
            (A.operator_id_1='$emp_code' or A.operator_id_2='$emp_code' or A.helper1='$emp_code' or A.helper2='$emp_code')
            ORDER BY  A.entry_date DESC  LIMIT 1
        ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        echo $res[0]['mc_name'];
    }//function close

    //get production product type and product/size wise
	public function get_production_date_dept_wise($from_date,$to_date,$dept)
	{
        if($dept == "All")
        {
            $sql = "SELECT 
                    A.out_product_id,sum(A.total_spool) as coil,sum(A.total_qty) as qty
                    FROM production_entry as A 
                    LEFT JOIN product as C ON C.product_id = A.out_product_id 
                    LEFT JOIN product_type as E ON E.id = A.product_type 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    where A.entry_date between '$from_date' and '$to_date'  
                   
                    ";
        }
        else
        {
             $sql = "SELECT 
                    A.out_product_id,sum(A.total_spool) as coil,sum(A.total_qty) as qty
                    FROM production_entry as A 
                    LEFT JOIN product as C ON C.product_id = A.out_product_id 
                    LEFT JOIN product_type as E ON E.id = A.product_type 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    where A.entry_date between '$from_date' and '$to_date' and  J.department_id ='$dept'
                   
                    ";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    

    //get production product type and product/size wise
	public function get_production_product_type_and_product_wise($from_date,$to_date,$dept)
	{
        if($dept == "All")
        {
            $sql = "SELECT 
                    A.out_product_id,sum(A.total_spool) as coil,sum(A.total_qty) as qty,
                    C.name as out_product_name,C.size as out_size,
                    E.name as product_type_name
                    FROM production_entry as A 
                    LEFT JOIN product as C ON C.product_id = A.out_product_id 
                    LEFT JOIN product_type as E ON E.id = A.product_type 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    where A.entry_date between '$from_date' and '$to_date'  
                    GROUP BY A.product_type,A.out_product_id
                    ";
        }
        else
        {
            $sql = "SELECT 
                    A.out_product_id,sum(A.total_spool) as coil,sum(A.total_qty) as qty,
                    C.name as out_product_name,C.size as out_size,
                    E.name as product_type_name
                    FROM production_entry as A 
                    LEFT JOIN product as C ON C.product_id = A.out_product_id 
                    LEFT JOIN product_type as E ON E.id = A.product_type 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    where A.entry_date between '$from_date' and '$to_date' and  J.department_id ='$dept'
                    GROUP BY A.product_type,A.out_product_id
                    ";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    public function get_date_wise_machine_details($from_date,$to_date,$mc_id)
    {
        $sql = "SELECT 
                    sum(A.total_spool) as coil,sum(A.qty1) as qty_a,sum(A.qty2) as qty_b,sum(A.total_qty) as qty,
                    sum(A.running_hours_1) as mc_running_hours_a,sum(A.running_hours_2) as mc_running_hours_b
                    FROM production_entry as A 
                    where A.entry_date between '$from_date' and '$to_date' and  A.mc_id ='$mc_id'
                    ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //get dept wise and machine wise production 
    public function get_date_wise_machine_details2($from_date,$to_date,$dept_id,$mc_id)
    {
        if($dept_id==5)
        { 
            //wet block
            if($mc_id<12)
            {
                $sql = "SELECT sum(total_qty) as qty FROM production_entry where entry_date between '$from_date' and '$to_date' and  mc_id IN (4,5,6,7,8,9,10,11)  ";
            }
            else
            {
                $sql = "SELECT sum(total_qty) as qty FROM production_entry where entry_date between '$from_date' and '$to_date' and  mc_id IN (12,13,14,15,16,17,18,19,20,30)  ";
            }
        }
        else
        {
            //mini or dry
            $sql = "SELECT sum(total_qty) as qty FROM production_entry where entry_date between '$from_date' and '$to_date' and  mc_id ='$mc_id' ";
        }
            
        //starting reading
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){$qty = $res[0]['qty'];}else{$qty = 0;}
        return $qty;
        
    }//function close

     
  

    public function get_date_wise_pro_details_with_product_type($from_date,$to_date,$dept,$col,$product_type)
    {
        if($col == 1){$col_name = "P.dept_1_w"; }
        elseif($col == 2){$col_name = "P.dept_2_m"; }
        elseif($col == 3){$col_name = "P.dept_3_d"; }
        else{$col_name = "P.dept_1_w";}

        $sql = "SELECT sum(qty1) as qty,`product_type` 
                    FROM production_entry as A 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id 
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    LEFT JOIN product_type as P ON P.id = A.product_type 
                    where A.entry_date between '$from_date' and '$to_date' and J.department_id ='$dept' and $col_name =  '$product_type'
                ";
      
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){  $qty1 = $res[0]['qty'];}else{$qty1 = 0;}

        $sql = "SELECT sum(qty2) as qty
                FROM production_entry as A 
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id 
                LEFT JOIN department as J ON J.department_id = I.dept 
                LEFT JOIN product_type as P ON P.id = A.product_type 
                where A.entry_date between '$from_date' and '$to_date' and J.department_id ='$dept' and $col_name =  '$product_type'
                ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ $qty2 = $res[0]['qty']; }else{$qty2 = 0;}
        return $result['qty']=$qty1+$qty2;
    }//function close



    //------------------emp list present on given date
    public function get_emp_list_in_given_date($dept,$from_date,$to_date,$field)
    {
        $sql = "    SELECT 
                    A.operator_id_1,A.operator_id_2,A.helper1,A.helper2
                    FROM production_entry as A 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    where A.entry_date between '$from_date' and '$to_date' and  J.department_id ='$dept'  
                    ";
        $query = $this->db->query($sql);
        $res =  $query->result_array();
        $op = array();$hp = array();
        foreach($res as $r)
        {
            if(!empty($r['operator_id_1'])){$op[] = $r['operator_id_1'];}
            if(!empty($r['operator_id_2'])){$op[] = $r['operator_id_2'];}
            if(!empty($r['helper1'])){$hp[] = $r['helper1'];}
            if(!empty($r['helper2'])){$hp[] = $r['helper2'];}
        }

        if($field == 'Operator'){ return array_unique($op);}else{ return  array_unique($hp);}
    }//function close

    //------------------emp list present on given date
    public function get_emp_list_in_given_date_mc($mc_id,$from_date,$to_date,$data)
    {
        $test = new DateTime($from_date); 
        $month = date_format($test,'m');
        $year = date_format($test,'Y');

        $sql = "    SELECT 
                    A.operator_id_1,A.operator_id_2,A.helper1,A.helper2
                    FROM production_entry as A 
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                    LEFT JOIN department as J ON J.department_id = I.dept 
                    where A.entry_date between '$from_date' and '$to_date'   
                    ";
        if($mc_id != 'ALL'){ $sql = $sql."and  A.mc_id ='$mc_id'";}
        $query = $this->db->query($sql);
        $res =  $query->result_array();
        $op = array();$hp = array();
        foreach($res as $r)
        {
            if(!empty($r['operator_id_1'])){$op[] = $r['operator_id_1'];}
            if(!empty($r['operator_id_2'])){$op[] = $r['operator_id_2'];}
            if(!empty($r['helper1'])){$hp[] = $r['helper1'];}
            if(!empty($r['helper2'])){$hp[] = $r['helper2'];}
        }
        $uop = array_unique($op);
        $hp = array_unique($hp);
        
        //geting op salary
        $op_gross_salary = array();
        $op_net_pay = array();
        foreach($uop as $o)
        {
            $out3 = $this->Hrmodel->get_emp_deatis_with_emp_code($o);
            if(!empty($out3))
            {
                //$out3[0]['first_name'];
                $op_gross_salary[] = $out3[0]['current_total_ctc'];
                //attendance
                $company_role = $out3[0]['company_role'];
                $emp_id = $out3[0]['id'];
                $att = $this->Hrmodel->get_atten_details_limit($company_role,$emp_id,$year,$month,1);
                if(isset($att[0]['current_total_ctc_payable'])){$op_net_pay[] = $att[0]['current_total_ctc_payable'];}else{$op_net_pay[] = 0;}
            }//!empty
        }
        if(!empty($op_gross_salary)){ $op_gross_salary2 = round(array_sum($op_gross_salary));}else{ $op_gross_salary2 = 0;}
        if(!empty($op_net_pay)){ $op_net_pay2 = round(array_sum($op_net_pay));}else{ $op_net_pay2 = 0;}

        //geting hp salary
        $hp_gross_salary = array();
        $hp_net_pay = array();
        foreach($hp as $o)
        {
            $out3 = $this->Hrmodel->get_emp_deatis_with_emp_code($o);
            if(!empty($out3))
            {
                //$out3[0]['first_name'];
                $hp_gross_salary[] = $out3[0]['current_total_ctc'];
                //attendance
                $company_role = $out3[0]['company_role'];
                $emp_id = $out3[0]['id'];
                $att = $this->Hrmodel->get_atten_details_limit($company_role,$emp_id,$year,$month,1);
                if(isset($att[0]['current_total_ctc_payable'])){$hp_net_pay[] = $att[0]['current_total_ctc_payable'];}else{$hp_net_pay[] = 0;}
            }//!empty
        }
        if(!empty($hp_gross_salary)){ $hp_gross_salary2 = round(array_sum($hp_gross_salary));}else{ $hp_gross_salary2 = 0;}
        if(!empty($hp_net_pay)){ $hp_net_pay2 = round(array_sum($hp_net_pay));}else{ $hp_net_pay2 = 0;}

        $result['op_gross_salary'] = $op_gross_salary2;
        $result['op_net_pay'] = $op_net_pay2;
        $result['hp_gross_salary'] = $hp_gross_salary2;
        $result['hp_net_pay'] = $hp_net_pay2; 
        return $result;
    }//function close



    //------------------emp list present on given date
    public function get_emp_list_in_given_date_mc2($mc_id,$date,$type,$dept_id,$display)
    {
        if($dept_id == 5){$avg_salry=900; $avg_salry2 = 0;}
        elseif($dept_id == 6){$avg_salry=900; $avg_salry2 = 600;}
        elseif($dept_id == 28){$avg_salry=700; $avg_salry2 = 550;}
        else{$avg_salry=900;}
        //same machine
        $sql = "SELECT 
                A.operator_id_1,A.operator_id_2,A.helper1,A.helper2
                FROM production_entry as A 
                where A.entry_date = '$date'  and  A.mc_id ='$mc_id'  
                ";
        $query = $this->db->query($sql);
        $op_list =  $query->result_array();
       
        $all_op_array = array();
        $all_hp_array = array();
        foreach($op_list as $o)
        {
            $all_op_array[] = $o['operator_id_1'];
            $all_op_array[] = $o['operator_id_2'];
            $all_hp_array[] = $o['helper1'];
            $all_hp_array[] = $o['helper2'];
        }
        $result['all_op'] = array_unique($all_op_array);
        $result['all_hp'] = array_unique($all_hp_array);


        //other machine
        $sql = "SELECT 
                A.operator_id_1,A.operator_id_2,A.helper1,A.helper2
                FROM production_entry as A 
                where A.entry_date = '$date'  and  A.mc_id !='$mc_id'  
                ";
        $query = $this->db->query($sql);
        $op_list2 =  $query->result_array();
        $other_op_hp_array = array();
        foreach($op_list2 as $o)
        {
            $other_op_hp_array[] = $o['operator_id_1'];
            $other_op_hp_array[] = $o['operator_id_2'];
            $other_op_hp_array[] = $o['helper1'];
            $other_op_hp_array[] = $o['helper2'];
        }
        //$result['other_op_hp'] = array_unique($other_op_hp_array);
        $result['other_op_hp'] = $other_op_hp_array;
        //print_r($result);
        return $result;
       
        
       
        /*
        if($type == 'OP')
        {
               
        }
        else
        {
              
        }
        */
            
    }//function close

    
   
    //production search 
    public function get_all_production_qty_search($search)
    {
        $sql="  SELECT 
                sum(A.total_qty) as qty
                FROM production_entry as A 
                WHERE 1=1  $search  
            ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(!empty($result)){
            return  $result[0]['qty'];
        }
    }//function close



    //production search 
    public function get_all_production_with_search($search)
    {
         $sql="  SELECT 
                A.*,
                B.name as in_product_name,B.size as in_size,
                C.name as out_product_name,C.size as out_size,
                D.name as grade_name,
                E.name as product_type_name,
                F.name as unit_name,
                G.first_name as op_name1,
                H.first_name as op_name2,
                I.name as mc_name,
                J.name as dept_name
                
                FROM production_entry as A 
                LEFT JOIN product as B ON B.product_id = A.in_product_id
                LEFT JOIN product as C ON C.product_id = A.out_product_id  
                LEFT JOIN product_grade as D ON D.id = A.grade 
                LEFT JOIN product_type as E ON E.id = A.product_type
                LEFT JOIN unit as F ON F.unit_id = A.unit_id
                LEFT JOIN employee as G ON G.emp_code = A.operator_id_1
                LEFT JOIN employee as H ON H.emp_code = A.operator_id_2
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                LEFT JOIN department as J ON J.department_id = I.dept 
                WHERE 1=1  $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //rope production search 
    public function get_all_rope_production_with_search($search)
    {
         $sql="  SELECT 
                A.*,
                D.name as grade_name,
                G.first_name as op_name,
                H.first_name as hp_name,
                I.name as mc_name
                
                FROM production_entry_rope as A 
                LEFT JOIN product_grade as D ON D.id = A.grade 
                LEFT JOIN employee as G ON G.emp_code = A.operator1
                LEFT JOIN employee as H ON H.emp_code = A.helper1
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
               
                WHERE 1=1  $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function rope_production_groupby_shift($mctype,$fdate,$tdate)
    {
        $sql=" SELECT 
                sum(A.qty_in_meter) as mtr, sum(A.qty_in_kg) as kgs, sum(A.scrap) as scrap, avg(A.eff1) as eff,
                A.shift1
                FROM production_entry_rope as A 
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                WHERE  I.type ='$mctype' and  A.entry_date between '$fdate' and '$tdate' GROUP BY A.shift1
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function rope_production_groupby_mc($mctype,$fdate,$tdate)
    {
        $sql=" SELECT 
                sum(A.qty_in_meter) as mtr, sum(A.qty_in_kg) as kgs, sum(A.scrap) as scrap, avg(A.eff1) as eff,
                I.name as mc_name
                FROM production_entry_rope as A 
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                WHERE  I.type ='$mctype' and  A.entry_date between '$fdate' and '$tdate' GROUP BY I.name
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function rope_production_groupby_size($mctype,$fdate,$tdate)
    {
        $sql=" SELECT 
                sum(A.qty_in_meter) as mtr, sum(A.qty_in_kg) as kgs, sum(A.scrap) as scrap, avg(A.eff1) as eff,
                A.size
                FROM production_entry_rope as A 
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                WHERE  I.type ='$mctype' and  A.entry_date between '$fdate' and '$tdate' GROUP BY A.size
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function rope_production_groupby_op($mctype,$fdate,$tdate)
    {
        $sql=" SELECT 
                sum(A.qty_in_meter) as mtr, sum(A.qty_in_kg) as kgs, sum(A.scrap) as scrap, avg(A.eff1) as eff,
                A.operation
                FROM production_entry_rope as A 
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                WHERE  I.type ='$mctype' and  A.entry_date between '$fdate' and '$tdate' GROUP BY A.operation
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function rope_production_groupby_con($mctype,$fdate,$tdate)
    {
        $sql=" SELECT 
                sum(A.qty_in_meter) as mtr, sum(A.qty_in_kg) as kgs, sum(A.scrap) as scrap, avg(A.eff1) as eff,
                A.construction
                FROM production_entry_rope as A 
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                WHERE  I.type ='$mctype' and  A.entry_date between '$fdate' and '$tdate' GROUP BY A.construction
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function rope_production_groupby_grade($mctype,$fdate,$tdate)
    {
        $sql=" SELECT 
                sum(A.qty_in_meter) as mtr, sum(A.qty_in_kg) as kgs, sum(A.scrap) as scrap, avg(A.eff1) as eff,
                D.name as grade_name
                FROM production_entry_rope as A 
                LEFT JOIN product_grade as D ON D.id = A.grade 
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                WHERE  I.type ='$mctype' and  A.entry_date between '$fdate' and '$tdate' GROUP BY D.name
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function rope_production_groupby_opman($mctype,$fdate,$tdate)
    {
        $sql=" SELECT 
                sum(A.qty_in_meter) as mtr, sum(A.qty_in_kg) as kgs, sum(A.scrap) as scrap, avg(A.eff1) as eff,
                G.first_name as op_name
                FROM production_entry_rope as A 
                LEFT JOIN employee as G ON G.emp_code = A.operator1
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                WHERE  I.type ='$mctype' and  A.entry_date between '$fdate' and '$tdate' GROUP BY  G.first_name
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function rope_production_groupby_helman($mctype,$fdate,$tdate)
    {
        $sql=" SELECT 
                sum(A.qty_in_meter) as mtr, sum(A.qty_in_kg) as kgs, sum(A.scrap) as scrap, avg(A.eff1) as eff,
                H.first_name as hp_name
                FROM production_entry_rope as A 
                LEFT JOIN employee as H ON H.emp_code = A.helper1
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                WHERE  I.type ='$mctype' and  A.entry_date between '$fdate' and '$tdate' GROUP BY  H.first_name
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    
    



    public function full_month_production_dept_wise($dept,$full_month_date,$month,$year)
    {
        foreach($full_month_date as $d)
        {
            $current_date = $this->Base->get_date_form_dayno_ymd($d,$month,$year);
            $production = $this->get_total_production_dept_wise($dept,$current_date);
            if(empty($production)){$production = 0;}
            $qty[] = $production;
        }//foreach
        return  $qty;
    }//function close



    //same query in Maintenancemodel get_kg_kwh_with_search
    //meter Production and KWH
    public function get_kg_kwh_with_search($date)
    {
        $sql="  SELECT A.* FROM production_day_wse as A WHERE 1=1 and A.entry_date = '$date'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    




   





















    //-----------------------------------------------------------Chart


    //dashbord production chart
    public function production_chart_display($year,$month,$div_length,$dept_id,$dept_name)
    {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $label = $this->Base->get_day_no_on_month($month,$year);

        $div_name = 'chart_a'.$dept_id;
        $data = $this->full_month_production_dept_wise($dept_id,$label,$month,$year);
        if(!empty($data) and array_sum($data)>0)
        {
           $this->Chartmodel->print_line_chart($div_name,'350','#03A9F4',$label,$data);
            ?>
                <div class="col-md-<?php echo $div_length;?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title" style="color:#03A9F4;"><?php echo $dept_name;?>, Date Wise Production</div>
                            <div class="row">
                                <div class="col-md-2" style="height:300px; overflow:auto;">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Production</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=0;$total = array();
                                                foreach($data as $d)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $label[$i].'-'.$month.'-'.$year;?></td>
                                                        <td class=" font-weight-bold" style="color:#03A9F4;"><?php echo $total[] = $d;?></td>
                                                    </tr>
                                                    <?php
                                                $i++;
                                                }
                                            ?>
                                        </tbody>
                                        <tfooter class="thead-light">
                                            <tr>
                                                <th scope="col">Total</th>
                                                <th scope="col"><?php if(!empty($total)){ echo round(array_sum($total));}?></th>
                                            </tr>
                                            <tr>
                                                <th scope="col">Avg</th>
                                                <th scope="col"><?php if(!empty($total)){ echo round(array_sum($total)/count($total));}?></th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                                <div class="col-md-10">
                                    <div id="<?php echo $div_name;?>" style="height: 200px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               
            <?php
        }//data
    }//function close



     //dashbord production chart
     public function production_machine_chart_display($year,$month,$div_length,$dept_id,$dept_name)
     {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        //all machine list of this dept
        $machine_list = $this->Machinemodel->fun_get_machine_form_dept_id($dept_id);
        
        
       
        $label = array();$mc_running_a = array();$mc_running_b = array();
        foreach($machine_list as $m)
        {
            $label[] = $m['name'];
            $res3 = $this->Productionmodel->get_date_wise_machine_details($from_date,$to_date,$m['mc_id']);
            if(!empty($res3[0]['qty_a']) and $res3[0]['qty_a']>0){
                $qty_a[] = round($res3[0]['qty_a']);
            }else{ $qty_a[] =0;}

            if(!empty($res3[0]['qty_b']) and $res3[0]['qty_b']>0){
                $qty_b[] = round($res3[0]['qty_b']);
            }else{ $qty_b[] =0;}

            if(!empty($res3[0]['qty']) and $res3[0]['qty']>0){
                $qty_t[] = round($res3[0]['qty']);
            }else{ $qty_t[] =0;}
        }//foreach

        if(!empty($qty_a)){}else{$qty_a=0;}
        if(!empty($qty_b)){}else{$qty_b=0;}
        if(!empty($qty_t)){}else{$qty_t=0;}
        
        $data = [$qty_a,$qty_b,$qty_t];
        $color = ['#44987B','#A0D4A0','#03A9F4'];
        $name = ['Shift A','Shift B','Total'];
        //chart1
        $div_name = 'chart_g'.$dept_id;
        $this->Chartmodel->print_double_bar_chart($div_name,'350',$color,$label,$data,$name);
        ?>
                 <div class="col-md-<?php echo $div_length;?>">
                     <div class="card mb-4">
                         <div class="card-body">
                             <div class="card-title" ><?php //echo $dept_name;?> Machine Wise Production</div>
                             <div class="row">
                                 <div class="col-md-3" style="height:300px; overflow:auto;">
                                 <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Machine</th>
                                                <th scope="col">Shift (A)</th>
                                                <th scope="col">Shift (B)</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=0;$total1 = array();$total2 = array();$total3 = array();
                                                foreach($label as $l)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $l;?></td>
                                                        <td class=" font-weight-bold" style="color:#44987B"><?php echo $total1[] = $qty_a[$i];?></td>
                                                        <td class=" font-weight-bold" style="color:#A0D4A0"><?php echo $total2[] = $qty_b[$i];?></td>
                                                        <td class=" font-weight-bold" style="color:#03A9F4"><?php echo $total3[] = $qty_t[$i];?></td>
                                                    </tr>
                                                    <?php
                                                $i++;
                                                }
                                            ?>
                                        </tbody>
                                        <tfooter class="thead-light">
                                            <tr>
                                                <th scope="col">Total</th>
                                                <th scope="col"><?php if(!empty($total1)){ echo round(array_sum($total1));}?></th>
                                                <th scope="col"><?php if(!empty($total2)){ echo round(array_sum($total2));}?></th>
                                                <th scope="col"><?php if(!empty($total3)){ echo round(array_sum($total3));}?></th>
                                            </tr>
                                            <tr>
                                                <th scope="col">Avg</th>
                                                <th scope="col"><?php if(!empty($total1)){ echo round(array_sum($total1)/count($total1));}?></th>
                                                <th scope="col"><?php if(!empty($total2)){ echo round(array_sum($total2)/count($total2));}?></th>
                                                <th scope="col"><?php if(!empty($total3)){ echo round(array_sum($total3)/count($total3));}?></th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                 </div>
                                 <div class="col-md-9">
                                     <div id="<?php echo $div_name;?>" style="height: 200px;"></div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
 
                
             <?php
        
     }//function close


    //dashbord production chart
    public function production_type_and_name_chart_display($year,$month,$div_length,$div_length2,$dept_id,$dept_name)
    {
    
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $res3 = $this->Productionmodel->get_production_product_type_and_product_wise($from_date,$to_date,$dept_id);
        $data = array();$data = array();
        foreach($res3 as $s)
        {
            $label[] = $s['product_type_name'].'('.$s['out_size'].')';
            $data[] = $s['qty'];
        }
       
        if(!empty($data) and array_sum($data)>0)
        {
            $color_list = $this->Base->get_random_color_list(count($data));
        
            //chart1
            $div_name = 'chart_b'.$dept_id;
            $this->Chartmodel->print_custom_bar_chart($div_name,'350','#03A9F4',$label,$data,$color_list);
            
            //chart2
            //$div_name2 = 'chart_c'.$dept_id;
            //$this->Chartmodel->print_donut_chart($div_name2,'350','100','#03A9F4',$label,$data,$color_list);
            ?>
                <div class="col-md-<?php echo $div_length;?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title"><?php //echo $dept_name;?> Product Type wise Qty</div>
                            <div class="row">
                                <div class="col-md-2" style="height:300px; overflow:auto;">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Product Type</th>
                                                <th scope="col">Production</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=0;$total = array();
                                                foreach($data as $d)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $label[$i];?></td>
                                                        <td class=" font-weight-bold" style="color:<?php echo $color_list[$i];?>"><?php echo $total[] = $d;?></td>
                                                    </tr>
                                                    <?php
                                                $i++;
                                                }
                                            ?>
                                        </tbody>
                                        <tfooter class="thead-light">
                                            <tr>
                                                <th scope="col">Total</th>
                                                <th scope="col"><?php if(!empty($total)){ echo round(array_sum($total));}?></th>
                                            </tr>
                                            <tr>
                                                <th scope="col">Avg</th>
                                                <th scope="col"><?php if(!empty($total)){ echo round(array_sum($total)/count($total));}?></th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                                <div class="col-md-10">
                                    <div id="<?php echo $div_name;?>" style="height: 200px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php /*
                <div class="col-md-<?php echo $div_length;?>">
                    <div class="card mb-12">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="card-title"><?php //echo $dept_name;?> Product Type wise Qty </div>
                                <div id="<?php echo $div_name;?>"></div>
                            </div>
                        </div>
                    </div>
                </div>

               
                <div class="col-md-<?php echo $div_length2;?>">
                    <div class="card mb-12">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="card-title"><?php echo $dept_name;?>, Product Type wise Qty</div>
                                <div id="<?php echo $div_name2;?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                */?>

            <?php
        }//data
    }//function close

    
   
    
    
    //dashbord running chart
    public function production_mc_running_chart_display($year,$month,$div_length,$dept_id,$dept_name)
    {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        //all machine list of this dept
        $machine_list = $this->Machinemodel->fun_get_machine_form_dept_id($dept_id);
        
        $label = array();$mc_running_a = array();$mc_running_b = array();$reading_diff = array();
        foreach($machine_list as $m)
        {
            $label[] = $m['name'];
            $res3 = $this->Productionmodel->get_date_wise_machine_details($from_date,$to_date,$m['mc_id']);
            if(!empty($res3[0]['mc_running_hours_a']) and $res3[0]['mc_running_hours_a']>0){
                $mc_running_a[] = round($res3[0]['mc_running_hours_a']);
            }else{ $mc_running_a[] =0;}

            if(!empty($res3[0]['mc_running_hours_b']) and $res3[0]['mc_running_hours_b']>0){
                $mc_running_b[] = round($res3[0]['mc_running_hours_b']);
            }else{ $mc_running_b[] =0;}

            $res4 = $this->Maintenancemodel->get_reading_full_details($from_date,$to_date,0,$m['mc_id']);
            if($res4[2]>0){$reading_diff[] = $res4[2];}else{$reading_diff[] = 0;}
            
        }//foreach
        
        $data = [$mc_running_a,$mc_running_b];
        $color = ['#44987B','#A0D4A0'];
        $name = ['Shift A','Shift B','Total'];
        //chart1
        $div_name = 'chart_d'.$dept_id;
        $this->Chartmodel->print_double_bar_chart($div_name,'350',$color,$label,$data,$name);
        ?>
             <div class="col-md-<?php echo $div_length;?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title"><?php //echo $dept_name;?> Total Running Hours Monthly (Shift A / B)</div>
                            <div class="row">
                                <div class="col-md-4" style="height:300px; overflow:auto;">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Machine</th>
                                                <th scope="col">Shift (A)</th>
                                                <th scope="col">Shift (B)</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Meter Reading Inc.</th>
                                                <th scope="col">Reading / Hours</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=0;$total1 = array();$total2 = array();$total3 = array();$total4 = array();
                                                foreach($label as $l)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $l;?></td>
                                                        <td class=" font-weight-bold" style="color:#44987B"><?php echo $total1[] = $mc_running_a[$i];?></td>
                                                        <td class=" font-weight-bold" style="color:#A0D4A0"><?php echo $total2[] = $mc_running_b[$i];?></td>
                                                        <td class=" font-weight-bold" ><?php echo $total_run = round($mc_running_a[$i]+$mc_running_b[$i]);  $total3[] = $total_run;?></td>
                                                        <td class=" font-weight-bold" ><?php echo $mtr_reading = $reading_diff[$i]; $total4[] = $mtr_reading;?></td>
                                                        <td class=" font-weight-bold" ><?php if($mtr_reading >0 and $total_run>0){echo round($mtr_reading/$total_run);}?></td>
                                                    </tr>
                                                    <?php
                                                $i++;
                                                }
                                            ?>
                                        </tbody>
                                        <tfooter class="thead-light">
                                            <tr>
                                                <th scope="col">Total</th>
                                                <th scope="col"><?php if(!empty($total1)){ echo round(array_sum($total1));}?></th>
                                                <th scope="col"><?php if(!empty($total2)){ echo round(array_sum($total2));}?></th>
                                                <th scope="col"><?php if(!empty($total3)){ echo round(array_sum($total3));}?></th>
                                            </tr>
                                            <tr>
                                                <th scope="col">Avg</th>
                                                <th scope="col"><?php if(!empty($total1)){ echo round(array_sum($total1)/count($total1));}?></th>
                                                <th scope="col"><?php if(!empty($total2)){ echo round(array_sum($total2)/count($total2));}?></th>
                                                <th scope="col"><?php if(!empty($total3)){ echo round(array_sum($total3)/count($total3));}?></th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <div id="<?php echo $div_name;?>" style="height: 200px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
     }//function close


    //dashbord reading chart
    public function production_mc_reading_chart_display($year,$month,$div_length,$dept_id,$dept_name)
    {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        //all machine list of this dept
        $machine_list = $this->Machinemodel->fun_get_machine_form_dept_id($dept_id);
        
        $label = array();$reading_start = array();$reading_end = array();$reading_diff = array();$reading_diff_per = array();
        foreach($machine_list as $m)
        {
            $label[] = $m['name'];
            $res3 = $this->Maintenancemodel->get_reading_full_details($from_date,$to_date,0,$m['mc_id']);
            if($res3[0]>0){$reading_start[] = $res3[0];}else{$reading_start[] = 0;}
            if($res3[1]>0){$reading_end[] = $res3[1];}else{$reading_end[] = 0;}
            if($res3[2]>0){$reading_diff[] = $res3[2];}else{$reading_diff[] = 0;}
            if($res3[3]>0){$reading_diff_per[] = $res3[3];}else{$reading_diff_per[] = 0;}
        }//foreach
        //chart1
        $div_name = 'chart_e'.$dept_id;
        $this->Chartmodel->print_bar_chart($div_name,'350','#53569C',$label,$reading_end);
        ?>
            <div class="col-md-<?php echo $div_length;?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title"><?php echo $dept_name;?> Total Energy Meter Reading</div>
                            <div class="row">
                                <div class="col-md-3" style="height:300px; overflow:auto;">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Machine</th>
                                                <th scope="col">Before <?php echo $this->Base->change_date_dmy($from_date);?> </th>
                                                <th scope="col">Current Reading</th>
                                                <th scope="col">Inc.</th>
                                                <th scope="col">% Inc.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=0;$total1 = array();$total2 = array();$total3 = array();$total4 = array();
                                                foreach($label as $l)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $l;?></td>
                                                        <td class=" font-weight-bold" ><?php echo $total1[] = $reading_start[$i];?></td>
                                                        <td class=" font-weight-bold" style="color:#53569C"><?php echo $total2[] = $reading_end[$i];?></td>
                                                        <td class=" font-weight-bold"><?php echo $total3[] = $reading_diff[$i];?></td>
                                                        <td class=" font-weight-bold"><?php echo $total4[] = $reading_diff_per[$i]; echo "%";?></td>
                                                    </tr>
                                                    <?php
                                                $i++;
                                                }
                                            ?>
                                        </tbody>
                                        <tfooter class="thead-light">
                                            <tr>
                                                <th scope="col">Total</th>
                                                <th scope="col"><?php if(!empty($total1)){ echo $a = round(array_sum($total1));}else{$a=0;}?></th>
                                                <th scope="col"><?php if(!empty($total2)){ echo $b = round(array_sum($total2));}else{$b=0;}?></th>
                                                <th scope="col"><?php if(!empty($total3)){ echo $d = round(array_sum($total3));}else{$d=0;}?></th>
                                                <th scope="col"><?php if($d>0){  echo round(($d/$a)*100); echo "%";} ?></th>
                                            </tr>
                                            <tr>
                                                <th scope="col">Avg</th>
                                                <th scope="col"><?php if(!empty($total1)){ echo round(array_sum($total1)/count($total1));}?></th>
                                                <th scope="col"><?php if(!empty($total2)){ echo round(array_sum($total2)/count($total2));}?></th>
                                                <th scope="col"><?php if(!empty($total3)){ echo round(array_sum($total3)/count($total3));}?></th>
                                                <th scope="col"></th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                                <div class="col-md-9">
                                    <div id="<?php echo $div_name;?>" style="height: 200px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
     }//function close


    public function get_dept_emp_detials($dept,$year,$month)
	{
        // $month=8;
        // $year=2023;
        // $dept = 6;

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $from_date = "$year-$month-01";
        $to_date = "$year-$month-$daysInMonth";

        $sql = "SELECT 
                    A.entry_date,
                    A.operator_id_1, A.effi1,
                    A.operator_id_2, A.effi2,
                    G.first_name as op1_name,
                    H.first_name as op2_name,
                    J.name as deptName
                FROM production_entry as A 
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                LEFT JOIN department as J ON J.department_id = I.dept 
                LEFT JOIN employee as G ON G.emp_code = A.operator_id_1
                LEFT JOIN employee as H ON H.emp_code = A.operator_id_2
                WHERE A.entry_date BETWEEN '$from_date' AND '$to_date'
                AND J.department_id = '$dept' ";
        $query = $this->db->query($sql);
        $entries = $query->result_array();
        //print_r($entries);
        $dept_name = $dept;
        if(!empty($entries))$dept_name = $entries[0]['deptName'];

        // Step 2: Process data per operator per date
        $eff_data = []; // [emp_code][date] = [effi_sum, count]
        $emp_names = [];

        foreach ($entries as $row) {
            $date = $row['entry_date'];

            // A shift
            if (!empty($row['operator_id_1']) && $row['effi1'] > 0) {
                $emp_code = $row['operator_id_1'];
                $eff_data[$emp_code][$date][] = $row['effi1'];
                $emp_names[$emp_code] = $row['op1_name'];
            }

            // B shift
            if (!empty($row['operator_id_2']) && $row['effi2'] > 0) {
                $emp_code = $row['operator_id_2'];
                $eff_data[$emp_code][$date][] = $row['effi2'];
                $emp_names[$emp_code] = $row['op2_name'];
            }
        }

            // Step 3: Build report rows
        $report = [];

            // Sample slab rates
            $rs_eff_75 = 10;
            $rs_eff_80 = 15;
            $rs_eff_85 = 20;
            $rs_eff_90 = 30;
            $rs_eff_100 = 35;

            $day_totals = array_fill(1, $daysInMonth, 0);
            $day_counts = array_fill(1, $daysInMonth, 0);

            $total_eff_75 = $total_eff_80 = $total_eff_85 = $total_eff_90 = $total_eff_100 = 0;
            $grand_total_incentive = 0;

            foreach ($eff_data as $emp_code => $daily_entries) {
                $row = ['name' => $emp_names[$emp_code]];
                $eff_sum = $eff_count = 0;
                $eff_75 = $eff_80 = $eff_85 = $eff_90 = $eff_100 = 0;

                for ($d = 1; $d <= $daysInMonth; $d++) {
                    $date_str = date("Y-m-d", strtotime("$year-$month-$d"));
                    if (isset($daily_entries[$date_str])) {
                        $avg = array_sum($daily_entries[$date_str]) / count($daily_entries[$date_str]);
                        $avg_rounded = round($avg);
                        $row[$d] = $avg_rounded . '%';

                        if ($avg_rounded > 0) {
                            $eff_sum += $avg_rounded;
                            $eff_count++;

                            $day_totals[$d] += $avg_rounded;
                            $day_counts[$d]++;

                            if ($avg_rounded >= 75 && $avg_rounded < 80) $eff_75++;
                            elseif ($avg_rounded >= 80 && $avg_rounded < 85) $eff_80++;
                            elseif ($avg_rounded >= 85 && $avg_rounded < 90) $eff_85++;
                            elseif ($avg_rounded >= 90 && $avg_rounded < 100) $eff_90++;
                            elseif ($avg_rounded >= 100) $eff_100++;
                        }
                    } else {
                        $row[$d] = '';
                    }
                }

                $row['no_of_day'] = $eff_count;
                $row['avg_num'] = ($eff_count > 0) ? round($eff_sum / $eff_count) : 0;
                $row['avg'] = ($eff_count > 0) ? $row['avg_num'] . '%' : '';

                $row['eff_75_rs'] = $eff_75 * $rs_eff_75;
                $row['eff_80_rs'] = $eff_80 * $rs_eff_80;
                $row['eff_85_rs'] = $eff_85 * $rs_eff_85;
                $row['eff_90_rs'] = $eff_90 * $rs_eff_90;
                $row['eff_100_rs'] = $eff_100 * $rs_eff_100;

                $row['total_incentive'] = $row['eff_75_rs'] + $row['eff_80_rs'] + $row['eff_85_rs'] + $row['eff_90_rs'] + $row['eff_100_rs'];

                $total_eff_75 += $row['eff_75_rs'];
                $total_eff_80 += $row['eff_80_rs'];
                $total_eff_85 += $row['eff_85_rs'];
                $total_eff_90 += $row['eff_90_rs'];
                $total_eff_100 += $row['eff_100_rs'];
                $grand_total_incentive += $row['total_incentive'];

                $report[] = $row;
            }

            usort($report, function($a, $b) {
                return $b['avg_num'] <=> $a['avg_num'];
            });

           
            $month_name = $this->Base->change_number_into_month($month);
            echo "<h5>$dept_name manpower eff(%) date wise of : $month_name-$year </h5><table border='1' cellpadding='5'>";
            echo "<tr><th>Sno</th>";
            echo "<th>Name</th>";
            for ($d = 1; $d <= $daysInMonth; $d++) {
                echo "<th>{$d} {$month_name}</th>";
            }
            echo "<th>No. of Days</th><th>Avg</th><th>75% Eff. Rs</th><th>80% Eff. Rs</th><th>85% Eff. Rs</th><th>90% Eff. Rs</th><th>100% Eff. Rs</th><th>Total Inc. Rs.</th></tr>";
            $k=1;
            foreach ($report as $r) {
                echo "<tr><td>{$k}</td>";
                echo "<td>{$r['name']}</td>";
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    //echo "<td>{$r[$d]}</td>";
                    ?><td class="<?php echo $this->Base->get_percent_color($r[$d]); ?>"><?php echo $r[$d]; ?></td><?php
                }
                echo "<td>" . ($r['no_of_day'] > 0 ? $r['no_of_day'] : '') . "</td>";
                echo "<td class='" . $this->Base->get_percent_color($r['avg_num']) . "'><strong>" . 
                    ($r['avg_num'] > 0 ? $r['avg'] : '') . 
                    "</strong></td>";
                echo "<td>" . ($r['eff_75_rs'] > 0 ? '₹' . $r['eff_75_rs'] : '') . "</td>";
                echo "<td>" . ($r['eff_80_rs'] > 0 ? '₹' . $r['eff_80_rs'] : '') . "</td>";
                echo "<td>" . ($r['eff_85_rs'] > 0 ? '₹' . $r['eff_85_rs'] : '') . "</td>";
                echo "<td>" . ($r['eff_90_rs'] > 0 ? '₹' . $r['eff_90_rs'] : '') . "</td>";
                echo "<td>" . ($r['eff_100_rs'] > 0 ? '₹' . $r['eff_100_rs'] : '') . "</td>";
                echo "<td>" . ($r['total_incentive'] > 0 ? '₹' . $r['total_incentive'] : '') . "</td>";
                echo "</tr>";


            $k++;
            }

            // Footer row: average per day and totals
            $overall_day_count = 0;
            $overall_avg_sum = 0;
            $overall_avg_count = 0;

            foreach ($report as $r) {
                $overall_day_count += $r['no_of_day'];
                if ($r['avg_num'] > 0) {
                    $overall_avg_sum += $r['avg_num'];
                    $overall_avg_count++;
                }
            }
            $avg_of_avg = ($overall_avg_count > 0) ? round($overall_avg_sum / $overall_avg_count) : 0;

            echo "<tr style='font-weight:bold; background-color:#f2f2f2;'><td>AVG/TOTAL</td><td></td>";
            for ($d = 1; $d <= $daysInMonth; $d++) {
                if ($day_counts[$d] > 0) {
                    $avg = round($day_totals[$d] / $day_counts[$d]);
                   // echo "<td>{$avg}%</td>";
                    ?><td class="<?php echo $this->Base->get_percent_color($avg); ?>"><?php echo $avg; ?>%</td><?php
                } else {
                    echo "<td></td>";
                }
            }
            echo "<td><strong></strong></td>"; // Not sure what this is for
            echo '<td class="' . $this->Base->get_percent_color($avg_of_avg) . '"><strong>' . $avg_of_avg . '%</strong></td>';
            echo "<td>" . ($total_eff_75 > 0 ? '₹' . $total_eff_75 : '') . "</td>";
            echo "<td>" . ($total_eff_80 > 0 ? '₹' . $total_eff_80 : '') . "</td>";
            echo "<td>" . ($total_eff_85 > 0 ? '₹' . $total_eff_85 : '') . "</td>";
            echo "<td>" . ($total_eff_90 > 0 ? '₹' . $total_eff_90 : '') . "</td>";
            echo "<td>" . ($total_eff_100 > 0 ? '₹' . $total_eff_100 : '') . "</td>";
            echo "<td>" . ($grand_total_incentive > 0 ? '₹' . $grand_total_incentive : '') . "</td>";
            echo "</tr>";
            echo "</table>";

        return $report;

    }//function close


    public function get_dept_machine_detials($dept,$year,$month)
	{
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $from_date = "$year-$month-01";
        $to_date = "$year-$month-$daysInMonth";

        $sql = "SELECT 
                    A.entry_date,
                    A.mc_id,
                    A.total_eff,
                    J.name as department_name,
                    I.name as machine_name
                   
                   
                FROM production_entry as A 
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                LEFT JOIN department as J ON J.department_id = I.dept 
              
                WHERE A.entry_date BETWEEN '$from_date' AND '$to_date'
                AND J.department_id = '$dept' ORDER By J.name,I.name ";
                 $query = $this->db->query($sql);
        $data = $query->result_array();
       // print_r($data);
        $dept_name = $dept;
        if(!empty($data))$dept_name = $data[0]['department_name'];
        echo "<br><br><br>";

  
        

        

        // Step 1: Organize data
        $machine_eff = [];

        foreach ($data as $entry) {
            $date = date('j', strtotime($entry['entry_date']));
            $machine = $entry['machine_name'];
            $eff = $entry['total_eff'];
            
            $machine_eff[$machine][$date][] = $eff;
        }

        // Step 2: Calculate average efficiency per machine per day
        $report = [];
        $day_totals = array_fill(1, $daysInMonth, ['sum' => 0, 'count' => 0]);
        $avg_col_sum = 0;
        $avg_col_count = 0;

        foreach ($machine_eff as $machine => $days) {
            $row = ['machine' => $machine];
            $total_eff = 0;
            $day_count = 0;

            for ($d = 1; $d <= $daysInMonth; $d++) {
                if (isset($days[$d])) {
                    $avg = round(array_sum($days[$d]) / count($days[$d]));
                    $row[$d] = $avg;
                    $total_eff += $avg;
                    $day_count++;

                    $day_totals[$d]['sum'] += $avg;
                    $day_totals[$d]['count']++;
                } else {
                    $row[$d] = '';
                }
            }

            $avg_eff = ($day_count > 0) ? round($total_eff / $day_count, 2) : '';
            $row['avg'] = $avg_eff;
            
            if ($avg_eff !== '') {
                $avg_col_sum += $avg_eff;
                $avg_col_count++;
            }

            $report[] = $row;
        }


         $month_name = $this->Base->change_number_into_month($month);
        echo "<h5>$dept_name, Machine eff(%) date wise of : $month_name-$year </h5>";
        ?>
         <!-- Step 3: Render HTML Table -->
        <table border='1' cellpadding='5' >
            <tr>
                <th>Machine Name</th>
                <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
                    <th><?= "{$d}-{$month}-{$year}" ?></th>
                <?php endfor; ?>
                <th>Avg</th>
            </tr>

            <?php foreach ($report as $row): ?>
                <tr>
                    <td><?= $row['machine'] ?></td>
                    <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
                        <td  class="<?php echo $this->Base->get_percent_color($row[$d]); ?>"><?= $row[$d] !== '' ? $row[$d] . '%' : '' ?></td>
                    <?php endfor; ?>
                    <td class="<?php echo $this->Base->get_percent_color($row['avg']); ?>"><?= $row['avg'] !== '' ? $row['avg'] . '%' : '' ?></td>
                </tr>
            <?php endforeach; ?>

            <!-- Final average row -->
            <tr>
                <td>Avg</td>
                <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
                    <?php
                    $avg = round($day_totals[$d]['count'] > 0) ? round($day_totals[$d]['sum'] / $day_totals[$d]['count']) : '';
                    ?>
                    <td class="<?php echo $this->Base->get_percent_color($avg); ?>"><?= $avg !== '' ? $avg . '%' : '' ?></td>
                <?php endfor; ?>
                <td class="<?php echo $this->Base->get_percent_color(round($avg_col_sum / $avg_col_count)); ?>"><?= $avg_col_count > 0 ? round($avg_col_sum / $avg_col_count) . '%' : '' ?></td>
            </tr>
        </table>




        
        <!-- Table 2: Summary of Avg Efficiency -->
         <br><br>
        <h2>Average Efficiency Per Machine</h2>
        <table border='1' cellpadding='5' >
            <tr>
                <th>Machine Name</th>
                <th>Average Efficiency (%)</th>
            </tr>
            <?php foreach ($report as $row): ?>
                <tr>
                    <td><?= $row['machine'] ?></td>
                    <td class="<?php echo $this->Base->get_percent_color(round($row['avg'])); ?>"><?= $row['avg'] !== '' ? round($row['avg']) . '%' : '' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
            
   

    }//function close


    

    


































    public function create_production_report_on_date_data_print($res2)
    {
        ?>
            <div class="table-responsive">
                <table border=1 style="width:100%; font-size: 13px;" id="printed_table">
                    <thead style="background-color:<?php //echo $this->Company->table_bg_color();?>; color:<?php //echo $this->Company->table_ft_color();?>;">
                        <tr>
                            <td colspan="8" class="dis_td "></td>
                            <td colspan="8" align="center" class="dis_td " style="background-color:#b8eff5">Shift (A)</td>
                            <td colspan="8"  align="center" class="dis_td " style="background-color:#f5b8d1">Shift (B)</td>
                            <td colspan="4"  align="center" class="dis_td ">Total</td>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Dept</th>
                            <th>M/C</th>
                            <th>Speed</th>
                            <?php // <th>Base</th> ?>
                            <th>In. Size</th>
                            <th>Grade</th>
                            <th>Product Type</th>
                            <?php // <th>Finish</th> ?>
                            <th>F.Size</th>
                           
                            
                            <th class="">Coils</th>
                            <th class="">Wt.(kg)</th>
                            <th class="">Run. Hrs.</th>
                            <th class="">Eff</th>
                            <th class="">OP Name</th>
                            <th class="">OP Code</th>
                            <th class="">Brk.Down</th>
                            <th class="">Brk. Hrs.</th>
                            
                            
                           
                            <th class="">Coils</th>
                            <th class="">Wt.(kg)</th>
                            <th class="">Run. Hrs.</th>
                            <th class="">Eff</th>
                            <th class="">OP Name</th>
                            <th class="">OP Code</th>
                            <th class="">Brk.Down</th>
                            <th class="">Brk. Hrs.</th>
                           
                           
                            <th>Total Coils</th>
                            <th>Total Wt. (kg)</th>
                            <th>Unit</th>
                            <th>Eff</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i=1;
                        foreach($res2 as $r)
                        {
                            //if(isset($r['in_product_name']))echo $r['in_product_name'];
                            //if(isset($r['out_product_name']))echo $r['out_product_name'];
                            //if(isset($r['op_name1'])){echo $r['op_name1'];}else{echo $r['operator_id_1'];}
                            //if(isset($r['op_name2'])){echo $r['op_name2'];}else{echo $r['operator_id_2'];}
                            ?>
                            <tr>
                                <td><?php echo $i;?>.</td>
                                <td><?php if(isset($r['dept_name']))echo $r['dept_name'];?></td>
                                <td><?php if(isset($r['mc_name']))echo $r['mc_name'];?></td>
                                <td><?php if(isset($r['mc_speed']))echo $r['mc_speed'];?></td>
                                <td><?php if(isset($r['in_size']))echo $r['in_size'];?></td>
                                <td><?php if(isset($r['grade_name']))echo $r['grade_name'];?></td>
                                <td><?php if(isset($r['product_type_name']))echo $r['product_type_name'];?></td>
                                <td><?php if(isset($r['out_size']))echo $r['out_size'];?></td>
                                
                                
                               
                               
                                <?php 
                                    if($r['no_of_spool1'] > 0)
                                    {
                                        ?>
                                             <td><?php if(isset($r['no_of_spool1']))echo $t1[] = $r['no_of_spool1'];?></td>
                                            <td style="font-weight:bold"><?php if(isset($r['qty1']))echo $t2[] = $r['qty1'];?></td>
                                            <td><?php if(isset($r['running_hours_1']))echo $t14[] = $r['running_hours_1'];?></td>
                                            <td><?php if(isset($r['effi1']))echo $t3[] = $r['effi1'];echo "%";?></td>
                                            <td><?php if(isset($r['op_name1']))echo $r['op_name1'];?></td>
                                            <td><?php if(isset($r['operator_id_1']))echo $r['operator_id_1'];?></td>
                                            <td><?php if(isset($r['down_type1']))echo $r['down_type1'];?></td>
                                            <td><?php if(isset($r['down_total_time1']))echo $t4[] = $r['down_total_time1'];?></td>
                                            
                                        <?php 
                                    }
                                    else{
                                        ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php
                                    }
                                ?>


                                    <?php 
                                    if($r['no_of_spool2'] > 0)
                                    {
                                        ?>
                                            <td><?php if(isset($r['no_of_spool2']))echo $t5[] = $r['no_of_spool2'];?></td>
                                            <td style="font-weight:bold"><?php if(isset($r['qty2']))echo $t6[] = $r['qty2'];?></td>
                                            <td><?php if(isset($r['running_hours_2']))echo $t16[] = $r['running_hours_2'];?></td>
                                            <td><?php if(isset($r['effi2']))echo $t7[] = $r['effi2'];echo "%";?></td>
                                            <td><?php if(isset($r['op_name2']))echo $r['op_name2'];?></td>
                                            <td><?php if(isset($r['operator_id_2']))echo $r['operator_id_2'];?></td>
                                            <td><?php if(isset($r['down_type2']))echo $r['down_type2'];?></td>
                                            <td><?php if(isset($r['down_total_time2']))echo $t8[] = $r['down_total_time2'];?></td>
                                            
                                        <?php 
                                    }
                                    else{
                                        ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <?php
                                    }
                                ?>
                               
                                
                                <td><?php if(isset($r['total_spool']))echo $t9[] = $r['total_spool'];?></td>
                                <td style="font-weight:bold"><?php if(isset($r['total_qty']))echo $t10[] = $r['total_qty'];?></td>
                                <td><?php if(isset($r['unit_name']))echo $r['unit_name'];?></td>
                                <td><?php if(isset($r['total_eff']))echo $t11[] = $r['total_eff'];echo "%";?></td>
                                
                            </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                        <tr>
                        <td>#</td>
                            <td colspan="7"></td>
                            <td class=""><?php if(!empty($t1))echo $a1 = array_sum($t1);?> coil</td>
                            <td class="" style="font-weight:bold"><?php if(!empty($t2))echo $a2 = array_sum($t2);?></td>
                            <td class=""><?php if(!empty($t14))echo $a14 = array_sum($t14);?> </td>
                            <td class=""><?php if(!empty($t3)){$a3 = array_sum($t3); if($a3>0){  echo round($a3/count($t3));echo "%";} }?></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""><?php if(!empty($t4))echo $a4 = array_sum($t4);?> Hours</td>
                            
                          
                            <td class=""><?php if(!empty($t5))echo $a5 = array_sum($t5);?> coil</td>
                            <td class="" style="font-weight:bold"><?php if(!empty($t6))echo $a6 = array_sum($t6);?></td>
                            <td class=""><?php if(!empty($t16))echo $a16 = array_sum($t16);?> </td>
                            <td class=""><?php if(!empty($t7)){$a7 = array_sum($t7); if($a7>0){  echo round($a7/count($t7));echo "%";} }?></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""></td>
                            <td class=""><?php if(!empty($t8))echo $a8 = array_sum($t8);?> Hours</td>
                            
                          

                            <td><?php if(!empty($t9))echo $a9 = array_sum($t9);?></td>
                            <td style="font-weight:bold"><?php if(!empty($t10))echo $a10 = array_sum($t10);?></td>
                            <td></td>
                            <td><?php if(!empty($t11)){$a11 = array_sum($t11); if($a11>0){  echo round($a11/count($t11));echo "%";} }?></td>
                        </tr>            
                    </tbody>
                </table>
            </div>
        <?php
    }//function close





     //-----------------------------------------------------------report
    // full report of production date wise
    public function create_production_report_on_date($search_date)
    {
        $where=" and A.entry_date = '$search_date'  ORDER by J.name ,I.order_list ASC  ";
        $res2 = $this->Productionmodel->get_all_production_with_search($where);
        $print_date = $this->Base->change_date_dmy($search_date);
       
        ?>
            <h4>Date : <?php echo $print_date;?></h4>
            <?php  $this->create_production_report_on_date_data_print($res2);?>
            <br>
            
            <div class="table-responsive">            
                <?php 
                    $dept_list = $this->Base->get_all_production_dept();
                    foreach($dept_list as $d)
                    {
                        $dept_id = $d['department_id'];
                        $dept_name = $d['name'];
                        $res3 = $this->Productionmodel->get_production_product_type_and_product_wise($search_date,$search_date,$dept_id);
                        ?>
                            <table border=1 style="width:30%; float:left; margin:20px;" >
                                <thead style="background-color:<?php //echo $this->Company->table_bg_color();?>; color:<?php //echo $this->Company->table_ft_color();?>;">
                                    <tr style="font-weight:bold">
                                        <td align="center" colspan="4"><?php echo $dept_name;?></td>
                                    </tr>
                                    <tr style="font-weight:bold">
                                        <td>Product Type</td>
                                        <td>Size</td>
                                        <td>Total Coil</td>
                                        <td>Qty</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $w1 = array();$w2 = array();
                                        foreach($res3 as $s)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $s['product_type_name'];?></td>
                                                <td><?php echo $s['out_size'];?></td>
                                                <td><?php echo $w1[] = $s['coil'];?></td>
                                                <td><?php echo $w2[] =$s['qty'];?></td>
                                            </tr>
                                            <?php
                                        }//foreach
                                    ?>
                                    <tr style="font-weight:bold">
                                        <td colspan="2">Total</td>
                                        <td><?php if(!empty($w1))echo $w1 = array_sum($w1);?></td>
                                        <td><?php if(!empty($w2))echo $w2 = array_sum($w2);?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php
                    }//foreach
                ?>
                
            </div>


            <div class="table-responsive">            
                <?php 
                    $this->Productionmodel->get_all_emp_ef_between_date($search_date,$search_date);
                    $this->Productionmodel->get_all_machine_ef_between_date($search_date,$search_date);
                ?>
            </div>

        <?php
    }//function close



    //----------------------------production-all report 
	public function get_all_production_report($dept,$year,$month)
	{
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        
        if($dept == 5){ $col =1;}//wet
        elseif($dept == 6){ $col =3;}//dry
        elseif($dept == 28){ $col =2;}//mini
        else{$col =1;}
        $pt = $this->Base->get_all_product_type_col_wise($col);
        
        //all machine list
		$mc = $this->Machinemodel->fun_get_machine_form_dept_id($dept);
        $days = $this->Base->get_day_no_on_month($month,$year);//all date form 1 to 31
        ?>
			<h2 align="left"><?php echo $dept_name = $this->Base->get_name_form_dept_id($dept);?> Production Report (<?php echo $month.' / '.$year?>)</h2>
			<table border=1 id="printed_table">
				<tr>
					<th>Date</th>
					<?php 
                        //machine list
						foreach($mc as $m)
						{
							?><th><?php echo $m['name'];?></th><?php 
						}
					?>
					<th>Total</th>
                    <?php 
                        //product type
						foreach($pt as $p)
						{
							?><th><?php echo $p['name'];?></th><?php 
						}
					?>
                    <th>Total</th>
                </tr>
				<?php 
                foreach($days as $d)
                {
                    ?>
                        <tr>
                            <td><?php echo $d;?></td>
                            <?php 
                                $machine_total_qty = array();
                                foreach($mc as $m)
                                {
                                    $mc_id =  $m['mc_id'];
                                    $current_date = $this->Base->change_date_ymd("$d-$month-$year");
                                    $pro = $this->get_date_wise_machine_details($current_date,$current_date,$mc_id);
                                    if(!empty($pro[0]['qty'])){$today_qty = (int)$pro[0]['qty']; $machine_total_qty[]=$today_qty;}else{$today_qty = '';}
                                    ?><td ><?php echo $today_qty;?></td><?php 
                                }
                            ?>
                            <th><?php echo $machine_total_qty2 =  round(array_sum($machine_total_qty));?></th>
                            <?php 
                                //product type
                                $product_type_qty = array();
                                foreach($pt as $p)
                                {
                                    $pt_name = $p['name'];
                                    ?>
                                        <td >
                                            <?php 
                                            echo $product_type_qty[] =  $this->get_date_wise_pro_details_with_product_type($current_date,$current_date,$dept,$col,$pt_name);
                                            ?>
                                        </td>
                                    <?php 
                                }
                            ?>
                            <th><?php echo $product_type_qty2 =  round(array_sum($product_type_qty));?></th>
                        </tr>
                    <?php
                }//days
				?>
                <tr>
                    <th>Total</th>
                    <?php 
                        $month_total_qty = array();
                        foreach($mc as $m)
                        {
                            $mc_id =  $m['mc_id'];
                            $pro = $this->get_date_wise_machine_details($from_date,$to_date,$mc_id);
                            if(!empty($pro[0]['qty'])){$today_qty = (int)$pro[0]['qty']; $month_total_qty[]=$today_qty;}else{$today_qty = '';}
                            ?><th ><?php echo $today_qty;?></th><?php 
                        }
                    ?>
                    <th ><?php echo $month_total_qty2 =  round(array_sum($month_total_qty));?></th>
                    <?php 
                    //product type
                    $product_type_qty = array();
                    foreach($pt as $p)
                    {
                        $pt_name = $p['name'];
                        ?>
                            <th >
                                <?php 
                                echo $product_type_qty[] =  $this->get_date_wise_pro_details_with_product_type($from_date,$to_date,$dept,$col,$pt_name);
                                ?>
                            </th>
                        <?php 
                    }
                ?>
                <th ><?php echo $product_type_qty2 =  round(array_sum($product_type_qty));?></th>
            </tr>

			</table>
		<?php 
    }//function close




    public function get_all_production_report2($dept,$year,$month)
	{
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $label = $this->Base->get_day_no_on_month($month,$year);
        
        if($dept == 5){ $col =1;}//wet
        elseif($dept == 6){ $col =3;}//dry
        elseif($dept == 28){ $col =2;}//mini
        else{$col =1;}
        $pt = $this->Base->get_all_product_type_col_wise($col);
        
        //all machine list
		$mc = $this->Machinemodel->fun_get_machine_form_dept_id($dept);
        $days = $this->Base->get_day_no_on_month($month,$year);//all date form 1 to 31
        ?>
            <h2 align="left"><?php echo $dept_name = $this->Base->get_name_form_dept_id($dept);?> Production Report (<?php echo $month.' / '.$year?>)</h2>
			<table border=1 id="printed_table" width="100%">
				<tr>
					<th>#</th>
					<th>Machine</th>
					<?php 
						foreach($label as $l)
						{
							?><th><?php echo $l;?></th><?php 
						}
					?>
					<th>Total Pro (wt.kg)</th>
                    <th>OP Net Salary</th>
                    <th>Helper Net Salary</th>
                    <th>Total Net Salary (Rs)</th>
                    <?php /*
					<th>OP Gross Salary</th>
                    <th>OP Net Salary</th>
                    <th>Helper Gross Salary</th>
                    <th>Helper Net Salary</th>
                    <th>Total Gross Salary</th>
                    <th>Total Net Salary (Rs)</th>
                    */?>
                    <th>Total Machine Running hours.</th>
                    <th>Meter Reading (KWH)</th>
                    <th>(All_Reading / All_Pro) X pro</th>
                    <th>Brk.Dwn. EBD</th>
                    <th>Brk.Dwn.Min EBD</th>
                    <th>Brk.Dwn. MBD</th>
                    <th>Brk.Dwn.Min MBD</th>
                    <th>Total Issue slip From Store</th>
				</tr>
            
                <?php
                $g_total_qty = array();
                $g_op_net_salary = array();
                $g_hp_net_salary = array();
                $g_net_salary = array();
                $g_ebd = array();
                $g_mbd = array();
                $i=1; 
                //machine list
                foreach($mc as $m)
                {
                    $mc_id =  $m['mc_id'];
                    //$salary = $this->get_emp_list_in_given_date_mc($mc_id,$from_date,$to_date,'');

                    //machine reading
                    $res3 = $this->Productionmodel->get_date_wise_machine_details($from_date,$to_date,$m['mc_id']);
                    if(!empty($res3)){
                        $mc_running_hrs = round($res3[0]['mc_running_hours_a']+$res3[0]['mc_running_hours_b']);
                    }else{ $mc_running_hrs = 0;}

                    $mtr_reading = $this->Maintenancemodel->get_reading_full_details2($from_date,$to_date,$dept,$m['mc_id']);
                    
                   
                    $brk_down_nos_ebd = $this->Maintenancemodel->get_breakdown_nos_mc_id($mc_id,'EBD',$from_date,$to_date); 
                    $brk_down_time_ebd = $this->Maintenancemodel->get_breakdown_nos_mc_id_time_taken($mc_id,'EBD',$from_date,$to_date);
                    $brk_down_nos_mbd = $this->Maintenancemodel->get_breakdown_nos_mc_id($mc_id,'MBD',$from_date,$to_date); 
                    $brk_down_time_mbd = $this->Maintenancemodel->get_breakdown_nos_mc_id_time_taken($mc_id,'MBD',$from_date,$to_date);
                    
                    $store = $this->Storemodel->issue_list_to_machine($mc_id,$from_date,$to_date);
                    ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $m['name'];?></td>
                            <?php 
                                //date
                                $machine_total_qty = array();
                                $salary_per_day_op_list = array();
                                $salary_per_day_hp_list = array();
                                foreach($label as $l)
                                {
                                    $current_date = $this->Base->change_date_ymd("$l-$month-$year");
                                    $pro = $this->get_date_wise_machine_details($current_date,$current_date,$mc_id);
                                   
                                    if(!empty($pro[0]['qty'])){$today_qty = (int)$pro[0]['qty']; $machine_total_qty[]=$today_qty;}else{$today_qty = '';}
                                    //emp salary per day
                                    if($today_qty>0)
                                    {
                                        /*
                                        //old
                                        $salary_per_day_op_list[] =  $this->get_emp_list_in_given_date_mc2($mc_id,$current_date,$current_date,'OP',$dept);//salary
                                        $salary_per_day_hp_list[] =   $this->get_emp_list_in_given_date_mc2($mc_id,$current_date,$current_date,'HP',$dept);//salary
                                        */
                                        //new
                                        //salary
                                        $current_date = $this->Base->change_date_ymd("$l-$month-$year");
                                        $op_hel_list =  $this->get_emp_list_in_given_date_mc2($mc_id,$current_date,'OP',$dept,'Y');//salary
                                        //print_r($op_hel_list);
                                        $all_op_string = implode(',',$op_hel_list['all_op']);
                                        $all_hp_string = implode(',',$op_hel_list['all_hp']);
                                        $salary_per_day_op_list[] = $this->Hrmodel->get_op_hp_salary_on_date_wise_via_machine($op_hel_list['all_op'],$op_hel_list['other_op_hp'],$current_date,'N');
                                        $salary_per_day_hp_list[] = $this->Hrmodel->get_op_hp_salary_on_date_wise_via_machine($op_hel_list['all_hp'],$op_hel_list['other_op_hp'],$current_date,'N');
                                    }
                                    //showing production date wise
                                    ?><td ><?php echo $today_qty;?></td><?php 
                                }//foreach
                            ?>
                            <td align="right"><?php echo $machine_total_qty2 =  round(array_sum($machine_total_qty)); $g_total_qty[] = $machine_total_qty2; ?></td>
                            <td align="right"><?php echo $op_salary_total = round(array_sum($salary_per_day_op_list)); $g_op_net_salary[] = $op_salary_total; ?> </td>
                            <td align="right"><?php echo $hp_salary_total = round(array_sum($salary_per_day_hp_list)); $g_hp_net_salary[] = $hp_salary_total; ?> </td>
                            <td align="right"><?php echo  $g_net_salary[] = round($op_salary_total+$hp_salary_total);?> </td>
                            <?php /*
                            <td><?php echo $salary['op_gross_salary'];?></td>
                            <td><?php echo $salary['op_net_pay'];?></td>
                            <td><?php echo $salary['hp_gross_salary'];?></td>
                            <td><?php echo $salary['hp_net_pay'];?></td>
                            <td><?php echo round($salary['op_gross_salary']+$salary['hp_gross_salary']);?></td>
                            <td><?php echo round($salary['op_net_pay']+$salary['hp_net_pay']);?></td> 
                            */?>
                            <td align="right"><?php echo $mc_running_hrs;?></td>
                            <td align="right"><?php echo $mtr_reading;?></td>
                            <td align="right">
                                <?php 
                                    $all_mtr_reading3 = $this->Maintenancemodel->get_reading_full_details3($from_date,$to_date,$dept,$m['mc_id']);
                                    $all_mc_pro = $this->get_date_wise_machine_details2($from_date,$to_date,$dept,$m['mc_id']);
                                    if($all_mc_pro > 0 and $all_mtr_reading3  >0 and $machine_total_qty2 > 0)
                                    {
                                        echo round(($all_mtr_reading3/$all_mc_pro)*$machine_total_qty2);
                                    }
                                ?>
                            </td>
                            
                            <td align="right"><?php if($brk_down_nos_ebd>0)echo $g_ebd[] = $brk_down_nos_ebd;?></td>
                            <td align="right"><?php echo  $brk_down_time_ebd; ?></td>
                            <td align="right"><?php if($brk_down_nos_mbd>0)echo $g_mbd[] = $brk_down_nos_mbd;?></td>
                            <td align="right"><?php echo $brk_down_time_mbd;?></td>
                            <td align="right"><?php if($store[0]['total_slip']>0)echo $store[0]['total_slip'];?></td>
                        </tr>
                    <?php 
                $i++;
                }
				?>
                <tr style="font-weight:bold">
                    <td></td>
                    <td>Total</td>
                    <?php 
						foreach($label as $l)
						{
							?><td></td><?php 
						}
					?>
                    <td align="right"><?php if(!empty($g_total_qty)){ echo round(array_sum($g_total_qty)); }?></td>
                    <td align="right"><?php if(!empty($g_op_net_salary)){ echo round(array_sum($g_op_net_salary)); }?></td>
                    <td align="right"><?php if(!empty($g_hp_net_salary)){ echo round(array_sum($g_hp_net_salary)); }?></td>
                    <td align="right"><?php if(!empty($g_net_salary)){ echo round(array_sum($g_net_salary)); }?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><?php if(!empty($g_ebd)){ echo round(array_sum($g_ebd)); }?></td>
                    <td></td>
                    <td align="right"><?php if(!empty($g_mbd)){ echo round(array_sum($g_mbd)); }?></td>
                    <td></td>
                    <td></td>
				</tr>

			</table>
		<?php 
    }//function close



    public function get_all_production_with_man_power_cost($dept,$year,$month,$date,$show_details)
	{
        if($date != 'ALL')
        {
            $from_date = date("$year-$month-$date");
            $to_date = date("$year-$month-$date");
        }
        else
        {
            $from_date = date("$year-$month-$d");
            $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        }
       
        $label = $this->Base->get_day_no_on_month($month,$year);
        
        if($dept == 5){ $col =1;}//wet
        elseif($dept == 6){ $col =3;}//dry
        elseif($dept == 28){ $col =2;}//mini
        else{$col =1;}
        $pt = $this->Base->get_all_product_type_col_wise($col);
        
        //all machine list
		$mc = $this->Machinemodel->fun_get_machine_form_dept_id($dept);
        //$days = $this->Base->get_day_no_on_month($month,$year);//all date form 1 to 31
        ?>
            <h2 align="left"><?php echo $dept_name = $this->Base->get_name_form_dept_id($dept);?> Production Report (<?php echo $month.' / '.$year?>)</h2>
			<table border=1 id="printed_table" width="100%">
				<tr>
					<th>#</th>
					<th>Machine</th>
					
					<th>Total OP</th>
                    <th>OP Net Salary</th>
                    <th>Helper Net Salary</th>
                    <th>Total Net Salary (Rs)</th>
                    
                    </tr>
            
                <?php
                $g_total_qty = array();
                $g_op_net_salary = array();
                $g_hp_net_salary = array();
                $g_net_salary = array();
                $g_ebd = array();
                $g_mbd = array();
                $i=1; 
                //machine list
                foreach($mc as $m)
                {
                    $mc_id =  $m['mc_id'];
                   
                    //salary
                    $current_date = $this->Base->change_date_ymd("$date-$month-$year");
                    $op_hel_list =  $this->get_emp_list_in_given_date_mc2($mc_id,$current_date,'OP',$dept,'Y');//salary
                    //print_r($op_hel_list);
                    $all_op_string = implode(',',$op_hel_list['all_op']);
                    $all_hp_string = implode(',',$op_hel_list['all_hp']);
                    $op_salary_total = $this->Hrmodel->get_op_hp_salary_on_date_wise_via_machine($op_hel_list['all_op'],$op_hel_list['other_op_hp'],$current_date,$show_details);
                    $hp_salary_total = $this->Hrmodel->get_op_hp_salary_on_date_wise_via_machine($op_hel_list['all_hp'],$op_hel_list['other_op_hp'],$current_date,$show_details);

                    ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $m['name'];?></td>
                            <td align="right">
                                    <?php 
                                        echo $all_op_string;
                                        echo "<br>";
                                        echo $all_hp_string;
                                        echo "<br>";
                                    ?>
                            </td>
                            <td align="right"><?php  echo  $g_op_net_salary[] = $op_salary_total; ?> </td>
                            <td align="right"><?php  echo $g_hp_net_salary[] = $hp_salary_total; ?> </td>
                            <td align="right"><?php echo  $g_net_salary[] = round($op_salary_total+$hp_salary_total);?> </td>
                            
                        </tr>
                    <?php 
                $i++;
                }
				?>
                <tr style="font-weight:bold">
                    <td></td>
                    <td>Total</td>
                    <td align="right"><?php if(!empty($g_total_qty)){ echo round(array_sum($g_total_qty)); }?></td>
                    <td align="right"><?php if(!empty($g_op_net_salary)){ echo round(array_sum($g_op_net_salary)); }?></td>
                    <td align="right"><?php if(!empty($g_hp_net_salary)){ echo round(array_sum($g_hp_net_salary)); }?></td>
                    <td align="right"><?php if(!empty($g_net_salary)){ echo round(array_sum($g_net_salary)); }?></td>
                   
				</tr>

			</table>
		<?php 
    }//function close


    public function get_all_production_with_man_power_cost_monthly($dept,$year,$month,$date,$show_details)
	{
        if($date != 'ALL')
        {
            $from_date = date("$year-$month-$date");
            $to_date = date("$year-$month-$date");
        }
        else
        {
            $from_date = date("$year-$month-01");
            $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        }
       
        $label = $this->Base->get_day_no_on_month($month,$year);
        
        if($dept == 5){ $col =1;}//wet
        elseif($dept == 6){ $col =3;}//dry
        elseif($dept == 28){ $col =2;}//mini
        else{$col =1;}
        $pt = $this->Base->get_all_product_type_col_wise($col);
        
        //all machine list
		$mc = $this->Machinemodel->fun_get_machine_form_dept_id($dept);
        //$days = $this->Base->get_day_no_on_month($month,$year);//all date form 1 to 31
        ?>
            <h2 align="left"><?php echo $dept_name = $this->Base->get_name_form_dept_id($dept);?> Machine wise Salary Report (<?php echo $month.' / '.$year?>)</h2>
			<table border=1 id="printed_table" width="100%">
				<tr>
					<th>#</th>
					<th>Machine</th>
                    <?php 
						foreach($label as $l)
						{
							?><td><?php echo $l;?></td><?php 
						}
					?>
					<th>Total</th>
                </tr>
            
                <?php
                $g_net_salary_all = array();
                $i=1; 
                //machine list
                foreach($mc as $m)
                {
                    $mc_id =  $m['mc_id'];
                    ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $m['name'];?></td>
                            <?php
                                $g_net_salary = array();
                                foreach($label as $l)
                                {
                                    //salary
                                    $current_date = $this->Base->change_date_ymd("$l-$month-$year");
                                    $op_hel_list =  $this->get_emp_list_in_given_date_mc2($mc_id,$current_date,'OP',$dept,'Y');//salary
                                    //print_r($op_hel_list);
                                    $all_op_string = implode(',',$op_hel_list['all_op']);
                                    $all_hp_string = implode(',',$op_hel_list['all_hp']);
                                    $op_salary_total = $this->Hrmodel->get_op_hp_salary_on_date_wise_via_machine($op_hel_list['all_op'],$op_hel_list['other_op_hp'],$current_date,$show_details);
                                    $hp_salary_total = $this->Hrmodel->get_op_hp_salary_on_date_wise_via_machine($op_hel_list['all_hp'],$op_hel_list['other_op_hp'],$current_date,$show_details);
                                    $g_op_net_salary[] = $op_salary_total;
                                    $g_hp_net_salary[] = $hp_salary_total;
                                    $g_net_salary_one_day = round($op_salary_total+$hp_salary_total);
                                    ?>
                                    <td align="right"><?php  echo  $g_net_salary[] = $g_net_salary_one_day; ?> </td>
                                    <?php
                                }//foreach 
                            ?>
                            <td align="right"><?php if(!empty($g_net_salary)){ echo $g_net_salary_all[] = round(array_sum($g_net_salary)); }?></td>
                        </tr>
                    <?php 
                $i++;
                }
				?>
                <tr style="font-weight:bold">
                    <td></td>
                    <td>Total</td>
                    <?php 
						foreach($label as $l)
						{
							?><td><?php //echo $l;?></td><?php 
						}
					?>
                    <td align="right"><?php if(!empty($g_net_salary_all)){ echo round(array_sum($g_net_salary_all)); }?></td>
                </tr>

			</table>
		<?php 
    }//function close





    























    //-----------------------------------------------------------------SCRAP
    //get scrap details form id
	public function get_scrap_data_with_id($id)
	{
        $sql = "SELECT * FROM scrap_entry where scrap_id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //production search 
    public function get_all_scrap_with_search($search)
    {
        $sql="  SELECT 
                A.*,
                D.name as grade_name,
                F.name as unit_name1,
                G.name as unit_name2,
                I.name as mc_name,
                J.name as dept_name
                
                FROM scrap_entry as A 
                LEFT JOIN product_grade as D ON D.id = A.grade 
                LEFT JOIN unit as F ON F.unit_id = A.unit1
                LEFT JOIN unit as G ON G.unit_id = A.unit2
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_no
                LEFT JOIN department as J ON J.department_id = A.dept 
                WHERE 1=1  $search 
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close




     //-----------------------------------------------------------------Short pcs
    //get scrap details form id
	public function get_short_data_with_id($id)
	{
        $sql = "SELECT * FROM short_entry where id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //production search 
    public function get_all_short_with_search($search)
    {
        $sql="  SELECT 
                A.*,
                D.name as grade_name,
                F.name as unit_name1,
                G.name as unit_name2,
                I.name as mc_name,
                J.name as dept_name
                
                FROM short_entry as A 
                LEFT JOIN product_grade as D ON D.id = A.grade 
                LEFT JOIN unit as F ON F.unit_id = A.unit1
                LEFT JOIN unit as G ON G.unit_id = A.unit2
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_no
                LEFT JOIN department as J ON J.department_id = A.dept 
                WHERE 1=1  $search 
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //--------------------get eff of machine
	public function get_all_machine_ef_between_date($from_date,$to_date)
	{
         $sql = "  SELECT A.mc_id, I.name as mc_name,
                                ROUND(AVG(total_eff), 2) AS avg_total_eff
                            FROM production_entry AS A
                            LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                            WHERE A.entry_date BETWEEN '$from_date' AND '$to_date'
                            AND total_eff > 0
                            GROUP BY mc_id
                            ORDER BY avg_total_eff DESC
                        ";
                    $query = $this->db->query($sql);
        $mac =  $query->result_array();
            ?>
                <table border=1 style="width:30%; float:left; margin:20px;" >
                    <thead style="background-color:<?php //echo $this->Company->table_bg_color();?>; color:<?php //echo $this->Company->table_ft_color();?>;">
                        <tr style="font-weight:bold">
                            <td align="center" colspan="4">Machine Wise Eff%</td>
                        </tr>
                        <tr style="font-weight:bold">
                            <td>Machine Name</td>
                            <td>Eff%</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $w1 = array();
                            foreach($mac as $s)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $s['mc_name'];?></td>
                                    <td><?php echo round($s['avg_total_eff']);?> %</td>
                                </tr>
                                <?php
                            }//foreach
                        ?>
                        
                    </tbody>
                </table>
            <?php
    }//function close
   
      

    //--------------------get eff of emp via emp code
	public function get_all_emp_ef_between_date($from_date,$to_date)
	{
        $sql = "  SELECT operator_id, op_name, 
                                ROUND(AVG(efficiency), 2) AS avg_efficiency
                            FROM (
                                SELECT A.operator_id_1 AS operator_id,
                                    CONCAT(G.first_name, ' ', G.last_name) AS op_name,
                                    effi1 AS efficiency
                                FROM production_entry AS A
                                LEFT JOIN employee AS G ON G.emp_code = A.operator_id_1
                                WHERE effi1 > 0 AND A.entry_date BETWEEN '$from_date' AND '$to_date'

                                UNION ALL

                                SELECT A.operator_id_2 AS operator_id,
                                    CONCAT(H.first_name, ' ', H.last_name) AS op_name,
                                    effi2 AS efficiency
                                FROM production_entry AS A
                                LEFT JOIN employee AS H ON H.emp_code = A.operator_id_2
                                WHERE effi2 > 0 AND A.entry_date BETWEEN '$from_date' AND '$to_date'
                            ) AS combined
                            GROUP BY operator_id, op_name
                            ORDER BY avg_efficiency DESC
                        ";
        $query = $this->db->query($sql);
        $oper =  $query->result_array();
            ?>
                <table border=1 style="width:30%; float:left; margin:20px;" >
                    <thead style="background-color:<?php //echo $this->Company->table_bg_color();?>; color:<?php //echo $this->Company->table_ft_color();?>;">
                        <tr style="font-weight:bold">
                            <td align="center" colspan="4">OP Wise Eff%</td>
                        </tr>
                        <tr style="font-weight:bold">
                            <td>OP Name</td>
                            <td>Eff%</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $w1 = array();
                            foreach($oper as $s)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $s['op_name'];?></td>
                                    <td><?php echo round($s['avg_efficiency']);?> %</td>
                                </tr>
                                <?php
                            }//foreach
                        ?>
                        
                    </tbody>
                </table>
            <?php
    }//function close
    
    
   
    
	//--------------------get eff of emp via emp code
	public function get_emp_ef_till_date($emp_code,$from_date,$to_date)
	{
		
		//$from_date = date('2020-01-01');
		//$to_date = date('Y-d-m');
		
		$sql = "SELECT avg(A.effi1) as effi1
                    FROM production_entry as A 
                    where A.entry_date between '$from_date' and '$to_date' and A.operator_id_1='$emp_code' and A.effi1!=''
                    ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ $effi1 = $res[0]['effi1'];}else{$effi1 =0;}
        
        
        $sql = "SELECT avg(A.effi2) as effi2
                    FROM production_entry as A 
                    where A.entry_date between '$from_date' and '$to_date'  and A.operator_id_2 = '$emp_code' and A.effi2!=''
                    ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ $effi2 = $res[0]['effi2'];}else{$effi2 = 0;}
        
        if($effi1>0 and $effi2>0)
        {
            $total_eff = round(($effi1+$effi2)/2);
        }
        elseif($effi1>0 and $effi2 < 1)
        {
            $total_eff = round($effi1);
        }
        elseif($effi1<1 and $effi2>0)
        {
            $total_eff = round($effi2);
        }
        else
        {
            $total_eff = 0;
        }
        
        return $total_eff;
	}//function close

    public function get_emp_ef_year_month_wise($emp_code,$year)
	{
        $list = $this->Base->get_all_month_list_from_given_finc_year($year); 
        $month_list = $list[0];
        $year_list = $list[1];
        $c=0;
        $efficiency_percent_list = array();
        ?>
        <table class="table table-hover table-bordered border-primary table-sm">
            <tr>
                <th><?php echo $year;?></th>
                <th>Efficiency %</th>
            </tr>
            <?php
           
            foreach($month_list as $m)
            {
                    $m = (int)$m;
                    $y = $year_list[$c];

                    $from_date = date("$y-$m-01");
                    $to_date = date("$y-$m-t");
                ?>
                    <tr>
                        <td><?php echo $this->Base->change_date_into_month_name($from_date);?></td>
                        <td><?php echo $efficiency_percent_list[] = $this->Productionmodel->get_emp_ef_till_date($emp_code,$from_date,$to_date);?></td>
                    </tr>
                <?php
            $c++;
            }
            ?>
            <tr style="font-weight: bold;">
                <td>Average </td>
                <td>
                    <?php 
                    $new_avg_list = $this->Base->get_array_filter_remove_zero_or_blank($efficiency_percent_list);
                    if(!empty($new_avg_list)){echo $avg_eff =round(array_sum($new_avg_list)/count($new_avg_list));}else{$avg_eff='';}
                    ?> %
                </td> 
            </tr>
        </table>
        <?php
        if($avg_eff > 0){return $avg_eff;}
    }//function close











    //--------------------------------------------------------------------PLAN
    //production  plan search 
    public function get_all_plan_with_search($search)
    {
         $sql="  SELECT A.*,
                    B.name as in_product_name,
                    B.size as in_size,
                    C.size as out_size,
                    C.name as out_product_name,
                    D.name as grade_name,
                    CU.name as cname,
                    E.name as product_type_name,
                    I.name as mc_name,
                    J.name as dept_name

                    FROM production_plan as A 
                    LEFT JOIN product as B ON B.product_id = A.inletSize 
                    LEFT JOIN product as C ON C.product_id = A.outletSize 
                    LEFT JOIN product_grade as D ON D.id = A.inletGrade 
                    LEFT JOIN product_type as E ON E.id = A.outletgrade
                    LEFT JOIN customer as CU ON CU.id = A.partyName
                    LEFT JOIN machine_list as I ON I.mc_id = A.mc_no
                    LEFT JOIN department as J ON J.department_id = I.dept 
               
                WHERE 1=1  $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //get current running plan
	public function fun_get_machine_running_plan($mc_no)
	{
        $sql = "SELECT A.*,
            B.name as in_product_name,
            B.size as in_size,
            C.size as out_size,
            C.name as out_product_name,
            D.name as grade_name,
            CU.name as cname,
            E.name as product_type_name

            FROM production_plan as A 
            LEFT JOIN product as B ON B.product_id = A.inletSize 
            LEFT JOIN product as C ON C.product_id = A.outletSize 
            LEFT JOIN product_grade as D ON D.id = A.inletGrade 
            LEFT JOIN product_type as E ON E.id = A.outletgrade
            LEFT JOIN customer as CU ON CU.id = A.partyName
        where A.mc_no = '$mc_no' and A.status='Pending' ORDER BY A.startDateTime ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get current running plan rank
	public function fun_get_machine_running_plan_rank($mc_no)
	{
        $sql = "SELECT A.planRank
                FROM production_plan as A 
                where A.mc_no = '$mc_no' and A.status='Pending' ORDER BY A.planRank DESC LIMIT 1 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function fun_plan_with_id($planid)
	{
        $sql = "SELECT A.*,
            B.name as in_product_name,
            B.size as in_size,
            C.size as out_size,
            C.name as out_product_name,
            D.name as grade_name,
            E.name as product_type_name

        FROM production_plan as A 
        LEFT JOIN product as B ON B.product_id = A.inletSize 
        LEFT JOIN product as C ON C.product_id = A.outletSize 
        LEFT JOIN product_grade as D ON D.id = A.inletGrade 
        LEFT JOIN product_type as E ON E.id = A.outletgrade
        where A.planid  = '$planid '  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

     //hours Req change
     public function pending_plan_display()
     {
        $sql = "SELECT A.*,
            B.name as in_product_name,
            B.size as in_size,
            C.size as out_size,
            C.name as out_product_name,
            D.name as grade_name,
            CU.name as cname,
            E.name as product_type_name

            FROM production_plan as A 
            LEFT JOIN product as B ON B.product_id = A.inletSize 
            LEFT JOIN product as C ON C.product_id = A.outletSize 
            LEFT JOIN product_grade as D ON D.id = A.inletGrade 
            LEFT JOIN product_type as E ON E.id = A.outletgrade
            LEFT JOIN customer as CU ON CU.id = A.partyName
            where  A.status='Pending' ORDER BY A.startDateTime ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
     }//function close


    //change rank of plan
    public function fun_plan_rank_change($mc_no,$targetIndex, $newRank)
	{
        $sql = "SELECT A.planid,A.planRank,A.startDateTime,A.hoursReq,A.endDateTime 
        FROM production_plan as A 
        where A.mc_no = '$mc_no' and A.status='Pending' ORDER BY A.startDateTime ASC ";
        $query = $this->db->query($sql);
        $array_list = $query->result_array();
        
       //print_r($array_list);
       //echo "<br>";

         // Find target item
        $targetItem = null;
        foreach ($array_list as $key => $item) {
            if ($item['planRank'] == $targetIndex) {
                $targetItem = $item;
                unset($array_list[$key]); // Remove the item
                break;
            }
        }

        if (!$targetItem) {
            echo "Rank $targetIndex not found!";
            return;
        }

        // Reorder the ranks
        foreach ($array_list as &$item) {
            if ($item['planRank'] >= $newRank) {
                $item['planRank']++;
            }
        }

        // Insert the target item at the new position
        $targetItem['planRank'] = $newRank;
        $array_list[] = $targetItem;

        // Sort the array by planRank
        usort($array_list, function ($a, $b) {
            return $a['planRank'] - $b['planRank'];
        });

        // Adjust start and end times dynamically
        for ($i = 0; $i < count($array_list); $i++) {
            if ($i == 0) {
                // Keep the first item's start time unchanged
                $array_list[$i]['startDateTime'] = $array_list[$i]['startDateTime'];
            } else {
                // Start time of the current item = End time of the previous item
                $array_list[$i]['startDateTime'] = $array_list[$i - 1]['endDateTime'];
            }
            // Calculate the new endDateTime
            $array_list[$i]['endDateTime'] = date('Y-m-d H:i:s', strtotime($array_list[$i]['startDateTime'] . " + {$array_list[$i]['hoursReq']} hours"));
        }


        //print_r($array_list);

        //update table
        if(!empty($array_list)){
            foreach($array_list as $a){
                $data = array(
                    'planRank' => $a['planRank'],
                    'startDateTime' => $a['startDateTime'],
                    'endDateTime' => $a['endDateTime'],
                );
                $where=array('planid'=>$a['planid']);   
                //echo $a['planid'];
                $this->Mymodel->update('production_plan',$data,$where);
            }
        }
    }//function close


    //hours Req change
    public function fun_hoursReq_change($mc_no)
	{
        $sql = "SELECT A.planid,A.planRank,A.startDateTime,A.hoursReq,A.endDateTime 
        FROM production_plan as A 
        where A.mc_no = '$mc_no' and A.status='Pending' ORDER BY A.startDateTime ASC ";
        $query = $this->db->query($sql);
        $array_list = $query->result_array();
        
       //print_r($array_list);
       //echo "<br>";

        // Adjust start and end times dynamically
        for ($i = 0; $i < count($array_list); $i++) {
            if ($i == 0) {
                // Keep the first item's start time unchanged
                $array_list[$i]['startDateTime'] = $array_list[$i]['startDateTime'];
            } else {
                // Start time of the current item = End time of the previous item
                $array_list[$i]['startDateTime'] = $array_list[$i - 1]['endDateTime'];
            }
            // Calculate the new endDateTime
            $array_list[$i]['endDateTime'] = date('Y-m-d H:i:s', strtotime($array_list[$i]['startDateTime'] . " + {$array_list[$i]['hoursReq']} hours"));
        }


        //print_r($array_list);

        //update table
        if(!empty($array_list)){
            foreach($array_list as $a){
                $data = array(
                    'startDateTime' => $a['startDateTime'],
                    'endDateTime' => $a['endDateTime'],
                );
                $where=array('planid'=>$a['planid']);   
                //echo $a['planid'];
                //print_r($data);
                $this->Mymodel->update('production_plan',$data,$where);
            }
        }
    }//function close




    


    //hours Req change
    public function pending_plan_display_table()
	{
       
        ?>
        <h2 class="text-center">Machine Production Plan</h2>
        <?php 
            $machines = $this->Base->get_all_machine();
            foreach ($machines as $m) 
            {
                $plans = $this->fun_get_machine_running_plan($m['mc_id']);
                if(empty($plans)){ continue;}
                ?>
                    <div class="machine-section">
                        <div class="machine-header">Machine No: <?= $m['mname'] ?></div>

                        <div class="row mt-3">
                            <?php 
                            $orderArray = array();
                            $proArray = array();
                            $balArray = array();
                            foreach ($plans as $item) 
                            { 
                                $startDate = $this->Base->change_date_dmy_hisa($item["startDateTime"]);
				                $endDate = $this->Base->change_date_dmy_hisa($item["endDateTime"]);
                                ?>
                                <div class="col-md-3" title="<?= $item["planid"] ?>">
                                    <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="badge bg-warning"><?= $item["status"] ?></span> 
                                        <span>Plan Rank: <?= $item["planRank"] ?>, Order No: <?= $item["orderNo"] ?> </span>
                                        <input type="button" id="newPlan" onclick="getModel(<?= $item['planid'];?>)" 
                                            class="btn btn-warning btn-sm" value="Edit"  
                                            data-toggle="modal" data-target=".plan-modal-lg">
                                    </div>

                                        <div class="card-body">
                                            <h6 class="card-title"><?= $item["in_size"] ?> → <?= $item["out_size"] ?>, <?= $item["cname"] ?> </h6>
                                           
                                            <p>
                                                <strong>Inlet Grade:</strong> <?= $item["grade_name"] ?> | <strong>Outlet Grade:</strong> <?= $item["product_type_name"] ?>,
                                                
                                                <br>
                                                <strong>Coating:</strong> <?= $item["coating"] ?> | <strong>Oil/Dry:</strong> <?= $item["oilDry"] ?>
                                                <br>
                                                <strong>Order Qty:</strong> <?= $orderArray[] = $item["orderQty"] ?> | <strong>Produced:</strong> <?= $proArray[] = $item["prodQty"] ?> | <strong>Balance:</strong> <?= $balArray[] = $item["balQty"] ?>
                                                <br>
                                               <strong>Coil Weight:</strong> <?= $item["coilWeight"] ?> | Reading:</strong> <?= $item["readingMtr"] ?> | (Speed: <?= $item["currentSpeed"] ?>)
                                                <br>
                                                <br> 
                                                <strong>Start:</strong> <?= $startDate ?>  
                                                <br><strong>End:</strong> <?= $endDate ?>
                                                <br> <?php $this->Base->get_date_bw_two_days($startDate,$endDate);?>
                                                <br><strong>Remarks:</strong> <?= !empty($item["remarks"]) ? $item["remarks"] : "N/A" ?>
                                                <br>
                                                <strong>Available Rod:</strong> 
                                                <?php 
                                                    echo $rolList = $this->Pomodel->count_all_not_issue_colino(sprintf("%.3f", $item['in_size']),$item['inletGrade']);
                                                ?>
                                                 
                                                 
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>


                            <div class="col-md-12" title="Total">
                                    <div class="card">
                                        <div class="card-header" style="background-color:white;color:black">
                                            Total Order Qty: <?php if(!empty($orderArray))echo array_sum($orderArray); ?>, <span style="margin-left:50px;"></span> 
                                            Total Produced Qty: <?php if(!empty($proArray))echo array_sum($proArray); ?>,  <span style="margin-left:50px;"></span> 
                                            Total Balance Qty: <?php if(!empty($balArray))echo array_sum($balArray); ?>
                                        </div>
                                    </div>
                                </div>

                        </div>



                       
                               
                        
                        
                    </div>
                <?php 
            } 
        ?>
    




        <?php
    }//function close










}//class close



