<section class="trendingSection pb-100 my-5">
    <div class="container">
        <div class="section-heading text-center py-5">
            <h2 class="section-title mb-0">Discover Trending Categories</h2>
            <p>Earn free Zapptas per minute you browse</p>
            <!-- <a href="#" class="btn btn-link zappta-red-color">See All</a> -->
        </div>

        <!-- <div class="trending-carousel swiper" id="homeCategorySlider"> -->
        <div class="trending-carousel swiper">
            <div class="swiper-wrapper">
                <?php if (is_array($categories) && count($categories) > 0) {
                    foreach ($categories as $homecat) { ?>
                        <div class="swiper-slide" onclick="location.href='<?php print base_url() . 'categories/' . $homecat['cat_url']; ?>'">
                            <div class="category-item">
                                <div class="category-img">
                                    <img  src="<?=$homecat['cat_icon'] ?>"  class="img img-responsive" style="height: 132px;" alt="">
                                </div>
                            </div>
                            <h3 class="title mt-3">
                                <a href="<?php print base_url() . 'categories/' . $homecat['cat_url']; ?>"><?php print $homecat['cat_name'];?></a>
                            </h3>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="swiper-scrollbar"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>