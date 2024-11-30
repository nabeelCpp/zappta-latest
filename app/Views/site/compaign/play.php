
<?php if(getUserId() > 0){ ?>
	<div class="embed-responsive embed-responsive-1by1">
		<iframe style="width:99vw !important;height:100vh !important;" class="embed-responsive-item" src="<?=base_url()?>spin-v-1.0.02/index.html" ></iframe>
	</div>
<?php }else { ?>
	<script>
		alert('You need to be logged in to play the game');
		window.location.href = '<?=base_url()?>';
	</script>
<?php  } ?>