<?php $db = \Config\Database::connect();
$spintowinNotification =  count($db->table('spree')
->where('is_read',0)
->get()
->getResultArray());

?>
			
			<div id="mySidepanel" class="sidepanel">
                     <a href="javascript:void(0)" class="closebtn d-lg-none" onclick="closeNav()">×</a> 
			
			<!-- Vertical navbar -->
			<div class="vertical-nav " id="sidebar">
				<div class="py-4 px-3"style="border-bottom: 3px solid #F5F5F5;">
				    <div class="media d-flex align-items-center">
				      <div class="media-body">
				        <h4 class="m-0">Hi, <?php print getUserName();?></h4>
				        <p class="font-weight-light text-muted mb-0">Thanks for being a Zappta customer </p>
				      </div>
				    </div>
				</div>
                <div class="py-4 px-3" style="border-bottom: 3px solid #F5F5F5;">
                	<div class="media-body">
					  	<ul class="nav flex-column ">
						    <li class="nav-item<?php if( getUrlSegment()[0] == 'history'){?> active-links<?php }?>">
						      	<a href="<?php print base_url().'/dashboard/history';?>" class="purchase-history nav-link">
						            Purchase History
						        </a>
						    </li>
						     <li class="nav-item<?php if( getUrlSegment()[0] == 'wallet'){?> active-links<?php }?>">
						      	<a href="<?php print base_url().'/dashboard/wallet';?>" class="wallet nav-link">
						            Wallet
						    	</a>
						    </li>
							<li class="nav-item<?php if( getUrlSegment()[0] == 'spree'){?> active-links<?php }?>">
								<a href="<?php print base_url().'/dashboard/spree';?>" class="registries nav-link">
									<div class="carticon">
									SPIN TO WIN CART
									
										<span class="ml-3">
											<svg xmlns="http://www.w3.org/2000/svg" width="23" height="25.754" viewBox="0 0 23 25.754">
												<g id="Group_2" data-name="Group 2" transform="translate(-1512 -69.246)">
												<g id="Rectangle_6" data-name="Rectangle 6" transform="translate(1512 76)" fill="none" stroke="#1a1a1a" stroke-width="1.5">
													<path d="M0,0H23a0,0,0,0,1,0,0V15a4,4,0,0,1-4,4H4a4,4,0,0,1-4-4V0A0,0,0,0,1,0,0Z" stroke="none"/>
													<path d="M.75.75h21.5a0,0,0,0,1,0,0V15A3.25,3.25,0,0,1,19,18.25H4A3.25,3.25,0,0,1,.75,15V.75A0,0,0,0,1,.75.75Z" fill="none"/>
												</g>
												<path id="Path_3" data-name="Path 3" d="M1517.49,79s-1.314-12.158,8.869-8.217c.164,0,2.956,2.966,2.628,8.217" fill="none" stroke="#1a1a1a" stroke-width="1.5"/>
												</g>
											</svg>
										</span><?php if(isset($spintowinNotification) && $spintowinNotification > 0){ ?>
											<span id="cartListGiveaway" class="fa fa-beat" style="margin-left: -15px;font-size: xx-small; color: green"><i class="fa fa-dot-circle-o"></i></span>
										<?php } ?>	
								</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="py-4 px-3"style="border-bottom: 3px solid #F5F5F5;">
					<h5>Manage Account</h5>
					<div class="media-body">
						  	<ul class="nav flex-column ">
						     <li class="nav-item<?php if( getUrlSegment()[0] == 'account'){?> active-links<?php }?>">
				      	     <a href="<?php print base_url().'/dashboard/account';?>" class="personal-info nav-link">
				                Personal info
				    	     </a>
				            </li>
						    <li class="nav-item<?php if( getUrlSegment()[0] == 'addresses'){?> active-links<?php }?>">
						      	<a href="<?php print base_url().'/dashboard/addresses';?>" class="address nav-link">
						            Address
						    	</a>
						    </li>
						   <li class="nav-item<?php if( getUrlSegment()[0] == 'communication'){?> active-links<?php }?>">
						      	<a href="<?php print base_url().'/dashboard/communication';?>" class="communication nav-link">
						            Communication & privacy
						    	</a>
						    </li> 
						</ul>
					</div>
					
				</div>
					<div class="py-4 px-3"style="border-bottom: 3px solid #F5F5F5;">
					   <h5>My Items</h5>
						<div class="media-body">
							  	<ul class="nav flex-column ">
							  		 <!-- <li class="nav-item<?php if( getUrlSegment()[0] == 'communication'){?> active-links<?php }?>">
							      	<a href="<?php print base_url().'/dashboard/communication';?>" class="communication nav-link">
							           Recorders
							    	</a>
							    </li> -->
							      <li class="nav-item<?php if( getUrlSegment()[0] == 'wishlist'){?> active-links<?php }?>">
							      	<a href="<?php print base_url().'/dashboard/wishlist';?>" class="list nav-link">
							            List
							    	</a>
							    </li>
								 
							   
							</ul>
						</div>
				   </div>
                    
				   	<div class="py-4 px-3"style="border-bottom: 3px solid #F5F5F5;">
							   <h5>Privacy</h5>
								<div class="media-body">
							  	<ul class="nav flex-column ">
							      <li class="nav-item<?php if( getUrlSegment()[0] == 'privacy'){?> active-links<?php }?>">
								      	<a href="<?php print base_url().'/privacy-policy';?>" class="privacy-policy nav-link">
								           Privacy Policy
								    	</a>
								    </li>
								     <!--  <li class="nav-item<?php if( getUrlSegment()[0] == 'personal'){?> active-links<?php }?>">
								      	<a href="<?php print base_url().'/dashboard/personal';?>" class="donot nav-link">
								            Do not sell my personal info
								    	</a>
								    </li> -->
							    
							</ul>
						</div>
				   </div>

				   	<div class="py-4 px-3"style="border-bottom: 3px solid #F5F5F5;">
							   <h5>Customers Services</h5>
								<div class="media-body">
							  	<ul class="nav flex-column ">
							     <li class="nav-item<?php if( getUrlSegment()[0] == 'help'){?> active-links<?php }?>">
								      	<a href="<?php print base_url().'/dashboard/help';?>" class="help nav-link">
								           Help
								    	</a>
								  </li>

								     
											    
							</ul>
						</div>
				   </div>
				   <div class="py-4 px-3">
					   	<div class="media-body">
					   	<ul class="nav flex-column ">
					   	 <li class="nav-item">
					      	<a href="<?php print base_url().'/logout';?>" class="signout nav-link">
					           Sign out
					    	</a>
					    </li>
					    </ul>
					   </div>
				  </div>

				<!--     <li class="nav-item<?php if( getUrlSegment()[0] == 'addresses'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/addresses';?>" class="address nav-link">
				            Address
				    	</a>
				    </li> -->
				   
				<!-- </ul> -->
			  	
			  	<!-- <p>Manage Account</p> -->

			  	<!-- <ul class="nav flex-column dashb"> -->
			<!-- 	    <li class="nav-item<?php if( getUrlSegment()[0] == 'account'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/account';?>" class="personal-info nav-link">
				           Personal info
				    	</a>
				    </li> -->
				<!--     <li class="nav-item<?php if( getUrlSegment()[0] == 'wishlist'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/wishlist';?>" class="list nav-link">
				            Wishlist
				    	</a>
				    </li> -->
				    <!-- <li class="nav-item<?php if( getUrlSegment()[0] == 'communication'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/communication';?>" class="communication nav-link">
				            Communication & privacy
				    	</a>
				    </li> -->
			  	<!-- </ul> -->

			  	<!-- <p>My Items</p> -->

			  
			  	<!-- <ul class="nav flex-column dashb">
				    <li class="nav-item<?php if( getUrlSegment()[0] == 'registries'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/registries';?>" class="registries nav-link">
				            Registries
				    	</a>
				    </li>
			  	</ul> -->

			 	<!-- <p>Privacy</p>

			  	<ul class="nav flex-column dashb">
				    <li class="nav-item<?php if( getUrlSegment()[0] == 'privacy'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/privacy';?>" class="privacy-policy nav-link">
				           Privacy Policy
				    	</a>
				    </li>
				    <li class="nav-item<?php if( getUrlSegment()[0] == 'personal'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/personal';?>" class="donot nav-link">
				            Do not sell my personal info
				    	</a>
				    </li>
			  	</ul> -->

			 	<!-- <p>Customer Services</p> -->

			  	<!-- <ul class="nav flex-column dashb"> -->
			<!-- 	    <li class="nav-item<?php if( getUrlSegment()[0] == 'help'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/help';?>" class="help nav-link">
				           Help
				    	</a>
				    </li>
 -->		<!-- 		    <li class="nav-item<?php if( getUrlSegment()[0] == 'terms'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/terms';?>" class="termofuse nav-link">
				            Terms of Use
				    	</a>
				    </li> -->
			  	<!-- </ul> -->

			  	<!-- <ul class="nav flex-column"> -->
			<!-- 	    <li class="nav-item">
				      	<a href="<?php print base_url().'/logout';?>" class="signout nav-link">
				           Sign out
				    	</a>
				    </li> -->
		<!-- 	  	</ul> -->
			  <!-- Toggle button -->
			  <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4 position-absolute"><i class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">Toggle</small></button>
			</div>
			<!-- End vertical navbar -->
</div>


<script>
function openNav() {
  document.getElementById("mySidepanel").style.display="block";
}

function closeNav() {
  document.getElementById("mySidepanel").style.display="none";
}
</script>