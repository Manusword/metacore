<?php
class Productmodel extends CI_Model
{
	//get product details form id
	public function get_product_data_with_id($id)
	{
        $sql = "SELECT A.*,C.name as cname,U.name as uname 
                FROM product as A 
                LEFT JOIN category C ON C.category_id=A.category_id
                LEFT JOIN unit as U ON U.unit_id = A.unit_id
                where A.product_id = '$id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //all row matrial list
    public function get_row_product_list()
	{
        $sql = "SELECT A.*,C.name as cname,U.name as uname FROM product as A 
                LEFT JOIN category C ON C.category_id=A.category_id
                LEFT JOIN unit as U ON U.unit_id = A.unit_id
                where A.row_mat_puc =1  
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get product details form id
	public function get_product_column_data_with_id($id,$field)
	{
        $sql = "SELECT $field FROM product where product_id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get product details form cat and name
    public function get_product_data_with_name_and_category($name,$category_id)
	{
        $sql = "SELECT * FROM product where name = '$name' and   category_id='$category_id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get_default_category_product_search
    public function get_default_category_product_search()
	{
        $sql = "SELECT details1 FROM company_profile where id =8 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res[0]['details1'];
    }//function close

    


    //product search with category and product name
    public function get_all_product_with_search($search)
	{
        $sql="
					SELECT  
					A.no_of_days,A.product_id,A.size,A.name,A.economic,A.reorder,A.max_level,A.status,A.repeated,A.row_mat_puc,A.details,A.con_mat_puc,
					B.name as cat,
					C.name as unit
					FROM product as A 
                    LEFT JOIN category B ON B.category_id=A.category_id
					LEFT JOIN unit as C ON C.unit_id = A.unit_id
					WHERE 1=1  $search 
				";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //product_autocomplate_search
    public function product_autocomplate_search_via_name($name)
	{
        $sql = " SELECT product_id,name,size FROM product WHERE name like '%$name%' and status='Active'  ORDER by name ASC LIMIT 10  ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $output=array();
		foreach($result as $row)
		{
			$output[] = array("value" =>$row['product_id'], "label" =>$row['name'], "size" =>$row['size']);
		}
        return $output;
    }//function close





}//class close



