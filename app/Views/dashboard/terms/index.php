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

			<div class="position-relative d-flex">
				<?php print view('dashboard/sidebar');?>
				<!-- Page content holder -->
				<div class="page-content p-5 position-relative" id="content">

					<div class="dashboard-page">
						
						<h3 class="mb-4">Hi <?php print getUserName();?>, How can we help you?</h3>
						
						<div class="help-block">
							<div class="row align-items-center justify-content-center">
								<div class="col-xl-4 col-lg-4 col-md-4 col-12 p-0 dashbr">
									<div class="hh text-center">
										<div class="icon order_icon"></div>
										<div class="text">Track your order</div>
									</div>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-12 p-0 dashbr">
									<div class="hh text-center">
										<div class="icon cancel_order"></div>
										<div class="text">Edit or cancel an Order</div>
									</div>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-12 p-0">
									<div class="hh text-center">
										<div class="icon refund_order"></div>
										<div class="text">Returns & Refunds</div>
									</div>
								</div>
							</div>
							<div class="row align-items-center">
								<div class="col-xl-12 col-lg-12 col-md-12 col-12 p-0">
									<div class="inputfield position-relative">
										<div class="icon position-absolute"><i class="fa-solid fa-magnifying-glass"></i></div>
										<input type="text" name="q" class="form-control" placeholder="Search help topics">
									</div>
								</div>
							</div>
						</div>

						<div class="contactus">
							<a href="<?php print base_url().'/contact-us'?>">Contact us</a>
						</div>

					</div>

				</div>
				<!-- End demo content -->
			</div>

		</div>
	</section>


<?php print view('site/footer');?>