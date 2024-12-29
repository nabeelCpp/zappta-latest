<?php print view('site/header');?>

	<section class="bread">
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
								<a href="<?php print base_url().'/dashboard';?>"><?php print $pagetitle;?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="dashboard">
		<div class="container">

			<div class=" d-flex">
				<?php print view('dashboard/sidebar');?>
				<!-- Page content holder -->
				<div class="page-content p-5 " id="content">

					<div class="dashboard-page">
						<h3 class="mb-4"><i onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>My Wishlist</h3>
						<?php print show_message();?>
						<div class="reorder-block wish-block account-info mt-4">
						<?php 
							if ( is_array($wishlist) && count($wishlist) > 0 ) {
						?>
							<div class="dash-colum d-flex align-items-center">
								<div class="icon-list"></div>
								<div class="text">(<?php print $total_list;?>)</div>
							</div>
							<?php
								foreach( $wishlist as $list ) {
							?>
							<div class="user-data">
								<div class="list-row d-flex flex-column flex-lg-row align-items-center justify-content-around">
                               <div class="d-flex ">
								<div class="image">
									<img src="<?=$list['pcover']?>" alt="">
								</div>

									<div class="listname">
										<h6><?php print short($list['pname'],50);?></h6>
										<p><?php print short($list['pshort'],100);?></p>
									</div>
                             </div>
							 <div class="d-flex">
									<div class="listlink">
										<a href="<?php print base_url().'/dashboard/wishlist/remove/'.my_encrypt($list['wishlist_id']);?>" onclick="return confirm('Are you sure to delete this?');">Remove</a>
									</div>

									<div class="listbtn">
										<a href="<?php print base_url().'/products/'.$list['purl'].'/p/'.$list['pc'].'/'.'?sd_row='.$list['sd_row'].'&pds='.$list['pds'];?>" target="_blank">View Product</a>
									</div>
									</div>
								</div>
							</div>
							<?php } ?>
						
						<?php } else { ?>
							<div class="notimg">
								<div class="image"></div>
								<div class="text">Your essentials will show up here for quick and easy reordering</div>
							</div>
						<?php } ?>
						</div>
						<?php if ( $total_list > $per_page ) { ?>
						<div class="pagenation mt-4">
							<?php print $pager->makeLinks($page, $per_page, $total_list,'front_full') ?>
						</div>
						<?php } ?>
					</div>

				</div>
				<!-- End demo content -->
			</div>

		</div>
	</section>


<?php print view('site/footer');?>