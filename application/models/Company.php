<?php
class Company extends CI_Model
{
	//company name
	public function prime_company()
	{
        //$sql = "SELECT * FROM company_profile where id =1 ";
        $sql = "SELECT full_name,logo FROM company where prime_company =1 LIMIT 1 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function profile()
	{
        $company_id = $this->session->userdata('company_id');    
        //$sql = "SELECT * FROM company_profile where id =1 ";
        $sql = "SELECT * FROM company where company_id = '$company_id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //out gst details
    public function our_gst_details()
	{
        $company_id = $this->session->userdata('company_id');
        //$sql = "SELECT * FROM company_profile where id =4 ";
        $sql = "SELECT gstno FROM company where company_id = '$company_id' ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close

    


    
    //header color 
    public function design()
	{
        $company_id = $this->session->userdata('company_id');
        //$sql = "SELECT * FROM company_profile where id =3 ";
        $sql = "SELECT * FROM company where company_id = '$company_id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //table tr head bg-color 
    public function table_bg_color()
	{
        $company_id = $this->session->userdata('company_id'); 
        $sql = "SELECT design1_bg_color FROM company where company_id = '$company_id' ";   
        //$sql = "SELECT details1 FROM company_profile where id =3 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res[0]['design1_bg_color'];
    }//function close

    //table tr head bg-color 
    public function table_ft_color()
	{
        $company_id = $this->session->userdata('company_id'); 
        $sql = "SELECT design1_ft_color FROM company where company_id = '$company_id' "; 
        //$sql = "SELECT details2 FROM company_profile where id =3 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res[0]['design1_ft_color'];
    }//function close





    //suplier reg form
    public function supplier_reg_form_show()
	{
        //$sql = "SELECT * FROM company_profile where id =9 ";
        $company_id = $this->session->userdata('company_id');
        $sql = "SELECT * FROM company where company_id = '$company_id' ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close

    






    //customer reg form
    public function customer_reg_form_show()
	{
        //$sql = "SELECT * FROM company_profile where id =10 ";
        $company_id = $this->session->userdata('company_id');
        $sql = "SELECT * FROM company where company_id = '$company_id' ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close


    //customer_rate_entry_via_customer_add  
    public function customer_rate_entry_via_customer_add()
    {
        $company_id = $this->session->userdata('company_id');
        $sql = "SELECT bill_from_customer_rate FROM company where company_id = '$company_id'  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if($res[0]['bill_from_customer_rate'] == 'Yes')
        {
            return 'TRUE';
        }
        else
        {
            return 'FALSE'; 
        }
    }//function close







    
    //PO expire after no of days
    public function po_expire_after_days()
    {
        $sql = "SELECT details1 FROM company_profile where id = 11 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){return $res[0]['details1'];}else{return 1;}
    }//function close
   
    
    //check_po_expire_access_in_this_user
    public function check_po_expire_access_in_this_user($emp_id)
    {
        $sql = "SELECT details3 FROM company_profile where id = 11 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res))
        {
            $all_user = explode(',',$res[0]['details3']);
            if(in_array($emp_id,$all_user)){$msg = "TRUE";}else{$msg = "FALSE";}
        }
        else
        {
            $msg = "FALSE";
        }
        return $msg;
    }//function close

    //PO approval amt limit for GM
    public function po_approval_limit_amt_for_gm()
    {
        $sql = "SELECT details4 FROM company_profile where id = 11 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){return $res[0]['details4'];}else{return 1;}
    }//function close









    //tds
    public function dispatch_entry_charge_apply_tds()
    {
        $sql = "SELECT details2 FROM company_profile where id = 12 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if($res[0]['details2'] == 1){return 'TRUE'; }else{return 'FALSE';}
    }//function close


    //Amortisation
    public function dispatch_entry_charge_apply_amortisation()
    {
        $sql = "SELECT details4 FROM company_profile where id = 12 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if($res[0]['details4'] == 1){return 'TRUE'; }else{return 'FALSE';}
    }//function close


    //tcs
    public function dispatch_entry_charge_apply_tcs()
    {
        $sql = "SELECT details6 FROM company_profile where id = 12 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if($res[0]['details6'] == 1){return 'TRUE'; }else{return 'FALSE';}
    }//function close


    //tcs val
    public function dispatch_entry_charge_apply_tcs_val()
    {
        $sql = "SELECT details6,details7 FROM company_profile where id = 12 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if($res[0]['details6'] == 1){return $res[0]['details7']; }else{return "";}
    }//function close


    public function get_full_line_12()
    {
        $sql = "SELECT * FROM company_profile where id = 12 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    //default unit
    public function dispatch_entry_get_deafult_unit()
    {
        $sql = "SELECT details2 FROM company_profile where id = 13 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res)){return $res[0]['details2']; }
    }//function close

    //default rate come
    public function dispatch_entry_get_deafult_rate_come()
    {
        $sql = "SELECT details4 FROM company_profile where id = 13 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res)){return $res[0]['details4']; }
    }//function close

    //get_fin_year
    public function get_fin_year()
    {
        $sql = "SELECT details1 FROM company_profile where id = 14 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){return $res[0]['details1']; }else{ return date('Y');}
    }//function close

    

    //get_extra_dispatch_qty_per, add word , total bill no digit
    public function get_extra_dispatch_qty_per()
    {
        $sql = "SELECT * FROM company_profile where id = 13 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close




    //po invoice entry
    public function po_invoice_entry_details()
    {
        $sql = "SELECT details1 FROM company_profile where id =17 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['details1'];}else{return '';}
    }//function close


    public function po_invoice_entry_details_validation()
    {
        $sql = "SELECT details2 FROM company_profile where id =17 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['details2'];}else{return 'No';}
    }//function close
















    //------------------------------------------------------------mail details
	public function mail_details()
	{
        $sql = "SELECT * FROM company_profile where id =2 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //---all dispatch email id
    public function dispatch_email_list()
	{
        $sql = "SELECT details1 FROM company_profile where id =6 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['details1'];}else{return '';}
    }//function close



    //---all dispatch details
    public function dispatch_details()
	{
        $company_id = $this->session->userdata('company_id'); 
        $sql = "SELECT design1_ft_color FROM company where company_id = '$company_id' "; 
        //$sql = "SELECT * FROM company_profile where id =5 ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close


    public function dispatch_last_line_details()
    {
        $sql = "SELECT * FROM company_profile where id = 15 ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close


    



    //----------po
    public function po_print_details()
    {
        $sql = "SELECT * FROM company_profile where id = 16 ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close

    public function po_email_list()
    {
        $sql = "SELECT * FROM company_profile where id = 18 ";
        $query = $this->db->query($sql);
        return $res = $query->result_array();
    }//function close


    















    //----------------------------------------------------Chart DASHBOARD
    public function purchase_and_sale_chart($year,$month,$div_length)
    {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $from_date_last_month = $this->Base->get_last_full_date_of_lastmonth_fd_ymd($month,$year);
        $to_date_last_month = $this->Base->get_last_full_date_of_lastmonth_td_ymd($month,$year);
        
        
        //-----------------------------------Purchase this month
        $pur_rs_array = $this->Pomodel->get_total_purchase_in_rs('Consumable',$from_date,$to_date);
        if(!empty($pur_rs_array[0]['grandtotal_rs'])){$purchase_this_month_rs_cun = round($pur_rs_array[0]['grandtotal_rs']);}else{$purchase_this_month_rs_cun =0;}
        
        $pur_rs_array = $this->Pomodel->get_total_purchase_in_rs('Raw Material',$from_date,$to_date);
        if(!empty($pur_rs_array[0]['grandtotal_rs'])){$purchase_this_month_rs_raw = round($pur_rs_array[0]['grandtotal_rs']);}else{$purchase_this_month_rs_raw =0;}
        
        $pur_rs_array = $this->Pomodel->get_total_purchase_in_rs('All',$from_date,$to_date);
        if(!empty($pur_rs_array[0]['grandtotal_rs'])){$purchase_this_month_rs_all = round($pur_rs_array[0]['grandtotal_rs']);}else{$purchase_this_month_rs_all =0;}
       


        //-----------------------------------Purchase last month
        $pur_rs_array = $this->Pomodel->get_total_purchase_in_rs('Consumable',$from_date_last_month,$to_date_last_month);
        if(!empty($pur_rs_array[0]['grandtotal_rs'])){$purchase_last_month_rs_cun = round($pur_rs_array[0]['grandtotal_rs']);}else{$purchase_last_month_rs_cun =0;}
    
        $pur_rs_array = $this->Pomodel->get_total_purchase_in_rs('Raw Material',$from_date_last_month,$to_date_last_month);
        if(!empty($pur_rs_array[0]['grandtotal_rs'])){$purchase_last_month_rs_raw = round($pur_rs_array[0]['grandtotal_rs']);}else{$purchase_last_month_rs_raw =0;}
        
        $pur_rs_array = $this->Pomodel->get_total_purchase_in_rs('All',$from_date_last_month,$to_date_last_month);
        if(!empty($pur_rs_array[0]['grandtotal_rs'])){$purchase_last_month_rs_all = round($pur_rs_array[0]['grandtotal_rs']);}else{$purchase_last_month_rs_all =0;}
       

        $per1 = $this->Base->get_per($purchase_this_month_rs_cun,$purchase_last_month_rs_cun);
        $per2 = $this->Base->get_per($purchase_this_month_rs_raw,$purchase_last_month_rs_raw);
        $per3 = $this->Base->get_per($purchase_this_month_rs_all,$purchase_last_month_rs_all);

        //-----------------------------------Sales
        //total sale in rs this month
        $sale_rs_array = $this->Dispatchmodel->get_total_product_sale_in_rs('',$from_date,$to_date);
        if(!empty($sale_rs_array[0]['grand_total_rs'])){$sale_this_month_rs = round($sale_rs_array[0]['grand_total_rs']);}else{$sale_this_month_rs =0;}
        
        //total sale in rs last month
        $sale_rs_array = $this->Dispatchmodel->get_total_product_sale_in_rs('',$from_date_last_month,$to_date_last_month);
        if(!empty($sale_rs_array[0]['grand_total_rs'])){$sale_last_month_rs = round($sale_rs_array[0]['grand_total_rs']);}else{$sale_last_month_rs =0;}
        
        $per = $this->Base->get_per($sale_this_month_rs,$sale_last_month_rs);
        ?>
             <div class="row">
                <!-- helpline-->
                <div class="col-md-3 col-lg-3">
                    <div class="card mb-2 o-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="t-font-bolder">Consumable Pur.</h5><small class="text-muted">Last Month</small>
                                </div>
                                <div class="col-6 text-right">
                                    <h3 class="t-font-boldest"><?php echo $purchase_this_month_rs_cun;?></h3><small class="text-muted">Last Month : <?php echo $purchase_last_month_rs_cun;?></small>
                                </div>
                                <div class="col-12">
                                    <div class="progress mt-3">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width:<?php echo $per1;?>%" aria-valuenow="<?php echo $per1;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $per1;?>%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- service-->
                <div class="col-md-3 col-lg-3">
                    <div class="card mb-2 o-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="t-font-bolder">Raw Material Pur.</h5><small class="text-muted">Last Month</small>
                                </div>
                                <div class="col-6 text-right">
                                    <h3 class="t-font-boldest"><?php echo $purchase_this_month_rs_raw;?></h3><small class="text-muted">Last Month : <?php echo $purchase_last_month_rs_raw;?></small>
                                </div>
                                <div class="col-12">
                                    <div class="progress mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width:<?php echo $per2;?>%" aria-valuenow="<?php echo $per2;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $per2;?>%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- email-->
                <div class="col-md-3 col-lg-3">
                    <div class="card mb-2 o-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="t-font-bolder">Total Purchase</h5><small class="text-muted">Last Month</small>
                                </div>
                                <div class="col-6 text-right">
                                    <h3 class="t-font-boldest"><?php echo $purchase_this_month_rs_all;?></h3><small class="text-muted">Last Month : <?php echo $purchase_last_month_rs_all;?></small>
                                </div>
                                <div class="col-12">
                                    <div class="progress mt-3">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width:<?php echo $per3;?>%" aria-valuenow="<?php echo $per3;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $per3;?>%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- territory-->
                <div class="col-md-3 col-lg-3">
                    <div class="card mb-2 o-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="t-font-bolder">Sale</h5><small class="text-muted">Current Month</small>
                                </div>
                                <div class="col-6 text-right">
                                    <h3 class="t-font-boldest"><?php echo $sale_this_month_rs;?></h3><small class="text-muted">Last Month : <?php echo $sale_last_month_rs;?></small>
                                </div>
                                <div class="col-12">
                                    <div class="progress mt-3">
                                        <div class="progress-bar bg-success" role="progressbar" style="width:<?php echo $per;?>%" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $per;?>%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }//function close


    //menu function 
   public function get_access_by_role($role_id)
    {
        // main menus
        $menus = $this->db->select('menu_id')
            ->from('erp_role_permission')
            ->where('role_id', $role_id)
            ->get()->result_array();

        // sub menus
        $subMenus = $this->db->select('sub_menu_id')
            ->from('erp_role_permission')
            ->where('role_id', $role_id)
            ->where('sub_menu_id IS NOT NULL')
            ->get()->result_array();

        return [
            'menus' => array_column($menus, 'menu_id'),
            'sub_menus' => array_column($subMenus, 'sub_menu_id')
        ];
    }



    //menu function 
    public function get_all_main_menu()
    {
        $role_id = $this->session->userdata('login_role_in_department');

        if (empty($role_id)) {
            redirect('Welcome/');
            exit;
        }

        $sql = "
            SELECT DISTINCT M.*
            FROM erp_menu M
            INNER JOIN erp_role_permission RP 
                ON RP.menu_id = M.id
            WHERE RP.role_id = '$role_id'
            AND M.status = 'Active' AND M.show_in_list='Yes'
            ORDER BY M.menu_order ASC
        ";

        return $this->db->query($sql)->result_array();
    }


    public function get_all_sub_menu_from_main_id($menu_id)
    {
        $role_id = $this->session->userdata('login_role_in_department');

        $sql = "
            SELECT DISTINCT SM.*
            FROM erp_sub_menu SM
            INNER JOIN erp_role_permission RP
                ON (RP.sub_menu_id = SM.id OR RP.menu_id = SM.main_menu_id OR RP.menu_id = (SELECT main_menu_id FROM erp_sub_menu WHERE id = SM.main_menu_id))
            WHERE RP.role_id = '$role_id'
            AND SM.main_menu_id = '$menu_id'
            AND SM.status = 'Active' AND SM.show_in_list='Yes'
            AND (
                    RP.sub_menu_id IS NULL
                    OR RP.sub_menu_id = SM.id
                )
            ORDER BY SM.menu_order;

        ";

        return $this->db->query($sql)->result_array();
    }

    
    // public function get_all_sub_menu()
    // {
    //     $sql = "SELECT * FROM  erp_sub_menu  WHERE  status = 'Active'   ORDER by menu_order ASC ";
    //     $query = $this->db->query($sql);
    //     return $query->result_array();
    // }//function close

    function checkPermission($menu_id, $sub_menu_id = null)
    {
        $role_id = $this->session->userdata('login_role_in_department');

        if (empty($role_id)) {
            redirect('Welcome/');
            exit;
        }

        $sql = "
            SELECT 1
            FROM erp_role_permission
            WHERE role_id = '$role_id'  
            AND menu_id = '$menu_id'
            AND (
                    sub_menu_id IS NULL
                    OR sub_menu_id = '$sub_menu_id'
                )
            LIMIT 1
        ";

        $query = $this->db->query($sql, [
            $role_id,
            $menu_id,
            $sub_menu_id
        ]);

        if ($query->num_rows() === 0) {
            show_error('Unauthorized Access', 403);
            exit;
        }

        return true;
    }


    function checkPermission1($id_name)
    {
        $role_id = $this->session->userdata('login_role_in_department');
        $parts = explode('/', trim($id_name, '/'));
        if(count($parts) > 2){
            array_pop($parts);
        }
        $id_name = implode('/', $parts);


        $sql = "
            SELECT 1
            FROM erp_sub_menu SM
            INNER JOIN erp_role_permission RP
                ON (RP.sub_menu_id = SM.id OR RP.menu_id = SM.main_menu_id OR RP.menu_id = (SELECT main_menu_id FROM erp_sub_menu WHERE id = SM.main_menu_id))
            WHERE RP.role_id = '$role_id'
            AND SM.id_name = '$id_name'
            AND SM.status = 'Active'
            AND (
                    RP.sub_menu_id IS NULL
                    OR RP.sub_menu_id = SM.id
                )
            LIMIT 1
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() === 0) {
           echo 'Unauthorized Access';
           exit;
        }
    }

    //full link check
    function checkPermission2($id_name)
    {
        $role_id = $this->session->userdata('login_role_in_department');
        //$id_name = preg_replace('#/(\d+)$#', '', $id_name);

        $sql = "
            SELECT 1
            FROM erp_sub_menu SM
            INNER JOIN erp_role_permission RP
                ON (RP.sub_menu_id = SM.id OR RP.menu_id = SM.main_menu_id OR RP.menu_id = (SELECT main_menu_id FROM erp_sub_menu WHERE id = SM.main_menu_id))
            WHERE RP.role_id = '$role_id'
            AND SM.id_name = '$id_name'
            AND SM.status = 'Active'
            AND (
                    RP.sub_menu_id IS NULL
                    OR RP.sub_menu_id = SM.id
                )
            LIMIT 1
        ";

        $query = $this->db->query($sql);
        if ($query->num_rows() === 0) {
           echo 'Unauthorized Access';
           exit;
        }
    }

    //true /false
    function checkPermission3($id_name)
    {
        $role_id = $this->session->userdata('login_role_in_department');
        $id_name = preg_replace('#/(\d+)$#', '', $id_name);

        $sql = "
            SELECT 1
            FROM erp_sub_menu SM
            INNER JOIN erp_role_permission RP
                ON (RP.sub_menu_id = SM.id OR RP.menu_id = SM.main_menu_id OR RP.menu_id = (SELECT main_menu_id FROM erp_sub_menu WHERE id = SM.main_menu_id))
            WHERE RP.role_id = '$role_id'
            AND SM.id_name = '$id_name'
            AND SM.status = 'Active'
            AND (
                    RP.sub_menu_id IS NULL
                    OR RP.sub_menu_id = SM.id
                )
            LIMIT 1
        ";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
          return true;
        }
        return false;
    }














}//class close



