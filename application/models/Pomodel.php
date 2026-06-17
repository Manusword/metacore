<?php
class Pomodel extends CI_Model
{
    //get PO details form ID
	public function get_po_details_with_id($po_id)
	{
        $sql = "SELECT A.*,B.name as s_name FROM po_entry as A LEFT JOIN supplier as B ON A.supplier_id = B.id where  A.po_id='$po_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    
    //get total purchase rs date wise
    public function get_total_purchase_in_rs($product_type,$from_date,$to_date)
	{
        $sql="  SELECT sum(total) as total_rs,sum(grandtotal) as grandtotal_rs
        FROM product_invoice_entry as A
        LEFT JOIN supplier as B  ON B.id = A.supplier_id
        WHERE  A.invoice_date between '$from_date' and '$to_date'  ";

        if($product_type != 'All')
        {
            $sql.= " and   B.product_type='$product_type' ";
        }
        //echo $sql;
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close


   


    //get PO list form stage
	public function get_po_list_from_stage($stage)
	{
        $sql = "   SELECT A.*,B.name as sname FROM po_entry as A
                   LEFT JOIN supplier as B ON A.supplier_id = B.id
                   where A.status='Active' and A.stage='$stage'  ORDER by A.po_no DESC
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    //next po no
	public function get_next_po_no($date)
	{
		$sql = "SELECT po_no FROM po_entry where  po_date='$date' ORDER BY po_no DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))
        {
            $next_no = ((int)$res[0]['po_no'])+1;
        }
        else
        {
            $join_date = $this->Base->change_date_join_ymd($date);
            $next_no = $join_date.'01';
        }
        return $next_no;
    }//function close


    //get PO amt form po id
	public function get_po_all_amt_form_id($po_id)
	{
        $sql = "SELECT total FROM po_entry WHERE po_id='$po_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    
   


    //get PO PCC photo exits or not
	public function get_pcc_image_details_with_id($po_id)
	{
        $sql = "SELECT pcc_img_status FROM po_entry where  po_id='$po_id'  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res) and  $res[0]['pcc_img_status']==1)
        {
            $msg = "YES";
        }
        else
        {
            $msg = "NO";
        }
        return $msg;
    }//function close

















    //---------------------------------------------------------PO Product
    //get PO product details form ID
	public function get_po_product_details_with_id($po_id)
	{
        $sql = "SELECT * FROM po_entry_details where  po_entry_id='$po_id' ORDER by po_entry_details_id ASC  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get PO product details form po_entry_details_id
	public function get_po_product_details_with_podetails_id($po_entry_details_id)
	{
        $sql = "SELECT * FROM po_entry_details where  po_entry_details_id='$po_entry_details_id' ORDER by po_entry_details_id ASC  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //get PO  details form supplier_id
	public function get_po_details_with_supplier_id($supplier_id)
	{
        $sql = "SELECT * FROM po_entry_details where  supplier_id='$supplier_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    
    //get product details form form last purchase
	public function get_product_data_with_id_all($supplier_id,$product_id)
	{
        $sql = "SELECT * FROM po_entry_details where supplier_id='$supplier_id' and  product_id='$product_id'   ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    //get product details form form last purchase
	public function get_product_data_with_id($supplier_id,$product_id)
	{
        if($supplier_id == 'All')
        {
            //for get data form all supllier
            $sql = "SELECT * FROM po_entry_details where  product_id='$product_id' ORDER BY po_no DESC LIMIT 1  ";
        }
        else
        {
            //for get data form one supllier
            $sql = "SELECT * FROM po_entry_details where supplier_id='$supplier_id' and  product_id='$product_id' ORDER BY po_no DESC LIMIT 1  ";
        }//all
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //get_product_unit_form_last_purchase
    public function get_product_unit_form_last_purchase($product_id)
	{
        $sql = "SELECT unitname_id FROM po_entry_details where product_id='$product_id' and unitname_id!='' ORDER BY po_no DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))return $res[0]['unitname_id'];
    }//function close

    //get_product_hsn_form_last_purchase
    public function get_product_hsn_form_last_purchase($product_id)
	{
        $sql = "SELECT hsn FROM po_entry_details where product_id='$product_id' and hsn!='' ORDER BY po_no DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))return $res[0]['hsn'];
    }//function close

    //get_product_igst_per_form_last_purchase
    public function get_product_igst_per_form_last_purchase($product_id)
	{
        $sql = "SELECT itemigst FROM po_entry_details where product_id='$product_id' and itemigst!='' ORDER BY po_no DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))return $res[0]['itemigst'];
    }//function close

    //get_product_cgst_per_form_last_purchase
    public function get_product_cgst_per_form_last_purchase($product_id)
	{
        $sql = "SELECT itemcgst FROM po_entry_details where product_id='$product_id' and itemcgst!='' ORDER BY po_no DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))return $res[0]['itemcgst'];
    }//function close

    //get_product_sgst_per_form_last_purchase
    public function get_product_sgst_per_form_last_purchase($product_id)
	{
        $sql = "SELECT itemsgst FROM po_entry_details where product_id='$product_id' and itemsgst!='' ORDER BY po_no DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))return $res[0]['itemsgst'];
    }//function close












    //--------------------------------------------------------both po table query
    //get PO total product and rec product
    public function get_product_total_order_total_rec_in_no($fdate,$tdate)
	{
        $sql = "    SELECT  
					A.po_id,A.po_date,A.po_no,A.supplier_id,A.grandtotal,A.stage,A.out_print_option_set,S.name as sname,
                    (select count(*) from po_entry_details WHERE po_entry_id=A.po_id ) AS total_item,
                    (select count(*) from po_entry_details WHERE po_entry_id=A.po_id and stage=1 ) AS rec_item
                    FROM po_entry as A 
                    LEFT JOIN po_entry_details B ON B.po_entry_id=A.po_id
                    LEFT JOIN supplier as S ON A.supplier_id = S.id
                    WHERE  A.status='Active' and A.stage='5'  and A.po_date between '$fdate' and '$tdate'  GROUP BY A.po_id ORDER by A.po_no DESC  
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //PO search
    public function po_serach_query($search)
    {
        $sql="  SELECT  
                A.po_id,A.po_date,A.po_no,A.supplier_id,A.grandtotal,A.stage,A.out_print_option_set,A.reject_by,A.comment,S.name as sname,
                (select count(*) from po_entry_details WHERE po_entry_id=A.po_id ) AS total_item,
                (select count(*) from po_entry_details WHERE po_entry_id=A.po_id and stage=1 ) AS rec_item
                FROM po_entry as A 
                LEFT JOIN po_entry_details B ON B.po_entry_id=A.po_id
                LEFT JOIN supplier as S ON A.supplier_id = S.id
                WHERE 1=1 $search
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //PO product list form supplier while invoice entry (PO controler)
    public function get_product_form_po_details_with_supplier_id($supplier_id,$validity,$data)
    {
        $today=date("Y-m-d");
        $sql="  SELECT  A.product_id,B.name
                FROM po_entry_details as A 
                LEFT JOIN product B ON B.product_id=A.product_id
                LEFT JOIN po_entry P ON P.po_id=A.po_entry_id
                WHERE A.supplier_id='$supplier_id'  and A.stage='0' and P.stage='5' and P.invoice_entry_disable!=1
            ";
        //validity
        if($validity != 'Yes'){$sql = $sql." and P.po_validity >= '$today' ";}
        $sql = $sql." GROUP BY A.product_id ORDER BY B.name ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //PO po no  list form supplier while invoice entry (PO controler)
    public function get_pono_form_po_details_with_supplier_id_and_product_id($supplier_id,$product_id,$validity,$data)
    {
        $today=date("Y-m-d");
        $sql="  SELECT  A.po_entry_details_id,P.po_no
                FROM po_entry_details as A 
                LEFT JOIN product B ON B.product_id=A.product_id
                LEFT JOIN po_entry P ON P.po_id=A.po_entry_id
                WHERE A.supplier_id='$supplier_id' and A.product_id='$product_id'  and A.stage='0' and P.stage='5' and P.invoice_entry_disable!=1
            ";
        //validity
        if($validity != 'Yes'){$sql = $sql." and P.po_validity >= '$today' ";}
        $sql = $sql." GROUP BY A.po_no ORDER by A.po_no ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close




    
    //PO product search
    public function po_product_serach_query($search)
    {
        $sql="
                SELECT  A.po_date,A.po_no,A.supplier_id,A.product_id,A.unitname_id,A.qunt,A.rate,A.disc,A.net,A.amount,A.rev_qunt,
                S.name as sname,
                P.name as pname,
                U.name as uname,
                B.out_print_option_set,
                B.po_id

                FROM po_entry_details as A

                LEFT JOIN po_entry B ON A.po_entry_id=B.po_id
                LEFT JOIN supplier S ON S.id=A.supplier_id
                LEFT JOIN product P ON A.product_id=P.product_id
                LEFT JOIN unit U ON A.unitname_id=U.unit_id

                WHERE 1=1 $search
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close




    //----------------------------------------------------PO Print
    public function print_po($id)
	{
        if($id>0)
		{
            $result['res2'] = $this->Pomodel->get_po_details_with_id($id);
            $result['res3'] = $this->Pomodel->get_po_product_details_with_id($id);
            //supplier details
            $supplier_id = $result['res2'][0]['supplier_id'];
            $result['sup'] = $this->Suppliermodel->get_supplier_with_id($supplier_id);
            
            $this->load->view('po/print/print',$result);
        }
    }//function close


    public function po_action_email($id,$current_status,$after_accept_action_no,$after_reject_action_no,$from,$to_list)
	{
        if($id>0)
		{
            $result['res2'] = $this->Pomodel->get_po_details_with_id($id);
            $result['res3'] = $this->Pomodel->get_po_product_details_with_id($id);
            //supplier details
            $supplier_id = $result['res2'][0]['supplier_id'];
            $po_no = $result['res2'][0]['po_no'];
            $result['sup'] = $this->Suppliermodel->get_supplier_with_id($supplier_id);
            $sup_name = $result['sup'][0]['name'];
            
            $body = $this->load->view('po/print/print',$result,true);
            $body_footer2="<br><br> Thank You.";
            $body_footer2=$body_footer2."<br><br><span style='color:red;'>This is system generated email. No need to reply.</span>";

            if($current_status == 4 and $after_accept_action_no == 5 )
            {
                //po approved sending to store
                $sub= "<br><br><span style='color:green;'>PO Approved</span>";
                $body2 = $sub.$body.$body_footer2;
            }
            else
            {
                $sub= "<br><br><span style='color:red;'>New PO</span>";
                $url1=base_url();
                $url2=base_url()."index.php/Welcome/po_approved_by_email?po_id=$id&email=$from&newstage=$after_accept_action_no&current_status=$current_status";
                $url3=base_url()."index.php/Welcome/po_reject_by_email?po_id=$id&email=$from&newstage=$after_reject_action_no&current_status=$current_status";
                
                $login_button="<br><br><a href='$url1'><button style='width:100px; height:30px; margin-left:40px; background-color:blue;color:white'>Login</button></a>";
                $approve_button="<br><br><a href='$url2'><button style='width:100px; height:30px; margin-left:40px; background-color:green;color:white'>Approve</button></a>";
                $Reject_button="<br><br><a href='$url3'><button style='width:100px; height:30px; margin-left:40px; background-color:red;color:white'>Reject</button></a>";
                $body2 = $sub.$body.$login_button.$approve_button.$Reject_button.$body_footer2;
            }

            
            
            $tolist = explode(",",$to_list);
            if(!empty($tolist))
            {
                foreach($tolist as $to)
                {
                   $this->Base->send_po_mail($to,"PO: $po_no: $sup_name",$body2);
                }
            }

        }
    }//function close



























    //-----------------------------------------------------------DELETE
    //delete product form po
	public function delete_po_product_with_id($po_entry_details_id)
	{
        $sql = "DELETE FROM po_entry_details WHERE po_entry_details_id='$po_entry_details_id'  ";
        $this->db->query($sql);
        return "Deleted";
    }//function close
























    //-----------------------------------------------------PO Invoice
    //next invoice no
	public function get_next_invoice_no($date)
	{
		$sql = "SELECT product_invoice_save_no FROM product_invoice_entry where  product_invoice_save_date='$date' ORDER BY product_invoice_save_no DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))
        {
            $next_no = ((int)$res[0]['product_invoice_save_no'])+1;
        }
        else
        {
            $join_date = $this->Base->change_date_join_ymd($date);
            $next_no = $join_date.'01';
        }
        return $next_no;
    }//function close

    //get PO invoice details form ID
	public function get_po_invoice_details_with_id($id)
	{
        $sql = "SELECT A.*,B.name as sname FROM product_invoice_entry as A LEFT JOIN supplier as B ON A.supplier_id = B.id where  A.product_invoice_entry_id='$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //get PO Invoice product details form ID
	public function get_po_invoice_product_details_with_id($product_invoice_entry_id)
	{
        $sql = "SELECT * FROM product_invoice_entry_details where  product_invoice_entry_id='$product_invoice_entry_id' ORDER by product_invoice_entry_id ASC  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get PO Invoice product details form po_entry_details_id
	public function get_po_invoice_product_details_with_podetails_id($details_id)
	{
        $sql = "SELECT A.*,P.name as pname FROM product_invoice_entry_details as A
         LEFT JOIN product as P ON A.product_id = P.product_id
        where  details_id='$details_id' ORDER by details_id ASC  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //get PO Invoice product get_po_invoice_qc_row_heat_with_invoice_id form po_entry_details_id
	public function get_po_invoice_qc_row_heat_with_invoice_id($invoice_deatils_id)
	{
        $sql = "SELECT * FROM product_invoice_row_heatdeatils where  invoice_deatils_id='$invoice_deatils_id' ORDER by finish_size ASC  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //invoice search
    public function po_invoice_serach_query($search)
    {
        $sql="  SELECT 
                A.*,B.name as sname 
                FROM product_invoice_entry as A 
                LEFT JOIN supplier as B ON A.supplier_id = B.id 
                where 1=1 $search
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //po invoice product search
    function product_group_by_rate($search)
    {
        $sql="	SELECT A.*,
                    SUM(A.net) as total_qty_list,
                    SUM(A.amount) as total_amount_list,
                    SUM(A.package) as total_package_list,
                    B.raw_material_from,
                    S.name as sname,
                    P.name as pname,
                    U.name as uname	

                    FROM product_invoice_entry_details  as A
                    LEFT JOIN product_invoice_entry as B ON A.product_invoice_entry_id = B.product_invoice_entry_id 
                    LEFT JOIN supplier as S ON B.supplier_id = S.id
                    LEFT JOIN product as P ON A.product_id = P.product_id
                    LEFT JOIN unit as U ON A.unitname_id = U.unit_id
                    
                    where 1=1  $search     
                    GROUP BY A.product_invoice_entry_id,A.product_id,A.price,A.notrepeat
                ";	
        $query = $this->db->query($sql);
        return $query->result_array();	
    }//function close





    public function get_product_last_rate_form_invoice($product_id,$lotno,$grade,$data)
	{
        //-----------geting last price of an item
        $sql=" SELECT price FROM product_invoice_entry_details Where product_id='$product_id' and lotno='$lotno' and product_grade_id='$grade' ORDER BY product_invoice_save_no DESC LIMIT 1 ";
        $query = $this->db->query($sql);
        $out3 = $query->result_array();
        if(!empty($out3) and strlen($out3[0]['price'])>0)
        {
            $price=$out3[0]['price'];
        }
        else
        {
            $sql2 = " SELECT avg(recive_stock_level) as price FROM product_stock Where product_id='$product_id' and lotno='$lotno' and product_grade_id='$grade'  ";
            $query = $this->db->query($sql2);
            $out4 = $query->result_array();
            if(!empty($out4) and strlen($out4[0]['price'])>0)
            {
                $price=$out4[0]['price'];
            }
            else
            {
                $price='0';
            }
        }
        
        if($price>0){return $price;}else{return '0';}
    }//function close


    //save po rec qty when invoice enter
    function recieve_qty_amount($id,$qty,$cost)
    {
        $today=date("Y-m-d H:i:s");
        $user_email = $this->session->userdata('login_emp_id');
        
        $where7=" po_entry_details_id='$id'   ";
        $qry = $this->db->select('*')->where($where7)->get('po_entry_details');$out7= $qry->result_array();
        if(!empty($out7) and count($out7)>0)
        {
            $rev_qunt = (int)$out7[0]['rev_qunt']+$qty;
            $rev_amount = (int)$out7[0]['rev_amount']+$cost;
            $total=$out7[0]['qunt'];
            if($rev_qunt>=$total){$stage=1;}else{$stage=0;}
            
            //--------------------------update PO
            $data3=array(
                            'rev_qunt'=>"$rev_qunt",
                            'rev_amount'=>"$rev_amount",
                            'stage'=>"$stage",
                            'update_by'=>"$user_email",
                            'update_date'=>"$today",
                        );
            $this->db->update('po_entry_details',$data3,$where7);
        }	
    
    }//function close

    //---------------------------------------save opening balance
    function min_recieve_qty_amount($id,$qty,$cost)
    {
        $today=date("Y-m-d H:i:s");
        $user_email=$this->session->userdata('login_emp_id');
        
        $where7=" po_entry_details_id='$id'   ";
        $qry = $this->db->select('*')->where($where7)->get('po_entry_details');
        $out7= $qry->result_array();
        if(!empty($out7) and count($out7)>0)
        {
            $rev_qunt = (int)$out7[0]['rev_qunt']-$qty;
            $rev_amount = (int)$out7[0]['rev_amount']-$cost;
            $total = (int)$out7[0]['qunt'];
            if($rev_qunt>=$total){$stage=1;}else{$stage=0;}
            
            //--------------------------update PO
            $data3=array(
                            'rev_qunt'=>"$rev_qunt",
                            'rev_amount'=>"$rev_amount",
                            'stage'=>"$stage",
                            'update_by'=>"$user_email",
                            'update_date'=>"$today",
                        );
            $this->db->update('po_entry_details',$data3,$where7);
        }	
    
    }//function close


    
    







    //get_po_invoice_qc_row_test_with_invoice_id search
    public function get_po_invoice_qc_row_test_with_invoice_id($invoice_deatils_id)
	{
        $sql = "SELECT Q.*,
            S.name as sname,
            P.name as pname,
            U.name as uname	
            FROM product_invoice_row_qc_test as Q
            LEFT JOIN product_invoice_entry_details as A ON  Q.invoice_deatils_id = A.details_id
            LEFT JOIN product_invoice_entry as B ON A.product_invoice_entry_id = B.product_invoice_entry_id
            LEFT JOIN supplier as S ON B.supplier_id = S.id
            LEFT JOIN product as P ON A.product_id = P.product_id
            LEFT JOIN unit as U ON A.unitname_id = U.unit_id
            where  Q.invoice_deatils_id='$invoice_deatils_id' 
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    
     //po invoice product search
     function product_group_by_rod($search)
     {
         $sql="	SELECT A.*,Q.*,
                     SUM(A.net) as total_qty_list,
                     SUM(A.amount) as total_amount_list,
                     SUM(A.package) as total_package_list,
                     B.raw_material_from,
                     B.invoice_no,
                     S.name as sname,
                     P.name as pname,
                     U.name as uname,
                     G.name as gname	
 
                    FROM product_invoice_entry_details  as A
                    LEFT JOIN product_invoice_entry as B ON A.product_invoice_entry_id = B.product_invoice_entry_id 
                    LEFT JOIN supplier as S ON B.supplier_id = S.id
                    LEFT JOIN product as P ON A.product_id = P.product_id
                    LEFT JOIN unit as U ON A.unitname_id = U.unit_id
                    LEFT JOIN product_invoice_row_qc_test as Q ON  Q.invoice_deatils_id = A.details_id
                    LEFT JOIN product_grade as G ON G.id = Q.product_grade
                     
                    where 1=1  $search     
                    GROUP BY A.product_invoice_entry_id,A.product_id,A.price,A.notrepeat
                 ";	
        $query = $this->db->query($sql);
        return $query->result_array();	
     }//function close

    public function po_rod_show_table($details_id,$min_bl,$max_bl,$rod_category,$issued)
    {
        $blres = $this->Base->get_breakingload_category($min_bl,$max_bl,0);
        if(!empty($blres)){
            $minMaxBL = $this->Base->get_breakingload_min_max($blres[2],$blres[3],$blres[4],$blres[5],$rod_category);
        }else{$minMaxBL ="NaN";}
        //print_r($blres);//find min max is aviavle in product_invoice_row_qc_test

        //getting 10% of min & max BL
        $min_bl_per_val = 0;
        $max_bl_per_val = 0;
        $per = 5;
        if($min_bl >0 ){$min_bl_per_val = round($min_bl + ($per/100*$min_bl));}
        if($max_bl >0 ){$max_bl_per_val = round($max_bl - ($per/100*$max_bl));}

        // echo $min_bl.', '.$min_bl_per_val;
        // echo "<br>";
        // echo $max_bl_per_val.', '.$max_bl;
        
        if($issued == "YES"){
            $rods = $this->Pomodel->get_po_invoice_qc_row_test_coils_with_category_coilsno_not_issue($details_id,$rod_category);
        }else{
            $rods = $this->Pomodel->get_po_invoice_qc_row_test_coils_with_category_coilsno($details_id,$rod_category);
        }
        
        if(!empty($rods)){
            $no_of_rods = count($rods);
            $coilList = "";
            foreach($rods as $rod)
            {
                $minArrow = ""; 
                $maxArrow = "";
                if($min_bl > 0 && $min_bl_per_val >0 && $rod['breaking_load'] > 0 && $rod['breaking_load'] >= $min_bl && $rod['breaking_load'] <= $min_bl_per_val){
                    $minArrow="<i class='i-Left text-danger font-weight-bold'></i> ";
                }
                if($max_bl > 0 && $max_bl_per_val >0 && $rod['breaking_load'] > 0 && $rod['breaking_load'] <= $max_bl && $rod['breaking_load'] >= $max_bl_per_val){
                    $maxArrow="<i class='i-Right text-danger font-weight-bold'></i> ";
                }
                
                
                $coilList.= $minArrow.$rod['coil_no']." (B.L: ". $rod['breaking_load'].") ".$maxArrow."~". $rod['coil_test_d'].", " ;
            }
            // echo $coilList;
        }else{
            $no_of_rods = "";
            $coilList = "";
        }

        return array($minMaxBL, $no_of_rods, $coilList);
    }//function close

    public function po_rod_show_table_display_rod_box($rods_result)
    {
        $rodList = explode(",",$rods_result[2]);
        ?>
            <ul style="list-style-type: none;margin: 0;padding: 0;">
                <li>B.L Min-Max: <span style="color:blue"><?php echo $rods_result[0];?></span></li>
                <li>No of Rods: <span style="color:blue"><?php echo $rods_result[1];?></span></li>
                <li>Rod List: 
                    <ul style="margin: 0;">
                        <?php 
                            foreach($rodList as $rl){
                                if(strlen($rl) < 2)continue;
                                $r = explode("~",$rl);
                                $base_rod_id = $r[1];
                                $coilsList = $this->Qcmodel->getAllWdCoilsList_from_base_rodid_onlycount($base_rod_id);
                                ?>
                                    <li <?php if($coilsList >0){?> style=' color:gray; text-decoration: underline overline dotted red;' <?php }else{?>style='font-weight:bold' <?php }?> >
                                        <?php 
                                            echo $r[0];
                                            if($coilsList >0){
                                            ?>
                                                <button  style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;" type="button" data-toggle="modal" id="<?php echo $base_rod_id;?>"  onclick='fun_get_cust_details(this.id)'  data-target="#exampleModal"><?php echo $coilsList;?></button>
                                                <?php 
                                            }?>
                                    </li>
                                <?php
                            }
                        ?>
                    </ul>  
                </li>
            </ul>
        <?php
    }//function close



    public function get_po_invoice_qc_row_test_coils_with_invoice_id($invoice_deatils_id)
	{
        $sql = "SELECT A.*
            FROM product_invoice_row_qc_test_coilswise as A
            where  A.invoice_deatils_id='$invoice_deatils_id' 
            ORDER BY A.coil_no
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_po_invoice_qc_row_test_coils_with_category($invoice_deatils_id)
	{
        $sql = "SELECT count(A.coil_test_d) no_of_coils,A.coil_no,A.bl_category,A.bl_color
            FROM product_invoice_row_qc_test_coilswise as A
            where  A.invoice_deatils_id='$invoice_deatils_id' 
            GROUP BY A.bl_category
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    public function get_po_invoice_qc_row_test_coils_with_category_coilsno($invoice_deatils_id,$category)
	{
        $sql = "SELECT A.coil_test_d,A.coil_no,A.breaking_load
            FROM product_invoice_row_qc_test_coilswise as A
            where  A.invoice_deatils_id='$invoice_deatils_id' and A.bl_category= '$category'
            GROUP BY A.coil_no
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_po_invoice_qc_row_test_coils_with_category_coilsno_not_issue($invoice_deatils_id,$category)
	{
        $sql = "SELECT A.coil_test_d,A.coil_no,A.breaking_load
            FROM product_invoice_row_qc_test_coilswise as A
            where  A.invoice_deatils_id='$invoice_deatils_id' and A.bl_category= '$category' and coil_issue < 1
            GROUP BY A.coil_no
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    public function get_all_heatno_colino_from_fsize_grade($fsize,$grade)
	{
        $sql = "SELECT A.coil_test_d,A.heat_no,A.coil_no,L.name as lotname
            FROM product_invoice_row_qc_test_coilswise as A
            LEFT JOIN product_invoice_row_qc_test as B ON A.invoice_deatils_id = B.invoice_deatils_id
            LEFT JOIN pickling_production as P ON P.coil_test_d = A.coil_test_d
            LEFT JOIN product_lotno as L ON L.id = P.lotno
            where  A.finish_size='$fsize' and B.product_grade='$grade' and coil_issue=1 and coil_used < 1
            GROUP BY A.heat_no,A.coil_no ORDER BY A.coil_no,A.heat_no
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_all_heatno_colino_from_coil_id($coil_test_d)
	{
        $sql = "SELECT A.coil_test_d,A.finish_size,A.heat_no,A.coil_no,B.min_bl,B.max_bl,B.invoice_deatils_id,A.breaking_load,A.uts,A.bl_category,A.bl_color,
                        B.qc_row_test_date,A.torsion_test,A.bend_test,A.ra_per,A.rdarea,G.name as gname,L.name as lotname
            FROM product_invoice_row_qc_test_coilswise as A
            LEFT JOIN product_invoice_row_qc_test as B ON A.invoice_deatils_id = B.invoice_deatils_id
            LEFT JOIN product_grade as G ON G.id = B.product_grade
            LEFT JOIN pickling_production as P ON P.coil_test_d = A.coil_test_d
            LEFT JOIN product_lotno as L ON L.id = P.lotno
            where  A.coil_test_d = '$coil_test_d'
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_all_heatno_colino_from_rodSize($rodSize,$fdate,$tdate)
    {
        if (!is_array($rodSize)) {
            $rodSize = array_filter(array_map('trim', explode(',', (string)$rodSize)), function($v){ return $v !== ''; });
        } else {
            $rodSize = array_map('trim', $rodSize);
            $rodSize = array_filter($rodSize, function($v){ return $v !== ''; });
        }

        if (empty($rodSize)) {
            return [];
        }

        // escape each value to avoid SQL injection
        $escapedValues = array_map([$this->db, 'escape'], $rodSize);

        $sql = "SELECT A.coil_test_d, A.finish_size, A.invoice_deatils_id
                FROM product_invoice_row_qc_test_coilswise AS A
                LEFT JOIN product_invoice_entry_details AS B ON A.invoice_deatils_id = B.details_id
                WHERE B.invoice_date BETWEEN '$fdate' AND '$tdate' and  A.finish_size IN (" . implode(',', $escapedValues) . ")";

        $query = $this->db->query($sql);
        return $query->result_array();
    }


    


    //log search 
    public function get_all_not_issue_colino_search($search)
    {
        ///$sql = " SELECT * FROM qc_pickling_test as A   WHERE 1=1  $search   ";
        $sql = "SELECT A.*
            FROM product_invoice_row_qc_test_coilswise as A
            LEFT JOIN product_invoice_row_qc_test as B ON A.invoice_deatils_id = B.invoice_deatils_id
            WHERE  1=1  $search 
            
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } //function close


    //rod coilno size wise
    public function get_all_not_issue_colino_groupby_size($coil_issue)
	{
        if(!empty($coil_issue) && $coil_issue == 'ALL'){ $coil_filter = "1=1";}else{ $coil_filter = " A.coil_issue = '$coil_issue' ";}
        $sql = "SELECT A.finish_size
            FROM product_invoice_row_qc_test_coilswise as A
            WHERE   $coil_filter
            GROUP BY A.finish_size ORDER BY A.finish_size ASC
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //rod coilno heat_no wise
    public function get_all_not_issue_colino_groupby_heat($coil_issue)
	{
        if(!empty($coil_issue) && $coil_issue == 'ALL'){ $coil_filter = "1=1";}else{ $coil_filter = " A.coil_issue = '$coil_issue' ";}
        $sql = "SELECT A.heat_no
            FROM product_invoice_row_qc_test_coilswise as A
            WHERE   $coil_filter
            GROUP BY A.heat_no ORDER BY A.heat_no ASC
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //rod coilno grade wise
    public function get_all_not_issue_colino_groupby_grade($coil_issue)
	{
        if(!empty($coil_issue) && $coil_issue == 'ALL'){ $coil_filter = "1=1";}else{ $coil_filter = " A.coil_issue = '$coil_issue' ";}
        $sql = "SELECT B.product_grade,G.name as gname
            FROM product_invoice_row_qc_test_coilswise as A
            LEFT JOIN product_invoice_row_qc_test as B ON A.invoice_deatils_id = B.invoice_deatils_id
            LEFT JOIN product_grade as G ON G.id =B.product_grade
            WHERE   $coil_filter
            GROUP BY B.product_grade ORDER BY G.name ASC
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    

    //get rod
    public function fun_wire_rod_query($size,$grade)
	{
        $where = "  and  A.finish_size='$size'  and  B.product_grade ='$grade' and  A.coil_issue <1 ORDER BY A.bl_category ASC  ";
		return $this->get_all_not_issue_colino_search($where);
    }//function close

    public function fun_wire_rod_size_grade_wise_query()
	{
        $sql = "SELECT 
                    G.name AS gname,
                    A.finish_size,
                    COUNT(A.coil_test_d) AS nos,
                    GROUP_CONCAT(A.coil_no ORDER BY A.coil_no ASC SEPARATOR ', ') AS coil_numbers
                FROM product_invoice_row_qc_test_coilswise AS A
                LEFT JOIN product_invoice_row_qc_test AS B 
                    ON A.invoice_deatils_id = B.invoice_deatils_id
                LEFT JOIN product_grade AS G 
                    ON G.id = B.product_grade
                WHERE A.coil_issue < 1 
                GROUP BY A.finish_size, B.product_grade  
                ORDER BY A.finish_size ASC;  
        ";
        $query = $this->db->query($sql);
        return $result =  $query->result_array();
    }//function close

    //count rod
    public function count_all_not_issue_colino($size,$grade)
    {
        ///$sql = " SELECT * FROM qc_pickling_test as A   WHERE 1=1  $search   ";
        $sql = "SELECT count(A.coil_test_d) as nos
            FROM product_invoice_row_qc_test_coilswise as A
            LEFT JOIN product_invoice_row_qc_test as B ON A.invoice_deatils_id = B.invoice_deatils_id
            WHERE A.finish_size='$size'  and  B.product_grade ='$grade' and  A.coil_issue <1 
        ";
        $query = $this->db->query($sql);
        $result =  $query->result_array();
        return $result[0]['nos'];
    } //function close




    public function fun_wire_rod_list($result,$rods)
	{
        $rod = explode(',',$rods);
        ?>
            <table border="1" width="100%">
                <tr style="background-color: #d4d5d6;">
                    <th>Sno</th>
                    <th>Choose</th>
                    <th>Coil No</th>
                    <th>Heat No</th>
                    <th>Size</th>
                    <th>B.L.</th>
                    <th>BL Category</th>
                    
                    <th>Torsion Test</th>
                    <th>Band Test</th>
                    <th>RD (mm)</th>
                    <th>% RA</th>
                </tr>
                <?php 
                    $i=1;
                    foreach($result as $r){
                        if(isset($r['issue_date']) && $r['issue_date'] != '0000-00-00'){$issue_date=$this->Base->change_date_dmy($r['issue_date']);}else{$issue_date='';}
                        ?>
                            <tr >
                                <td><?php echo $i;?></td>
                                <td title="<?php echo $r['coil_test_d'];?>"> <input type="checkbox" <?php if(in_array($r['coil_no'], $rod)){echo "checked";}?>  name='coilId' value="<?php echo $r['coil_no'];?>"> </td>
                                <td><?php echo $r['coil_no'];?></td>
                                <td><?php echo $r['heat_no'];?></td>
                                <td><?php echo $r['finish_size'];?></td>
                                <td><?php echo $r['breaking_load'];?></td>

                                <td  style="background-color:<?php echo $r['bl_color'];?>;color:white;"><?php echo $r['bl_category'];?></td>
                                <td><?php echo $r['torsion_test'];?></td>
                                <td><?php echo $r['bend_test'];?></td>
                                <td><?php echo $r['ra_per'];?></td>
                                <td><?php echo $r['rdarea'];?></td>
                            </tr>
                        <?php
                        $i++;
                    }
                ?>
            </table>

            <script>
                function handleCheckboxClick(checkbox) {
                    let checkedBox = Array.from(document.querySelectorAll("input[type=checkbox][name=coilId]:checked"), e => e.value);
                    //console.log(checkedBox);
                    $('#useRodList').val(checkedBox);
                }

                // Get all checkboxes with name='coilId' and add onclick event listener
                document.getElementsByName('coilId').forEach(function(checkbox) {
                    checkbox.addEventListener('click', function() {
                        handleCheckboxClick(this);
                    });
                });

                
            </script>
        <?php
    }//function close




    public function fun_wire_rod_list_group_by_grade_size($result)
	{
        $totalArray= array();
        ?>
            <h4>Available Rod:</h4>
            <table border="1" width="100%">
                <tr style="background-color: #d4d5d6;">
                    <th>Sno</th>
                    <th>Size</th>
                    <th>Grade</th>
                    <th>No Of Rod</th>
                    <th>Rod List</th>
                </tr>
                <?php 
                    $i=1;
                    foreach($result as $r){
                        if(isset($r['issue_date']) && $r['issue_date'] != '0000-00-00'){$issue_date=$this->Base->change_date_dmy($r['issue_date']);}else{$issue_date='';}
                        ?>
                            <tr >
                                <td><?php echo $i;?></td>
                                <td><?php echo $r['finish_size'];?></td>
                                <td><?php echo $r['gname'];?></td>
                                <td><?php echo $totalArray[]=  $r['nos'];?></td>
                                <td><?php echo $r['coil_numbers'];?></td>
                            </tr>
                        <?php
                        $i++;
                    }
                ?>
                <tr >
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td><?php if(!empty($totalArray))echo array_sum($totalArray);?></td>
                    <td></td>
                </tr>
            </table>

           
        <?php
    }//function close

  













}//class close



