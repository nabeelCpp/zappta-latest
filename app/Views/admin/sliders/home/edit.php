<?php print view('admin/header');?>
	
	<div class="row">
		<div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                	<h4 class="card-title">Edit Slide</h4>
                	<form method="post" action="<?php print base_url().'/admincp/sliders/homepage/update';?>" enctype="multipart/form-data">
                		<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>">
                		<input type="hidden" name="_id" value="<?php print $id; ?>">
                		<div class="form-group">
                			<label>Upload Image</label>
                			<input type="file" name="fimg" class="form-control" required />
                		</div>
                		<div class="form-group">
                			<img src="<?php print getImageThumg('slider',$file, 100);?>" class="img-lg rounded" alt="" />
                		</div>
                		<button class="btn btn-info" type="submit">Update</button>
                	</form>
                </div>
            </div>
        </div>
	</div>

<?php print view('admin/footer');?>