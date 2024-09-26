<?php print view('admin/header');?>
	<?php $errors = session()->getFlashdata('errors'); ?>
	<?php $success = session()->getFlashdata('success'); ?>
	<?php if(!empty($success)){ ?>
	<div class="alert alert-primary" role="alert">
   <?php print_r($success); ?>
   </div>
<?php } ?>
	<div class="row">
		<div class="col-md-6">
			<div>
				<form method="POST" action="<?php print base_url().ADMINURL.'users/AddAdminUsers';?>">
					<input type="hidden" name="<?php print csrf_token();?>" value="<?php print csrf_hash();?>">
					  <div class="form-group">
					    <label for="InputName">Name</label>
					    <input type="text" class="form-control" name="name" id="InputName" aria-describedby="emailHelp" placeholder="Enter Name">
					    <span style="font-size: 20px; color: red"><?=$errors&&isset($errors['name'])?$errors['name']:''?></span>
					  </div>
					  <div class="form-group">
					    <label for="InputEmail">Email</label>
					    <input type="text" class="form-control" name="email" id="InputEmail" placeholder="Enter Email">
					    <span style="font-size: 20px; color: red"><?=$errors&&isset($errors['email'])?$errors['email']:''?></span>
					  </div>
					   <div class="form-group">
					    <label for="InputPassword">Password</label>
					    <input type="password" class="form-control" name="password" id="InputPassword" placeholder="Enter Password">
					    <span style="font-size: 20px; color: red"><?=$errors&&isset($errors['password'])?$errors['password']:''?></span>
					  </div>
					<button type="submit" name="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
		
	</div>


<?php print view('admin/footer');?>