<?php print view('vendors/header'); ?>

<section class="bread">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-12">
				<div class="bb">
					<ul class="p-0 m-0 d-flex align-items-center">
						<li>
							<a href="<?php print base_url(); ?>">Home</a>
						</li>
						<li>/</li>
						<li>Catalog</li>
						<li>/</li>
						<li><?php print $pagetitle; ?></li>
						<li>/</li>
						<li>Add</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="vendor-dashbaord">
	<div class="container">
		<div class="wrapper d-flex align-items-stretch">

			<?php print view('vendors/sidebar'); ?>

			<div id="content" class="float-start">

				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<div class="artaddForm">
								<?php print show_message(); ?>
								<form action="<?php print base_url() . '/vendors/attributes/save'; ?>" method="post">
									<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
									<input type="hidden" name="id" value="<?php print my_encrypt(0); ?>" />
									<div class="form-field">
										<label>Name <span class="required">*</span></label>
										<div class="field-input">
											<input type="text" name="name_en" value="">
										</div>
									</div>
									<div class="form-field">
										<label>Attribute type <span class="required">*</span></label>
										<div class="field-input">
											<select name="opt">
												<option value="1">Size</option>
												<option value="2">Color</option>
												<option value="3">Dimension</option>
												<option value="4">Paper Type</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label>Category</label>
										<select class="js-example-basic-single w-100" name="category_id[]" multiple="multiple">
											<?php getAdminDropDownCategorySelectedArray(buildTree($allcat)); ?>
										</select>
									</div>
									<div class="form-field">
										<div class="btns">
											<button type="submit">Save</button>
										</div>
										<div class="btnCancel">
											<button type="button" onclick="window.location.href = '<?php print base_url() . '/vendor/attributes'; ?>';">Cancel</button>
										</div>
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

<?php print view('vendors/footer'); ?>