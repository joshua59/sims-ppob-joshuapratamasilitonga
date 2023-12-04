<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/register', 'Register::index');
$routes->get('/login', 'Login::index');
$routes->get('/login-process', 'Login::login_process');
$routes->get('/logout', 'Login::logout');
$routes->get('/topup', 'Topup::index');
$routes->get('/payment/(:any)', 'Payment::index/$1');
$routes->get('/transaction', 'Transaction::index');
$routes->get('/transaction-show-more', 'Transaction::list');
$routes->get('/account', 'Account::index');
$routes->get('/edit-profile', 'Account::edit');
