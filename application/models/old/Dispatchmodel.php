<?php
class Dispatchmodel extends CI_Model
{
	//get all data form customer_schedule with id
	public function get_customer_schedule_data_with_id($id)
	{
        $sql = "SELECT * FROM customer_schedule where schedule_id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get all data form customer_schedule details with id
	public function get_customer_schedule_details_data_with_id($id)
	{
        $sql = "SELECT * FROM customer_schedule_details where schedule_id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get all data form customer_schedule details with  details-id
	public function get_customer_schedule_details_data_with_details_id($details_id)
	{
        $sql = "SELECT * FROM customer_schedule_details where details_id = '$details_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get customer PO no from   details-id
	public function get_customer_po_no_details_id($details_id)
	{
        $sql = "SELECT A.customer_po FROM customer_schedule as A 
        LEFT JOIN customer_schedule_details as B ON B.schedule_id = A.schedule_id
        WHERE  B.details_id = '$details_id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get all data form customer_schedule details with customer id
	public function get_customer_schedule_list($customer_id,$today_date1,$today_date2)
	{
        $sql = "SELECT A.schedule_id,A.customer_po FROM customer_schedule as A 
                LEFT JOIN customer_schedule_details as B ON B.schedule_id = A.schedule_id
                WHERE A.customer_id='$customer_id' and   A.stage='0' and A.status='Active'  and B.from_date between '$today_date1' and '$today_date2' GROUP BY A.schedule_id   ORDER by A.schedule_id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //get all data form customer_schedule details with schedule  id
	public function get_customer_schedule_list_with_schedule_id($schedule_id,$today_date1,$today_date2)
	{
        $sql = "SELECT * FROM customer_schedule_details
                WHERE schedule_id='$schedule_id' and stage='0' and from_date between '$today_date1' and '$today_date2' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    



    //Schedule search
    public function schedule_serach_query($search)
    {
        $sql="
                SELECT 
                            
                A.schedule_id,A.customer_po,A.customer_po_date,A.customer_po,A.plan_remarks,A.customer_id,A.actual_month,
                B.stage,B.from_date,B.to_date,
                C.name as cname
                
                FROM customer_schedule as A 
                
                LEFT JOIN customer_schedule_details as B ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id=A.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                
                WHERE 1=1 $search
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //Schedule search
    public function schedule_serach_query2($search)
    {
        $sql="
                SELECT 
                            
                A.product_id,A.rate,A.order_qty,A.unit,A.forecast_qty,A.amt,A.send_qty,A.send_amt,A.plan_remarks,A.stage,A.from_date,A.to_date,
                B.schedule_id,B.customer_po,B.customer_po_date,B.plan_remarks,B.customer_id,B.schedule_save_date,
                C.name as cname,C.area_location,C.sales_person,
                P.name as pname,
                G.name as grade_name
                    
                FROM customer_schedule_details  as A 
                
                LEFT JOIN customer_schedule as B ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id = B.customer_id
                LEFT JOIN product P ON P.product_id = A.product_id
                LEFT JOIN product_grade G ON G.id = A.product_grade
                
                WHERE 1=1 $search
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //total sch vs supply qty
    public function get_sch_vs_sup_qty($data,$from_date,$to_date)
	{
        $sql="  SELECT 
                sum(A.order_qty) as order_qty, sum(A.send_qty) as send_qty,
                sum(A.amt) as order_amt, sum(A.send_amt) as send_amt
                FROM customer_schedule_details  as A 
                LEFT JOIN customer_schedule as B ON B.schedule_id = A.schedule_id
                WHERE  A.from_date between '$from_date' and '$to_date' and  B.type_of_bill='Tax Invoice'
                  ";
        $query = $this->db->query($sql); //cancel bill amt also inclue
        return $res = $query->result_array();
    }//function close



    //total sch vs supply qty
    public function get_sch_vs_sup_grade($from_date,$to_date)
    {
        $sql="  SELECT 
                P.name as product_name,G.name as grade_name,sum(A.forecast_qty) as forecast_qty, sum(A.order_qty) as order_qty, sum(A.send_qty) as send_qty,
                sum(A.amt) as order_amt, sum(A.send_amt) as send_amt,A.product_id,A.unit,C.sales_person
                FROM customer_schedule_details  as A 
                LEFT JOIN customer_schedule as B ON B.schedule_id = A.schedule_id
                LEFT JOIN product as P ON P.product_id = A.product_id
                LEFT JOIN product_grade as G ON G.id = A.product_grade
                LEFT JOIN customer as C ON C.id = B.customer_id
                WHERE  A.from_date between '$from_date' and '$to_date' and  B.type_of_bill='Tax Invoice'
                GROUP BY  P.product_id,A.product_grade ORDER BY sales_person,P.name,G.name
                ";
        $query = $this->db->query($sql); //cancel bill amt also inclue
        $res = $query->result_array();
        // print_r($res);
        ?>
            <div class="table-responsive">
                <table border=0 style="width:100%" id="printed_table">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Grade</th>
                            <th>Forecast Qty</th>
                            <th>Order Qty</th>
                            <th>Dispatch Qty</th>
                            <th>Rem Qty (Order - Dispatch)</th>
                            <th>Unit</th>
                        </tr>
                        
                        <?php
                            $i=1;
                            $total_nos = count($res);
                            $forecast_qty3 = array();$order_qty3 = array(); $send_qty3 = array(); $rem3 = array();
                            foreach($res as $r)
                            {
                                ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $r['product_name'];?></td>
                                        <td><?php echo $r['grade_name'];?></td>
                                        <td><?php echo $forecast_qty = round($r['forecast_qty'],2); $forecast_qty2[] = $forecast_qty; $forecast_qty3[] = $forecast_qty;?></td>
                                        <td><?php echo $order_qty = round($r['order_qty'],2); $order_qty2[] = $order_qty; $order_qty3[] = $order_qty;?></td>
                                        <td><?php echo $send_qty = round($r['send_qty'],2); $send_qty2[] = $send_qty; $send_qty3[] = $send_qty;?></td>
                                        <td><?php echo $rem = round($order_qty-$send_qty,2);  $rem2[] = $rem; $rem3[] = $rem; ?></td>
                                        <td><?php echo $r['unit'];?></td>
                                    </tr>
                                <?php
                                
                                
                                if($i<$total_nos  and $r['product_id'] != $res[$i]['product_id'])
                                {
                                    ?>
                                        <tr style="border-top: 1px solid black;font-weight:bold">
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td><?php if(!empty($forecast_qty2)){ echo round(array_sum($forecast_qty2),2);}?></td>
                                            <td><?php if(!empty($order_qty2)){ echo round(array_sum($order_qty2),2);}?></td>
                                            <td><?php if(!empty($send_qty2)){ echo round(array_sum($send_qty2),2);}?></td>
                                            <td><?php if(!empty($rem2)){ echo round(array_sum($rem2),2);}?></td>
                                            <td></td>
                                        </tr>
                                        <tr style="height:60px;">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    $forecast_qty2 = array();
                                    $order_qty2 = array();
                                    $send_qty2 = array();
                                    $rem2 = array();
                                }
                                $i++;
                            }
                        ?>
                        <tr style="height:60px;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            <tr style="border-top: 1px solid red;font-weight:bold">
                            <td>Grand Total</td>
                            <td></td>
                            <td></td>
                            <td><?php if(!empty($forecast_qty3)){ echo round(array_sum($forecast_qty3),2);}?></td>
                            <td><?php if(!empty($order_qty3)){ echo round(array_sum($order_qty3),2);}?></td>
                            <td><?php if(!empty($send_qty3)){ echo round(array_sum($send_qty3),2);}?></td>
                            <td><?php if(!empty($rem3)){ echo round(array_sum($rem3),2);}?></td>
                            <td></td>
                        </tr>
            </table>
        </div> 
        <?php
      }//function close




    //total sch vs supply qty
    public function get_sch_vs_sup_grade_sales_person($from_date,$to_date)
    {
            $sql="  SELECT sales_person from customer GROUP BY sales_person ";
            $query = $this->db->query($sql); //cancel bill amt also inclue
            $sales_person_list = $query->result_array();
            
            foreach($sales_person_list as $s)
            {
                ?>
                <div style="height:100px; width:100%;"></div>
                <h2 align="left" style="background-color:pink;"><?php echo $sales_person = $s['sales_person'];?></h2>
                <?php 
                    $sql="  SELECT 
                            P.name as product_name,G.name as grade_name,sum(A.forecast_qty) as forecast_qty, sum(A.order_qty) as order_qty, sum(A.send_qty) as send_qty,
                            sum(A.amt) as order_amt, sum(A.send_amt) as send_amt,A.product_id,A.unit,C.sales_person
                            FROM customer_schedule_details  as A 
                            LEFT JOIN customer_schedule as B ON B.schedule_id = A.schedule_id
                            LEFT JOIN product as P ON P.product_id = A.product_id
                            LEFT JOIN product_grade as G ON G.id = A.product_grade
                            LEFT JOIN customer as C ON C.id = B.customer_id
                            WHERE  A.from_date between '$from_date' and '$to_date' and  B.type_of_bill='Tax Invoice' and C.sales_person ='$sales_person'
                            GROUP BY  P.product_id,A.product_grade ORDER BY P.name,G.name
                            ";
                    $query = $this->db->query($sql); //cancel bill amt also inclue
                    $res = $query->result_array();
                ?>
                    <div class="table-responsive">
                        <table border=0 style="width:100%" id="printed_table">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Grade</th>
                                    <th>Forecast Qty</th>
                                    <th>Order Qty</th>
                                    <th>Dispatch Qty</th>
                                    <th>Rem Qty</th>
                                    <th>Unit</th>
                                </tr>
                                
                                <?php
                                    $i=1;
                                    $total_nos = count($res);
                                    $forecast_qty3 = array();$order_qty3 = array(); $send_qty3 = array(); $rem3 = array();
                                    foreach($res as $r)
                                    {
                                        ?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $r['product_name'];?></td>
                                                <td><?php echo $r['grade_name'];?></td>
                                                <td><?php echo $forecast_qty = round($r['forecast_qty'],2); $forecast_qty2[] = $forecast_qty; $forecast_qty3[] = $forecast_qty;?></td>
                                                <td><?php echo $order_qty = round($r['order_qty'],2); $order_qty2[] = $order_qty; $order_qty3[] = $order_qty;?></td>
                                                <td><?php echo $send_qty = round($r['send_qty'],2); $send_qty2[] = $send_qty; $send_qty3[] = $send_qty;?></td>
                                                <td><?php echo $rem = round($order_qty-$send_qty,2);  $rem2[] = $rem; $rem3[] = $rem; ?></td>
                                                <td><?php echo $r['unit'];?></td>
                                            </tr>
                                        <?php
                                        
                                        
                                        if($i<$total_nos  and $r['product_id'] != $res[$i]['product_id'])
                                        {
                                            ?>
                                                <tr style="border-top: 1px solid black;font-weight:bold">
                                                    <td>Total</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?php if(!empty($forecast_qty2)){ echo round(array_sum($forecast_qty2),2);}?></td>
                                                    <td><?php if(!empty($order_qty2)){ echo round(array_sum($order_qty2),2);}?></td>
                                                    <td><?php if(!empty($send_qty2)){ echo round(array_sum($send_qty2),2);}?></td>
                                                    <td><?php if(!empty($rem2)){ echo round(array_sum($rem2),2);}?></td>
                                                    <td></td>
                                                </tr>
                                                <tr style="height:60px;">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php
                                            $forecast_qty2 = array();
                                            $order_qty2 = array();
                                            $send_qty2 = array();
                                            $rem2 = array();
                                        }
                                        $i++;
                                    }
                                ?>
                                <tr style="height:60px;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="border-top: 1px solid red;font-weight:bold">
                                    <td>Grand Total</td>
                                    <td></td>
                                    <td></td>
                                    <td><?php if(!empty($forecast_qty3)){ echo round(array_sum($forecast_qty3),2);}?></td>
                                    <td><?php if(!empty($order_qty3)){ echo round(array_sum($order_qty3),2);}?></td>
                                    <td><?php if(!empty($send_qty3)){ echo round(array_sum($send_qty3),2);}?></td>
                                    <td><?php if(!empty($rem3)){ echo round(array_sum($rem3),2);}?></td>
                                    <td></td>
                                </tr>
                    </table>
                </div> 
                <?php
            }//sales_person_list


            
    }//function close

    
































    //---------------------------------------------------------------Dispatch
    //get all data form customer_dispatch with id
	public function get_customer_dispatch_data_with_id($id)
	{
        $sql = "SELECT * FROM dispatch where dispatch_id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get all data form customer_dispatch details with id
	public function get_customer_dispatch_details_data_with_id($id)
	{
        $sql = "SELECT * FROM dispatch_details where dispatch_id = '$id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //get all data form customer_dispatch details with  details-id
	public function get_customer_dispatch_details_data_with_details_id($details_id)
	{
        $sql = "SELECT * FROM customer_schedule_details where dispatch_details_id = '$details_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get last bill gst per with customer id
	public function get_customer_last_gst_per_with_id($customer_id)
	{
        $sql = "SELECT sgst_per,cgst_per,igst_per,place_of_supply FROM dispatch WHERE customer_id='$customer_id' ORDER BY entry_date DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get last bill hsn per with customer id
	public function get_last_dispatch_from_product_hsn($product_id)
	{
        $sql = "SELECT hsn FROM dispatch_details WHERE product_id='$product_id' and hsn!='' ORDER BY dispatch_details_id DESC LIMIT 1  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get last bill unit per with customer id
	public function get_last_dispatch_from_product_unit($customer_id,$product_id)
	{
        $sql = "SELECT A.unit_name FROM dispatch_details as A 
                LEFT JOIN dispatch as B ON B.dispatch_id = A.dispatch_id
                WHERE A.unit_name!='' and A.product_id='$product_id' and B.customer_id='$customer_id' ORDER BY A.dispatch_details_id DESC LIMIT 1 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //next bill no for save
	public function get_next_bill_no($date)
	{
        $fin_year = $this->Company->get_fin_year();
	    $sql1=" SELECT max(dispatch_no) as dispatch_no FROM dispatch WHERE fin_year='$fin_year' ";
        $query1 = $this->db->query($sql1);
        $out1=$query1->result_array();
        if(!empty($out1))
        {
            $max_dispatch_no1 = $out1[0]['dispatch_no'];
            $max_dispatch_no1 = $max_dispatch_no1+1;
        }
        else
        {
            $max_dispatch_no1 = 1;
        }//if(!empty($res1))
        return $max_dispatch_no1;
    }//function close


    //next bill no for display
	public function get_next_bill_no_display($id)
	{
        $fin_year = $this->Company->get_fin_year();
	    $sql1=" SELECT dispatch_no,fin_year FROM dispatch WHERE dispatch_id='$id' ";
        $query1 = $this->db->query($sql1);
        $out1=$query1->result_array();
        if(!empty($out1))
        {
            $dispatch_no = $out1[0]['dispatch_no'];
            
            //fin year details
            $fin_year = $out1[0]['fin_year'];
            $sql1=" SELECT * FROM company_fin_year_code WHERE fin_year='$fin_year' ";
            $query1 = $this->db->query($sql1);
            $out2 = $query1->result_array();
            if(!empty($out2))
            {
                $start = $out2[0]['invoice_id_start_name'];
                $digit = $out2[0]['invoice_id_total_digit'];
                $end = $out2[0]['invoice_id_last_name'];
                $dispatch_no_full = $this->Base->convert_no_to_max_digit($dispatch_no,$digit); 
                return $start.$dispatch_no_full.$end;
            }// if(!empty($out2))
        }//if(!empty($out1))
        
    }//function close




    //Dispatch search
    public function dispatch_serach_query($search)
    {
        $sql="
                SELECT 
                            
                A.dispatch_id,A.customer_id,A.customer_schedule_id,A.entry_date,A.dispatch_no,A.transport_mode,A.vehicle_no,
                A.total,A.grandtotal,A.is_it_cancel,A.discount_offer,A.other_discount_per,A.tds_per,A.tds_val,A.grandtotal2,
                C.name as cname

                FROM dispatch as A
                
                LEFT JOIN dispatch_details as B ON B.dispatch_id = A.dispatch_id
                LEFT JOIN customer C ON C.id=A.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                
                WHERE 1=1 $search
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //Dispatch search
    public function dispatch_serach_group_customer_query($search)
    {
        $sql="
                SELECT 
                            
                sum(B.qty) as qty,
                C.name as cname,
                P.name as pname

                FROM  dispatch_details as B
                
                LEFT JOIN dispatch as A ON B.dispatch_id = A.dispatch_id
                LEFT JOIN customer C ON C.id=A.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                
                WHERE 1=1 $search
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close








    ///------------------------------------------------------------------dispatch table
    //state wise sales
    public function state_wise_sales($from_date,$to_date)
    {
        $sql="  SELECT  C.state,sum(B.qty) as qty
                FROM  dispatch_details as B
                LEFT JOIN dispatch as A ON B.dispatch_id = A.dispatch_id
                LEFT JOIN customer C ON C.id=A.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                WHERE A.entry_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice' and A.is_it_cancel=0  
                GROUP BY C.state  ORDER by C.state
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //company type sales
    public function company_type_wise_sales($from_date,$to_date)
    {
        $sql="  SELECT  C.type,sum(B.qty) as qty
                FROM  dispatch_details as B
                LEFT JOIN dispatch as A ON B.dispatch_id = A.dispatch_id
                LEFT JOIN customer C ON C.id=A.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                WHERE A.entry_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice' and A.is_it_cancel=0  
                GROUP BY C.type  ORDER by C.type
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close





    ///------------------------------------------------------------------schedule table
    //state wise sales
    public function state_wise_sales_schedule($from_date,$to_date)
    {
        $sql="  SELECT  C.state,sum(B.forecast_qty) as forecast_qty,sum(B.order_qty) as order_qty,sum(B.send_qty) as send_qty, sum(B.send_qty) as send_qty,sum(B.send_amt) as send_amt,P.size
               
                FROM  customer_schedule_details as B
                LEFT JOIN customer_schedule as A ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id=B.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                WHERE B.from_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice' 
                GROUP BY C.state  ORDER by C.state
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //company type sales
    public function company_type_wise_sales_schedule($from_date,$to_date)
    {
        $sql="  SELECT  C.type,sum(B.forecast_qty) as forecast_qty,sum(B.order_qty) as order_qty,sum(B.send_qty) as send_qty,sum(B.send_qty) as send_qty,sum(B.send_amt) as send_amt,P.size
                
                FROM  customer_schedule_details as B
                LEFT JOIN customer_schedule as A ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id=B.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                WHERE B.from_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice' 
                GROUP BY C.type  ORDER by C.type
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //sales_person sales 
    public function sales_person_wise_sales_from_schedule($from_date,$to_date)
    {
        $sql="  SELECT  C.sales_person,sum(B.forecast_qty) as forecast_qty,sum(B.order_qty) as order_qty,sum(B.send_qty) as send_qty,sum(B.send_qty) as send_qty,sum(B.send_amt) as send_amt,P.size
        
                FROM  customer_schedule_details as B
                LEFT JOIN customer_schedule as A ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id=B.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                WHERE B.from_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice' 
                GROUP BY C.sales_person  ORDER by C.sales_person
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //product sales 
    public function product_wise_sales_from_schedule($from_date,$to_date)
    {
        $sql="  SELECT  P.name as pname,sum(B.forecast_qty) as forecast_qty,sum(B.order_qty) as order_qty,sum(B.send_qty) as send_qty, sum(B.send_qty) as send_qty,sum(B.send_amt) as send_amt,P.size
                FROM  customer_schedule_details as B
                LEFT JOIN customer_schedule as A ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id=B.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                WHERE B.from_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice' 
                GROUP BY B.product_id  ORDER by P.name
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //custmer sales 
    public function customer_wise_sales_from_schedule($from_date,$to_date,$type)
    {
        $sql="  SELECT  C.name as cname,sum(B.forecast_qty) as forecast_qty,sum(B.order_qty) as order_qty,sum(B.send_qty) as send_qty, sum(B.send_qty) as send_qty,sum(B.send_amt) as send_amt,P.size
                FROM  customer_schedule_details as B
                LEFT JOIN customer_schedule as A ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id=B.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                WHERE B.from_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice'  and C.type='$type'
                GROUP BY B.customer_id  ORDER by C.name
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

   

    


    //grade sales 
    public function grade_wise_sales_from_schedule($from_date,$to_date)
    {
        $sql="  SELECT  G.name as gname,sum(B.forecast_qty) as forecast_qty,sum(B.order_qty) as order_qty,sum(B.send_qty) as send_qty, sum(B.send_qty) as send_qty,sum(B.send_amt) as send_amt,P.size
                FROM  customer_schedule_details as B
                LEFT JOIN customer_schedule as A ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id=B.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                LEFT JOIN product_grade G ON G.id=B.product_grade
                WHERE B.from_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice' 
                GROUP BY B.product_grade  ORDER by G.name
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //product_grade sales 
    public function product_grade_wise_sales_from_schedule_with_grade_id($grade_id,$from_date,$to_date)
    {
        $sql="  SELECT  P.name as pname,G.name as gname,sum(B.forecast_qty) as forecast_qty,sum(B.order_qty) as order_qty,sum(B.send_qty) as send_qty, sum(B.send_qty) as send_qty,sum(B.send_amt) as send_amt,P.size
                FROM  customer_schedule_details as B
                LEFT JOIN customer_schedule as A ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id=B.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                LEFT JOIN product_grade G ON G.id=B.product_grade
                WHERE B.from_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice'  and B.product_grade='$grade_id'
                GROUP BY B.product_id,B.product_grade  ORDER by P.name,G.name
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


     //product_grade sales 
     public function product_grade_wise_sales_from_schedule($from_date,$to_date)
     {
         $sql="  SELECT  P.name as pname,G.name as gname,sum(B.forecast_qty) as forecast_qty,sum(B.order_qty) as order_qty,sum(B.send_qty) as send_qty,sum(B.send_amt) as send_amt,P.size
                
                 FROM  customer_schedule_details as B
                 LEFT JOIN customer_schedule as A ON B.schedule_id = A.schedule_id
                 LEFT JOIN customer C ON C.id=B.customer_id
                 LEFT JOIN product P ON P.product_id=B.product_id
                 LEFT JOIN product_grade G ON G.id=B.product_grade
                 WHERE B.from_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice' 
                 GROUP BY B.product_id,B.product_grade  ORDER by P.name,G.name
             ";
         $query = $this->db->query($sql);
         return $query->result_array();
     }//function close


    //product_grade sales 
    public function grade_product_wise_sales_from_schedule($from_date,$to_date)
    {
        $sql="  SELECT  P.name as pname,G.name as gname,sum(B.forecast_qty) as forecast_qty,sum(B.order_qty) as order_qty,sum(B.send_qty) as send_qty,sum(B.send_qty) as send_qty,sum(B.send_amt) as send_amt,P.size
                FROM  customer_schedule_details as B
                LEFT JOIN customer_schedule as A ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id=B.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                LEFT JOIN product_grade G ON G.id=B.product_grade
                WHERE B.from_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice' 
                GROUP BY B.product_grade,B.product_id  ORDER by G.name,P.name
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //product_grade sales 
    public function sscp_wise_sales_from_schedule($from_date,$to_date)
    {
        $sql="  SELECT C.sales_person,C.state,C.name as cname,P.name as pname,G.name as gname,
                sum(B.forecast_qty) as forecast_qty,sum(B.order_qty) as order_qty,sum(B.send_qty) as send_qty,sum(B.send_qty) as send_qty,sum(B.send_amt) as send_amt,P.size
                FROM  customer_schedule_details as B
                LEFT JOIN customer_schedule as A ON B.schedule_id = A.schedule_id
                LEFT JOIN customer C ON C.id=B.customer_id
                LEFT JOIN product P ON P.product_id=B.product_id
                LEFT JOIN product_grade G ON G.id=B.product_grade
                WHERE B.from_date between '$from_date' and '$to_date'  and  A.type_of_bill='Tax Invoice' 
                GROUP BY C.sales_person,C.state,B.customer_id,B.product_id,B.product_grade  ORDER by C.sales_person,C.state,C.name,P.name,G.name
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close




























    
    public function get_total_product_sale_in_rs($data,$from_date,$to_date)
	{
        $sql="  SELECT sum(total) as total_rs,sum(grandtotal2) as grand_total_rs
                FROM dispatch 
                WHERE  entry_date between '$from_date' and '$to_date' and  type_of_bill='Tax Invoice' and is_it_cancel = '0' ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close



































   


    //----------------------------------------------------DISPATCH mail
    public function print_dispatch($id)
	{
		if($id>0)
		{
            $result['res2'] = $this->Dispatchmodel->get_customer_dispatch_data_with_id($id);
            $result['res3'] = $this->Dispatchmodel->get_customer_dispatch_details_data_with_id($id);
            //customer details
            $customer_id = $result['res2'][0]['customer_id'];
            $result['cust'] = $this->Customermodel->get_customer_with_id($customer_id);
            
            $this->load->view('dispatch/dispatch/print',$result);
        }
    }//function close



    public function mail_dispatch($id,$msg)
	{
        
        if($id>0)
		{
            $result['cust'] = $this->Customermodel->get_customer_with_id($id);
            $result['res2'] = $this->Dispatchmodel->get_customer_dispatch_data_with_id($id);
            $result['res3'] = $this->Dispatchmodel->get_customer_dispatch_details_data_with_id($id);
            //customer details
            $customer_id = $result['res2'][0]['customer_id'];
            $result['cust'] = $this->Customermodel->get_customer_with_id($customer_id);
            $customer_name = $result['cust'][0]['name'];
            $invoice_no =  $this->Dispatchmodel->get_next_bill_no_display($id);

            $body = $this->load->view('dispatch/dispatch/print',$result,true);
            
            if($msg == "New"){
                $subject ="$invoice_no : $customer_name";
                $body_top = " Dear Sir, <br> New Invoice Is created.<br><br> ";
            }
            elseif($msg == "Update"){
                $subject ="$invoice_no* Updated : $customer_name";
                $body_top = " Dear Sir, <br> This Invoice is updaed.<br><br> ";
            }
            else{
                $subject ="$invoice_no : $customer_name"; 
                $body_top = " Dear Sir, <br> New Invoice Is created.<br><br> ";
            }
            


            //schedule vs supply data
            $sch_vs_supp = 1; //data must come form company profile in future
            if($sch_vs_supp == 1)
            {
                $search_date1= date('Y-m-01');
                $search_date2= date('Y-m-t');
                $where ="  and B.customer_id='$customer_id' and A.from_date between '$search_date1' and '$search_date2'  GROUP BY A.details_id   ORDER by B.schedule_id DESC ";
                $result['res2'] = $this->Dispatchmodel->schedule_serach_query($where);
                $sch_vs_supp_data = $this->load->view('dispatch/schedule/show_table',$result,true);
            }
            else{
                $sch_vs_supp_data = "";
            }// if($sch_vs_supp == 1)


            $body_bottom = "<br><br> <h4>Thank You.</h4> <span style='color:red;'>This is system generated email. No need to reply.</span>";
            $body2 = $body_top.$body.'<br><br><h4>Schedule VS Supply Details</h4>'.$sch_vs_supp_data.$body_bottom;

            $tolist = explode(",",$this->Company->dispatch_email_list());
            if(!empty($tolist))
            {
                foreach($tolist as $to)
                {
                   $this->Base->send_mail($to,$subject,$body2);
                }
            }
            
		}
    }//function close
    

    
    




    //----------------------------------------------------DISPATCH DASHBOARD
    public function get_sch_vs_sup_chart($year,$month,$div_length)
	{
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);

        $out = $this->get_sch_vs_sup_qty('All',$from_date,$to_date);
        if(!empty($out[0]['order_qty'])){$order_qty = round($out[0]['order_qty'],2);}else{$order_qty =0;}
        if(!empty($out[0]['send_qty'])){$send_qty = round($out[0]['send_qty'],2);}else{$send_qty =0;}
        $per = $this->Base->get_per($order_qty,$send_qty);

        $from_date_last_month = $this->Base->get_last_full_date_of_lastmonth_fd_ymd($month,$year);
        $to_date_last_month = $this->Base->get_last_full_date_of_lastmonth_td_ymd($month,$year);
        $out = $this->get_sch_vs_sup_qty('All',$from_date_last_month,$to_date_last_month);
        if(!empty($out[0]['order_qty'])){$order_qty2 = round($out[0]['order_qty'],2);}else{$order_qty2 =0;}
        if(!empty($out[0]['send_qty'])){$send_qty2 = round($out[0]['send_qty'],2);}else{$send_qty2 =0;}

        ?>
            <div class="row mt-2">
                <div class="col-md-<?php echo $div_length;?> col-lg-12">
                    <div class="card mb-2 o-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="t-font-bolder">Schedule VS Supply </h5><small class="text-muted">Current Month</small>
                                </div>
                                <div class="col-6 text-right">
                                    <h3 class="t-font-boldest"><?php echo $send_qty;?> / <?php echo $order_qty;?></h3><small class="text-muted">Last Month : <?php echo $send_qty2;?> / <?php echo $order_qty2;?></small>
                                </div>
                                <div class="col-12">
                                    <div class="progress mb-3">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width:<?php echo $per;?>%"  aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $per;?>%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }//function close

    //date wise sale chart
    public function date_wise_sale_chart_display($year,$month,$div_length)
    {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $label = $this->Base->get_day_no_on_month($month,$year);
        
        $name = "Sale";
        $data = array();
        foreach($label as $d)
        {
            $current_date = $this->Base->get_date_form_dayno_ymd($d,$month,$year);
            $sale_rs_array = $this->Dispatchmodel->get_total_product_sale_in_rs('',$current_date,$current_date);
            if(!empty($sale_rs_array[0]['grand_total_rs'])){$data[] = $sale_rs_array[0]['grand_total_rs'];}else{$data[] =0;}
        }
        
        //chart details
        $div_name = 'chart_k'.'1';
        $color_list = "#03A9F4";
        $this->Chartmodel->print_line_chart($div_name,'250',$color_list,$label,$data);
        ?>
            <div class="col-md-<?php echo $div_length;?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title" style="color:#03A9F4;">Invoice entry From Dispatch (Rs.)</div>
                            <div class="row">
                                <div class="col-md-2" style="height:300px; overflow:auto;">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Sales</th>
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
    }//function close


    //date wise sale chart
    public function date_wise_sale_chart_display_via_account($year,$month,$div_length)
    {
       
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $label = $this->Base->get_day_no_on_month($month,$year);
        
        $name = "Sale";
        $data = array();
        foreach($label as $d)
        {
            $current_date = $this->Base->get_date_form_dayno_ymd($d,$month,$year);
            $sale_rs_array = $this->Customermodel->get_total_debit_amount_in_rs_datewise('',$current_date,$current_date);
            if(!empty($sale_rs_array[0]['total_rs'])){$data[] = round($sale_rs_array[0]['total_rs']);}else{$data[] =0;}
        }
        
        //chart details
        $div_name = 'chart_k1'.'1';
        $color_list = "green";
        $this->Chartmodel->print_line_chart($div_name,'250',$color_list,$label,$data);
        ?>
            <div class="col-md-<?php echo $div_length;?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title" style="color:#03A9F4;">Invoice entry From Account (Rs.)</div>
                            <div class="row">
                                <div class="col-md-2" style="height:300px; overflow:auto;">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Sales</th>
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
    }//function close


    //date wise amt rec
    public function date_wise_amt_rec_chart_display_via_account($year,$month,$div_length)
    {
        $year = 2023;
        $month = 12;
        
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $label = $this->Base->get_day_no_on_month($month,$year);
        
        $name = "Sale";
        $data = array();
        foreach($label as $d)
        {
            $current_date = $this->Base->get_date_form_dayno_ymd($d,$month,$year);
            $sale_rs_array = $this->Customermodel->get_total_credit_amount_in_rs_datewise('',$current_date,$current_date);
            if(!empty($sale_rs_array[0]['total_rs'])){$data[] = round($sale_rs_array[0]['total_rs']);}else{$data[] =0;}
        }
        
        //chart details
        $div_name = 'chart_k2'.'1';
        $color_list = "red";
        $this->Chartmodel->print_line_chart($div_name,'250',$color_list,$label,$data);
        ?>
            <div class="col-md-<?php echo $div_length;?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title" style="color:#03A9F4;">Payment Receive date wise (Rs.) (Testing)</div>
                            <div class="row">
                                <div class="col-md-2" style="height:300px; overflow:auto;">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Sales</th>
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
    }//function close




}//class close



