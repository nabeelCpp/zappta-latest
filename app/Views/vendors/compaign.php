<?php 
	$ccomp = vendorcompain();
	if ( !empty($ccomp) ) {
		if ( !empty($ccomp) && $ccomp['cvs'] == 1 ) {
?>	
	<div class="row">
		<div class="col-12">
			<div class="alert alert-success mt-4 mb-4 compaignblock">
				<h3 class="text-capitalize mt-0"><?php print $ccomp['compain_name'];?></h3>
				<p>Starting From: <?php print $ccomp['compain_s_date'];?> , <?php print $ccomp['compain_e_date'];?></p>
				<?php print html_entity_decode($ccomp['compain_msg']);?>
				<p style=" font-size: 12px;font-weight: bold; margin-top: 10px;" class="mt-4 mb-4">
					<a href="javascript:void(0);" class="btn btn-default btn-sm">View Terms & Condition</a>
					<a href="<?php print base_url().'/vendors/products/compaign?pro=1&cc='.my_encrypt($ccomp['compaign_id']);?>" class="btn btn-success btn-sm">Accept Compaign</a>
					<a href="<?php print base_url().'/vendors/products/compaign?pro=2&cc='.my_encrypt($ccomp['compaign_id']);?>" class="btn btn-danger btn-sm">Decline Compaign</a>
				</p>
			</div>
		</div>
	</div>
<?php		
	} elseif ( $ccomp['cvs'] == 2) {
?>
	<div class="row">
		<div class="col-12">
			<div class="alert alert-info mt-4 mb-4 compaignblock">
				<h3  class="text-capitalize mt-0"><?php print $ccomp['compain_name'];?></h3>
				<p  style=" font-size: 12px;font-weight: bold; margin-top: 10px;">Starting From: <?php print $ccomp['compain_s_date'];?> To : <?php print $ccomp['compain_e_date'];?></p>
			</div>
		</div>
	</div>
<?php
	}
}
?>