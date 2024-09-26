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
								<a href="<?php print base_url().'/stores';?>">Stores</a>
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
	<section class="cart">
		<div class="container">
		<form method="post" action="<?php print base_url().'/cart/checkout';?>">
			<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>">
			<div class="row">
				<div class="col-xl-9 col-lg-9 col-md-9 col-12">
					<div style="overflow-y:auto;" class="cart-table align-items-center justify-content-center">
				<?php 
					// print '<pre>';
					// print_r(get_cart_contents());
					// print '</pre>';
				?>
						<table style="min-width:831px;" class="table justify-content-center align-items-center">
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
						foreach( get_cart_contents() as $cart ) {
							$single_item = (new \App\Models\ProductsDetailModel())->getById($cart['id']);
							$sub_total_price = ( $single_item['retail_price_tax'] * $cart['qty'] ) + $single_item['shipping_cost'];
							$grand_sub_total[] = ( $single_item['retail_price_tax'] * $cart['qty'] );	
							$grand_shipp_total[] = $single_item['shipping_cost'];
					?>
								<tr class="cart_row_<?php print $cart['rowid'];?>">
									<td>
										<!-- <img src="<?php print $cart['item_image'];?>" alt="" class="img-thumbnails animate"/> -->
									</td>
									<td>
										<!-- <small>Nike</small> -->
										<p><?php print ucfirst($cart['name']);?></p>
									<?php if ( $single_item['devliery_time'] == 2 ) { ?>
										<?php if ( $single_item['quantity'] > 0 ) { ?>
										<small class="dilvery_note"><?php print $single_item['devliery_days'];?></small>
										<?php } else { ?>
										<small class="dilvery_note"><?php print $single_item['devliery_days_after'];?></small>
										<?php } ?>
									<?php } ?>
									</td>
									<td><p class="cartprice" data-price="<?php print $single_item['retail_price_tax'];?>">$<?php print number_format($single_item['retail_price_tax'],2)?></p></td>
									<td>
										<div class="quantity d-flex mt-3 mb-3">
											<div class="qbox d-flex">
												<div class="decreament" id="decreament_<?php print $cart['rowid'];?>" onclick="cart_table_decreament('<?php print $cart['rowid'];?>');">-</div>
												<div class="inputvalue" id="inputvalue_<?php print $cart['rowid'];?>"><?php print $cart['qty'];?></div>
												<div class="increament" id="increament_<?php print $cart['rowid'];?>" onclick="cart_table_increament('<?php print $cart['rowid'];?>');">+</div>
											</div>
										</div>
									</td>
									<td>
										<p class="shiptotal">$<?php print number_format($single_item['shipping_cost'],2);?></p>
									</td>
									<td>
										<p class="carttotal">$<?php print number_format($sub_total_price,2)?></p>
										<div class="price-zaptta d-flex align-item-center">
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
											<span>840 as bonus</span>
										</div>
									</td>
									<td>
										<div class="removeButton" data-row-id="<?php print $cart['rowid'];?>">
											<i class="fa-solid fa-xmark"></i>
										</div>
									</td>
								</tr>
					<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<div class="carttotal">
						<div class="totalsamount">
							<h3 class="pb-3 pt-2">Cart Totals</h3>
							<div class="totalrow d-flex pt-3 pb-3">
								<div class="left">Cart Subtotal</div>
								<div class="left" id="grandsubtotal">$<?php print number_format(array_sum($grand_sub_total),2);?></div>
							</div>
							<div class="totalrow d-flex pt-3 pb-3">
								<div class="left">Shipping</div>
								<?php if ( is_array($grand_shipp_total) && count($grand_shipp_total) > 0 ) { ?>
								<div class="left" id="shippingTotal">$<?php print number_format(array_sum($grand_shipp_total),2);?></div>
								<?php } else { ?>
								<div class="left" id="shippingTotal">Free Shipping</div>
								<?php } ?>
							</div>
							<div class="totalrow d-flex pt-3 pb-3">
								<div class="left">Total</div>
								<div class="left">
									<span id="shippingTotal">$<?php print number_format(array_sum($grand_sub_total) + array_sum($grand_shipp_total),2);?></span>
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
							<div class="processbtn">
								<button type="submit" class="btn btn-play">Proceed To Checkout</button>
							</div>
						</div>
					</div>
				</div>	
			</div>
	</form>
		</div>
	</section>

	<section class="storecats category-single cat-pro-list cst-s-50">
		<div class="container">
			<div class="cat-pro-head cst-m-50">
				<h2 class="text-center">Related Products</h2>
			</div>
			<div class="row mt-4 mb-4 related-slider">
				<?php print view('site/stores/prolist',['count' => 6]);?>
			</div>
		</div>
	</section>

<?php 
	}
?>
<?php print view('site/footer');?>