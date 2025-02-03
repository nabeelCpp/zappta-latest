<?php print view('site/header');?>

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

			<!-- div class="position-relative d-flex"> -->
			<div class="d-flex">
				<div >				
					<?php print view('dashboard/sidebar');?>
				</div>
				<div class="p-4">
				   <div class="row py-4 px-3" style="border-bottom: 3px solid #F5F5F5;">
					  <div>
							<div class="" id="content">
								<div class="dashboard-page">
									<h5 class=""><i onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>Hi <?php print getUserName();?>, How can we help you?</h5>
								</div>
							</div>
				     </div>	
				    
			    </div>

<style>
#help-accordian div{
width:100%;
}
</style>

			    <div id="help-accordian" class=" d-flex flex-wrap flex-md-row flex-column">
					<?php foreach ($faqs as $key => $faq) { ?>
						<div class=" mt-5">
							<div class="accordion w-100" id="accordionExample_<?=$key?>">
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingOne<?=$key?>">
										<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?=$key?>" aria-expanded="true" aria-controls="collapseOne<?=$key?>">
											<?=$faq['question']?>
										</button>
									</h2>
									<div id="collapseOne<?=$key?>" class="accordion-collapse collapse " aria-labelledby="headingOne<?=$key?>" data-bs-parent="#accordionExample_<?=$key?>">
										<div class="accordion-body">
											<p><?=$faq['answer']?></p>
											<?php if(isset($faq['steps']) && $faq['steps']): ?>
												<ul>
													<?php foreach ($faq['steps'] as $key => $step) { ?>
														<li><?=$step?></li>
													<?php } ?>
												</ul>
											<?php endif; ?>
											<?php if(isset($faq['additional_info']) && $faq['additional_info']): ?>
												<p><?=$faq['additional_info']?></p>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
			    </div>
			        
				
			        
				
			    <div class="row mt-5">
			    	<div class="col-12">
			    		<blockquote class="blockquote">
						  <h4 class="mb-0 blockquote-footer text-center">Need more help ?</h4>
						</blockquote>
			    	</div>
			    </div>
			    <div class="d-flex justify-content-center">
			    	<div class=" p-5" style="background-color: #F5f5F5;">
				    	<div class="row">
				    		<div class="col-lg-7">
				    			<h5><i class="fa fa-headphones" aria-hidden="true"></i> Online Service</h5>
				    			<p class="text-muted">24/7</p>
				    		</div>
				    		<div class="col-lg-5 pull-right ml-3">
				    			<button class="btn btn-primary" onclick="window.location.href='<?php print base_url().'/contact-us';?>'" style="color: #FFFFFF;border: 1px solid #FB5000;background: #FB5000;">Contact Us</button>
				    		</div>
				    	</div>
			    	</div>

			    	
			    	
			    </div>
			  </div>
			</div>

		</div>
	</section>


<?php print view('site/footer');?>