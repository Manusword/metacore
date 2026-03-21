<?php
class Customermodel extends CI_Model
{
	//GST
	public function check_customer_gst($gst)
	{
        $sql = "SELECT * FROM customer where gst_no='$gst'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //customer details 
    public function get_customer_with_id($id)
	{
        $sql = "SELECT * FROM customer where id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //all customer list
    public function get_all_active_customer()
    {
        $sql = "SELECT * FROM customer WHERE  status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return  $query->result_array();
    }//function close


    //all sales_person list
    public function get_all_sales_person_customer()
    {
        $sql = "SELECT sales_person FROM customer WHERE  1=1 GROUP BY sales_person ORDER by sales_person ASC ";
        $query = $this->db->query($sql);
        return  $query->result_array();
    }//function close

    
    
    
    //customer rate 
    public function get_customer_rate_with_id($id)
	{
        $sql = "SELECT * FROM customer_rate where customer_id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_customer_product_rate($customer_id,$product_id)
	{
        $sql = "SELECT * FROM customer_rate where customer_id='$customer_id' and product_id='$product_id'  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['rate'];}else{return '';}
    }//function close

    public function get_customer_product_rate_detials($customer_id,$product_id)
	{
        $sql = "SELECT * FROM customer_rate where customer_id='$customer_id' and product_id='$product_id'  ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close



    //customer rate detele 
    public function customer_rate_delete($id)
	{
        $where9=array('customer_id'=>"$id");   
		$this->Mymodel->deletedata('customer_rate',$where9);
    }//function close



    //customer search
    public function get_all_customer_with_search($search)
	{
        $sql="SELECT * FROM customer WHERE 1=1  $search ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //customer comp compl search 
    public function get_all_cust_comp_with_search($search)
    {
        $sql="  SELECT 
                A.*, C.name as cname
                FROM customer_complain as A
                LEFT join customer as C on C.id = A.customer_name
                WHERE 1=1  $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //customer comp photo with comp_id
    public function get_all_cust_comp_photo_with_comp_id($customer_id,$comp_id)
    {
       $folder = "pic/complaint/$customer_id/$comp_id/";

        if (is_dir($folder)) {
            $images = glob($folder . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

            if (!empty($images)) {
                foreach ($images as $imgPath) {
                    $imgURL = base_url($imgPath);
                    echo '<div style="display:inline-block; margin:10px;">
                            <a href="' . $imgURL . '" target="_blank">
                                <img src="' . $imgURL . '" width="150" height="100" 
                                    style="object-fit:cover; border:1px solid #ccc;" />
                            </a>
                        </div>';
                }
            } else {
                echo "<p>No images found in folder.</p>";
            }
        } else {
            echo "<p>Folder not found: $folder</p>";
        }
       
    }//function close

     //customer comp photo
    public function get_all_cust_comp_photo($customer_id)
    {
        $base_folder = "pic/complaint/$customer_id/";

        if (is_dir($base_folder)) {
            // Get all subfolders (comp_id folders)
            $folders = array_filter(glob($base_folder . '*'), 'is_dir');

            if (!empty($folders)) {
                foreach ($folders as $folderPath) {
                    $comp_id = basename($folderPath); // folder name

                    $where =" and comp_id ='$comp_id' ";
                    $cus_data = $this->Customermodel->get_all_cust_comp_with_search($where);
                    if(isset($cus_data[0]['complain_date']) and $cus_data[0]['complain_date'] != '0000-00-00'){$complain_date=$this->Base->change_date_dmy($cus_data[0]['complain_date']);}else{$complain_date='';}
                    if(isset($cus_data[0]['status']) ){$status=$cus_data[0]['status'];}else{$status='';}
                    if(isset($cus_data[0]['defect_qty']) ){$defect_qty=$cus_data[0]['defect_qty'];}else{$defect_qty='';}
                     if(isset($cus_data[0]['defect_unit']) ){$defect_unit=$cus_data[0]['defect_unit'];}else{$defect_unit='';}
                    
                    echo "<h5 style='margin-top:20px;'>Complain Date: $complain_date, Status: $status, Defect Qty: $defect_qty $defect_unit;</h5>";

                    // Get all images in this folder
                    $images = glob($folderPath . "/*.{jpg,jpeg,png,gif}", GLOB_BRACE);

                    if (!empty($images)) {
                        foreach ($images as $imgPath) {
                            $imgURL = base_url($imgPath);
                            echo '<div style="display:inline-block; margin:10px;">
                                    <a href="' . $imgURL . '" target="_blank">
                                        <img src="' . $imgURL . '" width="150" height="100" 
                                            style="object-fit:cover; border:1px solid #ccc;" />
                                    </a>
                                </div>';
                        }
                    } else {
                        echo "<p>No images found in folder: $comp_id</p>";
                    }
                }
            } else {
                echo "<p>No complaint folders found for customer ID: $customer_id</p>";
            }
        } else {
            echo "<p>Customer folder not found: $base_folder</p>";
        }
    }






























    //financial year
    public function get_financial_year_last_bill()
    {
        $sql = "SELECT fin_year FROM  cr_dr_master  WHERE 1=1 ORDER BY entry_date DESC LIMIT 1   ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['fin_year'];}else{return "";}
    }//function close

    //cr_dr_master details with id
    public function get_cr_dr_master_with_id($id)
	{
        $sql = " SELECT  
                A.cr_dr_id,A.entry_date,A.customer_id,A.invoice_no,A.debit_amount,A.credit_amount,A.rem_amount,A.payment_date,A.remarks, 
                C.name as cname
				FROM cr_dr_master as A
				LEFT join customer as C on C.id = A.customer_id
				WHERE A.cr_dr_id = '$id'   ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


     //-------------------------------------------------------------cheque details with id
     public function get_cr_advance_cheque_with_id($id)
     {
         $sql = " SELECT  
                 A.*,
                 C.name as cname
                 FROM cr_advance_cheque as A
                 LEFT join customer as C on C.id = A.customer_id
                 WHERE A.id = '$id'   ";
         $query = $this->db->query($sql);
         return $query->result_array();
     }//function close
     //debit search 
    public function get_all_cr_advance_cheque_with_search($search)
    {
        $sql="  SELECT 
                A.*, C.name as cname
                FROM cr_advance_cheque as A
				LEFT join customer as C on C.id = A.customer_id
                WHERE 1=1 and A.cheque_no != '' $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //--------------------------------------------------------------------debit search 
    public function get_all_debit_with_search($search)
    {
        $sql="  SELECT 
                A.cr_dr_id,A.entry_date,A.customer_id,A.debit_amount,A.invoice_no,A.fin_year,A.remarks, C.name as cname
                FROM cr_dr_master as A
				LEFT join customer as C on C.id = A.customer_id
                WHERE 1=1 and A.debit_amount != '' $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //debit with date
    public function get_total_debit_amount_in_rs_datewise($data,$from_date,$to_date)
	{
        $sql="  SELECT sum(A.debit_amount) as total_rs
                FROM cr_dr_master as A 
                WHERE  A.entry_date between '$from_date' and '$to_date'  ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close

    //credit search 
    public function get_all_credit_with_search($search)
    {
        $sql="  SELECT 
                A.cr_dr_id,A.entry_date,A.invoice_no,A.payment_date,A.customer_id,A.credit_amount,A.remarks, C.name as cname
                FROM cr_dr_master as A
				LEFT join customer as C on C.id = A.customer_id
                WHERE 1=1 and A.credit_amount != '' $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //credit with date
    /*
    public function get_total_credit_amount_in_rs_datewise($data,$from_date,$to_date)
	{
        $sql="  SELECT sum(A.credit_amount) as total_rs
                FROM cr_dr_master as A 
                WHERE  A.payment_date  between '$from_date' and '$to_date'  ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close
    */


    public function get_total_credit_amount_in_rs_datewise($data,$from_date,$to_date)
	{
        $sql="  SELECT sum(A.paid_amt) as total_rs
                FROM cr_dr_paid_amt_history as A 
                WHERE  A.paid_date  between '$from_date' and '$to_date'  ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close


    //credit search 
    public function get_all_credit_with_search2($search)
    {
        $sql="  SELECT 
                A.cr_dr_id,A.payment_date,A.customer_id,
                sum(A.credit_amount) as credit_amount
                FROM cr_dr_master as A
				WHERE 1=1 and A.credit_amount != '' $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //credit search 
    public function get_all_credit_history_with_search($search)
    {
            $sql="  SELECT 
                A.cr_dr_id,B.paid_date as payment_date,A.customer_id,A.invoice_no,
                B.paid_amt as credit_amount,
                C.name as cname
                
                
                FROM cr_dr_paid_amt_history as B
                LEFT join cr_dr_master as A on A.cr_dr_id = B.cr_dr_master_id
                LEFT join customer as C on C.id = A.customer_id
				WHERE 1=1  $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close






    //credit & debit search 
    public function get_all_cr_dr_with_search($search)
    {
        $sql="  SELECT 
                A.cr_dr_id,A.entry_date,A.day_limit,A.last_date,A.notifi_date,A.customer_id,
                A.invoice_no,A.debit_amount,A.credit_amount,A.payment_date,A.rem_amount, A.remarks,  
                C.name as cname,C.sales_person
                FROM cr_dr_master as A
                LEFT join customer as C on C.id = A.customer_id
                WHERE 1=1  $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //popup payment history
    public function get_rem_payment_history_search($search)
    {
        $sql="  SELECT 
                A.cr_dr_id,A.entry_date,A.day_limit,A.last_date,A.notifi_date,A.customer_id,
                A.invoice_no,A.debit_amount,A.credit_amount,A.payment_date,A.rem_amount, A.remarks, 
                C.name as cname
                FROM cr_dr_master as A
                LEFT join customer as C on C.id = A.customer_id
                WHERE 1=1   $search  
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    
    


    


    //Flow up search 
    public function get_cus_flowup_with_search($search)
    {
        $today_date = date('Y-m-d');
        $sql="  SELECT 
                
                A.cr_dr_id,A.entry_date,A.customer_id,A.remarks,C.email,C.con_email1,C.con_email2,
                
                sum(A.rem_amount) as  rem_amount,
                
                (SELECT sum(X.rem_amount)  FROM cr_dr_master  as X
                    WHERE  X.last_date < '$today_date' and X.customer_id = A.customer_id   
                    GROUP BY X.customer_id) as redzone_amt,

                (SELECT sum(Y.rem_amount)  FROM cr_dr_master  as Y
                WHERE  Y.notifi_date <= '$today_date' and Y.last_date >= '$today_date'   and Y.customer_id = A.customer_id   
                GROUP BY Y.customer_id) as orangezone_amt,

                (SELECT sum(Z.rem_amount)  FROM cr_dr_master  as Z
                WHERE  Z.notifi_date > '$today_date'   and Z.customer_id = A.customer_id  
                GROUP BY Z.customer_id) as greenzone_amt,


                (SELECT count(CQ.id)  FROM cr_advance_cheque  as CQ WHERE  CQ.customer_id = A.customer_id  GROUP BY CQ.customer_id) as cheque_no,

                
                C.name as cname,C.limit_of_days,C.limit_of_dis,C.sales_person,C.follow_up_date,C.telphone,C.con_name1,C.con_mob1,C.con_name2,C.con_mob2,C.disputed_issue
                
                FROM cr_dr_master as A
                LEFT join customer as C on C.id = A.customer_id
                
                WHERE 1=1  $search    GROUP BY A.customer_id ORDER by C.name ASC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    

    
    //red zone amount
    public function get_red_payment_groupby_date($fdate,$tdate,$customer_id,$group)
    {
        if($group == "NO"){$group_val = "";}else{$group_val = "GROUP BY $group"; }
        
        if($customer_id == 'ALL'){
            $sql="  SELECT last_date,sum(A.rem_amount) as  rem_amount  
            FROM cr_dr_master as A 
            WHERE  A.last_date between '$fdate' and '$tdate'  $group_val   ";
        }
        else{
          
            $sql="  SELECT last_date,sum(A.rem_amount) as  rem_amount  
            FROM cr_dr_master as A 
            WHERE  A.customer_id = '$customer_id' and  A.last_date between '$fdate' and '$tdate'    $group_val  ";
        }
        
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close
    
 
    //red zone amount
    public function get_red_zone_payment_within_date($customer_id)
    {
        //$search_date = $this->Base->change_date_ymd($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),"-$days"));
        $today_date = date('Y-m-d');
        
        if($customer_id == 'ALL'){
            $sql="  SELECT sum(A.rem_amount) as  rem_amount  
            FROM cr_dr_master as A 
            LEFT join customer as C on C.id = A.customer_id
            WHERE   C.show_in_follow_up >0 and A.last_date < '$today_date'  ";
        }
        else{
            $sql="  SELECT sum(A.rem_amount) as  rem_amount
            FROM cr_dr_master as A WHERE  A.last_date < '$today_date' and A.customer_id = '$customer_id'   GROUP BY A.customer_id 
            ";
        }
        
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['rem_amount'];}else{return 0;}
    }//function close

    


    public function get_orange_payment_groupby_date($fdate,$tdate,$customer_id,$group)
    {
        if($group == "NO"){$group_val = "";}else{$group_val = "GROUP BY $group"; } 

        if($customer_id == 'ALL'){
            $sql="  SELECT notifi_date,sum(A.rem_amount) as  rem_amount  
            FROM cr_dr_master as A 
            WHERE  A.notifi_date between '$fdate' and '$tdate'  $group_val   ";
        }
        else{
            $sql="  SELECT notifi_date,sum(A.rem_amount) as  rem_amount
            FROM cr_dr_master as A WHERE  A.customer_id = '$customer_id' and  A.notifi_date between '$fdate' and '$tdate' $group_val ";
        }
        
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close


    //orange zone amount
    public function get_orange_zone_payment_within_date($customer_id)
    {
        //$search_date = $this->Base->change_date_ymd($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),"-$days"));
        $today_date = date('Y-m-d');
        
        if($customer_id == 'ALL'){
            $sql= "SELECT sum(Y.rem_amount) as  rem_amount  
            FROM cr_dr_master  as Y
            LEFT join customer as C on C.id = Y.customer_id
            WHERE  C.show_in_follow_up >0 and  Y.notifi_date <= '$today_date' and Y.last_date >= '$today_date'     ";
        }
        else{
            $sql= "SELECT sum(Y.rem_amount) as  rem_amount  FROM cr_dr_master  as Y
            WHERE  Y.notifi_date <= '$today_date' and Y.last_date >= '$today_date'   and Y.customer_id = '$customer_id'   
            GROUP BY Y.customer_id ";
        }
        
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['rem_amount'];}else{return 0;}
    }//function close


    //Green zone amount
    public function get_green_zone_payment_within_date($customer_id)
    {
        //$search_date = $this->Base->change_date_ymd($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),"-$days"));
        $today_date = date('Y-m-d');
        
        if($customer_id == 'ALL'){
            $sql= "SELECT sum(Z.rem_amount) as  rem_amount  FROM cr_dr_master  as Z
            LEFT join customer as C on C.id = Z.customer_id
            WHERE C.show_in_follow_up >0 and  Z.notifi_date > '$today_date'      ";
        }
        else{
            $sql= "SELECT sum(Z.rem_amount) as  rem_amount  
            FROM cr_dr_master  as Z
            WHERE   Z.notifi_date > '$today_date'   and Z.customer_id = '$customer_id'  
            GROUP BY Z.customer_id";
        }
        
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['rem_amount'];}else{return 0;}
    }//function close

    //get customer limit in day & amt
    public function get_customer_has_limtit($customer_id)
    {
        $sql= "SELECT limit_of_days,limit_of_dis  FROM customer where id='$customer_id' ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
        //if(!empty($res)){ return $res[0]['limit_of_dis'];}else{return 0;}
    }//function close

    //get customer limit status
    public function get_customer_amt_limtit_status($customer_id)
    {
        $cus = $this->get_customer_has_limtit($customer_id);
        if(!empty($cus) and $cus[0]['limit_of_dis']>0){ 
            $limit_amt = $cus[0]['limit_of_dis'];
           
            $redzone_amt = $this->get_red_zone_payment_within_date($customer_id);
            $orangezone_amt = $this->get_orange_zone_payment_within_date($customer_id);
            $greenzone_amt = $this->get_green_zone_payment_within_date($customer_id);

            $zone_total = round($redzone_amt + $orangezone_amt + $greenzone_amt);
            $limit_balance = round($limit_amt - $zone_total);
            if($limit_balance > 0){ $limit_text = $this->Base->money($limit_balance); $limit_color="green";}else{$limit_text = $limit_balance." Limit already exceeded"; $limit_color="red";}
            return array($limit_balance,$limit_text,$limit_color);         
        }else{
            return array('',"Customer limit is blank. Please enter","red");
        }
       
    }//function close



   //get_follow_up_his_search search 
   public function get_follow_up_his_search($search)
   {
       $sql="  SELECT 
               
               A.customer_id,A.entry_date,A.last_status,A.current_comments,A.next_follow_up_date, 
               
               C.name as cname
               
               FROM cr_dr_master_follow_up as A
               LEFT join customer as C on C.id = A.customer_id
               
               WHERE 1=1  $search  
           ";
       $query = $this->db->query($sql);
       return $query->result_array();
   }//function close


   //get_follow_up_no_on_date Dispatch Dashbord 
   public function get_follow_up_no_on_date($date)
   {
        $sql="  SELECT count(id) as nos FROM customer  WHERE follow_up_date <= '$date' and follow_up_date != '0000-00-00' ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['nos'];}else{return 0;}
   }//function close



   //payment receive history
   public function get_payment_receive_history($cr_dr_master_id)
   {
        $sql="  SELECT * FROM cr_dr_paid_amt_history  WHERE cr_dr_master_id ='$cr_dr_master_id' ORDER BY paid_date ";
        $query = $this->db->query($sql);
        $out2 = $query->result_array();
        if(!empty($out2)){ 
            foreach($out2 as $o){
                $paid_amt = $this->Base->money($o['paid_amt']);
                $paid_date = $this->Base->change_date_dmy($o['paid_date']);
                echo "Rs. $paid_amt/- on $paid_date, ";
                echo "<br>";
            }
        }
   }//function close




    //get red payment start date
    public function get_due_date_start_from($customer_id,$filters)
    {
        $today_date = date('Y-m-d');
        $sql="  SELECT 
                A.last_date,A.rem_amount FROM cr_dr_master as A
                WHERE A.customer_id = '$customer_id' and A.rem_amount>0 and  A.last_date < '$today_date' and A.rem_amount > 1  ORDER by A.entry_date ASC LIMIT 1
            ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(!empty($result)){
            return $result[0]['last_date'];
        }
         
    }//function close




    //payment history in table 
    public function get_payment_history_with_table($customer_id,$filters)
    {
        
        $today_date = date('Y-m-d');
        $filter = strtoupper($filters[0]);
        if(isset($filters[1])){$table = strtoupper($filters[1]);}else{$table = strtoupper("table");}
        $heading ="Balance Payment History";
        $due_date_column = "Overdue Days";
        if($filter == strtoupper("All Invoices")){
            //all 
            $where=" and A.customer_id = '$customer_id'  ORDER by A.entry_date,invoice_no ASC ";
        }
        else if($filter == strtoupper("red rem amt")){
            $where=" and A.customer_id = '$customer_id' and A.rem_amount>0 and  A.last_date < '$today_date'   ORDER by A.entry_date,invoice_no ASC ";
        }
        else if($filter == strtoupper("orange rem amt")){
            $where=" and A.customer_id = '$customer_id' and A.rem_amount>0 and  A.notifi_date <= '$today_date' and A.last_date >= '$today_date'  ORDER by A.entry_date,invoice_no ASC ";
            $heading ="Upcoming Week Payment";
            $due_date_column="No of Day's left";
        }
        else if($filter == strtoupper("date wise")){
            //-------from party amt date wise
            if(!empty($filters['search_date'])){
                $search_date = $filters['search_date'];
                $heading = $this->Base->change_date_dmy($search_date);
                $party_show = 1;
                if($customer_id == 'ALL'){
                     $where="  and  A.notifi_date = '$search_date' OR A.last_date = '$search_date'  ORDER by A.entry_date,invoice_no ASC ";
                }
                else{
                    $where=" and A.customer_id = '$customer_id'  and  (A.notifi_date = '$search_date' OR A.last_date = '$search_date')  ORDER by A.entry_date,invoice_no ASC ";
                }
            }
            if(!empty($filters['fdate']) and !empty($filters['tdate'])){
                $fdate = $filters['fdate'];
                $tdate = $filters['tdate'];
                $party_show = 1;
                $heading = $this->Base->change_date_dmy($fdate).' To '.$this->Base->change_date_dmy($tdate);
                if($customer_id == 'ALL'){
                    $where="  and  A.last_date between '$fdate' and '$tdate'  ORDER by A.entry_date,invoice_no ASC ";
               }
               else{
                   $where=" and A.customer_id = '$customer_id' and  A.last_date between '$fdate' and '$tdate'  ORDER by A.entry_date,invoice_no ASC ";
               }
               
            }
           
        }
        else{
            //all 
            $where=" and A.customer_id = '$customer_id'  ORDER by A.entry_date,invoice_no ASC ";
        }
        
        
        
       
        
        $out2 = $this->Customermodel->get_rem_payment_history_search($where);
        if($table == strtoupper("table"))
        {
            ?>
                                <h5 align="left"><?php echo $heading;?></h5>	
								<table class="table-hover" border=1  style="font-size:12px; width:100%" >
									<tr>
										<th>#</th>
										<th>Invoice No</th>
                                        <?php if(!empty($party_show)){?> <th>Party</th> <?php }?>
										<th>Billing Date</th>
										<th>Day Limit</th>
										<th>Reminder Date</th>
										<th>Last Date</th>
										<th>Bill Amt.</th>
										<th>Paid Amt.</th>
                                        <th>Paid Day</th>
										<th>Rem. Amt.</th>
										<th><?php echo $due_date_column;?></th>
										<th>Interest @24% p.a.
                                            <?php 
                                            // if($filter == strtoupper("red rem amt")){
                                            //     echo " Interest @24% p.a.";
                                            // }else{
                                            //     echo "Remarks";
                                            // }
                                            ?>
                                        </th>
									</tr>
									<?php 
										$i=1;
										$debit_amount_arr = array();
										$cr_amount_arr = array();
										$rem_amount_arr = array();
                                        $interest_arr = array();
										$today_date = date('Y-m-d');
										foreach($out2 as $r)
										{
											if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
											if(isset($r['last_date'])){$last_date=$this->Base->change_date_dmy($r['last_date']);}else{$last_date='';}
											if(isset($r['notifi_date'])){$notifi_date=$this->Base->change_date_dmy($r['notifi_date']);}else{$notifi_date='';}
											if(isset($r['payment_date']) and $r['payment_date']!='0000-00-00'){$payment_date=$this->Base->change_date_dmy($r['payment_date']);}else{$payment_date='';}
											
											$text_color = "black";
                                            if($today_date > $r['last_date']){$text_color = "red";}
											else if($today_date >= $r['notifi_date'] and $today_date <= $r['last_date'] ){$text_color = "orange";}
											else if($today_date < $r['notifi_date']  ){$text_color = "green";}
											else{$text_color = "black";}

                                            $note_color = "black";
                                            if(!empty($search_date)  and $search_date == $r['notifi_date']){$note_color = "orange";}
                                            $last_color = "black";
                                            if(!empty($search_date)  and $search_date == $r['last_date']){$last_color = "red";}
											?>
												<tr>
													<td><?php echo $i;?></td>
													<td><?php if(isset($r['invoice_no']))echo $r['invoice_no'];?></td>
                                                    <?php if(!empty($party_show)){?> <td><?php if(isset($r['cname']))echo $r['cname'];?></td> <?php }?>
													<td><?php if(isset($entry_date))echo $entry_date;?></td>
													<td><?php if(isset($r['day_limit']))echo $r['day_limit'];?></td>
													<td style="color:<?php echo $note_color;?>;"><?php if(isset($notifi_date))echo $notifi_date;?></td>
													<td style="color:<?php echo $last_color;?>;"><?php if(isset($last_date))echo $last_date;?></td>
													
													<td style="color:<?php echo $text_color;?>;font-weight:bold">
													    <?php if(!empty($r['debit_amount'])) $debit_amount_arr[] = round($r['debit_amount'],2);echo  $this->Base->money($r['debit_amount']);?>
													</td>
													<td>
														<?php if(!empty($r['debit_amount'])) $cr_amount_arr[] = round($r['credit_amount'],2);echo  $this->Base->money($r['credit_amount']);?>
													</td>
                                                    <td><?php if(isset($payment_date))echo $payment_date;?></td>

													<td style="color:<?php echo $text_color;?>;font-weight:bold">
													    <?php if(!empty($r['rem_amount'])) $rem_amount_arr[] = round($r['rem_amount'],2);echo  $this->Base->money($r['rem_amount']);?>
													</td>
													
													<th align="center" style="color:<?php echo $text_color;?>">
                                                        <?php 
                                                            if(!empty($r['rem_amount']) and $r['rem_amount'] > 0){
                                                                if(isset($r['last_date'])){echo $overDays = $this->Base->get_diff_no_bw_two_days($r['last_date'],$today_date);}
                                                            }
                                                        ?>
                                                    </th>
													<th align="left" style="color:<?php echo $text_color;?>"><?php //if(isset($r['remarks']))echo $r['remarks'];?>
                                                    <?php 
                                                        // Interest to be charged.
                                                        if(!empty($r['rem_amount']) and $r['rem_amount'] > 1 and $overDays > 0 and $today_date > $r['last_date']){
                                                            $interest_arr[] = $int_amt = round(((($r['rem_amount']*24)/100)/365)*$overDays);
                                                            echo $this->Base->money($int_amt);
                                                        }
                                                        ?>
                                                    </th>
												<tr>
											<?php
											$i++; 
										}
									?>
									 <tr style="font-weight:bold">
										<td></td>
										<td>Total</td>
                                        <?php if(!empty($party_show)){?> <td></td> <?php }?>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td style="color:red"><?php if(!empty($debit_amount_arr)){ $a = round(array_sum($debit_amount_arr),2);  echo  $this->Base->money($a);}?></td>
										<td><?php if(!empty($cr_amount_arr)) {$b = round(array_sum($cr_amount_arr),2);  echo  $this->Base->money($b);}?></td>
										<td></td>
                                        <td style="color:red"><?php if(!empty($rem_amount_arr)) {$c = round(array_sum($rem_amount_arr),2);  echo  $this->Base->money($c);}?></td>
                                        <td></td>
                                        <td style="color:red"><?php if(!empty($interest_arr)){ $total_interest_amt = round(array_sum($interest_arr),2);  echo  $this->Base->money($total_interest_amt);}?></td>
                                    <tr>
								</table>
            <?php
            if(!empty($rem_amount_arr)) {return array_sum($rem_amount_arr);}else{return 0;}
        }//table
        elseif($table == strtoupper("return ans"))
        {
            //list
            return $out2;
        }
        else{

        }
        
    }//function close



















   
    //----------------------------------------------------Chart Dispatch DASHBOARD
    public function cust_follow_up_chart($year,$month,$div_length)
    {
        $today_date = date('Y-m-d');
        $tomorrow_date = $this->Base->change_date_ymd($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),'1'));
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $from_date_last_month = $this->Base->get_last_full_date_of_lastmonth_fd_ymd($month,$year);
        $to_date_last_month = $this->Base->get_last_full_date_of_lastmonth_td_ymd($month,$year);
        
        $url =  base_url()."index.php/Welcome/home?Customer/cus_payment_flowup_list/$today_date";
       
        ?>
             <div class="row">
                <!-- Row-->
                    <div class="col-md-2 col-lg-3">
                        <div class="card mb-2 o-hidden">
                            <div class="card-body">
                            <a href="<?php echo $url;?>">
                                <div class="row">
                                    <div class="col-4">
                                        <h5 class="t-font-bolder">Today Follow Up </h5>
                                    </div>
                                    <div class="col-8 text-right">
                                        <h3 class="t-font-boldest"><?php  echo round($this->get_follow_up_no_on_date($today_date));?></h3>
                                    </div>
                                    
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                


                <div class="col-md-2 col-lg-3">
                    <div class="card mb-2 o-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <h5 class="t-font-bolder" style='Color:red'>Payment in Red Zone (Rs.)</h5>
                                </div>
                                <div class="col-8 text-right">
                                    <h3 class="t-font-boldest" style='Color:red'><?php  echo $this->Base->money(($this->get_red_zone_payment_within_date('ALL')));?></h3>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-lg-3">
                    <div class="card mb-2 o-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <h5 class="t-font-bolder" style='Color:orange'>Payment in Orange Zone (Rs.)</h5>
                                </div>
                                <div class="col-8 text-right">
                                    <h3 class="t-font-boldest" style='Color:orange'><?php  echo $this->Base->money(($this->get_orange_zone_payment_within_date('ALL')));?></h3>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-2 col-lg-3">
                    <div class="card mb-2 o-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <h5 class="t-font-bolder" style='Color:green'>Payment in Green Zone (Rs.)</h5>
                                </div>
                                <div class="col-8 text-right">
                                    <h3 class="t-font-boldest" style='Color:green'><?php  echo $this->Base->money(($this->get_green_zone_payment_within_date('ALL')));?></h3>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row-->
            </div>
        <?php
    }//function close







}//class close



