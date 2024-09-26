<?php print view('vendors/header');?>
	
	<section class="bread">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12">
				<div class="bb d-flex align-items-center">
					<i onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>
						<ul class="p-0 m-0 d-flex align-items-center">
							<li>
								<a href="<?php print base_url();?>">Home</a>
							</li>
							<li>/</li>
							<li>Vendors</li>
							<li>/</li>
							<li><?php print $pagetitle;?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="position-relative vendor-dashbaord">
		<div class="container">
			<div class="wrapper d-flex align-items-stretch">
		
				<?php print view('vendors/sidebar');?>

				<div id="content" class="float-start">
					<div class="container-fluid">
						<div class="row mb-4">
					      	<div class="col-md-12">
					      		<div class="attributes-links mt-4 mb-4">
					      			<div class="d-flexs">
						      			<a href="<?php print base_url().'/vendors/spree/add'?>" class="addbtn float-end">
						      				<span><i class="fa-solid fa-plus"></i></span>
						      				<span>Add Spree</span>
						      			</a>
						      			<div class="clearfix"></div>
						      		</div>
					      		</div>
				      			<?php print show_message();?>

				      			<div class="table-responsive product-list" style="width:100%;overflow:auto;">
				      				<table style="min-width:672px;" class="table table-striped table-hover">
				      					<thead>
				      						<tr>
				      							<!-- <th><input type="checkbox" name="product-ids[]" /></th> -->
				      							<th>#</th>
				      							<th>Spree Image</th>
				      							<th>Compaign Name</th>
				      							<th>Spree Price</th>
				      							<th>Bonus/Coupon to participants (%)</th>
				      							<th>Compaign Start</th>
				      							<th>Compaign End</th>
				      							<th>Status</th>
				      							<th>&nbsp;</th>
				      						</tr>
				      					</thead>
				      					<tbody>
				      					<?php 
				      						if ( is_array($sprees) && count($sprees) > 0 ) {
				      							$itme = isset($_GET['page']) ? $_GET['page'] * 10 : 1;
				      							foreach ($sprees as $pro) {
				      								if( ! empty( $pro['cover'] ) ) { 
									                    $ext_name = explode('.',$pro['cover']);
									                    $url = base_url().'/upload/media/spree/'.$pro['cover'];
									                } else {
									                    $url = base_url().'/images/product/img-not-found/jpg/100';
									                }
				      					?>
				      						<tr>
				      							<!-- <td><input type="checkbox" name="product-ids[]" value="<?php print my_encrypt($pro['id']);?>" /></td> -->
				      							<td><?php print $itme;?></td>
				      							<td>
				      								<div class="name-p d-flex align-items-center">
					                                    <div class="image">
					                                      	<img src="<?php print $url;?>" alt="">
					                                    </div>
					                                </div>
				      							</td>
				      							<td><?php print $pro['compain_name'];?></td>
				      							<td><?php print $pro['price'];?></td>
				      							<td><?php print $pro['percentage_to_participants'];?></td>
				      							<td><?php print date('m/d/Y', strtotime($pro['start_date']));?></td>
				      							<td><?php print date('m/d/Y', strtotime($pro['end_date']));?></td>
												<td>
													<div class="badge badge-<?=$pro['status']?'success' : 'danger'?>"><?=$pro['status']?'Active' : 'Inactive'?></div>
												</td>
								            	<td>
				      								<div class="action">
				      									<div class="btn-group" role="group">
									                    	<button id="btnGroupDrop<?php print my_encrypt($pro['id']);?>" type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
									                                <svg id="Component_120_5" data-name="Component 120 – 5" xmlns="http://www.w3.org/2000/svg" width="19" height="5" viewBox="0 0 19 5">
									                              <g id="Group_315" data-name="Group 315">
									                                <circle id="Ellipse_34" data-name="Ellipse 34" cx="2.5" cy="2.5" r="2.5"/>
									                                <circle id="Ellipse_35" data-name="Ellipse 35" cx="2.5" cy="2.5" r="2.5" transform="translate(7)"/>
									                                <circle id="Ellipse_36" data-name="Ellipse 36" cx="2.5" cy="2.5" r="2.5" transform="translate(14)"/>
									                              </g>
									                            </svg>
									                        </button>
									                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop<?php print my_encrypt($pro['id']);?>">
									                            <li>
								                                  <a class="dropdown-item bbdr" href="<?php print base_url();?>/vendors/spree/edit/<?php print my_encrypt($pro['id']);?>">
								                                    <span class="icons"><i class="fa-solid fa-pencil"></i></span>
								                                    <span>Edit</span>
								                                  </a>
									                            </li>
									                  			<li>
								                                  <a class="dropdown-item bbdr" onclick="return confirm(`Are you sure to delete this?`)" href="<?php print base_url();?>/vendors/spree/trash/<?php print my_encrypt($pro['id']);?>">
								                                    <span class="icons"><i class="fa-solid fa-trash"></i></span>
								                                    <span>Delete</span>
								                                  </a>
								                                </li>
								                            </ul>
									                    </div>
									                </div>
				      							</td>
				      						</tr>
				      					<?php
				      								$itme++;
				      							}
				      						}
				      					?>
				      					</tbody>
				      				</table>
				      			</div>

								<?php 
									if ( $total_orders > 10 ) { ?>
								<div class="pagenation">
									<?php print $pager->makeLinks(1, 10, $total_orders,'front_full') ?>
								</div>
								<?php } ?>

					      	</div>
					     </div>
						
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>


<?php // print view('vendors/footer');?>