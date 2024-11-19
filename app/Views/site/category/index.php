<?php $globalSettings = (new \App\Models\Setting())->orderBy('id', 'ASC')->GetValues(['company_name', 'frontend_logo']);
$brand_get = $next['brand_get'] = isset($_GET['b']) ? $_GET['b'] : 0;
$size_link = $next['size_link'] = isset($_GET['size']) ? '&size=' . $_GET['size'] : '';
$color_link = $next['color_link'] =  isset($_GET['color']) ? '&color=' . $_GET['color'] : '';
$dimension_link = $next['dimension_link'] =  isset($_GET['dimension']) ? '&dimension=' . $_GET['dimension'] : '';
$paper_type_link = $next['paper_type_link'] =  isset($_GET['paper_type']) ? '&paper_type=' . $_GET['paper_type'] : '';
$pf = $next['pf'] =  isset($_GET['p']) ?  '&p=' . $_GET['p'] : '';
?>
<?= view('site/newLanding/header', ['globalSettings' => $globalSettings]); ?>
<?php
if (isset($category_id) && ! empty($category_id['cat_img'])) {
?>
	<div class="BannerSection">
		<img src="<?= $category_id['cat_img'] ?>" alt="" />
	</div>
<?php } ?>

<!-- ./ Banner-section end-->

<!-- section dividie Layout// -->
<section class="py-5">
	<div class="container">
		<div class="row">
			<!-- sidebar //// -->
			<div class="col-12 col-md-4 col-lg-3">
				<div class="sidebarCollapse">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php print base_url(); ?>">Home</a></li>
							<li class="breadcrumb-item" aria-current="page">
								<a href="<?php print base_url() . '/categories'; ?>">Categories</a>
							</li>
							<?php if (isset($category_id)) { ?>
								<li> / </li>
								<li class="breadcrumb-item active"><?php print $category_id['cat_name']; ?></li>
							<?php } ?>
						</ol>
					</nav>
					<div>
						<form method="get" action="<?php print base_url() . '/categories/'.$category_id['cat_url']; ?>" class="category-form-wrap">
							<input class="form-control" type="text" name="q" placeholder="Search...">
							<input type="submit" class="searchIcon" />
						</form>

					</div>
					<?php
					if (isset($_GET['b']) || isset($_GET['size']) || isset($_GET['color']) || isset($_GET['dimension']) || isset($_GET['paper_type']) || isset($_GET['p'])) {
					?>
						<div class="clearfilter">
							<a href="<?php print base_url() . '/categories/' . $category_id['cat_url']; ?>">Clear Filter</a>
						</div>
					<?php
					}
					?>

					<ul class="nav nav-vertical" id="filterNav">
						<?php if (is_array($allcat) && count($allcat) > 0) { ?>
							<li class="nav-item">
								<a class="nav-link dropdown-toggle mb-3" data-bs-toggle="collapse" href="#seasonCollapse" aria-expanded="true">
									Product Categories
								</a>
								<div class="collapse show" id="seasonCollapse" data-simplebar-collapse="#seasonGroup">
									<div class="form-group form-group-overflow mb-6" id="seasonGroup" data-simplebar="init">
										<?php foreach ($allcat as $cat) { ?>
											<div class="form-check mb-3">
												<input class="form-check-input" id="<?= $cat['cat_url'] ?>" type="checkbox" <?= $category_id['cat_url'] == $cat['cat_url'] ? 'checked' : '' ?> onclick="location.href='<?php print base_url() . '/categories/' . $cat['cat_url']; ?>'">
												<label class="form-check-label" for="<?= $cat['cat_url'] ?>">
													<?php print ucfirst($cat['cat_name']); ?>
												</label>
											</div>
										<?php } ?>
									</div>
								</div>
							</li>
						<?php } ?>
						<?php if (is_array($brands) && count($brands) > 0) { ?>
							<li class="nav-item">
								<a class="nav-link dropdown-toggle mb-3" data-bs-toggle="collapse" href="#seasonCollapse2" aria-expanded="true">
									Brands
								</a>
								<div class="collapse show" id="seasonCollapse2" data-simplebar-collapse="#seasonGroup2">
									<div class="form-group form-group-overflow mb-6" id="seasonGroup2" data-simplebar="init">
										<?php foreach ($brands as $bra) { ?>
											<div class="form-check mb-3">
												<input class="form-check-input" id="seasonOne2" type="checkbox" onclick="location.href='<?php print base_url() . '/categories/' . $category_id['cat_url'] . '/?b=' . my_encrypt($bra['id']) . $size_link . $color_link . $dimension_link . $paper_type_link . $pf; ?>'">
												<label class="form-check-label" for="seasonOne2">
													<?php print $bra['name']; ?>
												</label>
											</div>
										<?php } ?>
										<a class="seeAllBtn" href="#">See All</a>
									</div>
								</div>
							</li>
						<?php } ?>
						<?= view('site/category/options', $next) ?>
						<li class="nav-item">
							<a class="nav-link dropdown-toggle mb-3" data-bs-toggle="collapse" href="#seasonCollapse3" aria-expanded="true">
								Price ($)
							</a>
							<div class="collapse show my-5" id="seasonCollapse3" data-simplebar-collapse="#seasonGroup3">
								<div id="price-slider" class="my-3"></div>
								<div class="d-flex justify-content-between mt-3">
									<input type="number" id="min-price" class="form-control"  min="0" max="5000" value="<?=$min_price ?? '' ?>">
									<span class="mx-2">-</span>
									<input type="number" id="max-price" class="form-control" min="0" max="5000" value="<?=$max_price ?? ''?>">
								</div>
								<div class="text-center mt-3">
									<button class="btn btn-secondary px-5" onclick="applyFilter()">Filter</button>
								</div>
							</div>
						</li>
					</ul>


				</div>
			</div>
			<!-- end sidebarr // -->
			<!-- content /// -->
			<div class="col-12 col-md-8 col-lg-9">
				<div class="contentsListing">
					<div class="d-flex justify-content-between mb-3">
						<?=displayResultsPhrase($page, $product_limit, $total_products)?>
						<select class="customSelect">
							<option>Sort by Latest</option>
							<option>Sort by Prices</option>
							<option>Sort by Brands</option>
						</select>
					</div>
					<div class="row">
						<?php if (is_array($products) && count($products) > 0) { ?>
							<?= view('site/stores/prolist', ['count' => $products]) ?>
						<?php } else { ?>
							<div class="col-12">
								<div class="alert alert-warning text-center" role="alert">
									No products found!
								</div>
							</div>
						<?php } ?>

					</div>
					<?php if ($total_products > $product_limit) { ?>
						<?php print $pager->makeLinks($page, $product_limit, $total_products, 'zappta_new') ?>
					<?php } ?>
				</div>
			</div>

			<!-- end content /// -->
		</div>
	</div>
</section>

<?= view('site/search/price-slider-script') ?>

<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>