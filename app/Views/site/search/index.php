<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>

<!-- section dividie Layout// -->
<section class="py-5">
	<div class="container">
		<div class="row">
			<!-- sidebar //// -->
			<div class="col-12 col-md-4 col-lg-3">
				<div class="sidebarCollapse">

					<ul class="nav nav-vertical" id="filterNav">
						<li class="nav-item">
							<a class="nav-link dropdown-toggle mb-3" data-bs-toggle="collapse" href="#seasonCollapse" aria-expanded="true">
								Product Categories
							</a>
							<div class="collapse show" id="seasonCollapse" data-simplebar-collapse="#seasonGroup">
								<div class="form-group form-group-overflow mb-6" id="seasonGroup" data-simplebar="init">
									<div class="form-check mb-3">
										<input class="form-check-input" id="seasonOne" type="checkbox" <?= $search_cat == 0?'checked=""':''?> onchange="location.href='<?=base_url('search?c=0')?>'">
										<label class="form-check-label" for="seasonOne">
											All
										</label>
									</div>
									<?php 
									foreach ($categories as $key => $cat) { ?>
										<div class="form-check">
											<input class="form-check-input" id="season<?=$cat['id']?>" type="checkbox" <?= $search_cat == $cat['id']?'checked=""':''?> onchange="location.href='<?=base_url('search?c='.my_encrypt($cat['id']))?>'">
											<label class="form-check-label" for="season<?=$cat['id']?>">
												<?=$cat['cat_name']?>
											</label>
										</div>
									<?php	
									} 
									?>
								</div>
							</div>
						</li>
						<li class="nav-item">
							<a class="nav-link dropdown-toggle mb-3" data-bs-toggle="collapse" href="#seasonCollapse1" aria-expanded="true">
								Vendors
							</a>
							<div class="collapse show" id="seasonCollapse1" data-simplebar-collapse="#seasonGroup1">
								<div class="form-group form-group-overflow mb-6" id="seasonGroup1" data-simplebar="init">
									<?php 
									foreach ($vendors as $key => $vendor) { ?>
										<div class="form-check mb-3">
											<input class="form-check-input" id="seasonOne<?=$vendor['id']?>" type="checkbox">
											<label class="form-check-label" for="seasonOne<?=$vendor['id']?>">
												<?=$vendor['store_name']?>
											</label>
										</div>
									<?php } ?>
								</div>
							</div>
						</li>
						<li class="nav-item">
							<a class="nav-link dropdown-toggle mb-3" data-bs-toggle="collapse" href="#seasonCollapse2" aria-expanded="true">
								Brands
							</a>
							<div class="collapse show" id="seasonCollapse2" data-simplebar-collapse="#seasonGroup2">
								<div class="form-group form-group-overflow mb-6" id="seasonGroup2" data-simplebar="init">
									<?php
									foreach ($brands as $key => $brand) { ?>
										<div class="form-check mb-3">
											<input class="form-check-input" id="seasonOne<?=$brand['id']?>" type="checkbox">
											<label class="form-check-label" for="seasonOne<?=$brand['id']?>">
												<?=$brand['name']?>
											</label>
										</div>
									<?php
									} ?>
									<!-- <a class="seeAllBtn" href="#">See All</a> -->
								</div>
							</div>
						</li>
						<li class="nav-item">
							<h6 class="mb-5">Price ($)</h6>
							<div id="price-slider" class="my-3"></div>
							<div class="d-flex justify-content-between mt-3">
								<input type="number" id="min-price" class="form-control"  min="0" max="5000" value="<?=$min_price ?? '' ?>">
								<span class="mx-2">-</span>
								<input type="number" id="max-price" class="form-control" min="0" max="5000" value="<?=$max_price ?? ''?>">
							</div>
							<div class="text-center mt-3">
								<button class="btn btn-secondary px-5" onclick="applyFilter()">Filter</button>
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
						<?=displayResultsPhrase($page, $limit, $total_products)?>
						<select class="customSelect">
							<option>Sort by Latest</option>
							<option>Sort by Prices</option>
							<option>Sort by Brands</option>
						</select>
					</div>
					<div class="row">
						<?php if (is_array($products) && count($products) > 0) { ?>
							<?php print view('site/stores/prolist', ['count' => $products]); ?>
						<?php } else { ?>
							<div class="col-12">
								<p class="alert alert-danger">No result found</p>
							</div>
						<?php } ?>
					</div>
					<?php if ($total_products > 12) { ?>
						<?php print $pager->makeLinks($page, $limit, $total_products, 'zappta_new') ?>
					<?php } ?>
				</div>
			</div>

			<!-- end content /// -->
		</div>
	</div>
</section>
<?= view('site/search/price-slider-script') ?>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>