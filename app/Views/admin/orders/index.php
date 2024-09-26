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
                    <h6 class="m-0 float-start" style="padding-top: 8px;">Orders</h6>
                	<div class="clearfix"></div>
                  </div>
                  <div class="card-body p-0">

                  		<table class="table table-striped">
                  			<thead>
                  				<tr>
                  					<th width="50"><input type="checkbox" name=""></th>
		                            <th width="80">Order #</th>
                                <th>Name</th>
		                            <th>Email</th>
                                <th>Phone</th>
                                <th>Total Amount</th>
                                <th>Payment Method</th>
                                <th>Total Items</th>
                                <!-- <th>Total Stores</th> -->
                  					<th width="150"></th>
                  				</tr>
                  			</thead>
                  			<tbody id="customerListTable">
                  			<?php 
                  				if(is_array($sql)){
                  					$sr = 1;
                  					foreach($sql as $row){
                  			?>
                  				<tr>
                  							<td><input type="checkbox" name=""></td>
                            		<td><?php print $row['order_serial'];?></td>
                                <td><?php print $row['username'];?></td>
		                            <td><?php print $row['email'];?></td>
                                <td><?php print $row['phone'];?></td>
                                <td><?php print $row['total_amount'];?></td>
                                <td><?php print $row['payment_method'];?></td>
                                <td><?php print $row['total_orders'];?></td>
                                <!-- <td><?php print $row['total_stores'];?></td> -->
						                    <td>
						                    <?php if ( $perm->view == 1 ) { ?>  
						                      <a href="<?php print base_url().'/admincp/orders/view/'.my_encrypt($row['id']);?>" class="mb-2 btn btn-sm btn-success mr-1">
						                        View
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
              url: '<?php print base_url().'/admincp/orders/search?word=';?>'+order_id,
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