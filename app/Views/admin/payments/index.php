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
                    <h6 class="m-0 float-start" style="padding-top: 8px;">Payments</h6>
                                 	<div class="clearfix"></div>
                  </div>
                  <div class="card-body p-0">

                  		<table class="table table-striped">
                  			<thead>
                  				<tr>
                  					
		                            <th width="80"></th>
		                            <th>Store</th>
		                            <th>Sale($)</th>
		                            <th>Zappta Commission($)</th>
		                            <!-- <th>Give away</th> -->
		                            <th>Orders</th>
		                            <th>Payment($)</th>
		                            
                  					<th width="150"></th>
                  				</tr>
                  			</thead>
                  			<tbody id="customerListTable">
                  			<?php 	
   //                			echo '<pre>';
	 	// print_r($payments);
	 	// echo '</pre>';
                  			foreach($payments as $payment){
                  				$commision = number_format($payment['total']*$app_commision/100, 2);
	 	  ?>
                  				<tr>
                  					
		                            <td class="lo-stats__image">
		                            	
		                            	    	<?php 
									    				if( ! empty( $payment['store_logo'] ) ) { 
									    					$ext_name = explode('.',$payment['store_logo']);
									    			?>
									    				<img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/100';?>" class="border rounded" alt="">
									    			<?php } else { ?>
									    				<img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" class="border rounded" alt="">
									    			<?php }?>

		                            </td>
		                            <td><?php print $payment['store_name'];?></td>
		                            <td><?=number_format($payment['total']-$commision, 2)?></td>
		                            <td><?=$commision?></td>
		                            <!-- <td>4</td> -->
		                            <td><?=(new App\Models\OrderModel)->countOrdersPerStore($payment['id'])?></td>
				                    <td><?=number_format($payment['total'], 2)?></td>
				                	</tr>
				                <?php } ?>
                  			</tbody>
                  		</table>

                  </div>
                </div>
                          </div>
            </div>



<?php print view('admin/footer');?>