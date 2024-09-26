<?php print view('admin/header');?>

        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        

            <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0 float-start" style="padding-top: 8px;">Pages</h6>
                  <?php if ( $perm->addp == 1 ) { ?>
                    	<a href="<?php print base_url();?>/admincp/pages/add" class="btn btn-info btn-sm float-end">Add</a>
                	<?php } ?>
                  </div>
                  <div class="card-body p-0">

                  		<table class="table table-striped">
                  			<thead>
                  				<tr>
                  							<th width="50"><input type="checkbox" name=""></th>
                  							<th width="100"></th>
                  							<th>Name</th>
                            		<th>FeaturedImage</th>
                            		<th><?php //print langs('sidebar');?></th>
                            		<th>Status</th>
                            		<th></th>
                  					<th width="150"></th>
                  				</tr>
                  			</thead>
                  			<tbody>
                  			<?php 
                  				if(is_array($sql)){
                  					$sr = 1;
                  					foreach($sql as $row){
                  			?>
                  				<tr>
                  					<td><input type="checkbox" name=""></td>
                  					<td><?php print $sr;?></td>
                  					<td><?php print $row['title'];?></td>
                            <td>
                              <?php 
                                if( ! empty( $row['fimg'] ) ) { 
                                  $ext_name = explode('.',$row['fimg']);
                              ?>
                                <img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded" alt="" width="100">
                              <?php } else { ?>
                                <img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" class="border rounded" alt="" width="100">
                              <?php }?>
                            </td>
                  					<td><?php 
                  						// switch($row['sidebar']){
                  						// 	case 1:
                  						// 			print 'yes';
                  						// 		break;
                  						// 	case 2:
                  						// 			print 'No';
                  						// 		break;
                  						// }
                  						?>
                  					</td>
                  					<td><?php 
                  						switch($row['active']){
                  							case 1:
                  									print 'Active';
                  								break;
                  							case 2:
                  									print 'Draft';
                  								break;
                  							case 3:
                  									print 'Block';
                  								break;
                  						}
                  						?>
                  					</td>
                  					<td><?php print $row['created_at'];?></td>
				                    <td>
				                    <?php if ( $perm->editp == 1 ) { ?>  
				                      <a href="<?php print base_url().'/admincp/pages/edit/'.my_encrypt($row['id']);?>" class="mb-2 btn btn-sm btn-success mr-1">
				                        EDIT
				                      </a>
				                    <?php  } ?> 
				                    <?php if ( $perm->deletep == 1 ) { ?>
				                      <a href="<?php print base_url().'/admincp/pages/delete/'.my_encrypt($row['id']);?>" onclick="return confirm('Are you sure to delete this?');" class="mb-2 btn btn-sm btn-danger mr-1">
				                        DELETE
				                      </a>
				                    <?php  } ?> 
				                    </td>
                  				</tr>
                  			<?php
                  						$sr++;
                  					}
                  				}
                  			?>	
                  			</tbody>
                  		</table>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Default Light Table -->
<?php print view('admin/footer');?>