<div class="row">
	<div class="col-xl-10 col-lg-10 col-md-10 col-12">
		<div class="form-group">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label class="lh">Package dimension</label>
					<p>Charge additional shipping costs based on packet dimensions covered here.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<label>
						<span class="tit">Width</span>
					</label>
					<div class="position-relative subtitle">
						<input type="text" class="form-control" value="<?php print $default['dimwidth'];?>">
						<span class="position-absolute">cm</span>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<label>
						<span class="tit">Height</span>
					</label>
					<div class="position-relative subtitle">
						<input type="text" class="form-control" value="<?php print $default['dimheight'];?>">
						<span class="position-absolute">cm</span>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<label>
						<span class="tit">Depth</span>
					</label>
					<div class="position-relative subtitle">
						<input type="text" class="form-control" value="<?php print $default['dimlenth'];?>">
						<span class="position-absolute">cm</span>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<label>
						<span class="tit">Weight</span>
					</label>
					<div class="position-relative subtitle">
						<input type="text" class="form-control" value="<?php print $default['weightkg'];?>">
						<span class="position-absolute">kg</span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label class="lh">Delivery Time</label>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label class="form-check">
						<input type="radio" value="1" <?php if( $default['devliery_time'] == 1 ) {?> checked<?php }?>>
						<span class="tit">None</span>
					</label>
					<label class="form-check">
						<input type="radio" value="2" <?php if( $default['devliery_time'] == 2 ) {?> checked<?php }?>>
						<span class="tit">Default delivery time</span>
					</label>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">Delivery time of in-stock products:</span>
					</label>
					<input type="text" placeholder="Delivery within 3-4 days" class="form-control" value="<?php print $default['devliery_days'];?>">
					<span>Leave empty to disable.</span>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">Delivery time of out-of-stock products with allowed orders:</span>
					</label>
					<input type="text" placeholder="Delivery within 3-4 days" class="form-control" value="<?php print $default['devliery_days_after'];?>">
					<span>Leave empty to disable.</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label class="lh">Shipping fees</label>
					<p>Does this product incur additional shipping costs?</p>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<div class="position-relative subtitle">
						<span class="position-absolute">$</span>
						<input type="text" class="form-control" value="<?php print $default['shipping_cost'];?>" placeholder="0.00">
					</div>
					<span>Leave empty to disable.</span>
				</div>
			</div>
		</div>
	</div>
</div>