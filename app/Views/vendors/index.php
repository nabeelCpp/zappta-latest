<?php print view('vendors/header');?>
	
	<section class="bread">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12">
					<div class="bb d-flex align-items-center">
					<i onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>
						<ul class="p-0 m-0 d-flex align-items-center">
							<li>
								<a href="<?php print base_url();?>">Home</a>
							</li>
							<li>/</li>
							<li><?php print $pagetitle;?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="vendor-dashbaord position-relative">
		<div class="container">
			<div class="wrapper  d-flex align-items-stretch">
		
				<?php print view('vendors/sidebar');?>

				<div id="content" class="float-start">
					<div class="container-fluid">
				<?php print view('vendors/compaign');?>
			          	<div class="row mt-4 mb-4">
							<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-3">
				              	<div class="card l-bg-cherry">
					                <div class="card-statistic-3 p-4">
					                    <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
					                    <div class="mb-4">
					                        <h5 class="card-title mb-0">Total Orders</h5>
					                    </div>
					                    <div class="row align-items-center mb-2 d-flex">
					                        <div class="col-8">
					                            <h2 class="d-flex align-items-center mb-0">
					                                <?php print isset($stats) ? number_format($stats['total_order']) : 0; ?>
					                            </h2>
					                        </div>
					                        <div class="col-4 text-right">
					                            <span>
													<?php 
													$percentageComparedToLastmonth =  isset($stats) ? calculatePercentage($stats['current_month_orders'],$stats['last_month_orders']) : 0;
													echo $percentageComparedToLastmonth < 0 ? -$percentageComparedToLastmonth : $percentageComparedToLastmonth; 
												?>% <i class="fa fa-arrow-<?=$percentageComparedToLastmonth > 0 ?'up':'down' ?>"></i></span>
					                        </div>
					                    </div>
					                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
					                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="<?php print  isset($stats) ? percentage($stats['total_order'],$stats['last_total_order']) : 0;?>%" aria-valuenow="<?php print  isset($stats) ? percentage($stats['total_order'],$stats['last_total_order']) : 0;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php print  isset($stats) ? percentage($stats['total_order'],$stats['last_total_order']) : 0;?>%;"></div>
					                    </div>
					                </div>
					            </div>
				             </div> 
							<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-3">
				              	<div class="card l-bg-blue-dark">
					                <div class="card-statistic-3 p-4">
					                    <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
					                    <div class="mb-4">
					                        <h5 class="card-title mb-0">New Orders</h5>
					                    </div>
					                    <div class="row align-items-center mb-2 d-flex">
					                        <div class="col-8">
					                            <h2 class="d-flex align-items-center mb-0">
					                                <?php print isset($stats) ? number_format($stats['pending_total_order']) : 0; ?>
					                            </h2>
					                        </div>
					                        <div class="col-4 text-right">
					                            <span><?php print isset($stats) ?  percentage($stats['pending_total_order'],$stats['last_pending_total_order']): 0;?>% <i class="fa fa-arrow-up"></i></span>
					                        </div>
					                    </div>
					                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
					                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="<?php print isset($stats) ?  percentage($stats['pending_total_order'],$stats['last_pending_total_order']) : 0;?>%" aria-valuenow="<?php print isset($stats) ?  percentage($stats['pending_total_order'],$stats['last_pending_total_order']) : 0;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php print isset($stats) ? percentage($stats['pending_total_order'],$stats['last_pending_total_order']) : 0 ;?>%;"></div>
					                    </div>
					                </div>
					            </div>
				            </div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-3">
				              <div class="card l-bg-orange-dark">
					                <div class="card-statistic-3 p-4">
					                    <div class="card-icon card-icon-large"><i class="fas fa-arrow-up"></i></div>
					                    <div class="mb-4">
					                        <h5 class="card-title mb-0">Total Sales</h5>
					                    </div>
					                    <div class="row align-items-center mb-2 d-flex">
					                        <div class="col-8">
					                            <h2 class="d-flex align-items-center mb-0">
					                                $<?php print isset($stats) ? number_format($stats['total_revnue'],2) : 0; ?>
					                            </h2>
					                        </div>
					                        <div class="col-4 text-right">
					                            <span><?php print isset($stats) ? percentage($stats['total_revnue'],$stats['last_total_revnue']) : 0;?>% <i class="fa fa-arrow-up"></i></span>
					                        </div>
					                    </div>
					                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
					                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="<?php print isset($stats) ? percentage($stats['total_revnue'],$stats['last_total_revnue']) : 0;?>%" aria-valuenow="<?php print isset($stats) ? percentage($stats['total_revnue'],$stats['last_total_revnue']):0;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php print isset($stats) ? percentage($stats['total_revnue'],$stats['last_total_revnue']):0;?>%;"></div>
					                    </div>
					                </div>
					            </div>
				            </div>
						</div>
						<div class="row mt-4 mb-4">
						  <canvas id="myNewChart"></canvas>
						</div>
						<div class="row mt-4 mb-4">
							<div class="chart-container" style="position: relative; height:auto !important;margin-bottom: 100px;">
								<canvas id="myChart" style="height:400px !important;"></canvas>
							</div>
						</div>
						
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>
	
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = [
	<?php print  !empty($getSalesData) ? "'" . implode ( "', '", $getSalesData['months'] ) . "'" : '';//implode("', '", $getChartData['months']);?>
  ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'Sales Throughout year ($)',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [<?php print  !empty($getSalesData) ? implode(', ', $getSalesData['count']) : '';?>],
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {}
  };

  const myNewChart = new Chart(
    document.getElementById('myNewChart'),
    config
  );
</script>
<script>

const ctx = document.getElementById('myChart').getContext('2d');

const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php print  !empty($getChartData) ? "'" . implode ( "', '", $getChartData['months'] ) . "'" : '';//implode("', '", $getChartData['months']);?>],
        datasets: [{
            label: 'Total Orders',
            data: [<?php print  !empty($getChartData) ? implode(', ', $getChartData['count']) : '';?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


</script>
 <?php // print view('vendors/footer');?> 