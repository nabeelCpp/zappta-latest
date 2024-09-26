<?php $commission = (new \App\Models\Setting())->getResultById(['SMTPHost','SMTPUser','SMTPPass','SMTPPort','EmailFrom','EmailUserName','SMTPCrypto','SMTPprotocol']);?>
<?php 
	// print '<pre>';
	// print_r($commission);
	// print '</pre>';
	// die();
?>
<form method="post" action="<?php print base_url().ADMINURL.'settings/update';?>">
	<input type="hidden" name="<?php print csrf_token();?>" value="<?php print csrf_hash();?>">
	<input type="hidden" name="_red" value="email">
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>SMTP Host</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="SMTPHost" class="form-control" value="<?php print $commission[0]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Email Login User</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="SMTPUser" class="form-control" value="<?php print $commission[1]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Password</label>
			</div>
			<div class="col-md-6">
				<input type="password" name="SMTPPass" class="form-control" value="<?php print $commission[2]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>SMTP Port</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="SMTPPort" class="form-control" value="<?php print $commission[3]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Email From</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="EmailFrom" class="form-control" value="<?php print $commission[4]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>Email Username</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="EmailUserName" class="form-control" value="<?php print $commission[5]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>SMTP SSL</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="SMTPCrypto" class="form-control" value="<?php print $commission[6]['var_detail'];?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<div class="col-md-4">
				<label>SMTP Protocol</label>
			</div>
			<div class="col-md-6">
				<input type="text" name="SMTPprotocol" class="form-control" value="<?php print $commission[7]['var_detail'];?>">
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-primary">Update</button>
</form>