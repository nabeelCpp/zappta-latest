<?php print view('site/header');
$give_review = false; ?>
<style type="text/css">
	.ratings {
		 color:  white;
	}

	/*.ratings span:hover{
		color:  #fb5000;
	}

	.ratings span:hover ~span{
		color:  #fb5000;
	}*/

	.ratings .active {
		 color:  #fb5000;
	}
	.ratings span{
		cursor: pointer;
	}
</style>

	<section class="bread">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12">
					<div class="bb">
						<ul class="p-0 m-0 d-flex align-items-center">
							<li>
								<a href="<?php print base_url();?>">Home</a>
							</li>
							<li>/</li>
							<li>
								<a href="<?php print base_url().'/dashboard';?>"><?php print $pagetitle;?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="dashboard">
		<div class="container">

			<div class="position-relative d-flex">
				<?php print view('dashboard/sidebar');?>
				<!-- Page content holder -->
				<div class="page-content p-5 position-relative" id="content">

					<div class="dashboard-page">
						
						<h3><i onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>Order Status</h3>
						
						<div class="row mt-4">
							
							<div class="col-12">
							<?php 
								if( is_array($order_timeline) && count($order_timeline) ) {
							?>
					<div class="timeline">
								<?php 
									foreach ( $order_timeline as $time ) { 
										switch ($time['status']) {
											case 1:
								?>	
									  <div class="containers right">
									    <div class="date"><?php print date('j D F y', strtotime($time['created_at']));?></div>
									    <i class="icon fa far fa-thumbs-up"></i>
									    <div class="content">
									      <h2><?php print strip_tags(orderCartOnAdminStatus($time['status']));?></h2>
									    </div>
									  </div>
								<?php 
												break;
											case 2:	
								?>
									  <div class="containers left">
									    <div class="date"><?php print date('j D F y', strtotime($time['created_at']));?></div>
									    <i class="icon fa fas fa-tag"></i>
									    <div class="content">
									      <h2><?php print strip_tags(orderCartOnAdminStatus($time['status']));?></h2>
									    </div>
									  </div>
								<?php 
												break;
											case 3:	
								?>
									  <div class="containers right">
									    <div class="date"><?php print date('j D F y', strtotime($time['created_at']));?></div>
									    <i class="icon fa fas fa-truck"></i>
									    <div class="content">
									      <h2><?php print strip_tags(orderCartOnAdminStatus($time['status']));?></h2>
									    </div>
									  </div>
								<?php 
												break;
											case 4:	
												$give_review = true;
								?>
									  <div class="containers left">
									    <div class="date"><?php print date('j D F y', strtotime($time['created_at']));?></div>
									    <i class="icon fa fab fa-periscope"></i>
									    <div class="content">
									      <h2><?php print strip_tags(orderCartOnAdminStatus($time['status']));?></h2>
									    </div>
									  </div>
								<?php 
												break;
											case 5:	
								?>
									  <div class="containers right">
									    <div class="date"><?php print date('j D F y', strtotime($time['created_at']));?></div>
									    <i class="icon fa fas fa-undo"></i>
									    <div class="content">
									      <h2><?php print strip_tags(orderCartOnAdminStatus($time['status']));?></h2>
									    </div>
									  </div>
								<?php 
												break;
											case 6:	
								?>
									  <div class="containers left">
									    <div class="date"><?php print date('j D F y', strtotime($time['created_at']));?></div>
									    <i class="icon fa fas fa-ban"></i>
									    <div class="content">
									      <h2><?php print strip_tags(orderCartOnAdminStatus($time['status']));?></h2>
									    </div>
									  </div>
							<?php 
												break;
											case 7:	
								?>
									  <div class="containers left">
									    <div class="date"><?php print date('j D F y', strtotime($time['created_at']));?></div>
									    <i class="icon fa fas fa-ban"></i>
									    <div class="content">
									      <h2><?php print strip_tags(orderCartOnAdminStatus($time['status']));?></h2>
									    </div>
									  </div>
							<?php 
												break;
											// case 2:	
									}
								}
							?>
								</div>
						<?php }else{ ?>
							<div class="timeline">
								<div class="containers right">
								    <div class="date"><div class="date"><?php print date('j D F y', strtotime($possible_arrival));?></div></div>
								    <i class="icon fa far fa-thumbs-up"></i>
								    <div class="content">
								      <h2><?php print strip_tags(orderCartOnAdminStatus(0));?></h2>
								    </div>
								  </div>

								  <div class="containers left" style="opacity: 0.5">
								    <i class="icon fa far fa-truck"></i>
								    <div class="content">
								      <h2><?php print strip_tags(orderCartOnAdminStatus(3));?></h2>
								    </div>
								  </div>

								  <div class="containers right" style="opacity: 0.5">
								    <i class="icon fa far fa-periscope"></i>
								    <div class="content">
								      <h2><?php print strip_tags(orderCartOnAdminStatus(4));?></h2>
								    </div>
								  </div>
							</div>
						<?php } ?>
							</div>

						</div>

					</div>
					
					<?php if($give_review): ?>
						<div class="p-5 bg-secondary mt-3" style="background: #e4e4e4  !important;">
							<form action="<?=base_url().route_to('customer.save.review', my_encrypt($order_id))?>" class="jumbotron" id="reviewForm">
								<?php if(!$review){ ?>
									<textarea name="review" id="review" class="form-control" placeholder="Enter your detailed review!"></textarea>
									<input type="hidden" value="0" name="rating" id="rating">
									<input type="hidden" value="<?=csrf_hash()?>" id="_cc" name="<?=csrf_token()?>">
									<div class="text-center py-2 ratings"  data-clicked="0">
										<span data-id="1"><i class="fa fa-star"></i></span>
										<span data-id="2"><i class="fa fa-star"></i></span>
										<span data-id="3"><i class="fa fa-star"></i></span>
										<span data-id="4"><i class="fa fa-star"></i></span>
										<span data-id="5"><i class="fa fa-star"></i></span>
									</div>
									<div class="text-center">
										<button type="reset" class="btn btn-danger">Cancel</button>
										<button type="submit" class="btn btn-success">Save</button>
									</div>
								<?php }else{ ?>
									<p class="h4">Reviews</p>
									<hr>
									<?php foreach ($review as $key => $r) { ?>
										<div class="text-justified">
											<?=$r->comments?>
										</div>
										<div class="py-2 ratings">
											<?php for ($i=1; $i <= 5; $i++) {  ?>
												<span class="<?= $i <= $r->rates?'active':''?>"><i class="fa fa-star"></i></span>
											<?php } ?>
										</div>
									<?php } ?>
								<?php } ?>
							</form>
						</div>

					<?php endif ?>

				</div>
				<!-- End demo content -->
			</div>

		</div>
	</section>
	<?php if(!$review){ ?>
		<script type="text/javascript">
			$('#reviewForm').submit(function(e){
				e.preventDefault();
				let form = $(this);
				let url = form.attr('action');
				let formdata = form.serialize();
				$.ajax({
					url: url,
					type: 'POST',
					dataType: 'json',
					data: formdata,
					beforeSend: function(){
						form.css('pointer-events', 'none');
						form.css('opacity', '0.4');
					},
					success: function(data){
						form.removeAttr('style');
						if(data.code == 200){
							html = `<div class="alert alert-success text-center">${data.msg}</div>
									<p class="h4">Reviews</p>
									<hr>
									${data.review.map((r)=>{
										let span = '';
										for (let i=1; i <= 5; i++) {
											span += `<span class="${i <= r.rates?'active':''}"><i class="fa fa-star"></i></span>`;
										}
										return `
										<div class="text-justified">
											${r.comments}
										</div>
										<div class="py-2 ratings">
											${span}	
										</div>`;
									}).join("")}`;
							form.html(html);
						}
					}
				})
			})
			$('.ratings span').hover(function(){
				$(this).parent().find('span').removeClass('active');
				$(this).prevAll().addClass('active');
				
				$(this).addClass('active');
			});
			$('.ratings').mouseleave(function(){
				if(!parseInt($(this).attr('data-clicked'))){
					$(this).find('span').removeClass('active');
				}
			})
			$('.ratings span').click(function(){
				let rating = $(this).data('id');
				$(this).parent().find('span').removeClass('active');
				$(this).prevAll().addClass('active');
				$(this).parent().attr('data-clicked', '1');
				$('#rating').val(rating);
				$(this).addClass('active');
			})
		</script>
	<?php } ?>

<?php print view('site/footer');?>