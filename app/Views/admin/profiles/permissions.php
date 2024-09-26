<?php print view('admin/header');?>

<script type="text/javascript">

    function checkallinput(Allcheckall)
    {
        if ( $('#'+Allcheckall).is(":checked") ) {
          $("."+Allcheckall).each(function() {
            this.checked=true;
          })              
        } else {
          $("."+Allcheckall).each(function() {
            this.checked=false;
          })              
        }
    }

    function checksingle(Allcheckall,checkSingle)
    {
        if ($("."+Allcheckall).is(":checked")) {
          var isAllChecked = 0;
          $(".checkSingle").each(function(){
            if(!this.checked)
               isAllChecked = 1;
          })              
          if(isAllChecked == 0){ $("#"+Allcheckall).prop("checked", true); }     
        }else {
          $("#"+Allcheckall).prop("checked", false);
        }
    }

</script>
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Permission</h4>
                  
                  <form class="form form-horizontal" method="post" action="<?php print base_url().'/admincp/profiles/permission_update';?>">
                        <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                        <input type="hidden" name="hid" value="<?php print $row_id;?>"/>
                          <table class="table table-striped table-hover">
                                <thead class="block-fluid">
                                    <tr>
                                        <th width="48%">Name</th>
                                        <th width="10%">Add <input type="checkbox" class="check" onchange="checkallinput('Addcheckall');" id="Addcheckall"></th>
                                        <th width="10%">Edit <input type="checkbox" class="check" onchange="checkallinput('Editcheckall');" id="Editcheckall"></th>
                                        <th width="10%">View <input type="checkbox" class="check" onchange="checkallinput('Viewcheckall');" id="Viewcheckall"></th>
                                        <th width="10%">Delete <input type="checkbox" class="check" onchange="checkallinput('Deletecheckall');" id="Deletecheckall"></th>
                                        <th width="12%">View All <input type="checkbox" class="check" onchange="checkallinput('Allcheckall');" id="Allcheckall"></th>
                                    </tr>
                                </thead>
                            <tbody class="block-fluid">
                            <?php 
                              $insert = 0;
                                    $view = 0;
                                    $edit = 0;
                                    $delete = 0; 
                                    $viewall = 0;
                                    if ( is_array($roles) && count($roles) ) {
                                      foreach($roles as $roles_row){ 
                                        if ( is_array($roletype) && count($roletype) ) {
                                          foreach($roletype as $rows){
                                                  if($rows['pright'] ==  $roles_row['rights']){
                                                      $insert = $rows['addp'];
                                                      $edit = $rows['editp'];
                                                      $view = $rows['view'];
                                                      $delete = $rows['deletep'];
                                                      $viewall = $rows['allview'];
                                                  }
                                              }
                                          }
                              ?>
                                    <tr class="form-group">
                                        <td><?php echo $roles_row['name'];?></td>
                                        <td>
                                            <div class="form-checkss">
                                                <label class="form-check-labelss">
                                                    <input type="checkbox" name="<?php echo $roles_row['rights'];?>[addp]" value="1" <?php if($insert == 1){?> checked="checked" <?php } ?> class="form-check-input Addcheckall checkSingle"/>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-checks">
                                                <label class="form-check-labelss">
                                                    <input type="checkbox" name="<?php echo $roles_row['rights'];?>[editp]" value="1" <?php if($edit == 1){?> checked="checked" <?php } ?> class="ace-checkbox-2 Editcheckall"/>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-checks">
                                                <label class="form-check-labels">
                                                    <input type="checkbox" name="<?php echo $roles_row['rights'];?>[view]" value="1" <?php if($view == 1){?> checked="checked" <?php } ?> class="ace-checkbox-2 Viewcheckall"/>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-checks">
                                                <label class="form-check-labels">
                                                    <input type="checkbox" name="<?php echo $roles_row['rights'];?>[deletep]" value="1" <?php if($delete == 1){?> checked="checked" <?php } ?> class="ace-checkbox-2 Deletecheckall"/>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-checks">
                                                <label class="form-check-labels">
                                                    <input type="checkbox" name="<?php echo $roles_row['rights'];?>[allview]" value="1" <?php if($viewall == 1){?> checked="checked" <?php } ?> class="ace-checkbox-2 Allcheckall"/>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                                  
                              <?php
                                          $insert = 0;
                                            $view = 0;
                                            $edit = 0;
                                            $delete = 0; 
                                            $viewall = 0; 
                                      }
                                    }
                            ?>  
                                </tbody>
                            </table>
                            <div class="form-row">
                                <button type="submit" class="mb-2 btn btn-success mr-2">Update</button>
                            </div>
                        </form>

                </div>
              </div>
            </div>
        </div>

<?php print view('admin/footer');?>