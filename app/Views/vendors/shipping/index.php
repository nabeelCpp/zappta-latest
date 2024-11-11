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

	<section class="vendor-dashbaord position-relative">
		<div class="container">
			<div class="wrapper d-flex align-items-stretch">
		
				<?php print view('vendors/sidebar');?>

				<div id="content" class="float-start">
					<div class="container-fluid">
				<?php print view('vendors/compaign');?>
						<div class="artaddForm ship-form">
				 			<?php print show_message();?>
							<form action="<?php print base_url().'/vendors/shipping/update';?>" method="post">
                    			<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                    			<input type="hidden" name="_id" value="<?php print isset($sql['id']) ? my_encrypt($sql['id']) : my_encrypt(0);?>">
								<div class="form-group mb-2">
				      				<label class="mb-2 font-13">Handling Charges <span class="required">*</span></label>
				      				<div class="field-input">
				      					<input type="text" name="handlingcharges" value="<?php print isset($sql['handlingcharges']) ? $sql['handlingcharges'] : '';?>" placeholder="0.000000" class="form-control font-0-8" required>
				      				</div>
				      			</div>
								<div class="form-group">
				      				<label class="mb-2 font-13">Free shipping starts at ( Price )</label>
				      				<div class="field-input">
				      					<input type="text" name="freeshipat" value="<?php print isset($sql['freeshipat']) ? $sql['freeshipat'] : '';?>" placeholder="0.000000" class="form-control font-0-8">
				      				</div>
				      			</div>
								<div class="form-group">
				      				<label class="mb-2 font-13">Free shipping starts at ( Weight )</label>
				      				<div class="field-input">
				      					<input type="text" name="freeshipatweight" value="<?php print isset($sql['freeshipatweight']) ? $sql['freeshipatweight'] : '';?>" placeholder="0" class="form-control font-0-8">
				      				</div>
				      			</div>
								<div class="form-group">
									<label class="mb-2 font-13">Shipping & Returns Message</label>
				      				<div class="field-input">
										<textarea class="tinymce form-control" name="shipping_returns_msg"><?php print isset($sql['shipping_returns_msg']) ? $sql['shipping_returns_msg'] : ''; ?></textarea>
				      				</div>
								</div>
								<div class="form-group mt-2">
									<button type="submit" class="btn btn-pro m-0">Update</button>
								</div>
							</form>
						</div>

					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>

<?php  print view('vendors/footer');?>