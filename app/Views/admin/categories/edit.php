<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Categories</h4>
                  <p class="card-description">
                    Edit
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/categories/update" enctype="multipart/form-data" class="forms-sample">
                    <?php 
	                    if(!empty($sql)){
                        $result = [];
                        if ( $sql['parent_id'] > 0 ) {
                            $result[$sql['parent_id']] = $sql['parent_id'];
                        }
	                ?>    
                        <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                        <input type="hidden" name="id" value="<?php print my_encrypt($sql['id']);?>">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="cat_name" placeholder="Name" value="<?php print $sql['cat_name'];?>">
                    </div>
                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" name="description" placeholder="Description"><?php print $sql['description'];?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Meta keyword</label>
                      <textarea class="form-control" name="metakey" placeholder="Meta keyword"><?php print $sql['metakey'];?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="feInputState">Parent Categories</label>
                      <select name="parent_id" class="form-control">
                        <option value="0">---</option>
                        <?php getAdminDropDownCategorySelectedArray(buildTree($allcat),$result);?>
                      </select>
                    </div>
                    <div class="form-group">
                      <?php 
                          $brand_select = (new \App\Models\CategoriesModel())->getSelectBrand($sql['id']);
                      ?>
                      <label>Brands</label>
                      <select name="brands[]" class="form-control searchBrandFilter" multiple>
                          <?php 
                              if ( is_array($brand_select) && count($brand_select) > 0 ) {
                                  foreach ( $brand_select as $key => $value) {
                          ?>
                          <option value="<?php print $value['id'];?>" selected><?php print ucfirst($value['name']);?></option>
                          <?php
                                  }
                              }
                          ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <?php 
                          $attribute_select = (new \App\Models\CategoriesModel())->getSelectAttribute($sql['id']);
                      ?>
                      <label>Attributes</label>
                      <select name="attributes[]" class="form-control searchAttributesFilter" multiple>
                         <?php 
                              if ( is_array($attribute_select) && count($attribute_select) > 0 ) {
                                  foreach ( $attribute_select as $key => $value) {
                          ?>
                          <option value="<?php print $value['id'];?>" selected><?php print ucfirst($value['name_en']);?></option>
                          <?php
                                  }
                              }
                          ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="feInputState">Status</label>
                      <select name="status" class="form-control">
                        <option value="1"<?php if ( $sql['status'] == 1 ) { ?> selected<?php } ?>>Publish</option>
                        <option value="2"<?php if ( $sql['status'] == 2 ) { ?> selected<?php } ?>>Draft</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Category Icon</label>
                      <input type="file" name="cat_icon" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                      	<?php 
		    				if( ! empty( $sql['cat_icon'] ) ) { 
		    					$ext_name = explode('.',$sql['cat_icon']);
		    			?>
		    				<img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded mt-1" alt="" width="100">
		    			<?php } ?>
                    </div>
                    <div class="form-group">
                      <label>Category Banner</label>
                      <input type="file" name="catimg" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                      	<?php 
		    				if( ! empty( $sql['cat_img'] ) ) { 
		    					$ext_name = explode('.',$sql['cat_img']);
		    			?>
		    				<img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded mt-1" alt="" width="100">
		    			<?php } ?>
                    </div>
                	<input type="hidden" name="type" value="1"/>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" type="button" onclick="window.location.href='<?php print base_url().'/admincp/categories';?>'">Cancel</button>
                <?php } ?>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>