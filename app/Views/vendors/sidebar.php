<style>
	@media only screen and (max-width: 991px) {
		#mySidepanel {
			position: absolute !important;
			top: 0;
			left: 0;
			box-shadow: 0px 3px 6px #00000029;
			z-index: 2 !important;
			background-color: white !important;
			max-height: 100vh;
			overflow-y: auto;
			display: none;
		}

		#content {
			width: 100% !important;
		}
	}
</style>

<div id="mySidepanel" class="position-relative sidepanel admin-side ms-2 float-start">
	<div class="sidebar">

		<div class="logtext">
			<a href="javascript:void(0)" class="closebtn d-lg-none d-block text-end me-3 text-black fs-2" onclick="closeNav()">×</a>
			<h4 class="mt-0"><b>Hi, <?php print getVendorUserName(); ?></b></h4>
			<p>Thanks for being a zappta user.</p>
		</div>
		<div class="sidemenu border-menu">
			<ul class="sidebar-menu">
				<li class="<?php if (getUrlSegment()[0] == 'home') { ?> active<?php } ?>"><a href="<?php print base_url() . '/vendors'; ?>"><i class="fasa fabook"></i> <span>Dashboard</span></a></li>
				<li class="<?php if (getUrlSegment()[0] == 'products') { ?> active<?php } ?>">
					<a href="<?php print base_url() . '/vendors/products'; ?>"><i class="fasa facatalog"></i> <span>Catalog</span></a>
				</li>
				<li class="<?php if (getUrlSegment()[0] == 'orders') { ?> active<?php } ?>">
					<a href="<?php print base_url() . '/vendors/orders'; ?>"><i class="fasa faorders"></i> <span>Orders</span></a>
				</li>
				<li class="<?php if (getUrlSegment()[0] == 'shipping') { ?> active<?php } ?>">
					<a href="<?php print base_url() . '/vendors/shipping'; ?>"><i class="fasa fashipping"></i> <span>Shipping</span></a>
				</li>
				<li class="<?php if (getUrlSegment()[0] == 'invoices') { ?> active<?php } ?>">
					<a href="<?php print base_url() . '/vendors/invoices'; ?>"><i class="fasa fapayments"></i> <span>Payments</span></a>
				</li>
				<li class="<?php if (getUrlSegment()[0] == 'design') { ?> active<?php } ?>">
					<a href="<?php print base_url() . '/vendors/design'; ?>"><i class="fasa fa-solid fa-palette"></i> <span>Design</span></a>
				</li>
				<li class="<?php if (getUrlSegment()[0] == 'spree') { ?> active<?php } ?>">
					<a href="<?php print base_url() . '/vendors/spree'; ?>"><i class="fasa fa-solid fa-bell"></i> <span>Spree</span></a>
				</li>

				<li class="<?php if (getUrlSegment()[0] == 'attributes') { ?> active<?php } ?>">
					<a href="<?php print base_url() . '/vendors/attributes'; ?>"><i class="fa fa-bucket"></i> <span class="mx-3">Attributes</span></a>
				</li>
				<li class="<?php if (getUrlSegment()[0] == 'reports') { ?> active<?php } ?>">
					<a href="<?php print base_url() . '/vendors/reports'; ?>"><i class="fasa fareports"></i> <span>Reports</span></a>
				</li>
				<li class="<?php if (getUrlSegment()[0] == 'contact') { ?> active<?php } ?>">
					<a href="<?php print base_url() . '/vendors/contact'; ?>"><i class="fasa fareports"></i> <span>Contact Us</span></a>
				</li>
				<li class="header"></li>
				<li class="<?php if (getUrlSegment()[0] == 'account') { ?> active<?php } ?>"><a href="<?php print base_url() . '/vendors/account'; ?>"><i class="fasa faaccount"></i> <span>Account</span></a></li>
				<li><a href="<?php print base_url() . '/vendors/logout'; ?>"><i class="fasa falogout"></i> <span>Logout</span></a></li>
			</ul>
		</div>
	</div>
</div>


<script>
	function openNav() {
		document.getElementById("mySidepanel").style.display = "block";
	}

	function closeNav() {
		document.getElementById("mySidepanel").style.display = "none";
	}
</script>