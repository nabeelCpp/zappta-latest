<div class="row">
	<div class="col-xl-10 col-lg-10 col-md-10 col-12">
		<div class="form-row">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label class="lh">Quantity</label>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">Quantity</span>
					</label>
					<input type="text" data-required="Quantity is required" required name="product[detail][quantity]" class="form-control" value="<?php print $default['quantity'];?>">
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">Minimum quantity for sale</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="The minimum quantity required to buy this product (set to 1 to disable this feature). E.g.: if set to 3, customers will be able to purchase the product only if they take at least 3 in quantity.">
						  	<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<input type="text" name="product[detail][min_qty]" class="form-control" value="<?php print $default['min_qty'];?>">
				</div>
			</div>
		</div>
		<div class="form-row">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label class="lh">Stock</label>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">Low stock level</span>
					</label>
					<input type="text" name="product[detail][low_qty]" class="form-control" value="<?php print $default['low_qty'];?>">
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">
							<input type="checkbox" name="product[detail][stock_email]" value="1"<?php if( $default['stock_email'] == 1 ) {?> checked<?php }?>>
							Send me an email when the quantity is below or equals this level 
						</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="The email will be sent to all the users who have the right to run the stock page.">
						  	<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
				</div>
			</div>
		</div>
		<div class="form-row">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label class="lh">Availability preferences</label>
					<p>Behavior when out of stock</p>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label class="form-check">
						<input type="radio" name="product[detail][outofstockorder]" value="1" <?php if( $default['outofstockorder'] == 1 ) {?> checked<?php }?>>
						<span class="tit">Deny orders</span>
					</label>
					<label class="form-check">
						<input type="radio" name="product[detail][outofstockorder]" value="2"<?php if(  $default['outofstockorder'] == 2 ) {?> checked<?php }?>>
						<span class="tit">Allow orders</span>
					</label>
				</div>
			</div>
		</div>
	</div>
</div>