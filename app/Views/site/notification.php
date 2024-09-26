<?php print view('site/header');?>
<?php $notifications = getNotifications(10);  ?>
<div class="container">
	<div class="row" >
		<div class="col-12" >
			<ul style="list-style: none;">
				<li>
			<h4 style="margin-left: -33px;">Notifications</h4>
			</li>
            </ul>
		</div>
		<!-- <div class="col-12 mt-2">
			<div class="card">
				  <div class="card-body">
					<ul  style="list-style: none;">
					  	<li><h5 class="card-title">Today</h5><br></li><br>

				        <li>
				        	<div class="row">
				        		<div class="col-1" style="text-align: right;">
				        			
				        		</div>
				        		<div class="col-10">
							        <p class="card-text">No New Notifications</p><br>
							        <p>September 24</p>
						        </div>
						        <div class="col-1"></div>
				            </div>
				   		</li>
				   	</ul>

			    </div>
			</div>
		</div> -->
		<div class="col-12" >
			<div class="card"style="border-bottom: 1px solid grey;">
				  <div class="card-body">
				  	<ul  style="list-style: none;">
					  	<li>
				        <h5 class="card-title"></h5><br>
				        </li><br>
						<?php if(count($notifications) > 0){ 
							$csrf = csrf_hash();
							foreach($notifications as $notif){ ?>
								<li class="mb-5">
									<div class="row">
										<div class="col-1" style="text-align: right;">
											<img src="<?php print base_url();?>/theme/image/truckk.png" style="width:30px;">
										</div>
										<div class="col-10" onclick="window.location.href='<?=str_replace('{csrf_hash}', $csrf, $notif['link'])?>'">
											<p class="card-text"><?=$notif['notification']?></p><br>
											<p><?=date('M d Y', strtotime($notif['created_at']))?></p>
										</div>
										<div class="col-1">
											<input type="checkbox" class="">
										</div>
									</div>
								</li>
							<?php } 
						}else{ ?>
							<li>
								<div class="row">
									<div class="col-1" style="text-align: right;">
										
									</div>
									<div class="col-10">
										<p class="card-text">No New Notifications</p><br>
										<!-- <p>September 24</p> -->
									</div>
									<div class="col-1"></div>
								</div>
							</li>
						<?php } ?>
			         </ul>
			    </div><br>
			      <!-- <div class="card-footer bg-transparent ">
			      	<ul style="list-style: none;">
			      		  <li class="mt-5">
				        	<div class="row">
				        		<div class="col-1" style="text-align: right;">
				        			<img src="<?php print base_url();?>/theme/image/doublemail.png" style="width:30px;">
				        		</div>
				        		<div class="col-10">
							        <p class="card-text">You have unread messages</p><br>
							        <p>September 24</p>
						        </div>
						        <div class="col-1">
						        	<input type="checkbox" class="" checked>
						        </div>
				            </div>
				   		</li>
			      		<li>
			          <h5 class="card-title mt-4">You have unread Notifications</h5><br>
			          </li>
			          <li>
			        <p class="card-text">No New Notifications</p><br>
			        </li>
			        </ul>
			  </div> -->

			</div>
		</div>
		<div class="mb-5" style="text-align: right;">
			<button type="pill pill-danger btn-sm" style="color: white; background: #FB5000; border-radius: 5px;">
				<i class="fa fa-trash"></i>
			</button>
		</div>
	<!-- 	<div class="col-12" >
			<div class="card">
				  <div class="card-body">
			       <p class="card-text">Your Order <b style="color: #FB5000;">#123456789</b> has been shipped. Track Your Order Online</p>
			         <p>September 24</p>			    </div>
			</div>
		</div>
		<div class="col-12" >
			<div class="card">
				  <div class="card-body">
			        <h5 class="card-title">You have unread Notifications</h5>
			        <p class="card-text">No New Notifications</p>
			    </div>
			</div>
		</div> -->
	</div>
</div>
<?php print view('site/footer');?>