<?php print view('site/header');?>
<?php if(getUserId() > 0){ ?>
	<div class="embed-responsive embed-responsive-1by1">
		<iframe style="width:99vw !important;height:100vh !important;" class="embed-responsive-item" src="<?=base_url()?>spin-v-1.0.0/index.html" ></iframe>
	</div>
<?php } ?>
<?php print view('site/footer');?>
<?php if(!getUserId()){ ?>
	<script>
		$(document).ready(function(){
			$('.btnlogin').click();
		})
	</script>
<?php } ?>