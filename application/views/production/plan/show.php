<style>
    .ui-autocomplete {
        z-index:2147483647;
    }
        
    .machine-section {
        margin-bottom: 30px;
    }
    .machine-header {
        background-color:<?php echo $this->Company->table_bg_color();?>; 
        color:<?php echo $this->Company->table_ft_color();?>;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
    }


    .card {
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(241, 54, 54, 0.1);
        margin-bottom: 20px;
    }
    .card-header {
        font-weight: bold;
        background-color:gray;
        color: white;
    }
    .badge {
        font-size: 14px;
    }
</style>
     

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                   
                    <div class="col-md-1">
                        <input type="button" id="newPlan" onclick="getModel('')" class="btn btn-warning" style=" margin-top:25px;"  value="New Production Plan"  data-toggle="modal" data-target=".plan-modal-lg">
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title"></div>
                                <div id="table_show">
                                    <?php 
                                        
                                        $rolList = $this->Pomodel->fun_wire_rod_size_grade_wise_query();
                                       
                                        $this->Pomodel->fun_wire_rod_list_group_by_grade_size($rolList);
                                        echo "<br> <br>";
                                        $this->Productionmodel->pending_plan_display_table();
                                    ?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   








<div class="modal fade plan-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#ffc107; ">
                <h5 class="modal-title" id="exampleModalLabel">Production Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modelDis"></div>
        </div>
    </div>
</div>

<Script>
    
        //-----------All reports search
        function getModel(planid)
        {
            $('#modelDis').html('');
            let search1='1';
            
            $('#wait').show();
            $('#dis_output').html('Please wait...');
            jQuery.post("<?php echo base_url().'index.php/Production/fun_plan_model';?>", 
            {
                planid:planid,
                search1:search1,
            }, 
            function(data, textStatus)
            {	
                $('#modelDis').html(data);
                $('#wait').hide();
            });
        }//function close
</Script>

<?php $this->load->view('js/production_js');?>

                
