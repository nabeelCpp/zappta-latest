<?php print view('admin/header');?>
	
		<div class="row">
				<div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                	<h4 class="card-title">Add Slide</h4>
                	<form method="post" action="<?php print base_url().'/admincp/sliders/search/insert';?>" enctype="multipart/form-data">
                		<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>">
                		<div class="form-group">
                			<label>Slide Text</label>
                			<input type="text" name="name" placeholder="Slide Text" class="form-control" required />
                		</div>
                		<button class="btn btn-info" type="submit">Add</button>
                	</form>
                </div>
            </div>
        </div>
		</div>

<?php print view('admin/footer');?>