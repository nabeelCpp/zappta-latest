<?php
$routes->group('api', ['namespace' => 'App\Controllers\API'], function($routes) {
    $routes->get('home', 'Home::index');
    $routes->get('categories', 'Category::index');
    $routes->get('category/(:any)', 'Category::single/$1');
    $routes->group('user', ['namespace' => 'App\Controllers\API\User'], function($routes) {
        $routes->post('login', 'Login::index');
        $routes->get('index', 'Home::index');
        $routes->group('', ['filter' => 'api.customer'], function($routes) {
        });
    });
});

?>