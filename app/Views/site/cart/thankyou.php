<?= view('site/newLanding/header', ['globalSettings' => $globalSettings]); ?>
<section class="py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-5">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Shop</li>
                <li class="breadcrumb-item">All Products</li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <div class="checkoutBlankSection">
            <div class="checkoutBlankPage">
                <h3>Order Placed!</h3>
                <p>Thank you for choosing zappta</p>

                <div class="productSelectionFinal">

                    <a href="<?=base_url('dashboard/history/status?order_id='.$order_id)?>" class="cartBtn">
                        Track order</a>
                    <a href="<?=base_url()?>" class="buyNowBtn">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= view('site/newLanding/footer', ['globalSettings' => $globalSettings]) ?>