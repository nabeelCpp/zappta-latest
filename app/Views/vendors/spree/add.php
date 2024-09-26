<?php print view('vendors/header');?>
	
	<section class="bread">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12">
					<div class="bb">
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

	<section class="vendor-dashbaord">
		<div class="container">
			<div class="wrapper d-flex align-items-stretch">
		
				<?php print view('vendors/sidebar');?>

				<div id="content" class="float-start">
					<div class="container-fluid">
						
						<div class="product-admin">
							<div class="container">
						<form action="<?php print base_url().'/vendors/spree/'.(isset($spree)?'update':'insert');?>" method="post" enctype="multipart/form-data">		
								<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>">
                                <?php if(isset($spree)) { ?><input type="hidden" name="_id" value="<?=my_encrypt($spree->id)?>"> <?php } ?>
								<div class="row mt-3 mb-3">
									<div class="col-6">
										<h4><?=isset($spree)?'Edit':'Add'?> Spree</h4>
									</div>
									<div class="col-6">
										<div class="probtn d-flex justify-content-end">
											<button class="btn btn-pro" type="submit"><?=isset($spree)?'Update':'Save'?></button>
											<button class="btn btn-cancel" type="button" onclick="window.location.href='<?php print base_url().'/vendors/spree';?>'">Cancel</button>
										</div>
									</div>
								</div>

								<div class="row">
									
									<div class="col-xl-12 col-lg-12 col-md-12 col-12">
										<?php print show_message(); ?>
									</div>
									<div class="col-xl-12 col-lg-12 col-md-12 col-12">

										<div class="tabs-add">

											
											<div class="tab-content" id="myTabContent">
											  <div class="tab-pane fade show active" id="BasicSettings" role="tabpanel" aria-labelledby="BasicSettings-tab">
                                              <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                    <div class="form-row">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                                <label>
                                                                    <span class="tit">Upcoming Compaign</span>
                                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Upcoming Compaigns">
                                                                        <i class="fa-solid fa-circle-info"></i>
                                                                    </span>
                                                                </label>
																<?php if(isset($spree)){ ?>
																	<input type="text" class="form-control" readonly value="<?=$spree->compain_name?> <?= date('Y-m-d', strtotime($spree->compain_s_date)) > date('Y-m-d') ? "[Starting on :".date('m/d/Y', strtotime($spree->compain_s_date))."]": "[Ending on: ".date('m/d/Y', strtotime($spree->compain_e_date))."]"?>">
																<?php }else{ ?>
																	<select class="form-control" name="com_id">

																		<option value="">Select Compaign</option>
																		<?php foreach ($compaigns as $key => $comp) { ?>
																			<option value="<?=my_encrypt($comp['id'])?>" <?=isset($spree)&&$spree->com_id == $comp['id']?'selected':''?>><?=$comp['compain_name']?> <small>[Starting On <?=date('m/d/Y', strtotime($comp['compain_s_date']))?>]</small></option>
																		<?php } ?>
																	</select>
																<?php } ?>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                                <label>
                                                                    <span class="tit">Spree Cover</span>
                                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="The image will be used to display at your spree on website.">
                                                                        <i class="fa-solid fa-circle-info"></i>
                                                                    </span>
                                                                </label>
                                                                <input type="file" name="cover" class="form-control">
                                                                <?php 
                                                                if(isset($spree)){

                                                                    if( $spree->cover ) { 
                                                                        $ext_name = explode('.',$spree->cover);
                                                                        $url = base_url().'/upload/media/spree/'.$spree->cover;
                                                                    } else {
                                                                        $url = base_url().'/images/product/img-not-found/jpg/100';
                                                                    } ?>
                                                                    <img src="<?=$url?>" class="img img-responsive img-thumbnail" alt="">
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                                <label>
                                                                    <span class="tit">Spree Prize</span>
                                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="How much bonus you want to give to winner.">
                                                                        <i class="fa-solid fa-circle-info"></i>
                                                                    </span>
                                                                </label>
                                                                <input type="number" name="price" class="form-control" value="<?=isset($spree)&&$spree->price?$spree->price:''?>">
                                                            </div>
															<div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                                <label>
                                                                    <span class="tit">Bonus to participants (%)</span>
                                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="Percentage of discount/coupon you want to give to all participants">
                                                                        <i class="fa-solid fa-circle-info"></i>
                                                                    </span>
                                                                </label>
                                                                <input type="number" name="percentage_to_participants" class="form-control" value="<?=isset($spree)&&$spree->percentage_to_participants?$spree->percentage_to_participants:0?>">
                                                            </div>
                                                           
                                                        </div>
                                                        
                                                        
                                                    </div>

                                                </div>





                                            </div>
											  </div>
											</div>


										</div>

									</div>



								</div>
						</form>

							</div>
						</div>
						
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>


<?php print view('vendors/footer');?>