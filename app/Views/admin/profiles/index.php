<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        
        <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0 float-start" style="padding-top: 8px;">Profiles</h6>
                    <?php //if ( perm('categories')->addp == 1 ) { ?>
                    	<a href="<?php print base_url();?>/admincp/profiles/add" class="btn btn-info btn-sm float-end">Add</a>
                	<?php //} ?>
                	<div class="clearfix"></div>
                  </div>
                  <div class="card-body p-0">

                  		<table class="table table-striped">
                  			<thead>
                  				  <tr>
		                            <th>Name</th>
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
                            		<td><?php print $row['name_en'];?></td>
						                    <td>
						                    <?php //if ( perm('categories')->editp == 1 ) { ?>  
						                      <a href="<?php print base_url().'/admincp/profiles/edit/'.my_encrypt($row['id']);?>" class="mb-2 btn btn-sm btn-success mr-1">
						                        Edit
						                      </a>
						                    <?php  //} ?> 
						                    <?php //if ( perm('categories')->deletep == 1 ) { ?>
                                  <a href="<?php print base_url().'/admincp/profiles/delete/'.my_encrypt($row['id']);?>" onclick="return confirm('Are you sure to delete this?');" class="mb-2 btn btn-sm btn-danger mr-1">
                                    Delete
                                  </a>
                                  <a href="<?php print base_url().'/admincp/profiles/permissions/'.my_encrypt($row['id']);?>" class="mb-2 btn btn-sm btn-warning mr-1">
                                    Permissions
                                  </a>
						                    <?php  //} ?> 
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
                <?php //print $pager->links() ?>
              </div>
            </div>
<?php print view('admin/footer');?>