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
        <form method="post" action="<?php print base_url();?>/admincp/pages/insert" enctype="multipart/form-data">
          <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
            <div class="row">

              <div class="col-8">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0 float-left">Add</h6>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col"> 

                            
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" value="" >
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <textarea class="form-control tinymce" rows="20" name="description" placeholder="Description" style="width:100%;height:400px;"></textarea>
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Metakey</label>
                                    <textarea class="form-control" name="metakey" placeholder="Metakey"></textarea>
                                  </div>
                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Meta Description</label>
                                    <textarea class="form-control" name="metadesc" placeholder="Meta Description"></textarea>
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
                                <input type="radio" id="formsRadioActive" name="status"value="1" class="custom-control-input" checked>
                                <label class="custom-control-label" for="formsRadioActive">Active</label>
                              </div>
                              <div class="custom-control custom-radio mb-1">
                                <input type="radio" id="formsRadioDraft" name="status"value="2" class="custom-control-input">
                                <label class="custom-control-label" for="formsRadioDraft">Draft</label>
                              </div>
                              <div class="custom-control custom-radio mb-1">
                                <input type="radio" id="formsRadioBlock" name="status"value="3" class="custom-control-input">
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
                                </div>
                            </div>

                            <!-- Debug item template -->
                            <script type="text/html" id="debug-template">
                              <li class="list-group-item text-%%color%%"><strong>%%date%%</strong>: %%message%%</li>
                            </script>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>

              </div>

              

            </div>

          </form>
                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>