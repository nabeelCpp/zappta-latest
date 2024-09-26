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
                    Add
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/categories/insert" enctype="multipart/form-data" class="forms-sample">
            		<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="cat_name" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" name="description" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Meta keyword</label>
                      <textarea class="form-control" name="metakey" placeholder="Meta keyword"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="feInputState">Parent Categories</label>
                      <select name="parent_id" class="form-control">
                        <option value="0">---</option>
                        <?php getAdminDropDownCategorySelectedArray(buildTree($allcat));?> 
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Brands</label>
                      <select name="brands[]" class="form-control searchBrandFilter" multiple></select>
                    </div>
                    <div class="form-group">
                      <label>Attributes</label>
                      <select name="attributes[]" class="form-control searchAttributesFilter" multiple></select>
                    </div>
                    <div class="form-group">
                      <label for="feInputState">Status</label>
                      <select name="status" class="form-control">
                        <option value="1" selected>Publish</option>
                        <option value="2">Draft</option>
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
                    </div>
                	   <input type="hidden" name="type" value="1"/>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" type="button" onclick="window.location.href='<?php print base_url().'/admincp/categories';?>'">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>