<?php
class Maintenancemodel extends CI_Model
{
    //breakdown all machine name list
    public function get_breakdown_all_machine_list_name($from_date,$to_date)
    {
        $sql="  SELECT  A.mc_no, C.name as mname 
                FROM maint_problem as A 
                LEFT JOIN machine_list as C ON A.mc_no = C.mc_id  
                WHERE entry_date between '$from_date' and '$to_date' GROUP BY A.mc_no ORDER BY A.dept,C.name ASC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    
    
    //breakdown data with id 
    public function get_breakdown_data_with_id($id)
	{
        $sql="  SELECT A.*,B.name as dname,C.name as mname FROM maint_problem as A 
                LEFT JOIN department as B ON A.dept = B.department_id
                LEFT JOIN machine_list as C ON A.mc_no = C.mc_id  
                WHERE maint_problem_id='$id'
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    //breakdown data with dept id 
    public function get_breakdown_nos($dept,$status,$from_date,$to_date)
	{
        if($dept = "All")
        {
            $sql="  SELECT count(maint_problem_id) as nos FROM maint_problem WHERE entry_date between '$from_date' and '$to_date' and active='$status' ";
        }
        else
        {
            $sql="  SELECT count(maint_problem_id) as nos FROM maint_problem WHERE entry_date between '$from_date' and '$to_date' and active='$status' and dept='$dept' ";
        }
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['nos'];}else{return 0;}
    }//function close



    //breakdown data with mc id
    public function get_breakdown_nos_mc_id($mc_id,$type2,$from_date,$to_date)
	{
        $sql="  SELECT count(maint_problem_id) as nos FROM maint_problem WHERE entry_date between '$from_date' and '$to_date'  and mc_no='$mc_id' and type2='$type2' ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['nos'];}else{return 0;}
    }//function close

     //breakdown data with mc id time_taken
     public function get_breakdown_nos_mc_id_time_taken($mc_id,$type2,$from_date,$to_date)
     {
        $sql="  SELECT break_down_date,break_down_time,comp_date,comp_time FROM maint_problem WHERE entry_date between '$from_date' and '$to_date'  and mc_no='$mc_id' and type2='$type2' ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        $total_time = array();
        foreach($res as $r)
        {
            if(!empty($r['comp_time']) and $r['comp_time']!='00:00:00')
            {
                $comp_time=$this->Base->change_time_hisa($r['comp_time']);
                $break_down_date=$this->Base->change_date_dmy($r['break_down_date']);
                $break_down_time=$this->Base->change_time_hisa($r['break_down_time']);
                $comp_date=$this->Base->change_date_dmy($r['comp_date']);

                $to1="$break_down_date $break_down_time";
                $from1="$comp_date $comp_time";
                
                $to_time = strtotime($to1);
                $from_time = strtotime($from1);
                $total_time[] = round(abs($to_time - $from_time) / 60,2);
            }
        } 
        if(!empty($total_time)){ return round(array_sum($total_time));}
    }//function close
    


    //breakdown search 
    public function get_all_breakdown_with_search($search)
	{
        $sql="  SELECT A.*,B.name as dname,C.name as mname,P.name as problem_name,
                E.first_name as fname,E.last_name as lname,
                E2.first_name as fname2,E2.last_name as lname2
                FROM maint_problem as A 
                LEFT JOIN breakdown_problem_list as P ON P.id = A.problem_type_id
                LEFT JOIN department as B ON A.dept = B.department_id
                LEFT JOIN machine_list as C ON A.mc_no = C.mc_id  
                LEFT JOIN employee as E ON E.emp_code = A.person  
                LEFT JOIN employee as E2 ON E2.emp_code = A.attend_by
                WHERE 1=1  $search 
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //breakdown machine wise 
    public function get_all_machine_breakdown_in_minute($from_date,$to_date)
    {
        $sql="  SELECT A.mc_no,C.name as mname,count(A.maint_problem_id) as no_of_bk, avg(rating) as avg_rating, sum(breakdown_total_time_in_min) as total_min 
                FROM maint_problem as A 
                LEFT JOIN machine_list as C ON A.mc_no = C.mc_id  
                WHERE A.entry_date between '$from_date' and '$to_date'  
                GROUP BY A.mc_no
                ORDER BY total_min DESC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

     //breakdown problem wise 
     public function get_all_problem_breakdown_in_minute($from_date,$to_date)
     {
         $sql="  SELECT A.problem_type_id,A.mc_no,sum(breakdown_total_time_in_min) as total_min, avg(rating) as avg_rating, count(A.maint_problem_id) as no_of_bk, M.name as problem_name
                 FROM maint_problem as A 
                 LEFT JOIN breakdown_problem_list as M ON M.id = A.problem_type_id  
                 WHERE A.entry_date between '$from_date' and '$to_date'  
                 GROUP BY A.problem_type_id
                 ORDER BY total_min DESC
             ";
         $query = $this->db->query($sql);
         return $query->result_array();
     }//function close

     //breakdown person problem wise 
     public function get_all_person_attend_breakdown_in_minute($from_date,$to_date)
     {
         $sql=" SELECT 
                A.attend_by,
                E2.first_name AS fname2,
                E2.last_name AS lname2,

                COUNT(A.maint_problem_id) AS no_of_bk,
                SUM(A.breakdown_total_time_in_min) AS total_min,
                AVG(A.rating) AS avg_rating,

                COUNT(CASE WHEN A.active = 'Pending' THEN 1 END) AS pending_count,
                COUNT(CASE WHEN A.active = 'Under Process' THEN 1 END) AS under_process_count,
                COUNT(CASE WHEN A.active = 'Completed' THEN 1 END) AS completed_count,
                COUNT(CASE WHEN A.active = 'Canceled' THEN 1 END) AS canceled_count,

                ROUND((COUNT(CASE WHEN A.active = 'Completed' THEN 1 END) * 100.0) / COUNT(A.maint_problem_id), 2 ) AS efficiency_percent

            FROM maint_problem AS A
            LEFT JOIN employee AS E2 ON E2.emp_code = A.attend_by

             WHERE A.entry_date between '$from_date' and '$to_date' 

            GROUP BY A.attend_by
            ORDER BY total_min DESC;


             ";
         $query = $this->db->query($sql);
         return $query->result_array();
     }//function close


    //breakdown type of work wise 
     public function get_all_type_of_work_breakdown_in_minute($from_date,$to_date)
     {
         $sql="  SELECT A.type_of_work,
                    sum(breakdown_total_time_in_min) as total_min, 
                    avg(rating) as avg_rating, count(A.maint_problem_id) as no_of_bk,

                     COUNT(CASE WHEN A.active = 'Pending' THEN 1 END) AS pending_count,
                COUNT(CASE WHEN A.active = 'Under Process' THEN 1 END) AS under_process_count,
                COUNT(CASE WHEN A.active = 'Completed' THEN 1 END) AS completed_count,
                COUNT(CASE WHEN A.active = 'Canceled' THEN 1 END) AS canceled_count,

                ROUND((COUNT(CASE WHEN A.active = 'Completed' THEN 1 END) * 100.0) / COUNT(A.maint_problem_id), 2 ) AS efficiency_percent
                   
                 FROM maint_problem as A 
                 WHERE A.entry_date between '$from_date' and '$to_date'  
                 GROUP BY A.type_of_work
                 ORDER BY total_min DESC
             ";
         $query = $this->db->query($sql);
         return $query->result_array();
     }//function close


    
    //get_breakdown_from_mc_and_problem 

    //1st
    public function get_breakdown_from_mc_and_problem1($from_date,$to_date,$mc_id,$problem_type_id)
    {
        $sql="  SELECT *
                FROM maint_problem as A 
                WHERE A.entry_date between '$from_date' and '$to_date' and A.mc_no='$mc_id' and A.problem_type_id='$problem_type_id'
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //2nd
	public function get_breakdown_from_mc_and_problem2($from_date,$to_date,$mc_id,$problem_type_id)
	{
		$ress = $this->get_breakdown_from_mc_and_problem1($from_date,$to_date,$mc_id,$problem_type_id);
        if(!empty($ress)){
            ?>
            <table border=1>
            <?php
                $o=1;
                $min_diff2 = array();
                $total_min = array();
                foreach($ress  as $r)
                {
                    $save_date = $this->Base->change_date_dmy($r['entry_date']);
                    $problem = $r['problem'];
                    $break_down_date_time = $this->Base->change_date_dmy_hisa($r['break_down_date'].' '.$r['break_down_time']);
                    $comp_date_time = $this->Base->change_date_dmy_hisa($r['comp_date'].' '.$r['comp_time']);
                    
                    if(!empty($r['comp_time']) and $r['comp_time']!='00:00:00')
                    {
                        $min_diff = $this->Base->get_minute_diff_bw_two_dates($break_down_date_time,$comp_date_time);
                    }
                    else{ $min_diff = '';}

                    ?>
                        <tr>
                            <td><?php echo $o;?></td>
                            <td><?php echo $save_date;?></td>
                            <td><?php echo $problem;?></td>
                            <td><?php echo $min_diff2[] = $min_diff;?></td>
                        </tr>
                    <?php
                $o++;
                }
                ?>
                <tr>
                    <td></td>
                    <td>Total</td>
                    <td></td>
                    <td>
                        <b>
                            <?php 
                                if(!empty($min_diff2))
                                {  
                                    echo $min_diff3 = round(array_sum($min_diff2)); 
                                    //array_push($min_diff4,$problem_type_id => $min_diff3);
                                    $total_min[$problem_type_id] = $min_diff3;
                                }
                                else
                                {
                                    $total_min[$problem_type_id] = '12';
                                }
                            ?>
                        </b>
                    </td>
                </tr>
            </table>
            <?php
            
        }//!empty
        else
        {
            $total_min[$problem_type_id] = 0;  
        }

        //key problem type value = total time
        return $total_min;
    }//function close




    //list search
	public function get_breakdown_from_mc_and_problem3($from_date,$to_date)
	{
		$pl=$this->Base->get_all_breakdown_problem_list();
		$mc = $this->Maintenancemodel->get_breakdown_all_machine_list_name($from_date,$to_date);
		
		?>
			<table border=1 id="printed_table">
				<tr>
					<th>M/C</th>
					<?php 
						foreach($pl as $p)
						{
							?>
								<td><?php echo $p['name']?></td>
							<?php
						}
					?>
				</tr>
				
				<?php
					//body 
					foreach($mc as $m)
					{
						?>
						<tr>
							<td><?php echo $m['mname']?></td>
							<?php 
								foreach($pl as $p)
								{
									?>
										<td><?php $res2[] = $this->Maintenancemodel->get_breakdown_from_mc_and_problem2($from_date,$to_date,$m['mc_no'],$p['id']);?></td>
									<?php
								}
							?>
						</tr>
						<?php
					}
					
                    if(!empty($res2)){ $total_key_value = $this->Base->add_multi_array($res2);}
                   
					
				?>

				<tr>
					<th>Total</th>
					<?php 
						foreach($pl as $p)
						{
							?>
								<td><?php if(!empty($total_key_value[$p['id']])){echo $total_key_value[$p['id']];}?></td>
							<?php
						}
					?>
				</tr>

			</table>
            <br>
            <a target='_blank' href="<?php echo base_url()."index.php/Maintenance/list3?search_date1=$from_date&search_date2=$to_date";?>">View Full Page</a>
                               

		<?php
	
	}//function close




    public function get_breakdwon_machine_wise($data)
    {
        $dates = array_column($data, 'entry_date');
        sort($dates);
        $fdate_search = $dates[0];
        $tdate_search = end($dates);
        
        $report = [];
        foreach ($data as $entry) {
            $mc_no = $entry['mc_no'];
            if (!isset($report[$mc_no])) {
                $report[$mc_no] = [
                    'mc_no' => $mc_no,
                    'mname' => $entry['mname'],
                    'total_minutes' => 0,
                    'breakdown_count' => 0,
                    'rating_total' => 0,
                ];
            }

            $report[$mc_no]['total_minutes'] += $entry['breakdown_total_time_in_min'];
            $report[$mc_no]['breakdown_count'] += 1;
            $report[$mc_no]['rating_total'] += $entry['rating'];
        }

        // Sort report by total_minutes DESC
        usort($report, function ($a, $b) {
            return $b['breakdown_count'] <=> $a['breakdown_count'];
        });

        echo '<table border="1" width="100%" cellpadding="5" cellspacing="0">';
        echo '<thead style="background-color:' . $this->Company->table_bg_color() . '; color:' . $this->Company->table_ft_color() . ';">
        <tr>
            <th>#</th>
            <th>M/C No</th>
            <th>Total Minute</th>
            <th>No of Breakdown</th>
            <th>Avg Efficiency Rating</th>
            <th>MTTR Format</th>
            <th>MTBF Format</th>
            <th>Report</th>
        </tr>
        </thead>
        <tbody>';

        $i = 1;

        foreach ($report as $mc_data) {
            $breakdowns = $mc_data['breakdown_count'];
            $total_minutes = $mc_data['total_minutes'];
            $avg_rating = $breakdowns > 0 ? round($mc_data['rating_total'] / $breakdowns, 2) : 0;
            $mttr = $this->Base->get_mttr($breakdowns, $total_minutes);
            $mtbf = $this->Base->get_mtbf($breakdowns);

            $mttr_remark = $this->Base->get_mttr_remarks($mttr);
            $mtbf_remark = $this->Base->get_mtbf_remarks($mtbf);

            echo "<tr>
                <td>{$i}</td>
                <td>{$mc_data['mname']}</td>
                <td>{$total_minutes}</td>
                <td>{$breakdowns}</td>
                <td>{$avg_rating}</td>
                <td>{$mttr} min ({$mttr_remark})</td>
                <td>{$mtbf} min ({$mtbf_remark})</td>
                <td><a target='_blank' href='" . base_url() . "index.php/Maintenance/mttr_format/{$mc_data['mc_no']}/{$fdate_search}/{$tdate_search}' class='btn btn-sm btn-outline-primary'>Report</a></td>
            </tr>";
            $i++;
        }

        echo '</tbody></table>';
    }




    public function get_breakdwon_problem_wise($data)
	{
        $dates = array_column($data, 'entry_date');
        sort($dates);
        $fdate_search = $dates[0];
        $tdate_search = end($dates);
        $report = [];

        foreach ($data as $entry) {
            $problem = $entry['problem_name'];
            if (!isset($report[$problem])) {
                $report[$problem] = [
                    'problem_type_id' => $entry['problem_type_id'],
                     'problem_name' => $problem,
                    'total_minutes' => 0,
                    'breakdown_count' => 0,
                    'rating_total' => 0,
                ];
            }

            $report[$problem]['total_minutes'] += $entry['breakdown_total_time_in_min'];
            $report[$problem]['breakdown_count'] += 1;
            $report[$problem]['rating_total'] += $entry['rating'];
        }
        // Sort by total_minutes DESC
        usort($report, function ($a, $b) {
            return $b['breakdown_count'] <=> $a['breakdown_count'];
        });


        // Generate table
        echo '<table border="1" width="100%" cellpadding="5" cellspacing="0">';
        echo '<thead style="background-color:' . $this->Company->table_bg_color() . '; color:' . $this->Company->table_ft_color() . ';">
        <tr>
            <th>#</th>
            <th>Problem Name</th>
            <th>Total Minute</th>
            <th>No of Breakdowns</th>
            <th>Avg Efficiency Rating</th>
            <th>MTTR Format</th>
            <th>MTBF Format</th>
            <th>Report</th>
        </tr>
        </thead>
        <tbody>';

        $i = 1;
      

        foreach ($report as $problem_data) {
            $breakdowns = $problem_data['breakdown_count'];
            $total_minutes = $problem_data['total_minutes'];
            $avg_rating = $breakdowns > 0 ? round($problem_data['rating_total'] / $breakdowns, 2) : 0;
           
            $mttr = $this->Base->get_mttr($breakdowns,$total_minutes);
            $mtbf = $this->Base->get_mtbf($breakdowns);
           
            $mttr_remark = $this->Base->get_mttr_remarks($mttr);
            $mtbf_remark = $this->Base->get_mtbf_remarks($mtbf);

            echo "<tr>
                <td>{$i}</td>
                <td>{$problem_data['problem_name']}</td>
                <td>{$total_minutes}</td>
                <td>{$breakdowns}</td>
                <td>{$avg_rating}</td>
                <td>{$mttr} min ({$mttr_remark})</td>
                <td>{$mtbf} min ({$mtbf_remark})</td>
                <td><a target='_blank' href='" . base_url() . "index.php/Maintenance/mttr_format2/{$problem_data['problem_type_id']}/{$fdate_search}/{$tdate_search}' class='btn btn-sm btn-outline-primary'>Report</a></td>
            </tr>";
            $i++;
        }
        

        echo '</tbody></table>';
        
    }//function close

    public function get_breakdwon_type2_wise($data)
	{
       $report = [];

        foreach ($data as $entry) {
            $type2 = $entry['type2'] ?: 'Not Specified';

            if (!isset($report[$type2])) {
                $report[$type2] = [
                    'type2' => $type2,
                    'total_minutes' => 0,
                    'breakdown_count' => 0,
                    'rating_total' => 0,
                ];
            }

            $report[$type2]['total_minutes'] += $entry['breakdown_total_time_in_min'];
            $report[$type2]['breakdown_count'] += 1;
            $report[$type2]['rating_total'] += $entry['rating'];
        }

         // Sort by total_minutes DESC
        usort($report, function ($a, $b) {
            return $b['breakdown_count'] <=> $a['breakdown_count'];
        });

        // Output table
        echo '<table border="1" width="100%" cellpadding="5" cellspacing="0">';
        echo '<thead style="background-color:' . $this->Company->table_bg_color() . '; color:' . $this->Company->table_ft_color() . ';">
        <tr>
            <th>#</th>
            <th>Type2</th>
            <th>Total Minute</th>
            <th>No of Breakdowns</th>
            <th>Avg Efficiency Rating</th>
            <th>MTTR Format</th>
            <th>MTBF Format</th>
        </tr>
        </thead>
        <tbody>';

        $i = 1;
       

        foreach ($report as $type2_data) {
            $breakdowns = $type2_data['breakdown_count'];
            $total_minutes = $type2_data['total_minutes'];
            $avg_rating = $breakdowns > 0 ? round($type2_data['rating_total'] / $breakdowns, 2) : 0;
            
            $mttr = $this->Base->get_mttr($breakdowns,$total_minutes);
            $mtbf = $this->Base->get_mtbf($breakdowns);
           
            $mttr_remark = $this->Base->get_mttr_remarks($mttr);
            $mtbf_remark = $this->Base->get_mtbf_remarks($mtbf);

            echo "<tr>
                <td>{$i}</td>
                <td>{$type2_data['type2']}</td>
                <td>{$total_minutes}</td>
                <td>{$breakdowns}</td>
                <td>{$avg_rating}</td>
                <td>{$mttr} min ({$mttr_remark})</td>
                <td>{$mtbf} min ({$mtbf_remark})</td>
            </tr>";
            $i++;
        }

        echo '</tbody></table>';
        
    }//function close

    

public function get_breakdwon_mc_type2_problem_wise($data)
{
    $report = [];

    // Step 1: Group data by Dept → Machine → Type2 → Problem
    foreach ($data as $entry) {
       $dept = $entry['dname'] ?? 'No Dept';
        $machine = $entry['mname'];
        $type2 = $entry['type2'] ?: 'Not Specified';
        $problem = $entry['problem_name'];

        if (!isset($report[$dept])) {
            $report[$dept] = [];
        }

        if (!isset($report[$dept][$machine])) {
            $report[$dept][$machine] = [];
        }

        if (!isset($report[$dept][$machine][$type2])) {
            $report[$dept][$machine][$type2] = [];
        }

        if (!isset($report[$dept][$machine][$type2][$problem])) {
            $report[$dept][$machine][$type2][$problem] = [
                'total_minutes' => 0,
                'breakdown_count' => 0,
                'rating_total' => 0,
                'part_changes' => [],
            ];
        }

        $report[$dept][$machine][$type2][$problem]['total_minutes'] += $entry['breakdown_total_time_in_min'];
        $report[$dept][$machine][$type2][$problem]['breakdown_count'] += 1;
        $report[$dept][$machine][$type2][$problem]['rating_total'] += $entry['rating'];
        if (!empty($entry['part_change'])) {
            $report[$dept][$machine][$type2][$problem]['part_changes'][] = trim($entry['part_change']);
        }

    }

    

    // Step 2: Render HTML report
    echo '<div class="container-fluid my-4">';

    foreach ($report as $dept => $machines) {
        echo "<h2 class='mb-4 p-2 bg-info text-white rounded'>Dept: {$dept}</h2>";

        foreach ($machines as $machine => $type2Groups) {
            echo "<div class='card mb-4 shadow'>
                    <div class='card-header' >
                        <h5 class='mb-0' style='color:blue'>Machine: {$machine}</h5>
                    </div>
                    <div class='card-body'>";

            // Machine totals
            $machine_total_min = 0;
            $machine_total_break = 0;
            $machine_total_rating = 0;
            $machine_total_mttr = 0;
            $machine_total_mtbf = 0;
            $machine_row_count = 0;

            foreach ($type2Groups as $type2 => $problems) {
                echo "<div class='mb-4'>
                        <h6 class='text-secondary border-bottom pb-1'>{$type2}</h6>
                        <div class='table-responsive'>
                        <table class='table table-bordered table-striped'>
                            <thead class='table-light'>
                                <tr>
                                    <th>Problem</th>
                                    <th>Total Time (min)</th>
                                    <th>Breakdowns</th>
                                    <th>Avg Rating</th>
                                    <th>MTTR (min)</th>
                                    <th>MTBF (min)</th>
                                    <th>Part Changed</th>
                                </tr>
                            </thead>
                            <tbody>";

                // Type2 totals
                $type2_total_min = 0;
                $type2_total_break = 0;
                $type2_total_rating = 0;
                $type2_total_mttr = 0;
                $type2_total_mtbf = 0;
                $type2_row_count = 0;

                foreach ($problems as $problem => $info) {
                    $total_min = $info['total_minutes'];
                    $count = $info['breakdown_count'];
                    $avg_rating = $count > 0 ? round($info['rating_total'] / $count, 2) : 0;
                    
                    //$mttr = $count > 0 ? round($total_min / $count, 2) : 0;
                    //$mtbf = $count > 0 ? round(1440 / $count, 2) : 0;

                    $mttr = $this->Base->get_mttr($count,$total_min);
                    $mtbf = $this->Base->get_mtbf($count);
                
                    $mttr_remark = $this->Base->get_mttr_remarks($mttr);
                    $mtbf_remark = $this->Base->get_mtbf_remarks($mtbf);
                    $part_changes = array_unique($info['part_changes']);
                    $part_change_str = implode(', ', $part_changes);

                    echo "<tr>
                            <td>{$problem}</td>
                            <td>{$total_min}</td>
                            <td>{$count}</td>
                            <td>{$avg_rating}</td>
                            <td>{$mttr} {$mttr_remark}</td>
                            <td>{$mtbf} {$mtbf_remark}</td>
                            <td>{$part_change_str}</td>
                          </tr>";

                    // Accumulate Type2 totals
                    $type2_total_min += $total_min;
                    $type2_total_break += $count;
                    $type2_total_rating += $info['rating_total'];
                    $type2_total_mttr += $mttr;
                    $type2_total_mtbf += $mtbf;
                    $type2_row_count++;

                    // Accumulate Machine totals
                    $machine_total_min += $total_min;
                    $machine_total_break += $count;
                    $machine_total_rating += $info['rating_total'];
                    $machine_total_mttr += $mttr;
                    $machine_total_mtbf += $mtbf;
                    $machine_row_count++;
                }

                // Type2 Summary Row
                $t_avg_rating = round($type2_total_rating / max(1, $type2_row_count), 2);
                $t_avg_mttr = round($type2_total_mttr / max(1, $type2_row_count), 2);
                $t_avg_mtbf = round($type2_total_mtbf / max(1, $type2_row_count), 2);
                
                $mttr_remark_avg = $this->Base->get_mttr_remarks($t_avg_mttr);
                $mtbf_remark_avg = $this->Base->get_mttr_remarks($t_avg_mtbf);

                echo "<tr style='font-weight: bold; background-color: #f8f9fa;'>
                        <td>Total / Avg</td>
                        <td>{$type2_total_min}</td>
                        <td>{$type2_total_break}</td>
                        <td>{$t_avg_rating}</td>
                        <td>{$t_avg_mttr} {$mttr_remark_avg}</td>
                        <td>{$t_avg_mtbf} {$mtbf_remark_avg}</td>
                        <td></td>
                      </tr>";

                echo "</tbody></table></div></div>";
            }

            // Machine Grand Total Row
            $m_avg_rating = round($machine_total_rating / max(1, $machine_row_count), 2);
            $m_avg_mttr = round($machine_total_mttr / max(1, $machine_row_count), 2);
            $m_avg_mtbf = round($machine_total_mtbf / max(1, $machine_row_count), 2);

            $mttr_remark_avg2 = $this->Base->get_mttr_remarks($m_avg_mttr);
            $mtbf_remark_avg2 = $this->Base->get_mttr_remarks($m_avg_mtbf);

           

             echo "<div class='bg-white text-black p-2 rounded text-end mt-4'>
                    <strong>Machine Total / Avg:</strong>
                    {$machine_total_min} min | {$machine_total_break} breakdowns |
                    Avg Rating: {$m_avg_rating} |
                    MTTR: {$m_avg_mttr} min {$mttr_remark_avg2} |
                    MTBF: {$m_avg_mtbf} min {$mtbf_remark_avg2}
                  </div>";

            echo "</div></div>"; // end card-body, card
        }
    }

    echo '</div>'; // container
}
































    
    //---------------------------------------------------Meter Reading
    //meter reading data and dept
    public function get_energy_meter_reading_with_date_dept($date,$dept_id)
	{
        $sql="  SELECT meter_reading FROM energy_meter_reading WHERE entry_date='$date' and dept_id='$dept_id' ORDER BY id DESC LIMIT 1 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['meter_reading'];}else{return 0;}
    }//function close


    //meter reading data and dept and machine
    public function get_energy_meter_reading_with_date_dept_mc($date,$dept_id,$mc_id)
    {
        $sql="  SELECT meter_reading FROM energy_meter_reading WHERE entry_date='$date' and dept_id='$dept_id' and mc_id='$mc_id' ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){ return $res[0]['meter_reading'];}else{return 0;}
    }//function close


    //get machine full reading deails
    public function get_reading_full_details($from_date,$to_date,$dept_id,$mc_id)
    {
        if($dept_id>0){ $dept_search =" and dept_id ='$dept_id'";}else{$dept_search='';}
        if($mc_id>0){ $mc_search =" and mc_id ='$mc_id'";}else{$mc_search='';}
        
        
        //starting reading
        $sql = "SELECT meter_reading FROM energy_meter_reading where entry_date < '$from_date' and meter_reading >0  $dept_search $mc_search   ORDER BY entry_date DESC LIMIT 1 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){$day1_reading = $res[0]['meter_reading'];}else{$day1_reading = 0;}

        //last reading
        $sql = "SELECT meter_reading FROM energy_meter_reading where entry_date <= '$to_date' and meter_reading >0 $dept_search $mc_search ORDER BY entry_date DESC LIMIT 1 ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){$day2_reading = $res[0]['meter_reading'];}else{$day2_reading = 0;}

        //diff
        if($day1_reading >0 and $day2_reading>0){
            $inc_reading = $day2_reading-$day1_reading;
            $inc_per = round(($inc_reading/$day1_reading)*100);
        }
        elseif($day1_reading <= 0 and $day2_reading > 0){
            $inc_reading = $day2_reading;
            $inc_per = 100;
        }
        else{
            $inc_reading = 0;
            $inc_per = 0;
        }

        return $output = [$day1_reading,$day2_reading,$inc_reading,$inc_per];
    }//function close


    //get machine full reading deails
    public function get_reading_full_details2($from_date,$to_date,$dept_id,$mc_id)
    {
        if($dept_id>0){ $dept_search =" and dept_id ='$dept_id'";}else{$dept_search='';}
        if($mc_id>0){ $mc_search =" and mc_id ='$mc_id'";}else{$mc_search='';}
        
        //starting reading
        $sql = "SELECT sum(meter_reading) as meter_reading FROM energy_meter_reading where entry_date between '$from_date' and '$to_date' and meter_reading >0  $dept_search $mc_search  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(!empty($res)){$total_reading = $res[0]['meter_reading'];}else{$total_reading = 0;}
        return $total_reading;
    }//function close


    //get machine full reading deails with dept and avg of reading
    public function get_reading_full_details3($from_date,$to_date,$dept_id,$mc_id)
    {
        if($dept_id==5)
        { 
            //wet block
            if($mc_id<12)
            {
                $sql = "SELECT sum(meter_reading) as meter_reading FROM energy_meter_reading where entry_date between '$from_date' and '$to_date' and meter_reading >0 and   mc_id IN (4,5,6,7,8,9,10,11)  ";
            }
            else
            {
                $sql = "SELECT sum(meter_reading) as meter_reading FROM energy_meter_reading where entry_date between '$from_date' and '$to_date' and meter_reading >0 and   mc_id IN (12,13,14,15,16,17,18,19,20,30)  ";
            }
        }
        else
        {
            //mini or dry
            $sql = "SELECT sum(meter_reading) as meter_reading FROM energy_meter_reading where entry_date between '$from_date' and '$to_date' and meter_reading >0   and mc_id ='$mc_id'  ";
        }
        
        //starting reading
        $query = $this->db->query($sql);
            $res = $query->result_array();
        if(!empty($res)){$total_reading = $res[0]['meter_reading'];}else{$total_reading = 0;}
        return $total_reading;
    
    }//function close




    //meter reading search 
    public function get_all_meter_reading_with_search($search)
	{
        $sql="  SELECT A.entry_date,A.meter_reading,B.name as dname,C.name as mname FROM energy_meter_reading as A 
                LEFT JOIN department as B ON A.dept_id = B.department_id
                LEFT JOIN machine_list as C ON A.mc_id = C.mc_id  
                WHERE 1=1  $search 
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close





    //same query in Productionmodel get_kg_kwh_with_search
    //meter Productionand KWH
    public function get_kg_kwh_with_search($date)
    {
        $sql="  SELECT A.* FROM EKW_day_wse as A WHERE 1=1  and A.entry_date = '$date' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close





    //dept_wise_meter_reading_chart_display
    public function dept_wise_meter_reading_chart_display($year,$month,$div_length)
    {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        //dept list
        $dept_list = $this->Base->get_meter_reading_dept();
      
        $label = array();$reading_start = array();$reading_end = array();$reading_diff = array();$reading_diff_per = array();
        foreach($dept_list as $m)
        {
            if($m['is_main_production'] != 1)
            {
                $label[] = $m['name'];
                $dept_id = $m['department_id'];
                $res3 = $this->get_reading_full_details($from_date,$to_date,$dept_id,0);
                if($res3[0]>0){$reading_start[] = $res3[0];}else{$reading_start[] = 0;}
                if($res3[1]>0){$reading_end[] = $res3[1];}else{$reading_end[] = 0;}
                if($res3[2]>0){$reading_diff[] = $res3[2];}else{$reading_diff[] = 0;}
                if($res3[3]>0){$reading_diff_per[] = $res3[3];}else{$reading_diff_per[] = 0;}
            }
        }//foreach
        
        $div_name = 'chart_h'.$dept_id;
        $this->Chartmodel->print_bar_chart($div_name,'350','#53569C',$label,$reading_end);
        ?>
        <div class="col-md-<?php echo $div_length;?>">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title">Dept. wise Total Energy Meter Reading</div>
                        <div class="row">
                            <div class="col-md-3" style="height:300px; overflow:auto;">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Dept.</th>
                                            <th scope="col">Before <?php echo $this->Base->change_date_dmy($from_date);?> </th>
                                            <th scope="col">Current Reading</th>
                                            <th scope="col">Inc.</th>
                                            <th scope="col">% Inc.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $i=0;$total1 = array();$total2 = array();$total3 = array();$total4 = array();
                                            foreach($label as $l)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $l;?></td>
                                                    <td class=" font-weight-bold" ><?php echo $total1[] = $reading_start[$i];?></td>
                                                    <td class=" font-weight-bold" style="color:#53569C"><?php echo $total2[] = $reading_end[$i];?></td>
                                                    <td class=" font-weight-bold"><?php echo $total3[] = $reading_diff[$i];?></td>
                                                    <td class=" font-weight-bold"><?php echo $total4[] = $reading_diff_per[$i]; echo "%";?></td>
                                                </tr>
                                                <?php
                                            $i++;
                                            }
                                        ?>
                                    </tbody>
                                    <tfooter class="thead-light">
                                        <tr>
                                            <th scope="col">Total</th>
                                            <th scope="col"><?php if(!empty($total1)){ echo $a = round(array_sum($total1));}else{$a=0;}?></th>
                                            <th scope="col"><?php if(!empty($total2)){ echo $b = round(array_sum($total2));}else{$b=0;}?></th>
                                            <th scope="col"><?php if($a >0 and $b>0){ echo $d =$b-$a; }else{$d=0;}?></th>
                                            <th scope="col"><?php if($d>0){  echo round(($b/100)*$d); echo "%";} ?></th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Avg</th>
                                            <th scope="col"><?php if(!empty($total1)){ echo round(array_sum($total1)/count($total1));}?></th>
                                            <th scope="col"><?php if(!empty($total2)){ echo round(array_sum($total2)/count($total2));}?></th>
                                            <th scope="col"><?php if(!empty($total3)){ echo round(array_sum($total3)/count($total3));}?></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </tfooter>
                                </table>
                            </div>
                            <div class="col-md-9">
                                <div id="<?php echo $div_name;?>" style="height: 200px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }//function close




























    //------------------------------------------------------Dashbord
    //dashbord Breakdown_status
    public function break_down_status_chart($year,$month,$div_length)
    {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        
        $pending = $this->get_breakdown_nos("All","Pending",$from_date,$to_date);
        $under = $this->get_breakdown_nos("All","Under Process",$from_date,$to_date);
        $process = $this->get_breakdown_nos("All","Process Completed",$from_date,$to_date);
        $completed = $this->get_breakdown_nos("All","Completed",$from_date,$to_date);

        $color_list = ['#D53950','#EBA317','#5A479E','#00B87A'];
        $label = ['Pending','Under Process','Process Completed','Completed'];
        $data = [$pending,$under,$process,$completed ];
        $div_name = 'chart_f'.'1';
        $this->Chartmodel->print_donut_chart($div_name,'350','100','#03A9F4',$label,$data,$color_list);
        ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Breakdown Summary</div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Breakdown</th>
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
                                                    <td>Process Completed</td>
                                                    <td class="text-info font-weight-bold"><?php echo $process;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Completed</td>
                                                    <td class="text-success font-weight-bold"><?php echo $completed;?></td>
                                                </tr>
                                            </tbody>
                                            <tfooter class="thead-light">
                                                <tr>
                                                    <th scope="col">Total</th>
                                                    <th scope="col"><?php echo round($pending+$under+$process+$completed);?></th>
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


    
    /*
    //all_meter_reading_chart_display
    public function all_meter_reading_chart_display($year,$month,$div_length)
    {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $label = $this->Base->get_day_no_on_month($month,$year);
        
        $dept_list = $this->Base->get_meter_reading_dept();
        $all_dept = array();$name=array();
        foreach($dept_list as $m)
        {
            if($m['is_main_production'] != 1)
            {
                if($m['meter_reading_value_add']==1)
                {
                    $name [] = $m['name'];
                    $one_dept = array();
                    foreach($label as $d)
                    {
                        $current_date = $this->Base->get_date_form_dayno_ymd($d,$month,$year);
                        $one_dept[] = $this->get_energy_meter_reading_with_date_dept($current_date,$m['department_id']);
                    }
                    $all_dept[] = $one_dept;
                }
            }
        }//foreach
        $div_name = 'chart_i';
        $color_list = $this->Base->get_random_color_list(count($dept_list));
        $data = $all_dept;
        $this->Chartmodel->print_multi_line_chart($div_name,'350',$color_list,$label,$data,$name);
        ?>
            <div class="col-md-<?php echo $div_length;?>">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title" style="color:#03A9F4;">Dept. wise Energy Meter Reading</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="<?php echo $div_name;?>" style="height: 200px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
        
    }//function close
    */

    public function all_meter_reading_chart_display($year,$month,$div_length)
    {
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $label = $this->Base->get_day_no_on_month($month,$year);
        
        $dept_list = $this->Base->get_meter_reading_dept();
        $all_dept = array();$name=array();
        foreach($dept_list as $m)
        {
            if($m['is_main_production'] != 1)
            {
                
                $name = $m['name'];
                $one_dept = array();
                foreach($label as $d)
                {
                    $current_date = $this->Base->get_date_form_dayno_ymd($d,$month,$year);
                    $one_dept[] = $this->get_energy_meter_reading_with_date_dept($current_date,$m['department_id']);
                }
                //$all_dept[] = $one_dept;
                
                //chart details
                $div_name = 'chart_i'.$m['department_id'];
                $color_list = "#03A9F4";
                $data = $one_dept;
                $this->Chartmodel->print_line_chart($div_name,'350',$color_list,$label,$data);
                ?>
                    <div class="col-md-<?php echo $div_length;?>">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title" style="color:#03A9F4;"><?php echo $name;?>, energy meter reading</div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="<?php echo $div_name;?>" style="height: 200px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                
            }
            
        }//foreach
        
       
        
    }//function close
















    //-----------------------------------------------------------------------Reminder
     //reminder data with id 
    public function get_reminder_data_with_id($id)
	{
        $sql="  SELECT A.*,B.name as dname,C.name as mname 
                FROM reminder as A 
                LEFT JOIN department as B ON A.dept = B.department_id
                LEFT JOIN machine_list as C ON A.mc_no = C.mc_id  
                WHERE reminder_id ='$id'
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    
    //reminder search 
    public function get_all_reminder_with_search($search)
	{
        $sql="  SELECT A.*,B.name as dname,M.name as mname,C.name as cname
                FROM reminder as A 
                LEFT JOIN department as B ON A.dept = B.department_id
                LEFT JOIN machine_list as M ON A.mc_no = M.mc_id  
                LEFT JOIN customer as C ON A.customer_id = C.id
                WHERE 1=1  $search 
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //reminder search 
    public function get_dashboard_reminder($date)
	{
        $user_email=$this->session->userdata('login_emp_id');
        //WHERE (A.event_date = '$date' OR A.next_event_date <= '$date') and (A.status = 'Pending' OR A.status = 'Under Process') 
        $sql="  SELECT A.*,B.name as dname,M.name as mname,C.name as cname
                FROM reminder as A 
                LEFT JOIN department as B ON A.dept = B.department_id
                LEFT JOIN machine_list as M ON A.mc_no = M.mc_id  
                LEFT JOIN customer as C ON A.customer_id = C.id
                WHERE (A.event_date = '$date' OR A.next_event_date <= '$date') and (A.status = 'Pending' OR A.status = 'Under Process') and (A.show_to = '$user_email' OR A.show_to = 'Everyone') 
                ORDER by A.priority ASC ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    


 
    



}//class close



