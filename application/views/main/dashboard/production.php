<?php 
    $search_month = date("m");
    $search_year = date('Y');
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1>Production</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>

            <?php 
                $this->Company->purchase_and_sale_chart($search_year,$search_month,12); 
                //$this->Dispatchmodel->get_sch_vs_sup_chart($search_year,$search_month,12);
            ?>

            <div class="row">
                <?php
                    //$this->Dispatchmodel->date_wise_sale_chart_display($search_year,$search_month,12);
                ?>
            </div>

            
            <div class="row">
                <?php 
                   //$this->Meetingmodel->mom_status_chart($search_year,$search_month,12); 
                   //$this->Maintenancemodel->break_down_status_chart($search_year,$search_month,12); 
                ?>
            </div>
            
            <div class="row">
                <?php 
                    $dept_list = $this->Base->get_all_production_dept();
                    $i=1;
                    foreach($dept_list as $d)
                    {
                        if($d['department_id'] == 11){
                            continue;//skip rope
                        }
                        $dept_id = $d['department_id'];
                        $dept_name = $d['name'];
                        //$this->Productionmodel->production_chart_display($search_year,$search_month,12,$dept_id,$dept_name);
                        $this->Productionmodel->production_machine_chart_display($search_year,$search_month,12,$dept_id,$dept_name);
                        // $this->Productionmodel->production_type_and_name_chart_display($search_year,$search_month,12,5,$dept_id,$dept_name);
                        //$this->Productionmodel->production_mc_reading_chart_display($search_year,$search_month,12,$dept_id,$dept_name);
                        //$this->Productionmodel->production_mc_running_chart_display($search_year,$search_month,12,$dept_id,$dept_name);
                       
                        $i++;  
                    }//foreach
                ?>
            </div>


                   
        
</div><!-- end of main-content -->
