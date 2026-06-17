<?php
class Machinemodel extends CI_Model
{
    //get machine details form ID
	public function get_machine_details_with_id($id)
	{
        $sql = "SELECT A.*,B.name as dname FROM machine_list as A LEFT JOIN department as B ON A.dept = B.department_id WHERE  A.mc_id='$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //all machine lift form dept id
    public function fun_get_machine_form_dept_id($department_id)
    {
        $sql=" SELECT mc_id,name FROM machine_list WHERE dept= '$department_id' and status='Working' and hide_status='0' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //get dept id form machine id
    public function fun_get_dept_id_from_mc_id($mc_id)
    {
        $sql=" SELECT dept FROM machine_list WHERE mc_id='$mc_id' ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){return $res[0]['dept'];}else{return "";}
    }//function close


    //machine production tool life target
    public function fun_get_machine_pro_tool_target($id)
    {
        $sql=" SELECT * FROM machine_pro_tool_target WHERE mc_id='$id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //machine production capicity target
    public function fun_get_machine_pro_capicity_target($id)
    {
        $sql=" SELECT * FROM machine_pro_eff_target WHERE mc_id='$id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //machine production capicity target
    public function fun_get_machine_pro_capicity_target_with_mcid_proid($mc_id,$product_id)
    {
        $sql=" SELECT * FROM machine_pro_eff_target WHERE mc_id='$mc_id' and product_id='$product_id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    
    //machine search 
    public function get_all_machine_with_search($search)
    {
        $sql=" SELECT A.*,B.name as dname FROM machine_list as A LEFT JOIN department as B ON A.dept = B.department_id  WHERE 1=1  $search ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    

    // calculate_machine_eff
    public function calculate_machine_eff($mc_id,$product_id,$qty,$running_hours)
    {
        if(!empty($res = $this->fun_get_machine_pro_capicity_target_with_mcid_proid($mc_id,$product_id)))
        {
            $target_one_hour_production = round($res[0]['pro_eff']/24); 
            $total_target_qty = round($running_hours*$target_one_hour_production);
            $ef = round(($qty/$total_target_qty)*100);
            if($ef>0){return $ef;}else{return 0;}
        }
        else
        {
            return 0;
        }
    }//function close



}//class close





