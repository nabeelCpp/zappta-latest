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
							<li><?php print $pagetitle;?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php 
	if ( is_array(get_cart_contents()) && count(get_cart_contents()) > 0 ) {
?>
	<section class="cart mt-4 mb-4">
		<div class="container">
			<form method="post" action="<?php print base_url().'/cart/address';?>" id="checkoutform">
				<input type="hidden" name="<?php print csrf_token() ?>" id="_cc" value="<?php print csrf_hash() ?>">
				<div class="row flex-column flex-lg-row">
					<div class="col-xl-8 col-lg-7 col-12">
						<div class="form-checkout">
							<div class="billing_fields">
								<h3>Billing detail</h3>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-6 col-lg-6 col-md-6 col-12">
											<label>First name<span>*</span></label>
											<input type="text" name="address[billing][first_name]" class="form-control required" data-msg-required="Please enter your First name"/>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-12">
											<label>Last name<span>*</span></label>
											<input type="text" name="address[billing][last_name]"  class="form-control required" data-msg-required="Please enter your Last name"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Company name (Optional)</label>
											<input type="text" name="address[billing][company_name]"  class="form-control"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Country / Region<span>*</span></label>
											<select name="address[billing][country]" class="form-control required" data-msg-required="Please select Country / Region">
												<option value="">Select</option>
										<?php 
		                                    if ( is_array($country) && count($country) > 0 ) {
		                                        foreach( $country as $cn ) {
		                                ?>
		                                	<option value="<?php print my_encrypt($cn['id']);?>"><?php print $cn['name'];?></option>
		                                <?php 
		                                        }
		                                    }
		                                ?>
		                            		</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Town / City<span>*</span></label>
											<input type="text" name="address[billing][town_city]" class="form-control required" data-msg-required="Please enter Town / City"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Street address<span>*</span></label>
											<input type="text" name="address[billing][stree_address]" placeholder="House number and street name"  class="form-control required" data-msg-required="Please enter Street address"/>
											<input type="text" name="address[billing][stree_address_optional]" placeholder="Apartment, suite, unit, etc. (optional)"  class="form-control"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Postcode<span>*</span></label>
											<input type="text" name="address[billing][postcode]" class="form-control required" data-msg-required="Please enter Postcode" minlength="5" maxlength="7" />
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Phone<span>*</span></label>
											<input type="text" name="address[billing][phone]"  class="form-control required" data-msg-required="Please enter Phone"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Email Address<span>*</span></label>
											<input type="text" name="address[billing][email]" class="form-control required" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<div class="agree shipping d-flex mt-4 mb-4 align-items-center">
												<div class="round">
												    <input type="checkbox" id="same_shipping"  name="address[billing][same_shipping]" value="2"/>
												    <label for="same_shipping"></label>
												</div>
												<div class="term d-flex"> <span>Ship to a different address?</span></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Order notes (optional)</label>
											<textarea class="form-control" name="address[billing][order_notes]"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="shipping_fields mb-4" id="shipping_fields">
								<h3>Shipping detail</h3>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-6 col-lg-6 col-md-6 col-12">
											<label>First name<span>*</span></label>
											<input type="text" name="address[shipping][first_name]" class="form-control required" data-msg-required="Please enter your First name"/>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-12">
											<label>Last name<span>*</span></label>
											<input type="text" name="address[shipping][last_name]" class="form-control required" data-msg-required="Please enter your Last name"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Company name (Optional)</label>
											<input type="text" name="address[shipping][company_name]"  class="form-control"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Country / Region<span>*</span></label>
											<select name="address[shipping][country]" class="form-control required" data-msg-required="Please select Country / Region">
												<option value="">Select</option>
										<?php 
		                                    if ( is_array($country) && count($country) > 0 ) {
		                                        foreach( $country as $cn ) {
		                                ?>
		                                	<option value="<?php print my_encrypt($cn['id']);?>"><?php print $cn['name'];?></option>
		                                <?php 
		                                        }
		                                    }
		                                ?>
		                            		</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Town / City<span>*</span></label>
											<input type="text" name="address[shipping][town_city]" class="form-control required" data-msg-required="Please enter Town / City"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Street address<span>*</span></label>
											<input type="text" name="address[shipping][stree_address]" placeholder="House number and street name" class="form-control required" data-msg-required="Please enter Street address"/>
											<input type="text" name="address[shipping][stree_address_optional]" placeholder="Apartment, suite, unit, etc. (optional)"  class="form-control"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Postcode<span>*</span></label>
											<input type="text" name="address[shipping][postcode]" class="form-control required" data-msg-required="Please enter Postcode" minlength="5" maxlength="7"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Phone<span>*</span></label>
											<input type="text" name="address[shipping][phone]" class="form-control required" data-msg-required="Please enter Phone"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-12">
											<label>Email Address<span>*</span></label>
											<input type="text" name="address[shipping][email]" class="form-control required" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address"/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-5 col-12">
	<?php  if ( is_array(get_cart_contents()) && count(get_cart_contents()) > 0 ) { ?>
						<div class="order_detail_checkout">
							<div id="yourOrderHtml">
								<h3>Your order</h3>
								<div class="order_list_checkout checkout-border d-flex">
									<div class="left title">Product</div>
									<div class="right title">Sub-total</div>
								</div>
								<div class="order_list_checkout checkout-border mt-3">
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
										$grand_shipp_total[] = $handle_ship;
								?>
									<div class="items d-flex">
										<div class="left"><?php print ucfirst($cart['name']);?></div>
										<div class="right">$<?php print number_format($sub_total_price,2)?></div>
									</div>
								<?php } ?>
								</div>
								<div class="order_list_checkout mt-3 d-flex">
									<div class="left">Sub-total</div>
									<div class="right">$<?php print number_format(array_sum($grand_sub_total),2);?></div>
								</div>
								<div class="order_list_checkout checkout-border d-flex">
									<div class="left">Shipping</div>
									<?php if ( is_array($grand_shipp_total) && count($grand_shipp_total) > 0 ) { ?>
									<div class="right">$<?php print number_format(array_sum($grand_shipp_total),2);?></div>
									<?php } else { ?>
									<div class="right">Free Shipping</div>
									<?php } ?>
								</div>
								<div class="order_list_checkout mt-3 d-flex">
									<div class="left"><b>Total</b></div>
									<div class="right">
										<span id="shippingTotal"><b>$<?php print number_format(array_sum($grand_sub_total) + array_sum($grand_shipp_total),2);?></b></span>
										<div class="price-zaptta d-flex">
											<span>Earn</span>
											<span>
												<svg xmlns="http://www.w3.org/2000/svg" width="9" height="20" viewBox="0 0 9 20">
												<g id="Group_667" data-name="Group 667" transform="translate(-1129 -531)">
													<text id="Z" transform="translate(1129 547)" fill="#1f961b" font-size="15" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>
													<g id="Rectangle_4131" data-name="Rectangle 4131" transform="translate(1133 546.5)" fill="none" stroke="#1f961b" stroke-width="1">
													<rect width="1.2" height="2" stroke="none"/>
													<rect x="0.5" y="0.5" width="0.2" height="1" fill="none"/>
													</g>
													<g id="Rectangle_4132" data-name="Rectangle 4132" transform="translate(1133 535)" fill="none" stroke="#1f961b" stroke-width="1">
													<rect width="1.2" height="2" stroke="none"/>
													<rect x="0.5" y="0.5" width="0.2" height="1" fill="none"/>
													</g>
												</g>
												</svg>
											</span>
											<span>per $1 spent</span>
										</div>
									</div>
								</div>
							</div>
							<?php if(count($coupons) > 0){ ?>
								<div class="card">
									<div class="card-header">
										<h6>Available Coupons</h6>
									</div>
									<div class="card-body">
										<input type="hidden" class="form-control" name="coupons" id="coupons__">
										<ul class="list-group">
											<?php foreach ($coupons as $key => $coupon) { ?>
												<li class="list-group-item list-group-item-warning"><small>Coupon of worth $<?=$coupon['coupon_price']?></small> <button type="button" data-coupon="<?=$coupon['coupon_code']?>" class="btn btn-sm btn-success px-3 pull-right useCoupon">Use</button><b><?=$coupon['vendor']?></b></li>
											<?php } ?>
										</ul>
									</div>
								</div>
							<?php } ?>
							<div class="payment_gateways d-block">
								<h4>Direct bank transfer</h4>
								<p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleaned in our account.</p>
								<ul class="d-block">
									<?php if(!isset($_GET['coupon_code'])) { ?>
										<li data-gateway="creditcard" class="gtw">
											<div class="gateway d-flex align-items-center creditcard">
												<div class="circle active-circle"></div>
												<div class="name">Credit/Debit card</div>
												<div class="logo"></div>
											</div>
										</li>
										<li data-gateway="cod" class="gtw">
											<div class="gateway d-flex align-items-center cod">
												<div class="circle"></div>
												<div class="name">Cash on Delivery</div>
												<div class="logo"></div>
											</div>
										</li>
									<?php } ?>
									<?php if(isset($_GET['coupon_code']) ) { ?>
										<li data-gateway="coupon_code" class="gtw">
											<div class="gateway d-flex align-items-center coupon_code">
												<div class="circle active-circle"></div>
												<div class="name">Coupon Code : <?=$_GET['coupon_code']?></div>
												<div class="logo p-3"><i class="fa fa-coins"></i></div>
											</div>
										</li>
										<input type="hidden" name="coupon_code" value="<?=$_GET['coupon_code']?>">	
									<?php } ?>
								</ul>
							</div>
							<div class="agree d-flex mt-4 mb-4">
								<div class="rounds">
								    <input type="checkbox"  name="agree" value="1" required  data-msg-required="Please Accept Term and Condition"/>
								    <!-- <label></label> -->
								</div>
								<div class="term d-flex"> <span>I agree to the website</span> <a href="" target="_blank"><b>Term and Condition</b></a></div>
							</div>
							<input type="hidden" id="gateway" name="gateway" value="<?=isset($_GET['coupon_code'])?"coupon_code":"creditcard"?>" />
							<div class="processbtn">
							<?php if ( getUserId() > 0 ) { ?>
								<button type="submit" class="btn btn-play">Place order</button>
							<?php } else { ?>
								<button type="button" data-bs-toggle="modal" data-bs-target="#accountModal" class="btn btn-play">Place order</button>
							<?php } ?>
							</div>
						</div>
	<?php } ?>
					</div>	
				</div>
			</form>
		</div>
	</section>


<?php  } else { ?>
	<?php print view('site/cart404');?>
<?php } ?>
<?php print view('site/footer');?>
<script>
	$('.useCoupon').click(function(){
		let btn = $(this);
		let coupon = btn.attr('data-coupon');
		let existingCoupons = $('#coupons__').val();
		if(existingCoupons){
			const arr = existingCoupons.split(',');
			arr.push(coupon);
			$('#coupons__').val(arr.join());
		}else{
			$('#coupons__').val(coupon);
		}
		$.ajax({
			url : '<?=base_url('cart/useCoupon')?>',
			type: 'POST',
			dataType: 'json',
			data: {
				<?=csrf_token()?>: $('#_cc').val(),
				coupon: $('#coupons__').val()
			},
			beforeSend: function(){
				btn.attr('disabled', true);
			},
			success: function(resp){
				$('#_cc').val(resp._cc);
				if(resp.success) {
					$('#yourOrderHtml').html(resp.html);
					notyf.success('Coupon used successfully!');
					btn.text('Used');
				}else{
					notyf.error(resp.message);
					btn.attr('disabled', false);
				}
			}
		})
	})
</script>