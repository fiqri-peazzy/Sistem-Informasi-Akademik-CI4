<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', static function ($routes) {
    $routes->group('', ['filter' => 'cifilter:auth'], static function ($routes) {
        // Dashboard
        $routes->get('home', 'AdminController::index', ['as' => 'admin.home']);
        // Logout
        $routes->get('logout', 'AdminController::logoutHandler', ['as' => 'admin.logout']);
        // Data Guru
        $routes->get('guru', 'AdminController::pageGuru', ['as' => 'data.guru']);
        $routes->post('tambah-guru', 'AdminController::dataGuruStore', ['as' => 'data.guru.store']);
        $routes->post('import-guru', 'AdminController::importGuru', ['as' => 'data.guru.import']);
        $routes->get('datatables-guru', 'AdminController::datatablesGuru', ['as' => 'data.guru.datatables']);
        $routes->get('data-guru', 'AdminController::dataGuru', ['as' => 'get.data.guru']);
        $routes->post('edit-guru', 'AdminController::dataGuruUpdate', ['as' => 'data.guru.update']);
        $routes->get('hapus-guru', 'AdminController::dataGuruDrop', ['as' => 'data.guru.drop']);

        // Data Siswa
        $routes->get('siswa', 'AdminController::pageSiswa', ['as' => 'page.siswa']);
        $routes->post('tambah-siswa', 'AdminController::dataSiswaStore', ['as' => 'data.siswa.store']);
        $routes->get('datatables-siswa', 'AdminController::datatablesSiswa', ['as' => 'data.siswa.datatables']);
        $routes->get('data-siswa', 'AdminController::dataSiswa', ['as' => 'get.data.siswa']);
        $routes->post('edit-siswa', 'AdminController::dataSiswaUpdate', ['as' => 'data.siswa.update']);
        $routes->get('hapus-siswa', 'AdminController::dataSiswaDrop', ['as' => 'data.siswa.drop']);

        // Data Kelas
        $routes->get('kelas', 'AdminController::pageKelas', ['as' => 'page.kelas']);
        $routes->post('tambah-kelas', 'AdminController::dataKelasStore', ['as' => 'data.kelas.store']);
        $routes->get('datatables-kelas', 'AdminController::datatablesKelas', ['as' => 'data.kelas.datatables']);
        $routes->get('data-kelas', 'AdminController::dataKelas', ['as' => 'get.data.kelas']);
        $routes->post('edit-kelas', 'AdminController::dataKelasUpdate', ['as' => 'data.kelas.update']);
        $routes->get('hapus-kelas', 'AdminController::dataKelasDrop', ['as' => 'data.kelas.drop']);

        // Data User
        $routes->get('data_user', 'AdminController::pageUsers', ['as' => 'page.users']);
    });
    $routes->group('', ['filter' => 'cifilter:guest'], static function ($routes) {
        $routes->get('login', 'AuthController::loginForm', ['as' => 'admin.login.form']);
        $routes->post('login', 'AuthController::loginHandler', ['as' => 'admin.login.handler']);
    });
});