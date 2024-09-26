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
				<div class="page-content  "  id="content">

					<div class="dashboard-page">
						
						<h3 class="mb-4"><i   onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>Delivery Address</h3>
						<div class="eerr mt-3 mb-3"><?php print show_message();?></div>
						<div class="dadd">
						<?php 
							if ( is_array($address) && count($address) > 0 ) {
								foreach ( $address as $add ) {
						?>
							<div class="daddrow d-flex align-items-center">
								<div class="rrt">
									<h6><?php print $add['first_name'] . ' ' . $add['last_name'];?></h6>
									<p><?php print $add['stree_address'] . ' ' . $add['stree_address_optional'] . ' ' . $add['town_city'] . ', ' . $add['postcode'];?></p>
								</div>
								<div class="rrbt">
									<a href="<?php print base_url().'/dashboard/addresses/remove/'.my_encrypt($add['id']);?>" onclick="return confirm ('Are sure to delete ?');">Remove</a>
								</div>
							</div>
						<?php
								}
							}
						?>
						</div>
							
					</div>

				</div>
				<!-- End demo content -->
			</div>

		</div>
	</section>


<?php print view('site/footer');?>