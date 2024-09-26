<?php print view('vendors/header');?>
	<section class="bread">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12">
				<div class="bb d-flex align-items-center">
					<i onclick="openNav()" class="openbtn d-lg-none  fa-solid fa-bars me-3"></i>
						<ul class="p-0 m-0 d-flex align-items-center">
							<li>
								<a href="<?php print base_url();?>">Home</a>
							</li>
							<li>/</li>
							<li><?php print $pagetitle;?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="position-relative">
<div class="container ">
					<?php print view('vendors/sidebar');?>
<section>
  	<div class="row">
  		<div class="col-lg-12">
  			<h1 class="text-center"style="font-family: Alumni Sans !important; font-size: 3.125rem;"><b>Contact Us</b></h1>
  			<h5 class="text-center">Item are reserved for 60 minutes</h5>
  		</div>
  	</div>
	 
  	<div class="row flex-lg-row flex-column justify-content-around">
  	 <div class="col-lg-6 col-12 mt-4">
  			<img src="/theme/image/Group 626.svg" class="img-responsive img-thumbnail">
  		<div class="row flex-column flex-sm-row">
  				<div class="col-sm-6 col-12">
		  			<h5 class="mt-4 "style="font-family: Alumni Sans !important; font-size: 2.125rem;"><b>Address</b></h5>
		  			<p>You Can Reach Us at this address</p>
  		   </div>
  		   <div class="col-sm-6 col-12">
		  			<h5 class="mt-4"style="font-family: Alumni Sans !important; font-size: 2.125rem;"><b>Phone</b></h5>
		  			<img src="/theme/image/Untitled-1.png"> <a href="tel:+971 0549983130"> +92 047776573130</a><br><br>
		  			<img src="/theme/image/Untitled-1.png"> <a href="tel:+971 0549983130"> +92 054976575670</a><br><br>
  		   </div>
  		</div>
  		<div class="row">
  			<div class="col-6">
		  			<h2 class=""style="font-family: Alumni Sans !important; font-size: 2.125rem;"><b>Online Services</b></h2>
		  			<img src="/theme/image/Untitled-2.png"> www.zappta.com<br><br>
		  			<img src="/theme/image/Untitled-3.png"> zappta@gmail.com<br><br>
  		   </div>
  		</div>
  	</div>

  		<div class="col-lg-4 col-12 mt-4">
  			<div class="card" >
				  <div class="card-body">
				   <form method="post" action="<?php print base_url().'/contact-us';?>"> 
				   	<span id="SuccessMessage" style="color:Green"></span>
				   	  <div class="form-group"><br>
					    <label for="name">Full Name</label>
					    <input type="name" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Your Name">
					    
					    
					   </div>
					   <span id="errorForm" style="color:blue"></span> 
					  <div class="form-group"><br>
					    <label for="exampleInputEmail1">Email</label>
					    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
					    
					   </div>
					   <span id="errorForms" style="color:blue"></span>
						  <div><br>
							  <p><label for="message">Message:</label></p>
                <textarea id="message" class="form-control" name="message" id="message" rows="4" cols="50"></textarea>
                </div><br>
                <span id="errorFormss" style="color:blue"></span>
                <input type="hidden" id="_vendor_login_token" value="<?php print csrf_hash() ?>">
               <button type="button" name="submitcontact"  id="submitcontact" class="btn btn-primary" onclick="SendMessage()" style="background-color:#fb5000">Submit</button>
             </form>
				  </div>
       </div>
  		</div>
  	
	
	</div>
 </section>
 </div>
 </section>
<?php // print view('vendors/footer');?>
<script type="text/javascript">
	function SendMessage(){
		var name = $('#name').val();
		var email = $('#exampleInputEmail1').val();
		var message = $('#message').val();
		var csrf_token = $('#_vendor_login_token').val();
		let errors = 0;
	  jQuery('#errorForm,#errorForms,#email_error ,#errorFormss').text(' ');
		     if(name == ''){
          	$('#errorForm').html('<p class="alert alert-danger">Please Enter Your Name</p>');
             errors++;
          }
          else if(email == ''){
          	$('#errorForms').html('<p class="alert alert-danger">Please Enter Your Email</p>');
          	errors++;
          }
          else if(message == ''){
          	$('#errorFormss').html('<p class="alert alert-danger">Please Enter Your Message</p>');
          	errors++;
          }
          else{
 			$.ajaxSetup({
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', csrf_token);
        }
    });
 					$.ajax({
				url: baseUrl+'/contact-us',
				type: 'POST',
				data : { 'name' : name, 'email' : email, 'message' : message,'<?= csrf_token() ?>':'<?= csrf_hash() ?>'},
				dataType: 'JSON',
				success: function(resp){
					if(resp != ''){
						$('#SuccessMessage').html('<p class="alert alert-success">Your Message has been Sent Successfully!</p>');
						setTimeout(function(){
							window.location.href="";
						}, 5000);
					}
				}
		});
 				}
 	}
</script>