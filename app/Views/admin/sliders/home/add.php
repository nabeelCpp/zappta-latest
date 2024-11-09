<?php print view('admin/header');?>
	
	<div class="row">
		<div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                	<h4 class="card-title">Add Slide</h4>
                	<form method="post" action="<?php print base_url().'/admincp/sliders/homepage/insert';?>" enctype="multipart/form-data">
                		<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>">
                		<div class="form-group">
                			<label>Upload Image</label>
                			<input type="file" name="fimg" class="form-control" required onchange="checkImageDimensions(this)" data-type="slider" />
                		</div>
                		<button class="btn btn-info" type="submit">Add</button>
                	</form>
                </div>
            </div>
        </div>
	</div>

<?php print view('admin/footer');?>