<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Store</h4>
                  <p class="card-description">
                    Add
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/vendors/insert" enctype="multipart/form-data" class="forms-sample">
            		<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                    <div class="form-group">
                      <label>Name *</label>
                      <input type="text" class="form-control" name="store_name" placeholder="Name" required>
                    </div>

                    <div class="form-group">
                      <label>Store Email *</label>
                      <input type="email" class="form-control" name="email" placeholder="Store Email" required>
                    </div>
                    <div class="form-group">
                      <label>Password *</label>
                      <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                      <label>Store Link</label>
                      <input type="text" class="form-control" name="store_link" placeholder="Store Link">
                    </div>
                    <div class="form-group">
                      <label>Order Email</label>
                      <input type="email" class="form-control" name="store_order_email" placeholder="Order Email">
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Earn Zappta</label>
                          <input type="number" min="0" class="form-control" name="earn_zappta" placeholder="Earn Zappta">
                        </div>
                        <div class="col-md-6">
                          <label>Per Dollar</label>
                          <input type="number" min="0" class="form-control" name="per_dollar" placeholder="Per Dollar">
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label>PayPal Email</label>
                      <input type="email" class="form-control" name="paypal_email" placeholder="PayPal Email">
                    </div>

                    <div class="form-group">
                      <label>Store Logo</label>
                      <input type="file" name="store_logo" class="file-upload-default" accept=".jpg,.jpeg,.png" onchange="checkImageDimensions(this)" data-type="store_logo">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image" id="store_logo_text_field">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                      <small class="required">Maximum size 300px / 300px ( File format must be JPEG, PNG )</small>
                    </div>
                    <div class="form-group">
                      <label for="feInputState">Status</label>
                      <select name="status" class="form-control">
                        <option value="2" selected>Active</option>
                        <option value="3">Blocked</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" type="button" onclick="window.location.href='<?php print base_url().'/admincp/vendors';?>'">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>