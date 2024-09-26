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
						
						<h3> <i   onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i> Purchase History</h3>
						
						<?php 
							if ( is_array($order_list) && count($order_list) > 0 ) {
								foreach( $order_list['order'] as $list ) {
						?>
						<div class="list-colum">
							<div class="order-status">
								<?php print orderCartOnAdminStatus($list['status']);?>
								<?php if($list['status'] == 4){?>
								<span class="orderdd"><?php print $list['status_date'];?></span>
								<?php } ?>
							</div>
							<div class="row">
								<div class="col-xl-7 col-lg-7 col-md-7 col-12">
								<?php foreach ( $order_list['items'][$list['id']] as $items) { ?>	
									<div class="item-list d-flex">
										<div class="image">
											<img src="<?php print $items['item_image'];?>" alt="<?php print $items['item_name'];?>"/>
										</div>
										<div class="detail">
											<h4><?php print short($items['item_name'],70);?></h4>
											<span>7am - 7pm</span>
										</div>
									</div>
								<?php } ?>
								</div>
								<div class="col-xl-5 col-lg-5 col-md-5 col-12">
									<div class="buttonorder">
										<a class="orders animate" href="<?php print base_url().'/dashboard/history/status?order_id='.my_encrypt($list['id']).'&key='.csrf_hash();?>">Order Status</a>
										<a class="orderv animate" href="<?php print base_url().'/dashboard/history/view?order_id='.my_encrypt($list['id']).'&key='.csrf_hash();?>">View Order Detail</a>
										<a href="<?php print base_url().'/dashboard/history/invoice?order_id='.my_encrypt($list['id']).'&key='.csrf_hash();?>">Get Invoice</a>
									</div>
								</div>
							</div>
						</div>
						<?php
								}
							}
						?>
						<?php if ( $total_order > 10 ) { ?>
						<div class="pagenation">
							<?php print $pager->makeLinks(1, 10, $total_order,'front_full') ?>
						</div>
						<?php } ?>
					</div>

				</div>
				<!-- End demo content -->
			</div>

		</div>
	</section>


<?php print view('site/footer');?>