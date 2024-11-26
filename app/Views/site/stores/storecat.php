
<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>
<?php 
	if( !empty($store) ) {
?>
	<?php 
		if ( $vendor_design > 0 && !empty($vendor_design['header_banner']) ) {
			$img_ext = explode('.',$vendor_design['header_banner']);
	?>
	<section class="storeBanner animate" style="background-image: url('<?php print base_url().'images/media/'.$img_ext[0].'/'.$img_ext[1].'/1980';?>');"></section>
	<?php } else { ?>
	<section class="storeBanner animate" style="background-image: url('<?php print base_url().'upload/stores/Image-10.jpg';?>');"></section>
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
								<a href="<?php print base_url().'stores/'.strtolower($store['store_slug']);?>">Stores</a>
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
							<!-- btns animate -->
							<button type="button" class="btns animate" onclick="window.location.href='<?php print '/stores/'.$store['store_slug'];?>'" style="color: #fb5000;background: #ffffff;">Home</button>
						</div>
						<div class="links">
							<?php print StoreCatTree( buildTree($categories),'/stores/'.$store['store_slug'] );?>
						</div>
						<div class="searchStore">
							<div class="input-field position-relative">
								<form method="get" action="<?php print $search_url;?>">
									<?php if ( isset($_GET['cat']) && isset($_GET['p']) ) { ?>
										<input type="hidden" name="cat" value="<?php print isset($_GET['cat']) ? $_GET['cat']: '';?>" />
										<input type="hidden" name="p" value="<?php print isset($_GET['p']) ? $_GET['p']: '';?>" />
									<?php } ?>
									<input type="text" name="searchq" placeholder="Search Product" />
									<span class="position-absolute"><i class="fa fa-search"></i></span>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="storecats">
		<div class="container">

			<div class="cat-pro-list mt-4 mb-4">
				<div class="d-flex">
					<?php print view('site/stores/prolist',['count' => $products]);?>
				</div>
			</div>

		</div>
	</section>
	<script>
		currentUrl = "<?php print base_url().'stores/'.$store['store_slug'];?>";
	</script>
<?php } else { ?>
	<?php print view('site/404');?>
<?php }?>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>