<?php print view('site/header');?>



<?php if(getUserId() > 0){ ?>
	<div class="embed-responsive embed-responsive-1by1">
		<iframe style="width:99vw !important;height:100vh !important;" class="embed-responsive-item" src="<?=base_url()?>/Spin Wheel v3.1/index.html" ></iframe>
	</div>
<?php } ?>


	<!-- <section class="htext-block">
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
					<a href="<?php print base_url().'/compaign';?>" class="seeall">See All</a>
				</div>
			</div>
		</div>
	</section> -->
<?php print view('site/footer');?>
<?php if(!getUserId()){ ?>
	<script>
		$(document).ready(function(){
			$('.btnlogin').click();
		})
	</script>
<?php } ?>