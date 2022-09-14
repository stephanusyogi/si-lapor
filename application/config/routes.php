<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Authentication
$route['login'] = 'auth';
$route['user-auth'] = 'auth/login';
$route['logout'] = 'auth/logout';

// Dashboard
$route['dashboard'] = 'dashboard';

// Kasus 
$route['lapor-ungkap-kasus'] = 'kasus/viewLaporKasus';
$route['lapor-ungkap-kasus/(:num)'] = 'kasus/viewLaporKasusById/$1';
$route['data-tersangka/(:num)'] = 'kasus/viewTersangka/$1';
$route['data-tersangka/getBBDuplicate'] = 'kasus/getBBDuplicate'; // Get BB For Select Option When Duplicate BB
$route['barang-bukti/(:num)/(:any)'] = 'kasus/viewBarangBukti/$1/$2';
$route['finalisasi-data/(:num)'] = 'kasus/viewFinalisasiData/$1';

// Pangkalan Data
$route['master-kasus'] = 'data/viewMasterKasus';
$route['matrik-kasus'] = 'data/viewMatrikKasus';
$route['matrik-barang-bukti'] = 'data/viewMatrikBarangBukti';

// Selra
$route['selra'] = 'data/viewSelra';

// Kasus Menonjol
$route['kasus-menonjol'] = 'data/viewKasusMenonjol';

// Lapor Kasus Pelimpahan
$route['kasus-pelimpahan'] = 'pelimpahan/viewKasusPelimpahan';
$route['kasus-pelimpahan/(:num)'] = 'pelimpahan/viewKasusPelimpahanById/$1';
$route['riwayat-pelimpahan'] = 'pelimpahan/viewRiwayatPelimpahan';
$route['data-tersangka-pelimpahan/(:num)'] = 'pelimpahan/viewTersangkaPelimpahan/$1';
$route['data-tersangka-pelimpahan/getBBDuplicate'] = 'pelimpahan/getBBDuplicate'; // Get BB For Select Option When Duplicate BB
$route['barang-bukti-pelimpahan/(:num)/(:any)'] = 'pelimpahan/viewBarangBukti/$1/$2';
$route['finalisasi-data-pelimpahan/(:num)'] = 'pelimpahan/viewFinalisasiData/$1';

// Chat
$route['chat'] = 'chat';

// Export
$route['export-opsi/(:any)'] = 'export/viewExport/$1';

// Pengumuman
$route['pengumuman'] = 'pengumuman';

// Permohonan
$route['daftar-permohonan-edit'] = 'permohonan';

// Admin
$route['data-admin'] = 'admin/viewAdmin';

// Files
$route['upload-file'] = 'file/viewUploadFile';

// Additional route for super admin
// $route['riwayat-pelimpahan'] = 'pelimpahan/viewRiwayatPelimpahan';
// $route['upload-file'] = 'file/viewUploadFile';