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
							<li>Catalog</li>
							<li>/</li>
							<li><?php print $pagetitle;?></li>
							<li>/</li>
							<li><?php print $attrtitle;?></li>
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
					   	<div class="row">
					      	<div class="col-md-12">

								<div class="artaddForm">
					      			<?php print show_message();?>
								   	<form method="post" action="<?php print base_url();?>/vendors/attributes/valueinsert" enctype="multipart/form-data">
					<?php if ( !empty($sql) ) { ?>
			                            <input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
			                            <input type="hidden" name="_valueid" value="<?php print my_encrypt($sql['id']);?>" />
			                            <input type="hidden" name="value_opt" value="<?php print my_encrypt($sql['value_opt']);?>" />
			                            <div class="form-field">
			                                <label  data-bs-toggle="tooltip" data-bs-placement="top" title="Choose the attribute for this value.">Attribute Name <span class="required">*</span></label>
			                                <div class="field-input">
				                                <select class="form-control" name="attr_id">
				                                <?php 
				                                	if ( is_array($result) && count($result) > 0 ) {
				                                		foreach( $result as $row ) {
				                                ?>
				                                    <option value="<?php print my_encrypt($row['id']);?>"<?php if ( $row['id'] == my_decrypt($attr_id) ) {?> selected<?php }?>><?php print ucfirst($row['name_en']);?></option>
				                                <?php
				                                		}
				                                	}
				                                ?>
				                                </select>
				                            </div>
			                            </div>
			                            <div class="form-field">
			                            	<label>Value Name <span class="required">*</span></label>
			                            	<div class="field-input">
				                            	<input type="text" name="name_en" value="<?php print $sql['name_en'];?>" required />
				                            </div>
			                            </div>
			                            <div id="color_value"<?php if ( $sql['value_opt'] == 2 ) { ?> style="display: block;"<?php } ?>>
				                            <div class="form-field position-relative">
				                            	<label>Color Code</label>
				                            	<div class="field-input">
					                            	<input type="text" name="color_code" placeholder="000000" id="chosen-value" value="<?php print $sql['color_code'];?>" />
					                            </div>
					                            <button type="button" class="btn color_btn position-absolute jscolor {valueElement:'chosen-value', onFineChange:'setTextColor(this)'}">
					                            	<i class="fa-solid fa-palette"></i>
					                            </button>
				                            </div>
											<div class="form-field">
												<label data-bs-placement="top" title="Upload an image file containing the color texture from your computer.This will override the HTML color!">Texture</label>
												<div class="field-input">
													<!-- Add Gallery logic -->
													<div class="row" id="product_image_block">
														<input type="hidden" id="galleryTypeSingle" value="1">
														<?php
														if (isset($sql['value_img']) && $sql['value_img']) {
															$img_ext = explode('.', $sql['value_img']);
														?>
																<div class="col-md-3 mt-1 mb-1 pp_1">
																	<div class="position-relative">
																		<div class="">
																			<img src="<?php print base_url(); ?>/images/product/<?php print $img_ext[0]; ?>/<?php print $img_ext[1]; ?>/100" alt="" class="rounded" style="height: 100px; width: 100%; object-fit: cover; object-position: center; cursor:pointer;">
																		</div>
																	</div>
																	<input type="hidden" id="input_pp_1" name="fimg" value="<?=$sql['value_img']?>" />
																</div>
														<?php
															}
														?>
														<!--  -->
														<div class="col-md-3  mt-1 mb-1">
															<div class="upload-pro text-center" id="addGallery">
																<div class="upload-img">
																	<svg xmlns="http://www.w3.org/2000/svg" width="50" height="42.857" viewBox="0 0 50 42.857">
																		<path id="Icon_material-add-a-photo" data-name="Icon material-add-a-photo" d="M6.522,7.622V1.5H10.87V7.622h6.522V11.7H10.87v6.122H6.522V11.7H0V7.622Zm6.522,12.245V13.745h6.522V7.622H34.783L38.761,11.7h6.891A4.233,4.233,0,0,1,50,15.786v24.49a4.233,4.233,0,0,1-4.348,4.082H10.87a4.233,4.233,0,0,1-4.348-4.082V19.867ZM28.261,38.235c6,0,10.87-4.571,10.87-10.2s-4.87-10.2-10.87-10.2-10.87,4.571-10.87,10.2S22.261,38.235,28.261,38.235ZM21.3,28.031a6.746,6.746,0,0,0,6.957,6.531,6.746,6.746,0,0,0,6.957-6.531A6.746,6.746,0,0,0,28.261,21.5,6.746,6.746,0,0,0,21.3,28.031Z" transform="translate(0 -1.5)" fill="#bbcdd2" />
																	</svg>
																</div>
															</div>
														</div>
													</div>
													<!-- Gallery logics end -->
												</div>
											</div>
			                            </div>
			                            <div class="form-field">
			                            	<label>Price Increament</label>
			                            	<div class="field-input">
			                            		<div class="form-check form-switch">
												  <input class="form-check-input" id="formcheckinput" name="price_enable" type="checkbox" onclick="getCheckBox('formcheckinput');" value="1" <?php if ( $sql['price_enable'] == 1 ) {?> checked<?php } ?>/>
												  <label class="form-check-label">Enable</label>
												</div>
				                            </div>
			                            </div>
			                            <div id="priceblock"<?php if ( $sql['price_enable'] == 1 ) {?> style="display: block;"<?php }?>>
				                            <div class="form-field">
				                            	<label>Add Price</label>
				                            	<div class="field-input">
				                            		<input type="text" name="price_value" value="<?php print $sql['price_value'];?>" />
					                            </div>
				                            </div>
				                        </div>
						      			<div class="form-field">
						      				<div class="btns">
						      					<button type="submit">Save</button>
						      				</div>
						      				<div class="btnCancel">
						      					<button type="button" onclick="window.location.href = '<?php print base_url().'/vendors/attributes/values/'.$attr_id.'/?t='.$_GET['t'];?>';">Cancel</button>
						      				</div>
						      			</div>
					<?php } ?>
								   	</form>

							   </div>

							</div>
						</div>
					</div>

				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>

<?php print view('vendors/footer');?>