<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/lp', 'Home::Landing');
$routes->post('/mailchimps', 'Mailchimps::index');
$routes->get('/default', 'Home::default');
$routes->get('/images/(:any)/(:any)/(:any)/(:any)', 'Images::index/$1');
$routes->get('/images/full/(:any)/(:any)', 'Images::fullpath');
$routes->get('/vendor-registration', 'Register::vendor');
$routes->get('/vendor-login', 'Register::vendorlogin');
$routes->post('/vendor-add', 'Register::vendoradd');
$routes->post('/vendor-login-verify', 'Register::vendorverify');

// admin dashboard
$routes->group('admincp', ['namespace' => 'App\Controllers\Admincp'], function($routes)
{
    $routes->get('/', 'Home::index');
    $routes->get('profile', 'Home::profile', ['as' => 'admin.profile']);
    $routes->post('profile', 'Home::updateProfile', ['as' => 'admin.profile.update']);
    $routes->get('email-templates', 'Home::emailTemplates');
    $routes->post('save/email-template', 'Home::saveEmailTemplate', ['as' => 'save.email.template']);
    $routes->get('notifications', 'Home::emailNotifications', ['as' => 'admin.notifications']);
    $routes->post('sendemail', 'Home::SendEmail', ['as' => 'admin.send.email']);
});

// vendor dashboard
$routes->group('vendor', ['namespace' => 'App\Controllers\Vendors'], function($routes)
{
    // $routes->get('/', 'Home::index', [ 'filter' =>  'vendor' ] );
    // $routes->get('/attributes', 'Attributes::index', [ 'filter' =>  'vendor' ] );
     $routes->get('notifications', 'Orders::GetLatestOrders', ['as' => 'vandor.notifications']);
});

// customer dashboard
$routes->group('dashboard', ['namespace' => 'App\Controllers\Dashboard'], function($routes)
{
    $routes->post('save/review/(:any)', 'Home::saveReview/$1', ['as' => 'customer.save.review']);
    // $routes->get('/', 'Home::index', [ 'filter' =>  'vendor' ] );
    // $routes->get('/attributes', 'Attributes::index', [ 'filter' =>  'vendor' ] );
});

// store routes
$routes->get('stores', 'Stores::index');
$routes->get('stores/(:any)', 'Stores::view');
$routes->get('categories', 'Category::index');
$routes->get('categories/(:any)', 'Category::single/$1');
$routes->get('products/(:any)/p/(:any)/', 'Products::index');
$routes->get('brands', 'Brands::index');
$routes->get('brands/(:any)', 'Brands::single');
$routes->post('cart/add', 'Cart::add');
$routes->get('cron', 'Cron::index');
$routes->get('payments/success', 'Cart::paysuccess');
$routes->get('payments/cancel', 'Cart::paycancel');



// cms link
$routes->get('payment-method', 'Pages::PaymentMethod');
$routes->get('about-us', 'Pages::index');
$routes->get('return-policy', 'Pages::ReturnPolicy');
$routes->get('terms-conditions', 'Pages::TermsAndConditions');
$routes->get('help', 'Pages::help');
$routes->get('contact-us', 'Pages::contact_us');
$routes->post('contact-us', 'Pages::ajaxcontact');
$routes->get('privacy-policy', 'Pages::PrivacyPolicy');
$routes->get('diy-academy', 'Pages::index');
$routes->get('plant-maintenace', 'Pages::index');
$routes->get('deletion', 'Pages::deletion');

$routes->get('compaign/winners', 'Compaign::winners', ['as' => 'compaign.winners']);
$routes->post('compaign/ajax/winners', 'Compaign::ajaxWinners',['as' => 'ajax.winners']);

$routes->post('page-feedback','Pages::AddPagesFeedBack');
$routes->get('notifications', 'Pages::notificationpage');




$routes->get('email/tpl', function(){
//     $user_data['friendName'] = 'Jamshed';
//     $user_data['friendMsg'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
// tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
// quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
// consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
// cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
// proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
// $user_data['user_id'] = 21;
// $data['user_data'] = $user_data;
// return view('email/referemail', $data);
// return view('email/veirfication', $data);
    $users['store_name'] = 'Zappta';
    $data['users'] = $users;
return view('email/vendorconfirm', $data);
});
$routes->group('api', function($routes)
{
    $routes->post('wheel/(:num)', 'Api::wheel/$1');
    $routes->post('product/details', 'Api::productDetails');
    $routes->post('leaderboard', 'Api::leaderBoard');
    $routes->post('play/save/result', 'Api::playResult');
    $routes->post('reset/player/(:num)', 'Api::resetPlayer/$1');
});
$routes->get('signup/(:any)', 'Register::loginViaReferral/$1');
$routes->post('register/save', 'Register::save');
