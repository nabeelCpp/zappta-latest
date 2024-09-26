<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        

            <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0 float-start" style="padding-top: 8px;">Terms</h6>
                  <?php if ( $perm->addp == 1 ) { ?>
                    	<a href="<?php print base_url();?>/admincp/terms/add" class="btn btn-info btn-sm float-end">Add</a>
                	<?php } ?>
                  </div>
                  <div class="card-body p-0">
                  		<table class="table table-striped">
					        <thead>
					            <tr>
					            		<th></th>
					                <th>Name</th>
					                <th width="15%"></th>
					            </tr>
					        </thead>
					        <tbody>
					        <?php 
					        	if(is_array($sql) && count($sql)) {
					        		$sr = 1;
					        		foreach ( $sql as $row ) {
					        ?>
					        	<tr>
					        		<td><?php print $sr;?></td>
					        		<td><?php print $row['name'];?></td>
					        		<td>
					        		<?php if ($perm->addp == 1 ) { ?>	
					        			<a href="<?php print base_url().'/admincp/terms/faqanswer/'.my_encrypt($row['id']);?>" class="btn btn-sm btn-info">
					        				Answer
					        			</a>
					        		<?php  } ?>	
					        		<?php if ( $perm->editp == 1 ) { ?>	
					        			<a href="<?php print base_url().'/admincp/terms/edit/'.my_encrypt($row['id']);?>" class="btn btn-sm btn-success">
					        				EDIT
					        			</a>
					        		<?php  } ?>	
					        		<?php if ( $perm->addp == 1 ) { ?>
					        			<a href="<?php print base_url().'/admincp/terms/delete/'.my_encrypt($row['id']);?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-sm btn-danger">
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