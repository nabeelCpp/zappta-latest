<?php print view('site/header');?>
	<section class="page-header">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h2 class="text-center"><?php print $pagetitle;?></h2>
				</div>
			</div>
		</div>
	</section>
	<section class="bread">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12">
					<div class="bb">
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
	<section class="vendorform">
		<div class="container">
			<div class="row">
				<div class="vform">
					<div class="vendor-heading row  align-items-center">
						<div class="col-sm-3">
							<h3>Registration</h3>
						</div>
						<div class="col-sm-9">
							<div class="text-center successerror"></div>
						</div>
					</div>
					<div class="form-group row align-items-center">
						<label for="vEmail" class="col-sm-3 col-form-label">Email <span>*</span></label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="vEmail" />
					    </div>
					</div>
					<div class="form-group row align-items-center">
						<label for="vStoreName" class="col-sm-3 col-form-label">Store Name <span>*</span></label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="vStoreName" />
					    </div>
					</div>
					<div class="form-group row align-items-center">
						<label for="vStoreLink" class="col-sm-3 col-form-label">Store Link</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="vStoreLink" />
					      <small>https://zappta.com/</small>
					    </div>
					</div>
					<div class="form-group row align-items-center">
						<label for="vPassword" class="col-sm-3 col-form-label">Password <span>*</span></label>
					    <div class="col-sm-9 position-relative">
					      <input type="password" class="form-control" id="vPassword" />
					      <div class="eyep position-absolute" id="vPasswordPassShow" onclick="showPass('vPasswordPassShow','vPassword');"><i class="fa-solid fa-eye-slash"></i></div>
					    </div>
					</div>
					<div class="form-group row align-items-center">
						<label for="vConfirmPassword" class="col-sm-3 col-form-label">Confirm Password <span>*</span></label>
					    <div class="col-sm-9 position-relative">
					      <input type="password" class="form-control" id="vConfirmPassword" />
					      <div class="eyep position-absolute" id="vLoginPassShow" onclick="showPass('vLoginPassShow','vConfirmPassword');"><i class="fa-solid fa-eye-slash"></i></div>
					    </div>
					</div>
					<div class="form-group row">
						<div class="errorForm"></div>
					</div>
					<div class="form-group row align-items-center">
						<div class="text-center">
                			<input type="hidden" id="_vendor_token" value="<?php print csrf_hash() ?>">
							<button type="button" class="btn btnyellow" id="vRegisterBtn">Register</button>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-3 col-form-label"></div>
						<div class="col-sm-9 position-relative">
							<p class="link-tag"><a href="<?php print base_url().'/vendor-login';?>">Already have an Account?</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php print view('site/footer');?>