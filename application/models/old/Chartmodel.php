<?php
class Chartmodel extends CI_Model
{
    //bar chart
	public function print_bar_chart($div_id,$height,$color,$label,$data)
	{
        $symbol ="";
        $l = count($data);
       ?>
            <script>
                $(document).ready(function () {
                    var options = {
                    chart: {
                    height: <?php echo $height;?>,
                    type: 'bar',
                    toolbar: {show: false }
                    },
                    plotOptions: {
                    bar: {
                        dataLabels: {position: 'top'},
                        //endingShape: 'rounded'
                    }
                    },
                    colors: ['<?php echo $color;?>'],
                    dataLabels: {
                    enabled: true,
                    formatter: function formatter(val) { return val + "<?php $symbol;?>";},
                    offsetY: -20,
                    style: {fontSize: '12px',colors: ["#333"]}
                    },
                    series: [{
                    name: 'Qty',
                    data: [
                            <?php 
                                $j=1;
                                foreach($data as $d)
                                {
                                    if($j == $l){
                                        echo "'$d'";
                                    }
                                    else{
                                        echo "'$d',";
                                    }
                                    $j++;
                                }
                            ?> 
                        ]
                    }],
                    xaxis: {
                    categories: [
                                    <?php 
                                        $j=1;
                                        foreach($label as $d)
                                        {
                                            if($j == $l){
                                                echo "'$d'";
                                            }
                                            else{
                                                echo "'$d',";
                                            }
                                            $j++;
                                        }
                                    ?> 
                                ],
                    position: 'bottom',
                    labels: {offsetY: 0 },
                    axisBorder: { show: true},
                    axisTicks: {show: true},
                    tooltip: { enabled: false, offsetY: -35}
                    },/*
                    fill: {
                    gradient: {
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: '#639',
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [50, 0, 100, 100]
                    }
                    },*/
                    yaxis: {
                    axisBorder: {show: true},
                    axisTicks: {show: true},
                    labels: {
                        show: true,
                        formatter: function formatter(val) { return val + "<?php $symbol;?>";}
                    }
                    },
                    /*
                    title: {
                    text: 'Monthly Inflation in Argentina, 2002',
                    floating: true,
                    offsetY: 320,
                    align: 'left',
                    style: {color: '#444'}
                    }*/
                    };


                    var chart = new ApexCharts(document.querySelector("#<?php echo $div_id;?>"), options);
                    chart.render(); // stacked Column

                });
            </script>
       <?php
    }//function close





    //donutt chart
	public function print_donut_chart($div_id,$height,$width,$color,$label,$data,$color_list)
	{
        $symbol ="";
        $l = count($label);
       ?>
           <script>
            $(document).ready(function () {
                // simple Pie
                var options = {
                    chart: {
                    width: '<?php echo $width;?>%',
                    type: 'pie'
                    },
                    colors: [ 
                                <?php 
                                    $j=1;
                                    foreach($color_list as $d)
                                    {
                                        if($j == $l){
                                            echo "'$d'";
                                        }
                                        else{
                                            echo "'$d',";
                                        }
                                        $j++;
                                    }
                                ?> 
                             ],
                    labels: [
                                <?php 
                                    
                                    $j=1;
                                    foreach($label as $d)
                                    {
                                        if($j == $l){
                                            echo "'$d'";
                                        }
                                        else{
                                            echo "'$d',";
                                        }
                                        $j++;
                                    }
                                ?> 
                            ],
                    series: [
                                <?php 
                                   
                                    $j=1;
                                    foreach($data as $d)
                                    {
                                        if($j == $l){
                                            echo $d;
                                        }
                                        else{
                                            echo $d.',';
                                        }
                                        $j++;
                                    }
                                ?> 
                            ],
                    legend: {
                    position: 'bottom'
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 300
                        },
                        legend: {
                        position: 'bottom',
                        offsetY: 40
                        }
                    }
                    }]
                };
                var chart = new ApexCharts(document.querySelector("#<?php echo $div_id;?>"), options);
                chart.render(); // simple donut

            });
            </script>
       <?php
    }//function close



    //customDatalabelBar chart
	public function print_custom_bar_chart($div_id,$height,$color,$label,$data,$color_list)
	{
        $symbol ="";
        $l = count($label);
       ?>
                                        
           <script>
            $(document).ready(function () {
                // simple Pie
                var options = {
                    chart: {
                    height: <?php echo $height;?>,
                    type: 'bar',
                    toolbar: {show: false}
                    },
                    plotOptions: {
                    bar: {
                        barHeight: '100%',
                        distributed: true,
                        horizontal: false,
                        dataLabels: {
                        position: 'top'
                        },
                        //endingShape: 'rounded'
                    }
                    },
                    colors: [ 
                                <?php 
                                    $j=1;
                                    foreach($color_list as $d)
                                    {
                                        if($j == $l){
                                            echo "'$d'";
                                        }
                                        else{
                                            echo "'$d',";
                                        }
                                        $j++;
                                    }
                                ?> 
                             ],
                    dataLabels: {
                    enabled: true,
                    textAnchor: 'start',
                    style: {
                        colors: ['black']
                    },
                    formatter: function formatter(val, opt) {
                        //return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val;
                        return val;
                    },
                    offsetY: -20,
                    offsetX: -15,
                    dropShadow: {
                        enabled: false
                    }
                    },
                    series: [{
                    data: [
                                <?php 
                                    $l = count($data);
                                    $j=1;
                                    foreach($data as $d)
                                    {
                                        if($j == $l){
                                            echo $d;
                                        }
                                        else{
                                            echo $d.',';
                                        }
                                        $j++;
                                    }
                                ?> 
                            ]
                    }],
                    stroke: {
                    width: 1,
                    colors: ['#fff']
                    },
                    xaxis: {
                    categories: [
                                    <?php 
                                        $l = count($label);
                                        $j=1;
                                        foreach($label as $d)
                                        {
                                            if($j == $l){
                                                echo "'$d'";
                                            }
                                            else{
                                                echo "'$d',";
                                            }
                                            $j++;
                                        }
                                    ?> 
                                ]
                    },
                    
                    yaxis: {
                            axisBorder: {show: true},
                            labels: {
                                show: true
                            }
                    },
                    // title: {
                    //     text: 'Custom DataLabels',
                    //     align: 'center',
                    //     floating: true
                    // },
                    // subtitle: {
                    //     text: 'Category Names as DataLabels inside bars',
                    //     align: 'center',
                    // },
                    tooltip: {
                    theme: 'dark',
                    x: {show: true,},
                    y: {
                        title: {
                        formatter: function formatter() {
                            return '';
                        }
                        }
                    }
                    }
                };
                
                var chart = new ApexCharts(document.querySelector("#<?php echo $div_id;?>"), options);
                chart.render(); // Patterned bar
            });
            </script>
       <?php
    }//function close




    //double bar chart
	public function print_double_bar_chart($div_id,$height,$color,$label,$data,$name)
	{
        $symbol ="";
        $l = count($label);
        $k = count($data);

       ?>
            <script>
                             $(document).ready(function () {
                                     if (document.querySelector("#<?php echo $div_id;?>")) {
                                         //    basic column Chart
                                         var options = {
                                            chart: {
                                            height: <?php echo $height;?>,
                                            type: 'bar',
                                            toolbar: {show: false}
                                            },
                                            plotOptions: {
                                            bar: {
                                                barHeight: '100%',
                                                distributed: false,
                                                horizontal: false,
                                                dataLabels: {
                                                position: 'top'
                                                },
                                                //endingShape: 'rounded'
                                            }
                                            },
                                            colors: [
                                                            <?php 
                                                                $j=1;
                                                                foreach($color as $d)
                                                                {
                                                                    if($j == $l){
                                                                        echo "'$d'";
                                                                    }
                                                                    else{
                                                                        echo "'$d',";
                                                                    }
                                                                    $j++;
                                                                }
                                                            ?> 
                                                    ],
                                            dataLabels: {
                                            enabled: true,
                                            textAnchor: 'start',
                                            style: {
                                                colors: ['black']
                                            },
                                            formatter: function formatter(val, opt) {
                                                //return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val;
                                                return val;
                                            },
                                            offsetY: -20,
                                            offsetX: -15,
                                            dropShadow: {
                                                enabled: false
                                            }
                                            },
                                         series:    [
                                                        <?php 
                                                            $m=0;
                                                            foreach($data as $dat)
                                                            {
                                                                //print_r($dat);
                                                                ?>
                                                                    {
                                                                        name: '<?php echo $name[$m];?>',
                                                                        data:   [
                                                                                    <?php 
                                                                                        $j=1;
                                                                                        foreach($dat as $d)
                                                                                        {
                                                                                            if($j == $l){
                                                                                                echo "'$d'";
                                                                                            }
                                                                                            else{
                                                                                                echo "'$d',";
                                                                                            }
                                                                                            $j++;
                                                                                        }
                                                                                    ?>   
                                                                                ]
                                                                    }
                                                                <?php
                                                                if($m != $k-1){echo ","; }
                                                                $m++;
                                                            }
                                                        ?>
                                                    ],
                                         xaxis: {
                                             categories: [
                                                            <?php 
                                                                $j=1;
                                                                foreach($label as $d)
                                                                {
                                                                    if($j == $l){
                                                                        echo "'$d'";
                                                                    }
                                                                    else{
                                                                        echo "'$d',";
                                                                    }
                                                                    $j++;
                                                                }
                                                            ?> 
                                                        ]
                                         },
                                        yaxis: {
                                            title: {
                                            text: ''
                                            }
                                        },
                                        fill: {
                                            opacity: 1
                                        },
                                        tooltip: {
                                            y: {
                                                formatter: function formatter(val) {
                                                    return val;
                                                    }
                                                }
                                         }
                                         };
                                         var chart = new ApexCharts(document.querySelector("#<?php echo $div_id;?>"), options);
                                         chart.render();
                                     } // column WIth DataLabel
 
                                 });


                                 
                     </script>
       <?php
    }//function close












    //circel chart
	public function print_pie2_chart($div_id,$width,$color,$label,$data)
	{
        $symbol ="";
        $l = count($label);
       ?>
            <script>
                $(document).ready(function () {
                var options = {
                    chart: {
                    width: '<?php echo $width;?>',
                    type: 'donut'
                    },
                    dataLabels: {
                    enabled: false
                    },
                    series: [
                                <?php 
                                    $j=1;
                                    foreach($data1 as $d)
                                    {
                                        if($j == $l){
                                            echo "'$d'";
                                        }
                                        else{
                                            echo "'$d',";
                                        }
                                        $j++;
                                    }
                                ?> 
                            ],
                    fill: {
                    type: 'gradient'
                    },
                    legend: {
                    formatter: function formatter(val, opts) {
                        return val + " - " + opts.w.globals.series[opts.seriesIndex];
                    },
                    position: 'bottom'
                    },
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 310
                        },
                        legend: {
                        position: 'bottom'
                        }
                    }
                    }]
                };
                var chart = new ApexCharts(document.querySelector("#<?php echo $div_id;?>"), options);
                chart.render();
                });
            
            </script>
        <?php
    }//function close




    //line chart
	public function print_line_chart($div_id,$height,$color,$label,$data)
	{
        $symbol ="";
        $l = count($label);
        ?> 
         <script>
               
                $(document).ready(function () {
                    var options = {
                        chart: {
                        height: <?php echo $height;?>,
                        type: 'line',
                        shadow: {
                            enabled: true,
                            color: '#000',
                            top: 18,
                            left: 7,
                            blur: 10,
                            opacity: 1
                        },
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true,
                            easing: 'linear',
                            speed: 500,
                            animateGradually: {
                            enabled: true,
                            delay: 150
                            },
                            dynamicAnimation: {
                            enabled: true,
                            speed: 550
                            }
                        }
                        },
                        colors: ['<?php echo $color;?>'],
                        dataLabels: {
                        enabled: true
                        },
                        stroke: {
                        curve: 'smooth'
                        },
                        series: [{
                        //name: "High - 2013",
                        data: [<?php 
                                $j=1;
                                foreach($data as $d)
                                {
                                    if($j == $l){
                                        echo "'$d'";
                                    }
                                    else{
                                        echo "'$d',";
                                    }
                                    $j++;
                                }
                            ?> ]
                        }],
                        grid: {
                        borderColor: '#e7e7e7',
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            // takes an array which will be repeated on columns
                            opacity: 0.5
                        }
                        },
                        markers: {
                        size: 6
                        },
                        xaxis: {
                        categories: [<?php 
                                        $j=1;
                                        foreach($label as $d)
                                        {
                                            if($j == $l){
                                                echo "'$d'";
                                            }
                                            else{
                                                echo "'$d',";
                                            }
                                            $j++;
                                        }
                                    ?> ],
                        //title: {text: 'Month'}
                        },
                        //yaxis: {min: 5,max: 40},
                        legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        floating: true,
                        offsetY: -25,
                        offsetX: -5
                        }
                    };
                    var chart = new ApexCharts(document.querySelector("#<?php echo $div_id;?>"), options);
                    chart.render(); // Zoomable timeseries line chart
                });
            </script>
        <?php
    }//function close




     //line chart
	public function print_multi_line_chart($div_id,$height,$color,$label,$data,$name)
	{
        $symbol ="";
        $l = count($label);
        $k = count($data);
        ?> 
         <script>
                "use strict";

                $(document).ready(function () {
                    var options = {
                    chart: {
                    height: <?php echo $height;?>,
                    type: 'line',
                    shadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 1
                    },
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'linear',
                        speed: 500,
                        animateGradually: {
                        enabled: true,
                        delay: 150
                        },
                        dynamicAnimation: {
                        enabled: true,
                        speed: 550
                        }
                    }
                    },
                    colors: [
                                <?php 
                                    $j=1;
                                    foreach($color as $d)
                                    {
                                        if($j == $l){
                                            echo "'$d'";
                                        }
                                        else{
                                            echo "'$d',";
                                        }
                                        $j++;
                                    }
                                ?>
                    ],
                    dataLabels: {
                    enabled: true
                    },
                    stroke: {
                    curve: 'smooth'
                    },
                    series: [
                                <?php 
                                    $m=0;
                                    foreach($data as $dat)
                                    {
                                        //print_r($dat);
                                        ?>
                                            {
                                                name: '<?php echo $name[$m];?>',
                                                data:   [
                                                            <?php 
                                                                $j=1;
                                                                foreach($dat as $d)
                                                                {
                                                                    if($j == $l){
                                                                        echo "'$d'";
                                                                    }
                                                                    else{
                                                                        echo "'$d',";
                                                                    }
                                                                    $j++;
                                                                }
                                                            ?>   
                                                        ]
                                            }
                                        <?php
                                        if($m != $k-1){echo ","; }
                                        $m++;
                                    }
                                ?>    
                    ],
                    grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        // takes an array which will be repeated on columns
                        opacity: 0.5
                    }
                    },
                    markers: {
                    size: 6
                    },
                    xaxis: {
                    categories: [
                                    <?php 
                                        $j=1;
                                        foreach($label as $d)
                                        {
                                            if($j == $l){
                                                echo "'$d'";
                                            }
                                            else{
                                                echo "'$d',";
                                            }
                                            $j++;
                                        }
                                    ?> 
                    ],
                    title: {
                        //text: 'Month'
                    }
                    },
                    yaxis: {
                    title: {
                       // text: 'Temperature'
                    },
                    //min: 5,
                    //max: 40
                    },
                    legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    floating: true,
                    offsetY: -25,
                    offsetX: -5
                    }
                };
                var chart = new ApexCharts(document.querySelector("#<?php echo $div_id;?>"), options);
                chart.render(); // Zoomable timeseries line chart
                });
            </script>
        <?php
    }//function close



}//class close



