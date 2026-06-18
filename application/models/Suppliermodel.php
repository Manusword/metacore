<?php
class Suppliermodel extends CI_Model
{
	//gst
	public function check_supplier_gst($gst)
	{
        $sql = "SELECT * FROM supplier where gst_no='$gst'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get supplier details 
    public function get_supplier_with_id($id)
	{
        $sql = "SELECT * FROM supplier where id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    //all supplier list
    public function get_all_active_supplier()
	{
        $sql = "SELECT * FROM supplier WHERE  status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return  $query->result_array();
    }//function close



    //supplier approved or not
    public function is_supplier_approved($id)
	{
        $sql = "SELECT approved_no FROM supplier WHERE  id = '$id' ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res) and $res[0]['approved_no']>0){return $res[0]['approved_no'];}else{return "FALSE";}
    }//function close



    
    //supplier search
    public function get_all_supplier_with_search($search)
	{
        $sql="SELECT * FROM supplier WHERE 1=1  $search ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //supplier search
    public function get_supplier_gst_type($id)
	{
        $our = $this->Company->our_gst_details();
        $our_gst = isset($our[0]['gstno']) ? $our[0]['gstno'] : '';
        $our_state_code = substr($our_gst, 0, 2);
        $res = $this->get_supplier_with_id($id);
        $state_name=$res[0]['state'];
        $state_name1=explode('(',$state_name);
        $state_name2=explode(')',$state_name1[1]);
        $code=$state_name2[0];
        if($code == $our_state_code)
        {
            $mgs = "SGST & CGST";
        }
        else
        {
            $mgs = "IGST";
        }//if code
        
        return $mgs;
    }//function close





}//class close



