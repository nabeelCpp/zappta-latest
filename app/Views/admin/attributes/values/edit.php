<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Attributes Values</h4>
                  <p class="card-description">Edit</p>
                  <form method="post" action="<?php print base_url();?>/admincp/attributes/valuesupdate" enctype="multipart/form-data" class="forms-sample">
            <?php 
                if ( !empty($sql) ) {
            ?>		    
                        <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                        <input type="hidden" name="attr_id" value="<?php print $attr_id;?>" />
                        <input type="hidden" name="value_id" value="<?php print $value_id;?>" />
                        <input type="hidden" name="value_opt" value="<?php print $type;?>" />
                        <div class="form-group">
                            <label>Value Name</label>
                            <input type="text" class="form-control" name="name_en" value="<?php print $sql['name_en'];?>" placeholder="Name">
                        </div>
                    <?php if ( isset($type) && $type == 2 ) { ?>
                        <div id="color_value" class="d-block">
                            <div class="form-group form-field position-relative">
                                <label>Color Code</label>
                                <div class="field-input">
                                    <input type='text' name="color_code" class="color-picker" value="#<?php print $sql['color_code'];?>" />
                                </div>
                            </div>
                            <div class="form-group">
                              <label>Texture</label>
                              <input type="file" name="fimg" class="file-upload-default" id="fileupoad" onchange="getFilename('fileupoad','filename');" accept=".jpg,.jpeg,.png">
                              <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" id="filename" disabled placeholder="Upload Image">
                                <span class="input-group-append">
                                  <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                              </div>
                                <div class="clearfix"></div>
                                <input type="hidden" name="filenamevalue" value="" />
                                <?php if( !empty( $sql['value_img']) ) { ?>
                                <input type="hidden" name="filenamevalue" id="filenamevalue" value="<?php print $sql['value_img'];?>" />
                                <div class="attr_value_img position-relative" id="attr_value_img_block">
                                    <?php $value_img_ext = explode('.', $sql['value_img']);?>
                                    <img src="<?php print base_url().'/images/media/'.$sql['value_img'].'/'.end($value_img_ext).'/100';?>" alt="" style="width:50px;height:50px;border:1px solid #CCCCCC;border-radius: 5px;object-fit: cover;object-position: center;">
                                    <span class="remove_icon position-absolute" onclick="delete_attr_img('<?php print my_encrypt($sql['id']);?>')"><i class="fa-regular fa-trash-can"></i></span>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    <?php } ?>

                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" type="button" onclick="window.location.href='<?php print base_url().'/admincp/attributes/values/'.$attr_id.'?type='.$type;?>'">Cancel</button>
            <?php } ?>      
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>