<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Attributes</h4>
                  <p class="card-description">
                    Edit
                  </p>
                  <form method="post" action="<?php print base_url();?>/admincp/attributes/update" enctype="multipart/form-data" class="forms-sample">
                    <?php 
	                    if(!empty($sql)){
                        $result = [];
                        if ( is_array($sql['categories']) && count($sql['categories']) > 0) {
                            foreach( $sql['categories'] as $value ) {
                                $result[$value['attr_cat']] = $value['attr_cat'];
                            }
                        }
	                ?>    
                        <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                        <input type="hidden" name="id" value="<?php print $ids;?>">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name_en" placeholder="Name" value="<?php print $sql['name_en'];?>">
                    </div>
                    <div class="form-group">
                        <label>Attribute type</label>
                        <select name="opt" class="form-control">
                              <option value="1"<?php if( $sql['opt'] == 1 ) { ?> selected<?php } ?>>Size</option>
                              <option value="2"<?php if( $sql['opt'] == 2 ) { ?> selected<?php } ?>>Color</option>
                              <option value="3"<?php if( $sql['opt'] == 3 ) { ?> selected<?php } ?>>Dimension</option>
                              <option value="4"<?php if( $sql['opt'] == 4 ) { ?> selected<?php } ?>>Paper Type</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="feInputState">Categories</label>
                        <select class="js-example-basic-single w-100" name="category_id[]" multiple="multiple">
                        <?php getAdminDropDownCategorySelectedArray(buildTree($allcat),$result);?>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light" onclick="window.location.href='<?php print base_url().'/admincp/attributes';?>'">Cancel</button>
                <?php } ?>
                  </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>