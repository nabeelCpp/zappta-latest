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
							<li><?php print $pagetitle;?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="vendor-dashbaord position-relative">
		<div class="container">
			<div class="wrapper d-flex align-items-stretch">
		
				<?php print view('vendors/sidebar');?>

				<div id="content" class="float-start">
					<div class="container-fluid">
				<?php print view('vendors/compaign');?>
						<?php 
								if ( (new \App\Models\ProductsModel())->countTotalStorePro() > 0 ) {
						?>
						<div class="row">
							<div class="col-12">
								<div class="v-header-banner mt-3">
									<label>Store Banner</label>
									<?php 
										if ( $design > 0 && $design['header_banner'] !== "" ) {
											$img_ext = explode('.',$design['header_banner']);
									?>
										<div class="v-header-bg" id="uploadDesign" style="background-image:url('<?php print base_url().'/images/media/'.$img_ext[0].'/'.$img_ext[1].'/600';?>');">
											<div class="changebg" onclick="uploaddesign('uploadDesign','header.banner');">
												<i class="fas fa-edit"></i>
			                            		<input type="file" title='Click to add Files' class="position-absolute" />
											</div>
										</div>
									<?php } else { ?>
										<div class="v-header-bg dm-uploader p-2" id="uploadDesign">
											<div class="changebg d-none" onclick="uploaddesign('uploadDesign','header.banner');">
												<i class="fas fa-edit"></i>
			                            		<input type="file" title='Click to add Files' class="position-absolute" />
											</div>
											<div class="grids" onclick="uploaddesign('uploadDesign','header.banner');">
												<h3 class="mb-5 mt-5 text-muted">Drag and drop Banner Image</h3>
			                                  	<div class="btn btn-block position-relative">
			                                      	<span>Open the file Browser</span>
			                                      	<input type="file" title='Click to add Files' class="position-absolute"/>
			                                  	</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>

						<div class="row d-none">
							<div class="col-xl-6 col-lg-6 col-md-6 col-12">
								<div class="v-header-banner mt-3">
									<label>Store Category</label>
									<?php 
										if ( $design > 0 && !empty($design['category_banner_first']) ) {
											$img_ext_first = explode('.',$design['category_banner_first']);
											if ( is_array($img_ext_first) && count($img_ext_first) > 0 ) {
									?>
										<div class="v-header-bg he-500" id="category_banner_first" style="background-image:url('<?php print base_url().'/images/media/'.$img_ext_first[0].'/'.$img_ext_first[1].'/600';?>');">
											<div class="changebg" onclick="uploaddesign('category_banner_first','category.banner.first');">
												<i class="fas fa-edit"></i>
			                            		<input type="file" title='Click to add Files' class="position-absolute" />
											</div>
											<div class="changebg linkbtncat" id="category_link_first" onclick="selectVendorCat('category_link_first','<?php print $design['category_link_first'];?>','category_title_first','<?php print $design['category_title_first'];?>');">
												<i class="fa-solid fa-link"></i>
											</div>
										</div>
									<?php } ?>
									<?php } else { ?>
										<div class="v-header-bg he-500 dm-uploader p-2" id="category_banner_first">
											<div class="changebg d-none" onclick="uploaddesign('category_banner_first','category.banner.first');">
												<i class="fas fa-edit"></i>
			                            		<input type="file" title='Click to add Files' class="position-absolute" />
											</div>
											<div class="changebg linkbtncat d-none" id="category_link_first" onclick="selectVendorCat('category_link_first','','category_title_first','');">
												<i class="fa-solid fa-link"></i>
											</div>
											<div class="grids" onclick="uploaddesign('category_banner_first','category.banner.first');">
												<h3 class="mb-5 mt-5 text-muted">Drag and drop Category Banner Image</h3>
			                                  	<div class="btn btn-block position-relative">
			                                      	<span>Open the file Browser</span>
			                                      	<input type="file" title='Click to add Files' class="position-absolute"/>
			                                  	</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-12">
								<div class="row">
									<div class="col-12">
										<div class="v-header-banner mt-3">
											<label>Store Category</label>
											<?php 
												if ( $design > 0 && !empty($design['category_banner_second']) ) {
													$img_ext_first = explode('.',$design['category_banner_second']);
													if ( is_array($img_ext_first) && count($img_ext_first) > 0 ) {
											?>
												<div class="v-header-bg he-200" id="category_banner_second" style="background-image:url('<?php print base_url().'/images/media/'.$img_ext_first[0].'/'.$img_ext_first[1].'/600';?>');">
													<div class="changebg" onclick="uploaddesign('category_banner_second','category.banner.second');">
														<i class="fas fa-edit"></i>
					                            		<input type="file" title='Click to add Files' class="position-absolute" />
													</div>
													<div class="changebg linkbtncat" id="category_link_second" onclick="selectVendorCat('category_link_second','<?php print $design['category_link_second'];?>','category_title_second','<?php print $design['category_title_second'];?>');">
														<i class="fa-solid fa-link"></i>
													</div>
												</div>
											<?php } ?>
											<?php } else { ?>
												<div class="v-header-bg he-200 dm-uploader p-2" id="category_banner_second">
													<div class="changebg d-none" onclick="uploaddesign('category_banner_second','category.banner.second');">
														<i class="fas fa-edit"></i>
					                            		<input type="file" title='Click to add Files' class="position-absolute" />
													</div>
													<div class="changebg d-none linkbtncat" id="category_link_second" onclick="selectVendorCat('category_link_second','','category_title_second','');">
														<i class="fa-solid fa-link"></i>
													</div>
													<div class="grids" onclick="uploaddesign('category_banner_second','category.banner.second');">
														<h3 class="mb-5 mt-5 text-muted">Drag and drop Category Banner Image</h3>
					                                  	<div class="btn btn-block position-relative">
					                                      	<span>Open the file Browser</span>
					                                      	<input type="file" title='Click to add Files' class="position-absolute"/>
					                                  	</div>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-6 col-12">
										<div class="v-header-banner mt-1">
											<?php 
												if ( $design > 0 && !empty($design['category_banner_third']) ) {
													$img_ext_first = explode('.',$design['category_banner_third']);
													if ( is_array($img_ext_first) && count($img_ext_first) > 0 ) {
											?>
												<div class="v-header-bg he-200" id="category_banner_third" style="background-image:url('<?php print base_url().'/images/media/'.$img_ext_first[0].'/'.$img_ext_first[1].'/600';?>');">
													<div class="changebg" onclick="uploaddesign('category_banner_third','category.banner.third');">
														<i class="fas fa-edit"></i>
					                            		<input type="file" title='Click to add Files' class="position-absolute" />
													</div>
													<div class="changebg linkbtncat" id="category_link_third" onclick="selectVendorCat('category_link_third','<?php print $design['category_link_third'];?>','category_title_third','<?php print $design['category_title_third'];?>');">
														<i class="fa-solid fa-link"></i>
													</div>
												</div>
											<?php } ?>
											<?php } else { ?>
												<div class="v-header-bg he-200 dm-uploader p-2" id="category_banner_third">
													<div class="changebg d-none" onclick="uploaddesign('category_banner_third','category.banner.third');">
														<i class="fas fa-edit"></i>
					                            		<input type="file" title='Click to add Files' class="position-absolute" />
													</div>
													<div class="changebg d-none linkbtncat" id="category_link_third" onclick="selectVendorCat('category_link_third','','category_title_third','');">
														<i class="fa-solid fa-link"></i>
													</div>
													<div class="grids" onclick="uploaddesign('category_banner_third','category.banner.third');">
														<h6 class="mb-5 mt-5 text-muted">Drag and drop Category Banner Image</h6>
					                                  	<div class="btn btn-block position-relative">
					                                      	<span>Open the file Browser</span>
					                                      	<input type="file" title='Click to add Files' class="position-absolute"/>
					                                  	</div>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>				
									<div class="col-xl-6 col-lg-6 col-md-6 col-12">
										<div class="v-header-banner mt-1">
											<?php 
												if ( $design > 0 && !empty($design['category_banner_fourth']) ) {
													$img_ext_first = explode('.',$design['category_banner_fourth']);
													if ( is_array($img_ext_first) && count($img_ext_first) > 0 ) {
											?>
												<div class="v-header-bg he-200" id="category_banner_fourth" style="background-image:url('<?php print base_url().'/images/media/'.$img_ext_first[0].'/'.$img_ext_first[1].'/600';?>');">
													<div class="changebg" onclick="uploaddesign('category_banner_fourth','category.banner.fourth');">
														<i class="fas fa-edit"></i>
					                            		<input type="file" title='Click to add Files' class="position-absolute" />
													</div>
													<div class="changebg linkbtncat" id="category_link_fourth" onclick="selectVendorCat('category_link_fourth','<?php print $design['category_link_fourth'];?>','category_title_fourth','<?php print $design['category_title_third'];?>');">
														<i class="fa-solid fa-link"></i>
													</div>
												</div>
											<?php } ?>
											<?php } else { ?>
												<div class="v-header-bg he-200 dm-uploader p-2" id="category_banner_fourth">
													<div class="changebg d-none" onclick="uploaddesign('category_banner_fourth','category.banner.fourth');">
														<i class="fas fa-edit"></i>
					                            		<input type="file" title='Click to add Files' class="position-absolute" />
													</div>
													<div class="changebg d-none linkbtncat" id="category_link_fourth" onclick="selectVendorCat('category_link_fourth','','category_title_fourth','');">
														<i class="fa-solid fa-link"></i>
													</div>
													<div class="grids" onclick="uploaddesign('category_banner_fourth','category.banner.fourth');">
														<h6 class="mb-5 mt-5 text-muted">Drag and drop Category Banner Image</h6>
					                                  	<div class="btn btn-block position-relative">
					                                      	<span>Open the file Browser</span>
					                                      	<input type="file" title='Click to add Files' class="position-absolute"/>
					                                  	</div>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>										
								</div>
							</div>
						</div>


						<div class="row d-none">
							<div class="col-12">
								<div class="v-header-banner mt-3">
									<label>Best Selling Banner</label>
									<?php 
										if ( $design > 0 && !empty($design['middle_banner']) ) {
											$img_ext = explode('.',$design['middle_banner']);
									?>
										<div class="v-header-bg" id="middle_banner" style="background-image:url('<?php print base_url().'/images/media/'.$img_ext[0].'/'.$img_ext[1].'/600';?>');">
											<div class="changebg" onclick="uploaddesign('middle_banner','middle.banner');">
												<i class="fas fa-edit"></i>
			                            		<input type="file" title='Click to add Files' class="position-absolute" />
											</div>
										</div>
									<?php } else { ?>
										<div class="v-header-bg dm-uploader p-2" id="middle_banner">
											<div class="changebg d-none" onclick="uploaddesign('middle_banner','middle.banner');">
												<i class="fas fa-edit"></i>
			                            		<input type="file" title='Click to add Files' class="position-absolute" />
											</div>
											<div class="grids" onclick="uploaddesign('middle_banner','middle.banner');">
												<h3 class="mb-5 mt-5 text-muted">Drag and drop Best Selling Banner Image</h3>
			                                  	<div class="btn btn-block position-relative">
			                                      	<span>Open the file Browser</span>
			                                      	<input type="file" title='Click to add Files' class="position-absolute"/>
			                                  	</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>

					<?php } else { ?>
						<div class="row mt-4">
								<div class="col-12">
										<h6 class="alert alert-danger text-center">Please add some products to your store before designing your store page.</h6>
								</div>
						</div>
					<?php } ?>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>

<!-- Modal -->
<div class="modal fade" id="vendorCatModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      	<div class="modal-body">
        	<button type="button" class="btn-close position-absolute modalclose" data-bs-dismiss="modal" aria-label="Close"></button>
        	<input type="hidden" id="selectblock">
        	<input type="hidden" id="selecttitle">
        	<div class="pt-4">
        		<div class="form-group mb-2">
        				<input type="text" id="catetitle" class="form-control" placeholder="Add Title">
        		</div>
        		<div class="form-group">
		        	<select class="form-control" id="vcat">
		        		<option value="0">Select Category</option>
		        	<?php 
		        		if ( is_array($getVendorCategory) && count($getVendorCategory) > 0 ) {
		        			foreach( $getVendorCategory as $cat ) {
		        	?>
		        		<option value="<?php print $cat['cat_url'];?>"><?php print $cat['ccname'];?></option>
		        	<?php
		        			}
		        		}
		        	?>
		        	</select>
	        	</div>
        		<div class="form-group mt-2">
        				<button type="button" class="btn btn-success btn-sm" onclick="updateVendorCat()">Update</button>
        		</div>
	        </div>
      	</div>
    </div>
  </div>
</div>

<?php  print view('vendors/footer');?>