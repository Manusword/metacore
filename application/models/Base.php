<?php
class Base extends CI_Model
{
	
	function __construct() 
	{
        parent::__construct();
        
		//$this->load->library('encrypt');
        $this->load->model('Company');
        $this->load->model('Mymodel');
        $this->load->model('Hrmodel');

        $this->load->model('Productmodel');	
        $this->load->model('Suppliermodel');
        $this->load->model('Customermodel');
        $this->load->model('Pomodel');
        $this->load->model('Storemodel');
        $this->load->model('Invoicemodel');	
        $this->load->model('Maintenancemodel');
        $this->load->model('Meetingmodel');
        $this->load->model('Machinemodel');
        $this->load->model('Productionmodel');
        $this->load->model('Chartmodel');
        $this->load->model('Dispatchmodel');
        $this->load->model('Qcmodel');
        $this->load->model('Gpmodel');
        $this->load->model('Ddiemodel');
        $this->load->model('Aimodel');

    }//function close
    
    public function check_id_pass_valid($username,$password)
	{
        $sql = "SELECT id FROM employee WHERE username='$username' and pwd='$password' ";
        $query = $this->db->query($sql);
        $user = $query->result_array();
        if(!empty($user))
        {
            //valid user name or password
            $out['status'] = 'TRUE';
        }
        else
        {
            //invalid user name or password
            $out['status'] = 'FALSE';
            $out['msg'] = "Invalid Username and Password";
        }
        
        return $out;
    }//function close
    




    public function check_login_status($username)
	{
        $sql = "SELECT * FROM employee WHERE username='$username'  ";
        $query = $this->db->query($sql);
        $user = $query->result_array();
        $user_status = $user[0]['status'];
        $emp_id = $user[0]['id'];
        $user_login_from_other_ip =$user[0]['login_from_other_ip'];
        if($user_status != 'Active')
        {
            //if not active
            $out['status'] = 'FALSE';
            $out['msg'] = "You are not allow form login";
            $this->Base->update_login_ip($emp_id,'in',"not login. Emp $user_status for Login");
        }
        else  //if  active
        {
            //not able login form anywhere
            $ip = $this->input->ip_address();
            //$sql = "SELECT details10 FROM company_profile WHERE id=2 ";
            $sql = "SELECT login_ip_from FROM company WHERE company_id = 1 ";
            $query = $this->db->query($sql);
            $ip_details = $query->result_array();
            $login_from_ip_all = explode(',',$ip_details[0]['login_ip_from']);
            if(in_array($ip,$login_from_ip_all) or $user_login_from_other_ip == 1)
            {
                //login form anywhere
                $out['status'] = 'TRUE';
                $this->Base->update_login_ip($emp_id,'in','login');//creating histor
            }
            else
            {
                $out['status'] = 'FALSE';
                $out['msg'] = "Sorry! You can't login from outside.";
                $this->Base->update_login_ip($emp_id,'in','try from diff net');
            }// if($user_login_from_other_ip != 1)

        }//if($user_status != 'Active')
        
        return $out;
    }//function close



    public function create_session($username)
	{
        $sql = "SELECT id,first_name,last_name,department_id,emp_code,role_in_department,owner,company_id FROM employee WHERE username='$username' ";
        $query = $this->db->query($sql);
        $user = $query->result_array();
        if(!empty($user))
        {
            $emp_id= $user[0]['id'];
            $emp_code= $user[0]['emp_code'];
            $user_name= $user[0]['first_name'].' '.$user[0]['last_name'];
            $department_id= $user[0]['department_id'];
            $role_in_department= $user[0]['role_in_department'];
            $owner= $user[0]['owner'];
            $company_id= $user[0]['company_id'];
           
            //----------------employee details
            $newdata = array(
                                'login_emp_id'			      => $emp_id,  
                                'login_emp_code'			  => $emp_code,                
                                'login_username'  		      => $user_name,
                                'login_department_id'         => $department_id,
                                'login_role_in_department'    => $role_in_department,
                                'admin'                       => $owner,
                                'company_id'                  => $company_id,
                                'logged_in' 		          => TRUE
                            );
            $this->session->sess_expiration = '32140800';
            $this->session->set_userdata($newdata);
        }//user
        
    }//function close



    public function unset_session()
	{
        $newdata = array(
                            'login_emp_id',
                            'login_emp_code',
                            'login_username',
                            'login_department_id',
                            'login_role_in_department',
                            'admin',
                            'company_id',
                            'logged_in'
                        );
		$this->session->unset_userdata($newdata);
        
    }//function close



    public function check_session()
	{
        $login_emp_id = $this->session->userdata('login_emp_id');
        if(!$login_emp_id>0)
		{
			redirect('Welcome/');
		}
        
    }//function close


    //update_login_ip
	function update_login_ip($emp_id,$in_out,$status)
	{
        $today_date_time = date("Y-m-d H:i:s");
        $ip = $this->input->ip_address();

		if($in_out == 'in')
		{
			$data2 = array('last_online'=>"$today_date_time",'login_ip'=>"$ip");
		}
		elseif($in_out == 'out')
		{
			$data2 = array('last_logout'=>"$today_date_time",'logout_ip'=>"$ip");
		}
		
		//updating employee table
		$where2=array('id'=>"$emp_id");   
		$this->Mymodel->update('employee',$data2,$where2);

		//insert into history
		$data3  = array('emp_id'=>"$emp_id",'last_online'=>"$today_date_time",'login_ip'=>"$ip",'in_out'=>"$in_out",'status'=>"$status");
		$this->Mymodel->insertdata('login_his',$data3);

    }//function close


































    public function marital_status($status)
    {
        if (empty($status)) {
            return '';
        }

        $status = strtolower(trim($status));

        switch ($status) {
            case 'married':
                return 'M';

            case 'unmarried':
                return 'U';

            case 'widowed':
            case 'widow':
            case 'widower':
                return 'W';

            case 'divorced':
            case 'divorcee':
                return 'D';

            // EPFO does NOT recognize these separately
            // Treating them as Unmarried (safe default)
            case 'separated':
            case 'na':
            case 'other':
                return 'U';

            default:
                return '';
        }
    }//function close



    public function get_all_hr_asset_list()
	{
        $company_id = $this->session->userdata('company_id');    
        $sql = "SELECT assetList FROM company where company_id = '$company_id' ";    
        //$query6 =" SELECT details5 FROM company_profile WHERE id=21 ";
        $out6 = $this->Mymodel->query1($sql);
        $deptlist = array();
        if(!empty($out6))
        {
            $deptlist = explode(',',$out6[0]['assetList']);
        }
        return $deptlist;
    }//hr attendance dept list




    //debit payment notification date
    public function get_debit_payment_notifi_days()
    {
        return 4;
    }//function close

   

    //all main menu list.
    public function get_all_main_menu()
    {
        $sql = "SELECT * FROM  erp_menu  WHERE  status = 'Active'   ORDER by menu_order ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_all_main_menu2()
    {
        $sql = "SELECT * FROM  erp_menu   ORDER BY menu_order ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_all_sub_menu()
    {
        $sql = "SELECT * FROM  erp_sub_menu  WHERE  status = 'Active'   ORDER by menu_order ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_all_sub_menu2()
    {
        $sql = "SELECT * FROM  erp_sub_menu    ORDER by menu_order ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_all_sub_menu_from_main_id($main_id)
    {
        $sql = "SELECT * FROM  erp_sub_menu  WHERE main_menu_id='$main_id' and status = 'Active'   ORDER by menu_order ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_all_sub_menu_from_main_id2($main_id)
    {
        $sql = "SELECT * FROM  erp_sub_menu  WHERE main_menu_id='$main_id' ORDER by menu_order ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //all main production dept.
    public function get_all_production_dept()
    {
        $sql = "SELECT * FROM  department  WHERE  is_main_production = '1' and  status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //all sub production dept.
    public function get_sub_production_dept()
    {
        $sql = "SELECT * FROM  department  WHERE  is_sub_production = '1' and  status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //all  maintenace breakdown dept.
    public function get_maintenance_dept()
    {
        $sql = "SELECT * FROM  department  WHERE  is_maintenance = '1' and  status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //all  meter reading dept.
    public function get_meter_reading_dept()
    {
        $sql = "SELECT * FROM  department  WHERE  meter_reading = '1' and  status='Active'  ORDER by meter_reading_order ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //all  scrap dept.
    public function get_scrap_dept()
    {
        $sql = "SELECT * FROM  department  WHERE  is_scrap = '1' and  status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //All hr dept
    public function get_hr_dept()
    {
        $sql = "SELECT * FROM  department  WHERE  is_hr = '1' and  status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //All active dept
    public function get_all_dept()
    {
        $sql = "SELECT * FROM  department  WHERE    status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //All active dept
    public function get_all_dept2()
    {
        $sql = "SELECT * FROM  department    ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //All active shift
    public function get_all_shift()
    {
        $sql = "SELECT * FROM  emp_shift_master    ORDER by shift_code ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_all_active_shifts()
    {
        $sql = "SELECT * FROM  emp_shift_master WHERE status='Active' ORDER by shift_code ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    


    //All active machine
    public function get_all_machine()
    {
        $sql = "SELECT M.mc_id,M.name as mname,D.name as dname 
                FROM  machine_list as M 
                LEFT JOIN department as D  on D.department_id = M.dept  
                WHERE    M.status='Working'  ORDER by D.name,M.name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
     }//function close

    

    //dept name
    public function get_name_form_dept_id($id)
    {
        $sql = "SELECT name FROM  department  WHERE department_id = '$id'   ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['name'];}else{return "";}
    }//function close



    //All active deptrole
    public function get_all_dept_role()
    {
        $sql = "SELECT * FROM  department_role  WHERE    status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_all_dept_role2()
    {
        $sql = "SELECT * FROM  department_role   ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //role name
    public function get_name_form_role_id($id)
    {
        $sql = "SELECT name FROM  department_role  WHERE role_id = '$id'   ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['name'];}else{return "";}
    }//function close

    public function get_menu_access_role_id($id)
    {
        $sql = "SELECT menu_access FROM  department_role  WHERE role_id = '$id'   ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ 
            return explode(",", $res[0]['menu_access']);
        }else{return [];}
    }//function close

    public function get_menu_access_of_role()
    {
        $role_id = $this->session->userdata('login_role_in_department');    
        $sql = "SELECT menu_access FROM  department_role  WHERE role_id = '$role_id'   ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res) and strlen($res[0]['menu_access']) > 2){ 
            return explode(",", $res[0]['menu_access']);
        }else{return [];}
    }//function close


    //All active contractor_code
    public function get_all_contractor_code()
    {
        $company_id = $this->session->userdata('company_id'); 
        $sql = "SELECT * FROM  contractor_code  WHERE    status='Active' and company_id='$company_id' ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //All active contractor_code
    public function get_all_contractor_code2()
    {
        $company_id = $this->session->userdata('company_id'); 
        $sql = "SELECT * FROM  contractor_code WHERE company_id='$company_id'   ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //All active contractor_code
    public function get_payroll_master()
    {
        $company_id = $this->session->userdata('company_id'); 
        $sql = "SELECT * FROM  contractor_code WHERE working_unit < 1 and company_id='$company_id' GROUP by master_unit_id ORDER by order_no ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //All active contractor_code
    public function get_payroll_contractor()
    {
        $company_id = $this->session->userdata('company_id'); 
        $sql = "SELECT * FROM  contractor_code WHERE working_unit < 1 and company_id='$company_id'  ORDER by order_no ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_details_contractor_with_id($name)
    {
        $company_id = $this->session->userdata('company_id'); 
        $sql = "SELECT * FROM  contractor_code  WHERE name = '$name' and company_id='$company_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_details_contractor_with_id_list($company_role)
    {
        $company_id = $this->session->userdata('company_id'); 
        if (!empty($company_role) && is_array($company_role)) {    
            $company_role = array_map('trim', $company_role);
			$role_list = "'" . implode("','", $company_role) . "'";
            $sql = "SELECT * FROM  contractor_code  WHERE name IN ($role_list)  and company_id='$company_id'  ";
            $query = $this->db->query($sql);
            return $query->result_array();
        }else{
            return [];
        }
    }//function close
 
    
    //all category list
    public function get_all_category()
	{
        $sql = "SELECT * FROM category WHERE status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    //all lotno list
    public function get_all_lotno()
	{
        $sql = "SELECT * FROM product_lotno WHERE  status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //all lotno list
    public function get_all_lotno_for_pickling()
	{
        $sql = "SELECT * FROM product_lotno WHERE hide_in_pickling<1 and status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //all lotno list
    public function get_all_lotno_for_fur()
	{
        $sql = "SELECT * FROM product_lotno WHERE hide_in_fur<1 and status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

     //all lotno list
    public function get_all_lotno_with_id($id)
	{
        $sql = "SELECT * FROM product_lotno WHERE  id='$id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    


    //all grade list
    public function get_all_grade()
	{
        $sql = "SELECT * FROM product_grade WHERE status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //all grade list raw matrial
    public function get_all_grade_row()
	{
        $sql = "SELECT * FROM product_grade WHERE status='Active' and row_item=1  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //all grade list sale type 1
    public function get_all_grade_sale_type1()
    {
        $sql = "SELECT * FROM product_grade WHERE status='Active' and sale_type1=1  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
 
    //all grade name
    public function get_grade_name_from_id($id)
    {
        $sql = "SELECT name FROM product_grade WHERE id='$id'   ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))return $res[0]['name'];
    }//function close


    //all product type list
    public function get_all_product_type()
	{
        $sql = "SELECT * FROM product_type WHERE status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //all product type list get_all_product_type_col_wise
    public function get_all_product_type_col_wise($col)
    {
        if($col == 1){$col_name = "dept_1_w"; }
        elseif($col == 2){$col_name = "dept_2_m"; }
        elseif($col == 3){$col_name = "dept_3_d"; }
        else{$col_name = "dept_1_w";}
        
        $sql = "SELECT $col_name as name FROM product_type WHERE status='Active' and $col_name !='' GROUP BY $col_name ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //all unit list
    public function get_all_unit()
	{
        $sql = "SELECT * FROM unit WHERE status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return  $query->result_array();
    }//function close

    //all unit list
    public function get_unit_name_from_id($id)
    {
        $sql = "SELECT name FROM unit WHERE unit_id='$id'   ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res))return $res[0]['name'];
    }//function close

    //all state list
    public function get_all_state()
	{
        $sql = "SELECT * FROM state_code WHERE sno!=''  ORDER by state_name ASC ";
        $query = $this->db->query($sql);
        return  $query->result_array();
    }//function close



    //all breakdown problem list
    public function get_all_breakdown_problem_list()
    {
        $sql = "SELECT * FROM  breakdown_problem_list  WHERE  status='Active'  ORDER by name ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //all  ddie_pallet
    public function get_ddie_pallet()
    {
        $sql = "SELECT * FROM  ddie_pallet  WHERE 1=1  ORDER BY code ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


















    function convert_number_to_words($number) 
	{
        //$number = 190908100.25;
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'One', '2' => 'Two',
            '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
            '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
            '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
            '13' => 'Thirteen', '14' => 'fourteen',
            '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
            '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
            '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
            '60' => 'Sixty', '70' => 'Seventy',
            '80' => 'Eighty', '90' => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred
                    :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
            "." . $words[$point / 10] . " " . 
                $words[$point = $point % 10] : '';
        return "Rupees: ".$result.'Only';
    }//function close


    public function get_per($val1,$val2)
	{
       if(!empty($val1) and !empty($val2)){
            return round(($val2/$val1)*100);
       }
       elseif(!empty($val1) and empty($val2)){
            return  100;
       }
       elseif(empty($val1) and !empty($val2)){
            return  0;
       }
       else{
        return  0;
       }
        
    }//function close


    
    //calculate eff
    public function get_eff($qty1,$size1,$speed1,$shift,$running_hours)
    {
        $qty = (float)$qty1;
        $size = (float)$size1;
        $speed = (float)$speed1;
        //if($shift == 'A'){ $hours = 11.5;}else{$hours = 12;}
        $hours = $running_hours;
        
        if($qty >0 and $size >0 and $speed >0)
        {
            $eff = round(($qty/($size*$size*$speed*0.37*$hours))*100);
        }
        else
        {
            $eff = 0;
        }
       
        return $eff;                  
    }//function close

    public function get_percent_color($per)
    {
        if ($per >= 80) {
            $color = "bg-success";
        } elseif ($per >= 50) {
            $color = "bg-warning";
        } elseif ($per >= 1) {
            $color = "bg-danger";
        } else {
            $color = "";
        }
        return $color;
    }//function close


    
    //calculate mttr
    public function get_mttr($breakdowns,$total_minutes)
    {
        return  $breakdowns > 0 ? round($total_minutes / $breakdowns, 2) : 0;
    }//function close

    public function get_mtbf($breakdowns)
    {
        $operating_time = 1440; // Assuming 1 day = 1440 min
        return $breakdowns > 0 ? round($operating_time / $breakdowns, 2) : 0;
    }//function close

    public function get_mttr_remarks($mttr)
    {
        // MTTR Remark
        // Light machines	15–30 min
        // Medium complexity	30–60 min
        // High complexity/Heavy equipment	60–120 min
       
        if ($mttr <= 30) {
            $mttr_remark = "✅ Good";
        } elseif ($mttr <= 60) {
            $mttr_remark = "🟡 Average";
        } else {
            $mttr_remark = "🔴 Slow";
        }
        return  $mttr_remark;    
    }//function close


    public function get_mtbf_remarks($mtbf)
    {
       // MTBF Remark
        // Light-duty machines	500–1,000 min
        // Moderate usage	1,000–5,000 min
        // Highly reliable systems	10,000+ min
        
        if ($mtbf >= 1440) {
            $mtbf_remark = "✅ Decent – 1/day";
        } elseif ($mtbf >= 720) {
            $mtbf_remark = "🟡 Okay – 2/day";
        } else {
            $mtbf_remark = "🔴 Frequent failure";
        }
        return  $mtbf_remark;    
    }//function close































    //---------------------------------------------------------------Date
    //get age
    public function get_age_years($dob)
	{
		$today_date=date('Y-m-d');
        $date1 = date_create($today_date);
        $date2 = date_create($dob);
        return $dateDifference = date_diff($date1, $date2)->format('%y');
    }//function close

    public function get_age_years_month($dob)
	{
		$today_date=date('Y-m-d');
        $date1 = date_create($today_date);
        $date2 = date_create($dob);
        return $dateDifference = date_diff($date1, $date2)->format('%y.%m');
    }//function close


    //------change time into His
	public function change_time_Hi($time)
	{
		$test = new DateTime($time);
		return date_format($test,'H:i');
    }//function close

    //------change time into His
	public function change_time_His($time)
	{
		$test = new DateTime($time);
		return date_format($test,'H:i:s');
    }//function close

    //------change time into h:i:s a
	public function change_time_hisa($time)
	{
		$test = new DateTime($time);
		return date_format($test,'h:i:s a');
    }//function close

    //------change time into h:i:s a
	public function change_datetime_hisa($dateTime)
	{
		$test = new DateTime($dateTime);
		return date_format($test,'h:i:s a');
    }//function close

    //------change time into h:i:s a
	public function change_datetime_hi($dateTime)
	{
		$test = new DateTime($dateTime);
		return date_format($test,'h:i a');
    }//function close


    //------change date into YYYY-MM-DD  
	public function change_date_ymd_hisa($date_time)
	{
		$test = new DateTime($date_time);
		return date_format($test,'Y-m-d H:i:s');
    }//function close

    public function change_date_dmy_hisa($date_time)
	{
		$test = new DateTime($date_time);
		return date_format($test,'d-m-Y h:i:s a');
    }//function close

    public function change_date_dM_hisa($date_time)
	{
		$test = new DateTime($date_time);
		return date_format($test,'d-M h:i:s a');
    }//function close


     //------change date into YYYY-MM-DD  
	public function change_date_ymd($date)
	{
		$test = new DateTime($date);
		return date_format($test,'Y-m-d');
    }//function close
    
    //------change date into YYYYMMDD  
	public function change_date_join_ymd($date)
	{
		$test = new DateTime($date);
		return date_format($test,'Ymd');
    }//function close
    
    public function change_date_dmy($date)
	{
		$test = new DateTime($date);
		return date_format($test,'d-m-Y');
    }//function close

    public function change_date_dmy2($date)
	{
		$test = new DateTime($date);
		return date_format($test,'d/m/Y');
    }//function close

    public function add_no_of_days_in_date_ymd($date,$no)
	{
		return date( "Y-m-d",strtotime("+$no day",strtotime($date)));
    }//function close

    public function add_no_of_hours_in_date_ymd($date,$no)
	{
		return date( "Y-m-d H:i:s",strtotime("+$no hours",strtotime($date)));
    }//function close
    public function sub_no_of_hours_in_date_ymd($date,$no)
	{
		return date( "Y-m-d H:i:s",strtotime("-$no hours",strtotime($date)));
    }//function close

   

    public function get_last_date_of_month($month,$year)
	{
		$test = new DateTime(date("$year-$month-01"));
		return $last_day = date_format($test,'t');
    }//function close


    public function get_last_full_date_of_month_ymd($month,$year)
	{
		$test = new DateTime(date("$year-$month-01"));
		return $last_day = date_format($test,'Y-m-t');
    }//function close

    public function get_first_full_date_of_month_ymd($month,$year)
	{
		$test = new DateTime(date("$year-$month-01"));
		return $last_day = date_format($test,'Y-m-01');
    }//function close

    //get last month 1st date
    public function get_last_month_first_ymd($fdate){
        return date( "Y-m-d",strtotime("-1 month",strtotime($fdate)));
    }//function close
    public function get_last_month_last_ymd($fdate){
        return date( "Y-m-t",strtotime("-1 month",strtotime($fdate)));
    }//function close

    //get  month  minus
    function subtractMonthsGetMonthName($months) {
        $date= date("Y-m-d");
        $dateObj = new DateTime($date);
        $dateObj->modify("-{$months} months");
        return $dateObj->format('F'); // 'F' returns full month name
    }

    //month gap
    public function get_choise_gap_ymd($date,$gap){
        return date( "Y-m-d",strtotime($gap,strtotime($date)));
    }//function close

    public function get_day_list_bet_two_dates($from_date,$to_date){
        
        $start = new DateTime($from_date);
		$end = new DateTime($to_date);
		$end->modify('+1 day'); // Include the end date

		$interval = new DateInterval('P1D'); // 1 Day interval
		$period = new DatePeriod($start, $interval, $end);

		$all_dates = [];

		foreach ($period as $date) {
			$all_dates[] = $date->format('Y-m-d');
		}

		// Print all dates
		return $all_dates;
    }//function close



    //get next date
    public function add_givin_days_in_date_ymd($event_date,$repeat_status)
	{
		
		if($repeat_status == 'Daily'){
			 $next_event_date = date( "Y-m-d",strtotime("1 Day",strtotime($event_date)));
		}
		elseif($repeat_status == 'Weekly'){
			 $next_event_date = date( "Y-m-d",strtotime("7 Day",strtotime($event_date)));
		}
		elseif($repeat_status == 'Monthly'){
			 $next_event_date = date( "Y-m-d",strtotime("1 Month",strtotime($event_date)));
		}
		elseif($repeat_status == 'Yearly'){
			 $next_event_date = date( "Y-m-d",strtotime("1 Year",strtotime($event_date)));
		} 
		elseif($repeat_status == '2 Month' OR $repeat_status == '3 Month' OR $repeat_status == '4 Month' OR $repeat_status == '6 Month' OR $repeat_status == '8 Month'){
			$next_event_date = date( "Y-m-d",strtotime($repeat_status,strtotime($event_date)));
		}
		else{
			$next_event_date = $event_date;
		}

        return $next_event_date;
    }//function close
    

  



    //get last month 1st date
    public function get_last_full_date_of_lastmonth_fd_ymd($month,$year)
	{
        $tgl = $this->get_last_full_date_of_month_ymd($month,$year);
        return $prevmonth = date("Y-m-01",mktime(0,0,0,date("m", strtotime($tgl))-1,1,date("Y", strtotime($tgl))));
    }//function close
    //get last month last date
    public function get_last_full_date_of_lastmonth_td_ymd($month,$year)
	{
        $tgl = $this->get_last_full_date_of_month_ymd($month,$year);
        return $prevmonth = date("Y-m-t",mktime(0,0,0,date("m", strtotime($tgl))-1,1,date("Y", strtotime($tgl))));
    }//function close


   




    public function get_date_form_dayno_ymd($day_no,$month,$year)
	{
		$test = new DateTime(date("$year-$month-$day_no"));
		return $current_day = date_format($test,'Y-m-d');
    }//function close


    //------get all days no in month
	public function get_day_no_on_month($month,$year)
	{
        $last_day = $this->get_last_date_of_month($month,$year);
        $no = array();
        for($i=1;$i<=$last_day;$i++)
        {
            $no[] = $i;
        }
        return $no;
    }//function close


    //------get all days no in month
	public function get_day_full_date_on_month($month,$year)
	{
        $last_day = $this->get_last_date_of_month($month,$year);
        $no = array();
        for($i=1;$i<=$last_day;$i++)
        {
            $no[] = "$i-$month-$year";
        }
        return $no;
    }//function close




    //date diff
    public function get_diff_no_bw_two_days($from_date,$to_date)
	{
        if($from_date == "TODAY"){ $from_date = date('Y-m-d');}
        if($to_date == "MONTH LAST"){ $to_date = $this->get_last_full_date_of_month_ymd(date('m'),date('Y'));}

        $date1 = new DateTime($from_date);
		$date2 = new DateTime($to_date);
		$interval = $date1->diff($date2);
		return $dateDifference= $interval->days;
    }//function close


    //no of date between to date diff
    public function get_date_bw_two_days($startDate,$endDate)
	{
        $today = date('Y-m-d');
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'), // Interval of 1 day
            (new DateTime($endDate))->modify('+1 day') // Include the end date
        );
        
        foreach ($period as $date) {
            $day =  $date->format('Y-m-d') . PHP_EOL;
            $d =  $date->format('d') . PHP_EOL;
            
            $color="success";
            if($day < $today){
                $color="light";
            }
            
            ?>
                <span class="badge bg-<?php echo $color;?> rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                    <?php echo $d; ?>
                </span>
            <?php
        }
    }//function close


    //minute diff
    public function get_minute_diff_bw_two_dates($from_date,$to_date)
	{
        $to_time = strtotime($from_date);
        $from_time = strtotime($to_date);
        return $vr= round(abs($to_time - $from_time) / 60,2);
    }//function close


    //get total sunday in month
    public function getSundays($y, $m)
	{
		return new DatePeriod(
			new DateTime("first sunday of $y-$m"),
			DateInterval::createFromDateString('next sunday'),
			new DateTime("last day of $y-$m 23:59:59")
		);
	}
    public function getSundays2($y, $m)
	{
		foreach ($this->getSundays($y, $m) as $sunday) {
			$no_of_sunday_array2= $sunday->format("d,\n");
			$no_of_sunday_array[] = "$no_of_sunday_array2";
		}
		
		return $no_of_sunday_array;
	}//function close


    //------get month form date & time 
	public function change_date_into_month($date)
	{
		$test = new DateTime($date);
		return date_format($test,'m');
    }//function close

    public function change_number_into_month($monthNumber)
	{
		return  date("M", mktime(0, 0, 0, $monthNumber, 1));
    }//function close



    public function change_date_into_month_name($date)
	{
		$test = new DateTime($date);
		return date_format($test,'M-Y');
    }//function close


    //------get year form date & time
    public function change_date_into_year($date)
	{
		$test = new DateTime($date);
		return date_format($test,'Y');
    }//function close


    //------get year form date & time
    public function change_date_into_day($date)
	{
		$test = new DateTime($date);
		return round(date_format($test,'d'));
    }//function close


    //get month list
	function get_all_month_list_from_given_finc_year($current_year)
	{
        $next_year = $current_year+1;
        $month = ['04','05','06','07','08','09','10','11','12','01','02','03'];
        $year = [$current_year,$current_year,$current_year,$current_year,$current_year,$current_year,$current_year,$current_year,$current_year,$next_year,$next_year,$next_year];
       return $list = array($month,$year);
    }//function

    function get_all_year_list_from_given($current_year,$till_year)
	{
       $years = array();
       $diff = $current_year-$till_year;
       for($i=0;$i<=$diff;$i++){
            $years[] = $till_year+$i;
       }
       return $years;
    }//function


    function get_array_filter_remove_zero_or_blank($array)
	{
        return $filtered = array_filter($array, function($value) {
            return $value !== "" && $value !== null && $value > 0;
        });
    }//function













    //concvet no in 4 digit
    public function convert_no_to_max_digit($input,$no)
	{
        return str_pad($input, $no, "0", STR_PAD_LEFT);
    }//function close



    




























    //add multiple array
    public function add_multi_array($grand_total)
	{
        $sum = array();
        foreach ($grand_total as $key => $sub_array) {
            foreach ($sub_array as $sub_key => $value) {

                //If array key doesn't exists then create and initize first before we add a value.
                //Without this we will have an Undefined index error.
                if( ! array_key_exists($sub_key, $sum)) $sum[$sub_key] = 0;

                //Add Value
                $sum[$sub_key]+=$value;
            }
        }
        //print_r($sum);
        return $sum;
    }//function close

    
    //avg multiple array
    public function avg_multi_array1($grand_total)
	{
        $sum = array();
        foreach ($grand_total as $key => $sub_array) {
            foreach ($sub_array as $sub_key => $value) {
                //$sum[$sub_key]+=$value;
                if( ! array_key_exists($sub_key, $sum)) $sum[$sub_key][] = 0;
                $sum[$sub_key][]=$value;
            }
        }
        //print_r($sum[2]);
        return $sum;
    }//function close

    //avg multiple array
    public function avg_multi_array2($array_list)
	{
        $avg = 0;
        if(!empty($array_list)){
            $count =  count($array_list)-1;
            $avg = round(array_sum($array_list)/$count);
        }
       return $avg;
    }//function close




    //random color
    public function get_random_color()
	{
		return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }//function close


    //random color list
    public function get_random_color_list($no)
	{
        $color_name = array();
        for($i=1;$i<=$no;$i++)
        {
            $color_name[] = $this->get_random_color();
        }
        return $color_name;
    }//function close




    public function emp_details_from_emp_code($id)
	{
        $company_id = $this->session->userdata('company_id');
        $query6 =" SELECT profile_pic,first_name,last_name FROM employee WHERE id='$id' and company_id='$company_id'";
        return $out6 = $this->Mymodel->query1($query6);
    }

    public function emp_dp_from_emp_code($emp_code,$height,$weight)
	{
        $company_id = $this->session->userdata('company_id');
        $query6 =" SELECT profile_pic,first_name,last_name FROM employee WHERE emp_code='$emp_code' and company_id='$company_id' ";
        $out6 = $this->Mymodel->query1($query6);
        if(!empty($out6))
        {
            $name = $out6[0]['first_name'].' '.$out6[0]['last_name'];
            $pic_name = $out6[0]['profile_pic'];
            $img_url = base_url().'pic/'.$company_id.'/employee/dp/'.$pic_name;
            if (!file_exists($img_url)) 
            {   
                ?>
                    <a target="_blank"   href="<?php echo $img_url;?>">
                        <div class="ul-widget-s5__pic" style="float:left;"><img id="userDropdown" title="<?php echo $name;?>" style="height:<?php echo $height;?>px; width:<?php echo $weight;?>px;" src="<?php echo $img_url;?>" alt="<?php //echo $name;?>"  aria-haspopup="true" aria-expanded="false" /></div>
                    </a>
                <?php
            }
        }
    }//hr attendance dept list









    public function hr_attendance_dept_list_all()
	{
        $query6 =" SELECT details1 FROM company_profile WHERE id=21 ";
        $out6 = $this->Mymodel->query1($query6);
        $deptlist = array();
        if(!empty($out6))
        {
            $deptlist = explode(',',$out6[0]['details1']);
        }
        return $deptlist;
    }//hr attendance dept list

    public function hr_attendance_dept_list_all_nick_name()
	{
        $query6 =" SELECT details3 FROM company_profile WHERE id=21 ";
        $out6 = $this->Mymodel->query1($query6);
        $deptlist = array();
        if(!empty($out6))
        {
            $deptlist = explode(',',$out6[0]['details3']);
        }
        return $deptlist;
    }//hr attendance dept list
    
   
    public function get_dept_name_from_random_name($name)
	{
        $t = 0; $s = 0; $o = 0; $h = 0;
        //if($name == 'Office'){ $dept_id = '1,7,16,19'; $t=4; $s=3;$o=0;$h=1; }
        if($name == 'IT'){ $dept_id = 1; $t=1; $s=1;$o=0;$h=0; }
        elseif($name == 'HR'){ $dept_id = 7; $t=1; $s=1;$o=0;$h=0;}
        elseif($name == 'Account'){ $dept_id = 16; $t=1; $s=1;$o=0;$h=0;}
        elseif($name == 'Pantry'){ $dept_id = 19; $t=1; $s=0;$o=0;$h=1;}
        
        
        
        elseif($name == 'PPC'){ $dept_id = 53; $t=1; $s=1;$o=0;$h=0;}
        elseif($name == 'STORE'){ $dept_id = 2; $t=2; $s=0;$o=2;$h=0;}
        elseif($name == 'QUALITY'){ $dept_id = 3; $t=7; $s=1;$o=5;$h=1;}
        elseif($name == 'DIE ROOM'){ $dept_id = 18; $t=7; $s=1;$o=5;$h=1;}
        elseif($name == 'PAINTER'){ $dept_id = 54; $t=1; $s=0;$o=1;$h=0;}
        elseif($name == 'E.T.P'){ $dept_id = 55; $t=1; $s=0;$o=1;$h=0;}
        elseif($name == 'HYDRA  & FORKLIFT'){ $dept_id = '52,58'; $t=2; $s=0;$o=2;$h=0;}
        elseif($name == 'SWEEPER'){ $dept_id = 56; $t=2; $s=0;$o=0;$h=2;} 
        elseif($name == 'CIVIL'){ $dept_id = 49; $t=2; $s=0;$o=1;$h=1;}
        elseif($name == 'SECURITY'){ $dept_id = 23; $t=4; $s=0;$o=4;$h=0;}
        elseif($name == 'ELECT'){ $dept_id = 48; $t=8; $s=2;$o=5;$h=1;}
        elseif($name == 'MECH'){ $dept_id = 37; $t=16; $s=1;$o=12;$h=1;}
        elseif($name == 'PICKLING'){ $dept_id = 31; $t=6; $s=0;$o=3;$h=4;}
        elseif($name == 'MINI-BLOCK'){ $dept_id = 28; $t=24; $s=0;$o=12;$h=12;}
        elseif($name == 'WIRE DRAWING'){ $dept_id = 6; $t=36; $s=2;$o=16;$h=16;}
        elseif($name == 'WET'){ $dept_id = 5; $dept_id = 5; $t=48; $s=2;$o=42;$h=4;}
        elseif($name == 'Standing'){ $dept_id = 11; $t=48; $s=2;$o=42;$h=4;}
        elseif($name == 'GI. PATT.'){ $dept_id = '29,32'; $t=26; $s=2;$o=24;$h=0;}
        elseif($name == 'DISPATCH & PACKING'){ $dept_id = '4,30'; $t=22; $s=2;$o=0;$h=21;}
        elseif($name == 'Cont.'){ $dept_id = 57; $t=0; $s=0;$o=0;$h=0;}
        else{$dept_id = 0; $t=0; $s=0;$o=0;$h=0;} 
       

        $result = array($dept_id,$s,$o,$h,$t);
        return $result;
    }//function close

    





    //encryption
    public function encode($str)
    {
    return  urlencode ($str);
    }//function close


    //deencryption
    public function decode($encryption)
    {
        return base64_decode($encryption);
    }//function close
 





    

    //---------------------------------------------------MAIL SEND
    public function send_mail($toemail,$subject,$mesg)
	{
        $out = $this->Company->mail_details();
        $smtp_host = $out[0]['details3']; //mail.rkserp.com
        $smtp_port = $out[0]['details4']; //587
        $smtp_user = $out[0]['details5']; //system@rkserp.com
        $smtp_pass = $out[0]['details6']; //xmh9qepnazb2
        $tittle = $out[0]['details1']; // RKS Steel Industries Pvt Ltd - ERP
        $cc_mail = array($out[0]['details7']); //other mail id 1
        $bcc_mail = array($out[0]['details8']);//other mail id 2
       
        $config = Array(        
            'protocol' => 'smtp',
            'smtp_host' => $smtp_host, //mail.rkserp.com
            'smtp_port' =>  $smtp_port,    //587
            'smtp_user' => $smtp_user, //email id
            'smtp_pass' => $smtp_pass,  //passwrod
            'smtp_timeout' => '4',
            'mailtype'  => 'html', 
            'charset'   => 'utf-8',
            'wordwrap' => TRUE
        );
       
        

        $this->load->library('email', $config);
        $fromemail = $smtp_user;
        $this->email->initialize($config);
        $this->email->to($toemail);
        $this->email->from($fromemail, $tittle);
        $this->email->subject($subject);
        $this->email->cc($cc_mail);
        $this->email->bcc($bcc_mail);
        $this->email->message($mesg);
        //$mail = $this->email->send();

        if ($this->email->send()) {
            echo 'Save';
        } else {
            //show_error($this->email->print_debugger());
            echo 'Mail Not Sent';
        }
    }//function close


     //---------------------------------------------------MAIL SEND
     public function send_po_mail($toemail,$subject,$mesg)
     {
        $out = $this->Company->mail_details();
        $smtp_host = $out[0]['details3']; //mail.rkserp.com
        $smtp_port = $out[0]['details4']; //587
        $smtp_user = $out[0]['details5']; //system@rkserp.com
        $smtp_pass = $out[0]['details6']; //xmh9qepnazb2
        $tittle = $out[0]['details1']; // RKS Steel Industries Pvt Ltd - ERP
        $cc_mail = array($out[0]['details7']); //other mail id 1
        $bcc_mail = array($out[0]['details8']);//other mail id 2
    

        $config = Array(        
            'protocol' => 'smtp',
            'smtp_host' => $smtp_host, //mail.rkserp.com
            'smtp_port' =>  $smtp_port,    //587
            'smtp_user' => $smtp_user, //email id
            'smtp_pass' => $smtp_pass,  //passwrod
            'smtp_timeout' => '4',
            'mailtype'  => 'html', 
            'charset'   => 'utf-8',
            'wordwrap' => TRUE
        );
    

        $this->load->library('email', $config);
        $fromemail = $smtp_user;
        $this->email->initialize($config);
        $this->email->to($toemail);
        $this->email->from($fromemail, $tittle);
        $this->email->subject($subject);
        //$this->email->cc($cc_mail);
        //$this->email->bcc($bcc_mail);
        $this->email->message($mesg);
        //$mail = $this->email->send();

        if ($this->email->send()) {
            //echo 'Save';
        } else {
            //show_error($this->email->print_debugger());
            echo 'Mail Not Sent';
        }
     }//function close


    


    /*
    not in use this function
    //---------------------------------------------------MAIL SEND
    public function send_mail_test($toemail,$subject,$mesg)
	{
        
        
        $customer_id = 87;

        //getting data form RKS ERP
        $url = base_url()."index.php/Welcome/mail_type_1_body?customer_id=$customer_id";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $mail_body = curl_exec($ch);

        $toemail = "kingmanu12801@gmail.com";
        $subject = "RKS Steel Industries Pvt Ltd - ERP";
        $mesg = $mail_body;


       // $out = $this->Company->mail_details();
        $smtp_host = "mail.rkssteel.in"; //mail.rkserp.com
        $smtp_port = 587; //587
        $smtp_user ="it@rkssteel.in"; //system@rkserp.com
        $smtp_pass = "itekss@123"; //xmh9qepnazb2
        $tittle = "RKS Steel Industries Pvt Ltd - ERP"; // 
        $cc_mail = "";
        $bcc_mail ="";
       
        

        $config = Array(        
            'protocol' => 'smtp',
            'smtp_host' => $smtp_host, //mail.rkserp.com
            'smtp_port' =>  $smtp_port,    //587
            'smtp_user' => $smtp_user, //email id
            'smtp_pass' => $smtp_pass,  //passwrod
            'smtp_timeout' => '4',
            'mailtype'  => 'html', 
            'charset'   => 'utf-8',
            'wordwrap' => TRUE
        );
       


        $this->load->library('email', $config);
        $fromemail = $smtp_user;
        $this->email->initialize($config);
        $this->email->to($toemail);
        $this->email->from($fromemail, $tittle);
        $this->email->subject($subject);
       // $this->email->cc($cc_mail);
       // $this->email->bcc($bcc_mail);
        $this->email->message($mesg);
        if ($this->email->send()) {
            echo 'Email sent successfully.';
        } else {
            echo 'Email could not be sent. Error: ' . $this->email->print_debugger();
        }
    }//function close
    */





    function money($amount)
    {

        $amount = round($amount,2);

        $amountArray =  explode('.', $amount);
        if(count($amountArray)==1)
        {
            $int = $amountArray[0];
            $des=00;
        }
        else {
            $int = $amountArray[0];
            $des=$amountArray[1];
        }
        if(strlen($des)==1)
        {
            $des=$des."0";
        }
        if($int>=0)
        {
            $int = $this->numFormatIndia( $int );
            $themoney = $int.".".$des;
        }

        else
        {
            $int=abs($int);
            $int = $this->numFormatIndia( $int );
            $themoney= "-".$int.".".$des;
        }   
        return $themoney;
    }

    function numFormatIndia($num)
    {

        $explrestunits = "";
        if(strlen($num)>3)
        {
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if($i==0) {
                    $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; // writes the final format where $currency is the currency symbol.
    }


   

    //Get Breaking load category
    function get_breakingload_category($min_load,$max_load,$current_load)
    {
       // echo " ".$min_load." ".$max_load." ".$current_load;
        $diff = round(($max_load-$min_load)/3);
        $gap1 = round($min_load + $diff);
        $gap2 = round($min_load + $diff + $diff);
        
        if($current_load < $min_load){
            $category = 1;
        }
        elseif($current_load >=  $min_load && $current_load <=  $gap1){
            $category = 2;
        }
        elseif($current_load >  $gap1 && $current_load <=  $gap2){
            $category = 3;
        }
        elseif($current_load >  $gap2 && $current_load <=  $max_load){
            $category = 4;
        }
        elseif($current_load > $max_load){
            $category = 5;
        }
        else{
            $category = 0;
        }
        //return $category;
        
        return array($current_load,$diff,$min_load,$gap1,$gap2,$max_load,$category);
    }//function close

     //Get Breaking load min-max
     function get_breakingload_min_max($min_load,$gap1,$gap2,$max_load,$category)
     {
         if($category == 1){ $minmax = "(< $min_load)";}
         elseif($category == 2){ $minmax = "($min_load - $gap1)";}
         elseif($category == 3){ $minmax = "($gap1 - $gap2)";}
         elseif($category == 4){ $minmax = "($gap2 - $max_load)";}
         elseif($category == 5){ $minmax = "($max_load <)";}
         else{ $minmax = ' '; }
 
         return $minmax;
     }//function close


    //Get Breaking load color
    function get_breakingload_color($category)
    {
        if($category == 1){ $color = 'purple';}
        elseif($category == 2){ $color = 'blue';}
        elseif($category == 3){ $color = 'green';}
        elseif($category == 4){ $color = 'red';}
        elseif($category == 5){ $color = '#09b8e8';}
        else{ $color = 'white'; }

        return $color;
    }//function close


    function get_uts_from_breakingload_size($breakingload, $size)
    {
        if($breakingload > 0 && $size > 0){
            return round((float)$breakingload / ((float)$size * (float)$size * 0.785),2);
        }else{
            return 0;
        }
        
    }//function close



    // attendance function 3
	function get_attendance_p_a($data,$ot_hrs)
	{
			if($data=='P'){$out = 'P';     $color = 'background-color:green;color:white; padding-left:5px;';}
			elseif($data=='A'){$out = 'A'; $color = 'background-color:red;color:white;padding-left:5px;';}
            elseif($data=='L'){$out = 'L'; $color = 'background-color:orange;color:white;padding-left:5px;';}
            elseif($data=='R'){$out = 'R'; $color = 'background-color:purple;color:white;padding-left:5px;';}
			elseif($data=='H'){$out = 'H'; $color = 'background-color:yellow;color:black;padding-left:5px;';}
			elseif($data=='S'){$out = 'S'; $color = 'background-color:blue;color:white;padding-left:5px;'; }
			elseif($data=='SL'){$out = 'SL'; $color = 'background-color:blue;color:white;padding-left:5px;'; }
			elseif($data=='SL'){$out = 'SL'; $color = 'background-color:purple;color:white;padding-left:5px;'; }
			elseif($data=='CL'){$out = 'CL'; $color = 'background-color:purple;color:white;padding-left:5px;'; }
			elseif($data=='EL'){$out = 'EL'; $color = 'background-color:purple;color:white;padding-left:5px;'; }
			elseif($data=='EL'){$out = 'EL'; $color = 'background-color:purple;color:white;padding-left:5px;'; }
			elseif($data=='OL'){$out = 'OL'; $color = 'background-color:purple;color:white;padding-left:5px;'; }
			elseif($data==NULL){$out = '';$color = '';}
			else{$out = '';$color = '';}
		  
		  	//print_r($data);
		  	//$res = "<td style='$color'>$out</td>";
		   	
			if($ot_hrs > 0){$ot_hrs2 = $ot_hrs;}  else{$ot_hrs2 = '';}
			//return $res = "<td style='$color'>$out<br>$ot_hrs2</td>";
            return $res = "<td style='$color'>$out</td>";
	}//function


    function data_to_table($data)
	{
         $html = "<table class='table table-bordered table-sm'>";
        
        // Table Header
        $html .= "<tr style='background-color:aliceblue;'>";
        foreach (array_keys($data[0]) as $key) {
            $html .= "<th>" . htmlspecialchars($key) . "</th>";
        }
        $html .= "</tr>";
        
        // Table Rows
        foreach ($data as $row) {
            $html .= "<tr>";
            foreach ($row as $value) {
                $html .= "<td>" . htmlspecialchars($value) . "</td>";

               
            }
            $html .= "</tr>";
        }

        $html .= "</table><br>";
        return $html;
    }//function














    //Check Attendane lock or not 
    public function atten_lock_check($date,$emp_id)
    {
        $company_id = $this->session->userdata('company_id');  
        $month = (int)date('m', strtotime($date)); // 01
        $year  = date('Y', strtotime($date)); // 2026

        $lock = $this->db->query(
			"SELECT att_monthly_id
			FROM daily_attendance_monthly
			WHERE emp_code=? AND att_month=? AND att_year=? AND company_id = ? AND edit_disable=1
			LIMIT 1",
			[$emp_id,$month,$year,$company_id]
		)->row_array();

		if ($lock) {
			return true;
		}
        return false;
    }



    /* =====================================================
       SHIFT DETECT (API2)
    ===================================================== */
    public function calculateShiftForApi2($punch_ts)
    {
        $date = date('Y-m-d', $punch_ts);

        $dbShifts = $this->Base->get_all_active_shifts();
        if (empty($dbShifts)) {
            return 'A'; // hard fallback
        }

        // ---------- 1️⃣ NIGHT / CROSS-DAY SHIFTS FIRST ----------
        foreach ($dbShifts as $s) {

            $cfg = $this->getShiftConfig($s['shift_code'], $date);

            if ($cfg['cross_day']) {

                $start = strtotime('-2 hours', strtotime($cfg['in']));
                $end   = strtotime('+2 hours', strtotime($cfg['out2']));

                if ($punch_ts >= $start && $punch_ts <= $end) {
                    return $s['shift_code'];
                }
            }
        }

        // ---------- 2️⃣ DAY SHIFTS ----------
        foreach ($dbShifts as $s) {

            $cfg = $this->getShiftConfig($s['shift_code'], $date);
            $in  = strtotime($cfg['in']);

            if ($punch_ts >= strtotime('-2 hours', $in) &&
                $punch_ts <= strtotime('+2 hours', $in)) {
                return $s['shift_code'];
            }
        }

        // ---------- 3️⃣ FINAL FALLBACK ----------
        return $dbShifts[0]['shift_code'];
    }



    public function getShiftConfig($shift, $punch_date)
    {
       
        $next_day = date('Y-m-d', strtotime($punch_date . ' +1 day'));

        $dbShifts = $this->Base->get_all_active_shifts();

        $map = [];

        foreach ($dbShifts as $s) {

            $in_time  = $s['in_time'];
            $out_time = $s['out_time'];
            $out2_time = $s['out_time_ot'];

            // detect cross day shift
            $cross_day = (strtotime($out_time) <= strtotime($in_time));

            $out_date  = $cross_day ? $next_day : $punch_date;

            $map[$s['shift_code']] = [
                'in'        => $punch_date . ' ' . $in_time,
                'out'       => $out_date . ' ' . $out_time,
                'out2'      => $out_date . ' ' . $out2_time,
                'cross_day' => $cross_day
            ];
        }

       
        // fallback protection
        return $map[$shift] ?? reset($map);
    }


    public function calculateDutyAndOT(
        $status,
        $in_datetime,
        $out_datetime,
        $shiftConfig,
        $get_overtime,
        $restday,
        $day_name,
        $working_hr,
        $manual_ot,
        $late_punch_add
    ) {
        // HARD DEFAULT
        if (empty($working_hr) || $working_hr <= 0) {
            $working_hr = 8;
        }

        $res = [
            'duty' => $status,
            'full_day_duty' => 'A',
            'duty_hours' => 0,
            'ot_hours' => $manual_ot,
            'in_min' => 0,
            'out_min' => 0,
            'in_status' => '',
            'out_status' => '',
            'duty_type' =>  $status,
            'extra_min' => 0
        ];

        $status = $status ?: 'A';

         if (empty($in_datetime) || empty($out_datetime)) {
            return $res;
        }

        $in_ts  = strtotime($in_datetime);
        $out_ts = strtotime($out_datetime);
        if (!$in_ts || !$out_ts) return $res;

        /* ================= CROSS DAY ================= */
        if (!empty($shiftConfig['cross_day']) && $out_ts < $in_ts) {
            $out_ts = strtotime('+1 day', $out_ts);
        }
        if ($out_ts <= $in_ts){ 
            // if ($late_punch_add === 'Yes' and $status ==='R') {
            //     $res['duty'] = 'A';
            //     $res['ot_hours'] = 0;
            // }
            return $res;
        }
        

        /* ================= DUTY HOURS ================= */
        $worked_hours = round(($out_ts - $in_ts) / 3600, 2);
        $res['duty_hours'] = $worked_hours;

       

        /* ================= WEEK OFF ================= */
        if ($status === 'WO') {
            if ($late_punch_add === 'Yes') {
                $res['duty'] = 'A';
                $res['full_day_duty'] = 'R';
                return $res;
            }else{
                $res['duty'] = 'R';
                $res['full_day_duty'] = 'R';
                return $res;
            }
           
        }

        /* ================= ABSENT ================= */
        if ($status === 'A') {
            if ($restday === $day_name) {
                $res['duty'] = 'R';
                $res['full_day_duty'] = 'R';
            }
            return $res;
        }
      

        /* ================= HALF DAY ================= */
        if (in_array($status, ['HALF','½P'], true)) {
            $res['duty'] = 'HA';
            $res['full_day_duty'] = 'H';
            return $res;
        }

       
        /* ================= IN STATUS ================= */
        $shift_in = strtotime($shiftConfig['in']);
        if ($in_ts > $shift_in) {
            $res['in_min'] = round(($in_ts - $shift_in) / 60);
            $res['in_status'] = 'L';
        } elseif ($in_ts < $shift_in) {
            $res['in_min'] = round(($shift_in - $in_ts) / 60);
            $res['in_status'] = 'E';
        }

        /* ================= OUT STATUS ================= */
        $shift_out = strtotime($shiftConfig['out2']);
        if ($out_ts > $shift_out) {
            $res['out_min'] = round(($out_ts - $shift_out) / 60);
            $res['out_status'] = 'L';
        } elseif ($out_ts < $shift_out) {
            $res['out_min'] = round(($shift_out - $out_ts) / 60);
            $res['out_status'] = 'E';
        }

       
        /* ================= REST DAY ================= */
        // if ($status == 'R' || $restday === $day_name) {

        //     $res['duty'] = 'R';
        //     $res['full_day_duty'] = 'R';

        //     $worked_minutes = round(($out_ts - $in_ts) / 60);
        //     // OLD BEHAVIOR: FULL OT
        //     if($manual_ot > 0){
        //         $res['ot_hours'] = $manual_ot;
        //     }else{
        //         $res['ot_hours'] = $worked_hours; // FULL OT
        //     }
        //     return $res;
        // }


        if (in_array($status, ['T','WOP'], true)  || $restday === $day_name) {

            $res['duty'] = 'R';
            $res['full_day_duty'] = 'R';

            $worked_minutes = round(($out_ts - $in_ts) / 60);

            if ($late_punch_add === 'Yes') {
                // STRICT RULE: NO OT, ONLY EXTRA MINUTES
                $res['duty'] = 'T';
                $res['ot_hours'] = 0;
                $res['extra_min'] = max(0, $worked_minutes);
            } else {
                // OLD BEHAVIOR: FULL OT
                if($manual_ot > 0){
                    $res['ot_hours'] = $manual_ot;
                }else{
                    $res['ot_hours'] = $worked_hours; // FULL OT
                }
                
            }

            return $res;
        }


        /* ================= PRESENT ================= */
        if ($status === 'P') {
            $res['duty'] = 'P';
            $res['full_day_duty'] = 'F';

            if ($get_overtime === 'Yes') {
                if ($worked_hours > $working_hr) {
                    $ot = $worked_hours - $working_hr;

                    if($manual_ot > 0){
                        $res['ot_hours'] = $manual_ot;
                    }else{
                        // ROUND SAME AS OLD LOGIC
                        $ot = round($ot, 1);
                        $res['ot_hours'] = (fmod($ot, 1) == 0.5) ? $ot : round($ot);
                    }
                }
            }
        }

        if($res['out_status'] == 'L' && $res['out_min'] > 0){
            // ADD EXTRA MINUTES IF LATE PUNCH OUT
            $res['extra_min'] += $res['out_min'];
        }

        if($status === 'P' && $res['out_status'] == 'E' && $res['out_min'] > 0){
           $res['extra_min'] -= $res['out_min'];
        }

        if($res['extra_min'] < 0){
            $res['extra_min'] = 0;
        }

        
        return $res;
    }


    /* =========================================================
   COMMON CORE FUNCTION (USE EVERYWHERE) attendance_entry_manual_save_employee_wise,emp_attend_api2
   ========================================================= */
  public function processAttendanceCore(array $p)
    {
        $company_id = $this->session->userdata('company_id'); 

        $emp_id     = $p['emp_id'];
        $emp_code   = $p['emp_code'];
        $bio_code   = $p['bio_code'];
        $company_role   = $p['company_role'];
        $status     = strtoupper($p['status']);
        $att_date   = $p['att_date'];
        $in_dt      = $p['in_dt']; 
        $out_dt     = $p['out_dt'];
        $dutyMin     = $p['dutyMin'];
        $get_ot     = $p['get_ot'];
        $restday    = $p['restday'];
        $working_hr = $p['working_hr'] ?? 8;
        $source     = $p['source'];
        $location   = $p['location'];
        $late_punch_add   = $p['late_punch_add'] ?? "No";
        $save_by    = $p['save_by'];

        $manual_duty    = $p['manual_duty']    ?? null;   // 👈 manual duty 
        $manual_ot    = $p['manual_ot']    ?? null;   // 👈 manual OT
        $manual_shift = $p['manual_shift'] ?? null;   // 👈 manual shift
        $attenid      = $p['attenid']      ?? null;   // 👈 daily_attendance id

        $day_name = date('l', strtotime($att_date));

        //get emp shift
        $query=" SELECT current_shift FROM employee where id='$emp_id'  and company_id='$company_id' ";
        $shiftData = $this->Mymodel->query1($query);
        if(!empty($shiftData)){
            if($shiftData[0]['current_shift'] != 'A' and $shiftData[0]['current_shift'] != 'B'){
                 $shift = $shiftData[0]['current_shift'];
            }else{
              $shift = $in_dt ? $this->calculateShiftForApi2(strtotime($in_dt)) : 'A';
            }
        }else{
            $shift = $in_dt ? $this->calculateShiftForApi2(strtotime($in_dt)) : 'A';
        }

        /* ========= SHIFT RESOLUTION ========= */
        if (!empty($manual_shift)) {
            $shift = $manual_shift;
        } 

        if ($shift === "B" && !empty($in_dt) && !empty($out_dt)) {

            $inTime  = strtotime($in_dt);
            $outTime = strtotime($out_dt);

            // Only if OUT is earlier than IN → means next day punch
            if ($outTime < $inTime) {
                $out_dt = date("Y-m-d H:i:s", $outTime + 86400);
            }
        }

      
      
        $cfg = $this->getShiftConfig($shift, $att_date);
        $cfg['shift'] = $shift;
        

        /* ========= CALC ========= */
        $calc = $this->calculateDutyAndOT(
            $status,
            $in_dt,
            $out_dt,
            $cfg,
            $get_ot,
            $restday,
            $day_name,
            $working_hr,
            $manual_ot,
            $late_punch_add
        );
        
        /* ========= MANUAL OT OVERRIDE ========= */
        if (empty($calc['ot_hours'])) {
            $calc['ot_hours'] =0;
        }

       

        $in_time_mc = "0000-00-00 00:00:00";
        $out_time_mc = "0000-00-00 00:00:00";
        if($source == 'API2'){
            $in_time_mc = $in_dt;
            $out_time_mc = $out_dt;
        }

        //extra min 
        $extra_min = $calc['extra_min'];
        if($calc['duty_hours'] < $working_hr){
            $extra_min = 0;
        }

        // if ($dutyMin < 1 && $calc['duty_hours'] > 0) {
        //    $dutyMin = floor($calc['duty_hours'] * 60);
        // }
       
        
        /* ========= DAILY ATTENDANCE ========= */
        $save = [
            'entry_date'           => $cfg['in'],//current date time
            'company_id'          => $company_id,
            'emp_code'          => $emp_code,
            'bio_code'          => $bio_code,
            'shift'             => $shift,
            'shift_in_time'     => $cfg['in'],
            'shift_out_time'    => $cfg['out'],
            'shift_out_time2'   => $cfg['out2'],
            'in_time'           => $in_dt,
            'out_time'          => $out_dt,
            'in_time_mc'        => $in_time_mc,
            'out_time_mc'       => $out_time_mc,
            'in_min_late_early' => $calc['in_min'],
            'out_min_late_early'=> $calc['out_min'],
            'in_status'         => $calc['in_status'],
            'out_status'        => $calc['out_status'], 
            'duty_hours'        => $calc['duty_hours'],
            'dutyMin'        => $dutyMin,
            'full_day_duty'     => $calc['full_day_duty'],
            'ot_hours'          => $calc['ot_hours'],
            'extra_min'          =>  $extra_min,
            'duty_type'          => $calc['duty_type'],
            'get_ot'            => $get_ot,
            'save_from'         => $source,
            'location'          => $location
        ];

        // ================= AUTO DETECT EXISTING ENTRY (API2 SAFE) =================
        if (empty($attenid)) {
            $existing = $this->db
                ->select('id')
                ->from('daily_attendance')
                ->where('emp_code', $emp_code)
                ->where('company_id', $company_id)
                ->where('DATE(in_time)', $att_date)
                ->limit(1)
                ->get()
                ->row_array();

            if ($existing) {
                $attenid = $existing['id']; // 🔥 FORCE UPDATE
            }
        }


        if (!empty($attenid)) {
            // UPDATE
            $save['update_by']   = $save_by;
            $save['update_date']= date('Y-m-d H:i:s');

            $this->db->where('id', $attenid)
                    ->update('daily_attendance', $save);
        } else {
            // INSERT
            $save['save_by']   = $save_by;
            $save['save_date']= date('Y-m-d H:i:s');

            $this->db->insert('daily_attendance', $save);
        }

        /* ========= MONTHLY ========= */
        $day   = date('j', strtotime($att_date));
        $month = date('n', strtotime($att_date));
        $year  = date('Y', strtotime($att_date));

        $dcol = "d{$day}";
        $ocol = "o{$day}";

        $row = $this->db->get_where('daily_attendance_monthly', [
            'company_id'  => $company_id,
            'emp_code'  => $emp_id,
            'att_year'  => $year,
            'att_month' => $month
        ])->row_array();

        // if(!empty($manual_duty)) {
        //     $calc['duty'] = $manual_duty;
        // }

        if ($row) {
            $this->db->where('att_monthly_id', $row['att_monthly_id'])->where('company_id', $company_id)
                    ->update('daily_attendance_monthly', [
                        $dcol => $calc['duty'],
                        $ocol => $calc['ot_hours'],
                        'update_by'   => $save_by,
                        'update_date'=> date('Y-m-d H:i:s')
                    ]);
            return $row['att_monthly_id'];
        }

        $this->db->insert('daily_attendance_monthly', [
            'company_id'  => $company_id,
            'emp_code'  => $emp_id,
            'att_year'  => $year,
            'att_month' => $month,
            'company_role_id' => $company_role,
            $dcol       => $calc['duty'],
            $ocol       => $calc['ot_hours'],
            'save_by'   => $save_by,
            'save_date' => date('Y-m-d H:i:s')
        ]);

        return $this->db->insert_id();
    }


    public function cal_min_into_days_latepunch($late_punch_minutes,$working_hr)
    {
        if(empty($working_hr) || $working_hr <=0)
        {
            $working_hr = 8;
        }  
        $late_hours = $late_punch_minutes / 60;
       
        // RULE 1: 4 hour grace – no credit
        if ($late_hours <= 4) {
            $late_punch_days = 0;
        } else {

            // RULE 2: half day slab
            $half_day_hours = $working_hr / 2; // e.g. 12 → 6

            // RULE 3: grace ke baad ka kaam
            $effective_hours = $late_hours - 4;

            // RULE 4: employee loss na ho → ROUND UP
            $late_punch_days = ceil($effective_hours / $half_day_hours) * 0.5;

            // RULE 5: monthly cap (company safety)
            if ($late_punch_days > 3) {
                $late_punch_days = 3; // max 3 days/month
            }
        }
       
        return $late_punch_days;
    }   


    public function roud_days($total_present_days_raw)
    {
        return $total_present_days = floor($total_present_days_raw) 
        + (
            ($total_present_days_raw - floor($total_present_days_raw)) < 0.25 ? 0 :
            (($total_present_days_raw - floor($total_present_days_raw)) < 0.75 ? 0.5 : 1)
        );
    }
    







}//class close



