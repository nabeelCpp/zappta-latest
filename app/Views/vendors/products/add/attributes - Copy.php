<div class="row">

	<div class="cataddblock mt-4">
			<?php  $cat_list = (new App\Models\CategoriesModel())->getcat(); ?>
			<div class="form-group">
				<label>
					<span class="tit">Categories </span>
					<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Where should the product be available on your site? The main category is where the product appears by default: this is the category which is seen in the product page's URL. Disabled categories are written in italics.">
					  	<i class="fa-solid fa-circle-info"></i>
					</span>
				</label>
				<div class="catheight">
	          <?php 
	              if ( is_array($cat_list) && count($cat_list) > 0 ) {
	                  foreach($cat_list as $cats){
	          ?>
	              <div class="custom-control custom-checkbox mb-1">
	                <input type="checkbox" class="custom-control-input" id="parentCategory<?php print my_encrypt($cats['id']);?>" name="product_category[]" value="<?php print my_encrypt($cats['id']);?>"<?php if ( isset($getData['product_category']) && in_array(my_encrypt($cats['id']),$getData['product_category']) ) { ?> checked<?php } ?>>
	                <label class="custom-control-label" for="parentCategory<?php print my_encrypt($cats['id']);?>"><?php print $cats['name']; ?> <?php print $cats['cat_name']; ?></label>
	              </div>

	          <?php
	                  }
	              }
	          ?>  
	          	</div>
	        </div>
	    </div>

	    <div class="cataddblock mt-4">
					<?php  $brand_list = (new App\Models\BrandModel())->findAll(); ?>
					<div class="form-group">
							<label> <span class="tit">Brands </span></label>
							<select class="form-control" name="product[default][brand_id]">
									<option value="<?php print my_encrypt(0);?>">Select Brand</option>
		          <?php 
		              if ( is_array($brand_list) && count($brand_list) > 0 ) {
		                  foreach($brand_list as $brand){
		          ?>
		          		<option value="<?php print my_encrypt($brand['id']);?>" <?php if ( isset($getData['product']['default']['brand_id']) && $getData['product']['default']['brand_id'] == my_encrypt($brand['id']) ) { ?> selected<?php }?> ><?php print $brand['name']; ?></option>
		          <?php
		                  }
		              }
		          ?>  
		          </select>
		      </div>
		  </div>



	<div class="col-xl-12 col-lg-12 col-md-12 col-12">
		<?php 
			$size = (new App\Models\AttributeValueModel())->getAllByType(1);
			if ( is_array($size) && count($size) > 0 ) {
		?>
		<div class="form-row attrbute-field">
			<h3>Size</h3>
			<?php  
					foreach ( $size as $col ) {
			?>
			<div class="form-check">
				<label class="d-flex">
					<div class="value-name ms-2 me-2 d-flex align-items-center">
	    				<input type="checkbox" name="product_attribute[size][<?php print my_encrypt($col['attr_id']).'-'.my_encrypt($col['id']);?>]" value="<?php print my_encrypt($col['attr_id']).'_1_'.my_encrypt($col['id']);?>" <?php if ( isset($getData['product_attribute']['size']) && in_array(my_encrypt($col['attr_id']).'_1_'.my_encrypt($col['id']),$getData['product_attribute']['size']) ) { ?> checked<?php } ?>>
	    				<span class="ms-1"><?php print $col['name_en']?></span>
					</div>
				</label>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		
		<?php 
			$colors = (new App\Models\AttributeValueModel())->getAllByType(2);
			if ( is_array($colors) && count($colors) > 0 ) {
		?>
		<div class="form-row attrbute-field">
			<h3>Colors</h3>
			<?php  
					foreach ( $colors as $col ) {
			?>
			<div class="form-check">
				<label class="d-flex">
					<div class="value-name color-field ms-2 me-2 d-flex align-items-center">
						<?php if( !empty( $col['value_img']) ) { ?>
		    				<?php $value_img_ext = explode('.', $col['value_img']);?>
		    				<input type="checkbox" name="product_attribute[color][<?php print my_encrypt($col['attr_id']).'-'.my_encrypt($col['id']);?>]" value="<?php print my_encrypt($col['attr_id']).'_1_'.my_encrypt($col['id']);?>" style="background: url(<?php print base_url().'/images/media/'.$value_img_ext[0].'/'.end($value_img_ext).'/100';?>);" <?php if ( isset($getData['product_attribute']['color']) && in_array(my_encrypt($col['attr_id']).'_1_'.my_encrypt($col['id']),$getData['product_attribute']['color']) ) { ?> checked<?php } ?>>
		    				<span class="ms-1"><?php print $col['name_en']?></span>
		    			<?php } else { ?>
		    				<input type="checkbox" name="product_attribute[color][<?php print my_encrypt($col['attr_id']).'-'.my_encrypt($col['id']);?>]" value="<?php print my_encrypt($col['attr_id']).'_1_'.my_encrypt($col['id']);?>" style="background: #<?php print $col['color_code'];?>;" <?php if ( isset($getData['product_attribute']['color']) && in_array(my_encrypt($col['attr_id']).'_1_'.my_encrypt($col['id']),$getData['product_attribute']['color']) ) { ?> checked<?php } ?>>
		    				<span class="ms-1"><?php print $col['name_en']?></span>
		    			<?php } ?>
					</div>
				</label>
			</div>
			<?php } ?>
		</div>
		<?php } ?>

		<?php 
			$dimension = (new App\Models\AttributeValueModel())->getAllByType(3);
			if ( is_array($dimension) && count($dimension) > 0 ) {
		?>
		<div class="form-row attrbute-field">
			<h3>Dimension</h3>
			<?php  
					foreach ( $dimension as $col ) {
			?>
			<div class="form-check">
				<label class="d-flex">
					<div class="value-name ms-2 me-2 d-flex align-items-center">
	    				<input type="checkbox" name="product_attribute[dimension][<?php print my_encrypt($col['attr_id']).'-'.my_encrypt($col['id']);?>]" value="<?php print my_encrypt($col['attr_id']).'_1_'.my_encrypt($col['id']);?>" <?php if ( isset($getData['product_attribute']['dimension']) && in_array(my_encrypt($col['attr_id']).'_1_'.my_encrypt($col['id']),$getData['product_attribute']['dimension']) ) { ?> checked<?php } ?>>
	    				<span class="ms-1"><?php print $col['name_en']?></span>
					</div>
				</label>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<?php 
			$papertype = (new App\Models\AttributeValueModel())->getAllByType(4);
			if ( is_array($papertype) && count($papertype) > 0 ) {
		?>
		<div class="form-row attrbute-field">
			<h3>Paper Type</h3>
			<?php  
					foreach ( $papertype as $col ) {
			?>
			<div class="form-check">
				<label class="d-flex">
					<div class="value-name ms-2 me-2 d-flex align-items-center">
	    				<input type="checkbox" name="product_attribute[papertype][<?php print my_encrypt($col['attr_id']).'-'.my_encrypt($col['id']);?>]" value="<?php print my_encrypt($col['attr_id']).'_1_'.my_encrypt($col['id']);?>" <?php if ( isset($getData['product_attribute']['papertype']) && in_array(my_encrypt($col['attr_id']).'_1_'.my_encrypt($col['id']),$getData['product_attribute']['papertype']) ) { ?> checked<?php } ?>>
	    				<span class="ms-1"><?php print $col['name_en']?></span>
					</div>
				</label>
			</div>
			<?php } ?>
		</div>
		<?php } ?>

	</div>
</div>