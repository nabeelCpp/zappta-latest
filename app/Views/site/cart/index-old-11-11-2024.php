<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>

<section class="bread">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-12">
				<div class="bb">
					<ul class="p-0 m-0 d-flex align-items-center">
						<li>
							<a href="<?php print base_url(); ?>">Home</a>
						</li>
						<li>/</li>
						<li><?php print $pagetitle; ?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
$checkgive = 0;
if (is_array(get_cart_contents()) && count(get_cart_contents()) > 0) { ?>
	<section class="cart mg-70">
		<div class="container">
			<!-- <form method="post" action="<?php print base_url() . '/cart/checkout'; ?>"> -->
			<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>">
			<div class="row flex-column flex-lg-row">
				<div class="col-xl-9 col-lg-8  col-12">
					<div style="overflow-y:auto;" class="cart-table align-items-center justify-content-center">
						<?php
						// print '<pre>';
						// print_r(get_cart_contents());
						// print '</pre>';
						?>
						<table style="min-width:830px;" class="table justify-content-center align-items-center">
							<thead>
								<tr>
									<th></th>
									<th>Product</th>
									<th>Price</th>
									<th>Quantity</th>
									<th>Shipping</th>
									<th>Total</th>
									<th>Remove</th>
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
										<!-- <td>
										<?php if ($cart['givewaytags'] == 1) { ?>
												<div class="giveselect ms-4">
													<input type="radio" class="givewayplay" name="givewayplay" value="<?php print my_encrypt($cart['id']); ?>">
												</div>
										<?php } else { ?>
												<input type="hidden" name="givewayplay" class="givewayplay" value="0">
										<?php } ?>
									</td> -->
										<td>
											<img src="<?php print $cart['item_image']; ?>" alt="" class="img-thumbnails animate" />
										</td>
										<td class="cart_item_pname">
											<!-- <small>Nike</small> -->
											<p><?php print ucfirst($cart['name']); ?></p>
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
										</td>
										<td>
											<p class="cartprice" data-price="<?php print $item_update_rice; ?>">$<?php print number_format($item_update_rice, 2) ?></p>
										</td>
										<td>
											<div class="quantity d-flex mt-3 mb-3">
												<div class="qbox d-flex">
													<div class="decreament" id="decreament_<?php print $cart['rowid']; ?>" onclick="cart_table_decreament('<?php print $cart['rowid']; ?>');">-</div>
													<div class="inputvalue" id="inputvalue_<?php print $cart['rowid']; ?>"><?php print $cart['qty']; ?></div>
													<div class="increament" id="increament_<?php print $cart['rowid']; ?>" onclick="cart_table_increament('<?php print $cart['rowid']; ?>');">+</div>
												</div>
											</div>
										</td>
										<td>
											<p class="shiptotal">$<?php print number_format($handle_ship, 2); ?></p>
										</td>
										<td>
											<p class="carttotal">$<?php print number_format($sub_total_price, 2) ?></p>
											<?php if (isset($store['earn_zappta']) && $store['earn_zappta']) { ?>
												<div class="price-zaptta d-flex align-item-center">
													<span>Earn</span>
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="9" height="20" viewBox="0 0 9 20">
															<g id="Group_667" data-name="Group 667" transform="translate(-1129 -531)">
																<text id="Z" transform="translate(1129 547)" fill="#1f961b" font-size="15" font-family="OpenSans, Open Sans">
																	<tspan x="0" y="0">Z</tspan>
																</text>
																<g id="Rectangle_4131" data-name="Rectangle 4131" transform="translate(1133 546.5)" fill="none" stroke="#1f961b" stroke-width="1">
																	<rect width="1.2" height="2" stroke="none" />
																	<rect x="0.5" y="0.5" width="0.2" height="1" fill="none" />
																</g>
																<g id="Rectangle_4132" data-name="Rectangle 4132" transform="translate(1133 535)" fill="none" stroke="#1f961b" stroke-width="1">
																	<rect width="1.2" height="2" stroke="none" />
																	<rect x="0.5" y="0.5" width="0.2" height="1" fill="none" />
																</g>
															</g>
														</svg>
													</span>
													<span><?= number_format($store['earn_zappta'] * $store['per_dollar'] * $sub_total_price, 2) ?> as bonus</span>
												</div>
											<?php $zapptas += $store['earn_zappta'] * $store['per_dollar'] * $sub_total_price;
											} ?>
										</td>
										<td>
											<div class="d-flex">
												<div class="removeButton" data-row-id="<?php print $cart['rowid']; ?>" onclick="deleteItem('<?php print $cart['rowid']; ?>');">
													<i class="fa-solid fa-xmark"></i>
												</div>
											</div>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-xl-3 col-lg-4  col-12">
					<div class="carttotal">
						<div class="totalsamount">
							<h3 class="pb-3 pt-2">Cart Totals</h3>
							<div class="totalrow d-flex pt-3 pb-3">
								<div class="left">Cart Subtotal</div>
								<div class="left" id="grandsubtotal">$<?php print number_format(array_sum($grand_sub_total), 2); ?></div>
							</div>
							<div class="totalrow d-flex pt-3 pb-3">
								<div class="left">Shipping</div>
								<?php if (is_array($grand_shipp_total) && count($grand_shipp_total) > 0) { ?>
									<div class="left" id="shippingTotal">$<?php print number_format(array_sum($grand_shipp_total), 2); ?></div>
								<?php } else { ?>
									<div class="left" id="shippingTotal">Free Shipping</div>
								<?php } ?>
							</div>
							<div class="totalrow d-flex pt-3 pb-3">
								<div class="left">Total</div>
								<div class="left">
									<span id="shippingTotal">$<?php print number_format(array_sum($grand_sub_total) + array_sum($grand_shipp_total), 2); ?></span>
									<?php if ($zapptas > 0) { ?>
										<div class="price-zaptta d-flex">
											<span>Earn</span>
											<span>
												<svg xmlns="http://www.w3.org/2000/svg" width="9" height="20" viewBox="0 0 9 20">
													<g id="Group_667" data-name="Group 667" transform="translate(-1129 -531)">
														<text id="Z" transform="translate(1129 547)" fill="#1f961b" font-size="15" font-family="OpenSans, Open Sans">
															<tspan x="0" y="0">Z</tspan>
														</text>
														<g id="Rectangle_4131" data-name="Rectangle 4131" transform="translate(1133 546.5)" fill="none" stroke="#1f961b" stroke-width="1">
															<rect width="1.2" height="2" stroke="none" />
															<rect x="0.5" y="0.5" width="0.2" height="1" fill="none" />
														</g>
														<g id="Rectangle_4132" data-name="Rectangle 4132" transform="translate(1133 535)" fill="none" stroke="#1f961b" stroke-width="1">
															<rect width="1.2" height="2" stroke="none" />
															<rect x="0.5" y="0.5" width="0.2" height="1" fill="none" />
														</g>
													</g>
												</svg>
											</span>
											<span><?= number_format($zapptas, 2) ?> Overall</span>
										</div>
									<?php } ?>
								</div>
							</div>
							<div class="processbtn">
								<?php
								if ($checkgive == 1) {
								?>
									<div class="d-flex justify-content-center mt-2">
										<button type="button" onclick="checkPlayAndWin()" class="btn btn-play btn-smplay">Play & Win</button>
										<button type="button" onclick="window.location.href='<?php print base_url() . '/cart/checkout'; ?>'" class="btn btn-play btn-smplay">Buy Now</button>
									</div>
								<?php } else { ?>
									<button type="button" onclick="window.location.href='<?php print base_url() . '/cart/checkout'; ?>'" class="btn btn-play">Buy Now</button>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- </form> -->
		</div>
	</section>



<?php  } else { ?>
	<?php print view('site/cart404'); ?>
<?php } ?>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>