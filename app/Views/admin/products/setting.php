<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-12">
		<div class="form-group">
			<div class="row">
	          	<?php 
	          			if( isset($default['gallery']) && is_array($default['gallery']) && count($default['gallery']) > 0 ) {
	          					$x=1;
	          					foreach( $default['gallery'] as $gall ) {
	          						$img_ext = explode('.',$gall['fimg']);
	          	?>
	          		<div class="col-md-1 mt-1 mb-1 pp_<?php print $x;?> <?php if( $default['cover'] == $gall['fimg'] ) { ?>active-cover<?php } ?>">
	          			<div class="position-relative active_img_gallery">                       
	          				<div class="ppgal">                                            
	          					<img src="<?php print base_url();?>/images/product/<?php print $img_ext[0];?>/<?php print $img_ext[1];?>/100" alt="" class="rounded" style="height: 100px; width: 100%; object-fit: contain; object-position: center; cursor:pointer;">
	          				</div>                                      
	          			</div>
	          		</div>
	          	<?php
	          						$x++;
	          					}
	          			}
	          	?>
	        </div>
		</div>

		<div class="form-group">
					<label>Summary</label>
					<textarea class="tinymce form-control" maxlength="200"><?php print $default['short'];?></textarea>
		</div>
		<div class="form-group">
					<label>Description</label>
					<textarea class="tinymce form-control"><?php print $default['description'];?></textarea>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">Condition</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Not all shops sell new products. This option enables you to indicate the condition of the product. It can be required on some marketplaces.">
						  	<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<select class="form-control">
						<option value="1"<?php if ( $default['conditions'] == 1 ) { ?> selected<?php }?>>New</option>
						<option value="2"<?php if ( $default['conditions'] == 2 ) { ?> selected<?php }?>>Used</option>
						<option value="3"<?php if ( $default['conditions'] == 3 ) { ?> selected<?php }?>>Refurbished</option>
					</select>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">SKU</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Your SKU code for this product. Allowed special characters: .-_#.">
						  	<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<input type="text" class="form-control" value="<?php print $default['reference'];?>">
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
					<input type="text" class="form-control" value="<?php print $default['isbn'];?>">
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">EAN-13 or JAN barcode</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="This type of product code is specific to Europe and Japan, but is widely used internationally. It is a superset of the UPC code: all products marked with an EAN will be accepted in North America.">
						  	<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<input type="text" class="form-control" value="<?php print $default['ean'];?>">
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
					<input type="text" class="form-control" value="<?php print $default['upcbarcode'];?>">
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-12">
					<label>
						<span class="tit">MPN</span>
						<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="MPN is used internationally to identify the Manufacturer Part Number.">
						  	<i class="fa-solid fa-circle-info"></i>
						</span>
					</label>
					<input type="text" class="form-control" value="<?php print $default['mpncode'];?>">
				</div>
			</div>
		</div>

	</div>

	

</div>