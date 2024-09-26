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

	<section class="vendor-dashbaord  position-relative">
		<div class="container">
			<div class="wrapper d-flex align-items-stretch">
		
				<?php print view('vendors/sidebar');?>

				<div id="content" class="float-start">
					<div class="container-fluid">
				<?php print view('vendors/compaign');?>
						<div class="row mt-3">
							<div class="col-12">

					      		<?php print show_message();?>

					      		<div class="artaddForm mt-3">
					      			<h5 class="mb-2 mt-2">Store Detail</h5>
									<form action="<?php print base_url().'/vendors/account/save';?>" method="post" enctype="multipart/form-data">
                      					<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
										<div class="form-group">
											<label class="mb-1 font-13">Store Name</label>
											<input type="text" name="store_name" value="<?php print isset($user_data['store_name']) ? $user_data['store_name'] : '';?>" class="form-control font-0-8"/>
										</div>
										<div class="form-group mt-2">
											<label class="mb-1 font-13">Store Logo</label>
											<div class="fileinput position-relative">
												<div class="fileicons position-absolute d-flex align-items-center">
													<div class="fc d-flex align-items-center text-center me-2">
														<span><i class="fa-regular fa-image"></i></span>
														<span>Add Logo</span>
													</div>
													<div class="filename" id="filename"></div>
												</div>
												<input type="file" id="store_logo" onchange="getStoreLogo('store_logo','filename');" name="store_logo" class="position-absolute"  accept=".jpg,.jpeg,.png"/>
											</div>
											<small class="required">Maximum size 300px / 300px ( File format must be JPEG, PNG )</small>
											<div class="logothumb">
												<?php 
								    				if( ! empty( $user_data['store_logo'] ) ) { 
								    					$ext_name = explode('.',$user_data['store_logo']);
								    			?>
								    				<img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="animate" alt="">
								    			<?php } else { ?>
								    				<img src="<?php print base_url().'/images/media/img-not-found/jpg/100';?>" class="animate" alt="">
								    			<?php }?>
											</div>
										</div>
										<div class="form-group mt-2">
											<label class="mb-1 font-13">Store Link</label>
											<input type="text" name="store_link" value="<?php print isset($user_data['store_link']) ? $user_data['store_link'] : '';?>" class="form-control font-0-8"/>
										</div>
										<div class="form-group mt-2">
											<label class="mb-1 font-13">Order Email</label>
											<input type="email" name="store_order_email" value="<?php print isset($user_data['store_order_email']) ? $user_data['store_order_email'] : $user_data['email'];?>" class="form-control font-0-8"/>
										</div>
										<div class="form-group mt-2">
											<label class="mb-1 font-13">PayPal Email</label>
											<input type="email" name="paypal_email" value="<?php print isset($user_data['paypal_email']) ? $user_data['paypal_email'] : '';?>" class="form-control font-0-8"/>
										</div>
										<div class="form-group mt-2">
											<label class="mb-1 font-13">Store Available for Public</label>
											<div class="field-input">
			                            		<div class="form-check form-switch">
												  <input class="form-check-input" id="storecheckinput" name="store_status" value="1" type="checkbox" <?php if ( $user_data['store_status'] == 1 ) { ?> checked<?php } ?>/>
												  <label class="form-check-label">Enable</label>
												</div>
				                            </div>
										</div>
										<div class="form-group mt-4">
											<button type="submit" class="btn btn-pro m-0">Update</button>
										</div>
									</form>
								</div>

					      		<div class="artaddForm mt-3">
					      			<h5 class="mb-2 mt-2">Account Detail</h5>
									<form action="<?php print base_url().'/vendors/account/update';?>" method="post">
                      					<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
										<div class="form-group">
											<label class="mb-1 font-13">Store Email</label>
											<input type="text" value="<?php print isset($user_data['email']) ? $user_data['email'] : '';?>" class="form-control font-0-8" disabled readonly/>
										</div>
										<div class="form-group mt-2">
											<label class="mb-1 font-13">Store Password</label>
											<input type="password" name="password" value="" class="form-control font-0-8"/>
										</div>
										<div class="form-group mt-4">
											<button type="submit" class="btn btn-pro m-0">Update</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>

<?php  print view('vendors/footer');?>