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
			    	<div class=" mt-5">
			    		<div class="accordion w-100" id="accordionExample">
							  <div class="accordion-item">
								    <h2 class="accordion-header" id="headingOne1">
								      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
								       Where is my Order
								      </button>
								    </h2>
								    <div id="collapseOne1" class="accordion-collapse collapse" aria-labelledby="headingOne1" data-bs-parent="#accordionExample">
								      <div class="accordion-body">
								      <p>You can find tracking information in your order details. If an order includes multiple items, each may have 
                                       separate delivery dates and tracking information.</p>
                                      <p>To track your order:</p>
                                      <ul>
                                      	<li>Go to Your Orders.</li>
                                      	<li>Go to the order you want to track.</li>
                                      	<li>Select Track order next to your order.</li>
                                      	<li>Select see all updates to view delivery updates</li>
                                      </ul>
								      </div>
								    </div>
							  </div>
						</div>
			    	</div>
			    	<div class=" mt-5">
			    			<div class="accordion w-100" id="accordionExample">
							  <div class="accordion-item">
								    <h2 class="accordion-header" id="headingOne2">
								      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
								        How to refund
								      </button>
								    </h2>
								    <div id="collapseOne2" class="accordion-collapse collapse" aria-labelledby="headingOne2" data-bs-parent="#accordionExample">
								      <div class="accordion-body">
								        <p>The appropriate tax amount by item will be included with your refund. Original shipping and handling 
                                           fees (if applicable) may be deducted from the value of your refund unless the return is a result of our 
                                           error. Refunds will be issued in the form of purchase gift cards.</p>
								      </div>
								    </div>
							  </div>
						</div>
			    	</div>
					<div class=" mt-5">
			    		<div class="accordion w-100" id="accordionExample">
							  <div class="accordion-item">
								    <h2 class="accordion-header" id="headingOne3">
								      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne3">
								      How To change order information?
								      </button>
								    </h2>
								    <div id="collapseOne3" class="accordion-collapse collapse" aria-labelledby="headingOne3" data-bs-parent="#accordionExample">
								      <div class="accordion-body">
								    <p> You can update the shipping address, payment method, and more, on orders that haven't entered the 
                                      shipping process by visiting Your Orders in Your Account.</p>
                                      <ul>
                                      	<li>Go to Your Orders.</li>
                                      	<li>Select Order Details link for the order you want to change.</li>
                                      	<li>To edit orders shipping address select Change next to the details you want to modify (shipping address, 
                                        payment method, gift options, etc.).</li>
                                      	<li>Follow the on-screen instructions to change the desired information.</li>
                                      </ul>
								      </div>
								    </div>
							  </div>
						</div>
			    	</div>

			    	<div class="mt-5">
			    			<div class="accordion w-100" id="accordionExample">
							  <div class="accordion-item">
								    <h2 class="accordion-header" id="headingOne4">
								      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
								        How long it will take to receive a credit or refund for returned items ?
								      </button>
								    </h2>
								    <div id="collapseOne4" class="accordion-collapse collapse" aria-labelledby="headingOne4" data-bs-parent="#accordionExample">
								      <div class="accordion-body">
								      <p>Returns are processed in 10-14 business days and refunds can be expected 5-7 business days after 
                                         processing.</p>
								      </div>
								    </div>
							  </div>
						</div>
			    	</div>
					<div class=" mt-5">
			    		<div class="accordion w-100" id="accordionExample">
							  <div class="accordion-item">
								    <h2 class="accordion-header" id="headingOne5">
								      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">
								       How To cancel order ?
								      </button>
								    </h2>
								    <div id="collapseOne5" class="accordion-collapse collapse show" aria-labelledby="headingOne5" data-bs-parent="#accordionExample">
								      <div class="accordion-body">
								      	<p>
								   You can cancel orders that haven't entered the shipping process yet. Go to Your Orders and select the 
                                   order you want to cancel.</p>
                                   <ul>
                                   	<li>Select Cancel items</li>
                                   	<li>Select the check box of the item you want to remove from the order. To cancel the entire order,select all of the items.</li>
                                   	<li>Select Cancel selected items in this order when finished.</li>
                                   </ul>
								      </div>
								    </div>
							  </div>
						</div>
			    	</div>
			    	<div class=" mt-5">
			    			<div class="accordion w-100" id="accordionExample">
							  <div class="accordion-item">
								    <h2 class="accordion-header" id="headingOne6">
								      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne6" aria-expanded="true" aria-controls="collapseOne6">
								        How to replace a Damaged , Defactive and Broken item ?
								      </button>
								    </h2>
								    <div id="collapseOne6" class="accordion-collapse collapse " aria-labelledby="headingOne6" data-bs-parent="#accordionExample">
								      <div class="accordion-body">
								     <p>If you received a damaged, defective, or incorrect item sold by Amazon, you can request a replacement
                                     for eligible items through Your Orders.</p>
                                     <p>To replace an item:</p>
                                     <ul>
                                     	<li>Go to Your Orders and select beside the item you want to replace.</li>
                                     	<li>Select the item that you want to replace and select a reason from the Reason for return menu.</li>
                                     	<li>If your item is ineligible for replacement, you will be asked to return it</li>
                                
                                     </ul>
                                     <p>A replacement order, with the same shipping speed that was used on your original item, will be created. 
                                     Use the return label provided to you to send your original item back. You'll need to return the original
                                     item within 30 days</p>


								      </div>
								    </div>
							  </div>
						</div>
			    	</div>
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