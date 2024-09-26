<?php print view('admin/header');?>
	
	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card">
        	<div class="addbtn d-block text-end">
        		<a href="<?php print base_url().'/admincp/sliders/homepage/add';?>" class="float-end">
        			<span><i class="mdi mdi-file-plus-outline"></i></span>
        			<span>Add</span>
        		</a>
        		<div class="clearfix"></div>
        	</div>
        </div>
		<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                	<h4 class="card-title">Homepage Slider</h4>
                	<div class="table-responsive">
	                    <table class="table">
	                    		<thead>
	                    				<tr>
	                    						<th style="width:5%;"></th>
	                    						<th style="width:80%;">Slide</th>
	                    						<th style="width:15%;"></th>
	                    				</tr>
	                    		</thead>
	                    		<tbody>
	                    		<?php 
	                    				if( is_array($slider) && count($slider) > 0 ) {
	                    						foreach( $slider as $slide ) {
	                    		?>
	                    				<tr>
	                    						<td><?php print $slide['id'];?></td>
	                    						<td><img src="<?php print getImageThumg('slider',$slide['name'], 100);?>" class="img-lg rounded" alt="" /></td>
	                    						<td class="text-end">
	                    								<a href="<?php print base_url().'/admincp/sliders/homepage/edit/'.$slide['id'].'?m='.$slide['name'];?>" class="badge badge-success text-decoration-none">Edit</a>
	                    								<a href="<?php print base_url().'/admincp/sliders/homepage/delete/'.$slide['id'].'?m='.$slide['name'];?>" onclick="return confirm('Are you sure to delete this?');" class="badge badge-danger text-decoration-none">Delete</a>
	                    						</td>
	                    				</tr>
	                    		<?php
	                    						}
	                    				}
	                    		?>
	                    		</tbody>
	                    </table>
	                </div>
                </div>
            </div>
        </div>
	</div>

<?php print view('admin/footer');?>