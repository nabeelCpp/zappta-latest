<?php print view('admin/header');?>

	
		<div class="row">
			
			<div class="col-xl-12 col-lg-12 col-md-12 col-12">
				<?php print show_message(); ?>
			</div>
			<div class="col-xl-12 col-lg-12 col-md-12 col-12">

				<div class="form-group mb-4">
					<input type="text" placeholder="Enter Product Name *" class="form-control" value="<?php print $default['name'];?>" />
				</div>

				<div class="tabs-add">

					<ul class="nav nav-tabs" id="myTab" role="tablist">
					  <li class="nav-item" role="presentation">
					    <button class="nav-link active" id="BasicSettings-tab" data-bs-toggle="tab" data-bs-target="#BasicSettings" type="button" role="tab" aria-controls="BasicSettings" aria-selected="true">Basic Settings</button>
					  </li>
					  <li class="nav-item" role="presentation">
					    <button class="nav-link" id="Attributes-tab" data-bs-toggle="tab" data-bs-target="#Attributes" type="button" role="tab" aria-controls="Attributes" aria-selected="false">Categories & Attributes</button>
					  </li>
					  <li class="nav-item" role="presentation">
					    <button class="nav-link" id="Quantities-tab" data-bs-toggle="tab" data-bs-target="#Quantities" type="button" role="tab" aria-controls="Quantities" aria-selected="false">Quantities</button>
					  </li>
					  <li class="nav-item" role="presentation">
					    <button class="nav-link" id="Shipping-tab" data-bs-toggle="tab" data-bs-target="#Shipping" type="button" role="tab" aria-controls="Shipping" aria-selected="false">Shipping</button>
					  </li>
					  <li class="nav-item" role="presentation">
					    <button class="nav-link" id="Pricing-tab" data-bs-toggle="tab" data-bs-target="#Pricing" type="button" role="tab" aria-controls="Pricing" aria-selected="false">Pricing</button>
					  </li>
					  <li class="nav-item" role="presentation">
					    <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false">SEO</button>
					  </li>
					</ul>
					<div class="tab-content" id="myTabContent">
					  <div class="tab-pane fade show active" id="BasicSettings" role="tabpanel" aria-labelledby="BasicSettings-tab">
					  		<?php print view('admin/products/setting');?>
					  </div>
					  <div class="tab-pane fade" id="Attributes" role="tabpanel" aria-labelledby="Attributes-tab">
					  		<?php print view('admin/products/attributes');?>
					  </div>
					  <div class="tab-pane fade" id="Quantities" role="tabpanel" aria-labelledby="Quantities-tab">
					  		<?php print view('admin/products/quantities');?>
					  </div>
					  <div class="tab-pane fade" id="Shipping" role="tabpanel" aria-labelledby="Shipping-tab">
					  		<?php print view('admin/products/shipping');?>
					  </div>
					  <div class="tab-pane fade" id="Pricing" role="tabpanel" aria-labelledby="Pricing-tab">
					  		<?php print view('admin/products/pricing');?>
					  </div>
					  <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
					  		<?php print view('admin/products/seo');?>
					  </div>
					</div>


				</div>

			</div>



		</div>

<?php print view('admin/footer');?>