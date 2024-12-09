<?php $this->load->view('admin/common/header'); ?>
<div class="clearfix"></div>
<style type="text/css">
    .card {
        color: #ffffff;
    }
    h4{
        color: #ffffff;   
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid">
        <!--Start Dashboard Content-->       
        <div class="row mt-3">           
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card bg-dribbble">
                    <div class="card-body">
                        <div class="">
                            <div class="float-left mt-2" >
                                <h4><?php echo $users;?></h4>
                                <p>Total User</<p>
                            </div>
                            <div class="float-right">
                                <span style="font-size:30px;"><i class="fa fa-users"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card bg-behance">
                    <div class="card-body">
                        <div class="">
                            <div class="float-left mt-2" >
                                <h4><?php echo $category;?></h4>
                                <p>Total Category</<p>
                            </div>
                            <div class="float-right">
                                <span style="font-size:30px;"><i class="fa fa-pie-chart"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card bg-warning">
                    <div class="card-body">
                        <div class="">
                            <div class="float-left mt-2" >
                                <h4><?php echo $level;?></h4>
                                <p>Total level</<p>
                            </div>
                            <div class="float-right">
                                <span style="font-size:30px;"><i class="fa fa-linode"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="card bg-dark">
                    <div class="card-body">
                        <div class="">
                            <div class="float-left mt-2" >
                                <h4><?php echo $question;?></h4>
                                <p>Total Question</<p>
                            </div>
                            <div class="float-right">
                                <span style="font-size:30px;"><i class="fa fa-question-circle"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--End Row-->
          <!--End Dashboard Content-->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <h5 class="popover-title">This Week Refer & Earning User</h5>
                    <div class="card-body">

                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <h5 class="popover-title">Question By Type </h5>
                    <div class="card-body">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div> 
            <div class="col-lg-3">
                <div class="card">
                    <h5 class="popover-title">Total Play Contest</h5>
                    <div class="card-body">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

             <div class="col-lg-6">
                <div class="card">
                    <h5 class="popover-title">This week Register User </h5>
                    <div class="card-body">
                       <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <h5 class="popover-title">Last week earning top 10 users </h5>
                    <div class="card-body">
                         <canvas id="earningBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/common/footer'); ?>

<script src="<?php echo base_url(); ?>assets/plugins/chartjs/chart.min.js"></script>
<script>
 
    //line   
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday ", "Sunday"],
            datasets: [{
                    label: 'Refer Earning ', // Name the series
                    data: <?php echo json_encode($week_parent_earning);?>, // Specify the data values array
                    fill: false,
                    borderColor: '#2196f3', // Add custom color border (Line)
                    backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
                    borderWidth: 1 // Specify bar border width
                },
                {
                    label: 'Quiz Earning', // Name the series
                    data: <?php echo json_encode($week_earning);?>, // Specify the data values array
                    fill: false,
                    borderColor: '#4CAF50', // Add custom color border (Line)
                    backgroundColor: '#4CAF50', // Add custom color background (Points and Fill)
                    borderWidth: 1 // Specify bar border width
                }]
        },
        options: {
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
        }
    });


    //Doughnut
    var ctx = document.getElementById("doughnutChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Practice Questions", "Contest Questions"],
            datasets: [{
                    label: 'Total Record', // Name the series
                    data: [<?php echo $practice_questions; ?>, <?php echo $contest_questions; ?>], // Specify the data values array
                    fill: false,
                    backgroundColor: [
                        'rgb(255, 151, 0)',
                        'rgb(34, 48, 53)'
                    ],
                    hoverOffset: 4
                },
            ]
        },
        options: {
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
        }
    });

    //pie
    var ctx = document.getElementById("pieChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Total Play Practice ", "Total Play Contest"],
            datasets: [{
                    label: 'Total Record', // Name the series
                    data: [<?php echo $practice_play; ?>,<?php echo $contest_play; ?>], // Specify the data values array
                    fill: false,
                    backgroundColor: [
                        'rgb(234, 76, 137)',
                        'rgb(92, 99, 160)'
                    ],
                    hoverOffset: 4
                },
            ]
        },
        options: {
            responsive: true, // Instruct chart js to respond nicely.
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
        }
    });

    //Bar
    var ctx = document.getElementById("barChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday ", "Sunday"],
            datasets: [{
                    label: 'Total User', // Name the series
                    data: <?php echo json_encode($week_user); ?>, // Specify the data values array
                    fill: false,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(149, 220, 211)',
                        'rgb(92, 99, 160)',
                        'rgb(255,193,7)',
                        'rgb(0,123,255)',
                        'rgb(34,48,53)'
                    ],
                    hoverOffset: 4
                },
            ]
        }
    });


   //Bar earning chart
    var ctx = document.getElementById("earningBarChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($week_earning_label); ?>,
            datasets: [{
                    label: 'Earning', // Name the series
                    data: <?php echo json_encode($week_earning_data); ?>, // Specify the data values array
                    fill: false,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(149, 220, 211)',
                        'rgb(92, 99, 160)',
                        'rgb(255,193,7)',
                        'rgb(0,123,255)',
                        'rgb(34,48,53)'
                    ],
                    hoverOffset: 4
                },
            ]
        },
         options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        min: 0,
                        max: 500    
                    }
                  }]
               }
            }
    }); 

</script>