<?php $commission = (new \App\Models\Setting())->getResultById(['ZAPTA_COMMISSION_STATUS','ZAPTA_COMMISSION','ZAPTA_COMMISSION_OPTION','ZAPTA_COMMISSION_PIRCE_INCREASE']);?>
<div class="row">
	<div class="col-xl-10 col-lg-10 col-md-10 col-12">
		<div class="form-group">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label class="lh">Retail price</label>
				<?php 
					if ( $commission[2]['var_detail'] == 1 ) {
				?>
					<p>Zappta Charge <?php if ( $commission[1]['var_detail'] == 1 ) { 
												print '$'.$commission[0]['var_detail']; 
											} else {  
												print $commission[0]['var_detail'] . '%';
											} ?> Commission on this product.<?php if ( $commission[3]['var_detail'] == 1 ) {?> Commission add in the final price<?php } ?></p>
				<?php } ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<label>
						<span class="tit">Sale price</span>
					</label>
					<div class="position-relative subtitle">
						<span class="position-absolute">$</span>
						<input type="text" name="product[detail][retail_price_notax]" id="p_deal_price" class="form-control" placeholder="0.000000" value="<?php print $default['retail_price_notax'];?>" onkeyup="updateFinalPrice()">
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<label>
						<span class="tit">Regular price</span>
					</label>
					<div class="position-relative subtitle">
						<span class="position-absolute">$</span>
						<input type="text" name="product[detail][retail_price_tax]" id="p_regular_price" class="form-control" placeholder="0.000000" value="<?php print $default['retail_price_tax'];?>" onkeyup="updateFinalPrice()">
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<label class="form-check-label">Enable Deal</label>
					<div class="field-input">
						<div class="form-check form-switch">
						  <input class="form-check-input ms-0" id="p_deal_enable" name="product[detail][deal_enable]" type="checkbox" value="1"<?php if ( isset($default['deal_enable']) && $default['deal_enable'] == 1 ) { ?> checked<?php } ?> onclick="updateFinalPrice()"/>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
			<?php 
				if ( $commission[2]['var_detail'] == 1 ) {
			?>
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<label>
						<span class="tit">Zappta Commission</span>
					</label>
					<div class="position-relative subtitle">
						<span class="position-absolute">$</span>
						<input type="text" name="product[detail][zappta_commission]" id="p_zappta_commission" class="form-control" placeholder="0.000000" value="<?php print isset($default['zappta_commission']) ? $default['zappta_commission'] : '';?>" readonly>
					</div>
				</div>
			<?php } else { ?>
				<input type="hidden" name="product[detail][zappta_commission]" value="0" />
			<?php } ?>
				<input type="hidden" name="product[detail][deal_final_price]" id="deal_final_price" value="<?php print isset($default['deal_final_price']) ? $default['deal_final_price'] : 0;?>" />
				<input type="hidden" name="product[detail][final_price]" id="default_final_price" value="<?php print isset($default['final_price']) ? $default['final_price'] : 0;?>" />
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<label>
						<span class="tit">Final Price</span>
					</label>
					<div class="position-relative subtitle">
						<span class="position-absolute">$</span>
						<?php if ( isset($default['deal_enable']) && $default['deal_enable'] == 1 ) { ?>
						<input type="text" data-commission="<?php print $commission[0]['var_detail'];?>" data-commission-option="<?php print $commission[1]['var_detail'];?>" data-commission-status="<?php print $commission[2]['var_detail'];?>" data-commission-price="<?php print $commission[3]['var_detail'];?>" id="p_final_price" class="form-control" placeholder="0.000000" value="<?php print $default['deal_final_price'];?>" readonly>
						<?php } else { ?>
						<input type="text" data-commission="<?php print $commission[0]['var_detail'];?>" data-commission-option="<?php print $commission[1]['var_detail'];?>" data-commission-status="<?php print $commission[2]['var_detail'];?>" data-commission-price="<?php print $commission[3]['var_detail'];?>" id="p_final_price" class="form-control" placeholder="0.000000" value="<?php print $default['final_price'];?>" readonly>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>