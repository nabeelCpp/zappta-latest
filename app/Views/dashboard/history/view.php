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
						
						<h3>Order Detail</h3>
						<div class="row mt-4 ">
							<div class="col-xl-8 col-lg-8 col-md-8 col-12 mb-3">
								<?php 
									if ( is_array($address) && count($address) > 0 ) {
								?>
								<div class="order_address d-flex">
									<div class="shipping">
										<h4>Billing Info</h4>
										<h6><?php print $address[0]['first_name'] . ' ' . $address[0]['last_name'];?></h6>
										<p><?php print $address[0]['company_name'];?></p>
										<p><?php print $address[0]['stree_address'];?></p>
										<p><?php print $address[0]['stree_address_optional'];?></p>
										<p><?php print $address[0]['town_city'];?>, <?php print $address[0]['postcode'];?></p>
										<p><?php print $address[0]['country_name'];?></p>
										<p><?php print $address[0]['email'];?></p>
										<p><?php print $address[0]['phone'];?></p>
									</div>
									<div class="shipping">
										<h4>Shipping Info</h4>
										<h6><?php print $address[1]['first_name'] . ' ' . $address[1]['last_name'];?></h6>
										<p><?php print $address[1]['company_name'];?></p>
										<p><?php print $address[1]['stree_address'];?></p>
										<p><?php print $address[1]['stree_address_optional'];?></p>
										<p><?php print $address[1]['town_city'];?>, <?php print $address[1]['postcode'];?></p>
										<p><?php print $address[1]['country_name'];?></p>
										<p><?php print $address[1]['email'];?></p>
										<p><?php print $address[1]['phone'];?></p>
									</div>
								</div>
								<?php
									}
								?>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-12">
								<div class="order_info">
									<h4>Order information</h4>
									<h6>Order #<?php print $order['order']['order_serial'];?></h6>
									<p>Made on: <?php print $order['order']['order_date'];?></p>
									<p>Order status: <?php print orderCartOnAdminStatus($order['order']['order_status']);?></p>
									<p>Payment Method: <?php print $order['order']['payment_method'];?></p>
								</div>
							</div>
						</div>
						<div class="order_items mt-4" style="overflow-y:auto;">
							<table style="min-width:600px;" class="table justify-content-center align-items-center">
								<thead>
									<tr>
										<th></th>
										<th>Product</th>
										<th>Store</th>
										<th>Price</th>
										<th>Quantity</th>
										<th>Discount</th>
										<th>Shipping</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$total_sub_total = [];
									$total_shipping = [];
									$total_grand = [];
									$discount = 0;
									if ( is_array($order['items']) && count($order['items']) > 0 ) {
										foreach( $order['items'] as $it ) {
											$total_sub_total[] = $it['subtotal'];
											$total_shipping[] = $it['shipping'];
											$total_grand[] = $it['subtotal'];
											$attributes = $it['attribute'];
								?>
									<tr>
										<td width="50">
											<div class="td-thumb">
												<img src="<?php print $it['item_image']?>" alt="">
											</div>
										</td>
										<td>
											<?php print ucfirst($it['item_name']);?>
											<?php 
												if ( !empty($attributes) && is_array($attributes) && count($attributes) > 0 ) {
													if ( $attributes[0]['attribute_id'] > 0 ) {
											?>	
											<p class="d-flex cart-attr">
											<?php 
													foreach ( $attributes as $option ) {
											?>	
													<span><?php print $option['value_name'];?></span>
											<?php
													}
											?>	
											</p>
											<?php 
													}
												}
											?>
										</td>
										<td><?=$it['store_name']?></td>
										<td>$<?php print number_format($it['price'],2);?></td>
										<td><?php print $it['qty'];?></td>
										<td>$<?php if(count($coupons) == 0){echo number_format(0, 2);}foreach ($coupons as $key => $cop) {
											if($cop->item_id == $it['item_id']){
												$discount += $cop->coupon_price_used;
												echo number_format($cop->coupon_price_used, 2);
											}else{
												echo number_format(0, 2);
											}
										} ?></td>
										<td>$<?php print number_format($it['shipping'],2);?></td>
										<td>$<?php print number_format($it['subtotal'],2);?></td>
									</tr>
								<?php
										}
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5">Subtotal</td>
										<td>$<?php print number_format($order['order']['final_subtotal'],2);?></td>
									</tr>
									<tr>
										<td colspan="5">Shipping</td>
										<td>$<?php print number_format($order['order']['shipping'],2);?></td>
									</tr>
									<tr>
										<td colspan="5">Discount</td>
										<td>$<?php print number_format($order['order']['discount']+$discount,2);?></td>
									</tr>
									<tr>
										<td colspan="5">Grand Total</td>
										<td>$<?php print number_format($order['order']['total_amount'],2);?></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>

				</div>
				<!-- End demo content -->
			</div>

		</div>
	</section>


<?php print view('site/footer');?>