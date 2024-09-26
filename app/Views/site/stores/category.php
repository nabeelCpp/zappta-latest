<?php print view('site/header');?>
	<section class="storeBanner animate" style="background-image: url('<?php print base_url().'/upload/stores/Image-10.jpg';?>');"></section>
	
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
								<a href="<?php print base_url().'/stores';?>">Stores</a>
							</li>
							<li>/</li>
							<li><?php print $pagetitle;?></li>
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
					<div class="navbtn">

					</div>
					<div class="navs d-flex">
						<div class="followbtn">
							<button type="button" class="btns animate">Follow</button>
						</div>
						<div class="links">
							<ul>
								<li>
									<a href="<?php print base_url();?>">Home</a>
								</li>
								<li>
									<a href="" class="sublinks">Men's <i class="fa-solid fa-caret-down"></i></a>
									<ul>
										<li>
											<a href="">Collections</a>
										</li>
										<li>
											<a href="">Collections</a>
										</li>
										<li>
											<a href="">Collections</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="" class="sublinks">Women's <i class="fa-solid fa-caret-down"></i></a>
									<ul>
										<li>
											<a href="">Collections</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="" class="sublinks">Kids & Juniors <i class="fa-solid fa-caret-down"></i></a>
									<ul>
										<li>
											<a href="">Collections</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
						<div class="searchStore">
							<div class="input-field position-relative">
								<input type="text" name="q" placeholder="Search Product" />
								<span class="position-absolute"><i class="fa fa-search"></i></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="storecats category-single">
		<div class="container">
			<div class="cat-coll-m mt-4 mb-4">
				<div class="row">
					<div class="col-12">
						<div class="store-cat-banner-left" style="background-image:url('<?php print base_url().'/upload/stores/cat-banner.png';?>');">
							<div class="catname">
								<h3>Men's Collection</h3>
							</div>
							<p>Lorem ipsum, or lipsum as it is sometimes known, graphic or web designs.</p>
							<div class="shoplink">
								<a href="">Shop Now 
									<i class="fa-solid fa-right-long"></i>
									<span></span><span></span><span></span><span></span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="cat-pro-list mt-4 mb-4">
				<div class="cat-pro-head">
					<h2 class="text-center">Top Trending</h2>
				</div>
				<div class="row">
					<?php print view('site/stores/prolist',['count' => 20]);?>
				</div>
				<div class="row align-items-center justify-content-center marg-cst-50">
					<div class="col-12">
						<div class="pagination">
							<ul class="d-flex justify-content-center">
								<li>
									<a href="" class="animate"><i class="fa-solid fa-angle-left"></i></a>
								</li>
								<li>
									<a href="" class="active-pag animate">1</a>
								</li>
								<li>
									<a href="" class="animate">2</a>
								</li>
								<li>
									<a href="" class="animate">3</a>
								</li>
								<li>
									<a href="" class="animate">4</a>
								</li>
								<li>
									<a href="" class="animate"><i class="fa-solid fa-angle-right"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>



<?php print view('site/footer');?>