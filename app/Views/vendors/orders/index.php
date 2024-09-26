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
			<div class="wrapper d-flex align-items-stretch">
		
				<?php print view('vendors/sidebar');?>

				<div id="content" class="float-start">
					<div class="container-fluid">
				<?php print view('vendors/compaign');?>
						
						<div class="row mt-4">
							<div class="col-xl-6 col-lg-6 col-md-6 col-12">
								<div class="total_orders"><b>Orders(<?php print $total_orders;?>)</b></div>
							</div>
						</div>

						<div class="mt-4" style="width:100%;overflow:auto;">
							<div class="table-responsive" style="min-width:652px;">
							<form>
								<div class="table-field d-flex">
									<div class="checkbox"><input type="checkbox" name="order_id[]" class="checked"></div>
									<div class="orderid">ID</div>
									<div class="customerid">Customer</div>
									<div class="deliveryid">Delivery</div>
									<div class="totalid">Total</div>
									<div class="paymentid">Payment</div>
									<div class="dateid">Date</div>
									<div class="statusid">Status</div>
									<div class="actionid"></div>
								</div>
							<?php 
								if ( is_array($orders) && count($orders) > 0 ) {
									foreach( $orders as $order ) {
							?>
								<div class="table-data-field d-flex">
									<div class="checkbox"><input type="checkbox" name="order_id[<?php print $order['order_id'];?>]" class="checkedAll"></div>
									<div class="orderid"><?php print $order['order_id'];?></div>
									<div class="customerid">
									<?php 
										if ( !empty($order['address']) && is_array($order['address']) && count($order['address']) > 0 ) {
									?>
										<span><?php print substr(ucfirst($order['address'][0]['first_name']),0,1) . '.' . $order['address'][0]['last_name'];?></span>
									<?php } ?>
									</div>
									<div class="deliveryid">
									<?php 
										if ( is_array($order['address']) && count($order['address']) > 0 ) {
									?>
										<span><?php print $order['address'][0]['stree_address'];?></span>
										<span><?php print $order['address'][0]['name'];?></span>
									<?php } ?>
									</div>
									<div class="totalid">$<?php print number_format($order['total'],2);?></div>
									<div class="paymentid"><?php print $order['payment'];?></div>
									<div class="dateid"><?php print $order['created_at'];?></div>
									<div class="statusid"><?php print $order['time_status'];?></div>
									<div class="actionid">
										<div class="action">
											<a class="dropdown-item bbdr" href="<?php print base_url().'/vendors/orders/view/'.my_encrypt($order['order_id']);?>">
			                                    <span class="icons"><i class="fa-solid fa-eye"></i></span>
			                                    <!-- <span>View</span> -->
			                                  </a>
											<!-- <div class="btn-group" role="group">
												<button id="btnGroupDrop<?php print $order['order_id'];?>" type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
													<svg id="Component_120_5" data-name="Component 120 – 5" xmlns="http://www.w3.org/2000/svg" width="19" height="5" viewBox="0 0 19 5">
						                              <g id="Group_315" data-name="Group 315">
						                                <circle id="Ellipse_34" data-name="Ellipse 34" cx="2.5" cy="2.5" r="2.5"/>
						                                <circle id="Ellipse_35" data-name="Ellipse 35" cx="2.5" cy="2.5" r="2.5" transform="translate(7)"/>
						                                <circle id="Ellipse_36" data-name="Ellipse 36" cx="2.5" cy="2.5" r="2.5" transform="translate(14)"/>
						                              </g>
						                            </svg>
												</button>
												<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop<?php print $order['order_id'];?>">
													<li>
					                                  <a class="dropdown-item bbdr" href="<?php print base_url().'/vendors/orders/view/'.my_encrypt($order['order_id']);?>">
					                                    <span class="icons"><i class="fa-solid fa-eye"></i></span>
					                                    <span>View</span>
					                                  </a>
					                                </li>
												</ul>
											</div> -->
										</div>
									</div>
								</div>
							<?php
									}
								} else {
							?>
							<div class="alert alert-danger">There is no order found</div>
							<?php } ?>
							</form>
							</div>
						</div>

						<?php 
							if ( $total_orders > 20 ) { ?>
						<div class="pagenation">
							<?php print $pager->makeLinks(1, 20, $total_orders,'front_full') ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>

<?php // print view('vendors/footer');?>