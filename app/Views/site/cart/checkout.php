<?php print view('site/newLanding/header'); ?>

<section class="py-3">
	<div class="container">
		<div class="w-100 mb-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php print base_url();?>">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page"> <?php print $pagetitle;?></li>
				</ol>
			</nav>
		</div>
		<?php if ( is_array(get_cart_contents()) && count(get_cart_contents()) > 0 ) { ?>
			<div class="cartSection ">
				<form method="post" action="<?php print base_url().'/cart/address';?>" id="checkoutform">
					<input type="hidden" name="<?php print csrf_token() ?>" id="_cc" value="<?php print csrf_hash() ?>">
					<div class="row no-gutters mt-5">
						<div class="col-lg-8">
							<!-- Cart Items -->
							<div class="card leftCartContent checkOutPage mb-4">
								<div class="card-body">
									<h2 class="card-title mb-4">Billing Information</h2>

									<div class="row">
										<div class="col-md-4 form-group">
											<label for="firstname">First Name<span>*</span></label>
											<input type="text" name="address[billing][first_name]" class="form-control required" data-msg-required="Please enter your First name" placeholder="First Name"/>
											<div class="invalid-feedback">
												<!-- Valid first name is required. -->
											</div>
										</div>

										<div class="col-md-4 form-group">
											<label>Last name<span>*</span></label>
											<input type="text" name="address[billing][last_name]"  class="form-control required" placeholder="Last Name" data-msg-required="Please enter your Last name"/>
											<div class="invalid-feedback">
												<!-- Valid last name is required. -->
											</div>
										</div>
										<div class="col-md-4 form-group">
											<label for="companyname">Company Name <span>(Optional)</span></label>
											<input type="text" name="address[billing][company_name]"  class="form-control"  placeholder="Company Name"/>

										</div>
									</div>
									<div class="row">
										<div class="col-md-12 form-group">
											<label for="address">Address</label>
											<input type="text" class="form-control" id="address" placeholder="Address">
											<div class="invalid-feedback">
												Address required.
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3 form-group">
											<label for="Country">Country</label>
											<input type="text" class="form-control" id="country" placeholder="Country" name="address[billing][country]">
											<div class="invalid-feedback">
												Country is required.
											</div>
										</div>

										<div class="col-md-3 form-group">
											<label for="state">Region/State</label>
											<input type="text" class="form-control" id="state" placeholder="state">
											<div class="invalid-feedback">
												State is required.
											</div>
										</div>
										<div class="col-md-3 form-group">
											<label for="City">City </label>
											<input type="text" class="form-control" id="City" placeholder="City">
											<div class="invalid-feedback">
												City is required.
											</div>
										</div>
										<div class="col-md-3 form-group">
											<label for="zipCode">Zip Code </label>
											<input type="text" class="form-control" id="zipCode" placeholder="Zip Code">
											<div class="invalid-feedback">
												Zip Code is required.
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 form-group">
											<label for="email">Email</label>
											<input type="text" class="form-control" id="email" placeholder="Email">
											<div class="invalid-feedback">
												Email required.
											</div>
										</div>
										<div class="col-md-6 form-group">
											<label for="phoneNumber">Phone Number</label>
											<input type="text" class="form-control" id="phoneNumber" placeholder="Phone Number">
											<div class="invalid-feedback">
												Phone Number required.
											</div>
										</div>
									</div>
									<div class="form-check my-4">
										<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
										<label class="form-check-label" for="flexCheckDefault">
											Ship into different address
										</label>
									</div>

									<div class="paymentInfo">
										<h2 class="card-title mb-4">Payment Option</h2>
										<div class="row">
											<div class="col-md-12 form-group">
												<label for="card">Name on Card</label>
												<input type="text" class="form-control" id="card" placeholder="Name on Card">
												<div class="invalid-feedback">
													Name on Card required.
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 form-group">
												<label for="cardNo">Card Number</label>
												<input type="text" class="form-control" id="cardNo" placeholder="Card Number">
												<div class="invalid-feedback">
													Card Number required.
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 form-group">
												<label for="cardNo">Expire Date</label>
												<input type="text" class="form-control" id="cardNo" placeholder="">
												<div class="invalid-feedback">
													Expire Date required.
												</div>
											</div>
											<div class="col-md-6 form-group">
												<label for="cvc">CVC</label>
												<input type="text" class="form-control" id="cvc" placeholder="">
												<div class="invalid-feedback">
													CVC required.
												</div>
											</div>
										</div>
									</div>
									<h2 class="card-title mb-4">Additional Information</h2>
									<div class="row">
										<div class="col-md-12 form-group mb-3">
											<label for="notes">Order Notes <span>(Optional)</span></label>

											<textarea class="form-control" cols="5" rows="5" id="notes" placeholder="Notes about your order, e.g. special notes for delivery">

								</textarea>
										</div>
									</div>
								</div>
							</div>

							<!-- Continue Shopping Button -->

						</div>
						<div class="col-lg-4">
							<!-- Cart Summary -->
							<?php  if ( is_array(get_cart_contents()) && count(get_cart_contents()) > 0 ) { ?>
								<div class="card cart-summary">
									<div class="card-body">
									<?php  
									$grand_sub_total = [];
									$grand_shipp_total = [];
									foreach( get_cart_contents() as $cart ) {
										$total_attr_price = [];
										if ( is_array($cart['options']) && count($cart['options']) > 0 ) {
											foreach ( $cart['options'] as $option ) {
												$total_attr_price[] = $option['attr_price'];
											}
										}
										$single_item = (new \App\Models\ProductsDetailModel())->getById($cart['id']);
										if ( $single_item['deal_enable'] > 0 ) {
											$new_total_price = ( $single_item['deal_final_price'] + array_sum($total_attr_price) );
										} else {
											$new_total_price = ( $single_item['final_price'] + array_sum($total_attr_price) );
										}


										$item_add_ship = ( $new_total_price * $cart['qty'] );
										$handle_ship = $cart['item_handle'];
										if ( !empty($single_item['shipping_cost']) && strlen($single_item['shipping_cost']) > 0 ) {
											$handle_ship = $single_item['shipping_cost'];
										}

										if ( $item_add_ship >= $cart['item_transfer'] ) {
											$handle_ship = 0;
										}

										$sub_total_price = ( $item_add_ship ) + $handle_ship;
										$grand_sub_total[] = $item_add_ship;//( $new_total_price * $cart['qty'] );
										$grand_shipp_total[] = $handle_ship; ?>
										<div class="d-flex justify-content-between mb-3">
											<span class="sbHeading"><?php print ucfirst($cart['name']);?></span>
											<span class="sbPrice">$<?php print number_format($sub_total_price,2)?></span>
										</div>
									<?php } ?>
										<h5 class="card-title mb-4">Order Summary</h5>
										<div class="d-flex justify-content-between mb-3">
											<span class="sbHeading">Sub-total</span>
											<span class="sbPrice">$<?php print number_format(array_sum($grand_sub_total),2);?></span>
										</div>
										<div class="d-flex justify-content-between mb-3">
											<span class="sbHeading">Shipping</span>
											<span class="sbPrice"><?= is_array($grand_shipp_total) && count($grand_shipp_total) > 0 ? '$'.number_format(array_sum($grand_shipp_total),2) : 'Free Shipping' ?></span>
										</div>
										<!-- <div class="d-flex justify-content-between mb-3">
											<span class="sbHeading">Discount</span>
											<span class="sbPrice">$24</span>
										</div>
										<div class="d-flex justify-content-between mb-3">
											<span class="sbHeading">Tax</span>
											<span class="sbPrice">$61.99</span>
										</div> -->
										<hr>
										<div class="d-flex justify-content-between mb-1">
											<strong class="totalHeading">Total</strong>
											<strong class="totalCost">$<?php print number_format(array_sum($grand_sub_total) + array_sum($grand_shipp_total),2);?> USD</strong>

										</div>
										<p class="earnTag mb-5">Earn <img src="./assets/images/zIcon.svg" alt=""> 15 per $1 spent</p>
										<button class="btn btn-primary w-100">Place Order</button>
									</div>
								</div>
							<?php } ?>

						</div>
					</div>
				</form>
			</div>
		<?php } else { 
			print view('site/cart404');
		} ?>
	</div>
</section>
<?php print view('site/newLanding/footer'); ?>
<script>
	$('.useCoupon').click(function() {
		let btn = $(this);
		let coupon = btn.attr('data-coupon');
		let existingCoupons = $('#coupons__').val();
		if (existingCoupons) {
			const arr = existingCoupons.split(',');
			arr.push(coupon);
			$('#coupons__').val(arr.join());
		} else {
			$('#coupons__').val(coupon);
		}
		$.ajax({
			url: '<?= base_url('cart/useCoupon') ?>',
			type: 'POST',
			dataType: 'json',
			data: {
				<?= csrf_token() ?>: $('#_cc').val(),
				coupon: $('#coupons__').val()
			},
			beforeSend: function() {
				btn.attr('disabled', true);
			},
			success: function(resp) {
				$('#_cc').val(resp._cc);
				if (resp.success) {
					$('#yourOrderHtml').html(resp.html);
					notyf.success('Coupon used successfully!');
					btn.text('Used');
				} else {
					notyf.error(resp.message);
					btn.attr('disabled', false);
				}
			}
		})
	})
</script>