<?php
class Meetingmodel extends CI_Model
{
    
    //mom data with id 
    public function get_mom_data_with_id($id)
	{
        $sql=" SELECT  * FROM mom WHERE mom_id='$id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    


    //breakdown search 
    public function get_all_mom_with_search($search)
	{
        $sql=" SELECT  * FROM mom WHERE 1=1  $search ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //mom data with id 
    public function get_mom_nos($status,$from_date,$to_date)
	{
        $sql="  SELECT count(mom_id) as nos FROM mom WHERE entry_date between '$from_date' and '$to_date' and status='$status' ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['nos'];}else{return 0;}
    }//function close












     //------------------------------------------------------Dashbord
    //dashbord mom status
    public function mom_status_chart($year,$month,$div_length)
    {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        
        $pending = $this->get_mom_nos("Pending",$from_date,$to_date);
        $under = $this->get_mom_nos("Under Process",$from_date,$to_date);
        $completed = $this->get_mom_nos("Completed",$from_date,$to_date);

        $color_list = ['#D53950','#EBA317','#00B87A'];
        $label = ['Pending','Under Process','Completed'];
        $data = [$pending,$under,$completed ];
        $div_name = 'chart_g'.'1';
        $this->Chartmodel->print_donut_chart($div_name,'350','100','#03A9F4',$label,$data,$color_list);
        ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Minutes of Meeting Summary</div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">List of work</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Pending</td>
                                                    <td class="text-danger font-weight-bold"><?php echo $pending;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Under Process</td>
                                                    <td class="text-warning font-weight-bold"><?php echo $under;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Completed</td>
                                                    <td class="text-success font-weight-bold"><?php echo $completed;?></td>
                                                </tr>
                                            </tbody>
                                            <tfooter class="thead-light">
                                                <tr>
                                                    <th scope="col">Total</th>
                                                    <th scope="col"><?php echo round($pending+$under+$completed);?></th>
                                                </tr>
                                            </tfooter>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="<?php echo $div_name;?>" style="height: 200px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
    }//function close



    



}//class close



