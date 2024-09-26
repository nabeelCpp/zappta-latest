<?php print view('vendors/header');?>
	
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
							<li>Catalog</li>
							<li>/</li>
							<li>Attributes</li>
							<li>/</li>
							<li><?php //print $attrtitle;?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="vendor-dashbaord">
		<div class="container">
			<div class="wrapper d-flex align-items-stretch">
		
				<?php print view('vendors/sidebar');?>

				<div id="content" class="float-start">
						
						<div class="container-fluid">

						   	<div class="row">
						      	<div class="col-md-12">
						      		<div class="attributes-links mt-4 mb-4">
						      			<div class="d-flexs">
							      			<a href="<?php print base_url().'/vendors/attributes/valueadd/'.$id.'/?t='.$_GET['t'];?>" class="addbtn float-end">
							      				<span><i class="fa-solid fa-plus"></i></span>
							      				<span>Add Value</span>
							      			</a>
							      			<div class="clearfix"></div>
							      		</div>
						      		</div>
					      			<?php print show_message();?>

					      			<div class="table-responsive product-list">
					      				<table class="table table-striped table-hover" id="attributes-value-data">
					      					<thead>
					      						<tr>
					      							<th><input type="checkbox" name="value-ids[]" /></th>
					      							<th>Name</th>
					      							<th>Values</th>
					      							<th>&nbsp;</th>
					      						</tr>
					      					</thead>
					      					<tbody></tbody>
					      				</table>
					      			</div>
					      			
						      	</div>
						   	</div>
						</div>


				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</section>

<?php print view('vendors/footer');?>