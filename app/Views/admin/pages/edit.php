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
                  <h4 class="card-title">Page</h4>
        <form method="post" action="<?php print base_url();?>/admincp/pages/update" enctype="multipart/form-data">
        <?php 
              if(!empty($sql)){
          ?>
          <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
            <input type="hidden" name="id" value="<?php print my_encrypt($sql['id']);?>">
            <div class="row">

              <div class="col-8">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0 float-left">Edit</h6>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col"> 

                            
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" value="<?php print $sql['title'];?>" >
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <!-- <textarea class="form-control tinymce" rows="20" name="description" placeholder="Description" style="width:100%;height:400px;"><?php //print html_entity_decode($sql['content']);?></textarea> -->
                                    <textarea class="tinymce form-control" name="description"><?php print html_entity_decode($sql['content']);?></textarea>
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Metakey</label>
                                    <textarea class="form-control" name="metakey" placeholder="Metakey"><?php print html_entity_decode($sql['metakeyword']);?></textarea>
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Meta Description</label>
                                    <textarea class="form-control" name="metadesc" placeholder="Meta Description"><?php print html_entity_decode($sql['metadescp']);?></textarea>
                                  </div>
                                </div>




                        </div>
                      </div>
                    </li>
                  </ul>
                </div>

                
                

              </div>


              <div class="col-4">


                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0 float-left">Status</h6>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col"> 
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary">Add</button>
                              <div style="clear:both;"></div>
                            </div>
                            <div class="form-group">
                              <div class="custom-control custom-radio mb-1">
                                <input type="radio" id="formsRadioActive" name="status"value="1" class="custom-control-input" <?php if($sql['active'] == 1){?> checked<?php }?>>
                                <label class="custom-control-label" for="formsRadioActive">Active</label>
                              </div>
                              <div class="custom-control custom-radio mb-1">
                                <input type="radio" id="formsRadioDraft" name="status"value="2" class="custom-control-input"<?php if($sql['active'] == 2){?> checked<?php }?>>
                                <label class="custom-control-label" for="formsRadioDraft">Draft</label>
                              </div>
                              <div class="custom-control custom-radio mb-1">
                                <input type="radio" id="formsRadioBlock" name="status"value="3" class="custom-control-input"<?php if($sql['active'] == 3){?> checked<?php }?>>
                                <label class="custom-control-label" for="formsRadioBlock">Block</label>
                              </div>
                            </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
  

                
  
                <div class="card card-small mb-4">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col"> 
                            <div class="input-group mb-3">
                                <div id="Pagedraganddropzone" class="dm-uploader p-5" style="width:100%;text-align: center;">
                                  <h3 class="mb-5 mt-5 text-muted">Featured Image </h3>
                                  <div class="btn btn-primary btn-block mb-5">
                                      <input type="file" name="fimg" title='Click to add Files'/>
                                  </div>
                                  <?php 
                                    if( ! empty( $sql['fimg'] ) ) { 
                                      $ext_name = explode('.',$sql['fimg']);
                                  ?>
                                    <img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded" alt="" width="100">
                                  <?php } else { ?>
                                    <img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" class="border rounded" alt="" width="100">
                                  <?php }?>
                                </div>
                            </div>

                        </div>
                      </div>
                    </li>
                  </ul>
                </div>

              </div>

              

            </div>
    <?php } ?>
          </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>