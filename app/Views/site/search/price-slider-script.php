<!-- noUiSlider CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.css" rel="stylesheet">

<!-- noUiSlider JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.js"></script>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const priceSlider = document.getElementById('price-slider');
		const minPriceInput = document.getElementById('min-price');
		const maxPriceInput = document.getElementById('max-price');
		let min = 0;
		let max = 5000;
		let minprice = minPriceInput.value ? parseInt(minPriceInput.value) : min;
		let maxprice = maxPriceInput.value ? parseInt(maxPriceInput.value) : max;
		// Initialize the noUiSlider
		noUiSlider.create(priceSlider, {
			start: [minprice ?? min, maxprice ?? max],  // Starting values set to 0 and 300000
			connect: true,
			range: {
				'min': min,          // Set minimum to 0
				'max': max      // Set maximum to 300000
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
			const minPrice = parseInt(minPriceInput.value) || min;
			const maxPrice = parseInt(maxPriceInput.value) || max;
			priceSlider.noUiSlider.set([minPrice, maxPrice]);
		});

		// Update slider when max price input changes
		maxPriceInput.addEventListener('change', function() {
			const minPrice = parseInt(minPriceInput.value) || min;
			const maxPrice = parseInt(maxPriceInput.value) || max;
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
		let currentUrl = baseUrl+updatedUrl;
		// Remove multiple consecutive slashes (except for the domain part)
		currentUrl = currentUrl.replace(/([^:]\/)\/+/g, "$1");

		// Remove trailing slashes (except for the domain)
		currentUrl = currentUrl.replace(/\/+$/, '');
		window.location.href = currentUrl;
	}
</script>