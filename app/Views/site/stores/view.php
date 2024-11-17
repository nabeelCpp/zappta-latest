<?= view('site/newLanding/header', ['globalSettings' => $globalSettings]); ?>
<?php
if (!empty($store)) { ?>
	<!-- ./ Banner-section start -->
	<div class="BannerSection">
		<img src="<?=$vendor_design['header_banner']?>" alt="" />
	</div>
	<!-- ./ Banner-section end-->

	<!-- section dividie Layout// -->
	<section class="py-2 brandPage">
		<div class="container">
			<div class="row">
				<!-- sidebar // -->
				<div class="col-12">
					<div class="sidebarCollapse">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php print base_url();?>">Home</a></li>
								<li class="breadcrumb-item">Store</li>
								<li class="breadcrumb-item active" aria-current="page"><a href="<?php print base_url().'/stores/'.strtolower($store['store_slug'])?>"><?php print $store['store_name'];?></a></li>
							</ol>
						</nav>

					</div>
				</div>
			</div>
			<!-- end sidebarr // -->
			<!-- content /// -->

			<div class="contentsListing">
				<div class="d-flex justify-content-between align-items-center mb-1">
					<h2>All Products</h2>
					<form method="GET" action="<?php print $search_url;?>" class="category-form-wrap">
						<?php if ( isset($_GET['cat']) && isset($_GET['p']) ) { ?>
							<input type="hidden" name="cat" value="<?php print isset($_GET['cat']) ? $_GET['cat']: '';?>" />
							<input type="hidden" name="p" value="<?php print isset($_GET['p']) ? $_GET['p']: '';?>" />
						<?php } ?>
						<input class="form-control" type="text" name="searchq" placeholder="Search Product" value="<?=$_GET['searchq'] ?? null ?>">
						<input type="submit" class="searchIcon" />
					</form>
				</div>
				<div class="filterSectionTab gallery-wrap">

					<ul id="filters" class="filterSection clearfix">
						<li><span class="filter <?= !isset($_GET['cat']) ? 'active' : '' ?>" data-filter="*"><a href="<?php print '/stores/'.$store['store_slug'];?>">Home</a></span></li>
						
						<?php foreach ($categories as $key => $cat) { ?>
							<li><span class="filter <?= isset($_GET['cat']) && my_decrypt($_GET['p']) == $cat['id'] ? 'active' : '' ?>" data-slug="<?= $cat['cat_url'] ?>"><a href="<?= base_url("/stores/{$store['store_slug']}?cat={$cat['cat_url']}&p=".my_encrypt($cat['id'])) ?>"><?= $cat['cat_name']?></a></span></li>
						<?php } ?>
					</ul>

					<!-- <div id="gallery">

						<a class="gallery-item shirts" href="#" data-cat="shirts">
							<div class="productPostWraps">
								<div class="productPostThumbnail">
									<span class="giveAway">Giveaway</span>
									<img src="./assets/images/flannel-t-shirt.png" alt="" />
									<button class="btn heartSelection">
										whishlist
									</button>
								</div>
								<div class="productPostInfo">
									<h3 class="productPriceTag">$83.97</h3>
									<p>Vans Men's classic skate Shirt</p>
									<p class="earnTag">Earn <img src="./assets/images/zIcon.svg" alt="" /> 15 per $1 spent</p>
								</div>
							</div>
						</a>

						<a class="gallery-item shoes" href="#" data-cat="shoes">
							<div class="productPostWraps">
								<div class="productPostThumbnail">
									<span class="priceOff">40% off</span>
									<img src="./assets/images/shoes.png" alt="" />
									<button class="btn heartSelection">
										whishlist
									</button>
								</div>
								<div class="productPostInfo">
									<h3 class="productPriceTag">$83.97</h3>
									<p>Vans Men's classic skate Shirt</p>
									<p class="earnTag">Earn <img src="./assets/images/zIcon.svg" alt="" /> 15 per $1 spent</p>
								</div>
							</div>
						</a>

						<a class="gallery-item shirts" href="#" data-cat="shirts">
							<div class="productPostWraps">
								<div class="productPostThumbnail">
									<span class="priceOff">40% off</span>
									<img src="./assets/images/flannel-t-shirt.png" alt="" />
									<button class="btn heartSelection">
										whishlist
									</button>
								</div>
								<div class="productPostInfo">
									<h3 class="productPriceTag">$83.97</h3>
									<p>Vans Men's classic skate Shirt</p>
									<p class="earnTag">Earn <img src="./assets/images/zIcon.svg" alt="" /> 15 per $1 spent</p>
								</div>
							</div>
						</a>

						<a class="gallery-item shoes" href="#" data-cat="shoes">
							<div class="productPostWraps">
								<div class="productPostThumbnail">
									<span class="priceOff">40% off</span>
									<img src="./assets/images/flannel-t-shirt.png" alt="" />
									<button class="btn heartSelection">
										whishlist
									</button>
								</div>
								<div class="productPostInfo">
									<h3 class="productPriceTag">$83.97</h3>
									<p>Vans Men's classic skate Shirt</p>
									<p class="earnTag">Earn <img src="./assets/images/zIcon.svg" alt="" /> 15 per $1 spent</p>
								</div>
							</div>
						</a>

						<a class="gallery-item shirts" href="#" data-cat="shirts">
							<div class="productPostWraps">
								<div class="productPostThumbnail">
									<span class="priceOff">40% off</span>
									<img src="./assets/images/flannel-t-shirt.png" alt="" />
									<button class="btn heartSelection">
										whishlist
									</button>
								</div>
								<div class="productPostInfo">
									<h3 class="productPriceTag">$83.97</h3>
									<p>Vans Men's classic skate Shirt</p>
									<p class="earnTag">Earn <img src="./assets/images/zIcon.svg" alt="" /> 15 per $1 spent</p>
								</div>
							</div>
						</a>



					</div> -->
				</div>

				<h2 class="mb-5">Top Rated Products</h2>
				<div class="row ">
					<?php print view('site/stores/prolist',['count' => $products, 'store'=>$store, 'col' => 4]);?>
				</div>

			</div>


			<!-- end content /// -->

		</div>
	</section>
	<script>
		currentUrl = "<?php print base_url().'/stores/'.$store['store_slug'];?>";
	</script>
<?php
} else {
	print view('site/404');
} ?>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>