<?php print view('admin/header');?>
	
		<div class="row">
      <div class="col"><?php print show_message();?></div>
    </div>

    <div class="row">
        <div class="col">
          <div class="card card-small pt-3 pb-3 ps-3 pe-3 mb-4">
              <div class="input-group input-group-seamless ml-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-search"></i>
                  </div>
                </div>
                <input class="form-control" id="CustomerSearch" type="text" placeholder="Search Keyword..." aria-label="Search">
                <input type="hidden" id="customerSearchToken" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
              </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
          <div class="card card-small mb-4">
            <div class="card-header border-bottom">
              <h6 class="m-0 float-start" style="padding-top: 8px;">Stores</h6>
              <?php if ( $perm->addp == 1 ) { ?>
              	<a href="<?php print base_url();?>/admincp/vendors/add" class="btn btn-info btn-sm float-end">Add</a>
          	<?php } ?>
          	<div class="clearfix"></div>
            </div>
            <div class="card-body p-0">

            		<table class="table table-striped">
            			<thead>
            				<tr>
            					<th width="50"><input type="checkbox" name=""></th>
                          <th width="80"></th>
                          <th width="80"></th>
                          <th>Store Name</th>
                          <th>Store Email</th>
                          <th>Store Link</th>
                          <th>Total Products</th>
            							<th>Status</th>
            							<th width="150"></th>
            				</tr>
            			</thead>
            			<tbody id="customerListTable">
            			<?php 
            				if(is_array($vendors)){
            					$sr = 1;
            					foreach($vendors as $row){
            			?>
            				<tr>
            							<td><input type="checkbox" name=""></td>
                      		<td><?php print $row['id'];?></td>
                          <td class="lo-stats__image">
                          	<?php 
									    				if( ! empty( $row['store_logo'] ) ) { 
									    					$ext_name = explode('.',$row['store_logo']);
									    			?>
									    				<img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded" alt="">
									    			<?php } else { ?>
									    				<img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" class="border rounded" alt="">
									    			<?php }?>
                          </td>
                          <td><?php print $row['store_name'];?></td>
                          <td><?php print $row['email'];?></td>
                          <td><?php print $row['store_link'];?></td>
                          <td><?php print $row['total_products'];?></td>
			                    <td><?php print vendorStatus($row['status']);?></td>
			                    <td>
			                    <?php if ( $perm->editp == 1 ) { ?>  
                            <?php if ( $row['status'] == 1 || $row['status'] == 3 ) {?>
			                      <a href="<?php print base_url().'/admincp/vendors/activate/'.my_encrypt($row['id']);?>" class="mb-2 btn btn-sm btn-warning mr-1">
			                        Activate
			                      </a> 
                            <?php } else {?>
                            <a href="<?php print base_url().'/admincp/vendors/blocked/'.my_encrypt($row['id']);?>" class="mb-2 btn btn-sm btn-warning mr-1">
                              Block
                            </a> 
                            <?php }?>
			                      <a href="<?php print base_url().'/admincp/vendors/edit/'.my_encrypt($row['id']);?>" class="mb-2 btn btn-sm btn-success mr-1">
			                        Edit
			                      </a>
			                    <?php  } ?> 
			                    <?php if ( $perm->deletep == 1 ) { ?>
			                      <a href="<?php print base_url().'/admincp/vendors/delete/'.my_encrypt($row['id']);?>" onclick="return confirm('Are you sure to delete this?');" class="mb-2 btn btn-sm btn-danger mr-1">
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
          <?php if ( $total_result > 20 ) { ?>
            <div class="pagenation">
              <?php print $pager->makeLinks(1, 20, $total_result,'front_full') ?>
            </div>
          <?php } ?>
        </div>
      </div>

<script type="text/javascript">
  $(function(){
      $('#CustomerSearch').keyup(function(){
          var order_id = $(this).val();
          var customerSearchToken = $('#customerSearchToken').val();
          $.ajaxSetup({
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', customerSearchToken);
            }
          });
          $.ajax({
              url: '<?php print base_url().'/admincp/vendors/search?word=';?>'+order_id,
              type: 'GET',
              datatype: 'JSON',
              success: function(resp){
                var r = JSON.parse(resp);
                $('#customerSearchToken').val(r.token);
                $('#customerListTable').html(r.html);
              }
          });
      });


  });
</script>

<?php print view('admin/footer');?>