<?php
class Gpmodel extends CI_Model
{
	
    
    //get get_gp_data_with_id
	public function get_gp_data_with_id($id)
	{
        $sql = "SELECT A.*,S.name as sname,C.name as cname  
                FROM gatepass as A 
                LEFT JOIN supplier S ON S.id=A.job_work_supplier_id
                LEFT JOIN customer C ON C.id=A.job_work_supplier_id
                where A.gp_id = '$id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    
    //get get_gp_details_data_with_gpid
	public function get_gp_details_data_with_gpid($id)
	{
        $sql = "SELECT A.*,P.name as pname,U.name as uname
                FROM gatepass_details as A 
                LEFT JOIN product P ON P.product_id=A.product_id
                LEFT JOIN unit U ON U.unit_id=A.unitname_id
                where A.gp_id = '$id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close




    /*
    //qc test1 check
    public function get_spec1_details_for_test1_check($type2,$size)
	{
        $sql = "SELECT * FROM qc_spec1  where type2 = '$type2' and size = '$size'   ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


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
    }//function close

    */





    //next gp no
	public function get_next_gp_no($date)
	{
		$sql = "SELECT gp_no FROM gatepass where  entry_date='$date' ORDER BY gp_no DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))
        {
            $next_no = ((int)$res[0]['gp_no'])+1;
        }
        else
        {
            $join_date = $this->Base->change_date_join_ymd($date);
            $next_no = $join_date.'01';
        }
        return $next_no;
    }//function close

   
 
















    //get get_sepc1_data_with_id
	public function get_test1_data_with_id($id)
	{
        $sql = "SELECT A.*,G.name as grade_name,M.name as mname,D.name as dname
                FROM qc_test1 as A 
                LEFT JOIN product_grade G ON G.id=A.product_grade
                LEFT JOIN machine_list as M ON A.mc_no = M.mc_id  
                LEFT JOIN department as D ON M.dept = D.department_id
               
                where A.id = '$id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //test1 search 
    public function get_all_test1_with_search($search)
    {
        $sql=" SELECT A.*,G.name as grade_name,M.name as mname,D.name as dname
                FROM qc_test1 as A 
                LEFT JOIN product_grade G ON G.id=A.product_grade
                LEFT JOIN machine_list as M ON A.mc_no = M.mc_id  
                LEFT JOIN department as D ON M.dept = D.department_id
                WHERE 1=1  $search 
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    

    




}//class close



