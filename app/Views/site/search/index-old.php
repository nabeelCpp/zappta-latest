<?= view('site/newLanding/header', ['globalSettings' => $globalSettings, 'css' => $css]); ?>
	<section class="category-page">
		<div class="container">
			<div class="row">
				<div class="col-xl-3 col-lg-3 col-md-3 col-12">
					<button class="btn btn-link see_details" data-id="0">See Details <i class="fa fa-arrow-down"></i></button>
					<div class="cate-left d-none">
						
						<?php 
							if ( isset($_GET['size']) || isset($_GET['color']) || isset($_GET['dimension']) || isset($_GET['paper_type']) || isset($_GET['p']) ) {
						?>
						<div class="clearfilter">
							<a href="<?php print base_url().'/search/?c='.$_GET['c'].'&searchq='.$_GET['searchq'].'&secure='.$_GET['secure'];?>">Clear Filter</a>
						</div>
						<?php
							}
						?>
						<?php 
							if ( is_array($attrbutes) && count($attrbutes) > 0 ) { 
								$size_link = isset($_GET['size']) ? '&size='.$_GET['size'] : '';
								$color_link = isset($_GET['color']) ? '&color='.$_GET['color'] : '';
								$dimension_link = isset($_GET['dimension']) ? '&dimension='.$_GET['dimension'] : '';
								$paper_type_link = isset($_GET['paper_type']) ? '&paper_type='.$_GET['paper_type'] : '';
								$pf = isset($_GET['p']) ?  '&p='.$_GET['p'] : '';
								$option_check = [1,2,3,4];
						?>
							
							<div class="left-block-link filters">
								<?php foreach ( $attrbutes as $attrkey => $attrvalues ) { ?>
									<h3><?php print $attrkey;?></h3>
								<ul class="pagelink">
										<?php foreach( $attrvalues as $vv ) {?>
								<li>
								<?php 
									switch ($vv['value_opt']) {
										case 1:
												$filter_url = 'size';
												$filter_ids = isset($_GET[$filter_url]) ? $_GET[$filter_url] : 0;
												$filter_active = explode('|',$filter_ids);
								?>
									<?php if ( !empty($filter_ids) || $filter_ids > 0 ) { ?>
										<?php if ( in_array( my_encrypt($vv['value_id']), $filter_active ) ) { ?>
											<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).'&'.$filter_url.'='.$filter_ids.$color_link.$dimension_link.$paper_type_link.$pf;?>" class="activeatr"><?php print $vv['value_name'];?></a>
										<?php } else { ?>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).'&'.$filter_url.'='.$filter_ids.'|'.my_encrypt($vv['value_id']).$color_link.$dimension_link.$paper_type_link.$pf;?>"><?php print $vv['value_name'];?></a>
										<?php } ?>
									<?php } else { ?>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).'&'.$filter_url.'='.my_encrypt($vv['value_id']).$color_link.$dimension_link.$paper_type_link.$pf;?>"><?php print $vv['value_name'];?></a>
									<?php } ?>
								<?php
										
											break;
										case 2:
												$filter_url = 'color';
												$filter_ids = isset($_GET[$filter_url]) ? $_GET[$filter_url] : 0;
												$filter_active = explode('|',$filter_ids);
								?>
									<?php if ( !empty($filter_ids) || $filter_ids > 0 ) { ?>
										<?php if ( in_array( my_encrypt($vv['value_id']), $filter_active ) ) { ?>
											<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.'&'.$filter_url.'='.$filter_ids.$dimension_link.$paper_type_link.$pf;?>" class="cclink"><span style="background-color: #<?php print $vv['color_code'];?>;" class="activeatr"></span></a>
										<?php } else { ?>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.'&'.$filter_url.'='.$filter_ids.'|'.my_encrypt($vv['value_id']).$dimension_link.$paper_type_link.$pf;?>" class="cclink"><span style="background-color: #<?php print $vv['color_code'];?>;"></span></a>
										<?php } ?>
									<?php } else { ?>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.'&'.$filter_url.'='.my_encrypt($vv['value_id']).$dimension_link.$paper_type_link.$pf;?>" class="cclink"><span style="background-color: #<?php print $vv['color_code'];?>;"></span></a>
									<?php } ?>
								<?php
											break;
										
										case 3:
												$filter_url = 'dimension';
												$filter_ids = isset($_GET[$filter_url]) ? $_GET[$filter_url] : 0;
												$filter_active = explode('|',$filter_ids);
								?>
									<?php if ( !empty($filter_ids) || $filter_ids > 0 ) { ?>
										<?php if ( in_array( my_encrypt($vv['value_id']), $filter_active ) ) { ?>
											<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.$color_link.'&'.$filter_url.'='.$filter_ids.$paper_type_link.$pf;?>" class="activeatr"><?php print $vv['value_name'];?></a>
										<?php } else { ?>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.$color_link.'&'.$filter_url.'='.$filter_ids.'|'.my_encrypt($vv['value_id']).$paper_type_link.$pf;?>"><?php print $vv['value_name'];?></a>
										<?php } ?>
									<?php } else { ?>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.$color_link.'&'.$filter_url.'='.my_encrypt($vv['value_id']).$paper_type_link.$pf;?>"><?php print $vv['value_name'];?></a>
									<?php } ?>
								<?php
										
											break;

										case 4:
												$filter_url = 'paper_type';
												$filter_ids = isset($_GET[$filter_url]) ? $_GET[$filter_url] : 0;
												$filter_active = explode('|',$filter_ids);
								?>
									<?php if ( !empty($filter_ids) || $filter_ids > 0 ) { ?>
										<?php if ( in_array( my_encrypt($vv['value_id']), $filter_active ) ) { ?>
											<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.$color_link.$paper_type_link.'&'.$filter_url.'='.$filter_ids.$pf;?>" class="activeatr"><?php print $vv['value_name'];?></a>
										<?php } else { ?>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.$color_link.$paper_type_link.'&'.$filter_url.'='.$filter_ids.'|'.my_encrypt($vv['value_id']).$pf;?>"><?php print $vv['value_name'];?></a>
										<?php } ?>
									<?php } else { ?>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.$color_link.$paper_type_link.'&'.$filter_url.'='.my_encrypt($vv['value_id']).$pf;?>"><?php print $vv['value_name'];?></a>
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
							</div>

						<?php } ?>
						

						<div class="left-block-link brands">
							<h3>Price</h3>
							<ul class="pagelink">
								<li>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.$color_link.$paper_type_link.$paper_type_link.'&p=0-100';?>">
										<span>0</span>
										<span>--</span>
										<span>100</span>
									</a>
								</li>
								<li>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.$color_link.$paper_type_link.$paper_type_link.'&p=200-300';?>">
										<span>200</span>
										<span>--</span>
										<span>300</span>
									</a>
								</li>
								<li>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.$color_link.$paper_type_link.$paper_type_link.'&p=300-400';?>">
										<span>300</span>
										<span>--</span>
										<span>400</span>
									</a>
								</li>
								<li>
									<a href="<?php print base_url().'/search/?c='.urldecode($_GET['c']).'&searchq='.urldecode($_GET['searchq']).'&secure='.urldecode($_GET['secure']).$size_link.$color_link.$paper_type_link.$paper_type_link.'&p=400-a';?>">
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
							<?php print view('site/stores/prolist',['count' => $products]);?>
						<?php } else { ?>
							<div class="col-12"><p class="alert alert-danger">No result found</p></div>
						<?php } ?>

						<?php if ( $total_products > 12 ) { ?>
						<div class="pagenation">
							<?php print $pager->makeLinks($page, 12, $total_products,'front_full') ?>
						</div>
						<?php } ?>

						</div>
						
					</div>
				</div>
			</div>
		</div>
	</section>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>
<script>
	$('.see_details').click(function(){
		let id = parseInt($(this).attr('data-id'));
		if(id == 0){
			$('.cate-left').removeClass('d-none');
			$(this).attr('data-id', 1)
			$(this).html('Hide Details <i class="fa fa-arrow-up"></i>');
		}
		if(id == 1){
			$('.cate-left').addClass('d-none');
			$(this).attr('data-id', 0)
			$(this).html('See Details <i class="fa fa-arrow-down"></i>');
		}
	})
</script>