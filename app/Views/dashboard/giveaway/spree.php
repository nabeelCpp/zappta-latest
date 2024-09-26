<?php print view('site/header');?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
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
							<li>
								<a href="<?php print base_url().'/dashboard';?>"><?php print $pagetitle;?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="dashboard">
		<div class="container">

			<div class=" d-flex">
				<?php print view('dashboard/sidebar');?>
				<!-- Page content holder -->
				<div class="page-content pr-0 p-5 " id="content">
                    <?php if(count($sprees) > 0){ ?>
                        <div class="jumbotron">
                            <?php foreach ($sprees as $compaign => $store) { ?>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6><?=$compaign?></h6>
                                            </div>
                                            <div class="col-4">
                                                <?=date('Y-m-d', strtotime($store['compain_s_date'])) > date('Y-m-d') ?"Game Starts in: ": (date('Y-m-d', strtotime($store['compain_e_date'])) > date('Y-m-d')?"Game Ends in: ":"")?>
                                            <div class="periodic_timer_minutes_<?=str_replace(' ','_', $compaign)?>">
                                                <div class="countdown show d_5" data-date="<?=date('Y-m-d', strtotime($store['compain_s_date'])) > date('Y-m-d') ?date('Y/m/d', strtotime($store['compain_s_date']))." 23:59:59": (date('Y-m-d', strtotime($store['compain_e_date'])) > date('Y-m-d')?date('Y/m/d', strtotime($store['compain_e_date']))." 23:59:59":"")?>">
                                                    <div class="running" style="display: flex;">
                                                        <timer class="align-items-center">
                                                            <span class="timerspan">
                                                                <span class="days">00</span>
                                                                <span class="timerlabel">Days</span>
                                                            </span>	
                                                            <span class="timerdots">:</span>
                                                            <span class="timerspan">
                                                                <span class="hours">00</span>
                                                                <span class="timerlabel">Hrs</span>
                                                            </span>	
                                                            <span class="timerdots">:</span>
                                                            <span class="timerspan">
                                                                <span class="minutes">00</span>
                                                                <span class="timerlabel">Mins</span>
                                                            </span>	
                                                            <span class="timerdots">:</span>
                                                            <span class="timerspan">
                                                                <span class="seconds">00</span>
                                                                <span class="timerlabel">Secs</span>
                                                            </span>	
                                                        </timer>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php foreach ($store['stores'] as $key => $st) { ?>
                                            <div class="panel panel-default">
                                                <!-- Default panel contents -->
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="panel-heading py-3"><?=$key?></h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Product</th>
                                                                    <th>Price</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($st as $key => $value) { ?>
                                                                    <tr>
                                                                        <td><?=$key+1?></td>
                                                                        <td>
                                                                            <?php 
                                                                                if( ! empty( $value['cover'] ) ) { 
                                                                                    $ext_cover = explode('.',$value['cover']);
                                                                            ?>
                                                                                <img src="<?php print base_url().'/images/product/'.$ext_cover[0].'/'.$ext_cover[1].'/250';?>" class="img img-thumbnail" style="height: 50px; width: 50px;" alt="">
                                                                            <?php } else { ?>
                                                                                <img src="<?php print base_url().'/images/media/img-not-found/jpg/100';?>" class="img img-thumbnail" style="height: 50px; width: 50px;" alt="">
                                                                            <?php }?>    
                                                                            <?=$value['name']?></td>
                                                                        <td>$<?=$value['deal_enable'] > 0?number_format($value['deal_final_price'], 2):number_format($value['final_price'], 2)?></td>
                                                                        <td><button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#exampleModal" data-id="<?=my_encrypt($value['id'])?>" data-name="<?=$value['name']?>" onclick="removeSpree(this)">Remove From Spree</button></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="card-footer">
                                                        <?php 
                                                        $checkout_done = false;
                                                        foreach ($coupons as $k_cop => $coup) {
                                                            if($coup->com_id == $value['compain_id'] && $coup->vendor_id == $value['store_id']){ $checkout_done = true; ?>
                                                                <div class="text-center">
                                                                    <form action="<?=base_url('cart/checkCoupon')?>" method="POST">
                                                                         <input type="hidden" name="<?=csrf_token()?>" value="<?=csrf_hash()?>" >
                                                                         <input type="hidden" name="coupon" value="<?=$coup->coupon_code?>">   
                                                                        <button type="submit" class="btn btn-success">Checkout</button>
                                                                    </form>
                                                                </div>
                                                            <?php }
                                                        }
                                                        if(!$checkout_done){ ?>
                                                            <div class="text-center">
                                                                <button class="btn btn-success" disabled>Checkout</button>
                                                                <?php 
                                                                if(date('Y-m-d', strtotime($store['compain_s_date'])) > date('Y-m-d')) { ?>
                                                                    <button class="btn btn-info" style="background: #fb5000" disabled>Play Now</button>
                                                                <?php }else if (date('Y-m-d', strtotime($store['compain_e_date'])) > date('Y-m-d')){ ?>
                                                                    <button class="btn btn-info upcoming_select_store" style="background: #fb5000" data-href="<?=base_url()?>/stores/<?=$value['store_slug']?>" data-comp="<?=my_encrypt($value['compain_id'])?>"  data-url="<?=base_url()?>/compaign/verify/<?=my_encrypt($value['id'])?>" data-id="<?=my_encrypt($value['store_id'])?>" data-button="play">PLAY NOW</button>
                                                                <?php } ?>
                                                                
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php }else{ ?>
                        <div class="text-center">
                            No Sprees found!
                        </div>
                    <?php } ?>
				</div>
				<!-- End demo content -->
			</div>

		</div>
	</section>
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         Are you sure you want to delete <b id="product_spree"></b> product from spree?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-success" id="removeSpreeBtn">Yes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php print view('site/footer');?>
<script>
    function removeSpree(element) {
        let id = $(element).attr('data-id');
        let name = $(element).attr('data-name');
        $('#product_spree').text(name);
        $('#removeSpreeBtn').attr('onclick', 'window.location.href="<?=base_url()?>/dashboard/spree/remove?id='+id+'"');
    }
</script>