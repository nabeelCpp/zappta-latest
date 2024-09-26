<?php print view('site/header');?>

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
				<div class="page-content p-5 " id="content">

					<div class="dashboard-page">
						
						<h3 class="mb-4"><i   onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i> Wallet</h3>
								
						<div class="row">
					        <div class="col-md-4 col-xl-4">
					            <div class="card bg-c-green order-card">
					                <div class="card-block">
					                    <h6 class="m-b-20">Total Earn Zappta</h6>
					                    <h2 class="text-right">
					                    	<div class="z-c">
												<span class="float-start me-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="11" height="24" viewBox="0 0 11 24">
													  <g id="Group_1" data-name="Group 1" transform="translate(-1363 -79)">
													    <text id="Z" transform="translate(1363 98)" fill="#ffffff" font-size="18" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>
													    <g id="Rectangle_4" data-name="Rectangle 4" transform="translate(1367 82)" fill="#fff" stroke="#ffffff" stroke-width="1">
													      <rect width="2" height="4" stroke="none"/>
													      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
													    </g>
													    <g id="Rectangle_5" data-name="Rectangle 5" transform="translate(1367 98)" fill="#fff" stroke="#ffffff" stroke-width="1">
													      <rect width="2" height="4" stroke="none"/>
													      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
													    </g>
													  </g>
													</svg>
												</span>
											 	<span class="float-start zzf"><?php print number_format($total_zappta['zapta_earn'],2);?></span>
											 	<div class="clearfix"></div>
											</div>
					                    </h2>
					                </div>
					            </div>
					        </div>
					        
					        <div class="col-md-4 col-xl-4">
					            <div class="card bg-c-yellow order-card">
					                <div class="card-block">
					                    <h6 class="m-b-20">Total Spend Zappta</h6>
					                    <h2 class="text-right">
					                    	<div class="z-c">
												<span class="float-start me-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="11" height="24" viewBox="0 0 11 24">
													  <g id="Group_1" data-name="Group 1" transform="translate(-1363 -79)">
													    <text id="Z" transform="translate(1363 98)" fill="#ffffff" font-size="18" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>
													    <g id="Rectangle_4" data-name="Rectangle 4" transform="translate(1367 82)" fill="#fff" stroke="#ffffff" stroke-width="1">
													      <rect width="2" height="4" stroke="none"/>
													      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
													    </g>
													    <g id="Rectangle_5" data-name="Rectangle 5" transform="translate(1367 98)" fill="#fff" stroke="#ffffff" stroke-width="1">
													      <rect width="2" height="4" stroke="none"/>
													      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
													    </g>
													  </g>
													</svg>
												</span>
											 	<!-- <span class="float-start zzf"><?php print number_format($total_spend['zappta_dollor'],2);?></span> -->
											 	<span class="float-start zzf"><?php print number_format(((new \App\Models\CompainModel())->getZapptaSpent()),2);?></span>
											 	<div class="clearfix"></div>
											</div>
					                    </h2>
					                </div>
					            </div>
					        </div>
					        
					        <div class="col-md-4 col-xl-4">
					            <div class="card bg-c-pink order-card">
					                <div class="card-block">
					                    <h6 class="m-b-20">Balance</h6>
					                    <h2 class="text-right">
					                    	<div class="z-c">
												<span class="float-start me-1">
													<svg xmlns="http://www.w3.org/2000/svg" width="11" height="24" viewBox="0 0 11 24">
													  <g id="Group_1" data-name="Group 1" transform="translate(-1363 -79)">
													    <text id="Z" transform="translate(1363 98)" fill="#ffffff" font-size="18" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>
													    <g id="Rectangle_4" data-name="Rectangle 4" transform="translate(1367 82)" fill="#fff" stroke="#ffffff" stroke-width="1">
													      <rect width="2" height="4" stroke="none"/>
													      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
													    </g>
													    <g id="Rectangle_5" data-name="Rectangle 5" transform="translate(1367 98)" fill="#fff" stroke="#ffffff" stroke-width="1">
													      <rect width="2" height="4" stroke="none"/>
													      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
													    </g>
													  </g>
													</svg>
												</span>
											 	<span class="float-start zzf">
											 		<?php 
											 			$balance = $total_zappta['zapta_earn'] - ((new \App\Models\CompainModel())->getZapptaSpent());
											 			if ( $balance > 0 ) {
											 				print number_format($balance,2);
											 			} else {
											 				print '0.00';
											 			}
											 		?>
											 	</span>
											 	<div class="clearfix"></div>
											</div>
					                    </h2>
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