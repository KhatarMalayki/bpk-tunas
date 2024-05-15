<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'BerandaController::index');
$routes->get('beranda', 'BerandaController::index');
$routes->get('status/(:any)', 'BerandaController::status/$1');
$routes->post('search', 'BerandaController::search');
$routes->post('update-status', 'BerandaController::getStatus');
$routes->post('request-bpk', 'BerandaController::create');

// routes dashboard admin
$routes->get('testing', 'Admin\DashboardController::dashboard');
$routes->get('dashboard', 'Admin\DashboardController::index');
$routes->group('', ['filter' => 'role:admin,superadmin'], function($routes) {

// routes admin bukti pengeluaran kas
$routes->get('bukti-pengeluaran-kas', 'Admin\BpkController::index');
$routes->get('request-form', 'Admin\BpkController::request');
$routes->put('bukti-pengeluaran-kas/approve', 'Admin\BpkController::approve');
$routes->put('bukti-pengeluaran-kas/reject', 'Admin\BpkController::reject');
$routes->put('bukti-pengeluaran-kas/edit/(:segment)', 'Admin\BpkController::update/$1');
// routes admin akun
$routes->get('akun/detail/(:num)', 'Admin\AkunController::detail/$1');
$routes->put('akun/edit/(:num)', 'Admin\AkunController::update/$1');
$routes->delete('akun/delete/(:num)', 'Admin\AkunController::destroy/$1');
$routes->get('akun', 'Admin\AkunController::index');
});
$routes->get('bpk-detail/(:segment)', 'Admin\BpkController::detail/$1');
$routes->get('/pdf/generate-pdf/(:segment)', 'Admin\BpkController::generatePdf/$1');
$routes->get('export-excel', 'Admin\BpkController::exportExcel');

