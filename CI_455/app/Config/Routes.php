<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//Home
$routes->group('home',  static function ($routes) {
    $routes->get('tech_paper', 'Home::tech_paper');
    $routes->get('documents', 'Home::documents');
    $routes->get('about', 'Home::About');
    $routes->get('internal_documents', 'Home::internal_documents');
    $routes->get('organogram', 'Home::organogram');
    $routes->get('governance', 'Home::governance');
    $routes->get('energy', 'Home::energy_graph');
    $routes->get('career', 'Home::vacancy');
    $routes->get('management', 'Home::Management');
});

$routes->group('documents', function ($routes) {
    $routes->get('/', 'Documents::index');

    $routes->post('upload', 'Documents::upload');

    $routes->get('download/(:num)', 'Documents::download/$1');
});

$routes->group('forms', static function ($routes) {
    $routes->get('downloads/(:any)', 'Form_download_ks::download_forms/$1', ['as' => 'form_download']);
});
//  User
$routes->group('users', static function ($routes) {
    $routes->get('register', 'Users::register');
    $routes->post('register', 'Users::create');
    // Login routes
    $routes->get('login', 'Users::login');
    $routes->post('loginProcess', 'Users::loginProcess');

    // Logout route
    $routes->get('logout', 'Users::logout');
});
//  SAREP Data
$routes->group('powerdata', static function ($routes) {
    $routes->get('list_energy/(:segment)', 'Powerdata::energy_list/$1');
    $routes->get('list_energy', 'Powerdata::energy_list');
    $routes->get('list_energy/incomplete', 'Powerdata::energy_list');
    $routes->get('create energy', 'Powerdata::energy_add');
    $routes->post('energy_store', 'Powerdata::energy_store');
    $routes->match(['get', 'post'], 'energy_edit/(:num)', 'Powerdata::energy_edit/$1');

    $routes->get('update_energy/(:segment)', 'Powerdata::energy_update/$1');
    $routes->post('update_energy/(:segment)', 'Powerdata::energy_update/$1');
});

//  Shared SAREP Data
$routes->group('publicdata', static function ($routes) {
    $routes->get('energy_data/(:segment)/(:segment)', 'Publicdata::energy_data/$1/$2');

    $routes->get('cod_public', 'Publicdata::cod_public');

    $routes->get('download_cod/(:num)', 'Publicdata::download_cod/$1');
    $routes->get('view_cod/(:num)', 'Publicdata::view_cod/$1'); // Add this line

    // ------------------------------------
    // New tender routes with rate limiting
    $routes->get('tenders', 'Publicdata::tenderPublic');
    $routes->get('show/(:num)', 'Publicdata::show/$1');
    $routes->get('download/file/(:num)/(:num)', 'Publicdata::downloadFile/$1/$2');

    // Updated news routes to match controller methods
    $routes->get('news', 'Publicdata::public_index');
    $routes->get('news/(:num)', 'Publicdata::public_view/$1');
    $routes->get('news/attachment/(:any)', 'Publicdata::serve_attachment/$1');

    // $routes->get('careers', 'Publicdata::vacancies');
    // $routes->get('careers/(:num)', 'Publicdata::vacancy_detail/$1');
    // $routes->get('careers/attachment/(:num)', 'Publicdata::download_vacancy_attachment/$1');
    $routes->get('public_tab', 'Publicdata::public_tab');
    $routes->get('careers', 'Publicdata::careers');
    $routes->get('careers/apply/(:num)', 'Publicdata::apply/$1');
    $routes->post('careers/store-application', 'Publicdata::storeApplication');
    $routes->get('careers/vacancy/(:num)', 'Publicdata::vacancy_detail/$1');
    $routes->get('careers/download/(:num)', 'Publicdata::download_vacancy_attachment/$1');


    $routes->get('candidates/apply/(:num)', 'Publicdata::apply/$1');
    $routes->post('candidates/store', 'Publicdata::storeApplication');
    $routes->get('report_public', 'Publicdata::report_public');

    $routes->get('results', 'PublicResults::index');
    $routes->get('results/vacancy/(:num)', 'PublicResults::viewVacancy/$1');
    $routes->get('results/candidate/(:num)', 'PublicResults::viewCandidate/$1');
});

$routes->group('reports', function ($routes) {
    $routes->get('report_list', 'Reports_ks::report_list');
    $routes->get('report_public', 'Reports_ks::report_public');
    $routes->get('report_create', 'Reports_ks::report_create');
    $routes->post('report_store', 'Reports_ks::report_store');
    $routes->get('report_download/(:num)', 'Reports_ks::report_download/$1');
    $routes->get('report_delete/(:num)', 'Reports_ks::report_delete/$1');
    $routes->get('report_preview/(:num)', 'Reports_ks::report_preview/$1');
});

//  Tickets
$routes->group('tickets', function ($routes) {
    $routes->get('add', 'Tickets::add');
    $routes->post('create', 'Tickets::create');
    $routes->get('list_tickets/(:segment)/(:segment)', 'Tickets::ticket_list/$1/$2');

    $routes->get('list_tickets/status/new', 'Tickets::ticket_list/status/new');
    $routes->get('list_tickets/status/pending', 'Tickets::ticket_list/status/pending');
    $routes->get('list_tickets/status/solved', 'Tickets::ticket_list/status/solved');
    $routes->get('list_tickets/issue_by/no_issuer', 'Tickets::ticket_list/issue_by/no_issuer');
    $routes->get('list_tickets/sol_eng/no_solver', 'Tickets::ticket_list/sol_eng/no_solver');
    $routes->get('list_tickets/status/Open', 'Tickets::ticket_list/sol_eng/no_solver');

    $routes->get('update_ticket/(:num)', 'Tickets::ticket_update/$1');

    $routes->post('update_ticket/(:num)', 'Tickets::save_update_ticket/$1');
    $routes->post('verify_ticket/(:alphanum)', 'Tickets::verify_ticket/$1');
});

//  Stations
$routes->group('stations', static function ($routes) {

    $routes->get('list_stations/(:segment)', 'Stations::station_list/$1');
    $routes->get('list stations/', 'Stations::station_list/$1');
});

// Admin Routes
$routes->group('admin', function ($routes) {
    $routes->get('tenders', 'AdminTender::tender');
    $routes->get('tenders/create', 'AdminTender::create');
    $routes->post('tenders/save', 'AdminTender::save');
    $routes->get('tenders/edit/(:num)', 'AdminTender::edit/$1');
    $routes->get('tenders/delete/(:num)', 'AdminTender::delete/$1');
});

$routes->group('bpso', function ($routes) {
    $routes->get('news', 'News::index');
    $routes->get('news/new', 'News::new');
    $routes->post('news/create', 'News::create');
    $routes->get('news/edit/(:num)', 'News::edit/$1');
    $routes->post('news/update/(:num)', 'News::update/$1');
    $routes->post('news/delete/(:num)', 'News::delete/$1');
    $routes->get('attachments/(:any)', 'News::serve_attachment/$1');
    $routes->get('news/delete_attachment/(:num)/(:num)', 'News::delete_attachment/$1/$2');
});

$routes->group('career', function ($routes) {
    $routes->get('vacancies', 'Vacancies::index');
    $routes->get('vacancies/create', 'Vacancies::create');
    $routes->post('vacancies/store', 'Vacancies::store');
    $routes->get('vacancies/view/(:num)', 'Vacancies::view/$1');
    $routes->get('vacancies/attachment/(:num)', 'Vacancies::attachment/$1');
    // In app/Config/Routes.php
    $routes->get('vacancies/close/(:num)', 'Vacancies::close/$1');
    $routes->cli('vacancies/checkExpired', 'Vacancies::checkExpired');
    $routes->get('candidates/apply/(:num)', 'Candidates::apply/$1');
    $routes->post('candidates/store', 'Candidates::storeApplication');
    $routes->get('candidates/shortlist/(:num)', 'Candidates::shortlist/$1');
    $routes->post('candidates/store-shortlist', 'Candidates::storeShortlist');
    $routes->get('candidates/resume/(:num)', 'Candidates::viewResume/$1');
    $routes->get('candidates/shortlisted', 'Candidates::viewShortlisted');
    $routes->get('candidates/reject/(:num)', 'Candidates::reject/$1');
    $routes->post('candidates/store-rejection', 'Candidates::storeRejection');

    $routes->get('candidates/select/(:num)', 'Candidates::select/$1');
    $routes->post('candidates/store-selection', 'Candidates::storeSelection');
});

$routes->get('bhutan', 'BhutanController::dashboard');
$routes->get('bhutan/dashboard', 'BhutanController::dashboard');
$routes->get('bhutan/dashboard/(:any)', 'BhutanController::dashboard/$1');
$routes->get('api/bhutan/test/(:any)', 'BhutanController::testBhutanUtility/$1');
$routes->get('api/bhutan/status', 'BhutanController::getApiStatus');
$routes->get('api/bhutan/utilities', 'BhutanController::getBhutanUtilities');
$routes->get('bhutan/debug/(:any)', 'BhutanController::debugUtility/$1');
$routes->get('bhutan/getUtilityData', 'BhutanController::getUtilityData');


$routes->get('results', 'PublicResults::index');
$routes->get('results/vacancy/(:num)', 'PublicResults::viewVacancy/$1');
$routes->get('results/candidate/(:num)', 'PublicResults::viewCandidate/$1');

//$routes->get('posoco/dashboard/(:any)', 'Posoco::dashboard/$1');
$routes->get('posoco/dashboard/(:segment)', 'Posoco::dashboard/$1');
$routes->get('posoco/dashboard', 'Posoco::dashboard');

$routes->get('auth/change-password', 'AuthController::changePassword');
$routes->post('auth/update-password', 'AuthController::updatePassword');

$routes->get('auth/edit-profile', 'AuthController::editProfile');
$routes->post('auth/update-profile', 'AuthController::updateProfile');
