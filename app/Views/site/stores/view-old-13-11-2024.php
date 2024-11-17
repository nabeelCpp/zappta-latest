<?php $globalSettings = (new \App\Models\Setting())->orderBy('id', 'ASC')->GetValues(['company_name', 'frontend_logo']); ?>
<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>
<?php 
	if( !empty($store) ) {
?>
	<?php 
		if ( $vendor_design > 0 && !empty($vendor_design['header_banner']) ) {
			$img_ext = explode('.',$vendor_design['header_banner']);
	?>
	<section class="storeBanner animate d-flex flex-row-reverse align-items-center" id="bannerSectionGala" style="background-image:  url('<?php print base_url().'/images/media/'.$img_ext[0].'/'.$img_ext[1].'/1980';?>');">
			
	</section>
	<?php } else { ?>
	<section class="storeBanner animate d-flex flex-row-reverse align-items-center" id="bannerSectionGala" style="background-image: url('<?php print base_url().'/upload/stores/Image-10.jpg';?>');"></section>
	<?php } ?>
	<section class="bread bg-white">
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
								<a href="<?php print base_url().'/stores/'.strtolower($store['store_slug'])?>">Stores</a>
							</li>
							<li>/</li>
							<li><?php print $store['store_name'];?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="storenav">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="navs d-flex">
						<div class="followbtn">
							<button type="button" class="btns animate" onclick="window.location.href='<?php print '/stores/'.$store['store_slug'];?>'">Home</button>
						</div>
						<div class="links">
							<?php print StoreCatTree( buildTree($categories),'/stores/'.$store['store_slug'] );?>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="storecats">
		<div class="container">
			
			<div class="cat-coll-m d-none mt-4 mb-4">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-12">
						<?php 
							if ( $vendor_design > 0 && !empty($vendor_design['category_banner_first']) ) {
								$img_ext = explode('.',$vendor_design['category_banner_first']);
								if ( !empty($vendor_design['category_link_second']) ) {
									$store_cat_slug = '/?cat='.$vendor_design['category_link_second'];
								} else {
									$store_cat_slug = '';
								}
						?>
						<a href="<?php print base_url().'/stores/'.$store['store_slug'].$store_cat_slug;?>">
							<div class="store-cat-banner animate" style="background-image:url('<?php print base_url().'/images/media/'.$img_ext[0].'/'.$img_ext[1].'/600';?>');">
								<div class="cat-logos">
								<?php if ( !empty($vendor_design['category_title_first']) ) {?>
									<div class="catname"></div>
								<?php } else { ?>
									<?php 
										if ( !empty($store['store_logo']) ) { 
											$img_ext = explode('.',$store['store_logo']);
									?>
										<img src="<?php print base_url().'/images/media/'.$img_ext[0].'/'.$img_ext[1].'/250';?>" alt="">
									<?php } else {?>
										<img src="<?php print base_url().'/theme/image/logo.png';?>" alt="">
									<?php } ?>
								<?php } ?>
								</div>
							</div>
						</a>
						<?php 
							} else {
						?>
						<div class="store-cat-banner animate">
							<div class="cat-logos">
							<?php 
								if ( !empty($store['store_logo']) ) { 
									$img_ext = explode('.',$store['store_logo']);
							?>
								<img src="<?php print base_url().'/images/media/'.$img_ext[0].'/'.$img_ext[1].'/250';?>" alt="">
							<?php } else {?>
								<img src="<?php print base_url().'/theme/image/logo.png';?>" alt="">
							<?php } ?>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-12">
						<div class="row">
							<div class="col-12">
								<?php 
									if ( $vendor_design > 0 && !empty($vendor_design['category_banner_second']) ) {
										$img_ext = explode('.',$vendor_design['category_banner_second']);
										if ( !empty($vendor_design['category_link_second']) ) {
											$store_cat_slug = '/?cat='.$vendor_design['category_link_second'];
										} else {
											$store_cat_slug = '';
										}
								?>
								<a href="<?php print base_url().'/stores/'.$store['store_slug'].$store_cat_slug;?>">
									<div class="store-cat-banner-left" style="background-image:url('<?php print base_url().'/images/media/'.$img_ext[0].'/'.$img_ext[1].'/600';?>');">
										<div class="catname"></div>
										<?php if ( !empty($vendor_design['category_link_second']) ) {?>
										<div class="shoplink"></div>
										<?php } ?>
									</div>
								</a>
								<?php } else { ?>
								<div class="store-cat-banner-left" style="background-image:url('<?php print base_url().'/upload/stores/11.png';?>');">
									<div class="catname"></div>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="row mt-4">

							<div class="col-xl-6 col-lg-6 col-md-6 col-12">
								<?php 
									if ( $vendor_design > 0 && !empty($vendor_design['category_banner_third']) ) {
										$img_ext = explode('.',$vendor_design['category_banner_third']);
										if ( !empty($vendor_design['category_link_second']) ) {
											$store_cat_slug = '/?cat='.$vendor_design['category_link_second'];
										} else {
											$store_cat_slug = '';
										}
								?>
								<a href="<?php print base_url().'/stores/'.$store['store_slug'].$store_cat_slug;?>">
									<div class="store-cat-banner-bottom" style="background-image:url('<?php print base_url().'/images/media/'.$img_ext[0].'/'.$img_ext[1].'/600';?>');">
										<div class="catname"></div>
										<?php if ( !empty($vendor_design['category_link_third']) ) {?>
										<div class="shoplink"></div>
										<?php } ?>
									</div>
								</a>
								<?php } else { ?>
								<div class="store-cat-banner-bottom" style="background-image:url('<?php print base_url().'/upload/stores/women.png';?>');">
									<div class="catname"></div>
								</div>
								<?php } ?>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-12">
								<?php 
									if ( $vendor_design > 0 && !empty($vendor_design['category_banner_fourth']) ) {
										$img_ext = explode('.',$vendor_design['category_banner_fourth']);
										if ( !empty($vendor_design['category_link_second']) ) {
											$store_cat_slug = '/?cat='.$vendor_design['category_link_second'];
										} else {
											$store_cat_slug = '';
										}
								?>
								<a href="<?php print base_url().'/stores/'.$store['store_slug'].$store_cat_slug;?>">
								<div class="store-cat-banner-bottom" style="background-image:url('<?php print base_url().'/images/media/'.$img_ext[0].'/'.$img_ext[1].'/600';?>');">
									<div class="catname"></div>
									<?php if ( !empty($vendor_design['category_link_fourth']) ) {?>
									<div class="shoplink"></div>
									<?php } ?>
								</a>
								</div>
								<?php } else { ?>
								<div class="store-cat-banner-bottom" style="background-image:url('<?php print base_url().'/upload/stores/kids.png';?>');">
									<div class="catname"></div>
								</div>
								<?php } ?>	
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row" id="newGalaDetails">
				
			</div>
			<div class="cat-pro-list mt-4 mb-4">
				<div class="cat-pro-head">
					<!-- <h2 class="text-center">Best Selling</h2> -->
				</div>
				<div class="row flex-wrap">
					<?php print view('site/stores/prolist',['count' => 8]);?>
				</div>
			</div>

			<div class="cat-pro-list mt-4 mb-4">
				<div class="cat-pro-head">
					<h2 class="text-center" id="storesProList">Top Trending</h2>
				</div>
				<div class="row flex-wrap justify-content-center">
					<?php print view('site/stores/prolist',['count' => $products, 'store'=>$store]);?>
				</div>
				<!-- <div class="row align-items-center justify-content-center marg-cst-50">
					<div class="col-12">
						<div class="pagination">
							<ul class="d-flex justify-content-center">
								<li>
									<a href="" class="animate"><i class="fa-solid fa-angle-left"></i></a>
								</li>
								<li>
									<a href="" class="active-pag animate">1</a>
								</li>
								<li>
									<a href="" class="animate">2</a>
								</li>
								<li>
									<a href="" class="animate">3</a>
								</li>
								<li>
									<a href="" class="animate">4</a>
								</li>
								<li>
									<a href="" class="animate"><i class="fa-solid fa-angle-right"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div> -->
			</div>

		</div>
	</section>
<?php } else { ?>
	<?php print view('site/404');?>
<?php }?>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>