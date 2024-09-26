<?php 
	$ccomp = vendorcompain();


		
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Zappta!</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?php print base_url().'/theme/css/bundle.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php print base_url().'/theme/css/theme.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php print base_url().'/theme/css/admin.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php print base_url().'/theme/js/vendors/css/dataTables.min.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php print base_url().'/theme/css/responsive-.css'?>">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script type="text/javascript">
		var baseUrl = '<?php print base_url();?>/';
	</script>
	<script type="text/javascript" src="<?php print base_url();?>/theme/js/bundle.js"></script>	
	<?php print csrf_meta() ?>
	<style type="text/css">
		.dropdown-toggle::after{
			display: none;
		}
	</style>
</head>
<body class="homepage">
	<!-- <div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div> -->
	<div class="loader">
	<div class="loadingio-spinner-wedges-6sp0olydj1g"><div class="ldio-ifqtsksmdi">
<div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div>
</div></div>
	</div>
	<header>
		<div class="middle-head">
			<div class="container">
				<div class="d-flex justify-content-between align-items-center">
					<div class="">
						<div class="logo">
							<a href="<?php print base_url();?>">
								<img src="<?php print base_url().'/theme/image/logo.png'?>" alt="" />
							</a>
						</div>
					</div>

					<div class="">

						<div class="header-right text-end float-end">
							<div class="cart-block d-flex align-items-center">
						<!-- 		 <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
			              <i class="fa fa-bell" aria-hidden="true"></i>
			                <span class="count d-none" id="checkCount"></span>
			              </a>
 -->
			              	<div class="dropdown">
									  <!-- 	<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
										    <span class="icon"><i class="fa-solid fa-user-check"></i></span> 
											<span>My Account</span>
									  	</a> --><!-- 
									  	<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false" >
									  				
										<span class="icon" style="color: black;" id="totalorders"><p id="countorders"></p><i class="fa-solid fa-bell"></i></span>

										
									</a> -->
									<button type="button" id="dropdownMenuLink2" class="btn btn-primary dropdown-toggle" style="border:none;background: linear-gradient(270deg, #9a4ac5 9.09%, #de48a1 76.77%);"  data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-bell fs-5" aria-hidden="true"></i>
									  <span class="badge badge-light bg-danger position-absolute  rounded-circle" style="top:-9px;right:-9px;border:2px solid white;"><p class="m-0" id="countorders"></p></span>
									</button>
									  	<div  class="dropdown-menu"  aria-labelledby="dropdownMenuLink2" style="width: 500px;">
										  	<ul class="list-group">
										  		<?php if ( !empty($ccomp) ) { ?>
										  			<li class="list-group-item">
													    <h3><?php print $ccomp['compain_name'];?></h3>
														<p>Starting From: <?php print $ccomp['compain_s_date'];?> To <?php print $ccomp['compain_e_date'];?></p>
										  			</li>
												<?php } ?>
			
											   <!--  <li>
											    	<a class="dropdown-item" href="<?php print base_url().'/notifications';?>">
											    		<span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
														<span style="color:#BF5000">See All Notifications</span>
											    	</a>
												</li> -->
										  	</ul>
										  	<div id="notificationList">
									  		
									  	</div>
									  	</div>
									  	
									</div>

								<div class="carticon">
									<a href="<?php print base_url().'/vendors/logout';?>" class="position-relative">
										<span>
											<svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
											  <g id="Icon_ionic-ios-log-out" data-name="Icon ionic-ios-log-out" transform="translate(0 0)">
											    <path id="Path_474" data-name="Path 474" d="M4.076,19.727a.691.691,0,0,1,.7.676.888.888,0,0,0,.9.869H14.99a.888.888,0,0,0,.9-.869V7.847a.888.888,0,0,0-.9-.869H5.678a.888.888,0,0,0-.9.869.7.7,0,0,1-1.4,0,2.264,2.264,0,0,1,2.3-2.222H14.99a2.264,2.264,0,0,1,2.3,2.222V20.4a2.264,2.264,0,0,1-2.3,2.222H5.678a2.264,2.264,0,0,1-2.3-2.222A.691.691,0,0,1,4.076,19.727Z" transform="translate(2.707 -5.625)" fill="#595959"/>
											    <path id="Path_475" data-name="Path 475" d="M14.962,11.021a.72.72,0,0,1,.5-.193.708.708,0,0,1,.5.193.628.628,0,0,1,0,.931L12.689,14.97H25.52a.659.659,0,1,1,0,1.316H12.674L15.858,19.3a.636.636,0,0,1,0,.931l-.005,0a.75.75,0,0,1-.491.183.7.7,0,0,1-.5-.193l-4.135-3.874a.887.887,0,0,1,0-1.373Z" transform="translate(-10.406 -7.124)" fill="#595959"/>
											  </g>
											</svg>
										</span>
										<span>Logout</span>
									</a>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<main>
		<script type="text/javascript">
    function loadNotification() {
      let url = '<?=base_url().route_to('vandor.notifications')?>';
      $.get(url, function(data){
      var count = data.length;
      $('#countorders').html(count);
  if(data != ' '){
            
            var html = `<a class="dropdown-item py-3">
                          
                        </a>
                        <div class="dropdown-divider"></div>
                        ${data.map(function(notif){
                          return `
                                
                                  <div class="preview-thumbnail">
                                     
                                  </div>
                                  <div class="preview-item-content flex-grow py-2">
                                  <ul style="list-style: none;">
                                  <li>
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">${notif.item_name}</p>
                                    </li>
                                    </ul>
                                  </div>`;
                        }).join("")}
                       `; 
        }else{
          var html = `<a class="dropdown-item py-3">
                          <p class="mb-0 font-weight-medium float-left">You Dont have any new Order </p>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item preview-item">      
                          <div class="preview-item-content flex-grow py-2">
                            <p class="h3">No unread notifications</p>
                          </div>
                        </a>
                        `;
        }
        $('#notificationList').html(html);
      })
      
    }
    loadNotification();
  </script>
