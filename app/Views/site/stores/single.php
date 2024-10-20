<?= view('site/newLanding/header', ['globalSettings' => $globalSettings]); ?>
<style>
    figure.zoom {
        background-position: 50% 50%;
        position: relative;
        width: 500px;
        overflow: hidden;
        cursor: zoom-in;
        background-repeat: no-repeat;
        background-size: 200%;
    }

    figure.zoom img {
        transition: opacity 0.5s;
        display: block;
        width: 100%;
    }

    figure.zoom img:hover {
        opacity: 0;
    }
</style>
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>/theme/zoomer/style.css" />
<link rel="stylesheet" href="<?= $assets_url ?>/css/lightslider.css" />
<script>
    currentUrl = "<?php print base_url() . '/stores/' . $single['store_slug']; ?>";
</script>
<!-- section dividie Layout// -->
<section class="py-3">
    <div class="container">
        <div class="w-100 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php print base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php print base_url() . '/stores/' . $single['store_slug']; ?>">Stores</a></li>
                    <li class="breadcrumb-item"><a href="<?php print base_url() . '/stores/' . $single['store_slug']; ?>"><?php print $single['store_name']; ?></a></li>
                </ol>
            </nav>
        </div>
        <div class="row no-gutters mt-5">
            <div class="col-md-7 pr-2">
                <?php if (is_array($single['gallery']) && count($single['gallery']) > 0) { ?>
                    <div class="sliderThumbnail">
                        <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                            <?php foreach ($single['gallery'] as $gal) { ?>
                                <li data-thumb="<?= getImageThumg($image_path, $gal['fimg'], 100) ?>">
                                    <figure class="zoom" onmousemove="zoom(event)" style="background-image: url('<?= getImageThumg($image_path, $gal['fimg'], 1280) ?>')">
                                        <img src="<?= getImageThumg($image_path, $gal['fimg'], 1280) ?>">
                                    </figure>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-5">
                <div class="singleProductDescription">
                    <h2><?= ucfirst($single['name']) ?></h2>
                    <p class="visitStore"><a href="<?php print base_url() . '/stores/' . $single['store_slug']; ?>" class="visit">Visit the Store</a></p>
                    <div class="p-ratings">
                        <?php
                        if (isset($overal_ratings->average_ratings) && $overal_ratings->average_ratings) {
                            $overal_ratings->average_ratings = round($overal_ratings->average_ratings);
                        }
                        for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fa fa-star <?= isset($overal_ratings->average_ratings) && $overal_ratings->average_ratings && $i <= $overal_ratings->average_ratings ? '' : 'fa-regular' ?>"></i>
                        <?php } ?>
                        <span><?= $overal_ratings->total_reviews ?? 0 ?> reviews</span>

                    </div>
                    <?php 
                    $item_price = 0;
                    if ($single['outofstockorder'] == 2) { ?>
                        <h3>In Stock</h3>
                        <div id="spreeOptBtn" class="m-2 add_To_Spree" data-id="<?= $single['product_id'] ?>"></div>
                    <?php } elseif ($single['outofstockorder'] == 1 && $single['quantity'] > 0) { ?>
                        <h3>In Stock</h3>
                        <div id="spreeOptBtn" class="m-2 add_To_Spree" data-id="<?= $single['product_id'] ?>"></div>
                    <?php } else { ?>
                        <h3 class="text-danger">Out of Stock</h3>
                    <?php } ?>
                    <div class="pricePrd">
                        <?php
                        if ($single['deal_enable'] > 0) { 
                            $item_price = $single['deal_final_price']; ?>
                            <h4 id="singleprice">$<?= number_format($single['deal_final_price'], 2) ?> <span class="priceCutOff"><del>$<?php print number_format($single['final_price'], 2) ?></del></span></h4>
                        <?php } else { 
                            $item_price = $single['final_price'];?>
                            <h4 id="singleprice">$<?= number_format($single['final_price'], 2) ?></h4>
                        <?php } ?>
                    </div>
                    <?= isset($store['earn_zappta']) ? '<p class="earnTag">Earn <img src="' . $assets_url . '/images/zIcon.svg" alt=""> ' . $store['earn_zappta'] . ' per $' . $store['per_dollar'] . ' spent</p>' : '' ?>
                    <?php
                    $givewaytags = isset($_GET['give']) ? $_GET['give'] : 0;
                    if ($givewaytags == 1) {
                    ?>
                        <div class="givewaytags position-absolute">
                            <p>Giveaway Active</p>
                        </div>
                    <?php
                    }
                    if (is_array($single['attributes']) && count($single['attributes']) > 1) {
                        $attr = 1;
                        foreach ($single['attributes'] as $attributes => $attrkeys) {
                            if (is_array($attrkeys) && count($attrkeys) > 0) {
                                switch ($attrkeys['attr_option']) {
                                    case 2: ?>
                                        <div class="colorSelection">
                                            <h5><?=$attrkeys['attribute_name'] ?> </h5>
                                            <span class="nametext_<?=my_encrypt($attrkeys['attr_id'])?>"></span>
                                            <div class="my-color">
                                                <label class="radio">
                                                    <input type="radio" name="colours" value="red" checked>
                                                    <span class="red"></span>
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="colours"
                                                        value="blue"> <span class="blue"></span>
                                                </label>
                                                <label class="radio">
                                                    <input type="radio"
                                                        name="colours" value="green"> <span class="green"></span>

                                                </label>
                                                <label class="radio">
                                                    <input
                                                        type="radio" name="colours" value="orange"> <span class="orange"></span>
                                                </label>
                                            </div>
                                        </div> <?php
                                        break;
                                    default: ?>
                                        <div class="selectionSize">
                                            <h4><?=$attrkeys['attribute_name'] ?></h4>
                                            <span class="nametext_<?=my_encrypt($attrkeys['attr_id'])?>"></span>

                                            <div class="d-flex">
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">XS</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">S</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">M</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">L</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">XL</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">2XL</span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div><?php
                                        break;
                                }
                            }
                            $attr++;
                        }
                    }else {
                        if (is_array($single['attributes']) && count($single['attributes']) == 1) {
                            $attrkeys = $single['attributes'][0];
                            if (is_array($attrkeys) && count($attrkeys) > 0) {
                                switch ($attrkeys['attr_option']) {
                                    case 2: ?>
                                        <div class="colorSelection">
                                            <h5><?=$attrkeys['attribute_name'] ?> </h5>
                                            <span class="nametext_<?=my_encrypt($attrkeys['attr_id'])?>"></span>
                                            <div class="my-color">
                                                <label class="radio">
                                                    <input type="radio" name="colours" value="red" checked>
                                                    <span class="red"></span>
                                                </label>
                                                <label class="radio">
                                                    <input type="radio" name="colours"
                                                        value="blue"> <span class="blue"></span>
                                                </label>
                                                <label class="radio">
                                                    <input type="radio"
                                                        name="colours" value="green"> <span class="green"></span>

                                                </label>
                                                <label class="radio">
                                                    <input
                                                        type="radio" name="colours" value="orange"> <span class="orange"></span>
                                                </label>
                                            </div>
                                        </div> <?php
                                        break;
                                    default: ?>
                                        <div class="selectionSize">
                                            <h4><?=$attrkeys['attribute_name'] ?></h4>
                                            <span class="nametext_<?=my_encrypt($attrkeys['attr_id'])?>"></span>

                                            <div class="d-flex">
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">XS</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">S</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">M</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">L</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">XL</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="">
                                                        <span class="red">2XL</span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div><?php
                                        break;
                                }
                            }
                        }
                    }
                    ?>



                    <div class="productSelectionFinal">
                        <button class="btn heartSelection">
                            whishlist
                        </button>
                        <?php
                        $givewaytags = isset($_GET['give']) ? $_GET['give'] : 0;
                        if ($givewaytags == 1) {
                        ?>
                            <button type="button " class="btn btn-cart animate mb-3 w-100" id="addtocard" data-id="<?php print my_encrypt($single['product_id']); ?>">Proceed to Game</button>
                        <?php } else { ?>
                            <a type="button " class="cartBtn" id="addtocard"><img src="<?= $assets_url ?>/images/shoppingcart.svg" alt="" />Add to cart</a>
                        <?php } ?>
                        <a type="button " class="buyNowBtn" id="buynow">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- tabs section/ -->
<section class="tabsDescription">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-3">
                <nav id="myTab" class="nav nav-pills flex-column">
                    <a href="#category_tab1" data-bs-toggle="pill" class="active nav-link">Description</a>
                    <a href="#category_tab4" data-bs-toggle="pill" class="nav-link">Reviews</a>
                    <a href="#category_tab2" data-bs-toggle="pill" class="nav-link">Additional Details</a>
                    <a href="#category_tab3" data-bs-toggle="pill" class="nav-link">Shipping & Returns</a>

                </nav>
            </div>
            <div class="col-md-9 tab-content">
                <article class="tab-pane fade show active" id="category_tab1">
                    <h6>Description</h6>
                    <p><?= html_entity_decode($single['description']) ?></p>
                </article>
                <article class="tab-pane fade" id="category_tab2">
                    <h6>Additional Details</h6>
                    Content can be edited
                    Ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </article>
                <article class="tab-pane fade" id="category_tab3">
                    <h6>Shipping & Returns</h6>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                </article>
                <article class="tab-pane fade" id="category_tab4">
                    <h6>Reviews</h6>
                    <div class="row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <?php if (isset($reviews) && count($reviews)) { ?>
                                <?php foreach ($reviews as $key => $r) { ?>
                                    <div class="card p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="user d-flex flex-row align-items-center">
                                                <span><small class="font-weight-bold text-primary"><?php //print ucfirst($r->fname)
                                                                                                    ?></small></span>
                                            </div>
                                            <small><?php print timeago($r->created_at); ?></small>
                                        </div>
                                        <div class="justify-content-between align-items-center">
                                            <p><?= $r->comments ?></p>
                                        </div>
                                        <div class="action d-flex justify-content-between mt-2 align-items-center">
                                            <div class="icons align-items-center">
                                                <div class="rating d-flex">
                                                    <p class="me-4">
                                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <i class="fa fa-star <?= $i <= $r->rates ? 'text-warning' : '' ?>"></i>
                                                        <?php } ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else {
                                echo "No reviews found";
                            } ?>
                        </div>
                    </div>
                </article>

            </div>
        </div> <!-- row.// -->
    </div>
</section>

<section class="w-100 py-5">
    <div class="container mt-4">
        <div class="row">
            <?= view('site/stores/prolist', ['count' => $related_products]) ?>
        </div>
        <!-- <div class="col-12 col-sm-12 justify-content-center d-flex align-items-center">
            <a href="#" class="viewMoreBtn">View More</a>
        </div> -->
    </div>
</section>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>
<script src="<?= $assets_url ?>/js/lightslider.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#buynow').on('click', function(e) {
            e.preventDefault();
            $('#addtocard').click();
            $(document).ajaxStop(function() {
                window.location.href = '<?= base_url() ?>/cart';
            })
        });
        $('#addtocard').click(function(e) {
            e.preventDefault();
            let dataid = $(this).data('id');
            $(document).ajaxStop(function() {
                if (dataid !== undefined && dataid) {
                    window.location.href = baseUrl + 'compaign/verify/' + dataid;
                }
            })
        })
    });

    function zoom(e) {
        var zoomer = e.currentTarget;
        var offsetX = e.offsetX ? e.offsetX : e.touches[0].pageX;
        var offsetY = e.offsetY ? e.offsetY : e.touches[0].pageY;
        var x = (offsetX / zoomer.offsetWidth) * 100;
        var y = (offsetY / zoomer.offsetHeight) * 100;
        zoomer.style.backgroundPosition = x + '% ' + y + '%';
    }
</script>