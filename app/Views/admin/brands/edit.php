<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Brands</h4>
                  <p class="card-description">
                    Edit
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/brands/update" enctype="multipart/form-data" class="forms-sample">
                    <?php 
	                    if(!empty($sql)){
	                ?>    
                        <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                        <input type="hidden" name="id" value="<?php print my_encrypt($sql['id']);?>">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Name" value="<?php print $sql['name'];?>">
                    </div>
                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" name="description" placeholder="Description"><?php print $sql['description'];?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="feInputState">Categories</label>
                      <select name="category_id" class="form-control">
                        <?php getDropDownCategory(buildTree($allcat),$sql['bcat']);?>
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
                      <label>Brand Icon</label>
                      <input type="file" name="logo" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                      <?php 
        		    				if( ! empty( $sql['logo'] ) ) { 
        		    					$ext_name = explode('.',$sql['logo']);
        		    			?>
		    				          <img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded mt-1" alt="" width="100">
	    			          <?php } ?>
                    </div>
                    <div class="form-group">
                      <label>Brand Banner</label>
                      <input type="file" name="brand_banner" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                      <?php 
        		    				if( ! empty( $sql['brand_banner'] ) ) { 
        		    					$ext_name = explode('.',$sql['brand_banner']);
        		    			?>
		    				          <img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded mt-1" alt="" width="100">
	    			          <?php } ?>
                    </div>
                	<input type="hidden" name="type" value="1"/>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" type="button" onclick="window.location.href='<?php print base_url().'/admincp/brands';?>'">Cancel</button>
                <?php } ?>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>