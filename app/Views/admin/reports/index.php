<?php print view('admin/header');?>
<?php 	$total = 0; 
                  			foreach($payments as $payment){
                  				$total += $payment['total'];
                  			}

                  			
	 	  
?>
<style type="text/css">
	.card{
		background-color: none;
	}
</style>
		
        <div class="row">
          <div class="col"><?php print show_message();?></div>
        </div>

        <div class="row">
            <div class="col">
              <div class="card card-small pt-3 pb-3 ps-3 pe-3 mb-4" style="background-color: none;">
              	<!-- <div class="row">
              		<div class="col-md-8"> -->
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
			                 <!--  <div class="col-md-4">
						            		<div class=" pt-3 pb-3 ps-3 pe-3 mb-4">
						            	   <h6 >Total = <?= $total; ?></h6>
						                </div>
						            </div> -->
                <!-- </div>
              </div> -->
            </div>
          
        </div>

        <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0 float-start" style="padding-top: 8px;"><b>Sales Report</b></h6><h6 style="float: right;margin-right: 350px;font-weight: bold;font-size: 20px;">Total = <?= $total; ?></h6>
                                 	<div class="clearfix"></div>
                  </div>
                  <div class="card-body p-0">

                  		<table class="table table-striped">
                  			<thead>
                  				<tr>
                  					
		                            <th width="80"></th>
		                            <th>Store</th>
		                            <th>Sale($)</th>
		                            <th>Zappta Commission</th>
		                            <th>Status</th>
		                            <th>Payment($)</th>
		                            
                  					<th width="150"></th>
                  				</tr>
                  			</thead>
                  			<tbody id="customerListTable">
                  			<?php 	
   //                			echo '<pre>';
	 	// print_r($payments);
	 	// echo '</pre>';
	 	$total = 0;
                  			foreach($payments as $payment){
                  				$total += $payment['total'];

                  				$commision = number_format($payment['total']*$app_commision/100, 2);
	 	  ?>
                  				<tr>
                  					<?php
                  					if($payment['item_status'] == 1)
                  					{
                  						$status = 'Pending';
                  					}
                  					else if($payment['item_status'] == 3)
                  							{
                  						$status = 'Shipped';
                  					}
                  						else if($payment['item_status'] == 4)
                  							{
                  						$status = 'Delivered';
                  					}
                  						else if($payment['item_status'] == 5)
                  							{
                  						$status = 'Returned';
                  					}
                  					else if($payment['item_status'] == 6)
                  							{
                  						$status = 'Cancelled';
                  					}
                  					 ?>
                  					
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
		                            <td><?=$status;?></td>
				                    <td><?=number_format($payment['total'], 2)?></td>
				                	</tr>
				                <?php } ?>
                   <!--       <tr>
                         	<td></td>
                         	<td></td>
                         	<td></td>
                         	<td></td>
                         	<td></td>
                         	<td><h4 style="margin-right: 50px;">Total = <?= $total; ?></h4></td>
                         </tr> -->

                  			</tbody>
                  		</table>
        
                  </div>

                </div>
                          </div>
            </div>



<?php print view('admin/footer');?>