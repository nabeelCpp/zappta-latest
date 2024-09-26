<?php print view('vendors/header');?>
	
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
							<li>Vendors</li>
							<li>/</li>
							<li><?php print $pagetitle;?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="vendor-dashbaord">
		<div class="container">
			<div class="wrapper d-flex align-items-stretch">
		
				<?php print view('vendors/sidebar');?>

				<div id="content" class="float-start">
					<div class="container-fluid">
						
						<div class="product-admin">
							<div class="container">
						<form action="<?php print base_url().'/vendors/products/update';?>" method="post">		
								<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>">
								<input type="hidden" name="_id" value="<?php print my_encrypt($default['pid']); ?>">
								<div class="row mt-3 mb-3">
									<div class="col-12">
										<div class="probtn d-flex justify-content-end">
											<button class="btn btn-pro d-none" type="submit" id="saveBtn">Save</button>
											<button class="btn btn-pro btn-secondary d-none nextTabBtn" type="button" data-id="-" id="prevBtn">Previous</button>
											<button class="btn btn-pro btn-info nextTabBtn" type="button" data-id="+" id="nextBtn">Next</button>
											<button class="btn btn-cancel" type="button" onclick="window.location.href='<?php print base_url().'/vendors/products';?>'">Cancel</button>
										</div>
									</div>
								</div>

								<div class="row">
									
									<div class="col-xl-12 col-lg-12 col-md-12 col-12">
										<?php print show_message(); ?>
									</div>
									<div class="col-xl-12 col-lg-12 col-md-12 col-12">

										<div class="form-group mb-4">
											<input type="text" data-required="Product name is required!" required id="productName" name="product[default][name]" placeholder="Enter Product Name *" class="form-control" value="<?php print $default['name'];?>" />
										</div>

										<div class="form-group" id="alertTabs">
											
										</div>

										<div class="tabs-add">

											<ul class="nav nav-tabs" id="myTab" role="tablist">
											  <li class="nav-item" role="presentation">
											    <button class="nav-link disabled active" id="BasicSettings-tab" data-bs-toggle="tab" data-bs-target="#BasicSettings" type="button" role="tab" aria-controls="BasicSettings" aria-selected="true">Basic Settings</button>
											  </li>
											  <li class="nav-item" role="presentation">
											    <button class="nav-link disabled" id="Attributes-tab" data-bs-toggle="tab" data-bs-target="#Attributes" type="button" role="tab" aria-controls="Attributes" aria-selected="false">Categories & Attributes</button>
											  </li>
											  <li class="nav-item" role="presentation">
											    <button class="nav-link disabled" id="Quantities-tab" data-bs-toggle="tab" data-bs-target="#Quantities" type="button" role="tab" aria-controls="Quantities" aria-selected="false">Quantities</button>
											  </li>
											  <li class="nav-item" role="presentation">
											    <button class="nav-link disabled" id="Shipping-tab" data-bs-toggle="tab" data-bs-target="#Shipping" type="button" role="tab" aria-controls="Shipping" aria-selected="false">Shipping</button>
											  </li>
											  <li class="nav-item" role="presentation">
											    <button class="nav-link disabled" id="Pricing-tab" data-bs-toggle="tab" data-bs-target="#Pricing" type="button" role="tab" aria-controls="Pricing" aria-selected="false">Pricing</button>
											  </li>
											  <li class="nav-item" role="presentation">
											    <button class="nav-link disabled" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false">SEO</button>
											  </li>
											</ul>
											<div class="tab-content" id="myTabContent">
											  <div class="tab-pane fade show active" id="BasicSettings" role="tabpanel" aria-labelledby="BasicSettings-tab">
											  		<?php print view('vendors/products/edit/setting');?>
											  </div>
											  <div class="tab-pane fade" id="Attributes" role="tabpanel" aria-labelledby="Attributes-tab">
											  		<?php print view('vendors/products/edit/attributes');?>
											  </div>
											  <div class="tab-pane fade" id="Quantities" role="tabpanel" aria-labelledby="Quantities-tab">
											  		<?php print view('vendors/products/edit/quantities');?>
											  </div>
											  <div class="tab-pane fade" id="Shipping" role="tabpanel" aria-labelledby="Shipping-tab">
											  		<?php print view('vendors/products/edit/shipping');?>
											  </div>
											  <div class="tab-pane fade" id="Pricing" role="tabpanel" aria-labelledby="Pricing-tab">
											  		<?php print view('vendors/products/edit/pricing');?>
											  </div>
											  <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
											  		<?php print view('vendors/products/edit/seo');?>
											  </div>
											</div>


										</div>

									</div>



								</div>
						</form>

							</div>
						</div>
						
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>


<?php print view('vendors/footer');?>
<?php print view('vendors/products/script');?>