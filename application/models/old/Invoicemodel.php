<?php
class Invoicemodel extends CI_Model
{
	//get total stock qty with product id
	public function get_product_last_invoice_entry_rate($product_id,$supplier_id,$val)
	{
        if($val == 'same_supplier')
        {
            $sql = "SELECT A.price,A.invoice_date,A.details_id,S.name as sname
                    FROM  product_invoice_entry_details as A 
                    LEFT JOIN supplier S ON A.supplier_id=S.id      
                    WHERE A.product_id='$product_id' and A.supplier_id = '$supplier_id' ORDER BY A.invoice_date DESC LIMIT 1
                    ";
        }
        else if($val == 'diff_supplier')
        {
            $sql = "SELECT A.price,A.invoice_date,A.details_id,S.name as sname
                    FROM  product_invoice_entry_details as A 
                    LEFT JOIN supplier S ON A.supplier_id=S.id      
                    WHERE A.product_id='$product_id' and A.supplier_id != '$supplier_id' ORDER BY A.invoice_date DESC LIMIT 1
                    ";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close





}//class close



