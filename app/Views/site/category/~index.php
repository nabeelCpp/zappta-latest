<?php print view('site/header');?>
	<?php 
		if( isset($category_id) && ! empty( $category_id['cat_img'] ) ) { 
			$ext_name = explode('.',$category_id['cat_img']);
	?>
		<section class="storeBanner animate" style="background-image: url('<?php print base_url().'/images/full/'.$ext_name[0].'/'.$ext_name[1];?>');"></section>
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
								<a href="<?php print base_url().'/categories';?>">Categories</a>
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
							<form method="get" action="<?php print base_url().'/categories';?>">
								<label class="mb-1">Search Product</label>
								<div class="position-relative">
									<input type="text" name="q" placeholder="Search Product" class="form-control">
									<button type="submit" class="btn position-absolute"><i class="fas fa-search"></i></button>
								</div>
							</form>
						</div>

						<?php 
							if ( isset($_GET['b']) || isset($_GET['size']) || isset($_GET['color']) || isset($_GET['dimension']) || isset($_GET['paper_type']) || isset($_GET['p']) ) {
						?>
						<div class="clearfilter">
							<a href="<?php print base_url().'/categories/'.$category_id['cat_url'];?>">Clear Filter</a>
						</div>
						<?php
							}
						?>

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
									<a href="<?php print base_url().'/categories/'.$cat['cat_url'];?>"><?php print ucfirst($cat['cat_name']);?></a>
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
							<?php 
								$brand_get = isset($_GET['b']) ? $_GET['b'] : 0;
								$size_link = isset($_GET['size']) ? '&size='.$_GET['size'] : '';
								$color_link = isset($_GET['color']) ? '&color='.$_GET['color'] : '';
								$dimension_link = isset($_GET['dimension']) ? '&dimension='.$_GET['dimension'] : '';
								$paper_type_link = isset($_GET['paper_type']) ? '&paper_type='.$_GET['paper_type'] : '';
								$pf = isset($_GET['p']) ?  '&p='.$_GET['p'] : '';
							?>
						<div class="left-block-link brands">
							<h3>Brands</h3>
							<ul class="pagelink">
								<?php foreach ( $brands as $bra ) { ?>
									<li>
										<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.my_encrypt($bra['id']).$size_link.$color_link.$dimension_link.$paper_type_link.$pf;?>"><?php print $bra['name'];?></a>
									</li>
								<?php } ?>
							</ul>
						</div>
						<?php } ?>
						
						<?php if ( is_array($getCatAttr) && count($getCatAttr) > 0 ) { ?>
						<div class="left-block-link filters">
							<?php 
								$brand_get = isset($_GET['b']) ? $_GET['b'] : 0;
								$size_link = isset($_GET['size']) ? '&size='.$_GET['size'] : '';
								$color_link = isset($_GET['color']) ? '&color='.$_GET['color'] : '';
								$dimension_link = isset($_GET['dimension']) ? '&dimension='.$_GET['dimension'] : '';
								$paper_type_link = isset($_GET['paper_type']) ? '&paper_type='.$_GET['paper_type'] : '';
								$pf = isset($_GET['p']) ?  '&p='.$_GET['p'] : '';
								$option_check = [1,2,3,4];
							?>
							<?php foreach ( $getCatAttr as $attr ) { ?>
						<?php if ( is_array($attr['values']) && count($attr['values']) > 0 ) { ?>
							<h3><?php print $attr['attr_name'];?></h3>
							<ul class="pagelink">
							<?php foreach ( $attr['values'] as $vv ) { ?>
								
								<li>
								<?php 
									switch ($vv['value_opt']) {
										case 1:
												$filter_url = '&size';
												$filter_ids = isset($_GET['size']) ? $_GET['size'] : 0;
												$filter_active = explode('|',$filter_ids);
								?>
									<?php if ( !empty($filter_ids) || $filter_ids > 0 ) { ?>
										<?php if ( in_array( my_encrypt($vv['id']), $filter_active ) ) { ?>
											<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$filter_url.'='.$filter_ids.$color_link.$dimension_link.$paper_type_link.$pf;?>" class="activeatr"><?php print $vv['name_en'];?></a>
										<?php } else { ?>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$filter_url.'='.$filter_ids.'|'.my_encrypt($vv['id']).$color_link.$dimension_link.$paper_type_link.$pf;?>"><?php print $vv['name_en'];?></a>
										<?php } ?>
									<?php } else { ?>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$filter_url.'='.my_encrypt($vv['id']).$color_link.$dimension_link.$paper_type_link.$pf;?>"><?php print $vv['name_en'];?></a>
									<?php } ?>
								<?php
										
											break;
										case 2:
												$filter_url = '&color';
												$filter_ids = isset($_GET['color']) ? $_GET['color'] : 0;
												$filter_active = explode('|',$filter_ids);
								?>
									<?php if ( !empty($filter_ids) || $filter_ids > 0 ) { ?>
										<?php if ( in_array( my_encrypt($vv['id']), $filter_active ) ) { ?>
											<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$filter_url.'='.$filter_ids.$dimension_link.$paper_type_link.$pf;?>" class="cclink"><span style="background-color: #<?php print $vv['color_code'];?>;" class="activeatr"></span></a>
										<?php } else { ?>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$filter_url.'='.$filter_ids.'|'.my_encrypt($vv['id']).$dimension_link.$paper_type_link.$pf;?>" class="cclink"><span style="background-color: #<?php print $vv['color_code'];?>;"></span></a>
										<?php } ?>
									<?php } else { ?>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$filter_url.'='.my_encrypt($vv['id']).$dimension_link.$paper_type_link.$pf;?>" class="cclink"><span style="background-color: #<?php print $vv['color_code'];?>;"></span></a>
									<?php } ?>
								<?php
											break;
										
										case 3:
												$filter_url = '&dimension';
												$filter_ids = isset($_GET['dimension']) ? $_GET['dimension'] : 0;
												$filter_active = explode('|',$filter_ids);
								?>
									<?php if ( !empty($filter_ids) || $filter_ids > 0 ) { ?>
										<?php if ( in_array( my_encrypt($vv['id']), $filter_active ) ) { ?>
											<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$filter_url.'='.$filter_ids.$paper_type_link.$pf;?>" class="activeatr"><?php print $vv['name_en'];?></a>
										<?php } else { ?>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$filter_url.'='.$filter_ids.'|'.my_encrypt($vv['id']).$paper_type_link.$pf;?>"><?php print $vv['name_en'];?></a>
										<?php } ?>
									<?php } else { ?>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$filter_url.'='.my_encrypt($vv['id']).$paper_type_link.$pf;?>"><?php print $vv['name_en'];?></a>
									<?php } ?>
								<?php
										
											break;

										case 4:
												$filter_url = '&paper_type';
												$filter_ids = isset($_GET[$filter_url]) ? $_GET[$filter_url] : 0;
												$filter_active = explode('|',$filter_ids);
								?>
									<?php if ( !empty($filter_ids) || $filter_ids > 0 ) { ?>
										<?php if ( in_array( my_encrypt($vv['id']), $filter_active ) ) { ?>
											<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$paper_type_link.$filter_url.'='.$filter_ids.$pf;?>" class="activeatr"><?php print $vv['name_en'];?></a>
										<?php } else { ?>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$paper_type_link.$filter_url.'='.$filter_ids.'|'.my_encrypt($vv['value_id']).$pf;?>"><?php print $vv['name_en'];?></a>
										<?php } ?>
									<?php } else { ?>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$paper_type_link.$filter_url.'='.my_encrypt($vv['id']).$pf;?>"><?php print $vv['name_en'];?></a>
									<?php } ?>
								<?php
										
											break;

										default:

											break;
									}
								?>
								</li>

							<?php } ?>
							</ul>
							<?php } ?>
						<?php } ?>
						</div>
						<?php } ?>

						<div class="left-block-link brands">
							<h3>Price</h3>
							<ul class="pagelink">
							<?php 
								$brand_get = isset($_GET['b']) ? $_GET['b'] : 0;
								$size_link = isset($_GET['size']) ? '&size='.$_GET['size'] : '';
								$color_link = isset($_GET['color']) ? '&color='.$_GET['color'] : '';
								$dimension_link = isset($_GET['dimension']) ? '&dimension='.$_GET['dimension'] : '';
								$paper_type_link = isset($_GET['paper_type']) ? '&paper_type='.$_GET['paper_type'] : '';
								$pf = isset($_GET['p']) ?  '&p='.$_GET['p'] : '';
							?>
								<li>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$paper_type_link.$paper_type_link.'&p=0-100';?>">
										<span>0</span>
										<span>--</span>
										<span>100</span>
									</a>
								</li>
								<li>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$paper_type_link.$paper_type_link.'&p=200-300';?>">
										<span>200</span>
										<span>--</span>
										<span>300</span>
									</a>
								</li>
								<li>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$paper_type_link.$paper_type_link.'&p=300-400';?>">
										<span>300</span>
										<span>--</span>
										<span>400</span>
									</a>
								</li>
								<li>
									<a href="<?php print base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$paper_type_link.$paper_type_link.'&p=400-a';?>">
										<span>400</span>
										<span>--</span>
										<span>Above</span>
									</a>
								</li>
							</ul>
						</div>

					</div>
				</div>
				<div class="col-xl-9 col-lg-9 col-md-9 col-12  p-0 m-0">
					<div class="cat-pro-list catp mt-4 mb-4">
						<div class="row p-0 m-0">
						<?php if ( is_array($products) && count($products) > 0 ) { ?>
							<?php print view('site/stores/~prolist',['count' => $products]);?>
						<?php } else { ?>
							<div class="col-12"><p class="alert alert-danger">No result found</p></div>
						<?php } ?>
						</div>
						<?php if ( $total_products > $product_limit ) { ?>
						<div class="pagenation">
							<?php print $pager->makeLinks($page, $product_limit, $total_products,'front_full') ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php print view('site/footer');?>