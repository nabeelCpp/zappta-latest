<?php print view('site/header');?>
<style>
	figure.zoom {
		background-position: 50% 50%;
		position: relative;
		width: 500px;
		overflow: hidden;
		cursor: zoom-in;
		background-repeat: no-repeat;
		background-size: 200%;
	}

	figure.zoom img {
		transition: opacity 0.5s;
		display: block;
		width: 100%;
	}

	figure.zoom img:hover {
		opacity: 0;
	}
</style>

<link type="text/css" rel="stylesheet" href="<?=base_url()?>/theme/zoomer/style.css"/>
<?php if ( !empty($single) ) { ?>	

<?php 
		// print '<pre>';
		// print_r($single);
		// print '</pre>';
?>

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
							<li>
								<a href="<?php print base_url().'/stores/'.$single['store_slug'];?>">Stores</a>
							</li>
							<li>/</li>
							<li><a href="<?php print base_url().'/stores/'.$single['store_slug'];?>"><?php print $single['store_name'];?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
<script>
	currentUrl = "<?php print base_url().'/stores/'.$single['store_slug'];?>";
</script>
<style>
.slick-list{
	height:auto !important;

}
.slick-track{
	display:flex;
	width: 100%;
	height:auto !important;
}
.rtl-slide-thumb{
	width: 1000% !important;
    background-size: 100px 100px !important;
}
</style>

	<section class="singlepro">
		<div class="container">
			<div class="row flex-column flex-lg-row">
			<div class="col-xl-6 col-lg-6 col-md-7 col-12">
				<?php if ( is_array($single['gallery']) && count($single['gallery']) > 0 ) { ?>
					<div class="row">
						<div class="col-2">
							<ul class="list-group py-5 mt-5">
								<?php foreach ( $single['gallery'] as $gal ) { ?>
									<?php if( ! empty( $gal['fimg'] ) ) { 
										$ext_fimg = explode('.',$gal['fimg']); ?>
										<li class="list-group-item shopping-image" style="cursor: pointer;" data-id="<?=$ext_fimg[0]?>"><img src="<?php print base_url().'/images/product/'.$ext_fimg[0].'/'.$ext_fimg[1].'/100';?>" alt="" class="img img-thumbnail"></li>
								<?php } else { ?>
									<li class="list-group-item"><img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" alt="" class="img img-thumbnail"></li>
								<?php } ?>
								<?php } ?>
							</ul>
						</div>
						<div class="col-10" id="main-image-viewer">
							<?php foreach ( $single['gallery'] as $key => $gal ) { ?>
								<div class="rtl-slider-slide animate" style="background: transparent !important; <?=$key > 0 ? "display: none" : ""?>">
								<?php 
									if( ! empty( $gal['fimg'] ) ) { 
										$ext_fimg = explode('.',$gal['fimg']);
								?>
									<figure class="zoom" onmousemove="zoom(event)"  data-id="<?=$ext_fimg[0]?>" style="background-image: url('<?php print base_url().'/images/product/'.$ext_fimg[0].'/'.$ext_fimg[1].'/1280';?>')">
										<img src="<?php print base_url().'/images/product/'.$ext_fimg[0].'/'.$ext_fimg[1].'/1280';?>">
									</figure>
							<?php } else { ?>
										<img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" alt="">
							<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
					<!-- <div class="rtl-slider-flex d-flex flex-column-reverse ">
						<div class="rtl-slider-slide-thumb position-relative ">
							<span class="thumb-prev position-absolute"><i class="fa fa-angle-up fa-lg"></i></span>
							<div class="rtl-slider-nav">
							<?php foreach ( $single['gallery'] as $gal ) { ?>
								<?php 
				    				if( ! empty( $gal['fimg'] ) ) { 
				    					$ext_fimg = explode('.',$gal['fimg']);
				    			?>
								<div class="rtl-slide-thumb animate" style="background-image: url('<?php print base_url().'/images/product/'.$ext_fimg[0].'/'.$ext_fimg[1].'/250';?>');">
							  	
						         </div>
							  <?php } else { ?>
								<div class="rtl-slide-thumb animate" style="background-image: url('<?php print base_url().'/images/product/img-not-found/jpg/100';?>');">
							  	</div>
							  <?php } ?>
							<?php } ?>
							</div>
							<span class="thumb-next position-absolute"><i class="fa fa-angle-down fa-lg"></i></span>
						</div>
						<div class="rtl-slider">
							<?php foreach ( $single['gallery'] as $gal ) { ?>
								<div class="rtl-slider-slide animate" style="background: transparent !important;">
								<?php 
				    				if( ! empty( $gal['fimg'] ) ) { 
				    					$ext_fimg = explode('.',$gal['fimg']);
				    			?>
									<figure class="zoom" onmousemove="zoom(event)" style="background-image: url('<?php print base_url().'/images/product/'.$ext_fimg[0].'/'.$ext_fimg[1].'/1280';?>')">
										<img src="<?php print base_url().'/images/product/'.$ext_fimg[0].'/'.$ext_fimg[1].'/1280';?>">
									</figure>
							  <?php } else { ?>
								  		<img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" alt="">
							  <?php } ?>
								</div>
							<?php } ?>
						</div>
					</div> -->
				<?php } else { ?>
					<div class="product-not-found">
						<img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" alt="">
					</div>
				<?php } ?>
			</div>
				<div class="col-xl-6 col-lg-6 col-md-5 col-12">
					<form id="cartform">
						<div class="singlepro-detail">
							<h2><?php print ucfirst($single['name']);?></h2>
							<a href="<?php print base_url().'/stores/'.$single['store_slug'];?>" class="visit">Visit the Store</a>
							<div class="rating d-flex">
								<p class="me-4">
									<?php 
									if(isset($overal_ratings->average_ratings)&&$overal_ratings->average_ratings){
										$overal_ratings->average_ratings = round($overal_ratings->average_ratings);
									}
									for ($i=1; $i <= 5; $i++) { ?>
										<span class="<?=isset($overal_ratings->average_ratings)&&$overal_ratings->average_ratings&&$i<=$overal_ratings->average_ratings?'golden':''?>"><i class="fa-solid fa-star"></i></span>
									<?php } ?>
								</p>
								<p><?=isset($overal_ratings->total_reviews)&&$overal_ratings->total_reviews?$overal_ratings->total_reviews:0?> reviews</p>
							</div>
							<div class="price-block position-relative">
								<?php 
									$item_price = 0;
								?>
								<div class="price">
								<?php if ( $single['outofstockorder'] == 2 ) { ?>
									<p class="instock">In Stock</p>
									<div id="spreeOptBtn" class="m-2 add_To_Spree" data-id="<?=$single['product_id']?>"></div>
								<?php } elseif ( $single['outofstockorder'] == 1 && $single['quantity'] > 0 ) {?>
									<p class="instock">In Stock</p>
									<div id="spreeOptBtn" class="m-2 add_To_Spree" data-id="<?=$single['product_id']?>"></div>
								<?php } else { ?>
									<p class="outstock">Outof Stock</p>
								<?php } ?>
									<p class="pp d-flex position-relative">
								<?php 
									if ( $single['deal_enable'] > 0 ) {
										$item_price = $single['deal_final_price'];
										$price = explode('.',trim($single['deal_final_price']));
										if ( is_array($price) && count($price) > 1 ) {
								?>
										<span id="singleprice">
											<small>$</small>
											<span id="firstdigit"><?php print $price[0];?></span>
											<small id="seconddigit"><?php print $price[1];?></small>
										</span>
									<?php } else { ?>		
										<span id="singleprice">
											<small>$</small>
											<span id="firstdigit"><?php print $single['deal_final_price'];?></span>
											<small id="seconddigit">00</small>
										</span>
									<?php } ?>
									<span class="ms-3 mt-2"><del>$<?php print number_format($single['final_price'],2)?></del></span>
								<?php } else {?>
									<?php 
											$item_price = $single['final_price'];
											$price = explode('.',trim($single['final_price']));
											if ( is_array($price) && count($price) > 1 ) {
										?>
										<span id="singleprice">
											<small>$</small>
											<span id="firstdigit"><?php print $price[0];?></span>
											<small id="seconddigit"><?php print $price[1];?></small>
										</span>
										<?php } else { ?>	
										<span id="singleprice">
											<small>$</small>
											<span id="firstdigit"><?php print $single['final_price']?></span>
											<small id="seconddigit">00</small>
										</span>
									<?php } ?>
								<?php } ?>
									</p>
								</div>
								<?php if(isset($store) && $store['earn_zappta']){ ?>
									<div class="price-zaptta d-flex">
										<span>Earn</span>
										<span>
											<svg xmlns="http://www.w3.org/2000/svg" width="9" height="20" viewBox="0 0 9 20">
											<g id="Group_667" data-name="Group 667" transform="translate(-1129 -531)">
												<text id="Z" transform="translate(1129 547)" fill="#1f961b" font-size="15" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>
												<g id="Rectangle_4131" data-name="Rectangle 4131" transform="translate(1133 546.5)" fill="none" stroke="#1f961b" stroke-width="1">
												<rect width="1.2" height="2" stroke="none"/>
												<rect x="0.5" y="0.5" width="0.2" height="1" fill="none"/>
												</g>
												<g id="Rectangle_4132" data-name="Rectangle 4132" transform="translate(1133 535)" fill="none" stroke="#1f961b" stroke-width="1">
												<rect width="1.2" height="2" stroke="none"/>
												<rect x="0.5" y="0.5" width="0.2" height="1" fill="none"/>
												</g>
											</g>
											</svg>
										</span>
										<span><?=$store['earn_zappta']?> per $<?=$store['per_dollar']?> spent</span>
									</div>
								<?php } ?>
								<?php 
									$givewaytags = isset($_GET['give']) ? $_GET['give'] : 0;
									if ( $givewaytags == 1 ) {
								?>
								<div class="givewaytags position-absolute">
									<p>Giveaway Active</p>
								</div>
								<?php
									}
								?>
							</div>
						<div class="attributes">
							<?php 
								if ( is_array($single['attributes']) && count($single['attributes']) > 1 ) {
									$attr = 1;
									foreach( $single['attributes'] as $attributes => $attrkeys) {
							?>
							<?php if ( is_array($attrkeys) && count($attrkeys) > 0 ) {?>
								<div class="attributes-list d-block">
									<div class="title d-flex">
										<h4><?php print $attrkeys['attribute_name'];?></h4>
										<span class="nametext_<?php print my_encrypt($attrkeys['attr_id']);?>"></span>
									</div>
									<div class="attr-ul attr-ul-<?php print my_encrypt($attrkeys['attr_id']);?>">
									<?php 
										switch ($attrkeys['attr_option']) {
											case 2:
									?>
										<ul class="p-0 m-0 d-flex">
										<?php
											foreach( $attrkeys['values'] as $val ) {
												$data_price_enable = !empty($val['price_enable']) ? $val['price_enable'] : 0;
												$data_price_value = !empty($val['price_value']) ? $val['price_value'] : 0;
										?>
											<li data-attr-setprice="<?php print $data_price_enable;?>" data-attr-price="<?php print $data_price_value;?>" class="attrImgClick proattr me-2 animate" data-name="<?php print $val['value_name'];?>" data-price="<?php print $item_price;?>" data-id="<?php print my_encrypt($attrkeys['attr_id']);?>" data-value="<?php print my_encrypt($val['pattr_value_id']);?>" data-img="<?=$val['value_img']?>">
											<?php 
												if( !empty( $val['value_img']) ) { 
													$value_img_ext = explode('.', $val['value_img']);
											?>
												<span class="attr_texture" style="height: 37px !important">
													<img src="<?php print base_url(); ?>/images/product/<?php print $value_img_ext[0]; ?>/<?php print end($value_img_ext); ?>/100" alt="" style="width: 35px; height: 35px;"></span>
											<?php } else { ?>
												<span class="attr_color" style="background-color:#<?php print $val['color_code'];?>"></span>
											<?php } ?>
											</li>
										<?php		
											}
										?>
										</ul>
									<?php
												break;

											default:
									?>
										<ul class="p-0 m-0 d-flex">
										<?php 
											foreach( $attrkeys['values'] as $val ) {
												$data_price_enable = !empty($val['price_enable']) ? $val['price_enable'] : 0;
												$data_price_value = !empty($val['price_value']) ? $val['price_value'] : 0;
										?>
												<li data-attr-setprice="<?php print $data_price_enable;?>" data-attr-price="<?php print $data_price_value;?>" class="proattr me-2 animate" data-name="<?php print $val['value_name'];?>" data-price="<?php print $item_price;?>" data-id="<?php print my_encrypt($attrkeys['attr_id']);?>" data-value="<?php print my_encrypt($val['pattr_value_id']);?>">
													<span><?php print $val['value_name'];?></span>
												</li>
										<?php } ?>	
										</ul>
									<?php
												break;
										}
									?>
									</div>
								</div>
									<?php } ?>
							<?php
										$attr++;
									}
								} else {
							?>
							<?php 
								if ( is_array($single['attributes']) && count($single['attributes']) == 1 ) {
									$attrkeys = $single['attributes'][0];
							?>
							<?php if ( is_array($attrkeys) && count($attrkeys) > 0 ) {?>
								<div class="attributes-list d-block">
									<div class="title d-flex">
										<h4><?php print $attrkeys['attribute_name'];?></h4>
										<span class="nametext_<?php print my_encrypt($attrkeys['attr_id']);?>"></span>
									</div>
									<div class="attr-ul attr-ul-<?php print my_encrypt($attrkeys['attr_id']);?>">
									<?php 
										switch ($attrkeys['attr_option']) {
											case 2:
									?>
										<ul class="p-0 m-0 d-flex">
										<?php
											foreach( $attrkeys['values'] as $val ) {
												$data_price_enable = !empty($val['price_enable']) ? $val['price_enable'] : 0;
												$data_price_value = !empty($val['price_value']) ? $val['price_value'] : 0;
										?>
											<li data-attr-setprice="<?php print $data_price_enable;?>" data-attr-price="<?php print $data_price_value;?>" class="attrImgClick proattr me-2 animate" data-name="<?php print $val['value_name'];?>" data-price="<?php print $item_price;?>" data-id="<?php print my_encrypt($attrkeys['attr_id']);?>" data-value="<?php print my_encrypt($val['pattr_value_id']);?>" data-img="<?=$val['value_img']?>">
											<?php 
												if( !empty( $val['value_img']) ) { 
													$value_img_ext = explode('.', $val['value_img']);
											?>
												<span class="attr_texture" style="height: 37px !important"><img src="<?php print base_url(); ?>/images/product/<?php print $value_img_ext[0]; ?>/<?php print end($value_img_ext); ?>/100" alt="" style="width: 35px; height: 35px;"></span>
											<?php } else { ?>
												<span class="attr_color" style="background-color:#<?php print $val['color_code'];?>"></span>
											<?php } ?>
											</li>
										<?php		
											}
										?>
										</ul>
									<?php
												break;

											default:
									?>
										<ul class="p-0 m-0 d-flex">
										<?php 
											foreach( $attrkeys['values'] as $val ) {
												$data_price_enable = !empty($val['price_enable']) ? $val['price_enable'] : 0;
												$data_price_value = !empty($val['price_value']) ? $val['price_value'] : 0;
										?>
												<li data-attr-setprice="<?php print $data_price_enable;?>" data-attr-price="<?php print $data_price_value;?>" class="proattr me-2 animate" data-name="<?php print $val['value_name'];?>" data-price="<?php print $item_price;?>" data-id="<?php print my_encrypt($attrkeys['attr_id']);?>" data-value="<?php print my_encrypt($val['pattr_value_id']);?>">
													<span><?php print $val['value_name'];?></span>
												</li>
										<?php } ?>	
										</ul>
									<?php
												break;
										}
									?>
									</div>
								</div>
									<?php } ?>

								<input type="hidden" name="attr[]" class="attr_hidden attr_hidden_<?php //print my_encrypt($attrkeys['id']);?>" value="<?php //print my_encrypt($attrkeys['id']);?>_<?php //print my_encrypt($attrkeys['values'][0]['value_id']);?>">
							<?php 
								}
							?>
							<?php } ?>

<style>
	@media only screen and (min-width: 575px){

.addtocard .btn-cart{
	width:150px !important;
	height:30px !important;
	margin:0px 7px !important;
	font-size:12px !important;
}

	}


	@media only screen and (max-width: 575px){

.addtocard .btn-cart{
	font-weight:bold !important;
	height:40px !important;
	margin:5px 10px !important;
	font-size:12px !important;
}

	}


</style>

							
								<div class="quantity d-flex flex-column flex-sm-row mt-3 mb-3">
									<div class="qbox d-flex mb-3">
										<div class="decreament" id="decreament" data-price="<?php print number_format($single['retail_price_tax'],2);?>" data-id="1">-</div>
										<div class="inputvalue" id="inputvalue"><?php print $single['min_qty'];?></div>
										<div class="increament" id="increament" data-price="<?php print number_format($single['retail_price_tax'],2);?>" data-id="1">+</div>
									</div>
									<div class="addtocard d-flex ">
									<?php 
										$givewaytags = isset($_GET['give']) ? $_GET['give'] : 0;
										if ( $givewaytags == 1 ) {
									?>
										<button type="button " class="btn btn-cart animate mb-3 w-100" id="addtocard" data-id="<?php print my_encrypt($single['product_id']);?>">Proceed to Game</button>
									<?php } else { ?>
										<button type="button " class="btn btn-cart animate mb-3 w-100" id="addtocard">Add to Cart</button>
									<?php } ?>
										<button type="button " class="btn btn-cart animate mb-3 w-100" id="buynow">Buy Now</button>
									</div>
									<div class="buybtn">
										<!-- <button type="button" class="btn btn-buy animate">Buy Now</button> -->
									</div>
								</div>
								<div class="addwishlist d-flex">
									<div class="wish-box d-flex me-4">
										<span class="icon" onclick="add_item_wish('<?php print my_encrypt($single['product_id']);?>','<?php print my_encrypt($single['pds']);?>',1);"><i class="fa-regular fa-heart"></i></span>
										<span class="text cursor"  onclick="add_item_wish('<?php print my_encrypt($single['product_id']);?>','<?php print my_encrypt($single['pds']);?>',1);">Add to wishlist</span>
									</div>
									<!-- <div class="wish-box d-flex ms-4">
										<span class="icon"><i class="fa-solid fa-arrow-right-arrow-left"></i></span>
										<span class="text">Compare</span>
									</div> -->
								</div>
								<div class="ask-block">
									<div class="help d-flex align-items-center mt-2 mb-2">
										<span class="icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top"><i class="fa-solid fa-question"></i></span>
										<?php if ( getUserId() == 0 ) { ?>
										<span class="text cursor" onclick="showLogin('login');">Ask a Question</span>
										<?php } else {?>
										<span class="text cursor" onclick="askQuestion();">Ask a Question</span>
										<?php } ?>
									</div>
									<div class="social">
										<ul class="p-0 m-0 d-flex align-items-center">
											<li>
												<a href=""><i class="fa-brands fa-facebook-f"></i></a>
											</li>
											<li>
												<a href=""><i class="fa-brands fa-twitter"></i></a>
											</li>
											<li>
												<a href=""><i class="fa-brands fa-instagram"></i></a>
											</li>
											<li>
												<a href=""><i class="fa-brands fa-linkedin-in"></i></a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="inputhidden">
							<?php 
								$givewaytags = isset($_GET['give']) ? $_GET['give'] : 0;
								if ( $givewaytags == 1 ) {
							?>
							<input type="hidden" name="givewaytags" id="givewaytags" value="1" />
							<?php } else {?>
							<input type="hidden" name="givewaytags" id="givewaytags" value="0" />
							<?php } ?>
							<!-- <input type="hidden" name="attr[]" class="attr_hidden" value="1_1"> -->
							<input type="hidden" name="qtycart" id="qtycart" value="<?php print $single['min_qty'];?>" />
							<input type="hidden" name="pid" id="pid" value="<?php print my_encrypt($single['product_id']);?>" />
							<?php if ( $single['deal_enable'] > 0 ) { ?>
							<input type="hidden" name="itemprice" class="itemprice_1" id="itemprice" value="<?php print number_format($single['deal_final_price'],2);?>" />
							<?php } else { ?>
							<input type="hidden" name="itemprice" class="itemprice_1" id="itemprice" value="<?php print number_format($single['final_price'],2);?>" />
							<?php } ?>
							<input type="hidden" name="pname" id="pname" value="<?php print ucfirst($single['name']);?>" />
						<?php 
							if ( !empty($single['cover']) ) {
								$value_img_ext_product = explode('.', $single['cover']);
						?>
							<input type="hidden" name="item_image" id="item_image" value="<?php print base_url().'/images/product/'.$value_img_ext_product[0].'/'.end($value_img_ext_product).'/250';?>" />
						<?php } else { ?>
							<input type="hidden" name="item_image" id="item_image" value="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" />
						<?php } ?>
                			<input type="hidden" id="_ajax_request" value="<?php print csrf_hash(); ?>">
                			<input type="hidden" id="_data_handle" value="<?php print $single['handlingcharges'];?>">
                			<input type="hidden" id="_data_transfer" value="<?php print $single['freeshipat'];?>">
						</div>
					</form>
				</div>
			</div>
			<div class="row cst-m-50">
				<div class="col-12 p-0">
					<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
					  <li class="nav-item" role="presentation">
					    <button class="nav-link active" id="DESCRIPTION-tab" data-bs-toggle="tab" data-bs-target="#DESCRIPTION" type="button" role="tab" aria-controls="DESCRIPTION" aria-selected="true">DESCRIPTION</button>
					  </li>
					  <!-- <li class="nav-item" role="presentation">
					    <button class="nav-link" id="SHIPPING-tab" data-bs-toggle="tab" data-bs-target="#SHIPPING" type="button" role="tab" aria-controls="SHIPPING" aria-selected="false">SHIPPING & RETUENS</button>
					  </li> -->
					  <li class="nav-item" role="presentation">
					    <button class="nav-link" id="REVIEWS-tab" data-bs-toggle="tab" data-bs-target="#REVIEWS" type="button" role="tab" aria-controls="REVIEWS" aria-selected="false">REVIEWS</button>
					  </li>
					</ul>
					<div class="tab-content" id="myTabContent">
					  	<div class="tab-pane fade show active" id="DESCRIPTION" role="tabpanel" aria-labelledby="DESCRIPTION-tab">
					  		<?php print html_entity_decode($single['description'])?>
					 	</div>
						<!-- <div class="tab-pane fade" id="SHIPPING" role="tabpanel" aria-labelledby="SHIPPING-tab">
						  	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
						</div> -->
					  	<div class="tab-pane fade reviewstabs" id="REVIEWS" role="tabpanel" aria-labelledby="REVIEWS-tab">

				  			<div class="row  d-flex justify-content-center">
				                <div class="col-md-12">
				                	<?php foreach ($reviews as $key => $r) { ?>
					                	<div class="card p-3">
					                        <div class="d-flex justify-content-between align-items-center">
							                    <div class="user d-flex flex-row align-items-center">
							                        <span><small class="font-weight-bold text-primary"><?php //print ucfirst($r->fname)?></small></span>
							                    </div>
							                    <small><?php print timeago($r->created_at);?></small>
							            	</div>
							            	<div class="justify-content-between align-items-center">
							            		<p><?=$r->comments?></p>
							            	</div>
					                      	<div class="action d-flex justify-content-between mt-2 align-items-center">
						                        <div class="icons align-items-center">
						                        	<div class="rating d-flex">
														<p class="me-4">
															<?php for ($i=1; $i <= 5; $i++) { ?>
																<i class="fa fa-star <?=$i<=$r->rates?'text-warning':''?>"></i>
															<?php } ?>
														</p>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
				                </div>
				            </div>
		



            

					  	</div>
					</div>

				</div>
			</div>
		</div>
	</section>

	<style>
		.related-slider .related-pro{
			width: 450px !important;
			max-width: 450px !important;
		}
	</style>

	<section class="storecats category-single cat-pro-list cst-s-50">
		<div class="container">
			<div class="cat-pro-head cst-m-50">
				<h2 class="text-center">Related Products</h2>
			</div>
			<div class="row mt-4 mb-4 related-slider ps-3 pe-3">
				<?php print view('site/stores/prolist',['count' => $related_products ]);?>
			</div>
		</div>
	</section>

<?php  } else { ?>
	<?php print view('site/404');?>
<?php } ?>
<?php print view('site/footer');?>
<script type="text/javascript">
	$(document).ready(function(){
    $('#buynow').on('click',function(e){
		e.preventDefault();
       $('#addtocard').click();
       $(document).ajaxStop(function() {
       		window.location.href='<?=base_url()?>/cart';
       })
    });
	$('#addtocard').click(function(e) {
		e.preventDefault();
		let dataid = $(this).data('id');
		$(document).ajaxStop(function() {
			if(dataid !== undefined && dataid){
				window.location.href = baseUrl + 'compaign/verify/'+dataid;
			}
       })
	})
});
</script>
<script>
	function zoom(e) {
		var zoomer = e.currentTarget;
		var offsetX = e.offsetX ? e.offsetX : e.touches[0].pageX;
		var offsetY = e.offsetY ? e.offsetY : e.touches[0].pageY;
		var x = (offsetX / zoomer.offsetWidth) * 100;
		var y = (offsetY / zoomer.offsetHeight) * 100;
		zoomer.style.backgroundPosition = x + '% ' + y + '%';
	}

	$('.shopping-image').click(function() {
		let id = $(this).attr('data-id');
		$('.shopping-image').removeClass('border-secondary');
		$('#main-image-viewer').find('.rtl-slider-slide').hide();
		$('#main-image-viewer').find('figure[data-id="'+id+'"]').parent().show();
		$(this).addClass('border-secondary');
	});

	$('.attrImgClick').click(function() {
		let img = $(this).attr('data-img');
		if(img) {
			let arr = img.split('.');
			arr.pop();
			let id = arr.join('.');
			$('.shopping-image[data-id="'+id+'"]').click();
		}
	});
</script>
