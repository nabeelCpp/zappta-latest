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
                  <h4 class="card-title">Faq Answer</h4>
                  <p class="card-description">
                    Edit
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/faq/faqupdate" enctype="multipart/form-data" class="forms-sample">
          <?php 
             if(!empty($sql)){ 
          ?> 
            		<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                            <input type="hidden" name="faq_heading_id" value="<?php print $faq_id; ?>" />
                            <input type="hidden" name="id" value="<?php print $faq_head_id; ?>" />
                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control tinymce" rows="20" name="short" placeholder="Description" style="width:100%;height:200px;"><?php print html_entity_decode($sql['answer']);?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" type="button" onclick="window.location.href='<?php print base_url().'/admincp/faq';?>'">Cancel</button>
        <?php } ?>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>