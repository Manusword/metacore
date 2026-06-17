<?php
class Storemodel extends CI_Model
{
    
    //update_stock
    public function update_stock($task,$comment,$value)
	{
        $today=date("Y-m-d H:i:s");
        $user_email=$this->session->userdata('login_emp_id');
        
        if(!empty($value[0])){$product_id = (int)$value[0];}else{$product_id = '';}
        if(!empty($value[1])){$lotno = $value[1];}else{$lotno = '';}
        if(!empty($value[2])){$grade = $value[2];}else{$grade = '';}
        if(!empty($value[3])){$qty = (int)$value[3];}else{$qty = '';}
        if(!empty($value[4])){$cost = (int)$value[4];}else{$cost = '';}
        if(!empty($value[5])){$pkg = (int)$value[5];}else{$pkg = '';}
        if(!empty($value[6])){$status = (int)$value[6];}else{$status = '';}
        
        if(!empty($product_id) and $product_id>0)
        {
            //check product is exits or not
            $res = $this->get_stock_product_lot_grade($product_id,$lotno,$grade);
            if(!empty($res) and $res[0]['product_stock_id']>0)
            {
                    //update stock
                        //old stock details
                        $product_stock_id = $res[0]['product_stock_id'];
                        $old_qty = (int)$res[0]['recive_stock_level'];
                        $old_cost = (int)$res[0]['recive_stock_level_cost'];
                        $old_pkg = (int)$res[0]['pkg'];
                        
                        //task action
                        if($task == "ADD")
                        {
                            $now_qty = round($old_qty + (int)$qty); 
                            $now_cost = round($old_cost + (int)$cost); 
                            $now_pkg = round($old_pkg + (int)$pkg);
                        }
                        elseif($task == "SUB")
                        {
                            $now_qty = round($old_qty-(int)$qty); 
                            $now_cost = round($old_cost-(int)$cost); 
                            $now_pkg = round($old_pkg-(int)$pkg); 
                            
                        }
                        else
                        {
                            $now_qty = $qty;
                            $now_cost = $cost;
                            $now_pkg = $pkg;
                        }
                        
                        if($now_qty < 0){$now_qty = 0;}
                        if($now_cost < 0){$now_cost = 0;}
                        if($now_pkg < 0){$now_pkg = 0;}

                        //updating stock table
                        $data=array(
                            'recive_stock_level'=>"$now_qty",
                            'recive_stock_level_cost'=>"$now_cost",
                            'pkg'=>"$now_pkg",
                            'status'=>"$status",
                            'update_by'=>"$user_email",
                            'update_date'=>"$today",
                        );
                        $where = array('product_id'=>"$product_id",'lotno'=>"$lotno",'product_grade_id'=>"$grade",);
                        $this->db->update('product_stock',$data,$where);
                       
            }
            else
            {
                    //new entry in stock
                    $now_qty = $qty;
                    $now_cost = $cost;
                    $now_pkg = $pkg;

                    $data=array(
                        'product_id'=>"$product_id",
                        'lotno'=>"$lotno",
                        'product_grade_id'=>"$grade",
                        'recive_stock_level'=>"$now_qty",
                        'recive_stock_level_cost'=>"$now_cost",
                        'pkg'=>"$now_pkg",
                        'status'=>"$status",
                        'save_by'=>"$user_email",
                        'save_date'=>"$today",
                    );
                    $product_stock_id = $this->Mymodel->insertdata_withid('product_stock',$data);
            }// if(!empty($res) and $res[0]['product_stock_id ']>0){


            //---------------stock history
            $data=array(
                'product_stock_id'=>"$product_stock_id",
                'task_status'=>"$task",
                'comment_status'=>"$comment",
                'product_id'=>"$product_id",
                'lotno'=>"$lotno",
                'product_grade_id'=>"$grade",
                'recive_stock_level'=>"$now_qty",
                'recive_stock_level_cost'=>"$now_cost",
                'pkg'=>"$now_pkg",
                'status'=>"$status",
                'save_by'=>"$user_email",
                'save_date'=>"$today",
            );
            $this->Mymodel->insertdata('product_stock_his',$data);

        }
        else
        {
            echo "Product not found while updateing stock.";
            exit;
        }//product not found
    }//function close
    
    
    
    
    
    
    //-------------------------------------------------------rec stock from invoice
	public function get_rec_qty_from_bill($id,$first_date,$last_date)
	{
        $sql = "SELECT sum(net) qty FROM product_invoice_entry_details WHERE product_id='$id' and invoice_date between '$first_date' and '$last_date'    ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //-------------------------------------------------------issue stock from invoice
	public function get_issue_qty_from_bill($id,$first_date,$last_date)
	{
        $sql = "SELECT sum(A.issuequnt) qty 
                FROM indent_store_req_details as A 
                LEFT JOIN indent_store_req as B on B.indent_store_req_id = A.indent_store_req_id
                WHERE A.product_id='$id' and B.entry_date between '$first_date' and '$last_date'    ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //-------------------------------------------------------issue dept stock from invoice 
	public function get_issue_qty_from_bill_dept_wise($id,$first_date,$last_date,$dept)
	{
       if($dept == 'Other')
       {
            $sql = "SELECT sum(A.issuequnt) qty 
            FROM indent_store_req_details as A 
            LEFT JOIN indent_store_req as B on B.indent_store_req_id = A.indent_store_req_id
            WHERE A.product_id='$id' and B.dept not in (5,6,28,29,31,32) and B.entry_date between '$first_date' and '$last_date'    ";
       }
       else
       {
            $sql = "SELECT sum(A.issuequnt) qty 
            FROM indent_store_req_details as A 
            LEFT JOIN indent_store_req as B on B.indent_store_req_id = A.indent_store_req_id
            WHERE A.product_id='$id' and B.dept = '$dept' and B.entry_date between '$first_date' and '$last_date'    ";
       }
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    
    
    
    //-------------------------------------------------------get
    //get total stock qty with product id
	public function get_stock_product_id($id)
	{
        $sql = "SELECT sum(recive_stock_level) total_qty,sum(recive_stock_level_cost) total_amt,sum(pkg) total_pkg FROM product_stock WHERE product_id='$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get total stock qty with product id, date
	public function item_details($id,$date)
	{
      $search_date = $this->Base->change_date_ymd($date);
      $month = $this->Base->change_date_into_month($date);
      $year = $this->Base->change_date_into_year($date);
      $first_date = $this->Base->get_first_full_date_of_month_ymd($month,$year);
      $last_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
    
        //current stock
        $out = $this->get_stock_product_id($id);
        $current_stock = $out[0]['total_qty'];
      
        
        //rec this month
        $out2 = $this->get_rec_qty_from_bill($id,$first_date,$last_date);
        $rec_this_month = (float)$out2[0]['qty'];
        
        //issue this month
        $out3 = $this->get_issue_qty_from_bill($id,$first_date,$last_date);
        $issue_this_month = (float)$out3[0]['qty'];
        
        //monthly opening balance
        $monthly_openning_balance = round($current_stock - $rec_this_month + $issue_this_month);


        //issue today
        $out4 = $this->get_issue_qty_from_bill($id,$search_date,$search_date);
        $issue_today = (float)$out4[0]['qty'];
        
        //rec today
        $out5 = $this->get_rec_qty_from_bill($id,$search_date,$search_date);
        $rec_today = (float)$out5[0]['qty'];

        //today opening balance
        $today_openning_balance = round($current_stock - $rec_today + $issue_today);

        //dept wise issue
        //ph
        $out5 = $this->get_issue_qty_from_bill_dept_wise($id,$search_date,$search_date,31);
        $ph_issue_today = (float)$out5[0]['qty'];
        //dry
        $out5 = $this->get_issue_qty_from_bill_dept_wise($id,$search_date,$search_date,6);
        $dry_issue_today = (float)$out5[0]['qty'];
        //min
        $out5 = $this->get_issue_qty_from_bill_dept_wise($id,$search_date,$search_date,28);
        $min_issue_today = (float)$out5[0]['qty'];
        //wet
        $out5 = $this->get_issue_qty_from_bill_dept_wise($id,$search_date,$search_date,5);
        $wet_issue_today = (float)$out5[0]['qty'];
        //GI
        $out5 = $this->get_issue_qty_from_bill_dept_wise($id,$search_date,$search_date,32);
        $gi_issue_today = (float)$out5[0]['qty'];
        //patt
        $out5 = $this->get_issue_qty_from_bill_dept_wise($id,$search_date,$search_date,29);
        $patt_issue_today = (float)$out5[0]['qty'];
        //other dept
        $out6 = $this->get_issue_qty_from_bill_dept_wise($id,$search_date,$search_date,'Other');
        $other_issue_today = (float)$out6[0]['qty'];
           
        if($rec_this_month <1){$rec_this_month ='';}
        if($issue_this_month <1){$issue_this_month ='';}
        if($rec_today <1){$rec_today ='';}
        if($ph_issue_today <1){$ph_issue_today ='';}
        if($dry_issue_today <1){$dry_issue_today ='';}
        if($min_issue_today <1){$min_issue_today ='';}
        if($wet_issue_today <1){$wet_issue_today ='';}
        if($gi_issue_today <1){$gi_issue_today ='';}
        if($patt_issue_today <1){$patt_issue_today ='';}
        if($other_issue_today <1){$other_issue_today ='';}

        return $result  = array(
                        'current_stock' => $current_stock,
                        'rec_this_month' => $rec_this_month,
                        'issue_this_month' => $issue_this_month,
                        'monthly_openning_balance' => $monthly_openning_balance,
                        'issue_today' => $issue_today,
                        'rec_today' => $rec_today,
                        'today_openning_balance' => $today_openning_balance,
                        'ph_issue_today' => $ph_issue_today,
                        'dry_issue_today' => $dry_issue_today,
                        'min_issue_today' => $min_issue_today,
                        'wet_issue_today' => $wet_issue_today,
                        'gi_issue_today' => $gi_issue_today,
                        'patt_issue_today' => $patt_issue_today,
                        'other_issue_today' => $other_issue_today
                    );

    }//function close


    //get total sum stock qty with product id lotno or grade
    public function get_stock_qty_from_plg($product_id,$lotno,$grade)
	{
        $sql = "SELECT sum(recive_stock_level) as qty FROM product_stock WHERE product_id='$product_id' and lotno='$lotno' and product_grade_id='$grade' ";
        $query = $this->db->query($sql);
        $out = $query->result_array();
        if(!empty($out))
        {
            return $out[0]['qty'];
        }
        else{return 0;}
    }//function close


    //get total stock qty with product id lotno or grade
    public function get_stock_product_lot_grade($product_id,$lotno,$grade)
	{
        $sql = "SELECT * FROM product_stock WHERE product_id='$product_id' and lotno='$lotno' and product_grade_id='$grade' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //-------get grade list form product id
    public function get_all_grade_list_with_product_id($product_id)
	{
        $sql = "SELECT  A.product_grade_id,sum(A.recive_stock_level) as qty,B.name as bname 
        FROM product_stock as A 
        LEFT JOIN product_grade as B ON A.product_grade_id = B.id
        WHERE A.product_id='$product_id' and recive_stock_level>'0'  GROUP BY A.product_grade_id ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //-------get lotno list form product id
    public function get_all_lotno_list_with_product_id($product_id)
	{
        $sql = "SELECT  A.lotno,A.product_grade_id,sum(recive_stock_level) as qty,S.name as sname,B.invoice_date
                FROM product_stock as A
                LEFT JOIN product_invoice_entry_details as B ON B.lotno = A.lotno
                LEFT JOIN supplier as S ON S.id = B.supplier_id
                WHERE A.product_id='$product_id' and A.recive_stock_level>'0' GROUP BY A.lotno ORDER BY B.invoice_date ASC
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    
    
    //next stroe issue slip no
	public function get_next_issue_slip_no()
	{
		$sql = "SELECT indent_store_req_id FROM indent_store_req Where indent_store_req_id!='' ORDER BY indent_store_req_id DESC LIMIT 1   ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))
        {
            $next_no = ((int)$res[0]['indent_store_req_id'])+1;
        }
        else
        {
            $next_no = '01';
        }
        return $next_no;
    }//function close





    //stock search with category and product name GROUP BY
    public function get_all_product_form_store_with_search($search)
	{
        $sql="
					SELECT 
					
                    A.product_stock_id,A.product_id,A.product_grade_id,A.lotno,sum(recive_stock_level) as total_qty, sum(recive_stock_level_cost) as total_cost,
                    sum(pkg) as total_pkg,
					P.name as pname,P.economic,P.reorder,P.max_level,P.details,P.size,P.no_of_days,
					C.name as cname,C.category_id,
					U.name as uname,
                    G.name as gname
					
					FROM product_stock as A 
					
					LEFT JOIN product as P ON P.product_id = A.product_id
					LEFT JOIN category C ON C.category_id=P.category_id
					LEFT JOIN unit U ON U.unit_id=P.unit_id
                    LEFT JOIN product_grade G ON G.id=A.product_grade_id
					
					   
					WHERE A.status='0'  $search 
				";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //stock search with category and product name ------------------------WITH OUT GROUP BY
    public function get_all_product_form_store_with_search_without_group_by($search)
	{
        $sql="
					SELECT 
					
                    A.product_stock_id,A.product_id,A.product_grade_id,A.lotno,A.recive_stock_level,A.recive_stock_level_cost,A.pkg,A.status,
                    P.name as pname,P.economic,P.reorder,P.max_level,P.details,P.size,P.no_of_days,
					C.name as cname,C.category_id,
					U.name as uname
					
					FROM product_stock as A 
					
					LEFT JOIN product as P ON P.product_id = A.product_id
					LEFT JOIN category C ON C.category_id=P.category_id
					LEFT JOIN unit U ON U.unit_id=P.unit_id
					
					   
					WHERE 1=1 $search 
				";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    
    //get_compair_graph
	public function get_compair_graph($qty,$min,$re,$max)
	{
        if($qty>0 and $max>0)
        {
            $per = round(($qty/$max)*100);
            
            if( $qty<=$min)
            {
                $color =  "danger";
            }
            elseif($qty>$min and $qty<=$re)
            {
                $color =  "warning";
            }
            elseif($qty>$re and $qty<=$max)
            {
                $color =  "success";
            }
            elseif($qty>$max)
            {
                $color =  "info";
            }
        }
        else
        {
            $per = 0;
            $color =  "info";
        }
        
        return $data =array($per,$color);

    }//function close



































    //-------------------------------------------------------INDENT table REQUEST-------------------------------
    //get_store_req_slip_with_id
	public function get_store_req_slip_with_id($id)
	{
        $sql = "SELECT * FROM indent_store_req WHERE indent_store_req_id='$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //get_store_req_slip_details_with_id
	public function get_store_req_slip_details_with_id($id)
	{
        $sql = "SELECT * FROM indent_store_req_details WHERE indent_store_req_id='$id'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


     //store indent  ------------------------WITH OUT GROUP BY
     public function store_indent_serach_query($search)
     {
         $sql="
                    SELECT 
                    A.indent_store_req_id,A.lotno,A.issuequnt,A.amt,A.pkg,A.receivedby,
                    B.entry_date,B.indent_no,B.indentor,B.request_by,
                    P.name as pname,
                    C.name as cname,C.category_id,
                    U.name as unit_name,
                    D.name as dept_name,
                    M.name as mc_name,
                    E.first_name as indentor_name,
                    F.first_name as request_by_name,
                    H.first_name as receivedby_name,
                    G.name as grade_name


                    FROM indent_store_req_details as A 
                    
                    LEFT JOIN indent_store_req as B ON B.indent_store_req_id = A.indent_store_req_id
                    LEFT JOIN product as P ON P.product_id = A.product_id
                    LEFT JOIN category C ON C.category_id=P.category_id
                    LEFT JOIN unit U ON U.unit_id=P.unit_id
                    LEFT JOIN department D ON D.department_id = B.dept
                    LEFT JOIN machine_list M ON M.mc_id = B.mc_no
                    
                    LEFT JOIN employee E ON E.emp_code = B.indentor
                    LEFT JOIN employee F ON F.emp_code = B.request_by
                    LEFT JOIN employee H ON H.emp_code = A.receivedby
                    
                    LEFT JOIN product_grade G ON G.id = A.grade
                    
                    
                    WHERE 1=1 $search 
                 ";
         $query = $this->db->query($sql);
         return $query->result_array();
    }//function close


    //store->issue_list Dashboard
	public function issue_list_dashboard($search_date1,$search_date2,$avg_month)
	{
		$sql=" SELECT  P.name as product_name,	D.name as dept_name, C.name as category_name,
						SUM(A.issuequnt) as issue_qty,
						(
							SELECT SUM(sub.issuequnt)
							FROM indent_store_req_details AS sub
							LEFT JOIN indent_store_req AS sub_req ON sub_req.indent_store_req_id = sub.indent_store_req_id
							WHERE 
								sub.product_id = A.product_id
								AND sub_req.entry_date BETWEEN DATE_SUB('$search_date1', INTERVAL $avg_month MONTH) AND '$search_date1'
						) AS sum_issue_qty_3_months
                   
                    FROM indent_store_req_details as A 
                    
                    LEFT JOIN indent_store_req as B ON B.indent_store_req_id = A.indent_store_req_id
                    LEFT JOIN product as P ON P.product_id = A.product_id
                   	LEFT JOIN department D ON D.department_id = B.dept
                    LEFT JOIN category C ON C.category_id=P.category_id
                   	WHERE  B.entry_date between '$search_date1' and '$search_date2' GROUP BY A.product_id ORDER BY C.name,P.name
                 ";
        $query = $this->db->query($sql);
        return $query->result_array();
	}//function close

    
	//store->issue_list Dashboard
	public function issue_list_category_wise_issue($raw_data)
	{
			$category_data = [];
			$departments = [];

			foreach ($raw_data as $row) {
				$cat = $row['category_name'];
				$dept = $row['dept_name'];
				$issue = floatval($row['issue_qty']);
				$sum = floatval($row['sum_issue_qty_3_months']);

				// Collect unique departments
				if (!in_array($dept, $departments)) {
					$departments[] = $dept;
				}

				// Initialize category if not exists
				if (!isset($category_data[$cat])) {
					$category_data[$cat] = [
						'category' => $cat,
						'total_issue' => 0,
						'total_sum' => 0,
					];
				}

				// Sum total
				$category_data[$cat]['total_issue'] += $issue;
				$category_data[$cat]['total_sum'] += $sum;

				// Store department-wise issue
				if (!isset($category_data[$cat][$dept])) {
					$category_data[$cat][$dept] = 0;
				}
				$category_data[$cat][$dept] += $issue;
			}

			// Sort departments
			sort($departments);

			?>
				<div >
					<h4 class="mb-3">Product Issue From Store (Category wise)</h4>

					<table class="table table-bordered table-striped table-sm">
						<thead>
							<tr style="background-color:#eee">
								<th>S.No.</th>
								<th>Category</th>
								<th>3 Month Total</th>
                                <th>3 Month Avg</th>
								<th>Total Issue</th>
								<?php foreach ($departments as $dept): ?>
									<th><?= $dept ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<?php $sno = 1; foreach ($category_data as $cat => $data): ?>
								<tr>
									<td><?= $sno++ ?></td>
									<td><?= $data['category'] ?></td>
									<td><?= round($data['total_sum']) ?></td>
                                    <td><?= $avg = round($data['total_sum']/3) ?></td>
									<td <?= ($data['total_issue'] > $avg) ? 'style="color:red; font-weight:bold;"' : '' ?>>
										<?= round($data['total_issue']) ?>
									</td>
									<?php foreach ($departments as $dept): ?>
										<?php $val = isset($data[$dept]) ? $data[$dept] : 0; ?>
										<td><?= ($val > 0 ? $val : '') ?></td>
									<?php endforeach; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php
	}//function close

    //store->issue_list Dashboard
	public function issue_list_product_wise_issue($raw_data)
    {
        // Pivoting data
        $pivot = [];
        $departments = [];

        foreach ($raw_data as $row) {
            $product = $row['product_name'];
            $category = $row['category_name'];
            $dept = $row['dept_name'];
            $sum = round($row['sum_issue_qty_3_months'], 2);
            $qty = $row['issue_qty'];

            // Collect unique departments
            if (!in_array($dept, $departments)) {
                $departments[] = $dept;
            }

            // Initialize product entry
            if (!isset($pivot[$product])) {
                $pivot[$product] = [
                    'sum' => $sum,
                    'product' => $product,
                    'category' => $category,
                    'total' => 0
                ];
            }

            $pivot[$product][$dept] = $qty;
            $pivot[$product]['total'] += $qty;
        }

        // Sort departments alphabetically
        sort($departments);
        ?>

        <div >
            <h4 class="mb-3">Product Issue From Store </h4>

            <table class="table table-bordered table-striped table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>S.No.</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>3 Month Total</th>
                        <th>3 Month Avg</th>
                        <th>Total Issue</th>
                        <?php foreach ($departments as $dept): ?>
                            <th><?= htmlspecialchars($dept) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $sno = 1; ?>
                    <?php foreach ($pivot as $product => $data): ?>
                        <tr>
                            <td><?= $sno++ ?></td>
                            <td><?= htmlspecialchars($data['category']) ?></td>
                            <td><?= htmlspecialchars($data['product']) ?></td>
                            <td><?= round($data['sum']) ?></td>
                            <td><?= $avg = round($data['sum']/3) ?></td>
                            <td <?= ($data['total'] > $avg) ? 'style="color:red; font-weight:bold;"' : '' ?>>
                                <?= $data['total'] ?>
                            </td>
                            <?php foreach ($departments as $dept): ?>
                                <?php $val = isset($data[$dept]) ? $data[$dept] : 0; ?>
                                <td><?= ($val > 0 ? $val : '') ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php
    } // function close


    
    
    
    
    
    
    //store issue form date to date on machine with amt
	public function issue_list_to_machine($mc_id,$from_date,$to_date)
	{
        $sql="  SELECT  count(B.indent_store_req_id) as total_slip, 
                        count(A.details_id) as total_item, 
                        sum(A.issuequnt) as qty, 
                        sum(A.amt) as amt, 
                        sum(A.pkg) as pkg
                FROM indent_store_req_details as A 
                LEFT JOIN indent_store_req as B ON B.indent_store_req_id = A.indent_store_req_id
                WHERE B.entry_date between '$from_date' and '$to_date' and B.mc_no = '$mc_id'
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
	}//function close


    





    //--------------------------------------------------------Stock
    public function get_qty_stock_with_search($search)
    {
        $sql="SELECT 
                    stock_id,no_of_coils,weight
                    FROM stock 
                    WHERE 1=1 $search 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //stock with search
    public function get_all_stock_with_search($search)
    {
        $sql="
                    SELECT 
                    A.stock_id,A.stock_dept,A.size,A.dia,A.oil,A.grade_id,A.no_of_coils,A.weight,A.unit,
                    P.product_id,P.name as pname,P.size as psize,
                    G.name as gname,
                    U.name as uname
                    FROM stock as A 
                    LEFT JOIN product P ON P.product_id=A.size
                    LEFT JOIN product_grade G ON G.id=A.grade_id
                    LEFT JOIN unit U ON U.unit_id=A.unit
                    WHERE 1=1 $search 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    public function get_all_stock_coils_weight_with_search($search)
    {
        $sql="  SELECT  SUM(A.no_of_coils) as no_of_coils,SUM(A.weight) as weight
                    FROM stock as A 
                    LEFT JOIN product P ON P.product_id=A.size
                    LEFT JOIN product_grade G ON G.id=A.grade_id
                    LEFT JOIN unit U ON U.unit_id=A.unit
                    WHERE 1=1 $search 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //--------------------------------Stock In out
     //stock_inout with id
     public function get_stockinout_id($id)
     {
         $sql = "SELECT A.*,P.product_id,P.name as pname,P.size as psize FROM stock_inout as A  
         LEFT JOIN product P ON P.product_id=A.size
         WHERE A.stock_inout_id ='$id'";
         $query = $this->db->query($sql);
         return $query->result_array();
     }//function close

     //stock with search
    public function get_all_inout_stock_with_search($search)
    {
        $sql="
                    SELECT 
                    A.stock_inout_id,A.inout,A.in_from,A.out_to,A.entry_date,A.stock_dept,A.size,A.dia,A.oil,A.grade_id,A.no_of_coils,A.weight,A.unit,
                    P.product_id,P.name as pname,P.size as psize,
                    G.name as gname,
                    U.name as uname
                    FROM stock_inout as A 
                    LEFT JOIN product P ON P.product_id=A.size
                    LEFT JOIN product_grade G ON G.id=A.grade_id
                    LEFT JOIN unit U ON U.unit_id=A.unit
                    WHERE 1=1 $search 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close




}//class close



