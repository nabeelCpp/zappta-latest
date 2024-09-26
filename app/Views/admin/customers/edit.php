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
                    Edit
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/vendors/update" enctype="multipart/form-data" class="forms-sample">
            <?php 
                if ( !empty($users) ) {
            ?>
                    <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                    <input type="hidden" name="_id" value="<?php print my_encrypt($users['id']); ?>" />
                    <div class="form-group">
                      <label>Name *</label>
                      <input type="text" class="form-control" name="store_name" placeholder="Name" value="<?php print $users['store_name'];?>" required>
                    </div>

                    <div class="form-group">
                      <label>Store Email</label>
                      <input type="email" class="form-control" placeholder="Store Email" value="<?php print $users['email'];?>" disabled>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>

                    <div class="form-group">
                      <label>Store Link</label>
                      <input type="text" class="form-control" name="store_link" placeholder="Store Link" value="<?php print $users['store_link'];?>">
                    </div>
                    <div class="form-group">
                      <label>Order Email</label>
                      <input type="email" class="form-control" name="store_order_email" placeholder="Order Email" value="<?php print $users['store_order_email'];?>">
                    </div>
                    <div class="form-group">
                      <label>PayPal Email</label>
                      <input type="email" class="form-control" name="paypal_email" placeholder="PayPal Email" value="<?php print $users['paypal_email'];?>">
                    </div>

                    <div class="form-group">
                      <label>Store Logo</label>
                      <input type="file" name="store_logo" class="file-upload-default" accept=".jpg,.jpeg,.png">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                      <small class="required">Maximum size 300px / 300px ( File format must be JPEG, PNG )</small>
                      <p class="mt-2">
                      <?php 
                        if( ! empty( $users['store_logo'] ) ) { 
                          $ext_name = explode('.',$users['store_logo']);
                      ?>
                        <img width="80" src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded" alt="">
                      <?php } ?>
                      </p>
                    </div>
                    <div class="form-group">
                      <label for="feInputState">Status</label>
                      <select name="status" class="form-control">
                        <option value="2"<?php if ( $users['status'] == 2 ) {?> selected<?php } ?>>Active</option>
                        <option value="3"<?php if ( $users['status'] == 3 ) {?> selected<?php } ?>>Blocked</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" type="button" onclick="window.location.href='<?php print base_url().'/admincp/vendors';?>'">Cancel</button>
              <?php } ?>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>