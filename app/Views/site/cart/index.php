<?= view('site/newLanding/header', ['globalSettings' => $globalSettings]); ?>
<section class="py-3">
	<div class="container">
		<div class="w-100 mb-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php print base_url(); ?>">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php print $pagetitle; ?></li>
				</ol>
			</nav>
		</div>
		<?php
		$checkgive = 0;
		if (is_array(get_cart_contents()) && count(get_cart_contents()) > 0) { ?>
			<div class="cartSection">
				<div class="row no-gutters mt-5">
					<div class="col-lg-8">
						<!-- Cart Items -->
						<div class="card leftCartContent mb-4">
							<div class="card-body">
								<h2 class="card-title mb-4">Shopping Cart</h2>
								<div class="tableResponsive">
									<table class="table">
										<thead class="table-dark">
											<tr>
												<th>Products</th>
												<th>Price</th>
												<th>Quantity</th>
												<th>Sub-Total</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$grand_sub_total = [];
											$grand_shipp_total = [];
											$zapptas = 0;
											foreach (get_cart_contents() as $cart) {
												if ($cart['givewaytags'] > 0) {
													$checkgive = $cart['givewaytags'];
												}
												$total_attr_price = [];
												if (is_array($cart['options']) && count($cart['options']) > 0) {
													foreach ($cart['options'] as $option) {
														$total_attr_price[] = $option['attr_price'];
													}
												}
												$single_item = (new \App\Models\ProductsDetailModel())->getById($cart['id']);
												$store = (new \App\Models\VendorModel())->findStoreById($single_item['store_id']);
												if ($single_item['deal_enable'] > 0) {
													$item_update_rice = $single_item['deal_final_price'] + array_sum($total_attr_price);
												} else {
													$item_update_rice = $single_item['final_price'] + array_sum($total_attr_price);
												}

												$item_add_ship = ($item_update_rice * $cart['qty']);
												$handle_ship = $cart['item_handle'];
												if (!empty($single_item['shipping_cost']) && strlen($single_item['shipping_cost']) > 0) {
													$handle_ship = $single_item['shipping_cost'];
												}

												if ($item_add_ship >= $cart['item_transfer']) {
													$handle_ship = 0;
												}

												$sub_total_price = ($item_add_ship) + $handle_ship;
												$grand_sub_total[] = $item_add_ship; //( $item_update_rice * $cart['qty'] );	
												$grand_shipp_total[] = $handle_ship;
												?>
												<tr class="cart_row_<?php print $cart['rowid']; ?>">
													<td>
														<div class="cartProductCell d-flex gap-3 align-items-center">
															<div class="closeCircle removeButton" data-row-id="<?php print $cart['rowid']; ?>" onclick="deleteItem('<?php print $cart['rowid']; ?>');"><a href="#">Close</a></div>
															<div class="cartThumbnail"><img src="<?php print $cart['item_image']; ?>" alt="" /></div>
															<div class="cartThumbHeading">
																<h4><?php print ucfirst($cart['name']); ?></h4>
																<?php
																if (!empty($cart['options']) && is_array($cart['options']) && count($cart['options']) > 0) {
																	if ($cart['options'][0]['attribute_id'] > 0) {
																?>
																		<p class="d-flex cart-attr">
																			<?php
																			foreach ($cart['options'] as $option) {
																			?>
																				<span><?php print $option['value_name']; ?></span>
																			<?php
																			}
																			?>
																		</p>
																<?php
																	}
																}
																?>
																<?php if ($single_item['devliery_time'] == 2) { ?>
																	<?php if ($single_item['quantity'] > 0) { ?>
																		<small class="dilvery_note"><?php print $single_item['devliery_days']; ?></small>
																	<?php } else { ?>
																		<small class="dilvery_note"><?php print $single_item['devliery_days_after']; ?></small>
																	<?php } ?>
																<?php } ?>
															</div>
														</div>
													</td>
													<td>
														<div class="cartThumbnailPrice d-flex flex-column">
															<div class="d-flex gap-2">
																<!-- <p class="cutPrice"><del>$99</del></p> -->
																<p class="cartprice" data-price="<?php print $item_update_rice; ?>">$<?php print number_format($item_update_rice, 2) ?></p>
															</div>
															<?php if (isset($store['earn_zappta']) && $store['earn_zappta']) { ?>
																<p class="earnTag">Earn <img src="<?=$assets_url?>/images/zIcon.svg" alt=""> <?= number_format($store['earn_zappta'] * $store['per_dollar'] * $sub_total_price, 2) ?></p>
															<?php $zapptas += $store['earn_zappta'] * $store['per_dollar'] * $sub_total_price;
															} ?>
														</div>
													</td>
													<td>
														<div class="input-group quantityBtns">
															<div class="input-group-prepend">
																<button class="btn btn-sm" id="decreament_<?php print $cart['rowid']; ?>" onclick="cart_table_decreament('<?php print $cart['rowid']; ?>');"><i class="fa fa-minus"></i></button>
															</div>
															<input type="number" class="form-control form-control-sm inputvalue" value="<?php print $cart['qty']; ?>" min="1" id="inputvalue_<?php print $cart['rowid']; ?>" readonly>
															<div class="input-group-prepend">
																<button class="btn btn-sm" id="increament_<?php print $cart['rowid']; ?>" onclick="cart_table_increament('<?php print $cart['rowid']; ?>');"><i class="fa fa-plus"></i></button>
															</div>
														</div>
													</td>
													<td>
														<h6 class="carttotal">$<?php print number_format($sub_total_price, 2) ?></h6>
													</td>
												</tr>
											<?php 
											} ?>
										</tbody>
									</table>
								</div>
								<div class="cartShoppingBtns">
									<a href="<?= base_url() ?>" class="btn btn-outline-primary">
										Continue Shopping
									</a>
								</div>
							</div>
						</div>
						<!-- Continue Shopping Button -->

					</div>
					<div class="col-lg-4">
						<!-- Cart Summary -->
						<div class="card cart-summary">
							<div class="card-body">
								<h5 class="card-title mb-4">Cart Totals</h5>
								<div class="d-flex justify-content-between mb-3">
									<span class="sbHeading">Sub-total</span>
									<span class="sbPrice">$<?php print number_format(array_sum($grand_sub_total), 2); ?></span>
								</div>
								<div class="d-flex justify-content-between mb-3">
									<span class="sbHeading">Shipping</span>
									<span class="sbPrice" id="shippingTotal"><?= is_array($grand_shipp_total) && count($grand_shipp_total) > 0 ? '$'.number_format(array_sum($grand_shipp_total), 2) : 'Free' ?></span>
								</div>
								<hr>
								<div class="d-flex justify-content-between mb-1">
									<strong class="totalHeading">Total</strong>
									<strong class="totalCost">$<?php print number_format(array_sum($grand_sub_total) + array_sum($grand_shipp_total), 2); ?> USD</strong>

								</div>
								<?php if ($zapptas > 0) { ?>
									<p class="earnTag mb-5">Earn <img src="<?=$assets_url?>/images/zIcon.svg" alt=""> <?= number_format($zapptas, 2) ?> Overall</p>
								<?php } ?>
								<?php
								if ($checkgive == 1) {
								?>
									<button class="btn btn-primary w-100" type="button" onclick="checkPlayAndWin()">Play & Win</button>
									<button class="btn btn-primary w-100" type="button" onclick="window.location.href='<?php print base_url() . '/cart/checkout'; ?>'">Proceed to Checkout</button>
								<?php } else { ?>
									<button  type="button" onclick="window.location.href='<?php print base_url() . '/cart/checkout'; ?>'" class="btn btn-primary w-100">Proceed to Checkout</button>
								<?php } ?>
							</div>
						</div>
						<!-- Promo Code -->
						<!-- <div class="card couponCard mt-4">
							<div class="card-body">
								<h5 class="card-title">Coupon Code</h5>
								<div class="input-group mb-3">
									<input type="text" class="form-control" placeholder="Enter code">
								</div>
								<button class="btn btnCoupon" type="button">Apply Coupon</button>
							</div>
						</div> -->
					</div>
				</div>
			</div>
		<?php }else{
			print view('site/cart404');
		} ?>
	</div>
</section>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>