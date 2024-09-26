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
                    Edit
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/profiles/insert" class="forms-sample">
                  <?php 
                    if ( !empty($sql) ) {
                  ?>
                    <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                    <input type="hidden" name="id" value="<?php print $sql['id']; ?>" />
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name_en" placeholder="Name" value="<?php print $sql['name_en'];?>">
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" onclick="window.location.href='<?php print base_url().'/admincp/profiles';?>'">Cancel</button>
                  <?php 
                    }
                  ?>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>