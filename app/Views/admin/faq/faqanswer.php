<?php print view('admin/header');?>
	
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        

            <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0 float-start" style="padding-top: 8px;">Faq`s Answer</h6>
                  <?php if ( $perm->addp == 1 ) { ?>
                    	<a href="<?php print base_url();?>/admincp/faq/faqadd/<?php print $faq_id;?>" class="btn btn-info btn-sm float-end">Add</a>
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
								        		<td><?php print short($row['answer'],100);?></td>
								        		<td>
								        		<?php if ( $perm->editp == 1 ) { ?>	
								        			<a href="<?php print base_url().'/admincp/faq/faqedit/'.my_encrypt($row['id']).'/'.$faq_id;?>" class="btn btn-sm btn-success">
								        				Edit
								        			</a>
								        		<?php  } ?>	
								        		<?php if ( $perm->addp == 1 ) { ?>
								        			<a href="<?php print base_url().'/admincp/faq/faqdelete/'.my_encrypt($row['id']).'/'.$faq_id;?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-sm btn-danger">
								        				Delete
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