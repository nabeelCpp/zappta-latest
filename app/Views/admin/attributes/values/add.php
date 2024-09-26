<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Attributes Values</h4>
                  <p class="card-description">Add</p>
                  <form method="post" action="<?php print base_url();?>/admincp/attributes/valuesinsert" enctype="multipart/form-data" class="forms-sample">
            		    <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                        <input type="hidden" name="attr_id" value="<?php print $attr_id;?>" />
                        <input type="hidden" name="value_opt" value="<?php print $type;?>" />
                        <div class="form-group">
                            <label>Value Name</label>
                            <input type="text" class="form-control" name="name_en" placeholder="Name">
                        </div>
                    <?php if ( isset($type) && $type == 2 ) { ?>
                        <div id="color_value" class="d-block">
                            <div class="form-field position-relative">
                                <label>Color Code</label>
                                <div class="field-input">
                                    <input type='text' name="color_code" class="color-picker" value="#000000" />
                                </div>
                                <!-- <button type="button" class="btn color_btn position-absolute jscolor {valueElement:'chosen-value', onFineChange:'setTextColor(this)'}">
                                    <i class="fa-solid fa-palette"></i>
                                </button> -->
                            </div>
                            <div class="form-group">
                                <label>Texture</label>
                                <input type="file" class="file-upload-default" onchange="getFilename('fileupoad','filename');" name="fimg"  accept=".jpg,.jpeg,.png">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                                <small>Maximum size 200px / 200px ( File format must be JPEG, PNG )</small>
                            </div>
                        </div>
                    <?php } ?>

                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" type="button" onclick="window.location.href='<?php print base_url().'/admincp/attributes/values/'.$attr_id.'?type='.$type;?>'">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>