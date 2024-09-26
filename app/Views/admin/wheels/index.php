<?php print view('admin/header');?>
		<div class="row">
            <div class="col-md-12 col-xl-12 grid-margin stretch-card">
            	<div class="card">
            		<div class="card-header"><?php print show_message();?></div>
	                <div class="card-body">
		            	<ul class="nav nav-tabs" role="tablist">
		                    <li class="nav-item">
		                      <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home-1" role="tab" aria-controls="home-1" aria-selected="true">First Wheel</a>
		                    </li>
		                    <li class="nav-item">
		                      <a class="nav-link" id="home-tab-1" data-bs-toggle="tab" href="#home-2" role="tab" aria-controls="home-2" aria-selected="false">Second Wheel</a>
		                    </li>
		                    <li class="nav-item">
		                      <a class="nav-link" id="home-tab-2" data-bs-toggle="tab" href="#home-3" role="tab" aria-controls="home-3" aria-selected="false">Third Wheel</a>
		                    </li>
		                    <li class="nav-item">
		                      <a class="nav-link" id="home-tab-3" data-bs-toggle="tab" href="#home-4" role="tab" aria-controls="home-4" aria-selected="false">Fourth Wheel</a>
		                    </li>
		                </ul>
		                <div class="tab-content">
		                	<div class="tab-pane fade show active" id="home-1" role="tabpanel" aria-labelledby="home-tab">
		                		<form method="post" action="<?php print base_url().'/admincp/wheels/update';?>">
            						<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
				                	<input type="hidden" name="id[1]" value="1">
				                <?php 
				                	for ( $i = 1; $i <= 16; $i++ ) {
				                ?>
				                	<div class="row mt-2 mb-2">
				                		<div class="col-5">
				                			<label>Box <?php print $i;?></label>
				                			<input type="text" class="form-control" name="box_first[<?php print $i;?>]" value="<?php print $getWheels[0]['box_'.$i];?>">
				                		</div>
				                		<div class="col-5">
				                			<label>Points <?php print $i;?></label>
				                			<input type="text" class="form-control" name="box_points[<?php print $i;?>]" value="<?php print (new \App\Models\CompainModel())->getWheelsPoints(1)['points_'.$i];?>">
				                		</div>
				                		<div class="col-2">
				                			<div class="form-check mt-3">
					                            <label class="form-check-label">
					                              <input type="radio" class="form-check-input" name="next_first" value="<?php print $i;?>" <?php if( (new \App\Models\CompainModel())->getWheelNextData(1,$i) == true ){?> checked<?php }?>>
					                              Redirect To Next Wheel
					                            <i class="input-helper"></i></label>
					                        </div>
				                		</div>
				                	</div>
				                <?php
				                	}
				                ?>      
				                	<div class="form-group">
				                		<button type="submit" class="btn btn-primary">Update</button>
				                	</div>
			                	</form>
		                    </div>
		                	<div class="tab-pane fade" id="home-2" role="tabpanel" aria-labelledby="home-tab">
		                		<form method="post" action="<?php print base_url().'/admincp/wheels/update';?>">
            						<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
		                      <input type="hidden" name="id[2]" value="2">
			                <?php 
			                	for ( $i = 1; $i <= 16; $i++ ) {
			                ?>
			                	<div class="row mt-2 mb-2">
			                		<div class="col-5">
			                			<label>Box <?php print $i;?></label>
			                			<input type="text" class="form-control" name="box_second[<?php print $i;?>]" value="<?php print $getWheels[1]['box_'.$i];?>">
			                		</div>
			                		<div class="col-5">
			                			<label>Points <?php print $i;?></label>
			                			<input type="text" class="form-control" name="box_points_second[<?php print $i;?>]" value="<?php print (new \App\Models\CompainModel())->getWheelsPoints(2)['points_'.$i];?>">
			                		</div>
			                		<div class="col-2">
			                			<div class="form-check mt-3">
				                            <label class="form-check-label">
				                              <input type="radio" class="form-check-input" name="next_second" value="<?php print $i;?>" <?php if( (new \App\Models\CompainModel())->getWheelNextData(2,$i) == true ){?> checked<?php }?>>
				                              Redirect To Next Wheel
				                            <i class="input-helper"></i></label>
				                        </div>
			                		</div>
			                	</div>
			                <?php
			                	}
			                ?>      
				                	<div class="form-group">
				                		<button type="submit" class="btn btn-primary">Update</button>
				                	</div>
			                	</form>
		                    </div>
		                	<div class="tab-pane fade" id="home-3" role="tabpanel" aria-labelledby="home-tab">
		                		<form method="post" action="<?php print base_url().'/admincp/wheels/update';?>">
            						<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
		                      <input type="hidden" name="id[3]" value="3">
			                <?php 
			                	for ( $i = 1; $i <= 6; $i++ ) {
			                ?>
			                	<div class="row mt-2 mb-2">
			                		<div class="col-5">
			                			<label>Box <?php print $i;?></label>
			                			<input type="text" class="form-control" name="box_third[<?php print $i;?>]" value="<?php print $getWheels[2]['box_'.$i];?>">
			                		</div>
			                		<div class="col-5">
			                			<label>Points <?php print $i;?></label>
			                			<input type="text" class="form-control" name="box_points_third[<?php print $i;?>]" value="<?php print (new \App\Models\CompainModel())->getWheelsPoints(3)['points_'.$i];?>">
			                		</div>
			                		<div class="col-2">
			                			<div class="form-check mt-3">
				                            <label class="form-check-label">
				                              <input type="radio" class="form-check-input" name="next_third" value="<?php print $i;?>" <?php if( (new \App\Models\CompainModel())->getWheelNextData(3,$i) == true ){?> checked<?php }?>>
				                              Redirect To Next Wheel
				                            <i class="input-helper"></i></label>
				                        </div>
			                		</div>
			                	</div>
			                <?php
			                	}
			                ?>      
				                	<div class="form-group">
				                		<button type="submit" class="btn btn-primary">Update</button>
				                	</div>
			                	</form>
		                    </div>
		                	<div class="tab-pane fade" id="home-4" role="tabpanel" aria-labelledby="home-tab">
		                		<form method="post" action="<?php print base_url().'/admincp/wheels/update';?>">
            						<input type="hidden" name="<?php print csrf_token() ?>" value="<?php print csrf_hash() ?>" />
		                      		<input type="hidden" name="id[4]" value="4">
			                <?php 
			                	for ( $i = 1; $i <= 3; $i++ ) {
			                ?>
			                	<div class="row mt-2 mb-2">
			                		<div class="col-7">
			                			<label>Box <?php print $i;?></label>
			                			<input type="text" class="form-control" name="box_fourth[<?php print $i;?>]" value="<?php print $getWheels[3]['box_'.$i];?>">
			                		</div>
			                		<div class="col-5">
			                			<label>Points <?php print $i;?></label>
			                			<input type="text" class="form-control" name="box_points_fourth[<?php print $i;?>]" value="<?php print (new \App\Models\CompainModel())->getWheelsPoints(4)['points_'.$i];?>">
			                		</div>
			                	</div>
			                <?php
			                	}
			                ?>   
				                	<div class="form-group">
				                		<button type="submit" class="btn btn-primary">Update</button>
				                	</div>
			                	</form>
		                    </div>
		                </div>
		            </div>
	            </div>
            </div>
        </div>
<?php print view('admin/footer');?>