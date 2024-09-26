<?php print view('admin/header');?>
		<div class="row">
            <div class="col-md-12 col-xl-12 grid-margin stretch-card">
            	<div class="card">
            		<div class="card-header"><?php print show_message();?></div>
	                <div class="card-body">
		            	<ul class="nav nav-tabs" role="tablist">
		                    <li class="nav-item">
		                      <a class="nav-link<?php if($page == 'profile'){?> active<?php }?>" href="<?php print base_url().ADMINURL.'settings/?tabs='?>profile">Profile</a>
		                    </li>
		                    <li class="nav-item">
		                      <a class="nav-link<?php if($page == 'dollors'){?> active<?php }?>" href="<?php print base_url().ADMINURL.'settings/?tabs='?>dollors">Z- Dollors</a>
		                    </li>
		                    <li class="nav-item">
		                      <a class="nav-link<?php if($page == 'commission'){?> active<?php }?>" href="<?php print base_url().ADMINURL.'settings/?tabs='?>commission">Commission</a>
		                    </li>
		                    <li class="nav-item">
		                      <a class="nav-link<?php if($page == 'email'){?> active<?php }?>" href="<?php print base_url().ADMINURL.'settings/?tabs='?>email">Email</a>
		                    </li>
		                </ul>
		                <div class="tab-content">
		                	<?php print view('admin/setting/'.$page);?>
		                </div>
		            </div>
	            </div>
            </div>
        </div>
<?php print view('admin/footer');?>