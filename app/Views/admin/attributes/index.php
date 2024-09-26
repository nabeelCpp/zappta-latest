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
                    <input class="form-control" id="BrandsSearch" type="text" placeholder="Search Keyword..." aria-label="Search">
                    <input type="hidden" id="customerSearchToken" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
                  </div>
              </div>
            </div>
        </div>

        <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0 float-start" style="padding-top: 8px;">Attributes</h6>
                    <?php if ( isset($perm->addp) && $perm->addp == 1 ) { ?>
                    	<a href="<?php print base_url();?>/admincp/attributes/add" class="btn btn-info btn-sm float-end">Add</a>
                	<?php } ?>
                	<div class="clearfix"></div>
                  </div>
                  <div class="card-body p-0">

                  		<table class="table table-striped">
                  			<thead>
                  				  <tr>
                  					    <th width="50"><input type="checkbox" name=""></th>
		                            <th width="80"></th>
                                <th>Name</th>
                                <th>Type</th>
		                            <th>Total Products</th>
                  					    <th width="150"></th>
                  				  </tr>
                  			</thead>
                  			<tbody id="customerListTable">
                  			<?php 
                  				if(is_array($sql)){
                            $attributesvalues = perm('attributesvalues');
                  					$sr = 1;
                  					foreach($sql as $row){
                  			?>
                  				<tr>
                  							<td><input type="checkbox" name=""></td>
                            		<td><?php print $row['id'];?></td>
                                <td><?php print $row['name_en'];?></td>
                                <td><?php print getAttributeType($row['opt']);?></td>
		                            <td><?php print $row['total_items'];?></td>
						                    <td>
						                    <?php if ( isset($perm->editp) && $perm->editp == 1 ) { ?>  
						                      <a href="<?php print base_url().'/admincp/attributes/edit/'.my_encrypt($row['id']);?>" class="mb-2 btn btn-sm btn-success mr-1">
						                        Edit
						                      </a>
						                    <?php  } ?> 
						                    <?php if ( isset($perm->deletep) && $perm->deletep == 1 ) { ?>
						                      <a href="<?php print base_url().'/admincp/attributes/delete/'.my_encrypt($row['id']);?>" onclick="return confirm('Are you sure to delete this?');" class="mb-2 btn btn-sm btn-danger mr-1">
						                        Delete
						                      </a>
						                    <?php  } ?> 
                                <?php if ( isset($attributesvalues->allview) && $attributesvalues->allview == 1 && $attributesvalues->view == 1 ) { ?>  
                                  <a href="<?php print base_url().'/admincp/attributes/values/'.my_encrypt($row['id']).'?type='.$row['opt'];?>" class="mb-2 btn btn-sm btn-warning mr-1">
                                    Values
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
      $('#BrandsSearch').keyup(function(){
          var order_id = $(this).val();
          var customerSearchToken = $('#customerSearchToken').val();
          $.ajaxSetup({
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', customerSearchToken);
            }
          });
          $.ajax({
              url: '<?php print base_url().'/admincp/attributes/search?word=';?>'+order_id,
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