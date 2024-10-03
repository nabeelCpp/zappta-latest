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
    /**
     * Stores API
     */
    $routes->group('stores', function($routes) {
        $routes->get('', 'Store::index');
        $routes->get('(:any)', 'Store::single/$1');
    });
    $routes->group('customer', ['namespace' => 'App\Controllers\API\User'], function($routes) {
        $routes->post('login', 'Login::index');
        $routes->post('register', 'Login::register');
        $routes->group('', ['filter' => 'api.customer'], function($routes) {
            $routes->get('index', 'Home::index');
        });
    });
});

?>