<?php if ((is_array($compaign) && count($compaign) > 0) || (is_array($compaign_upcoming) && count($compaign_upcoming) > 0)) { ?>
    <section class="category-section pb-60 pt-5">
        <div class="container">
            <div
                class="tabs-nav product-top-content heading-space mb-25 d-flex justify-content-center">
                <ul class="project-filter text-center">
                    <li
                        class="active">
                        <a class="px-5 py-3 btn btn-lg " href="#liveTab"> LIVE</a>
                    </li>
                    <li
                        class="">
                        <a class="px-5 py-3 btn btn-lg" href="#upcomingTab"> UPCOMING</a>
                    </li>
                </ul>
            </div>
            <div class="text-center whyHeading">
                <h2 class="text-muted">Why Shop & Pay When You Can Spin & Win?</h2>
                <p>Have fun, win big! Select any store below and start winning!</p>
                <?php if(!isset($see_all_btn)) { ?>
                    <a href="<?= route_to('compaigns.all') ?>" class=" btn-link zappta-red-color">See All</a>
                <?php } ?>
            </div>
            <section class="tabs-content mt-5">
                <div id="liveTab">
                    <?php if ((is_array($compaign) && count($compaign) > 0) ) {?>
                        <div class="category-carousel swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($compaign as $comp) { ?>
                                    <div class="swiper-slide">
                                        <div class="category-item">
                                            <div class="row">
                                                <div class="col-6">
                                                    <img src="<?= $comp['store_logo'] ?>" class="img img-thumbnail bg-transparent py-3" style="width: 250px; height: 100px;">
                                                </div>
                                                <div class="col-6">
                                                    <h3 class="title"><a href="#"><?php print short($comp['store_name'], 20); ?></a></h3>
                                                    <button
                                                        class="btn btn-danger zappta-red-bg btn-lg px-4 mb-3">
                                                        $<?php print $comp['price']; ?>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="category-img">
                                                <img src="<?= $comp['cover']; ?>" alt="" style="width: 267px; height: 139px;">
                                            </div>
                                            <h3 class="title"><a href="#">Game Ends in</a></h3>
                                            <div class="periodic_timer_minutes_1">
                                                <div class="jumbotron countdown show" data-Date='<?php print date('Y/m/d 23:59:59', strtotime($comp['compain_e_date'])); ?>'>
                                                    <div class="running" style="display: flex; justify-content:center">
                                                        <timer class="align-items-center d-flex smallBoxes justify-content-around mt-1 ">
                                                            <div class="px-3 py-1 bg-secondary-subtle rounded timerspan">
                                                                <span class="days"></span>
                                                                <p>Days</p>
                                                            </div>

                                                            <div class="px-3 py-1 bg-secondary-subtle rounded timerspan">
                                                                <span class="hours"></span>
                                                                <p>Hrs</p>
                                                            </div>

                                                            <div class="px-3 py-1 bg-secondary-subtle rounded timerspan">
                                                                <span class="minutes"></span>
                                                                <p>Mins</p>
                                                            </div>

                                                            <div class="px-3 py-1 bg-secondary-subtle rounded timerspan">
                                                                <span class="seconds"></span>
                                                                <p>Secs</p>
                                                            </div>
                                                            
                                                        </timer>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-info w-100 text-white mt-4 py-3 upcoming_select_store" data-href="<?=base_url()?>stores/<?=$comp['store_slug']?>" data-comp="<?=my_encrypt($comp['com_id'])?>" <?=getUserId() == 0?'onclick="showLogin(\'login\');"':''?> data-url="<?=base_url()?>compaign/verify/<?=my_encrypt($comp['id'])?>" data-id="<?=my_encrypt($comp['vendor_id'])?>" data-button="play">
                                                PLAY NOW
                                            </button>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    <?php }else{
                        echo '<div class="text-center bg-grey py-2">
                                    No Live compaigns found!
                                </div>';
                    } ?>
                </div>
                <div id="upcomingTab">
                    <?php if ((is_array($compaign_upcoming) && count($compaign_upcoming) > 0) ) { ?>
                            <div class="row">
                                <?php foreach ($compaign_upcoming as $comp) { ?>
                                    <div class="col-sm-3">
                                        <div class="category-item">
                                            <div class="topCatgPanel">
                                                <div class="col">
                                                    <img src="<?= $comp['store_logo'] ?>" class="img img-thumbnail bg-transparent py-3" style="width: 250px; height: 100px;">
                                                </div>
                                                <div class="col last">
                                                    <h3 class="title"><a href="#">Spin to win</a></h3>
                                                    <button
                                                        class="btn btn-danger zappta-red-bg btn-lg px-4 mb-3">
                                                        $<?php print $comp['price']; ?>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="category-img">
                                                <img src="<?= $comp['cover']; ?>" alt="" style="width: 267px; height: 139px;">
                                            </div>
                                            <h3 class="title"><a href="#">Game Starts in</a></h3>
                                            <div class="periodic_timer_minutes_1">
                                                <div class="jumbotron countdown show" data-Date='<?php print date('Y/m/d 23:59:59', strtotime($comp['compain_s_date'])); ?>'>
                                                    <div class="running" style="display: flex; justify-content:center">
                                                        <timer class="align-items-center d-flex smallBoxes justify-content-around mt-1 ">
                                                            <div class="px-3 py-1 bg-secondary-subtle rounded timerspan">
                                                                <span class="days"></span>
                                                                <p>Days</p>
                                                            </div>

                                                            <div class="px-3 py-1 bg-secondary-subtle rounded timerspan">
                                                                <span class="hours"></span>
                                                                <p>Hrs</p>
                                                            </div>

                                                            <div class="px-3 py-1 bg-secondary-subtle rounded timerspan">
                                                                <span class="minutes"></span>
                                                                <p>Mins</p>
                                                            </div>

                                                            <div class="px-3 py-1 bg-secondary-subtle rounded timerspan">
                                                                <span class="seconds"></span>
                                                                <p>Secs</p>
                                                            </div>
                                                            
                                                        </timer>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-100">
                                                <a type="button" data-url="<?=base_url('stores/'.$comp['store_slug'])?>" data-id="<?=my_encrypt($comp['vendor_id'])?>" data-comp="<?=my_encrypt($comp['com_id'])?>" <?=getUserId() == 0?'onclick="showLogin(\'login\');"':''?> class="btn btn-info w-100 text-white mt-4 py-3 upcoming_select_store" style="font-size: 16px;">SELECT ITEMS</a>
                                            </div>
                                            <div class="w-100">
                                                <a class="btn btn-zCoin w-100 mt-3" href="#"><img src="<?=$assets_url?>/images/zIcon.svg" alt=""> 15 Per Minute</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        <?php }else{ ?>
                            <div class="text-center bg-grey py-2">
                                No Upcoming compaigns found!
                            </div>
                    <?php } ?>
                </div>
            </section>

        </div>
    </section>
<?php } ?>