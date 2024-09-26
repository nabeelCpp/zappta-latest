<?php print view('admin/header');?>
	
		<div class="row">
      <div class="col"><?php print show_message();?></div>
    </div>

    <div class="row">
        <div class="col">
          <div class="card card-small mb-4">
            <div class="card-header border-bottom">
              <h6 class="m-0 float-start" style="padding-top: 8px;">Emails</h6>
          	<div class="clearfix"></div>
            </div>
            <div class="card-body p-0">

     <!--        		<table class="table table-striped">
            			<thead>
            				<tr>
                          <th width="80"></th>
                          <th>Emails</th>
            				</tr>
            			</thead>
            			<tbody id="customerListTable">
            			//<?php 
            				if(is_array($sql)){
            					$sr = 1;
            					foreach($sql as $row){
            			?>
            				<tr>
                      		<td><?php print $row['id'];?></td>
                          <td><?php print $row['email'];?></td>
            				</tr>
            			<?php
            						$sr++;
            					}
            				}
            			?>	
            			</tbody>
            		</table>

 -->
                 <form class="mt-3 ml-3" action="<?php print base_url().route_to('admin.send.email');?>" method="POST">
                  <div class="form-group">
                    <label for="exampleFormControlInput1" style="margin-left:30px;">Select Email address</label>
                      <select style="margin-left:30px; width: 800px;" name="emails"  class="form-control" id="exampleFormControlSelect1">
                        <?php   foreach($sql as $row) {?>
                      <option value="<?php print $row['email'];?>"><?php print $row['email'];?></option>
                       <?php  }?>
                        <?php   foreach($vendorEmails as $row) {?>
                      <option value="<?php print $row['email'];?>"><?php print $row['email'];?></option>
                       <?php  }?>
                    </select>
                  </div>
                  <div class="form-group">
                     <label for="subject" style="margin-left:30px;">Subject</label>
                    <input type="text" style="margin-left:30px; width: 800px;" name="subject" class="form-control" id="subject" >
                  </div>
                     <div class="form-group">
                     <label for="body" style="margin-left:30px;">Body</label>
                        <textarea class="form-control" style="margin-left:30px; width: 800px;" name="emailbody" id="body" rows="8"></textarea>

                  </div>
                  <input type="hidden" id="_vendor_login_token" name="<?php echo csrf_token() ?>" value="<?php print csrf_hash() ?>">
                  <div class="form-group">
                    <button style="margin-left:30px; width: 800px;" type="submit" name="submit"  class="btn btn-primary">Send Email</button>
                  </div>


                 
                  
                </form>

            </div>
          </div>
          <?php if ( $total_result > 20 ) { ?>
            <div class="pagenation">
              <?php print $pager->makeLinks(1, 20, $total_result,'front_full') ?>
            </div>
          <?php } ?>
        </div>
      </div>


<?php print view('admin/footer');?>