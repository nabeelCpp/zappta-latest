<?php print view('site/header');?>
<?php 
		$spindata = getWheelDataOnSpin(1);
		$wheel_data = [
							$spindata['box_1'],
							$spindata['box_2'],
							$spindata['box_3'],
							$spindata['box_4'],
							$spindata['box_5'],
							$spindata['box_6'],
							$spindata['box_7'],
							$spindata['box_8'],
							$spindata['box_9'],
							$spindata['box_10'],
							$spindata['box_11'],
							$spindata['box_12'],
							$spindata['box_13'],
							$spindata['box_14'],
							$spindata['box_15'],
							$spindata['box_16']






							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
							// $spindata['box_14'],
					];
		$wh = "'" . implode ( "', '", $wheel_data ) . "'";

		// print '<pre>';
		// print_r($single);
		// print '</pre>';
?>
	<!-- <section class="wheel-block">
		
		<div class="container-fluid">
			<div class="row">
				<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-12">
					<div class="game-end-block">
						<div class="jumbotron countdown show" data-Date='<?php print date('Y/m/d 23:59:59', strtotime($single['compain_e_date']));?>'>
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

				</div>
				<div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-12">
					<div class="points-tb">
						<div class="d-flex justify-content-end align-items-center">
							<div class="ptb d-flex">
								<div class="ptest">
									<svg xmlns="http://www.w3.org/2000/svg" width="162" height="38" viewBox="0 0 162 38">
									  <g id="Group_1317" data-name="Group 1317" transform="translate(-1135 -38)">
									    <text id="Z_Coins_Played" data-name="Z Coins Played" transform="translate(1216 68)" fill="#fff" font-size="28" font-family="OpenSans-Bold, Open Sans" font-weight="700"><tspan x="-80.322" y="0">Z</tspan><tspan y="0" xml:space="preserve" font-size="22"> Coins Played</tspan></text>
									    <g id="Rectangle_5127" data-name="Rectangle 5127" transform="translate(1143 67)" fill="#fff" stroke="#fff" stroke-width="1">
									      <rect width="2" height="4" stroke="none"/>
									      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
									    </g>
									    <g id="Rectangle_5128" data-name="Rectangle 5128" transform="translate(1143 45)" fill="#fff" stroke="#fff" stroke-width="1">
									      <rect width="2" height="4" stroke="none"/>
									      <rect x="0.5" y="0.5" width="1" height="3" fill="none"/>
									    </g>
									  </g>
									</svg>
								</div>
								<div class="ptpp count" id="playedCoins"><?php print number_format( (new \App\Models\CompainModel())->getZapptaPlay(1, $pid) );?></div>
							</div>
							<div class="ptb d-flex">
								<div class="ptest">
									<svg xmlns="http://www.w3.org/2000/svg" width="126" height="30" viewBox="0 0 126 30">
									  <text id="Points_Won" data-name="Points Won" transform="translate(63 24)" fill="#fff" font-size="22" font-family="OpenSans-Bold, Open Sans" font-weight="700"><tspan x="-62.079" y="0">Points Won</tspan></text>
									</svg>
								</div>
								<div class="ptpp count" id="playedCoinsWins" ><?php print number_format( (new \App\Models\CompainModel())->getZapptaWinPlay(1, $pid) );?></div>
							</div>
							<div class="ptb d-flex">
								<div class="ptest">
									<svg xmlns="http://www.w3.org/2000/svg" width="122" height="30" viewBox="0 0 122 30">
									  <text id="Total_Score" data-name="Total Score" transform="translate(61 24)" fill="#fff" font-size="22" font-family="OpenSans-Bold, Open Sans" font-weight="700"><tspan x="-60.833" y="0">Total Score</tspan></text>
									</svg>
								</div>
								<div class="ptpp count" id="playedCoinsTotal"><?php print number_format( (new \App\Models\CompainModel())->getTotalResult(1, $pid) );?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-12">
					<div class="topPlayerBlock" id="topPlayerBlock">
						<div class="tphead">
							<h3>top 20 players</h3>
						</div>
						<div class="tptable">
							<div class="d-flex thtablehead justify-content-center align-items-center">
								<div class="ht">Player</div>
								<div class="ht">Score</div>
								<div class="ht">Strikes</div>
							</div>
							<div class="tpplayerblockresult" id="tpplayerblockresult">
							<?php 
								$points = (new \App\Models\CompainModel())->getUserCompaignResult(1,my_encrypt($single['com_id']),$single['store_id'],$single['pid']);
						        if ( is_array($points) && count($points) > 0 ) {
						            $html = '';
						            usort($points, function ($item1, $item2) {
						                return $item2['score'] <=> $item1['score'];
						            });
						            $sr = 1;
						            foreach( $points as $p ) {
						                $html .= '<div class="resultplay">
						                            <div class="no">'.$sr++.'</div>
						                            <div class="imgtitle d-flex">
						                                <div class="img"></div>
						                                <div class="tt">'.$p['fname'].'</div>
						                            </div>
						                            <div class="sc">'.$p['score'].'</div>
						                            <div class="strike">'.$p['strikes'].'</div>
						                        </div>';
						            }
						        	print $html;
						        }
							?>
							</div>
						</div>
						<div class="strike-block">
				    		<div class="position-relative d-flex">
			    				<div class="currentstrike d-flex">
			    				<?php 
			    					$total_stikes_attend = (new \App\Models\CompainModel())->getTotlStrike(1, $single['compain_e_date'], $single['compain_s_date'], $pid);
			    					switch ($total_stikes_attend) {
			    						case 1:
			    				?>
		    						<span class="strike strike_1 attends"></span>
		    						<span class="strike strike_2"></span>
		    						<span class="strike strike_3"></span>
			    				<?php
			    							break;

			    						case 2:
			    				?>
		    						<span class="strike strike_1 attends"></span>
		    						<span class="strike strike_2 attends"></span>
		    						<span class="strike strike_3"></span>
			    				<?php
			    							break;

			    						case 3:
			    				?>
		    						<span class="strike strike_1 attends"></span>
		    						<span class="strike strike_2 attends"></span>
		    						<span class="strike strike_3 attends"></span>
			    				<?php
			    							break;
			    						
			    						default:
			    				?>
		    						<span class="strike strike_1"></span>
		    						<span class="strike strike_2"></span>
		    						<span class="strike strike_3"></span>
			    				<?php
			    							break;
			    					}
			    				?>
			    				</div>
			    				<div class="strike-text">
			    					<p>3 strikes loses</p>
									<p>Total score</p>
			    				</div>
				    		</div>
						</div>
					</div>
				</div>

				<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-12">
				    <div class="position-relative">
				    		<div class="wheel_canvas">
							    <div style="font-family: avantBold"> </div>
							    <canvas id='canvas' class="" width='390' height='390'></canvas>
							    <div class="insideCircle"><div class="insideCircle__circle"></div></div>
							    <div id="answer-box" class="answer">
						    		<div class="position-relative">
						    				<p id="popupText" class="answer__Text">WATCH OUT!</p>
						    		</div>
						    		<div class="position-relative">
						    				<p class="subheadanswerwheel"> 3 strikes wipes out your total score.</p>
						    		</div>
						    		<div class="position-relative">
						    				<p class="score-red" id="total_strikes"> 2 STRIKES</p>
						    		</div>
						    		<div class="position-relative">
						    				<p class="warning-sign"></p>
						    		</div>
						    		<div class="position-relative">
						    				<p class="leftstrike" id="leftstrike">You have only 1 strike left</p>
						    		</div>
						    		<div class="position-relative">
					    				<p class="currentstrike d-flex">
				    						<span class="strike-title">Strikes</span>
				    						<span class="strike strike_1"></span>
				    						<span class="strike strike_2"></span>
				    						<span class="strike strike_3"></span>
					    				</p>
						    		</div>
						    		<div class="position-relative">
						    				<p class="retrybtn">
						    						<span><i class="fas fa-redo-alt"></i></span>
						    						<span>Retry</span>
						    				</p>
						    		</div>
							    </div>
						  	</div>
						  	<div class="wheelbb">
						  		<div class="d-flex justify-content-center align-items-center mb-4">
						  			<div class="ddsd">
						  				<svg xmlns="http://www.w3.org/2000/svg" width="81.458" height="40.139" viewBox="0 0 81.458 40.139">
										  <g id="Group_154" data-name="Group 154" transform="translate(24.999 4.367)">
										    <g id="Path_112" data-name="Path 112" transform="translate(-24.999 -4.367)" fill="#52496c" stroke-linejoin="bevel">
										      <path d="M 80.45803833007812 39.13874816894531 L 1.000004291534424 39.13874816894531 L 1.000004291534424 1.000005483627319 L 80.45803833007812 1.000005483627319 L 80.45803833007812 39.13874816894531 Z" stroke="none"/>
										      <path d="M 2 1.999996185302734 L 2 38.13874816894531 L 79.45803070068359 38.13874816894531 L 79.45803070068359 1.999996185302734 L 2 1.999996185302734 M 0 -3.814697265625e-06 L 81.45803070068359 -3.814697265625e-06 L 81.45803070068359 40.13874816894531 L 0 40.13874816894531 L 0 -3.814697265625e-06 Z" stroke="none" fill="#fff"/>
										    </g>
										    <g id="Group_52" data-name="Group 52" transform="translate(-13.999 4.633)">
										      <text id="ATM" transform="translate(40.25 18.361)" fill="#fff" font-size="20" font-family="Montserrat-SemiBold, Montserrat" font-weight="600"><tspan x="-22.71" y="0">ATM</tspan></text>
										      <g id="Group_51" data-name="Group 51" transform="translate(0)">
										        <g id="Group_1318" data-name="Group 1318">
										          <text id="Z" transform="translate(6 18)" fill="#fff" font-size="20" font-family="Montserrat-SemiBold, Montserrat" font-weight="600"><tspan x="-6.63" y="0">Z</tspan></text>
										          <g id="Rectangle_30" data-name="Rectangle 30" transform="translate(5.112 1.147)" fill="#fff" stroke="#fff" stroke-width="1">
										            <rect width="1.775" height="3.649" stroke="none"/>
										            <rect x="0.5" y="0.5" width="0.775" height="2.649" fill="none"/>
										          </g>
										          <g id="Path_111" data-name="Path 111" transform="translate(5.112 17)" fill="#fff">
										            <path d="M 1.274860978126526 3.467641830444336 L 0.5000009536743164 3.467641830444336 L 0.5000009536743164 0.500001847743988 L 1.274860978126526 0.500001847743988 L 1.274860978126526 3.467641830444336 Z" stroke="none"/>
										            <path d="M 9.5367431640625e-07 1.9073486328125e-06 L 1.774860978126526 1.9073486328125e-06 L 1.774860978126526 3.967641830444336 L 9.5367431640625e-07 3.967641830444336 L 9.5367431640625e-07 1.9073486328125e-06 Z" stroke="none" fill="#fff"/>
										          </g>
										        </g>
										      </g>
										    </g>
										  </g>
										</svg>
						  			</div>
						  			<div class="bbl ms-2" id="bblance" data-coins="<?php print ( userTotalZappta() - 1 ) ;?>">
						  				<b>Balance:</b>
						  				<b id="balanceremin"><?php print number_format( ( userTotalZappta() - 1 ));?></b>
						  			</div>
						  		</div>
						  	</div>
						  	<div class="wheelinput">
						  		<div class="d-flex justify-content-center align-items-center">
						  			<div class="inbtnwheel cursor" id="whelminucbtn">
						  				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="36" height="36" viewBox="0 0 36 36">
										  <defs>
										    <radialGradient id="radial-gradient" cx="0.5" cy="0.5" r="0.5" gradientUnits="objectBoundingBox">
										      <stop offset="0" stop-color="#e5b33e"/>
										      <stop offset="1" stop-color="#d09408"/>
										    </radialGradient>
										  </defs>
										  <g id="Group_1184" data-name="Group 1184" transform="translate(-942 -956)">
										    <g id="Ellipse_21" data-name="Ellipse 21" transform="translate(942 956)" stroke="#fff" stroke-width="1.4" fill="url(#radial-gradient)">
										      <circle cx="18" cy="18" r="18" stroke="none"/>
										      <circle cx="18" cy="18" r="17.3" fill="none"/>
										    </g>
										    <path id="Icon_ionic-ios-add" data-name="Icon ionic-ios-add" d="M23.969,15.969H17.961c-.451,0-1.262.012-1.992,0H9.961a1,1,0,0,0,0,1.992H23.969a1,1,0,0,0,0-1.992Z" transform="translate(943.535 957.531)" fill="#fff" stroke="#fff" stroke-width="0.6"/>
										  </g>
										</svg>
						  			</div>
						  			<div class="inbtnwheel" id="inbtnwheellogo"></div>
						  			<div class="inbtnwheel cursor" id="whelplusbtn">
						  				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="54" height="54" viewBox="0 0 54 54">
										  <defs>
										    <radialGradient id="radial-gradient" cx="0.5" cy="0.5" r="0.5" gradientUnits="objectBoundingBox">
										      <stop offset="0" stop-color="#e9b848"/>
										      <stop offset="0.657" stop-color="#d3970c"/>
										      <stop offset="1" stop-color="#cf9205"/>
										    </radialGradient>
										    <filter id="Ellipse_20" x="0" y="0" width="54" height="54" filterUnits="userSpaceOnUse">
										      <feOffset dy="3" input="SourceAlpha"/>
										      <feGaussianBlur stdDeviation="3" result="blur"/>
										      <feFlood flood-opacity="0.161"/>
										      <feComposite operator="in" in2="blur"/>
										      <feComposite in="SourceGraphic"/>
										    </filter>
										  </defs>
										  <g id="Group_1183" data-name="Group 1183" transform="translate(-1069 -951)">
										    <g transform="matrix(1, 0, 0, 1, 1069, 951)" filter="url(#Ellipse_20)">
										      <g id="Ellipse_20-2" data-name="Ellipse 20" transform="translate(9 6)" stroke="#fff" stroke-width="1.4" fill="url(#radial-gradient)">
										        <circle cx="18" cy="18" r="18" stroke="none"/>
										        <circle cx="18" cy="18" r="17.3" fill="none"/>
										      </g>
										    </g>
										    <path id="Icon_ionic-ios-add" data-name="Icon ionic-ios-add" d="M23.969,15.969H17.961V9.961a1,1,0,0,0-1.992,0v6.008H9.961a1,1,0,0,0,0,1.992h6.008v6.008a1,1,0,1,0,1.992,0V17.961h6.008a1,1,0,0,0,0-1.992Z" transform="translate(1079.535 958.535)" fill="#fff" stroke="#fff" stroke-width="0.6"/>
										  </g>
										</svg>
						  			</div>
						  		</div>
						  		<div class="winp mt-3 d-flex justify-content-center align-items-center">
						  			<input type="text" id="wheelplayvalue" value="1" min="1" max="25" readonly>
						  		</div>
						  	</div>
							<?php if ( getUserId() == 0 ) { ?>
							<div class="spinbtns" onclick="showLogin('login');"><b>Spin</b></div>
							<?php } else { ?>
							<button type="button" class="spinbtn" id="spinbtn"><b>Spin</b></button>
							<?php } ?>
						</div>
				</div>
				
				<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-12">
					<div class="playproductinfo">
						<div class="piti">
							<div class="pinfoprice d-flex justify-content-center">
								<div class="sign">$</div>
								<div class="pri"><?php print $single['final_price'];?></div>
							</div>
						</div>
						<div class="pin position-relative d-flex">
							<?php 
								if( ! empty( $single['pcover'] ) ) { 
			    					$ext_name = explode('.',$single['pcover']);
			    					$dataimg  = base_url().'images/product/'.$ext_name[0].'/'.$ext_name[1].'/250';
			    				} else {
			    					$dataimg  = base_url().'images/product/img-not-found/jpg/100';
			    				}
								if( ! empty( $single['store_logo'] ) ) { 
			    					$ext_names = explode('.',$single['store_logo']);
			    					$store_logo  = base_url().'images/media/'.$ext_names[0].'/'.$ext_names[1].'/250';
			    				} else {
			    					$store_logo  = base_url().'images/product/img-not-found/jpg/100';
			    				}
							?>
							<div class="pinim">
								<img src="<?php print $dataimg;?>" alt="" />
								<div class="pintile"><?php print short($single['pname'],30);?></div>
							</div>
							<div class="pinst">
								<img src="<?php print $store_logo;?>" alt="" />
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>

	</section> -->




	<div class="embed-responsive embed-responsive-1by1">
		<iframe style="width:99vw !important;height:100vh !important;" class="embed-responsive-item" src="https://zappta.com/Spin%20Wheel%20v1.2.1/index.html" ></iframe>
	</div>


	<section class="htext-block">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-xl-2 col-lg-2 col-md-2 col-12">
					<div class="livebtn"></div>
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
					<a href="<?php print base_url().'compaign';?>" class="seeall">See All</a>
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
				<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
					<div class="card">
					<?php 
	    				if( ! empty( $comp['store_logo'] ) ) { 
	    					$ext_name = explode('.',$comp['store_logo']);
	    			?>
	    				<img src="<?php print base_url().'images/media/'.$ext_name[0].'/'.$ext_name[1].'/250';?>" class="animate card-img-top" alt="">
	    			<?php } else { ?>
	    				<img src="<?php print base_url().'images/media/img-not-found/jpg/100';?>" class="animate card-img-top" alt="">
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
	    				<img src="<?php print base_url().'images/product/'.$ext_cover[0].'/'.$ext_cover[1].'/250';?>" class="animate card-img-middle" alt="">
	    			<?php } else { ?>
	    				<img src="<?php print base_url().'images/media/img-not-found/jpg/100';?>" class="animate card-img-middle" alt="">
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
					    <a href="<?php print base_url().'products/'.$comp['purl'].'/p/'.$comp['pc'].'/'.'?sd_row='.$comp['sd_row'].'&pds='.$comp['pds'].'&give=1';?>" class="btn btn-play">PLAY NOW</a>
					  </div>
					</div>
				</div>
		<?php		// code...
			}
		?>
			</div>
		</div>
	</section>


<?php if ( getUserId() > 0 ) { ?>
<input type="hidden" id="winplayedCoins" value="<?=(new \App\Models\CompainModel())->getZapptaPlay(1, $pid)?>">
<input type="hidden" id="winplayedCoinsWins" value="<?=(new \App\Models\CompainModel())->getZapptaWinPlay(1, $pid)?>">
<input type="hidden" id="winplayedCoinsTotal" value="<?=(new \App\Models\CompainModel())->getTotalResult(1, $pid)?>">
<input type="hidden" id="winbalanceremin" value="<?php print ( userTotalZappta() - 1 ) ;?>">
<input type="hidden" id="winstrikes" value="<?=$total_stikes_attend?$total_stikes_attend:0?>">
<input type="hidden" id="winloser" value="0">
<input type="hidden" id="winpoerup" value="0">
<input type="hidden" id="points_result" value="0">

<script type="text/javascript">
	const [W,H] = [390,390];
	const ratio = W/H;

	// var wheel_spin_audio = new Audio('<?=base_url()?>/theme/audio/mixkit-bike-wheel-spinning-1613.wav');
	// var wheel_end_audio = new Audio('<?=base_url()?>/theme/audio/oppo ballys.mp3');
	// var display_score_audio = new Audio('<?=base_url()?>/theme/audio/mixkit-casino-winning-reward-1983.wav');
	// var display_strike_audio = new Audio('<?=base_url()?>/theme/audio/beep-warning-6387.mp3');
	// var bg_audio = new Audio('<?=base_url()?>/theme/audio/Slower_Version-2022-07-13_-_Our_Hopes_And_Dreams_-_www.FesliyanStudios.com.mp3');
	// setTimeout(function(){
	// 	bg_audio.play();
	// }, 3000);
	// bg_audio.loop=true;

	var wheelstrikes = !!localStorage.getItem('wheelstrikes') ? localStorage.getItem('wheelstrikes') : 0;
	let options = [<?php print $wh;?>];
	let colorsOdd = ['#58197c', '#fadfae', '#fadfae'];
	let colorsFill = ['#DAB44E', '#000000','#DAB44E', '#000000'];
	let colorsEven = ['#58197c', '#fadfae', '#58197c', '#fadfae'];
	let slices = options.length;
	let sliceDeg = 360/slices;
	let deg = 0;
	let width = canvas.width;
	let ctx = canvas.getContext('2d');
	let center = width/2;
	let spinDeg = 0;
	let mouseClicks = 0;
	let spinTime = 2;
	let spinDegCalc = 955;
	const deg2rad = (deg) => deg * Math.PI/180;
	const canvasWheel = document.querySelector('#canvas');
	const answerBox = document.querySelector('#answer-box');
	const textPart = document.querySelector('#popupText');
	const inputField = document.querySelector('#input-field');
	const clickable = document.querySelector('.spinbtn');
	
	const applyBtn = document.querySelector('#apply-btn');
	let myTimeout;
	let inputCount = 3;
	let colorNumber = 0;
	let fontsize = 95;

	ctx.canvas.width = W;
	ctx.canvas.height = H;


const drawSlice = (degg, color) => {
    ctx.beginPath();
    ctx.fillStyle = color;
		// ctx.fillRect(10,10,150,80);
    ctx.moveTo(center, center);
    ctx.arc(center, center, center, deg2rad(degg - 0.5), deg2rad(degg + sliceDeg + 0.5));
    ctx.fill();
}

const drawText = (deggg, text, color) => {
    ctx.save();
    ctx.translate(center, center);
    ctx.rotate(deg2rad(deggg));
    ctx.textAlign = 'left';
    ctx.fillStyle = color;
    ctx.font = 'Bold 20px avantBold';
    ctx.fillText(text, fontsize, 7);
    ctx.restore();
}

let drawWheel = (inpDeg) => {
    if(options.length % 2 === 0){
        for(let i = 0; i < slices; i++){
            if (colorNumber >= 4){
                colorNumber = 0;
                drawSlice(inpDeg, colorsEven[colorNumber]);
                drawText(inpDeg + sliceDeg/2, options[i], colorsFill[colorNumber]);
                inpDeg += sliceDeg;
                colorNumber++;
            }
            else{
                drawSlice(inpDeg, colorsEven[colorNumber]);
                drawText(inpDeg + sliceDeg/2, options[i], colorsFill[colorNumber]);
                inpDeg += sliceDeg;
                colorNumber++;
            }
        }
    }
    else{
        for(let i = 0; i < slices; i++){
            if (colorNumber >= 3){
                colorNumber = 0;
                drawSlice(inpDeg, colorsOdd[colorNumber]);
                drawText(inpDeg + sliceDeg/2, options[i], colorsFill[colorNumber]);
                inpDeg += sliceDeg;
                colorNumber++;
            }
            else{
                drawSlice(inpDeg, colorsOdd[colorNumber]);
                drawText(inpDeg + sliceDeg/2, options[i], colorsFill[colorNumber]);
                inpDeg += sliceDeg;
                colorNumber++;
            }
        }
    }
}

drawWheel(deg);

// const drawInputs = () => {
//     for(i = 1; i <= inputCount; i++){
//         inputField.insertAdjacentHTML("beforeend", `<input id="input${i}">`)
//     }
// }



// drawInputs();

const resultText = () => {
    let r = spinDeg % 360;
    r = Math.floor(r / sliceDeg);
    return options[r];
}

const randomR = () => {

    switch (Math.floor(Math.random() * Math.floor(7))) {
        case 0:
            spinTime *= 1.7;
            spinDegCalc *= 2.7;
            break;
        case 1:
            spinTime *= 1.8;
            spinDegCalc *= 3.8;
            break;
        case 2:
            spinTime *= 1.9;
            spinDegCalc *= 4.9;
            break;
        case 3:
            spinTime *= 2.1;
            spinDegCalc *= 5.0;
            break;
        case 4:
            spinTime *= 2.2;
            spinDegCalc *= 6.1;
            break;
        case 5:
            spinTime *= 2.3;
            spinDegCalc *= 7.2;
            break;
        case 6:
            spinTime *= 2.4;
            spinDegCalc *= 8.3;
            break;
    }
}


clickable.addEventListener("click", function() {

	const wheelplayvalue = document.getElementById('wheelplayvalue').value;
	if ( wheelplayvalue == 0 ) {
		alert('Please add alteast 1 Zappta Dollor');
	} else {
		abortRefreshResultsTimer();
		document.getElementById('spinbtn').disabled = true;

	    clearTimeout(myTimeout);
	    randomR();
	    answerBox.style.display = 'none';

	    spinDeg += spinDegCalc;
	    let rr = resultText();
	    getWheelREsult(rr,wheelplayvalue);

	    // textPart.innerHTML = rr;
	    canvasWheel.style.transition = `all ${spinTime}s cubic-bezier(.17,.74,.29,1.00) 0s`;
	    canvasWheel.style.transform = `rotate(-${spinDeg}deg)`;
		// wheel_spin_audio.play();
		// setTimeout(function(){
	    //     wheel_spin_audio.pause();
	    //     wheel_spin_audio.currentTime = 0;
	    //     wheel_end_audio.play();
	    //     getLatestResult();
	    //     restartTimer();
	    // }, spinTime*1000);

	    // myTimeout = setTimeout(function() { 
	    // 	document.getElementById('spinbtn').disabled = false;
	    // 	display_score_audio.play();
		// 	setTimeout(function(){
		//         display_score_audio.pause();
		//         display_score_audio.currentTime = 0;
		//     }, 3500);
	    // 	addValuesResult();
	    // }, ((spinTime*1000)+1500));

	    spinDegCalc = 960;
	    spinTime = 10;
	    
	}
});

answerBox.addEventListener("click", function() {
    // clearTimeout(myTimeout);
    // randomR();
    // answerBox.style.display = 'none'

    // spinDeg += spinDegCalc;
    // let rr = resultText();
    // textPart.innerHTML = rr;

    // canvasWheel.style.transition = `all ${spinTime}s cubic-bezier(.17,.74,.29,1.00) 0s`;
    // canvasWheel.style.transform = `rotate(-${spinDeg}deg)`;

    // myTimeout = setTimeout(function() { answerBox.style.display = 'inline-block' }, spinTime*1000);

    // spinDegCalc = 960;
    // spinTime = 10;
});



function addValuesResult()
{
	$('#playedCoins').text($('#winplayedCoins').val().toLocaleString('en-US'));
	$('#playedCoinsWins').text($('#winplayedCoinsWins').val().toLocaleString('en-US'));
	$('#playedCoinsTotal').text($('#winplayedCoinsTotal').val().toLocaleString('en-US'));
	$('#userTotalZappta').text($('#winbalanceremin').val().toLocaleString('en-US'));
	$('#balanceremin').text($('#winbalanceremin').val().toLocaleString('en-US'));
	$('#bblance').attr('data-coins',$('#winbalanceremin').val());
	const winstrikes = document.getElementById('winstrikes').value;
	const winloser = document.getElementById('winloser').value;
	const winpoerup = document.getElementById('winpoerup').value;
	

	$('.count').each(function () {
	    $(this).prop('Counter',0).animate({
	        Counter: $(this).text()
	    }, {
	        duration: 3500,
	        easing: 'swing',
	        step: function (now) {
	            $(this).text(Math.ceil(now));
	        }
	    });
	});
	document.getElementById('wheelplayvalue').value = 1;
	
	if ( winstrikes == 1 ) {
		$('.strike_1').addClass('attends');
		$('#total_strikes').text('1 STRIKES');
		$('#leftstrike').text('You have only 2 strike left');
		// display_score_audio.pause();
        // display_score_audio.currentTime = 0;
		// display_strike_audio.play();
		answerBox.style.display = 'block';

	} else if ( winstrikes == 2 ) {
		$('.strike_1').addClass('attends');
		$('.strike_2').addClass('attends');
		$('#total_strikes').text('2 STRIKES');
		$('#leftstrike').text('You have only 1 strike left');
		// display_score_audio.pause();
        // display_score_audio.currentTime = 0;
		// display_strike_audio.play();
		answerBox.style.display = 'block';
	} else if ( winstrikes == 3 ) {
		$('.answer__Text').text('SORRY');
		$('.warning-sign').css('background-image', "url(/theme/image/emojisad.png)");
		$('.warning-sign').css('width', "180px");
		$('.warning-sign').css('margin-left', "40px");
		$('.subheadanswerwheel').html('<strong>BETTER LUCK NEXT TIME</strong><br>YOU LOSE');
		$('#total_strikes').hide();
		$('.strike_1').addClass('attends');
		$('.strike_2').addClass('attends');
		$('.strike_3').addClass('attends');
		$('#total_strikes').text('3 STRIKES');
		$('#leftstrike').text('You have reached the limit of strikes');
		// $('#leftstrike').text('You have only 0 strike left');
		$('.retrybtn').html('<span><a href="<?=base_url()?>/compaign" style="color: white">END GAME</a></span>');
		// display_score_audio.pause();
        // display_score_audio.currentTime = 0;
		// display_strike_audio.play();
		answerBox.style.display = 'block';
		$('#spinbtn').attr('disabled', true);
		setTimeout(function(){
			window.location.href = '<?php print base_url().'compaign';?>';
		},5000);
	}

	if ( winpoerup == 1 ) {
		

		var url = '<?php print base_url().'compaign/play/'.$single['purl'].'/p/'.$single['pc'].'/'.'?sd_row='.$single['sd_row'].'&pds='.$single['pds'].'&playgive=1&wh=2';?>';
		var form = $('<form action="' + url + '" method="post">' +
		  '<input type="hidden" name="<?=csrf_token()?>" value="<?=csrf_hash()?>" />' +
		  '</form>');
		$('body').append(form);
		form.submit();
	}

}

function getWheelREsult(result,wheelplayvalue)
{
	$.ajax({
		url: '<?php print base_url();?>/compaign/playresult',
		type: 'POST',
		data: { 
				'res' : result, 
				'wheelplayvalue': wheelplayvalue,
				'wheel' : 1, 
				'winpidp': '<?php print my_encrypt($single['pid']);?>', 
				'winspidp': '<?php print my_encrypt($single['store_id']);?>', 
				'winscidp': '<?php print my_encrypt($single['com_id']);?>'
			},
		datatype: 'json',
		success: function(resp){
			r = JSON.parse(resp);
			$('#winplayedCoins').val(r[0].play);
			$('#winplayedCoinsWins').val(r[0].win);
			$('#winplayedCoinsTotal').val(r[0].total);
			$('#winbalanceremin').val(r[0].balance);
			$('#winstrikes').val(r[0].s);
			$('#winloser').val(r[0].l);
			$('#winpoerup').val(r[0].p);
			$('#points_result').val(r[0].points_result);
			$('#bblance').attr('data-coins',r[0].balance);
		}
	});
}


var timer = setInterval(function () {
	getLatestResult();
}, 30000);

function abortRefreshResultsTimer() {
	clearInterval(timer);
}

function restartTimer() {
	timer = setInterval(function () {
		getLatestResult();
	}, 30000);
}


function getLatestResult()
{
	$.ajax({
		url: '<?php print base_url();?>/compaign/latestresult',
		type: 'POST',
		data: { 
				'wheel' : 1, 
				'winpidp': '<?php print my_encrypt($single['pid']);?>', 
				'winspidp': '<?php print my_encrypt($single['store_id']);?>', 
				'winscidp': '<?php print my_encrypt($single['com_id']);?>'
			},
		datatype: 'json',
		success: function(resp){
			if(resp){
				r = JSON.parse(resp);
				$('#tpplayerblockresult').html(r);
			}
		}
	});
}
addValuesResult();
$('.retrybtn').click(function(){
	$(this).parents('#answer-box').hide(300);
})
</script>
<?php } ?>
<?php print view('site/footer');?>