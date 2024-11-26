<?php print view('site/header');?>
	<?php 
		if( isset($category_id) && ! empty( $category_id['cat_img'] ) ) { 
			$ext_name = explode('.',$category_id['cat_img']);
	?>
		<section class="storeBanner animate" style="background-image: url('<?php print base_url().'images/full/'.$ext_name[0].'/'.$ext_name[1];?>');"></section>
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
								<a href="<?php print base_url().'brands';?>">Brands</a>
							</li>
						<?php if ( isset($category_id) ) { ?>
							<li>/</li>
							<li><?php print $category_id['cat_name'];?></li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="category-page">
		<div class="container">
			<div class="row">
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<div class="cate-left">
						<div class="left-block-link search">
							<form method="get" action="<?php print base_url().'categories';?>">
								<label class="mb-1">Search Product</label>
								<div class="position-relative">
									<input type="text" name="q" placeholder="Search Product" class="form-control">
									<button type="submit" class="btn position-absolute"><i class="fas fa-search"></i></button>
								</div>
							</form>
						</div>

						<?php 
							if ( is_array($allcat) && count($allcat) > 0 ) {
						?>
						<div class="left-block-link category">
							<h3>Categories</h3>
							<ul class="pagelink">		
						<?php 		
								foreach( $allcat as $cat ) {
						?>		
								<li>
									<a href="<?php print base_url().'categories/'.$cat['cat_url'];?>"><?php print ucfirst($cat['cat_name']);?></a>
								</li>
						<?php
								}
						?>
							</ul>
						</div>
						<?php
							}
						?>	

						<?php if ( is_array($brands) && count($brands) > 0 ) { ?>
						<div class="left-block-link brands">
							<h3>Brands</h3>
							<ul class="pagelink">
								<?php foreach ( $brands as $bra ) { ?>
									<li>
										<a href="<?php print base_url().'brands/'.$bra['urls'];?>"><?php print $bra['name'];?></a>
									</li>
								<?php } ?>
							</ul>
						</div>
						<?php } ?>
						
					</div>
				</div>
				<div class="col-xl-9 col-lg-9 col-md-9 col-12  p-0 m-0">
					<div class="cat-pro-list catp mt-4 mb-4">
						<div class="row p-0 m-0">
						<?php if ( is_array($products) && count($products) > 0 ) { ?>
							<?php print view('site/stores/prolist',['count' => $products]);?>
						<?php } else { ?>
							<div class="col-12"><p class="alert alert-danger">No result found</p></div>
						<?php } ?>
						</div>
						<?php if ( $total_products > 12 ) { ?>
						<div class="pagenation">
							<?php print $pager->makeLinks($page, 12, $total_products,'front_full') ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php print view('site/footer');?>