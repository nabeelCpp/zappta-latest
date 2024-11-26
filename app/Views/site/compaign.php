<?php if ( (is_array($compaign) && count($compaign) > 0) || (is_array($compaign_upcoming) && count($compaign_upcoming) > 0) ) { ?>
		
		<section class="text-block">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-xl-11 col-lg-11 col-md-11 col-12">
						<div class="hlivetext text-center">
							<p>
								<b>HOW IT WORKS:</b>
								<span>Winning is easy 1-2-3...</span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="work-step">
			<div class="container">
				<div class="d-flex flex-wrap justify-content-around align-items-center">
					<div class=" mb-4"> 
						<div class="work-block position-relative bluebox">
							<div class="work-no position-absolute">1</div>
							<div class="work-text position-relative">
								<h3>SELECT YOUR PRODUCTS</h3>
								<p>Select your favorite giveaway below. Then simply add your favorite products to your Spin to Win cart.</p>
							</div>
						</div>
					</div>
					<div class=" mb-4"> 
						<div class="work-block position-relative purplebox">
							<div class="work-no position-absolute">2</div>
							<div class="work-text">
								<h3>SPIN THE WHEEL</h3>
								<p>Hold the highest score when the timer hits 0:00 and, congratulations...</p>
							</div>
						</div>
					</div>
					<div class=" mb-4"> 
						<div class="work-block position-relative orangebox">
							<div class="work-no position-absolute">3</div>
							<div class="work-text">
								<h3>YOU WIN</h3>
								<p>All the products in your spin to win cart are yours absolutely Free. You don't even pay s&h</p>
							</div>
						</div>
					</div>
					<div class=" mb-4"> 
						<div class="work-block position-relative greenbox">
							<div class="work-no position-absolute"></div>
							<div class="work-text">
								<h3>FREE TO PLAY FREE TO WIN</h3>
								<p>Play Now!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php if ( (is_array($compaign) && count($compaign) > 0) ) { ?>

		<section class="htext-block">
			<div class="container">
				<div class="d-flex flex-column flex-md-row align-items-center">
					
						<div class="livebtn"></div>
					
			
						<div class="livetext d-flex">
							<h3 style="line-height:1.8" class="d-flex flex-column flex-sm-row align-items-center">
								<b class="me-2">Spin to Win</b>
								<span>Shopping sprees. Happening Now</span>
							</h3>
						</div>
				
				</div>
			</div>
		</section>

		<section class="hproduct-block">
			<div class="container">
				<div class="row" id="giveawayCategorySlider">
			<?php 
				foreach ( $compaign as $comp) {
			?>	
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
						<div class="card" style="background:#E7E7E7; border-radius: 20px;">
							<!-- <span class="badge badge-pill badge-warning" style="background-color: #f33e1f;">Giveaway</span> -->
							<div class="givewaytags position-absolute">
								<p>Giveaway</p>
							</div>
						<?php 
		    				if( ! empty( $comp['store_logo'] ) ) { 
		    					$ext_name = explode('.',$comp['store_logo']);
		    			?>
		    				<img src="<?php print base_url().'images/media/'.$ext_name[0].'/'.$ext_name[1].'/250';?>" class="animate card-img-top" alt="" style="height: 85px;">
		    			<?php } else { ?>
		    				<img src="<?php print base_url().'images/media/img-not-found/jpg/100';?>" class="animate card-img-top" alt="" style="height: 85px;">
		    			<?php }?>

						  <div class="card-body">
						    <h5 class="card-title">SPIN TO WIN</h5>
						    <p class="card-text price-block">$<?php print $comp['price'];?></p>
						    <p class="card-text mt-2 mb-2">Shopping Spree (<?php print short($comp['store_name'],20);?>)</p>
						    <div class="hp-img">
						<?php 
		    				if( ! empty( $comp['cover'] ) ) { 
		    					$ext_cover = explode('.',$comp['cover']);
		    			?>
		    				<img src="<?php print base_url().'upload/media/spree/'.$comp['cover'];?>" class="card-img-middle" alt="">
		    			<?php } else { ?>
		    				<img src="<?php print base_url().'images/media/img-not-found/jpg/100';?>" class="card-img-middle" alt="">
		    			<?php }?>
						  	</div>
						  </div>
						  <div class="card-body pad-0">
						    <p class="card-text">Game ends in</p>
						    <div class="periodic_timer_minutes_1">
						    	<div class="jumbotron countdown show" data-Date='<?php print date('Y/m/d 23:59:59', strtotime($comp['compain_e_date']));?>'>
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

						    <!-- <a href="<?php //print base_url().'products/'.$comp['purl'].'/p/'.$comp['pc'].'/'.'?sd_row='.$comp['sd_row'].'&pds='.$comp['pds'].'&give=1';?>" class="btn btn-play">PLAY NOW</a> -->
						    <!-- <a href="#" class="btn btn-play">PLAY NOW</a> -->
							<button class="btn btn-play upcoming_select_store" data-href="<?=base_url()?>/stores/<?=$comp['store_slug']?>" data-comp="<?=my_encrypt($comp['com_id'])?>" <?=getUserId() == 0?'onclick="showLogin(\'login\');"':''?> data-url="<?=base_url()?>/compaign/verify/<?=my_encrypt($comp['id'])?>" data-id="<?=my_encrypt($comp['vendor_id'])?>" data-button="play">PLAY NOW</button>
						  </div>
						</div>
					</div>
			<?php		// code...
				}
			?>
				</div>
			</div>
		</section>
		<?php } ?>


		<?php if(count($compaign_upcoming) > 0){ ?>
			<section class="htext-block">
				<div class="container">
					<div class="d-flex flex-column flex-md-row align-items-center">
						<div class="row">
						    <div class="col-lg-2 col-md-2">
    							<h4 class="bg-warning px-1 text-white py-3 text-center" style="border-radius: 12px;background-color: #ff9300 !important;">
    								Starting Soon
    							</h4>
						    </div>
						    <div class="col-lg-9 col-md-9">
    							<div class="livetext d-flex">
    								<h3 style="line-height:1.8" class="d-flex flex-column flex-sm-row align-items-center">
    									<b class="me-2"> Spin to Win Shopping Sprees.</b>
    									<span class="bg-warning p-1 rounded" style="background-color: #ff9300 !important;">Select now items you want to win</span>
    								</h3>
    							</div>
        						<p style="text-align: justify; font-style: italic;">
        						Games below are starting soon. Boost your winning power by 100X. Earn <strong>BONUS COINS</strong> now by simply pre-selecting the items you’d like to win. Choose any Shopping Spree from the brands below, click on SELECT ITEMS and CHA-CHING—you <strong>earn coins per minute by browsing & selecting products</strong> you want to win. Coins earned can be used in any Spin to Win game. SELECT YOUR ITEMS NOW & GET SET TO WIN.
        						</p>
						    </div>
						</div>
						
							
						</div>
				</div>
			</section>

			<section class="hproduct-block">
				<div class="container">
					

					<div class="row" id="giveawayCategorySliderUpcoming">
				<?php 
					foreach ( $compaign_upcoming as $comp) {
				?>	
						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
							<div class="card" style="background:#E7E7E7; border-radius: 20px;">
								<!-- <span class="badge badge-pill badge-warning" style="background-color: #f33e1f;">Giveaway</span> -->
								<div class="givewaytags position-absolute">
									<p>Giveaway</p>
								</div>
							<?php 
								if( ! empty( $comp['store_logo'] ) ) { 
									$ext_name = explode('.',$comp['store_logo']);
							?>
								<img src="<?php print base_url().'images/media/'.$ext_name[0].'/'.$ext_name[1].'/250';?>" class="animate card-img-top" alt="" style="height: 85px;">
							<?php } else { ?>
								<img src="<?php print base_url().'images/media/img-not-found/jpg/100';?>" class="animate card-img-top" alt="" style="height: 85px;">
							<?php }?>

							<div class="card-body">
								<h5 class="card-title">WIN</h5>
								<p class="card-text price-block">$<?php print $comp['price'];?></p>
								<p class="card-text mt-2 mb-2"><?php print short($comp['store_name'],20);?></p>
								<div class="hp-img">
							<?php 
								if( ! empty( $comp['cover'] ) ) { 
									$ext_cover = explode('.',$comp['cover']);
							?>
								<img src="<?php print base_url().'upload/media/spree/'.$comp['cover'];?>" class="card-img-middle" alt="">
							<?php } else { ?>
								<img src="<?php print base_url().'images/media/img-not-found/jpg/100';?>" class="card-img-middle" alt="">
							<?php }?>
								</div>
							</div>
							<div class="card-body pad-0">
								<p class="card-text">Game Starts in</p>
								<div class="periodic_timer_minutes_1">
									<div class="jumbotron countdown show" data-Date='<?php print date('Y/m/d 23:59:59', strtotime($comp['compain_s_date']));?>'>
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
								<div class="btn-group" role="group" aria-label="Basic example">
									<button type="button" data-url="<?=base_url()?>/stores/<?=$comp['store_slug']?>" data-id="<?=my_encrypt($comp['vendor_id'])?>" data-comp="<?=my_encrypt($comp['com_id'])?>" <?=getUserId() == 0?'onclick="showLogin(\'login\');"':''?> class="btn btn-sm btn-play upcoming_select_store" style="font-size: 16px;">SELECT&nbsp;ITEMS</button>
									<button type="button" class="btn btn-light"  style="font-size: xx-small;width: 75%;color: #ff694e;">
									    <div class="row">
									        <div class="col-1" style="margin-left: 10%;">
									          <div class="lgztext">
        											<span>
        												 <svg xmlns="http://www.w3.org/2000/svg" width="11" height="24" viewBox="0 0 11 24">
            												<g id="Group_1" data-name="Group 1" transform="translate(-1363 -79)">
            													<text id="Z" transform="translate(1363 98)" fill="#fb5000" font-size="18" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>
            													<g id="Rectangle_4" data-name="Rectangle 4" transform="translate(1367 82)" fill="#fff" stroke="#fb5000" stroke-width="1">
            													<rect width="2" height="4" stroke="none"/>
            													<rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
            													</g>
            													<g id="Rectangle_5" data-name="Rectangle 5" transform="translate(1367 98)" fill="#fff" stroke="#fb5000" stroke-width="1">
            													<rect width="2" height="4" stroke="none"/>
            													<rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
            													</g>
            												</g>
        												</svg>
        											</span>
        										</div>  
									        </div>
									        <div class="col-5" style="font-size: 20px;font-weight: bolder;margin-left: -12%;margin-top: -2%;">
									            15
									        </div>
									        <div class="col-6" style="margin-left: -15%; text-transform: uppercase; font-weight: bold; text-align: left;">
									            Per Minute
									        </div>
									    </div>
									</button>
								</div>
							
							</div>
							</div>
						</div>
				<?php		// code...
					}
				?>
					</div>
				</div>
			</section>
		<?php } ?>

		
<?php }?>