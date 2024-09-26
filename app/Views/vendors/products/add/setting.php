<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-12">
		<div class="form-row">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12 p-0">
					<div class="row" id="product_image_block">
						<?php
						if (isset($getData['product_gallery']) && is_array($getData['product_gallery']) && count($getData['product_gallery'])) {
							$x = 1;
							foreach ($getData['product_gallery'] as $gallery) {
								$img_ext = explode('.', $gallery);
						?>
								<div class="col-md-3 mt-1 mb-1 pp_<?php print $x; ?>">
									<div class="position-relative">
										<div class="delicon btn btn-danger" style="position: absolute;padding: 3px;" onclick="removePImg(<?php print $x; ?>);">
											<i class="fa-regular fa-trash-can"></i>
										</div>
										<div class="ppgal">
											<img src="<?php print base_url(); ?>/images/product/<?php print $img_ext[0]; ?>/<?php print $img_ext[1]; ?>/100" alt="" class="rounded" style="height: 100px; width: 100%; object-fit: cover; object-position: center; cursor:pointer;">
										</div>
									</div>
									<input type="hidden" id="input_pp_<?php print $x; ?>" name="product_gallery[]" value="<?php print $gallery; ?>">
								</div>
						<?php
								$x++;
							}
						}
						?>
						<!--  -->
						<div class="col-md-3  mt-1 mb-1">
							<div class="upload-pro text-center" id="addGallery">
								<div class="upload-img">
									<svg xmlns="http://www.w3.org/2000/svg" width="50" height="42.857" viewBox="0 0 50 42.857">
										<path id="Icon_material-add-a-photo" data-name="Icon material-add-a-photo" d="M6.522,7.622V1.5H10.87V7.622h6.522V11.7H10.87v6.122H6.522V11.7H0V7.622Zm6.522,12.245V13.745h6.522V7.622H34.783L38.761,11.7h6.891A4.233,4.233,0,0,1,50,15.786v24.49a4.233,4.233,0,0,1-4.348,4.082H10.87a4.233,4.233,0,0,1-4.348-4.082V19.867ZM28.261,38.235c6,0,10.87-4.571,10.87-10.2s-4.87-10.2-10.87-10.2-10.87,4.571-10.87,10.2S22.261,38.235,28.261,38.235ZM21.3,28.031a6.746,6.746,0,0,0,6.957,6.531,6.746,6.746,0,0,0,6.957-6.531A6.746,6.746,0,0,0,28.261,21.5,6.746,6.746,0,0,0,21.3,28.031Z" transform="translate(0 -1.5)" fill="#bbcdd2" />
									</svg>
								</div>
							</div>
						</div>
						<input type="hidden" name="product[default][cover]" id="productCover" value="">
					</div>
					<div class="row">
						<div id="inputHidden" data-required="Atleast one gallery item is required!" required data-name="product_gallery[]"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="form-row">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label>Summary</label>
					<textarea class="tinymce form-control" name="product[default][short]" maxlength="200"><?php //print isset($getData['product']['default']['short']) ? $getData['product']['default']['short'] : '';
																											?></textarea>
					<span>Maximum 200 Char.</span>
				</div>
			</div>
		</div> -->
		<div class="form-row">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-12">
					<label>Description</label>
					<textarea class="tinymce form-control" name="product[default][description]"><?php print isset($getData['product']['default']['description']) ? $getData['product']['default']['description'] : ''; ?></textarea>
				</div>
			</div>
		</div>
		<div class="form-row">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">Condition</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Not all shops sell new products. This option enables you to indicate the condition of the product. It can be required on some marketplaces.">
							<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<select class="form-control" name="product[default][conditions]">
						<option value="1" <?php if (isset($getData['product']['default']['conditions']) && $getData['product']['default']['conditions'] == 1) { ?> selected<?php } ?>>New</option>
						<option value="2" <?php if (isset($getData['product']['default']['conditions']) && $getData['product']['default']['conditions'] == 2) { ?> selected<?php } ?>>Used</option>
						<option value="3" <?php if (isset($getData['product']['default']['conditions']) && $getData['product']['default']['conditions'] == 3) { ?> selected<?php } ?>>Refurbished</option>
					</select>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">SKU</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Your SKU code for this product. Allowed special characters: .-_#.">
							<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<input type="text" name="product[default][reference]" class="form-control" data-required="SKU field is required" required value="<?php print isset($getData['product']['default']['reference']) ? $getData['product']['default']['reference'] : ''; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">ISBN</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="The International Standard Book Number (ISBN) is used to identify books and other publications.">
							<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<input type="text" name="product[default][isbn]" class="form-control" value="<?php print isset($getData['product']['default']['isbn']) ? $getData['product']['default']['isbn'] : ''; ?>">
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">EAN-13 or JAN barcode</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="This type of product code is specific to Europe and Japan, but is widely used internationally. It is a superset of the UPC code: all products marked with an EAN will be accepted in North America.">
							<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<input type="text" name="product[default][ean]" class="form-control" value="<?php print isset($getData['product']['default']['ean']) ? $getData['product']['default']['ean'] : ''; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">UPC barcode</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="This type of product code is widely used in the United States, Canada, the United Kingdom, Australia, New Zealand and in other countries.">
							<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<input type="text" name="product[default][upcbarcode]" class="form-control" value="<?php print isset($getData['product']['default']['upcbarcode']) ? $getData['product']['default']['upcbarcode'] : ''; ?>">
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">MPN</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="MPN is used internationally to identify the Manufacturer Part Number.">
							<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<input type="text" name="product[default][mpncode]" class="form-control" value="<?php print isset($getData['product']['default']['mpncode']) ? $getData['product']['default']['mpncode'] : ''; ?>">
				</div>
			</div>

		</div>

	</div>





</div>