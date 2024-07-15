<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->addRedirect('/', 'login');
$routes->addRedirect('main', 'main/dashboard');
$routes->get('login', 'Auth\LoginController::loginPage');
$routes->get('register', 'Auth\LoginController::registerPage');
$routes->group('auth', function ($routes) {
    $routes->post('login-process', 'Auth\LoginController::doLogin');
    $routes->post('register-process', 'Auth\LoginController::doRegister');
});
$routes->group('main', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('dashboard', "DashboardController::index");

    $routes->group('flowers', function ($routes) {
        $routes->get('data-tanaman', "FlowerController::index");
        $routes->get('data-tanaman-filter', "FlowerController::indexFilter");
        $routes->post('load-data', "FlowerController::loadData");
        $routes->get('fetch-data', "FlowerController::fetchFlowersData");
        $routes->get('edit/(:segment)', "FlowerController::edit/$1");
        $routes->post('create', 'FlowerController::create');
        $routes->post('update/(:segment)', 'FlowerController::update/$1');
        $routes->post('delete/(:segment)', 'FlowerController::delete/$1');
    });

    $routes->group('master-data', function ($routes) {
        $routes->group('flowers-type', function ($routes) {
            $routes->get('tipe-tanaman', "FlowerTypeController::index");
            $routes->get('fetch-data', "FlowerTypeController::fetchFlowersType");
            $routes->post('create', 'FlowerTypeController::create');
            $routes->get('edit/(:segment)', "FlowerTypeController::edit/$1");
            $routes->post('update/(:segment)', 'FlowerTypeController::update/$1');
            $routes->post('delete/(:segment)', 'FlowerTypeController::delete/$1');
        });
    });

    $routes->group('profile', function ($routes) {
        $routes->get('setting', 'ProfileController::index');
        $routes->post('update/(:segment)', 'ProfileController::update/$1');
    });

    $routes->get('logout', 'Auth\LoginController::logout');
});
