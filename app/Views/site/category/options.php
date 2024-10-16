<?php if (is_array($getCatAttr) && count($getCatAttr) > 0) { ?>
    <?php foreach ($getCatAttr as $key => $attr) { ?>
        <?php if (is_array($attr['values']) && count($attr['values']) > 0 && !in_array($attr['attr_name'], $exclude_attr)) { ?>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle mb-3" data-bs-toggle="collapse" href="#seasonCollapse3__<?=$key?>" aria-expanded="true">
                    <?php print $attr['attr_name']; ?>
                </a>
                <div class="collapse show" id="seasonCollapse3__<?=$key?>" data-simplebar-collapse="#seasonGroup3__<?=$key?>">
                    <div class="form-group form-group-overflow mb-6" id="seasonGroup3__<?=$key?>" data-simplebar="init">
                        <?php foreach ($attr['values'] as $vv) { 
                            switch ($vv['value_opt']) {
                                case 1:
                                    $filter_url = '&size';
                                    $filter_ids = isset($_GET['size']) ? $_GET['size'] : 0;
                                    $filter_active = explode('|', $filter_ids); ?>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input makePageUrl" id="seasonOne3__<?=$key?>" type="checkbox" data-href="<?=( !empty($filter_ids) || $filter_ids > 0 ) ? (in_array( my_encrypt($vv['id']), $filter_active ) ? base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$filter_url.'='.$filter_ids.$color_link.$dimension_link.$paper_type_link.$pf : base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$filter_url.'='.$filter_ids.'|'.my_encrypt($vv['id']).$color_link.$dimension_link.$paper_type_link.$pf) : base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$filter_url.'='.my_encrypt($vv['id']).$color_link.$dimension_link.$paper_type_link.$pf ?>" <?=( !empty($filter_ids) || $filter_ids > 0 ) && (in_array( my_encrypt($vv['id']), $filter_active )) ? 'checked':''?> data-id="<?=my_encrypt($vv['id'])?>">
                                        <label class="form-check-label w-100 position-relative" for="seasonOne3__<?=$key?>">
                                            <?=$vv['name_en']?> <span class="counter"></span>
                                        </label>
                                    </div><?php
                                    break;
                                case 3:
                                    $filter_url = '&dimension';
                                    $filter_ids = isset($_GET['dimension']) ? $_GET['dimension'] : 0;
                                    $filter_active = explode('|',$filter_ids); ?>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input makePageUrl" id="seasonOne3__<?=$key?>" type="checkbox" data-href="<?=( !empty($filter_ids) || $filter_ids > 0 ) ? (in_array( my_encrypt($vv['id']), $filter_active ) ? base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$filter_url.'='.$filter_ids.$paper_type_link.$pf : base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$filter_url.'='.$filter_ids.'|'.my_encrypt($vv['id']).$paper_type_link.$pf) : base_url().'/categories/'.$category_id['cat_url'].'/?b='.$brand_get.$size_link.$color_link.$filter_url.'='.my_encrypt($vv['id']).$paper_type_link.$pf ?>" <?=( !empty($filter_ids) || $filter_ids > 0 ) && (in_array( my_encrypt($vv['id']), $filter_active )) ? 'checked':''?> data-id="<?=my_encrypt($vv['id'])?>">
                                        <label class="form-check-label w-100 position-relative" for="seasonOne3__<?=$key?>">
                                            <?=$vv['name_en']?> <span class="counter"></span>
                                        </label>
                                    </div><?php
                                    break;
                                default:
                                    break;
                            }
                        } ?>
                    </div>
                </div>
            </li>
        <?php } ?>
    <?php } ?>
<?php } ?>

<script>
    $('.makePageUrl').on('change', function() {
        let url = $(this).data('href');
        let id = $(this).data('id');
        if(!$(this).is(':checked')) {
            url = url.replace(id, '');
            url = url.replace('||', '|');
            let params = new URLSearchParams(new URL(url).search);
            params.forEach((value, key) => {
                value = value.replace(/^\|+|\|+$/g, '');
                params.set(key, value);
            });
            let baseUrl = url.split('?')[0];
            url = `${baseUrl}?${params.toString()}`
        }
        location.href = url;
    });

</script>