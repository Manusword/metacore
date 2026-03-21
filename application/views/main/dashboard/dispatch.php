<?php 
    $search_month = date("m");
    $search_year = date('Y');
?>
<div class="main-content">
    <div class="breadcrumb">
        <h1>Payment</h1>
    </div>
    <div class="separator-breadcrumb border-top">
    </div>


   
    <?php 
        $this->Customermodel->cust_follow_up_chart($search_year,$search_month,12); 
        $this->Dispatchmodel->get_sch_vs_sup_chart($search_year,$search_month,12);
    ?>

    <div class="row">
        <?php
            $this->Dispatchmodel->date_wise_sale_chart_display($search_year,$search_month,12);
        ?>
    </div>

    <div class="row">
        <?php
            $this->Dispatchmodel->date_wise_sale_chart_display_via_account($search_year,$search_month,12);
        ?>
    </div>


    <div class="row">
        <?php
            $this->Dispatchmodel->date_wise_amt_rec_chart_display_via_account($search_year,$search_month,12);
        ?>
    </div>
           


   





    
                

                   
        
</div><!-- end of main-content -->
