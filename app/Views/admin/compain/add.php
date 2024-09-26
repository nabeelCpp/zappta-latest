<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Campaign</h4>
                  <p class="card-description">
                    Add
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/compain/insert" enctype="multipart/form-data" class="forms-sample">
            		<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                    <div class="form-group">
                      <label>Campaign Name *</label>
                      <input type="text" class="form-control" name="compain_name" placeholder="Campaign Name" required>
                    </div>
                    <div class="form-group">
                      <label>Campaign Start Date *</label>
                      <input type="date" class="form-control" id="compain_s_date" onchange="fixededate()" min="<?php print date('Y-m-d');?>" name="compain_s_date" placeholder="Campaign Name" required>
                    </div>
                    <div class="form-group">
                      <label>Campaign End Date *</label>
                      <input type="date" class="form-control" id="compain_e_date" min="<?php print date('Y-m-d');?>" name="compain_e_date" placeholder="Campaign Name" required>
                    </div>
                    <div class="form-group">
                      <label>Campaign Detail</label>
                      <textarea class="form-control tinymce" name="compain_msg" placeholder="Campaign Detail"></textarea>
                      <small>This message ll be sent via email to all active vendors</small>
                    </div>
                    <div class="form-group">
                      <label>Campaign Terms</label>
                      <textarea class="form-control tinymce" name="compain_terms" placeholder="Campaign Terms"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                      <select name="status" class="form-control">
                        <option value="1" selected>Publish</option>
                        <option value="2">Draft</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Email Notify</label>
                      <select name="email_notify" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0" selected>No</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Notification</label>
                      <select name="notification" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0" selected>No</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" type="button" onclick="window.location.href='<?php print base_url().'/admincp/compain';?>'">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>

<script type="text/javascript">
  function fixededate()
  {
      var currentdate = $('#compain_s_date').val();
      $('#compain_e_date').attr('min',currentdate);
  }
</script>

<?php print view('admin/footer');?>