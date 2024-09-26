<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Attributes</h4>
                  <p class="card-description">Add</p>
                  <form method="post" action="<?php print base_url();?>/admincp/attributes/insert" enctype="multipart/form-data" class="forms-sample">
            		    <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name_en" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label>Attribute type</label>
                        <select name="opt" class="form-control">
                              <option value="1">Size</option>
                              <option value="2">Color</option>
                              <option value="3">Dimension</option>
                              <option value="4">Paper Type</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="js-example-basic-single w-100" name="category_id[]" multiple="multiple">
                        <?php getAdminDropDownCategorySelectedArray(buildTree($allcat));?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" onclick="window.location.href='<?php print base_url().'/admincp/attributes';?>'">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>