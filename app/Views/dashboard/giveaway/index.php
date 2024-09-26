<?php print view('site/header');?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style type="text/css">
		.page-content.pr-0
		{
			padding-right: 0 !important;

		}
		.dashboard-page .jumbotron
		{
			padding:2.5rem 1.35rem;

		}
		.pr-wrap
		{
			width: 100%;
			position: relative;
			
		}
		.pr-wrap::before
		{
			position: absolute;
			left: 4px;
			top: 16px;
			width: 96%;
			height: 80px;
			content: "";
			background: #C925F3;
			border-radius: 110px;

		}
		.pr-wrap::after
		{
			position: absolute;
			right: 0;
			top: 16px;
			width: 50%;
			height: 80px;
			content: "";
			background: #ffff;
			border-radius: 110px;

		}
		.pr-wrap .row
		{
			position: relative;
			z-index: 999;

		}
		.brand-img
		{
			position: relative;
			top: 16px;
		}
		.brand-img
		{
			width: 100%;
			height: 80px;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.prod-img
		{
			width: 100%;
			text-align: right;
			position: relative;
		}
		.prod-img .pr-info
		{
			position: absolute;
			left: 5px;
			bottom: 0;
			padding:0 4px;
			height: 22px;
			font-size: 11px;
			color: #fff;
			line-height: 18px;
			border-radius: 13px;
			background: #281957;
			border: 2px solid #fff;
			text-align: center;
			white-space: nowrap; 
			  width:96%; 
			  overflow: hidden;
			  text-overflow: ellipsis; 

		}
		.brand-img img
		{
			width:80px;
			height: auto;

		}
		.prod-img img
		{
			width: 90px;

		}
		h6.pr-price
		{
			color: #43245E;
			font-size: 32px;
			position: relative;
		}
		h6.pr-price sup
		{
			font-size: 16px;
			position: absolute;
			left: 0;
			top: 0;
		}
	</style>
	<section class="bread">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12">
					<div class="bb">
						<ul class="p-0 m-0 d-flex align-items-center">
							<li>
								<a href="<?php print base_url();?>">Home</a>
							</li>
							<li>/</li>
							<li>
								<a href="<?php print base_url().'/dashboard';?>"><?php print $pagetitle;?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="dashboard">
		<div class="container">

			<div class=" d-flex">
				<?php print view('dashboard/sidebar');?>
				<!-- Page content holder -->
				<div class="page-content pr-0 p-5 " id="content">

					<div class="dashboard-page">
						<p class="h3"> <i onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>Giveaways</p>
						<div class="jumbotron">
							<p class="text-center h5">Giveaways</p>
							<div class="row">
								<div class="col-md-6">
									<p class="h6">Current Winner</p>
									<div class="card mb-3">
		                              <div class="row no-gutters py-3 rounded px-2">
		                                <div class="col-md-3">
		                                  <img src="https://m.media-amazon.com/images/M/MV5BMTMyMjZlYzgtZWRjMC00OTRmLTllZTktMmM1ODVmNjljMTQyXkEyXkFqcGdeQXVyMTExNzQ3MzAw._V1_.jpg" class="card-img border border-warning img img-thumbnail img-responsive h-100 w-100" alt="...">
		                                </div>
		                                <div class="col-md-6">
		                                  <div class="card-body p-2">
		                                    <h5 class="card-title">David</h5>
		                                    <small class="text-muted" style="font-size: 12px;">With faded secondary text</small>
		                                  </div>
		                                </div>
		                                <div class="col-md-3">
		                                	<div class="pt-3 text-center">
		                                		<small class="text-center">Score</small>
		                                		<button class="btn btn-primary border border-warning text-center w-100" style="background-color: #2e057a;">28918</button>
		                                	</div>
		                                </div>
		                              </div>
		                            </div>
								</div>
								<div class="col-md-6">
									<p class="h6">Product</p>
									<div class="card mb-3">
		                              <div class="row no-gutters py-3 rounded px-2">
		                                <div class="col-md-9">
		                                	<div class="pr-wrap">
			                                	<div class="row">
			                                		<div class="col-6">
			                                			<div class="prod-img">
					                                  		<img src="https://pngimg.com/uploads/tshirt/tshirt_PNG5450.png" alt="...">
					                                  		<span class="pr-info">Adidas men's hoodies</span>
					                                  	</div>
			                                		</div>
			                                		<div class="col-6">
			                                			<div class="brand-img">
					                                  		<img src="https://zappta.com/theme/image/Group%201002.jpg" alt="...">
					                                  	</div>
			                                		</div>
			                                	</div>
		                                	</div>
		                                </div>
		                                <div class="col-md-3">
		                                	<div class="pt-3 text-center">
		                                		<small class="text-center">Score</small>
		                                		<h6 class="pr-price"><sup>$</sup>500</h6>
		                                	</div>
		                                </div>
		                              </div>
		                            </div>
								</div>
							</div>
						</div>
						
					</div>

				</div>
				<!-- End demo content -->
			</div>

		</div>
	</section>


<?php print view('site/footer');?>