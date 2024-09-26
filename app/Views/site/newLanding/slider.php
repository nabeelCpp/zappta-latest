<style>
    .pageWrapper .hero-section.others::before {
        background: none !important;
    }
</style>
<?php if (is_array($homeslider) && count($homeslider) > 0) { ?>
    <div class="sliderMain swiper">
        <div class="swiper-wrapper">
            <?php foreach ($homeslider as $key => $hslide) { ?>
                <section class="hero-section swiper-slide <?= $key ? "others" : ''  ?>">
                    <?php
                    if (! empty($hslide['name'])) {
                        $ext_name = explode('.', $hslide['name']);
                    ?>
                        <img src="<?php print base_url() . '/images/slider/' . $ext_name[0] . '/' . $ext_name[1] . '/1980'; ?>" alt="Home Page Slider">
                    <?php } else { ?>
                        <img src="<?php print base_url() . '/images/media/img-not-found/jpg/100'; ?>" alt="Home Page Slider">
                    <?php } ?>
                    <?php if (!$key) { ?>
                        <div class="waveWrapper">
                            <div class="container">
                                <div class="lessW">
                                    <p>The New Viral Shopping Sensation</p>
                                    <h1>Spin to Win <span> Everything <br /> in your cart-</span> <br /> 100% free</h1>
                                    <div class="lineBg">
                                        <p>your dream home awaits</p>
                                    </div>
                                    <h4>no credit card <br /> needed-ever!</h4>
                                    <a href="#compaign_section" class="playNowBtn">PLAY NOW</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </section>
            <?php } ?>
        </div>
        <div class="swiper-nav-prev"></div>
        <div class="swiper-nav-next"></div>
    </div>
<?php } ?>