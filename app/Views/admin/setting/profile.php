
<?php $commission = (new \App\Models\Setting())->orderBy('id', 'ASC')->GetValues(['name','email','mobile','whatsapp','company_name','tax_number','vat','mailaddress','frontend_logo','backend_logo', 'vendor_display']);?>
<?php 
// print '<pre>';
// print_r($commission);
// print '</pre>';
// die();
?>


<form method="POST" action="<?php print base_url().ADMINURL.'settings/updateprofile';?>" enctype="multipart/form-data">
	<input type="hidden" name="<?php print csrf_token();?>" value="<?php print csrf_hash();?>">
	<div class="form-group">
		<div class="row">
			<div class="col-sm-12 col-md-6">
               <div class="form-group row">
			 <label class="col-sm-12 col-md-2 col-form-label">App Name</label>
	           <div class="col-sm-12 col-md-10">
	              <input type="text" class="form-control" name="name" id="name" value="<?php print $commission[1]['var_detail'];?>"
	               placeholder="">
	               <div class="invalid-feedback">
	                <span class="messages"></span>
	               </div>
	           </div>
	       </div>
	   </div>
	   
	         <div class="col-sm-12 col-md-6">
               <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">App Email</label>
                  <div class="col-sm-12 col-md-10">
                    <input type="text"
                      class="form-control"
                      name="email" id="app_email"
                      value="<?php print $commission[8]['var_detail'];?>"
                       placeholder="">
                        
                        <div class="invalid-feedback">
                          <span class="messages"></span>
                        </div>
                  
                    </div>
               </div>
           </div>
       </div>
       		<div class="row">
			<div class="col-sm-12 col-md-6">
               <div class="form-group row">
			 <label class="col-sm-12 col-md-2 col-form-label">Mobile Number</label>
	           <div class="col-sm-12 col-md-10">
	              <input type="text" class="form-control" name="mobile" id="app_number" value="<?php print $commission[3]['var_detail'];?>"
	               placeholder="">
	               <div class="invalid-feedback">
	                <span class="messages"></span>
	               </div>
	           </div>
	       </div>
	   </div>
	   
	         <div class="col-sm-12 col-md-6">
               <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Whats App</label>
                  <div class="col-sm-12 col-md-10">
                    <input type="text"
                      class="form-control"
                      name="whatsapp" id="whatsapp"
                      value="<?php print $commission[2]['var_detail'];?>"
                       placeholder="">
                        
                        <div class="invalid-feedback">
                          <span class="messages"></span>
                        </div>
                  
                    </div>
               </div>
           </div>
       </div>

        <div class="row">

             <div class="col-sm-12 col-md-6">
                   <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Company Name</label>
                     <div class="col-sm-12 col-md-10">
                      <input type="text"
                       class="form-control"
                        name="company_name" id="company_name" value="<?php print $commission[7]['var_detail'];?>"
                           placeholder="">


                                                    
                          <div class="invalid-feedback">
                          <span class="messages"></span>
                           </div>
                                                   
                        </div>
                     </div>
                  </div>
             
             <div class="col-sm-12 col-md-6">
                   <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">TAX Number</label>
                     <div class="col-sm-12 col-md-10">
                      <input type="text"
                       class="form-control"
                        name="tax_number" id="tax_number" value="<?php print $commission[6]['var_detail'];?>"
                           placeholder="">


                                                    
                          <div class="invalid-feedback">
                          <span class="messages"></span>
                           </div>
                                                   
                        </div>
                     </div>
                  </div>
       </div>

        <div class="row">

             <div class="col-sm-12 col-md-6">
                   <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">VAT (%)</label>
                     <div class="col-sm-12 col-md-10">
                      <input type="text"
                       class="form-control"
                        name="vat" id="vat" value="<?php print $commission[9]['var_detail'];?>"
                           placeholder="">


                                                    
                          <div class="invalid-feedback">
                          <span class="messages"></span>
                           </div>
                                                   
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                   <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Mail Address</label>
                     <div class="col-sm-12 col-md-10">
                      <input type="text"
                       class="form-control"
                        name="mailaddress" id="mailaddress" value="<?php print $commission[4]['var_detail'];?>"
                           placeholder="">


                                                    
                          <div class="invalid-feedback">
                          <span class="messages"></span>
                           </div>
                                                   
                        </div>
                     </div>
                  </div>
             
       </div>
        <div class="row">

        	   
		         
  	          <div class="col-sm-12 col-md-6">
               <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">FrontEnd  Logo</label>
                  <div class="col-sm-12 col-md-8">
                   <input type="file"
                    class="form-control"
                    accept="image/jpeg, image/png, image/jpg" value="<?=base_url().'/upload/logo/'.$commission[5]['var_detail']?>" name="logo[frontend_logo]"
                    id="logo">
                    
                   <div class="invalid-feedback">
                   <span class="messages"></span>
                   </div>
                 </div>
                 <div class="col-sm-12 col-md-2">
                   <?php if(!empty($commission[5]['var_detail'])) {?>
                    <img src="<?=base_url().'/upload/logo/'.$commission[5]['var_detail']?>" class="img img-thumbnail rounded-circle" style="width:80px;height:80px">
                    <?php } else { ?>
                      <img src="https://zappta.com/theme/image/logo.png" class="img img-thumbnail rounded-circle" style="width:80px;height:80px">
                    <?php } ?>
                 </div>
              </div>
            </div>
       
             
              <div class="col-sm-12 col-md-6">
               <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Backend  Logo</label>
                  <div class="col-sm-12 col-md-8">
                   <input type="file"
                    class="form-control"
                    accept="image/jpeg, image/png, image/jpg" value="<?=base_url().'/upload/logo/'.$commission[10]['var_detail']?>" name="logo[backend_logo]"
                    id="logo">
                   <div class="invalid-feedback">
                   <span class="messages"></span>
                   </div>
                 
                 </div>
                 <div class="col-sm-12 col-md-2">
                   <?php if(!empty($commission[10]['var_detail'])) {?>
                    <img src="<?=base_url().'/upload/logo/'.$commission[10]['var_detail']?>" class="img img-thumbnail rounded-circle" style="width:80px;height:80px">
                    <?php } else { ?>
                      <img src="https://zappta.com/theme/image/logo.png" class="img img-thumbnail rounded-circle" style="width:80px;height:80px">
                    <?php } ?>
                 </div>
              </div>
             
            </div>
       </div>
       <div class="row">
         
        <div class="col-sm-12 col-md-6">
          <div class="form-group row">
          <label class="col-sm-12 col-md-2 col-form-label">Homepage Vendors Display</label>
            <div class="col-sm-12 col-md-10">
            <input type="text"
              class="form-control"
              name="vendor_display" id="vendor_display" value="<?php print $commission[11]['var_detail'];?>"
                  placeholder="YEAR/MONTH/WEEK">


                                          
                <div class="invalid-feedback">
                <span class="messages"></span>
                  </div>
                                          
              </div>
            </div>
        </div>
       </div>


   </div>
   <button type="submit" name="submit" class="btn btn-primary">Update</button>
</form>