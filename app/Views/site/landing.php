<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Zappta!</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?php print base_url().'/theme/css/bundle.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php print base_url().'/theme/css/theme.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php print base_url().'/theme/css/responsive.css'?>">
	<script type="text/javascript">
		var baseUrl = '<?php print base_url();?>/';
	</script>
</head>
<body class="landinglp">
	<div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
	<header>
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12">
					<div class="logo">
						<a href="<?php print base_url();?>">
							<img src="<?php print base_url().'/theme/image/logo.png'?>" alt="" />
						</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<main>
		<input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
		<section class="slider">
			<div class="slider-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-12 position-relative">
							<div class="wheel-animation">
								<img src="<?php print base_url();?>/theme/image/480.gif" alt="" />
							</div>
							<div class="videoplaybtn" data-bs-toggle="modal" data-bs-target="#videoModal" data-src="<?=base_url()?>/theme/videos/watch.mp4" style="position: absolute;bottom: 30px;right: 0;background: #e25648;width: 150px; height: 40px; text-align: center; line-height: 40px; color: #FFF; border-radius: 30px; cursor: pointer;"><i class="fa fa-play"></i>
								Watch Video
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-12">
							<div class="slide-text slider-lp text-center position-relative">
								<h3>Spin to win FREE products</h3>
								<h4>Worth hundreds, even thousands of dollars</h4>
								<div class="slide-points">
									<p>Free to join</p>
									<p>Free to play</p>
									<p>Free to win</p>
								</div>
								<div class="slider-email position-relative" id="sliderEmail">
									<div class="emailerror position-absolute"></div>
									<div class="form-row position-relative">
										<input type="text" name="subscribeemail" class="subscribeemail" placeholder="E-mail Address" />
										<button type="button" onclick="email_subscribe('subscribeemail','emailerror');" class="btn email-btn position-absolute">JOIN NOW!</button>
									</div>
									<p class="text-white">*We hate spam and promise to keep your email safe</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="text-block">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-xl-2 col-lg-2 col-md-2 col-12">
						<div class="livebtn"></div>
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-12">
						<div class="livetext live-lp">
							<p>
								<b>Shop n' Spin</b>
								<span>Shopping sprees. Happening Now</span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="product-block product-lp">
			<div class="container">
				<div class="row">
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
						<div class="card">
						  <img src="<?php print base_url();?>/theme/image/best-buy-logo-01.png" class="card-img-top" alt="...">
						  <div class="card-body">
						    <h5 class="card-title">WIN</h5>
						    <p class="card-text price-block">$1000</p>
						    <p class="card-text">Shopping Spree</p>
						    <img src="<?php print base_url();?>/theme/image/bestbuy-image1.png" class="card-img-middle" alt="...">
						  </div>
						  <div class="card-body pad-0">
						    <p class="card-text">Game ends in</p>
						    <div class="periodic_timer_minutes_1">
						    	<div class="jumbotron countdown show" data-Date='2022/10/27 23:33:53'>
					                <div class="running">
					                    <timer class="align-items-center">
					                    	<span class="timerspan">
					                        	<span class="days"></span>
					                        	<span class="timerlabel">Days</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="hours"></span>
					                        	<span class="timerlabel">Hrs</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="minutes"></span>
					                        	<span class="timerlabel">Mins</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="seconds"></span>
					                        	<span class="timerlabel">Secs</span>
					                        </span>	
					                    </timer>
					                </div>
					            </div>
						    </div>
						    <button type="button" class="btn btn-play" onclick="scrollEmailForm();">PLAY NOW</button>
						  </div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
						<div class="card">
						  <img src="<?php print base_url();?>/theme/image/Nike-Logo1.png" class="card-img-top" alt="...">
						  <div class="card-body text-center">
						    <h5 class="card-title">WIN</h5>
						    <p class="card-text price-block">$1000</p>
						    <p class="card-text">Shopping Spree</p>
						    <img src="<?php print base_url();?>/theme/image/nike-geo-metric-hoodie-teal-tint1.png" class="card-img-middle" alt="...">
						  </div>
						  <div class="card-body pad-0">
						    <p class="card-text">Game ends in</p>
						    <div class="periodic_timer_minutes_1">
						    	<div class="jumbotron countdown show" data-Date='2022/10/27 23:33:53'>
					                <div class="running">
					                    <timer class="align-items-center">
					                    	<span class="timerspan">
					                        	<span class="days"></span>
					                        	<span class="timerlabel">Days</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="hours"></span>
					                        	<span class="timerlabel">Hrs</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="minutes"></span>
					                        	<span class="timerlabel">Mins</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="seconds"></span>
					                        	<span class="timerlabel">Secs</span>
					                        </span>	
					                    </timer>
					                </div>
					            </div>
						    </div>
						    <button type="button" class="btn btn-play" onclick="scrollEmailForm();">PLAY NOW</button>
						  </div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
						<div class="card">
						  <img src="<?php print base_url();?>/theme/image/crate-barrel-logo2.png" class="card-img-top" alt="...">
						  <div class="card-body">
						    <h5 class="card-title">WIN</h5>
						    <p class="card-text price-block">$1000</p>
						    <p class="card-text">Shopping Spree</p>
						    <img src="<?php print base_url();?>/theme/image/crate&B-furniture1.png" class="card-img-middle" alt="...">
						  </div>
						  <div class="card-body pad-0">
						    <p class="card-text">Game ends in</p>
						    <div class="periodic_timer_minutes_1">
						    	<div class="jumbotron countdown show" data-Date='2022/10/27 23:33:53'>
					                <div class="running">
					                    <timer class="align-items-center">
					                    	<span class="timerspan">
					                        	<span class="days"></span>
					                        	<span class="timerlabel">Days</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="hours"></span>
					                        	<span class="timerlabel">Hrs</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="minutes"></span>
					                        	<span class="timerlabel">Mins</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="seconds"></span>
					                        	<span class="timerlabel">Secs</span>
					                        </span>	
					                    </timer>
					                </div>
					            </div>
						    </div>
						    <button type="button" class="btn btn-play" onclick="scrollEmailForm();">PLAY NOW</button>
						  </div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
						<div class="card">
						  <img src="<?php print base_url();?>/theme/image/Shein-logo1.png" class="card-img-top" alt="...">
						  <div class="card-body">
						    <h5 class="card-title">WIN</h5>
						    <p class="card-text price-block">$1000</p>
						    <p class="card-text">Shopping Spree</p>
						    <img src="<?php print base_url();?>/theme/image/Shein-pic1.png" class="card-img-middle" alt="...">
						  </div>
						  <div class="card-body pad-0">
						    <p class="card-text">Game ends in</p>
						    <div class="periodic_timer_minutes_1">
						    	<div class="jumbotron countdown show" data-Date='2022/10/27 23:33:53'>
					                <div class="running">
					                    <timer class="align-items-center">
					                    	<span class="timerspan">
					                        	<span class="days"></span>
					                        	<span class="timerlabel">Days</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="hours"></span>
					                        	<span class="timerlabel">Hrs</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="minutes"></span>
					                        	<span class="timerlabel">Mins</span>
					                        </span>	
					                        <span class="timerdots">:</span>
					                    	<span class="timerspan">
					                        	<span class="seconds"></span>
					                        	<span class="timerlabel">Secs</span>
					                        </span>	
					                    </timer>
					                </div>
					            </div>
						    </div>
						    <button type="button" class="btn btn-play" onclick="scrollEmailForm();">PLAY NOW</button>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="win-section win-lp">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="heading">
							<h1>HOW  YOU WIN</h1>
							<p>Winning high-value products on Zappta is easy as 1-2-3…</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="steps-block text-center">
							<h3>1</h3>
							<div class="stepimg">
								<img src="<?php print base_url();?>/theme/image/shoppingkart-3D1.png" alt="" />
							</div>
							<div class="stepdetail">
								<h4>Select yor favorite brands</h4>
								<p>Then simply add products you’d like to win to your Shop n’ Spin cart</p>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="steps-block text-center">
							<h3>2</h3>
							<div class="stepimg">
								<img src="<?php print base_url();?>/theme/image/wheel-blackcoins1.png" alt="" />
							</div>
							<div class="stepdetail">
								<h4>Spin the wheel</h4>
								<p>Hold the highest score when the timer reaches 0:00 and, congratulations…</p>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="steps-block text-center">
							<h3>3</h3>
							<div class="stepimg">
								<img src="<?php print base_url();?>/theme/image/winning1.png" alt="" />
							</div>
							<div class="stepdetail">
								<h4>You win</h4>
								<p>All the products in your Shop n’ Spin cart  are yours absolutely FREE. You don’t even pay s&h</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="promise-block">
			<div class="container">
				<div class="row justify-content-center align-items-center">
					<div class="col-xl-6 col-lg-6 col-md-6 col-12">
						<div class="promise-text promise-lp text-center">
							<h2>IT’S FREE. WE PROMISE!</h2>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-12">
						<div class="promise-text promise-lp">
							<p>So keep your credit card in your wallet.</p>
							<p>You won’t need it to play.</p>
							<p>You won’t need it to win.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="testi-section testi-lp">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="heading">
							<h1>TESTIMONIALS</h1>
						</div>
					</div>
				</div>
				<div class="row testimonials position-relative">
					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="testi-block">
							<div class="star-block">
								<div class="stars-left">
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
								</div>
								<div class="stars-right">
									<h3>“Pulls you in like a magnet”</h3>
								</div>
							</div>
							<div class="testidetail">
								<p>“This spin to win game pulls you in like a magnet. I couldn’t tear myself away from it.”</p>
							</div>
							<div class="testiimg">
								<div class="iconbb">
									<img src="<?php print base_url();?>/theme/image/testi-img-1.png" alt="...">
								</div>
								<div class="icon-text">
									<h4>Bella Reese</h4>
									<h5>Oakland CA</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="testi-block">
							<div class="star-block">
								<div class="stars-left">
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
								</div>
								<div class="stars-right">
									<h3>“Brilliant”</h3>
								</div>
							</div>
							<div class="testidetail">
								<p>“I took part in a focus group for Zappta.com. It’s a brilliant concept that is sure to change the way people shop.”</p>
							</div>
							<div class="testiimg">
								<div class="iconbb">
									<img src="<?php print base_url();?>/theme/image/testi-img-2.png" alt="...">
								</div>
								<div class="icon-text">
									<h4>Arthur Miller</h4>
									<h5>Newark NJ</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="testi-block">
							<div class="star-block">
								<div class="stars-left">
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
								</div>
								<div class="stars-right">
									<h3>“So addicting”</h3>
								</div>
							</div>
							<div class="testidetail">
								<p>"This game is so addicting. Thanks, Zappta!"</p>
							</div>
							<div class="testiimg">
								<div class="iconbb">
									<img src="<?php print base_url();?>/theme/image/testi-img-3.png" alt="...">
								</div>
								<div class="icon-text">
									<h4>Kathryn Ellis</h4>
									<h5>Groveland MA</h5>
								</div>
							</div>
						</div>
					</div>


					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="testi-block">
							<div class="star-block">
								<div class="stars-left">
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
								</div>
								<div class="stars-right">
									<h3>“Adrenalin-rush like no other”</h3>
								</div>
							</div>
							<div class="testidetail">
								<p>“An adrenalin-pumping rush like no other.”</p>
							</div>
							<div class="testiimg">
								<div class="iconbb">
									<img src="<?php print base_url();?>/theme/image/2.png" alt="...">
								</div>
								<div class="icon-text">
									<h4>Peter Elsher</h4>
									<h5>Seattle WA</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="testi-block">
							<div class="star-block">
								<div class="stars-left">
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
								</div>
								<div class="stars-right">
									<h3>“It’s addicting”</h3>
								</div>
							</div>
							<div class="testidetail">
								<p>“It’s amazing. Select the items you want from the stores you love & add them to your shopping cart. You then play to win all the items in your cart. It’s addicting.”</p>
							</div>
							<div class="testiimg">
								<div class="iconbb">
									<img src="<?php print base_url();?>/theme/image/4.png" alt="...">
								</div>
								<div class="icon-text">
									<h4>Judith Mills</h4>
									<h5>Aurora CO</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="testi-block">
							<div class="star-block">
								<div class="stars-left">
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
								</div>
								<div class="stars-right">
									<h3>“Brilliant”</h3>
								</div>
							</div>
							<div class="testidetail">
								<p>“My first reaction was yeah, right. But when I saw how it works I understood how Zappta can give away so many popular and expensive products free. It’s truly a win-win. Brilliant.”</p>
							</div>
							<div class="testiimg">
								<div class="iconbb">
									<img src="<?php print base_url();?>/theme/image/6.png" alt="...">
								</div>
								<div class="icon-text">
									<h4>Evenly Raven</h4>
									<h5>Irvine CA </h5>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="testi-block">
							<div class="star-block">
								<div class="stars-left">
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
								</div>
								<div class="stars-right">
									<h3>“Quite Genius”</h3>
								</div>
							</div>
							<div class="testidetail">
								<p>“This game is quite genius.”</p>
							</div>
							<div class="testiimg">
								<div class="iconbb">
									<img src="<?php print base_url();?>/theme/image/5.png" alt="...">
								</div>
								<div class="icon-text">
									<h4>Olivia Huxley</h4>
									<h5>Lansing MI</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-12 mb-4">
						<div class="testi-block">
							<div class="star-block">
								<div class="stars-left">
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
									<div class="stars"></div>
								</div>
								<div class="stars-right">
									<h3>“Incredibly fun”</h3>
								</div>
							</div>
							<div class="testidetail">
								<p>“OMG. I played the Zappta spin to win game as a test participant before it was released. It was incredibly fun to select the products I wanted and even more thrilling to spin the wheel.”</p>
							</div>
							<div class="testiimg">
								<div class="iconbb">
									<img src="<?php print base_url();?>/theme/image/1.png" alt="...">
								</div>
								<div class="icon-text">
									<h4>Abigail Gatlin</h4>
									<h5>Trenton NJ</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row align-items-center justify-content-center">
					<div class="col-12 align-item-center justify-content-center">
						<div class="bottom-heading text-center">
							<div class="stars"></div>
							<div class="stars"></div>
							<div class="stars"></div>
							<div class="stars"></div>
							<div class="stars"></div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="email-forms email-lp">
			<div class="container">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-12">
						<div class="email-heading">
							<h3>Email</h3>
						</div>
						<div class="emailform">
							<div class="form-row">
								<input type="text" name="subscribeemails" class="subscribeemails" placeholder="" />
								<button type="button" onclick="email_subscribe('subscribeemails','emailerrors')" class="btn email-btn position-absolute">JOIN NOW!</button>
							</div>
							<div class="emailerrors position-absolute"></div>
							<p>*We hate spam and promise to keep your email safe</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="text-about text-lp">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="text-heading">
							<p>Here are <b>just a few</b> of the many brands you might include in your free shopping spree when you play Shop n’ Spin…</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="logo-block">
			<div class="container">
				<div class="row row-cols-4 align-items-center">
					<?php 
						for($i=1; $i<=32;$i++){
					?>
					<div class="col mb-4">
						<div class="logo-img">
							<img src="<?php print base_url();?>/theme/image/logo-<?php print $i;?>.png" alt="" />
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</section>
		<section class="text-about-second text-about-second-lp">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="text-heading text-center">
							<p>Join <b>Zappta</b> and you might just <b>win</b> one shopping spree after another</p>
						</div>
						<div class="text-heading-small text-center">
							<p>and there are no limits to the number of sprees you can win! The more you PLAY the more you WIN!</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="imagine-block imagine-block-lp">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="text-heading text-center">
							<h2>Imagine being able to grab this…</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-4 col-12">
						<div class="imagine-block-col">
							<h4>$200 Apple watch</h4>
							<img src="<?php print base_url();?>/theme/image/pngegg-1.png" alt="" />
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-12">
						<div class="imagine-block-col">
							<h4>$300 Designer Boots</h4>
							<img src="<?php print base_url();?>/theme/image/pngegg-2.png" alt="" />
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-12">
						<div class="imagine-block-col">
							<h4>$500 Play station 5</h4>
							<img src="<?php print base_url();?>/theme/image/pngegg-3.png" alt="" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="text-heading text-center">
							<h3>all in ONE shopping spree—and at no cost to you.</h3>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="how-can-block how-can-block-lp">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="text-heading text-center">
							<h2>How can Zappta do it?</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="how-detail">
							<p>High-value brands want you to engage with their many products, </p>
							<p>so they pay us to give away free shopping sprees to winners of our new,</p>
							<p>high-thrill shopping game called <b>Shop n’ Spin.</b></p>
						</div>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="how-detail">
							<p>Choose name-brand products in nearly every shopping category, including…</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="category-block category-block-lp">
			<div class="container">
				<div class="row row-cols-5">
					<div class="col mb-4">
						<div class="cat-block">
							<img src="<?php print base_url();?>/theme/image/cat-1.png" alt="" />
							<p>Video games</p>
						</div>
					</div>
					<div class="col mb-4">
						<div class="cat-block">
							<img src="<?php print base_url();?>/theme/image/cat-2.png" alt="" />
							<p>Sports</p>
						</div>
					</div>
					<div class="col mb-4">
						<div class="cat-block">
							<img src="<?php print base_url();?>/theme/image/cat-3.png" alt="" />
							<p>Home</p>
						</div>
					</div>
					<div class="col mb-4">
						<div class="cat-block">
							<img src="<?php print base_url();?>/theme/image/cat-4.png" alt="" />
							<p>Fashion & Clothing</p>
						</div>
					</div>
					<div class="col mb-4">
						<div class="cat-block">
							<img src="<?php print base_url();?>/theme/image/cat-5.png" alt="" />
							<p>Electronics</p>
						</div>
					</div>
					<div class="col mb-4">
						<div class="cat-block">
							<img src="<?php print base_url();?>/theme/image/cat-6.png" alt="" />
							<p>Outdoor</p>
						</div>
					</div>
					<div class="col mb-4">
						<div class="cat-block">
							<img src="<?php print base_url();?>/theme/image/cat-7.png" alt="" />
							<p>Beauty</p>
						</div>
					</div>
					<div class="col mb-4">
						<div class="cat-block">
							<img src="<?php print base_url();?>/theme/image/cat-8.png" alt="" />
							<p>Home Improvement</p>
						</div>
					</div>
					<div class="col mb-4">
						<div class="cat-block">
							<img src="<?php print base_url();?>/theme/image/cat-9.png" alt="" />
							<p>Appliances</p>
						</div>
					</div>
					<div class="col mb-4">
						<div class="cat-block">
							<img src="<?php print base_url();?>/theme/image/cat-10.png" alt="" />
							<p>Exotic Vacations & Travel</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="experience-block experience-block-lp">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="text-heading text-left">
							<h2>Experience an adrenalin-pumping rush like no other</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="how-detail text-left">
							<p>Go ahead. Spin to win your first free online shopping spree and experience </p>
							<p>an adrenalin-pumping rush that will keep you on the edge of your seat.</p>
							<p>Be among the first to enjoy it — and start winning.</p>
						</div>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12 col-12">
						<div class="how-detail">
							<p>Sign up now and spin to win products worth hundreds, even thousands of dollars.</p>
						</div>
					</div>
				</div>
				<div class="row align-items-center">
					<div class="col-xl-6 col-lg-6 col-md-6 col-12">
						<div class="slide-text">
							<div class="slide-points">
								<p>Free to join</p>
								<p>Free to play</p>
								<p>Free to win</p>
							</div>
							<div class="email-heading">
								<h3>Email</h3>
							</div>
							<div class="emailform">
								<div class="form-row">
									<input type="text" name="subscribeemailss" class="subscribeemailss" placeholder="" />
									<button type="button" onclick="email_subscribe('subscribeemailss','emailerrors')" class="btn email-btn position-absolute">JOIN NOW!</button>
								</div>
								<div class="emailerrors position-absolute"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-12">
						<div class="wheel-animation">
							<img src="<?php print base_url();?>/theme/image/electronics-others-1.png" alt="" />
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<footer class="footer-lp">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-xl-5 col-lg-5 col-md-5 col-12">
					<div class="footer-left">
						<div class="d-flex align-items-center">
							<div class="foot-left-icon"><i class="fa-regular fa-envelope"></i></div>
							<div class="foot-left-text">
								<h3>JOIN NOW(IT’S FREE) AND START WINNING</h3>
								<p>Get 100 Zappta dollars when you join now. Good for 100 spins</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-2 col-lg-2 col-md-2 col-12">
					<div class="footer-logo">
						<img src="<?php print base_url();?>/theme/image/footer-logo.png" alt="" />
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-12">
					<div class="footer-right">
						<ul>
							<li>
								<a href="https://web.facebook.com/Zappta-100522449234631" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
							</li>
							<li>
								<a href="https://twitter.com/Zappta_official" target="_blank"><i class="fa-brands fa-twitter"></i></a>
							</li>
							<li>
								<a href="https://www.instagram.com/zappta_official/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
							</li>
							<li>
								<a href="https://www.youtube.com/channel/UCbulLJCMUctF7AEhH2nVhpQ"><i class="fa-brands fa-youtube" target="_blank"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>
<script type="text/javascript" src="<?php print base_url();?>/theme/js/bundle.js"></script>	
<script type="text/javascript" src="<?php print base_url();?>/theme/js/theme.js"></script>	
<script type="text/javascript">
	$(function(){
		$('.videoplaybtn').click(function(){
			var videoSrc = $(this).data( "src" );
			$("#videowheel").attr('src',videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
			$('#videoModal').modal('show');
		});
		$('.btn-close').click(function(){
			// var videoSrc = $(this).data( "src" );
			$("#videowheel").attr('src',"" ); 
			$('#videoModal').modal('hide');
		});
	});
</script>
<!-- Modal -->
<div class="modal fade" id="videoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body position-relative" style="padding: 0.5rem;">
        <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close" style="top:0;right:0;background: #ed383d;color: #FFFFFF;height:20px;width:20px;text-align: center;line-height: 20px;margin-top: -10px;margin-right: -10px;"><i class="fa fa-close"></i></button>
        <div class="embed-responsive embed-responsive-16by9">
		  <iframe class="embed-responsive-item" src="" id="videowheel"  allowscriptaccess="always" allow="autoplay" style="width:100%;height:400px;"></iframe>
		</div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
