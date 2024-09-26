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

	<section  class="dashboard position-relative">
		<div class="container">

			<div class="d-flex">
				
				
                       <?php print view('dashboard/sidebar');?>
               
				<!-- Page content holder -->
				<div class="page-content  position-relative" id="content">

					<div class="dashboard-page">
						<h3 class="mb-4"><i   onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>  Welcome to your Account</h3>
						<div class="dash-colum d-flex align-items-center">
							<a href="<?php print base_url().'/dashboard/history';?>" class="d-flex align-items-center">
								<div class="icon-history"></div>
								<div class="text">Purchase History</div>
								<div class="arrow text-end"><i class="fa-solid fa-chevron-right"></i></div>
							</a>
						</div>
						<div class="dash-colum mt-4 d-flex align-items-center">
							<a href="<?php print base_url().'/dashboard/wallet';?>" class="d-flex align-items-center">
								<div class="icon-wallet"></div>
								<div class="text">Wallet</div>
								<div class="arrow text-end"><i class="fa-solid fa-chevron-right"></i></div>
							</a>
						</div>
						<div class="account-info mt-4 d-block">
							<div class="dash-colum d-flex align-items-center">
								<div class="icon-account"></div>
								<div class="text">
									<h6>Account Info</h6>
									<p>Address, contact information & password</p>
								</div>
								<div class="arrow text-end"><i class="fa-solid fa-chevron-right"></i></div>
							</div>
							<div class="user-data">
								<div class="row dashb align-items-center">
									<div class="col-xl-6 col-lg-6 col-md-6 col-12 dashbr">
										<div class="pt-3 pb-3">
											<h6>Email Address</h6>
											<div class="d-flex align-items-center">
												<p><?php print $user['email'];?></p>
											<?php if ( $user['email_verify'] == 1 ) { ?>
												<button type="button" class="btn">Need Verification</button>
											<?php } ?>
											</div>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-12">
										<div class="pt-3 pb-3">
											<h6>Phone Number</h6>
											<div class="d-flex align-items-center">
												<?php if ( !empty($user['phone']) ) { ?>
													<p><?php print $user['phone_code'].$user['phone'];?><?=!$user['phone_code']&&!$user['phone']?'-':''?></p>
													<?php if ( $user['phone_verify'] == 1 ) { ?>
													<button type="button" class="btn">Need Verification</button>
													<?php } ?>
												<?php } else { ?>
													<!-- <button type="button" class="btn">Add phone number</button> -->
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<div class="row align-items-center">
									<div class="col-xl-12 col-lg-12 col-md-12 col-12">
										<div class="pt-3 pb-3">
											<div class="address-col d-flex align-items-center">
												<div class="d-text">
													<h6>Address</h6>
													<!-- <p>Lorem ipsum, or lipsum as it is sometimes </p> -->
												</div>
												<div class="d-btn">
													<a href="<?php print base_url().'/dashboard/addresses';?>">View Address</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="account-info mt-4 d-block">
							<div class="dash-colum d-flex align-items-center">
								<div class="icon-list"></div>
								<div class="text">List (1)</div>
								<div class="arrow text-end"><i class="fa-solid fa-chevron-right"></i></div>
							</div>
							<div class="user-data">
								<div class="list-row d-flex align-items-center">
									<div class="image">
										<img src="<?php print base_url()?>/theme/image/dashboard/shoes.jpg" alt="" />
									</div>
									<div class="listname">
										<h6>Wish List</h6>
										<p><?=$items?> items</p>
									</div>
									<div class="listlink"></div>
									<div class="listbtn">
										<a href="<?php print base_url().'/dashboard/wishlist';?>">View List</a>
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



