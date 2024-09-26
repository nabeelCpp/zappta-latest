<?php print view('admin/header');?>
	<p class="h1">Dashboard</p>
	<p class="text-muted">Profile</p>
	<hr>
	<?=session()->getFlashdata('error')?'<div class="alert alert-danger text-center alert-dismissible fade show">'.session()->getFlashdata('error').'</div>':''?>
	<?=session()->getFlashdata('success')?'<div class="alert alert-success text-center alert-dismissible fade show">'.session()->getFlashdata('success').'</div>':''?>
	<div class="row">
		<!-- <div class="col-md-4">
			<form action="<?=base_url().route_to('admin.profile.update')?>" method="POST" enctype="multipart/form-data">
				<img src="" alt="">
				<input type="file" name="file" class="form-control">
				<button class="btn btn-success mt-3" type="submit">Update</button>
			</form>
		</div> -->
		<div class="col-md-6 offset-md-3">
			<form action="<?=base_url().route_to('admin.profile.update')?>" method="POST">
				<input type="hidden" value="<?=csrf_hash()?>" name="<?=csrf_token()?>">
				<label for="name_en">First Name (En)</label>
				<input type="text" class="form-control mb-3 mt-2" placeholder="First name" id="name_en" value="<?=$admin->name_en?>" name="name_en" required>
				<label for="last_en">Last Name (En)</label>
				<input type="text" class="form-control mb-3 mt-2" placeholder="Last name" value="<?=$admin->last_en?>" id="last_en" name="last_en">
				<label for="name_ar">Full Name (Ar)</label>
				<input type="text" class="form-control mb-3 mt-2" placeholder="Full name in arabic" value="<?=$admin->name_ar?>" id="name_ar" name="name_ar">


				<label for="address">Address</label>
				<input type="text" class="form-control mb-3 mt-2" placeholder="Address" value="<?=$admin->address?>" id="address" name="address">


				<label for="designation">Designation</label>
				<input type="text" class="form-control mb-3 mt-2" placeholder="Designation" value="<?=$admin->designation?>" id="designation" name="designation">

				<label for="email">Email</label>
				<input type="text" class="form-control mb-3 mt-2" placeholder="Email" value="<?=$admin->email?>" id="email" readonly>

				<input type="submit" class="btn btn-success" value="Update Profile">

			</form>
		</div>
	</div>
<?php print view('admin/footer');?>