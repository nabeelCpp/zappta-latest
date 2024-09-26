<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Profiles</h4>
                  <p class="card-description">
                    Add
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/profiles/insert" class="forms-sample">
            		    <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                    <input type="hidden" name="id" value="0" />
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name_en" placeholder="Name">
                      <?php (session()->has('validation') && session('validation')->hasError('name_en'))?>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" onclick="window.location.href='<?php print base_url().'/admincp/profiles';?>'">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>