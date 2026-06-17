<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/layanan', 'Layanan::index');
$routes->get('/layanan/tambah', 'Layanan::tambah');
$routes->post('/layanan/simpan', 'Layanan::simpan');
$routes->get('/layanan/edit/(:num)', 'Layanan::edit/$1');
$routes->post('/layanan/update/(:num)', 'Layanan::update/$1');
$routes->get('/layanan/hapus/(:num)', 'Layanan::hapus/$1');
$routes->get('/layanan/detail/(:num)', 'Layanan::detail/$1');
$routes->get('/layanan/riwayat', 'Layanan::riwayat');
$routes->get('/layanan/selesaikan/(:num)', 'Layanan::selesaikan/$1');
$routes->get('/layanan/diambil/(:num)', 'Layanan::diambil/$1');