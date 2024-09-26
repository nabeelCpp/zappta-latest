<?php print view('admin/header');?>

    <div class="row">
      <div class="col"><?php print show_message();?></div>
    </div>

	<div class="row">
		<?php 
			if( is_array($sql) && count($sql) > 0 ) {
				foreach( $sql as $q ) {
		?>
			<div class="col-xl-3">
				<div class="card card-small mb-4">
					<div class="card-body p-2">
						<div class="del mb-2">
							<a href="<?php print base_url().'/admincp/media/delete?id='.$q['product_id'].'&fimg='.$q['fimg'];?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-sm btn-danger">Delete</a>
						</div>
						<div class="p-0">
						<?php 
		    				if( ! empty( $q['fimg'] ) ) { 
		    					$ext_name = explode('.',$q['fimg']);
		    			?>
		    				<img src="<?php print base_url().'/images/product/'.$ext_name[0].'/'.$ext_name[1].'/250';?>" class="border rounded" alt="" style="width: 100%;height: 200px;object-fit: contain;">
		    			<?php } else { ?>
		    				<img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" class="border rounded" alt="" style="width: 100%;height: 200px;object-fit: contain;">
		    			<?php }?>
		    			</div>
					</div>
				</div>
			</div>
		<?php
				}
			}
		?>
	</div>
	<div class="row">
        <?php if ( $total_result > 20 ) { ?>
          <div class="pagenation">
            <?php print $pager->makeLinks($page, 20, $total_result,'front_full') ?>
          </div>
        <?php } ?>
	</div>
<?php print view('admin/footer');?>