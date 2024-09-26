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
						
						<div class="row mt-4 mb-4">
							<div class="col-12 w-100 overflow-auto">
								<?php 
								$total = 0;
                                		foreach ( $getTotalAccount as $gg ) {
												 $total += (($gg['subtotal'])+($gg['zappta_commission']));
									}

								?>
								<h6 class="m-0 float-start" style="padding-top: 8px;"><b>Sales Report</b></h6><h6 style="float: right;margin-right: 25px;font-weight: bold;font-size: 20px;">Total = <?= $total; ?></h6>
								<table class="table" style="min-width:672px;">
									<thead>
										
										<tr>
											<th>Product</th>
											<th>OrderID</th>
											<th>Status</th>
											<th>Amount</th>
											<th>Commission</th>
											<th>Total Sales</th>
										</tr>
									</thead>
									<tbody>
									<?php 
																			if ( is_array($getTotalAccount) && count($getTotalAccount) > 0 ) {
											foreach ( $getTotalAccount as $gg ) {
												 $total += (($gg['subtotal'])+($gg['zappta_commission']));
									?>
										<tr>		<?php
                  					if($gg['item_status'] == 1)
                  					{
                  						$status = 'Pending';
                  					}
                  					else if($gg['item_status'] == 3)
                  							{
                  						$status = 'Shipped';
                  					}
                  						else if($gg['item_status'] == 4)
                  							{
                  						$status = 'Delivered';
                  					}
                  						else if($gg['item_status'] == 5)
                  							{
                  						$status = 'Returned';
                  					}
                  					else if($gg['item_status'] == 6)
                  							{
                  						$status = 'Cancelled';
                  					}
                  					 ?>
											<td><?php print($gg['item_name']);?></td>
											<td><?php print($gg['order_id']);?></td>
											<td><?=isset($status)&&$status?$status:'';?></td>

											<td>$<?php print number_format($gg['subtotal'],2);?></td>
										    <td>$<?php print ($gg['zappta_commission']);?></td>
										    <td>$<?php print ($gg['subtotal']+$gg['zappta_commission']);?></td>

										</tr>
									<?php
											}

										}
									?>	
									</tbody>
								</table>
							</div>
						</div>
						
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>

<?php // print view('vendors/footer');?>