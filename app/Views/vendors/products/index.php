<?php print view('vendors/header'); ?>

<section class="bread">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-12">
				<div class="bb d-flex align-items-center">
					<i onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>
					<ul class="p-0 m-0 d-flex align-items-center">
						<li>
							<a href="<?php print base_url(); ?>">Home</a>
						</li>
						<li>/</li>
						<li>Vendors</li>
						<li>/</li>
						<li><?php print $pagetitle; ?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="position-relative vendor-dashbaord">
	<div class="container">
		<div class="wrapper d-flex align-items-stretch">

			<?php print view('vendors/sidebar'); ?>

			<div id="content" class="float-start">
				<div class="container-fluid">
					<?php print view('vendors/compaign'); ?>
					<div class="row mb-4">
						<div class="col-md-12">
							<div class="attributes-links mt-4 mb-4">
								<div class="d-flexs">
									<a href="<?php print base_url() . '/vendors/products/add' ?>" class="addbtn float-end">
										<span><i class="fa-solid fa-plus"></i></span>
										<span>Add Product</span>
									</a>
									<div class="clearfix"></div>
								</div>
							</div>
							<?php print show_message(); ?>

							<div class="table-responsive product-list" style="100%;overflow:auto;">
								<table style="min-width:672px;" class="table table-striped table-hover">
									<thead>
										<tr>
											<th><input type="checkbox" name="product-ids[]" /></th>
											<th>ID</th>
											<th>Name</th>
											<th>SKU</th>
											<th>Category</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Status</th>
											<!-- <?php if (!empty(assigncompain())) { ?>
				      							<th>Giveway</th>
				      							<?php } ?> -->
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if (is_array($product) && count($product) > 0) {
											$itme = isset($_GET['page']) ? $_GET['page'] * 10 : 1;
											foreach ($product as $pro) {
												if (! empty($pro['cover'])) {
													$ext_name = explode('.', $pro['cover']);
													$url = base_url() . '/images/product/' . $ext_name[0] . '/' . $ext_name[1] . '/100';
												} else {
													$url = base_url() . '/images/product/img-not-found/jpg/100';
												}
										?>
												<tr>
													<td><input type="checkbox" name="product-ids[]" value="<?php print my_encrypt($pro['pid']); ?>" /></td>
													<td><?php print $itme; ?></td>
													<td>
														<div class="name-p d-flex align-items-center">
															<div class="image">
																<img src="<?php print $url; ?>" alt="">
															</div>
															<div class="name"><?php print $pro['pname']; ?></div>
														</div>
													</td>
													<td><?php print $pro['reference']; ?></td>
													<td><?php print $pro['cat_name']; ?></td>
													<td>
														<?php
														if ($pro['deal_enable'] == 1) {
															print number_format($pro['deal_final_price'], 2);
														} else {
															print number_format($pro['final_price'], 2);
														}
														?>
													</td>
													<td><?php print $pro['quantity']; ?></td>
													<td>
														<?php
														if ($pro['pstatus'] == 1) {
															print '<span class="badge bg-success">Publish</span>';
														} else {
															print '<span class="badge bg-danger">Draft</span>';
														}
														?>
													</td>
													<?php //if ( !empty(assigncompain() ) ) { 
													?>
													<!-- <td>
				      								<?php
														// if ( !empty(getProductCompain(assigncompain()['compaign_id'],$pro['pid'])) ) {
														// 	print '<span class="badge bg-info">Assigned</span>';
														// } else {
														// 	print '<span class="badge bg-primary">Not Assigned</span>';
														// }
														?>
				      							</td> -->
													<?php //} 
													?>
													<td>
														<div class="action">
															<div class="btn-group" role="group">
																<button id="btnGroupDrop<?php print my_encrypt($pro['pid']); ?>" type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
																	<svg id="Component_120_5" data-name="Component 120 – 5" xmlns="http://www.w3.org/2000/svg" width="19" height="5" viewBox="0 0 19 5">
																		<g id="Group_315" data-name="Group 315">
																			<circle id="Ellipse_34" data-name="Ellipse 34" cx="2.5" cy="2.5" r="2.5" />
																			<circle id="Ellipse_35" data-name="Ellipse 35" cx="2.5" cy="2.5" r="2.5" transform="translate(7)" />
																			<circle id="Ellipse_36" data-name="Ellipse 36" cx="2.5" cy="2.5" r="2.5" transform="translate(14)" />
																		</g>
																	</svg>
																</button>
																<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="btnGroupDrop<?php print my_encrypt($pro['pid']); ?>">
																	<li>
																		<a class="dropdown-item bbdr" href="<?php print base_url(); ?>/vendors/products/edit/<?php print my_encrypt($pro['pid']); ?>">
																			<span class="icons"><i class="fa-solid fa-pencil"></i></span>
																			<span>Edit</span>
																		</a>
																	</li>
																	<?php if ($pro['pstatus'] == 1) { ?>
																		<li>
																			<a class="dropdown-item bbdr" href="<?php print base_url(); ?>/vendors/products/draft/<?php print my_encrypt($pro['pid']); ?>">
																				<span class="icons"><i class="fa-brands fa-firstdraft"></i></span>
																				<span>Draft</span>
																			</a>
																		</li>
																	<?php } else { ?>
																		<li>
																			<a class="dropdown-item bbdr" href="<?php print base_url(); ?>/vendors/products/publish/<?php print my_encrypt($pro['pid']); ?>">
																				<span class="icons"><i class="fa-brands fa-firstdraft"></i></span>
																				<span>Publish</span>
																			</a>
																		</li>
																	<?php } ?>
																	<li>
																		<a class="dropdown-item bbdr" onclick="return confirm(`Are you sure to delete this?`)" href="<?php print base_url(); ?>/vendors/products/trash/<?php print my_encrypt($pro['pid']); ?>">
																			<span class="icons"><i class="fa-solid fa-trash"></i></span>
																			<span>Delete</span>
																		</a>
																	</li>
																	<?php //if ( !empty(assigncompain() ) ) { 
																	?>
																	<!-- <li>
									                  				<?php //if(!empty(getProductCompain(assigncompain()['compaign_id'],$pro['pid']))){ 
																		?>
										                                  <a class="dropdown-item bbdr" href="<?php //print base_url(); ?>/vendors/products/removegiveway/<?php //print my_encrypt($pro['pid']) . '/' . my_encrypt(assigncompain()['compaign_id']); ?>">
										                                    <span class="icons"><i class="fas fa-gift"></i></span>
										                                    <span>Remove Giveway</span>
										                                <?php //}else{ 
																		?>
										                                	<a class="dropdown-item bbdr" href="<?php //print base_url(); ?>/vendors/products/giveway/<?php //print my_encrypt($pro['pid']) . '/' . my_encrypt(assigncompain()['compaign_id']); ?>">
										                                    <span class="icons"><i class="fas fa-gift"></i></span>
										                                    <span>Add Giveway</span>
										                                <?php //} 
																		?>
								                                  </a>
								                                </li> -->
																	<?php //} 
																	?>
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
							if ($total_orders > 10) { ?>
								<div class="pagenation">
									<?php print $pager->makeLinks(1, 10, $total_orders, 'front_full') ?>
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


<?php // print view('vendors/footer');
?>