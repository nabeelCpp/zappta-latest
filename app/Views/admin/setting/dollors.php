<?php $commission = (new \App\Models\Setting())->getResultById(['ZAPPTA_REGISTER','ZAPPTA_LOGIN','ZAPPTA_PRODUCT_VIEW','ZAPPTA_BUYING','ZAPPTA_INVITE_FRIEND','ZAPPTA_INVITE_JOIN','ZAPPTA_VIEW_TODAY_DEAL','ZAPPTA_SHARING_TWITER','ZAPPTA_SHARING_INSTAGRAM','ZAPPTA_SHARING_FACEBOOK','ZAPPTA_SHARING_PIN','ZAPPTA_SHARING_WHATSAPP','ZAPPTA_SHARING_MESSENGAR','ZAPPTA_GIVE_WAY_RECOM','ZAPPTA_GIVE_WAY_ADS','ZAPPTA_WATCHING_VIDEO','ZAPPTA_REPEAT_VIEW', 'ZAPPTA_SELECT_ITEMS']);?>
<?php 
	// print '<pre>';
	// print_r($commission);
	// print '</pre>';
	// die();
?>
<form method="post" action="<?php print base_url().ADMINURL.'settings/update';?>">
	<input type="hidden" name="<?php print csrf_token();?>" value="<?php print csrf_hash();?>">
	<input type="hidden" name="_red" value="dollors">
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Register an Account</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_REGISTER" class="form-control" value="<?php print $commission[0]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Login an Account</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_LOGIN" class="form-control" value="<?php print $commission[1]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Product View</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_PRODUCT_VIEW" class="form-control" value="<?php print $commission[2]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Purchase Product</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_BUYING" class="form-control" value="<?php print $commission[3]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Invite Friend</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_INVITE_FRIEND" class="form-control" value="<?php print $commission[4]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Join Friend</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_INVITE_JOIN" class="form-control" value="<?php print $commission[5]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Zappta Deal</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_VIEW_TODAY_DEAL" class="form-control" value="<?php print $commission[6]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Sharing on Twitter</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_SHARING_TWITER" class="form-control" value="<?php print $commission[7]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Sharing on Instagram</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_SHARING_INSTAGRAM" class="form-control" value="<?php print $commission[8]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Sharing on Facebook</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_SHARING_FACEBOOK" class="form-control" value="<?php print $commission[9]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Sharing on Pinterest</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_SHARING_PIN" class="form-control" value="<?php print $commission[10]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Sharing on Whatsapp</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_SHARING_WHATSAPP" class="form-control" value="<?php print $commission[11]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Sharing on Messengar</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_SHARING_MESSENGAR" class="form-control" value="<?php print $commission[12]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Zappta Give way</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_GIVE_WAY_RECOM" class="form-control" value="<?php print $commission[13]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Zappta Give way Ads</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_GIVE_WAY_ADS" class="form-control" value="<?php print $commission[14]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Watching Video</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_WATCHING_VIDEO" class="form-control" value="<?php print $commission[15]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Select Items</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_SELECT_ITEMS" class="form-control" value="<?php print isset($commission[16])?$commission[16]['var_detail']:'';?>">
			</div>
		</div>
	</div>
	<!-- <div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Sharing on Pinterest</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="ZAPPTA_REPEAT_VIEW" class="form-control" value="<?php //print $commission[16]['var_detail'];?>">
			</div>
		</div>
	</div> -->
	<button type="submit" class="btn btn-primary">Update</button>
</form>