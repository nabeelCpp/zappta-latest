<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col-md-12">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Terms</h4>
                  <p class="card-description">
                    Add
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/terms/insert" enctype="multipart/form-data" class="forms-sample">
            		<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" type="button" onclick="window.location.href='<?php print base_url().'/admincp/terms';?>'">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>