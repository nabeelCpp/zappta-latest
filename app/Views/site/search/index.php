<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>
<!-- noUiSlider CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.css" rel="stylesheet">

<!-- noUiSlider JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.js"></script>

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
							<h6 class="mb-5">Price</h6>
							<div id="price-slider" class="my-3"></div>
							<div class="d-flex justify-content-between mt-3">
								<input type="number" id="min-price" class="form-control"  min="0" max="300000" value="<?=$min_price ?? '' ?>">
								<span class="mx-2">-</span>
								<input type="number" id="max-price" class="form-control" min="0" max="300000" value="<?=$max_price ?? ''?>">
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
<script>
	document.addEventListener("DOMContentLoaded", function() {
    const priceSlider = document.getElementById('price-slider');
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
	let minprice = minPriceInput.value ? parseInt(minPriceInput.value) : 0;
	let maxprice = maxPriceInput.value ? parseInt(maxPriceInput.value) : 300000;
    // Initialize the noUiSlider
    noUiSlider.create(priceSlider, {
        start: [minprice ?? 0, maxprice ?? 300000],  // Starting values set to 0 and 300000
        connect: true,
        range: {
            'min': 0,          // Set minimum to 0
            'max': 300000      // Set maximum to 300000
        },
        tooltips: [true, true],
        format: {
            to: (value) => Math.round(value),
            from: (value) => Number(value)
        }
    });

    // Update input fields when slider values change
    priceSlider.noUiSlider.on('update', function(values, handle) {
        if (handle === 0) {
            minPriceInput.value = values[0];
        } else {
            maxPriceInput.value = values[1];
        }
    });

    // Update slider when min price input changes
    minPriceInput.addEventListener('change', function() {
        const minPrice = parseInt(minPriceInput.value) || 0;
        const maxPrice = parseInt(maxPriceInput.value) || 300000;
        priceSlider.noUiSlider.set([minPrice, maxPrice]);
    });

    // Update slider when max price input changes
    maxPriceInput.addEventListener('change', function() {
        const minPrice = parseInt(minPriceInput.value) || 0;
        const maxPrice = parseInt(maxPriceInput.value) || 300000;
        priceSlider.noUiSlider.set([minPrice, maxPrice]);
    });
});

const applyFilter = () => {
	const minPrice = document.getElementById('min-price').value;
	const maxPrice = document.getElementById('max-price').value;
	const url = '<?= $current_url ?>';
	const searchParams = new URLSearchParams(window.location.search);  // Get the current query parameters

	// Update or add the 'p' parameter with the price range
	searchParams.set('p', `${minPrice}-${maxPrice}`);
	// Reconstruct the full URL with the updated query string
	const updatedUrl = `${window.location.pathname}?${searchParams.toString()}`;
	window.location.href = updatedUrl;
}


</script>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>