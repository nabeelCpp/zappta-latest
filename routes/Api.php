<?php
$routes->group('api', ['namespace' => 'App\Controllers\API', 'filter' => 'api.client'], function($routes) {
    $routes->post('stripe_webhook', 'App\Controllers\API\User\Checkout::stripeWebhook');
    $routes->get('image_dimensions', 'Home::imageDimensions');
    $routes->get('home', 'Home::index');
    $routes->get('search', 'Home::search');
    /**
     * Category API
     */
    $routes->group('categories', function($routes) {
        $routes->get('', 'Category::index');
        $routes->get('(:any)', 'Category::single/$1');
    });
    $routes->get('products/(:any)/p/(:any)/', 'Home::product/$1/$2');

    $routes->get('compaigns', 'Home::compaigns');
    /**
     * Stores API
     */
    $routes->group('stores', function($routes) {
        $routes->get('', 'Store::index');
        $routes->get('(:any)', 'Store::single/$1');
    });
    $routes->group('cart', ['filter' => 'api.customer'], function($routes) {
        $routes->get('', 'Cart::index');
        $routes->post('', 'Cart::add');
    });

    $routes->group('customer', ['namespace' => 'App\Controllers\API\User'], function($routes) {
        $routes->post('login', 'Login::index');
        $routes->post('register', 'Login::register');
        $routes->post('login/verify', 'Login::verify');
        $routes->group('', ['filter' => 'api.customer'], function($routes) {
            $routes->get('dashboard', 'Home::index');
            $routes->group('history', function($routes) {
                $routes->get('', 'History::index');
                // $routes->delete('remove/(:any)', 'Home::removeWishlist/$1');
                // $routes->post('add', 'Home::addToWishlist');
            });
            $routes->group('wishlist', function($routes) {
                $routes->get('', 'Home::wishList');
                $routes->delete('', 'Home::removeWishlist');
                $routes->post('', 'Home::addToWishlist');
            });
            $routes->get('wallet', 'Home::wallet');
            $routes->post('review', 'Home::giveReview');
            $routes->get('notifications', 'Profile::notifications');
            $routes->get('referral', 'Profile::referral');
            $routes->get('addresses', 'Home::addresses');
            $routes->post('addresses', 'Home::saveAddresse');
            $routes->delete('addresses/(:num)', 'Home::removeAddress/$1');
            $routes->patch('addresses/(:num)', 'Home::editAddress/$1');
            $routes->group('profile', function($routes) {
                $routes->get('', 'Profile::index');
                $routes->patch('', 'Profile::update');
                $routes->post('password', 'Profile::updatePassword');
            });
            $routes->group('checkout', function($routes) {
                $routes->post('paymentIntent/create', 'Checkout::createPaymentIntent');
                $routes->post('', 'Checkout::checkout');
            });
            $routes->group('spin_cart', function($routes) {
                $routes->get('sprees', 'SpinCart::getSprees'); // sprees / sprees?com_id=?&store_id=?
                $routes->post('spree', 'SpinCart::addRemove');
                $routes->delete('spree', 'SpinCart::addRemove');
            });
            $routes->post('spree/validate', 'SpinCart::fetchSpree');
        });
    });
});

?>