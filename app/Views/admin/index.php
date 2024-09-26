<?php print view('admin/header');?>
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
<style>
  .bg-secondary{
    --bs-bg-opacity:  0.1 !important;
  }
</style>
          <div class="row">
            <div class="col-sm-12">
                <p class="h1">Dashboard</p>
                <p class="text-muted text-bold">Overview</p>
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <!-- <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a> -->
                    </li>
                  </ul>
                  <div>
                    <!-- <div class="btn-wrapper">
                      <a href="#" class="btn btn-otline-dark"><i class="icon-share"></i> Share</a>
                      <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                      <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Export</a>
                    </div> -->
                  </div>
                </div>
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"> 
                    

                    <div class="row">
                            <div class="col-md-6 col-xl-3 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="Total Revenue">Total Revenue</h5>
                                                <h3 class="my-2 py-1">$ <?=$stats->getTotalRevenue()?></h3>
                                            </div>
                                        </div> <!-- end row-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->
        
                            <div class="col-md-6 col-xl-3 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="Revenue Today">Revenue Today</h5>
                                                <h3 class="my-2 py-1">$ <?=$stats->getTotalDailyRevenue()?></h3>
                                            </div>
                                        </div> <!-- end row-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="Total Visitors">Total Visitors</h5>
                                                <h3 class="my-2 py-1"><?=$stats->getTotalCustomer()?></h3>
                                            </div>
                                        </div> <!-- end row-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="New Visitors">New Visitors</h5>
                                                <h3 class="my-2 py-1"><?=$stats->getTotalDailyCustomer()?></h3>
                                            </div>
                                        </div> <!-- end row-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="Total Orders">Total Orders</h5>
                                                <h3 class="my-2 py-1"><?=$stats->getTotalOrders()?></h3>
                                            </div>
                                        </div> <!-- end row-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="Total Orders">Total Giveaways</h5>
                                                <h3 class="my-2 py-1"><?=$stats->getTotalGiveaways()?></h3>
                                            </div>
                                        </div> <!-- end row-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->

                            <div class="col-md-6 col-xl-3 mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="Total Orders">Total Stores</h5>
                                                <h3 class="my-2 py-1"><?=$stats->getTotalStores()?></h3>
                                            </div>
                                        </div> <!-- end row-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col -->
                        </div>
                    
                    <!-- End Small Stats Blocks -->
                    <div class="d-flex justify-content-around flex-wrap">
                      <div class=" mb-4 mt-4">
                        <canvas id="myChart" style="max-height:410px !important; height:410px;width:410px; "></canvas>
                      </div>
                      <div class=" mb-4 mt-4">
                        <canvas id="myDonutChart" style="max-height:410px !important; height:410px;width:410px; "></canvas>
                      </div>
                   </div>
                   <div class="row mb-5">
                      <div class="col-md-12 card p-3">
                        <div class="card-header">
                          <h5>Sales report</h5>
                        </div>
                          <table class="card-body table table-bordered">
                            
                            <thead>
                              <tr>
                                <th scope="col">Brand</th>
                                <th scope="col">Storename</th>
                                <th scope="col">Store Link</th>
                                <th scope="col">Sales</th>
                                <th scope="col">Orders Pending</th>
                                <th scope="col">Orders Delivered</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats->getSalesReport(5) as $key => $st) { ?>
                                  <tr>
                                    <td>
                                      <?php 
                                          if( ! empty( $st->store_logo ) ) { 
                                            $ext_name = explode('.',$st->store_logo);
                                        ?>
                                          <img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded" alt="" width="50">
                                        <?php } else { ?>
                                          <img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" class="border rounded" alt="" width="50">
                                        <?php }?>  
                                    </td>
                                    <td><?=$st->store_name?></td>
                                    <td><a href="<?=$st->store_link?$st->store_link:'#'?>" class="btn btn-link"><?=$st->store_link?></a></td>
                                    <td><?=$st->sales?></td>
                                    <td><?=$st->pending?></td>
                                    <td><?=$st->delivered?></td>
                                  </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                      </div>
                   </div>
                   <div class="row mb-5">
                    <div class="col-md-12 card p-3">
                        <div class="card-header">
                          <h5>Sales by Category</h5>
                        </div>
                            <table class="card-body table table-bordered">
                              
                              <tbody>
                                <?php $getSalesByCategory = $stats->getSalesByCategory();
                                    if(is_array($getSalesByCategory)){
                                      foreach($getSalesByCategory as $cats) { ?>
                                        <tr>
                                          <td>
                                            <?php 
                                              if( ! empty( $cats['cat_icon'] ) ) { 
                                                $ext_name = explode('.',$cats['cat_icon']);
                                            ?>
                                              <img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded" alt="" width="50">
                                            <?php } else { ?>
                                              <img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" class="border rounded" alt="" width="50">
                                            <?php }?>
                                            <?php print $cats['name'];?>   
                                          </td>
                                          <td>
                                            $ <?php print number_format($cats['subtotal'],2);?>
                                          </td>
                                        </tr><?php
                                      }
                                    } ?>     
                              </tbody>
                            </table>
                    </div>
                   </div>
                    

                    

                     <div class="col-12 table-compaign mt-3 card p-3" >
                     <table class="card-body table table-hover " id="table-compaign">
                       <thead>
                        <tr>
                         <th>#</th>
                         <th>Store</th>
                         <th>Products</th>
                         <th>Worth</th>
                         <th>Winner</th>
                         <th>Participants</th>
                         <th>Ending time</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      
                      </tbody>
                    </table>
                    
   
                    </div>
                    
                  </div>
                  </div>
                </div>
              </div>
            </div>
          

        

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>          
<script src="<?php print base_url();?>/admin_theme/Chart.js/2.7.1/Chart.min.js"></script>
<script type="text/javascript">
    let giveAways = <?=$stats->giveawaysReport()?>;
    let i = 1;
    let html = giveAways.map(g=>{
                  let products_list = ''; 
                  let worth_list = '';
                  let winners = ''; 
                  let participents = '';
                  if(g.products !== undefined && g.products.length){
                    g.products.map(product=>{
                      products_list += `<li class="list-group-item">${product.name?product.name:'-'}</li>`;
                      worth_list += `<li class="list-group-item">$ ${product.final_price?product.final_price:'-'}</li>`;
                      winners += `<li class="list-group-item">${product.winner !== null?`${product.winner.fname} (${product.winner.score})`:'-'}</li>`;
                      participents += `<li class="list-group-item">${product.participants?product.participants:'-'}</li>`;
                    })
                  }
                  return `<tr>
                            <th>${i++}</th>
                            <td>${g.store_name}</td>
                            <td>
                              <ul class="list-group">${products_list?products_list:'-'}</ul>
                            </td>
                            <td><ul class="list-group">${worth_list?worth_list:'-'}</ul></td>
                            <td><ul class="list-group">${winners?winners:'-'}</ul></td>
                            <td><ul class="list-group">${participents?participents:'-'}</ul></td>
                            <td><ul class="list-group">${g.compain_e_date}</ul></td>
                          </tr>`;
              });
    $('.table-compaign').find('tbody').html(html);
    
    !(function (o) {
    o(document).ready(function () {
        var a = window.ShardsDashboards.colors;
        o("#sales-overview-date-range").datepicker({}), o("#sales-report-date-range").datepicker({});
        var e = { responsive: !0, legend: { display: !1 }, tooltips: { enabled: !1 }, elements: { point: { radius: 0 } }, scales: { xAxes: [{ gridLines: !1, ticks: { display: !1 } }], yAxes: [{ gridLines: !1, ticks: { display: !1 } }] } };
        [
            { backgroundColor: a.primary.toRGBA(0.1), borderColor: a.primary.toRGBA(), data: [4, 4, 4, 9, 20] },
            { backgroundColor: a.success.toRGBA(0.1), borderColor: a.success.toRGBA(), data: [1, 9, 1, 9, 9] },
            { backgroundColor: a.warning.toRGBA(0.1), borderColor: a.warning.toRGBA(), data: [9, 9, 3, 9, 9] },
            { backgroundColor: a.salmon.toRGBA(0.1), borderColor: a.salmon.toRGBA(), data: [3, 3, 4, 9, 4] },
        ].forEach(function (o, a) {
            const r = document.getElementsByClassName("sales-overview-small-stats-" + (a + 1));
            new Chart(r, {
                type: "line",
                data: { labels: ["Label 1", "Label 2", "Label 3", "Label 4", "Label 5"], datasets: [{ label: "Today", fill: "start", data: o.data, backgroundColor: o.backgroundColor, borderColor: o.borderColor, borderWidth: 1.5 }] },
                options: e,
            });
        });
        var r = document.getElementsByClassName("sales-overview-sales-report")[0];
        (window.SalesOverviewChart = new Chart(r, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Nov", "Dec"],
                datasets: [
                    {
                        label: "Total",
                        fill: "start",
                        data: [<?php print $stats->getTotalProfit();?>],
                        backgroundColor: "#3fce89",
                        borderColor: "#3fce89",
                        pointBackgroundColor: "#FFFFFF",
                        pointHoverBackgroundColor: "#3fce89",
                        borderWidth: 1.5,
                    },
                    {
                        label: "Shipping",
                        fill: "start",
                        data: [<?php print $stats->getTotalShipping();?>],
                        backgroundColor: "rgba(72, 160, 255, 1)",
                        borderColor: "rgba(72, 160, 255, 1)",
                        pointBackgroundColor: "#FFFFFF",
                        pointHoverBackgroundColor: "rgba(0, 123, 255, 1)",
                        borderWidth: 1.5,
                    },
                    {
                        label: "Discount",
                        fill: "start",
                        data: [<?php print $stats->getTotalDiscount();?>],
                        backgroundColor: "rgba(153, 202, 255, 1)",
                        borderColor: "rgba(153, 202, 255, 1)",
                        pointBackgroundColor: "#FFFFFF",
                        pointHoverBackgroundColor: "rgba(0, 123, 255, 1)",
                        borderWidth: 1.5,
                    },
                ],
            },
            options: {
                legend: !1,
                tooltips: { enabled: !1, mode: "index", position: "nearest" },
                scales: {
                    xAxes: [{ stacked: !0, gridLines: !1 }],
                    yAxes: [
                        {
                            stacked: !0,
                            ticks: {
                                userCallback: function (o, a, e) {
                                    return o > 999 ? (o / 1e3).toFixed(0) + "k" : o;
                                },
                            },
                        },
                    ],
                },
            },
        })),
            o("#sales-overview-sales-report-legend").html(SalesOverviewChart.generateLegend()),
            google.charts.load("current", { packages: ["geochart"], mapsApiKey: "AIzaSyDlk2gIRtfbeYbF0n4plYUG-5MXIsEJtVA" }),
            google.charts.setOnLoadCallback(function () {
                var o = google.visualization.arrayToDataTable([
                        ["Country", "Sales"],
                        <?php 
                            $getCityOrder = $stats->getCityOrder();
                            if( $getCityOrder !== NULL ) {
                                foreach ($getCityOrder as $key ) {
                        ?>["<?php print $key['name'];?>", <?php print $key['total'];?>],<?php          
                                }
                            }
                        ?>]),
                    a = { 
                          region: 'SA',
                          displayMode: 'markers',
                          colorAxis: { colors: ["#B9C2D4", "#E4E8EF"] }, legend: !1 },
                    e = new google.visualization.GeoChart(document.getElementById("users-by-country-map"));
                function r() {
                    e.draw(o, a);
                }
                r(), window.addEventListener("resize", r);
            });
    });
})(jQuery);

</script>          

<?php print view('admin/footer');?>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script>
  {
    let revenue = '<?=json_encode($stats->lastMonthsRevenue())?>';
    
    revenue = JSON.parse(revenue);
    
    const labels = [];
    const points = [];
    revenue.forEach(r=>{
      labels.push(r.month);
      points.push(r.revenue);
    })
  
    const data = {
      labels: labels,
      datasets: [{
        label: 'Revenue ($)',
        backgroundColor: [
          'rgb(255, 140, 132)',
          'rgb(54, 255, 150)',
          'rgb(255, 205, 150)',
          'rgb(190, 0, 80)',
          'rgb(80, 0, 80)',
          'rgb(54, 140, 150)',
          'rgb(54, 10, 150)'
        ],
    
        data: points,
      }]
    };
  
    const config = {
      type: 'pie',
      data: data,
      options: {}
    };
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  }
  {
    let visitors = '<?=json_encode($stats->lastMonthsVisitors())?>';
    visitors = JSON.parse(visitors);
    const labels = [];
    const points = [];
    visitors.forEach(r=>{
      labels.push(r.month);
      points.push(r.visitors);
    })

    const data = {
      labels: labels,
      datasets: [{
        label: 'No. of Visitors',
        data: points,
        backgroundColor: [
          'rgb(255, 99, 132)',
          'rgb(54, 162, 235)',
          'rgb(255, 205, 86)',
          'rgb(252, 24, 46)',
          'rgb(55, 205, 16)',
          'rgb(255, 25, 38)'
        ],
        hoverOffset: 4
      }]
    };
    const config = {
      type: 'doughnut',
      data: data,
    };
  
    
  
    
    const myDonutChart = new Chart(
      document.getElementById('myDonutChart'),
      config
    );
  }

  $('#campaignSlider').slick({
    dots: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    infinite: true,
    // arrows: true,
    // nextArrow: '<button class="nextArrow"><i class="fa-solid fa-chevron-right"></i></button>',
    // prevArrow: '<button class="prevArrow"><i class="fa-solid fa-chevron-left"></i></button>',
    responsive: [
      {
        breakpoint: 1081,
        settings: {
          centerMode: true,
          centerPadding: '0px',
          slidesToShow: 3
        }
      },
      {
        breakpoint: 845,
        settings: {
          centerMode: true,
          centerPadding: '0px',
          slidesToShow: 2
        }
      },
      {
        breakpoint: 577,
        settings: {
          centerMode: true,
          centerPadding: '0px',
          slidesToShow: 1
        }
      },
      {
        breakpoint: 481,
        settings: {
          centerMode: true,
          centerPadding: '0px',
          slidesToShow: 1
        }
      }
      ]
  });

  $('#table-compaign').dataTable({
    scrollX: true,
  });

</script>