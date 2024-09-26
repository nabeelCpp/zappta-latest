
<?php print view('site/header');?>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
/>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<header class="alert alert-secondary text-center">Winners For Compaign Has been Announced <a href="<?= base_url().route_to('compaign.winners')?>">click here</a></header>
<?php print view('site/slider');?>
<?php print view('site/compaign');?>

<style>
							.swiper {
  width: auto;
  height: auto;
}
						</style>
		<section class="gtext-block mt-4">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="livetext">
							<h3 style="line-height:1.8" class="d-flex flex-column flex-md-row align-items-center">
								<b class="me-2">Gain winning power</b>
								<span>Stores that pay more than 10X Zapptas.</span>
							</h3>
							<div class="seemorelink float-start">
								<a href="<?=base_url()?>/stores">Shop Now</a>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<div class="d-flex  flex-wrap justify-content-center">
					<!-- Slider main container -->
					<div class="swiper">
						<!-- Additional required wrapper -->
						<div class="swiper-wrapper mb-5">
							<!-- Slides -->
							<?php $count = count($store); 
								if($count > 10){
									$stores = array_chunk($store, 10);
								}else{
									$stores[] = $store;
								}
								foreach ($stores as $key => $store) {
							?>
							<div class="swiper-slide">
								<div class="row">
									<?php 
									// for($i=1; $i<=10;$i++){
									if( is_array($store) && count($store) > 0 ) {
										foreach( $store as $st ) { ?>
											<div class="p-3 col-lg-2 my-2 comp-img-card" style="box-shadow: 0px 3px 6px #00000029;">
												<div class="logo-img">
													<a href="<?php print base_url().'/stores/'.$st['store_slug'];?>">
														<div class="lgimg">
															<?php 
																if( ! empty( $st['store_logo'] ) ) { 
																	$ext_name = explode('.',$st['store_logo']);
															?>
																<img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/250';?>" class="animate" alt="">
															<?php } else { ?>
																<img src="<?php print base_url().'/images/media/img-not-found/jpg/100';?>" class="animate" alt="" >
															<?php }?>
														</div>
														<?php if($st['earn_zappta'] && $st['per_dollar']){ ?>
														<div class="lgztext">
															<span>
																<!--<svg xmlns="http://www.w3.org/2000/svg" width="11" height="24" viewBox="0 0 11 24">-->
																<!--  <g id="Group_1" data-name="Group 1" transform="translate(-1363 -79)">-->
																<!--    <text id="Z" transform="translate(1363 98)" fill="#fb5000" font-size="18" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>-->
																<!--    <g id="Rectangle_4" data-name="Rectangle 4" transform="translate(1367 82)" fill="#fff" stroke="#fb5000" stroke-width="1">-->
																<!--      <rect width="2" height="4" stroke="none"/>-->
																<!--      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>-->
																<!--    </g>-->
																<!--    <g id="Rectangle_5" data-name="Rectangle 5" transform="translate(1367 98)" fill="#fff" stroke="#fb5000" stroke-width="1">-->
																<!--      <rect width="2" height="4" stroke="none"/>-->
																<!--      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>-->
																<!--    </g>-->
																<!--  </g>-->
																<!--</svg>-->
															</span>
																<span class="zzf">+<?=$st['earn_zappta']?> Zapptas / $<?=$st['per_dollar']?></span>
														</div>
														<?php } ?>
													</a>
												</div>
											</div>
										<?php }
									} ?>
								</div>
							</div>
							<?php } ?>
						</div>
						<!-- If we need pagination -->
						<div class="swiper-pagination"></div>
					</div>


					
				</div>
			</div>
		</section>

		<script>
			const swiper = new Swiper('.swiper', {
				// Optional parameters
				slidesPerView: 1,
				spaceBetween: 10,
				centeredSlides: true,
				direction: 'horizontal',
				loop: true,

				// If we need pagination
				pagination: {
					el: '.swiper-pagination',
				},

			});
		</script>

		<section class="category-home-block">
			<div class="container">

			<h3 class="mb-3 fw-bold"> Explore Popular Categories</h3>
				<div class="row" id="homeCategorySlider">
					<?php 
						if ( is_array($categories) && count($categories) > 0 ) {
							foreach( $categories as $homecat ) {
					?>
					<div class="col-xl-12">
						<div class="homecat">
							<a href="<?php print base_url().'/categories/'.$homecat['cat_url'];?>">
								<div class="cat-img">
									<?php 
					    				if( ! empty( $homecat['cat_icon'] ) ) { 
					    					$ext_name = explode('.',$homecat['cat_icon']);
					    			?>
					    				<img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/350';?>" class="animate img-responsive" alt="">
					    			<?php } else { ?>
					    				<img src="<?php print base_url().'/images/product/img-not-found/jpg/350';?>" class="animate img-responsive" alt="">
					    			<?php }?>
								</div>
								<h3><?php print $homecat['cat_name'];?></h3>
							</a>
						</div>
					</div>
					<?php
							}
						}
					?>
				</div>
			</div>
		</section>


		<section class="weekly-vendor">
			<div class="container">
				<div class="weekly-header">
					<h3>Top <?=$vendor_display_setting?>LY vendors</h3>
				</div>
				<?php if(count($top_vendors) > 0){ ?>
				<div class="row weekrow">
					<?php foreach ($top_vendors as $key => $t_v) { ?>
						<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-3">
							<div class="h-vendor-detail">
								<div class="h-vendor-top d-flex align-items-center" style="cursor: pointer;" onclick="location.href='<?php print base_url().'/stores/'.$t_v['store_slug'];?>'">
									<div class="h-vendor-img">
										<?php 
											if( ! empty( $t_v['store_logo'] ) ) { 
												$ext_name = explode('.',$t_v['store_logo']); ?>
												<img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/250';?>">
											<?php } else { ?>
												<img src="<?php print base_url().'/images/media/img-not-found/jpg/100';?>">
											<?php } ?>
									</div>
									<div class="h-vendor-text">
										<h4><?=$t_v['store_name']?> <span>(<?=$t_v['products']?> Products)</span></h4>
										<div class="h-vendor-rate d-flex">
											<span><i class="fa-solid fa-star"></i></span>
											<span><i class="fa-solid fa-star"></i></span>
											<span><i class="fa-solid fa-star"></i></span>
											<span><i class="fa-solid fa-star"></i></span>
											<span><i class="fa-solid fa-star"></i></span>
										</div>
									</div>
								</div>
								<div class="h-vendor-middle">
									<?php if($t_v['per_dollar']){ ?>
										<div class="h-vendor-zp d-flex">
											<!--<span>-->
											<!--	<svg xmlns="http://www.w3.org/2000/svg" width="11" height="24" viewBox="0 0 11 24">-->
											<!--	<g id="Group_1" data-name="Group 1" transform="translate(-1363 -79)">-->
											<!--		<text id="Z" transform="translate(1363 98)" fill="#fb5000" font-size="18" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>-->
											<!--		<g id="Rectangle_4" data-name="Rectangle 4" transform="translate(1367 82)" fill="#fff" stroke="#fb5000" stroke-width="1">-->
											<!--		<rect width="2" height="4" stroke="none"/>-->
											<!--		<rect x="0.5" y="0.5" width="1" height="3" fill="none"/>-->
											<!--		</g>-->
											<!--		<g id="Rectangle_5" data-name="Rectangle 5" transform="translate(1367 98)" fill="#fff" stroke="#fb5000" stroke-width="1">-->
											<!--		<rect width="2" height="4" stroke="none"/>-->
											<!--		<rect x="0.5" y="0.5" width="1" height="3" fill="none"/>-->
											<!--		</g>-->
											<!--	</g>-->
											<!--	</svg>-->
											<!--</span>-->
											<span>+<?=$t_v['earn_zappta'] ?> Zapptas / $<?=$t_v['per_dollar']?></span>
										</div>
									<?php } ?>
								</div>
								<div class="h-vendor-bottom">
									<?php if(count($t_v['top_products'])>0){ ?>
										<div class="row">
											<?php for ($p = 0; $p < count($t_v['top_products']); $p++) { ?>
												<?php if($p == 0){ ?>
													<div class="col-8 p-0" style="cursor: pointer;">
														<?php if( ! empty( $t_v['top_products'][$p]['cover'] ) ) { 
															$ext_name = explode('.',$t_v['top_products'][$p]['cover']); ?>
															<img src="<?php print base_url().'/images/product/'.$ext_name[0].'/'.$ext_name[1].'/600';?>">
														<?php } else { ?>
															<img src="<?php print base_url().'/images/media/img-not-found/jpg/600';?>" >
														<?php } ?>
													</div>
												<?php continue; } ?>
												<?php if($p == 1){ ?>
													<div class="col-4">
												<?php } ?>
														<div class="rightvimg" style="cursor: pointer;" >
															<?php if( ! empty( $t_v['top_products'][$p]['cover'] ) ) { 
																$ext_name = explode('.',$t_v['top_products'][$p]['cover']); ?>
																<img src="<?php print base_url().'/images/product/'.$ext_name[0].'/'.$ext_name[1].'/600';?>">
															<?php } else { ?>
																<img src="<?php print base_url().'/images/media/img-not-found/jpg/600';?>" >
															<?php } ?>
														</div>
												<?php if($p == count($t_v['top_products'])-1){ ?>
													</div>
												<?php } ?>
											<?php } ?>
										</div>
									<?php }else{ ?>
										<div class="row">
											<div class="col-md-12 text-center">No products found!</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php }else{ ?>
					<div class="row">
						<div class="col-md-12 text-center">No Vendors found!</div>
					</div>
				<?php } ?>
			</div>
		</section>


	
<?php print view('site/footer');?>

<script type="text/javascript">
			$('#giveawayCategorySlider').slick({
				slidesToShow: 4,
				slidesToScroll: 1,
				autoplay: false,
				autoplaySpeed: 2000,
				infinite: true,
				arrows: true,
				nextArrow: '<button class="nextArrow"><i class="fa-solid fa-chevron-right"></i></button>',
				prevArrow: '<button class="prevArrow"><i class="fa-solid fa-chevron-left"></i></button>',
				responsive: [
			    {
			      breakpoint: 1081,
			      settings: {
			        centerMode: true,
			        centerPadding: '0px',
			        slidesToShow: 4
			      }
			    },
			    {
			      breakpoint: 845,
			      settings: {
			        centerMode: true,
			        centerPadding: '0px',
			        slidesToShow: 2
			      }
			    },
			    {
			      breakpoint: 577,
			      settings: {
			        centerMode: true,
			        centerPadding: '0px',
			        slidesToShow: 1
			      }
			    },
			    {
			      breakpoint: 481,
			      settings: {
			        centerMode: true,
			        centerPadding: '0px',
			        slidesToShow: 1
			      }
			    }
			  	]
			});


			$('#giveawayCategorySliderUpcoming').slick({
				slidesToShow: 4,
				slidesToScroll: 1,
				autoplay: false,
				autoplaySpeed: 2000,
				infinite: true,
				arrows: true,
				nextArrow: '<button class="nextArrow"><i class="fa-solid fa-chevron-right"></i></button>',
				prevArrow: '<button class="prevArrow"><i class="fa-solid fa-chevron-left"></i></button>',
				responsive: [
			    {
			      breakpoint: 1081,
			      settings: {
			        centerMode: true,
			        centerPadding: '0px',
			        slidesToShow: 4
			      }
			    },
			    {
			      breakpoint: 845,
			      settings: {
			        centerMode: true,
			        centerPadding: '0px',
			        slidesToShow: 2
			      }
			    },
			    {
			      breakpoint: 577,
			      settings: {
			        centerMode: true,
			        centerPadding: '0px',
			        slidesToShow: 1
			      }
			    },
			    {
			      breakpoint: 481,
			      settings: {
			        centerMode: true,
			        centerPadding: '0px',
			        slidesToShow: 1
			      }
			    }
			  	]
			});
		</script>