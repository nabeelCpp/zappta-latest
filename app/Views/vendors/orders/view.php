<?php print view('vendors/header');?>
	
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

	<section class="vendor-dashbaord">
		<div class="container">
			<div class="wrapper d-flex align-items-stretch">
		
				<?php print view('vendors/sidebar');?>

				<div id="content" class="float-start">
					<div class="container-fluid">
				<?php print view('vendors/compaign');?>
					<div class="order_invoice">
						<header>
							<div class="clearfix"></div>
							<table class="meta" align="right">
								<tr>
									<th><span contenteditable>Invoice #</span></th>
									<td><span contenteditable><?php print $order['order']['order_serial'];?></span></td>
								</tr>
								<tr>
									<th><span contenteditable>Date</span></th>
									<td><span contenteditable><?php print date( 'F d, Y', strtotime($order['order']['order_date']));?></span></td>
								</tr>
							</table>

						</header>

						<address contenteditable class="adres">
							<div class="shipping">
								<h4>Shipping Info</h4>
								<table class="meta">
									<tr>
										<th><span contenteditable>Name</span></th>
										<td><span contenteditable><?php print $address[1]['first_name'] . ' ' . $address[1]['last_name'];?></span></td>
									</tr>
									<tr>
										<th><span contenteditable>Address</span></th>
										<td>
											<span contenteditable>
												<?php print $address[1]['stree_address'] . ', ' . $address[1]['stree_address_optional'];?> <?php print $address[1]['town_city'];?>, <?php print $address[1]['postcode'];?><br/><?php print $address[1]['country_name'];?>
											</span>
										</td>
									</tr>
									<tr>
										<th><span contenteditable>Email</span></th>
										<td><span contenteditable><?php print $address[1]['email'];?></span></td>
									</tr>
									<tr>
										<th><span contenteditable>Phone</span></th>
										<td><span contenteditable><?php print $address[1]['phone'];?></span></td>
									</tr>
								</table>
							</div>
						</address>


						<table class="inventory">
							<thead>
								<tr>
									<th><span contenteditable>Product</span></th>
									<th><span contenteditable>Price</span></th>
									<th><span contenteditable>Quantity</span></th>
									<th><span contenteditable>Shipping</span></th>
									<th><span contenteditable>Total</span></th>
									<th><span contenteditable>Status</span></th>
								</tr>
							</thead>
							<tbody>
							<?php 
								$total_sub_total = [];
								if ( is_array($order['items']) && count($order['items']) > 0 ) {
									foreach( $order['items'] as $it ) {
										$total_sub_total[] = $it['subtotal'];
							?>
								<tr>
									<td><span contenteditable><?php print ucfirst($it['item_name']);?></span></td>
									<td><span data-prefix>$</span><span contenteditable><?php print number_format($it['price'],2);?></span></td>
									<td><span contenteditable><?php print $it['qty'];?></span></td>
									<td><span data-prefix>$</span><span contenteditable><?php print number_format($it['shipping'],2);?></span></td>
									<td><span data-prefix>$</span><span contenteditable><?php print number_format($it['subtotal'],2);?></span></td>
									<td>
									<?php 
										switch($it['time_item_status'])
										{
											case 1:
									?>
										<select class="form-control" id="status_<?php print my_encrypt($it['item_id']);?>" name="shipstatus" onchange="updateOrderStatus('<?php print my_encrypt($it['item_id']);?>','<?php print my_encrypt($order_id);?>');">
											<option value="Pending" selected>Pending</option>
											<option value="Shipped">Shipped</option>
											<option value="Delivered">Delivered</option>
											<option value="Returned">Returned</option>
											<option value="Canceled">Canceled</option>
										</select>
									<?php
												break;
											case 3:
									?>
										<select class="form-control" id="status_<?php print my_encrypt($it['item_id']);?>" name="shipstatus" onchange="updateOrderStatus('<?php print my_encrypt($it['item_id']);?>','<?php print my_encrypt($order_id);?>');">
											<option value="Pending" disabled>Pending</option>
											<option value="Shipped" selected>Shipped</option>
											<option value="Delivered">Delivered</option>
											<option value="Returned">Returned</option>
											<option value="Canceled">Canceled</option>
										</select>
									<?php
												break;
											case 4:
									?>
										<select class="form-control" id="status_<?php print my_encrypt($it['item_id']);?>" name="shipstatus" onchange="updateOrderStatus('<?php print my_encrypt($it['item_id']);?>','<?php print my_encrypt($order_id);?>');">
											<option value="Pending" disabled>Pending</option>
											<option value="Shipped" disabled>Shipped</option>
											<option value="Delivered" selected>Delivered</option>
											<option value="Returned">Returned</option>
											<option value="Canceled">Canceled</option>
										</select>
									<?php
												break;
											case 5:
									?>
										<select class="form-control" id="status_<?php print my_encrypt($it['item_id']);?>" name="shipstatus" onchange="updateOrderStatus('<?php print my_encrypt($it['item_id']);?>','<?php print my_encrypt($order_id);?>');">
											<option value="Pending" disabled>Pending</option>
											<option value="Shipped" disabled>Shipped</option>
											<option value="Delivered" disabled>Delivered</option>
											<option value="Returned" selected>Returned</option>
											<option value="Canceled">Canceled</option>
										</select>
									<?php
												break;
											case 6:
									?>
										<select class="form-control" id="status_<?php print my_encrypt($it['item_id']);?>" name="shipstatus" onchange="updateOrderStatus('<?php print my_encrypt($it['item_id']);?>','<?php print my_encrypt($order_id);?>');">
											<option value="Pending" disabled>Pending</option>
											<option value="Shipped" disabled>Shipped</option>
											<option value="Delivered" disabled>Delivered</option>
											<option value="Returned" disabled>Returned</option>
											<option value="Canceled" selected>Canceled</option>
										</select>
									<?php
												break;
										}
									?>
									</td>
								</tr>
							<?php
									}
								}
							?>
							</tbody>
						</table>


						<table class="balance" align="right">
							<tr>
								<th><span contenteditable>Subtotal</span></th>
								<td><span data-prefix>$</span><span><?php print number_format(array_sum($total_sub_total),2);?></span></td>
							</tr>
							<tr>
								<th><span contenteditable>Shipping</span></th>
								<td><span data-prefix>$</span><span contenteditable><?php print number_format($order['order']['shipping'],2);?></span></td>
							</tr>
							<tr>
								<th><span contenteditable>Discount</span></th>
								<td><span data-prefix>$</span><span contenteditable><?php print number_format($order['order']['discount'],2);?></span></td>
							</tr>
							<tr>
								<th><span contenteditable>Balance Due</span></th>
								<td><span data-prefix>$</span><span><?php print number_format($order['order']['total_amount'],2);?></span></td>
							</tr>
						</table>

						<div class="clearfix"></div>
					</div>

						

					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>

<?php print view('vendors/footer');?>