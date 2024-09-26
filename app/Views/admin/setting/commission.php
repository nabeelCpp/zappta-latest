<?php $commission = (new \App\Models\Setting())->getResultById(['ZAPTA_COMMISSION_STATUS','ZAPTA_COMMISSION','ZAPTA_COMMISSION_OPTION','ZAPTA_COMMISSION_PIRCE_INCREASE']);?>
<?php 
	// print '<pre>';
	// print_r($commission[1]);
	// print '</pre>';
	// die();
?>
<form method="post" action="<?php print base_url().ADMINURL.'settings/update';?>">
	<input type="hidden" name="<?php print csrf_token();?>" value="<?php print csrf_hash();?>">
	<input type="hidden" name="_red" value="commission">
	<div class="form-group">
		<label>Commission Enable</label>
		<div class="field-input">
			<div class="form-check form-switch">
			  <input class="form-check-input ms-0" id="p_deal_enable" name="ZAPTA_COMMISSION_STATUS" type="checkbox" value="1"<?php if ( isset( $commission[2]['var_detail'] ) && $commission[2]['var_detail'] == 1 ) { ?> checked<?php } ?> />
			</div>
		</div>
	</div>
	<div class="form-group">
		<label>Commission</label>
		<input type="text" name="ZAPTA_COMMISSION" class="form-control" value="<?php print $commission[0]['var_detail'];?>" required>
	</div>
	<div class="form-group">
		<label>Commission Option</label>
		<select name="ZAPTA_COMMISSION_OPTION" class="form-control">
			<option value="1"<?php if ( $commission[1]['var_detail'] == 1 ) { ?> selected<?php } ?>>Fixed Amount</option>
			<option value="2"<?php if ( $commission[1]['var_detail'] == 2 ) { ?> selected<?php } ?>>Percentage</option>
		</select>
	</div>
	<div class="form-group">
		<label>Commission add in the final price</label>
		<select name="ZAPTA_COMMISSION_PIRCE_INCREASE" class="form-control">
			<option value="1"<?php if ( $commission[3]['var_detail'] == 1 ) { ?> selected<?php } ?>>Yes</option>
			<option value="2"<?php if ( $commission[3]['var_detail'] == 2 ) { ?> selected<?php } ?>>No</option>
		</select>
	</div>
	<button type="submit" class="btn btn-primary">Update</button>
</form>