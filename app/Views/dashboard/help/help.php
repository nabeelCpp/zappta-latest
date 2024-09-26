			<!-- Vertical navbar -->
			<div class="vertical-nav" id="sidebar">
				<div class="py-4 px-3">
				    <div class="media d-flex align-items-center">
				      <div class="media-body">
				        <h4 class="m-0">Hi, <?php print getUserName();?></h4>
				        <p class="font-weight-light text-muted mb-0">Thanks for being a Zappta customer </p>
				      </div>
				    </div>
				</div>

			  	<ul class="nav flex-column dasht">
				    <li class="nav-item<?php if( getUrlSegment()[0] == 'history'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/history';?>" class="purchase-history nav-link">
				            Purchase History
				        </a>
				    </li>
				    <!-- <li class="nav-item<?php if( getUrlSegment()[0] == 'reorder'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/reorder';?>" class="reorder nav-link">
				           Reorder
				    	</a>
				    </li> -->
				    <li class="nav-item<?php if( getUrlSegment()[0] == 'addresses'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/addresses';?>" class="address nav-link">
				            Address
				    	</a>
				    </li>
				    <li class="nav-item<?php if( getUrlSegment()[0] == 'wallet'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/wallet';?>" class="wallet nav-link">
				            Wallet
				    	</a>
				    </li>
				<!-- </ul> -->
			  	
			  	<!-- <p>Manage Account</p> -->

			  	<!-- <ul class="nav flex-column dashb"> -->
				    <li class="nav-item<?php if( getUrlSegment()[0] == 'account'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/account';?>" class="personal-info nav-link">
				           Personal info
				    	</a>
				    </li>
				    <li class="nav-item<?php if( getUrlSegment()[0] == 'wishlist'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/wishlist';?>" class="list nav-link">
				            Wishlist
				    	</a>
				    </li>
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
				    <li class="nav-item<?php if( getUrlSegment()[0] == 'help'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/help';?>" class="help nav-link">
				           Help
				    	</a>
				    </li>
				    <li class="nav-item<?php if( getUrlSegment()[0] == 'terms'){?> active-links<?php }?>">
				      	<a href="<?php print base_url().'/dashboard/terms';?>" class="termofuse nav-link">
				            Terms of Use
				    	</a>
				    </li>
			  	<!-- </ul> -->

			  	<!-- <ul class="nav flex-column"> -->
				    <li class="nav-item">
				      	<a href="<?php print base_url().'/logout';?>" class="signout nav-link">
				           Sign out
				    	</a>
				    </li>
			  	</ul>
			  <!-- Toggle button -->
			  <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4 position-absolute"><i class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">Toggle</small></button>
			</div>
			<!-- End vertical navbar -->
-------------------------------
	<div class="help-text">
							<div class="helps">
								<h4>Terms of Use</h4>
								<p>The Lorem ipsum text is derived from sections  &  of Cicero's 'De finibus bonorum et malorum'. The physical source may have been the 1914 Loeb Classical Library edition of De finibus, where the Latin text, presented on the left-hand (even) pages, breaks off on page 34 with "Neque porro quisquam est qui do-"& continues on page 36 with "lorem ipsum ...", suggesting that the galley type of that page was mixed up to make the dummy text seen today.</p>
								<p>The Lorem ipsum text is derived from sections  &  of Cicero's 'De finibus bonorum et malorum'. The physical source may have been the 1914 Loeb Classical Library edition of De finibus, where the Latin text, presented on the left-hand (even) pages, breaks off on page 34.</p>
							</div>
							<div class="helps">
								<h5>Introduction</h5>
								<p>The Lorem ipsum text is derived from sections  &  of Cicero's 'De finibus bonorum et malorum'. The physical source may have been the 1914 Loeb Classical Library edition of De finibus, where the Latin text, presented on the left-hand (even) pages, breaks off on page 34 with "Neque porro quisquam est qui do-"& continues on page 36 with "lorem ipsum ...", suggesting that the galley type of that page was mixed up to make the dummy text seen today.</p>
								<p>The Lorem ipsum text is derived from sections  &  of Cicero's 'De finibus bonorum et malorum'. The physical source may have been the 1914 Loeb Classical Library edition of De finibus, where the Latin text, presented on the left-hand (even) pages, breaks off on page 34.</p>
							</div>
							<div class="helps">
								<h5>DEFINED TERMS: In these Terms of Use:</h5>
								<ul>
									<li>The Lorem ipsum text is derived from sections  &  of Cicero's 'De finibus bonorum et malorum'.</li>
									<li>The physical source may have been the 1914 Loeb Classical Library edition of De finibus, where the Latin text, presented on the left-hand (even) pages, breaks off on page 34.</li>
									<li>Neque porro quisquam est qui do-"& continues on page 36 with "lorem ipsum ...", suggesting that the galley type of that page was mixed up to make the dummy text seen today.</li>
									<li>The physical source may have been the 1914 Loeb Classical Library edition of De finibus, where the Latin text, presented on the left-hand (even) pages, breaks off on page 34.</li>
									<li>The Lorem ipsum text is derived from sections  &  of Cicero's 'De finibus bonorum et malorum'.</li>
									<li>Neque porro quisquam est qui do-"& continues on page 36 with "lorem ipsum ...", suggesting that the galley type of that page was mixed up to make the dummy text seen today.</li>
								</ul>
							</div>
						</div>