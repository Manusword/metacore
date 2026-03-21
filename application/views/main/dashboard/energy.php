<?php 
    $search_month = date("m");
    $search_year = date('Y');
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1>Energy Meter Reading</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>

            <div class="row">
                <?php
                    $this->Maintenancemodel->all_meter_reading_chart_display($search_year,$search_month,6);
                ?>
            </div>

            <div class="row">
                <?php 
                    $dept_list = $this->Base->get_all_production_dept();
                    $i=1;
                    foreach($dept_list as $d)
                    {
                        $dept_id = $d['department_id'];
                        $dept_name = $d['name'];
                        $this->Productionmodel->production_mc_reading_chart_display($search_year,$search_month,12,$dept_id,$dept_name);
                       $i++;  
                    }//foreach
                ?>
            </div>


            <div class="row">
                <?php
                  $this->Maintenancemodel->dept_wise_meter_reading_chart_display($search_year,$search_month,12);  
                ?>
            </div>
            
            


                   
        
</div><!-- end of main-content -->
