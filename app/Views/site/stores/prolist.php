<?php if (is_array($count) && count($count) > 0) {
    $col = $col ?? null;
    switch($col) {
        case 4:
            $class = 'col-12 col-md-6 col-lg-3';
            break;
        default:
            $class = 'col-12 col-md-6 col-lg-4';
            break;
    }
    foreach ($count as $sr => $p) {
        if (!empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])  &&  !isset($filter['page'])) {
            $value_price = explode(',', $p['value_price']);
            $pr_rr = [];
            if (!empty($value_price) && is_array($value_price) && count($value_price) > 0) {
                foreach ($value_price as $pp) {
                    $valprice = explode('_', $pp);
                    $pr_rr[] = end($valprice);
                }
            }
            $increments_amount = !empty($filter) ? array_sum($pr_rr) : 0;
            $product_id_value_price = !empty($filter) ? $p['value_price'] : 0;
            $attr_url = '';
        } else {
            $attr_url = '';
            $increments_amount = 0;
            $product_id_value_price = 0;
        }
        if ($p['deal_enable'] > 0) {
            $dataprice = ($p['deal_final_price'] + $increments_amount);
        } else {
            $dataprice = ($p['final_price'] + $increments_amount);
        }
        
        $inc_price = ($p['deal_final_price'] + $increments_amount); ?>
        <div class="<?=$class?> mb-3">
            <div class="productPostWraps">
                <div class="productPostThumbnail p-4">
                    <?=$p['deal_enable'] > 0 ? '<span class="priceOff">'.number_format(calculatePercentage( $p['final_price']  + $increments_amount, $inc_price ), 0).'% off</span>' : '' ?>
                    <a href="<?= base_url() . 'products/' . $p['purl'] . '/p/' . $p['pc'] . '/' . '?sd_row=' . $p['sd_row'] . '&pds=' . $p['pds'] . $attr_url ?>">
                        <img src="<?= $p['pcover'] ?>" alt="" />
                    </a>
                    <button class="btn heartSelection <?=$p['is_wishlist']?'active':''?>" onclick="<?= !$p['is_wishlist'] ? 'add_item_wish(\''.my_encrypt($p['pid']).'\',\''.my_encrypt($p['pds']).'\',this,'.$sr.');':'remove_item_wish(this, \''.my_encrypt($p['wishlist_id']).'\');'?>" data-pid="<?= my_encrypt($p['pid']) ?>" data-pds="<?= my_encrypt($p['pds']) ?>" data-key="<?= $sr ?>">
                        whishlist
                    </button>
                </div>
                <a class="productPostInfo" href="<?= base_url() . 'products/' . $p['purl'] . '/p/' . $p['pc'] . '/' . '?sd_row=' . $p['sd_row'] . '&pds=' . $p['pds'] . $attr_url ?>">
                    <?php if ($p['deal_enable'] > 0) { ?>
                        <h3 class="productPriceTag">$<?=number_format($inc_price, 2)?></h3>
                        <p class="text-decoration-line-through">$<?=number_format( ( $p['final_price']  + $increments_amount ) ,2)?></p>
                    <?php }else { ?>
                        <h3 class="productPriceTag">$<?=number_format( ( $p['final_price']  + $increments_amount ) ,2)?></h3>
                    <?php } ?>
                    <p><?=short($p['pname'],35)?></p>
                    <?php if(isset($store) && $store['earn_zappta']) { ?>
                        <p class="earnTag">Earn <img src="<?=$assets_url?>/images/zIcon.svg" alt="" /> <?=$store['earn_zappta']?> per $<?=$store['per_dollar']?> spent</p>
                    <?php } ?>
                </a>
                <div class="add_To_Spree" data-id="<?=$p['pid']?>"></div>
            </div>
        </div>
        <?php }
        if(isset($view_more) && $view_more) { ?>
            <div class="col-12 col-sm-12 justify-content-center d-flex align-items-center" id="viewMore">
                <a type="button" class="viewMoreBtn" onclick="viewMoreProducts(<?=$product_category?>, <?=$id?>, <?=$offset?>)">View More</a>
            </div>
        <?php } 
} else { ?>
    <div class="text-center py-5 border border-2 border-danger-subtle"><b>No products found!</b></div>
<?php } ?>