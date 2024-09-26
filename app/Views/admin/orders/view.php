<?php print view('admin/header');?>
  			<div class="row">
              <div class="col-lg-12">
                  <div class="card px-2">
                      <div class="card-body">
                          <div class="container-fluid">
                            <h3 class="text-right my-5">Order&nbsp;&nbsp;#<?php print $orders['order']['order_serial'];?></h3>
                            <hr>
                          </div>
                          <div class="container-fluid d-flex justify-content-between">
                            <div class="col-lg-3 ps-0">
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
                            <div class="col-lg-3 pr-0">
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
                          <div class="container-fluid d-flex justify-content-between">
                            <div class="col-lg-3 ps-0">
                              <p class="mb-0 mt-5">Invoice Date : <?php print $orders['order']['order_date'];?></p>
                            </div>
                          </div>
                          <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                            <div class="table-responsive w-100">
                                <table class="table">
                                  <thead>
                                    <tr class="bg-dark text-white">
                                        <th>#</th>
                                        <th></th>
                                        <th>Description</th>
                                        <th>Store Name</th>
                                        <th class="text-right">Quantity</th>
                                        <th class="text-right">Unit cost</th>
                                        <th class="text-right">Shipping</th>
                                        <th class="text-right">Total</th>
                                        <th class="text-right">Status</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                <?php 
                                	if ( is_array($orders['items']) && count($orders['items']) > 0 ) {
                                		$sr=1;
                                		foreach( $orders['items'] as $items ) {
                                ?>
                                	<tr class="text-right">
                                      <td class="text-left"><?php print $sr;?></td>
                                      <td class="text-left">
                                      		<img src="<?php print $items['item_image'];?>" alt="">
                                      </td>
                                      <td class="text-left"><?php print $items['item_name'];?></td>
                                      <td class="text-left"><?php print $items['store_name'];?></td>
                                      <td><?php print $items['qty'];?></td>
                                      <td>$<?php print $items['price'];?></td>
                                      <td>$<?php print $items['shipping'];?></td>
                                      <td>$<?php print $items['subtotal'];?></td>
                                      <td><?php print orderCartOnAdminStatus($items['item_status']);?></td>
                                    </tr>
                                <?php
                                			$sr++;
                                		}
                                	}
                                ?>
                                  </tbody>
                                </table>
                              </div>
                          	</div>
                          	<div class="container-fluid mt-5 w-100">
                          		<div class="row justify-content-end">
                          			<div class="col-md-6">
		                            	<div class="table-responsive w-100">
			                                <table class="table">
												<tr>
													<td colspan="5">Subtotal</td>
													<td>$<?php print number_format($orders['order']['final_subtotal'],2);?></td>
												</tr>
												<tr>
													<td colspan="5">Shipping</td>
													<td>$<?php print number_format($orders['order']['shipping'],2);?></td>
												</tr>
												<tr>
													<td colspan="5">Discount</td>
													<td>$<?php print number_format($orders['order']['discount'],2);?></td>
												</tr>
												<tr>
													<td colspan="5">Grand Total</td>
													<td>$<?php print number_format($orders['order']['total_amount'],2);?></td>
												</tr>
			                                </table>
			                            </div>
			                        </div>
			                    </div>
                          	</div>
                      </div>
                  </div>
              </div>
          </div>
        
<?php print view('admin/footer');?>