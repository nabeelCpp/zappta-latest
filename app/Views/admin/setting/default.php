<form method="post" action="<?php print base_url().ADMINURL.'setting/update';?>">
	<input type="hidden" name="<?php print csrf_token();?>" value="<?php print csrf_hash();?>">
	<div class="form-group">
		<label class="col-sm-12 col-md-2 col-form-label">App Name</label>
           <div class="col-sm-12 col-md-10">
            <input type="text"
               class="form-control @error('app_name') is-invalid @enderror"
               name="app_name" id="app_name"
               value="{{ $settings[0]->value }}"
               placeholder="">
               
               <div class="invalid-feedback">
                <span class="messages"></span>
                </div>
             
         </div>
	</div>
</form>