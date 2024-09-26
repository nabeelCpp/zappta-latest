<script>
	const nextBtn = $('#nextBtn');
	const prevBtn = $('#prevBtn');
	const saveBtn = $('#saveBtn');
	const errors = [];
	$('.nextTabBtn').click(function() { 
		errors.splice(0, errors.length); // make errors array empty;
		// reset validations
		resetValidations();
		let tab = $('#myTab');
		let sign = $(this).attr('data-id');
		let totalTabs = tab.find('li').length - 1;

		let currentTab = tab.find('.nav-link.active');
		let currentTabLi = currentTab.parent();
		let currentTabLiPos = currentTabLi.index();
		let nextTabPos = sign == '-' ? (currentTabLiPos - 1 ) : (currentTabLiPos + 1 );
		let nextTab = tab.find('li').eq(nextTabPos);
		let nextTabBtn = nextTab.find('.nav-link');
		let nextTabId = nextTabBtn.attr('data-bs-target');
		if(!checkValidations(currentTab.attr('data-bs-target'))) {
			$('#alertTabs').html(notificationUl(errors));
			return false;
		}
		// remove active from current element
		currentTab.removeClass('active');
		addDisabledClass(currentTab);
		// add active to next li
		
		
		
		nextTabBtn.addClass('active');
		// current tab content display
		showTabContent(nextTabId);
		removeDisabledClass(nextTab);
		if(nextTabPos < 1) {
			prevBtn.addClass('d-none');
			saveBtn.addClass('d-none');
		}else if(totalTabs > nextTabPos) {
			nextBtn.removeClass('d-none');
			prevBtn.removeClass('d-none');
			saveBtn.addClass('d-none');
		}else {
			saveBtn.removeClass('d-none');
			nextBtn.addClass('d-none');
		}
	});

	function addDisabledClass(element) {
		element.addClass('disabled');
	}

	function removeDisabledClass(element) {
		element.removeClass('disabled');
	}

	function showTabContent(nextTabId) {
		$('#myTabContent').find('.tab-pane').removeClass('show active');
		$(nextTabId).addClass('show active');
	}

	function notificationUl(errors) {
		return `<ul class="alert alert-danger px-5">
			${errors.map(e => `<li>${e}</li>`).join('')}
		</ul>`;
	}


	/**
	 * Check validations for tabs;
	 */
	function checkValidations(element) {
		// product validations
		const requiredFields = $(element).find('[required]');
		let success = true;
		const additionalRequiredFields = $('#productName[type="text"]').filter('[required]');
		// Combine the existing fields with the new ones
		const allRequiredFields = requiredFields.add(additionalRequiredFields);
		allRequiredFields.each(function() {
			let node = $(this).prop('tagName');
			let msg = $(this).attr('data-required');
			if((node.toLowerCase() === 'div' && ! $('input[name="'+$(this).attr('data-name')+'"]').length) || (node.toLowerCase() === 'input' && !$(this).val())) {
				$(this).addClass('border border-danger')
				errors.push(msg);
				success = false;
			}
		});
		return success;
	}

	const resetValidations = () => {
		$('[required]').removeClass('border border-danger');
		$('#alertTabs').html('');
	}
</script>