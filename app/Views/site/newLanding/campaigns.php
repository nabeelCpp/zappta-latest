<!-- why Shop -->
<?php if ((is_array($compaign) && count($compaign) > 0) || (is_array($compaign_upcoming) && count($compaign_upcoming) > 0)) { ?>
    <section class="category-section pb-60 pt-60" id="compaign_section">
        <div class="container">
            <div
                class="product-top-content heading-space mb-25 d-flex justify-content-center">
                <ul class="project-filter text-center">
                    <li
                        class="btn btn-info text-white btn-lg px-5 py-3"
                        data-filter=".live">
                        LIVE
                    </li>
                    <li
                        class="btn btn-outline-secondary btn-lg px-5 py-3"
                        data-filter=".cake ">
                        UPCOMING
                    </li>
                </ul>
            </div>
            <div class="text-center whyHeading">
                <h2 class="text-muted">Why Shop & Pay When You Can Spin & Win?</h2>
                <p>Have fun, win big! Select any store below and start winning!</p>
                <a href="#" class=" btn-link zappta-red-color">See All</a>
            </div>

            <div class="category-carousel swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($compaign as $comp) { ?>
                        <div class="swiper-slide">
                            <div class="category-item">
                                <div class="row">
                                    <div class="col-6">
                                        <?php
                                        if (! empty($comp['store_logo'])) {
                                            $ext_name = explode('.', $comp['store_logo']);
                                        ?>
                                            <img
                                                src="<?php print base_url() . '/images/media/' . $ext_name[0] . '/' . $ext_name[1] . '/250'; ?>"
                                                class="img img-thumbnail bg-transparent py-3" style="width: 250px; height: 100px;">
                                        <?php } else { ?>
                                            <img
                                                src="<?php print base_url() . '/images/media/img-not-found/jpg/100'; ?>"
                                                class="img img-thumbnail bg-transparent py-3" style="width: 250px; height: 100px;"
                                                alt="">
                                        <?php } ?>
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
                                    <?php
                                    if (! empty($comp['cover'])) {
                                        $ext_cover = explode('.', $comp['cover']);
                                    ?>
                                        <img src="<?php print base_url() . '/upload/media/spree/' . $comp['cover']; ?>" alt="" style="width: 267px; height: 139px;">
                                    <?php } else { ?>
                                        <img src="<?php print base_url() . '/images/media/img-not-found/jpg/100'; ?>" alt="" style="width: 267px; height: 139px;">
                                    <?php } ?>
                                </div>
                                <h3 class="title"><a href="#">Game Ends is</a></h3>
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
                                <button class="btn btn-info w-100 text-white mt-4 py-3 upcoming_select_store" data-href="<?=base_url()?>/stores/<?=$comp['store_slug']?>" data-comp="<?=my_encrypt($comp['com_id'])?>" <?=getUserId() == 0?'onclick="showLogin(\'login\');"':''?> data-url="<?=base_url()?>/compaign/verify/<?=my_encrypt($comp['id'])?>" data-id="<?=my_encrypt($comp['vendor_id'])?>" data-button="play">
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
        </div>
    </section>
<?php } ?>