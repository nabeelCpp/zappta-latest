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

			<div class=" d-flex">
				<?php print view('dashboard/sidebar');?>
				<!-- Page content holder -->
				<div class="page-content p-5 " id="content">

					<div class="dashboard-page">
						
						<h3 class="mb-3"><i onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>Communication & privacy</h3>

						<p class="dasht mb-3 pt-3">How zappta communicate with you and what it shares..</p>
						<div class="accordion" id="accordionExample">
						  <div class="accordion-item">
						    <h2 class="accordion-header" id="headingOne">
						      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						        What information zappta collect from customer directly?
						      </button>
						    </h2>
						    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
						      <div class="accordion-body">
						        <p>We collect information directly or indirectly through your use of the website, register with our site, participate in our offers and programs, purchase products from our site or in stores, call Customer Care, participation in Zappta Giveaway, or otherwise provide information directly to us. The following are examples of information we may collect directly from you:</p>
						        <ul>
						        	
						        	<li>Name, email address, postal address</li>
						        	<li>Username and password.</li>
						        	<li>Phone number or mobile number.</li>
						        	<li>Age</li>
						        	<li>Geolocation information.</li>
						        	<li>Date of birth.</li>
						        	<li>Demographic information.</li>
						        	<li>Payment information (such as a credit card) and transaction history.</li>
						        	<li>Future communication preferences.</li>
						        </ul>
						      </div>
						    </div>
						  </div>
						  <div class="accordion-item">
						    <h2 class="accordion-header" id="headingTwo">
						      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						        How Zappta Use your Information?
						      </button>
						    </h2>
						    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
						      <div class="accordion-body">
						    <p>To provide offers, products and services. We use the information we collect to provide the products and services you request, to tell you about other products and services offered by Zappta, and to manage our sites and services.</p>
						    <p>The following are ways we may use the information we collect about you:</p>
						    <ul>
						    	<li>Send offers and information.</li>
						    	<li>Develop new products and services.</li>
						    	<li>Enroll you in contests, programs, or offers you request</li>
						    	<li>To provide you with other services.</li>
						    	<li>Create and manage your account.</li>
						    	<li>Protect against or identify possible fraudulent transactions.</li>
                                 <li>Provide you with customized, unsolicited offers and information about Zappta products and services.</li>
                                 <li>Develop and provide advertising tailored to your interests.</li>
                                 <li>Analyze the use of our products, services and sites.</li>
                                 <li>Understand how you arrived at our site.</li>
                                 <li>Determine the effectiveness of our advertising.</li>
                                 <li>Enforce our Terms and Conditions and otherwise manage or protect our business.</li>
                                 <li>In the event of a sale of Zappta, we may transfer your information as part of the transaction.</li>
						    </ul>
						      </div>
						    </div>
						  </div>
						  <div class="accordion-item">
						    <h2 class="accordion-header" id="headingThree">
						      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						        How to communicate with zappta?
						      </button>
						    </h2>
						    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
						      <div class="accordion-body">
						       <p>When you use Zappta, or send e-mails, text messages, you can send us your quires thorough contact us page from your desktop or mobile device to us, you may be communicating with us electronically. You consent to receive communications from us electronically, such as e-mails, texts, mobile push notices, or notices. You agree that all agreements, notices, disclosures, and other communications that we provide to you electronically satisfy any legal requirement that such communications be in writing.</p>
						      </div>
						    </div>
						  </div>
						</div>

					</div>

				</div>
				<!-- End demo content -->
			</div>

		</div>
	</section>


<?php print view('site/footer');?>