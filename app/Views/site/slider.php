<?php if ( is_array($homeslider) && count($homeslider) > 0 ) { ?>
		<section class="slider-banner">
			<div class="slider-content homepagesliderbanner">
			<?php foreach( $homeslider as $hslide ) { ?>
				<?php 
    				if( ! empty( $hslide['name'] ) ) { 
    					$ext_name = explode('.',$hslide['name']);
    			?>
    				<img src="<?php print base_url().'images/slider/'.$ext_name[0].'/'.$ext_name[1].'/1980';?>" class="animate" alt="Home Page Slider">
    			<?php } else { ?>
    				<img src="<?php print base_url().'images/media/img-not-found/jpg/100';?>" class="animate" alt="Home Page Slider">
    			<?php }?>
			<?php } ?>
			</div>
		</section>
<?php }?>