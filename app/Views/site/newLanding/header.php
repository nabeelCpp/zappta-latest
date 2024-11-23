<?php
$searchSlider = searchSlider();
$total_list = (new App\Models\WishlistModel)->getUserTotalList();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />

    <!-- Site Title -->
    <title>Welcome to Zappta! | <?= $globalSettings[1]['var_detail'] ?></title>

    <!-- Place favicon.ico in the root directory -->
    <link
        rel="shortcut icon"
        type="image/x-icon"
        href="<?= $assets_url ?>/img/favicon.ico" />

    <!-- CSS here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('minified/css/styles-1.0.34.min.css')?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <?= $css ?? null ?>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var baseUrl = '<?php print base_url(); ?>';
        var currentUrl = window.location.origin + window.location.pathname;
    </script>
    <?php print csrf_meta() ?>
    <meta name="csrf_token_name" content="<?php print csrf_token() ?>">
</head>

<body>
    <div class="loader">
        <div class="loadingio-spinner-wedges-6sp0olydj1g">
            <div class="ldio-ifqtsksmdi">
                <div>
                    <div>
                        <div></div>
                    </div>
                    <div>
                        <div></div>
                    </div>
                    <div>
                        <div></div>
                    </div>
                    <div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pageWrapper">
        <!-- header-area-start -->
        <header class="header">
            <div class="top-bar">
                <div class="container">
                    <div
                        class="top-bar-inner text-center d-block">
                        <div class="top-bar-middle">
                            <span>Winners For Compaign Has been Announced
                                <a href="<?= base_url() . route_to('compaign.winners') ?>" class="btn btn-link text-muted">click here</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-middle">
                <div class="container">
                    <div class="header-middle-inner">

                        <div class="header-logo">
                            <a href="<?php print base_url(); ?>">
                                <img src="<?= base_url() . 'upload/logo/' . $globalSettings[0]['var_detail'] ?>" alt="Logo" style="width: 150px; height: 100px" />
                            </a>
                        </div>
                        <form class="searchSection" method="get" action="<?php print base_url() . 'search'; ?>" id="searchHeaderForm">
                            <input type="hidden" name="secure" value="<?php print csrf_hash(); ?>">
                            <div class="serchdrop">
                                <?php
                                $select_cat_search = isset($_GET['c']) ? my_decrypt(filtreData(urldecode($_GET['c']))) : 0;
                                ?>
                                <select name="c" class="nice-select">
                                    <option value="0">All</option>
                                    <?php getDropDownCategorySelectedArray(getHeaderCategory(), $select_cat_search); ?>
                                </select>
                            </div>
                            <div class="category-form-wrap">
                                <input class="form-control" type="search" name="searchq" id="headerSearchQ" placeholder="Search for products, categories or brands">
                                <input type="submit" class="searchIcon" />
                            </div>
                        </form>

                        <div class="header-middle-right">
                            <div class="mright">
                                <div class="circleBg" <?= getUserId() > 0 ? "onclick=\"location.href='" . base_url() . "dashboard/wishlist'\"" : 'data-bs-toggle="modal" data-bs-target="#accountModal"' ?>>
                                    <img src="<?= $assets_url ?>/img/Link.svg" alt="" />
                                    <?= getUserId() > 0 && $total_list ? '<span class="smCircle">' . $total_list . '</span>' : '' ?>
                                </div>
                                <div class="circleBg" onclick="location.href='<?= base_url() . 'cart' ?>'">
                                    <img src="<?= $assets_url ?>/img/whishlist.svg" alt="" />
                                    <span class="smCircle" id="cartList"> <?= get_total_items() ?? '' ?></span>
                                </div>
                                <div class="zCoin" onclick="<?= getUserId() > 0 ? "location.href='" . base_url() . "dashboard/wallet'" : 'data-bs-toggle="modal" data-bs-target="#accountModal"' ?>">
                                    <img src="<?= $assets_url ?>/img/z-coin.svg" alt="" />
                                    <div class="colVert">
                                        <p>Coins</p>
                                        <h5 id="userTotalZappta"><?= getUserId() > 0 ? number_format(userTotalZappta() - ((new \App\Models\CompainModel())->getZapptaSpent()), 2) : number_format(0, 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                            <ul class="contact-item-list">

                                <?php if (getUserId() == 0) { ?>
                                    <li>
                                        <a type="button" onclick="showLogin('login');" class="login-btn zappta-red-color newLandingAccountModel" data-id="#login-tab">Sign In</a>
                                    </li>
                                    <li>
                                        <a type="button" onclick="showLogin('singin');" class="zappta-shaded-btn newLandingAccountModel" data-id="#signup-tab">Sign Up</a>
                                    </li>
                                <?php } else { 
                                    echo view('site/newLanding/notifications'); ?>
                                    
                                    
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="<?= $assets_url ?>/images/accountIcon.svg" alt="" /><span>My Account</span>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><span>Welcome back!</span></li>
                                            <li><a class="dropdown-item" href="<?php print base_url() . 'dashboard'; ?>"> <img src="<?= $assets_url ?>/images/dashboard.svg" alt="" /> Dashboard</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="<?php print base_url() . 'logout'; ?>"><img src="<?= $assets_url ?>/images/logout.svg" alt="" /> Logout</a></li>
                                        </ul>
                                    </li>

                                <?php } ?>


                            </ul>
                        </div>

                    </div>
                </div>
                <div class="greenBar py-2">
                    Refer-a-friend & Get Z <?= (new \App\Models\Setting())->where('var_name', 'ZAPPTA_INVITE_FRIEND')->first()['var_detail'] ?> Coins
                </div>
        </header>