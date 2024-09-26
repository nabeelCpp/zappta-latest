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
							<div class="col-12 w-100 overflow-auto" >
								<?php 
									// print '<pre>';
									// print_r($getTotalAccount);
									// print '</pre>';
								?>
								<table class="table" style="min-width:672px;">
									<thead>
										<tr>
											<th>Product</th>
											<th>OrderID</th>
											<th>Amount</th>
											<th>Commission</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										if ( is_array($getTotalAccount) && count($getTotalAccount) > 0 ) {
											foreach ( $getTotalAccount as $gg ) {
									?>
										<tr>
											
											<td><?php print($gg['item_name']);?></td>
											<td><?php print($gg['order_id']);?></td>
											<td>$<?php print number_format($gg['subtotal'],2);?></td>
										    <td>$<?php print ($gg['zappta_commission']);?></td>
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