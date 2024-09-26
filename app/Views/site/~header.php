<?php
$searchSlider = searchSlider();
$total_list = (new App\Models\WishlistModel)->getUserTotalList();
?>
<?php $globalSettings = (new \App\Models\Setting())->orderBy('id', 'ASC')->GetValues(['company_name', 'frontend_logo']); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Welcome to Zappta! | <?= $globalSettings[1]['var_detail'] ?></title>
	<meta name="description" content="Zappta Saas Based Ecommerce Platform">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="apple-touch-icon" sizes="57x57" href="<?php print base_url(); ?>/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php print base_url(); ?>/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php print base_url(); ?>/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php print base_url(); ?>/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php print base_url(); ?>/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php print base_url(); ?>/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php print base_url(); ?>/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php print base_url(); ?>/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php print base_url(); ?>/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php print base_url(); ?>/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php print base_url(); ?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php print base_url(); ?>/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php print base_url(); ?>/favicon-16x16.png">
	<!-- <link rel="manifest" href="<?php print base_url(); ?>/manifest.json"> -->
	<meta name="msapplication-TileColor" content="#fb5000">
	<meta name="msapplication-TileImage" content="<?php print base_url(); ?>/ms-icon-144x144.png">
	<meta name="theme-color" content="#fb5000">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php print base_url() . '/theme/css/bundle.css' ?>">
	<link rel="stylesheet" type="text/css" href="<?php print base_url() . '/theme/css/theme.css' ?>">
	<link rel="stylesheet" type="text/css" href="<?php print base_url() . '/theme/css/dashboard_.css' ?>">
	<link rel="stylesheet" type="text/css" href="<?php print base_url() . '/theme/css/responsive-.css' ?>">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
	<script type="text/javascript">
		var baseUrl = '<?php print base_url(); ?>/';
		var currentUrl = window.location.origin + window.location.pathname;
	</script>
	<?php print csrf_meta() ?>
	<style>
		.sticky_header_adjustment_main {
			margin-top: 12rem !important;
		}
		@media screen and (max-width: 1200px) {
			.sticky_header_adjustment_main {
				margin-top: 12rem !important;
			}
		}

		@media screen and (max-width: 768px) {
			.sticky_header_adjustment_main {
				margin-top: 20rem !important;
			}
		}

		@media screen and (max-width: 480px) {
			.sticky_header_adjustment_main {
				margin-top: 20rem !important;
			}
		}
	</style>
</head>
<body<?php if (is_array(getUrlSegment()) && getUrlSegment()[0] == '') { ?> class="homep" <?php } else { ?> class="homeload" <?php } ?>>
	<!-- <div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div> -->
	<div class="loader">
		<div class="loadingio-spinner-wedges-6sp0olydj1g">
			<div class="ldio-ifqtsksmdi">
				<div>
					<div>
						<div></div>
					</div>
					<div>
						<div></div>
					</div>
					<div>
						<div></div>
					</div>
					<div>
						<div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<header <?= isset($sticky_header) ? "class='fixed-top'" : "" ?>>
		<div class="top-head p-2 h-auto">
			<div class="container">
				<div class=" d-sm-flex justify-content-between align-items-center">
					<div class="d-flex justify-content-center">
						<div class="tophead-text">
							<h3>START EARNING ZAPPTA $ TODAY</h3>
						</div>
					</div>
					<div class="d-flex justify-content-center">
						<div class="topheadlink ">
							<ul class="d-flex align-items-center">
								<?php if (getUserId() == 0) { ?>
									<li>
										<button type="button" onclick="showLogin('login');" class="btn btnlogin">Sign In</button>
									</li>
									<li>
										<button type="button" onclick="showLogin('singin');" class="btn btnjoin">Join Now</button>
									</li>
								<?php } else { ?>
									<li class="d-flex">

										<div class="dropdown">
											<!-- 	<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
										    <span class="icon"><i class="fa-solid fa-user-check"></i></span> 
											<span>My Account</span>
									  	</a> -->
											<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false">

												<span class="icon"><i class="fa-solid fa-bell"></i></span>
												<span>Notification</span>
											</a>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuLink2" style="width: 500px;">
												<ul class="p-5">
													<?php
													$notifications = getNotifications(5);
													$csrf = csrf_hash();
													if (count($notifications) > 0) {
														foreach (getNotifications(5) as $notification) {  ?>
															<li class="mb-5">
																<?= $notification['category'] == 'referral' ? '<i class="fa-solid fa-share-nodes"></i>' : '' ?>
																<?= $notification['category'] == 'order-delivered' ? '<i class="fa-solid fa-location-dot"></i>' : '' ?>
																<?= $notification['category'] == 'order-placed' ? '<i class="fa-solid fa-truck-fast"></i>' : '' ?>
																<?= $notification['category'] == 'order-bonus' ? '<i class="fa-solid fa-coins"></i>' : '' ?>
																<?= $notification['category'] == 'order-shipped' ? '<i class="fa-solid fa-circle-check"></i>' : '' ?>
																<?= $notification['category'] == 'order-pending' ? '<i class="fa-solid fa-hourglass-end"></i>' : '' ?>
																<?= $notification['category'] == 'order-returned' ? '<i class="fa-solid fa-arrow-rotate-left"></i>' : '' ?>
																<a href="<?= str_replace('{csrf_hash}', $csrf, $notification['link']) ?>" class="btn btn-light">
																	<p class="mb-3"><?= $notification['notification'] ?></p>
																</a>
																<small class="pull-right"><?= timeago(date('Y-m-d H:i:s', strtotime($notification['created_at']))) ?></small>
															</li>
														<?php } ?>
														<li>
															<a class="dropdown-item" href="<?php print base_url() . '/notifications'; ?>">
																<span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
																<span style="color:#BF5000">See All Notifications</span>
															</a>
														</li>
													<?php } else { ?>
														<li>
															<p class="mb-3 text-muted text-center"><b>No notifications found!</b></p>
														</li>
													<?php } ?>
												</ul>
											</div>
										</div>

									</li>
									<li class="d-flex">
										<div class="dropdown">
											<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
												<span class="icon"><i class="fa-solid fa-user-check"></i></span>
												<span>My Account</span>
											</a>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
												<div class="userblock">
													<small class="me-3">Welcome Back!</small>
													<small class="me-3"><?php print getUserName(); ?></small>
												</div>
												<ul>
													<li>
														<a class="dropdown-item" href="<?php print base_url() . '/dashboard'; ?>">
															<span class="icon"><i class="fa-brands fa-dashcube"></i></span>
															<span>Dashboard</span>
														</a>
													</li>
													<li>
														<a class="dropdown-item" href="<?php print base_url() . '/logout'; ?>">
															<span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
															<span>Logout</span>
														</a>
													</li>
												</ul>
											</div>
										</div>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<style>
			.filter-dropdown-search {
				width: 100%;
				height: 700px;
				border-radius: 10px;
				position: absolute;
				top: 50px;
				left: 0;
				z-index: 11;
				display: none;
			}

			form:focus-within .filter-dropdown-search {
				display: block !important;
			}
		</style>
		<div class="middle-head">
			<div class="container position-relative">
				<div class="d-lg-flex align-items-center">
					<div class="col-xl-3 col-lg-3 col-md-3 col-12">
						<div class="logo">
							<a href="<?php print base_url(); ?>">
								<img src="<?= base_url() . '/upload/logo/' . $globalSettings[0]['var_detail'] ?>" alt="logo" />
							</a>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6  col-12">
						<div class="header-search">
							<form method="get" action="<?php print base_url() . '/search'; ?>" id="searchHeaderForm">
								<div class="input-field mt-2 position-relative d-flex">
									<div class="category-select position-relative">
										<?php
										$select_cat_search = isset($_GET['c']) ? my_decrypt(filtreData(urldecode($_GET['c']))) : 0;
										?>
										<select name="c" class="form-control">
											<option value="0">All</option>
											<?php getDropDownCategorySelectedArray(getHeaderCategory(), $select_cat_search); ?>
										</select>
										<span class="position-absolute"><i class="fa-solid fa-chevron-down"></i></span>
									</div>
									<div class="category-input">
										<div class="input-group flex-nowrap">
											<input type="search" id="headerSearchQ" name="searchq" style="border-rigth:none;" class="form-control" placeholder="Search..." />
											<button style="border-left:none;border:1px solid #ced4da;border-radius: 0.25rem;" type="submit" class="searchbtn bg-white"><i class="fa fa-search"></i></button>
											<!-- <div class="filter-dropdown-search bg-white" >
											
											</div> -->
										</div>

									</div>
								</div>
								<input type="hidden" name="secure" value="<?php print csrf_hash(); ?>">

							</form>


							<?php if (is_array($searchSlider) && count($searchSlider) > 0) { ?>
								<div class="search-text headersearchbtn mt-3 position-relative">
									<button class="searchnextArrow"><i class="fa-solid fa-chevron-right"></i></button>
									<div class="headersearchslider searchslider">
										<?php foreach ($searchSlider as $sl) { ?>
											<p class="text-center"><?php print $sl['name']; ?></p>
										<?php } ?>
									</div>
									<button class="searchprevArrow"><i class="fa-solid fa-chevron-left"></i></button>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-3 col-12" style="position: absolute; right:15px;top:0;">
						<div class="header-right text-end ">
							<div class="cart-block d-flex justify-content-end">
								<div class="z-c">
									<span class="float-start">
										<svg xmlns="http://www.w3.org/2000/svg" width="11" height="24" viewBox="0 0 11 24">
											<g id="Group_1" data-name="Group 1" transform="translate(-1363 -79)">
												<text id="Z" transform="translate(1363 98)" fill="#fb5000" font-size="18" font-family="OpenSans, Open Sans">
													<tspan x="0" y="0">Z</tspan>
												</text>
												<g id="Rectangle_4" data-name="Rectangle 4" transform="translate(1367 82)" fill="#fff" stroke="#fb5000" stroke-width="1">
													<rect width="2" height="4" stroke="none" />
													<rect x="0.5" y="0.5" width="1" height="3" fill="none" />
												</g>
												<g id="Rectangle_5" data-name="Rectangle 5" transform="translate(1367 98)" fill="#fff" stroke="#fb5000" stroke-width="1">
													<rect width="2" height="4" stroke="none" />
													<rect x="0.5" y="0.5" width="1" height="3" fill="none" />
												</g>
											</g>
										</svg>
									</span>
									<style>
										#wishList {
											position: absolute;
											top: 0;
											right: 0;
											background: red;
											color: white;
											border-radius: 50%;
											width: 20px;
											height: 20px;
											display: flex;
											align-items: center;
											justify-content: center;
										}
									</style>
									<?php if (getUserId() > 0) { ?>
										<span class="float-start zzf" id="userTotalZappta"><a href="<?= base_url() ?>/dashboard/wallet" class="text text-danger"><?php print number_format(userTotalZappta() - ((new \App\Models\CompainModel())->getZapptaSpent()), 2); ?></a></span> <?php } else { ?>
										<span class="float-start zzf">0.00</span>
									<?php } ?>
									<div class="clearfix"></div>
								</div>
								<div class="wishlist">
									<?php if (getUserId() > 0) { ?>
										<a class="position-relative" href="<?php print base_url() . '/dashboard/wishlist'; ?>">
											<span><i class="fa-regular fa-heart"></i></span>
											<span>Wishlist</span>
											<span id="wishList"><?= $total_list ?></span>
										</a>
									<?php } else { ?>

										<a class="position-relative" href="#" data-bs-toggle="modal" data-bs-target="#accountModal">
											<span><i class="fa-regular fa-heart"></i></span>
											<span>Wishlist</span>
											<!-- <span id="wishList"></span> -->
										</a>
									<?php } ?>
								</div>
								<div class="carticon">
									<a href="<?php print base_url() . '/cart'; ?>" class="position-relative">
										<span>
											<svg xmlns="http://www.w3.org/2000/svg" width="23" height="25.754" viewBox="0 0 23 25.754">
												<g id="Group_2" data-name="Group 2" transform="translate(-1512 -69.246)">
													<g id="Rectangle_6" data-name="Rectangle 6" transform="translate(1512 76)" fill="none" stroke="#1a1a1a" stroke-width="1.5">
														<path d="M0,0H23a0,0,0,0,1,0,0V15a4,4,0,0,1-4,4H4a4,4,0,0,1-4-4V0A0,0,0,0,1,0,0Z" stroke="none" />
														<path d="M.75.75h21.5a0,0,0,0,1,0,0V15A3.25,3.25,0,0,1,19,18.25H4A3.25,3.25,0,0,1,.75,15V.75A0,0,0,0,1,.75.75Z" fill="none" />
													</g>
													<path id="Path_3" data-name="Path 3" d="M1517.49,79s-1.314-12.158,8.869-8.217c.164,0,2.956,2.966,2.628,8.217" fill="none" stroke="#1a1a1a" stroke-width="1.5" />
												</g>
											</svg>
										</span>
										<span>Cart</span>
										<?php if (get_total_items() > 0) { ?>
											<span id="cartList"><?php print get_total_items(); ?></span>
										<?php } else { ?>
											<span id="cartList"></span>
										<?php } ?>
									</a>
								</div>
								<?php if (getUserId() > 0) { ?>
									<div class="carticon d-none ml-5">
										<a href="#" class="position-relative">
											<span>
												<i class="fa fa-clock-o fa-2x fa-beat" style="color: green"></i>
											</span>
											<strong id="remained_on_store_page_timer" style="color: #1f3541"></strong>
										</a>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="cart-block-text d-flex flex-sm-row-reverse">
							<p class=" zdbtn d-flex ps-2 pe-2">
								<span class=" me-1">
									<svg xmlns="http://www.w3.org/2000/svg" width="11" height="24" viewBox="0 0 11 24">
										<g id="Group_1" data-name="Group 1" transform="translate(-1363 -79)">
											<text id="Z" transform="translate(1363 98)" fill="#ffffff" font-size="18" font-family="OpenSans, Open Sans">
												<tspan x="0" y="0">Z</tspan>
											</text>
											<g id="Rectangle_4" data-name="Rectangle 4" transform="translate(1367 82)" fill="#fff" stroke="#ffffff" stroke-width="1">
												<rect width="2" height="4" stroke="none" />
												<rect x="0.5" y="0.5" width="1" height="3" fill="none" />
											</g>
											<g id="Rectangle_5" data-name="Rectangle 5" transform="translate(1367 98)" fill="#fff" stroke="#ffffff" stroke-width="1">
												<rect width="2" height="4" stroke="none" />
												<rect x="0.5" y="0.5" width="1" height="3" fill="none" />
											</g>
										</g>
									</svg>
								</span>
								<span class=""><?= (new \App\Models\Setting())->where('var_name', 'ZAPPTA_INVITE_FRIEND')->first()['var_detail'] ?></span>
							</p>
							<?php if (getUserId() == 0) { ?>
								<p class="me-1  text-nowrap" onclick="showLogin('login');">Refer-a-friend & Get</p>
							<?php } else { ?>
								<p class="me-1  text-nowrap" onclick="showReferLogin('login');">Refer-a-friend & Get</p>
							<?php } ?>
							<div class=""></div>
						</div>
						<div class=""></div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<main <?= isset($sticky_header) ? "class='sticky_header_adjustment_main'" : "" ?>>