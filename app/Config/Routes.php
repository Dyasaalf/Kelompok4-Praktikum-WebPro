<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Halaman utama - pilihan login Admin / Anggota
$routes->get('/', 'Home::index');

// =====================================================
// AUTH - Login & Logout (Admin & Anggota)
// =====================================================
$routes->get('login/admin', 'Auth\AdminAuth::login');
$routes->post('login/admin', 'Auth\AdminAuth::attemptLogin');
$routes->get('logout/admin', 'Auth\AdminAuth::logout');

$routes->get('login/anggota', 'Auth\AnggotaAuth::login');
$routes->post('login/anggota', 'Auth\AnggotaAuth::attemptLogin');
$routes->get('logout/anggota', 'Auth\AnggotaAuth::logout');

// =====================================================
// AREA ADMIN - dilindungi filter 'adminAuth'
// =====================================================
$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // CRUD Buku
    $routes->get('buku', 'Admin\Buku::index');
    $routes->get('buku/create', 'Admin\Buku::create');
    $routes->post('buku/save', 'Admin\Buku::save');
    $routes->get('buku/edit/(:num)', 'Admin\Buku::edit/$1');
    $routes->post('buku/update/(:num)', 'Admin\Buku::update/$1');
    $routes->post('buku/delete/(:num)', 'Admin\Buku::delete/$1');

    // CRUD Anggota
    $routes->get('anggota', 'Admin\Anggota::index');
    $routes->get('anggota/create', 'Admin\Anggota::create');
    $routes->post('anggota/save', 'Admin\Anggota::save');
    $routes->get('anggota/edit/(:num)', 'Admin\Anggota::edit/$1');
    $routes->post('anggota/update/(:num)', 'Admin\Anggota::update/$1');
    $routes->post('anggota/delete/(:num)', 'Admin\Anggota::delete/$1');
});

// =====================================================
// AREA CUSTOMER / ANGGOTA - dilindungi filter 'anggotaAuth'
// =====================================================
$routes->group('customer', ['filter' => 'anggotaAuth'], static function ($routes) {
    $routes->get('buku', 'Customer\Dashboard::index');
    $routes->post('buku/pinjam/(:num)', 'Customer\Dashboard::pinjam/$1');

    $routes->get('pinjaman-saya', 'Customer\Pinjaman::index');
    $routes->post('buku/kembalikan/(:num)', 'Customer\Pinjaman::kembalikan/$1');
});
