<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->get('admin/login', 'Login::admin');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('logout', 'Login::logout');
$routes->group('', ['filter' => 'auth'], function ($r) {
    $r->get('dashboard', 'Dashboard::index');
    $r->get('riwayat', 'Page::riwayat');
    $r->get('profil', 'Page::profil');
    $r->post('profil/update', 'Page::profilUpdate');
    $r->get('laporan', 'Page::laporan');
    $r->get('laporan/export', 'Page::laporanExport');
    $r->get('notifikasi', 'Page::notifikasi');
    $r->get('audit', 'Page::audit');
    $r->get('telemetri', 'Page::telemetri');
    $r->get('bantuan', 'Page::bantuan');
    $r->get('surat/preview/(:num)', 'Page::preview/$1');
    $r->get('surat/print/(:num)', 'Page::printSurat/$1');
    $r->get('surat/pdf/(:num)', 'Page::pdf/$1');
    $r->get('surat/(:segment)', 'Page::surat/$1');
    $r->post('surat/simpan/(:segment)', 'Page::simpanSurat/$1');
    $r->group('admin', ['filter' => 'permission:admin.view'], function ($a) {
        $a->get('surat', 'Admin::surat');
        $a->get('arsip', 'Admin::arsip');
        $a->post('surat/(:num)/verify', 'Admin::verify/$1');
        $a->get('users', 'Admin::users');
        $a->post('users/save', 'Admin::userSave');
        $a->get('penomoran', 'Admin::penomoran');
        $a->post('penomoran/save', 'Admin::penomoranSave');
        $a->get('kop', 'Admin::kop');
        $a->post('kop/save', 'Admin::kopSave');
    });
});
