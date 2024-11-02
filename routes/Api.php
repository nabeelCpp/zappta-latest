<?php
$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes) {
    $routes->get('home', 'Home::index');
    /**
     * Category API
     */
    $routes->group('categories', function($routes) {
        $routes->get('', 'Category::index');
        $routes->get('(:any)', 'Category::single/$1');
    });
    $routes->get('products/(:any)/p/(:any)/', 'Home::product/$1/$2');
    /**
     * Stores API
     */
    $routes->group('stores', function($routes) {
        $routes->get('', 'Store::index');
        $routes->get('(:any)', 'Store::single/$1');
    });
    $routes->group('cart', function($routes) {
        $routes->get('', 'Cart::index');
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
                $routes->delete('remove/(:any)', 'Home::removeWishlist/$1');
                $routes->post('add', 'Home::addToWishlist');
            });
            $routes->get('wallet', 'Home::wallet');
            $routes->get('addresses', 'Home::addresses');
            $routes->delete('addresses/(:num)', 'Home::removeAddress/$1');
            $routes->group('profile', function($routes) {
                $routes->get('', 'Profile::index');
                $routes->patch('', 'Profile::update');
                $routes->post('password', 'Profile::updatePassword');
            });
            $routes->group('checkout', function($routes) {
                $routes->post('paymentIntent/create', 'Checkout::createPaymentIntent');
            });
        });
    });
});

?>