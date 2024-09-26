<?php print view('site/header');?>
<?php if ( is_array($compaign) && count($compaign) > 0 ) { ?>

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
								<a href="<?php print base_url().'/compaign';?>">Giveway</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="htext-block">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-xl-2 col-lg-2 col-md-2 col-12">
					<div class="livebtn" style="max-width:135px;"></div>
				</div>
				<div class="col-xl-9 col-lg-9 col-md-9 col-12">
					<div class="livetext d-flex">
						<h3>
							<b>Spin to Win</b>
							<span>Shopping sprees. Happening Now</span>
						</h3>
					</div>
				</div>
				<div class="col-xl-1 col-lg-1 col-md-1 col-12 text-end">
					<!-- <a href="<?php print base_url().'/compaign';?>" class="seeall">See All</a> -->
				</div>
			</div>
		</div>
	</section>
	
	<section class="hproduct-block">
		<div class="container">
			<div class="row">
		<?php 
			foreach ( $compaign as $comp) {
		?>
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 mb-4">
					<div class="card">
					<?php 
	    				if( ! empty( $comp['store_logo'] ) ) { 
	    					$ext_name = explode('.',$comp['store_logo']);
	    			?>
	    				<img src="<?php print base_url().'/images/media/'.$ext_name[0].'/'.$ext_name[1].'/250';?>" class="animate card-img-top" alt="">
	    			<?php } else { ?>
	    				<img src="<?php print base_url().'/images/media/img-not-found/jpg/100';?>" class="animate card-img-top" alt="">
	    			<?php }?>

					  <div class="card-body">
					    <h5 class="card-title">WIN</h5>
					    <p class="card-text price-block">$<?php print $comp['final_price'];?></p>
					    <p class="card-text mt-2 mb-2"><?php print short($comp['pname'],20);?></p>
					    <div class="hp-img">
					<?php 
	    				if( ! empty( $comp['pcover'] ) ) { 
	    					$ext_cover = explode('.',$comp['pcover']);
	    			?>
	    				<img src="<?php print base_url().'/images/product/'.$ext_cover[0].'/'.$ext_cover[1].'/250';?>" class="animate card-img-middle" alt="">
	    			<?php } else { ?>
	    				<img src="<?php print base_url().'/images/media/img-not-found/jpg/100';?>" class="animate card-img-middle" alt="">
	    			<?php }?>
					  	</div>
					  </div>
					  <div class="card-body pad-10">
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
					    <a href="<?php print base_url().'/products/'.$comp['purl'].'/p/'.$comp['pc'].'/'.'?sd_row='.$comp['sd_row'].'&pds='.$comp['pds'].'&give=1';?>" class="btn btn-play">PLAY NOW</a>
					  </div>
					</div>
				</div>
		<?php		// code...
			}
		?>
			</div>
			<div class="row">
				<div class="col-12">
					<?php 
						if ( $total_products > 12 ) { ?>
					<div class="pagenation">
						<?php print $pager->makeLinks($page, 12, $total_products,'front_full') ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>


<?php }?>
<?php print view('site/footer');?>