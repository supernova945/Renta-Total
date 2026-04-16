<?php

use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */

//Rutas de login y autenticacion

$routes->get('/', 'Auth::loginForm');
$routes->get('login', 'Auth::loginForm');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');

//Redireccion a dashboard

$routes->get('dashboard', 'Dashboard::dashboard');
$routes->get('dashboarda', 'Dashboard::dashboard');

// Ruta para el registro de actividad
$routes->get('activity-log', 'Dashboard::activityLog');
$routes->get('activity-log/export-csv', 'Dashboard::exportActivityLogCsv');

// Rutas para notificaciones
$routes->get('notifications/count', 'Notifications::count');
$routes->get('notifications/list', 'Notifications::list');

// Ruta para el perfil de usuario
$routes->get('profile', 'Profile::index');
$routes->get('profile/edit', 'Profile::edit');
$routes->post('profile/update', 'Profile::update');
$routes->post('profile/change-password', 'Profile::changePassword');

// Rutas para la gestión de servicios
$routes->get('servicios', 'Servicios::index', ['filter' => 'role:Administrador,Jefatura']);
$routes->post('servicios/createViaAjax', 'Servicios::createViaAjax', ['filter' => 'role:Administrador,Jefatura']);
$routes->get('servicios/details/(:num)', 'Servicios::details/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->match(['POST', 'PUT'], 'servicios/update/(:num)', 'Servicios::update/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->delete('servicios/delete/(:num)', 'Servicios::delete/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->get('servicios/get-motocicletas', 'Servicios::getMotocicletas');
$routes->get('servicios/upcoming-count', 'Servicios::getUpcomingServicesCount');
$routes->get('servicios/upcoming-services', 'Servicios::getUpcomingServices');

// Rutas para la gestión de rentas
$routes->get('rentas', 'Rentas::index', ['filter' => 'role:Administrador,Jefatura']);
$routes->post('rentas/createRental', 'Rentas::createRental', ['filter' => 'role:Administrador,Jefatura']);
$routes->get('rentas/details/(:segment)', 'Rentas::getRentalDetails/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->post('rentas/update/(:segment)', 'Rentas::updateRental/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->post('rentas/end/(:segment)', 'Rentas::endRental/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->get('rentas/available-motorcycles', 'Rentas::getAvailableMotorcycles');
$routes->get('rentas/clients', 'Rentas::getClients');
$routes->get('rentas/expiring-count', 'Rentas::getExpiringLeasesCount');
$routes->get('rentas/expiring-leases', 'Rentas::getExpiringLeases');

// Rutas para la gestión de reportes
$routes->get('reportes', 'Reportes::index', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/available-motorcycles', 'Reportes::generateAvailableMotorcyclesReport', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/available-motorcycles/(:segment)', 'Reportes::generateAvailableMotorcyclesReport/$1', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/preview/available-motorcycles', 'Reportes::previewAvailableMotorcyclesReport', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/preview/available-motorcycles/(:segment)', 'Reportes::previewAvailableMotorcyclesReport/$1', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/leased-motorcycles', 'Reportes::generateLeasedMotorcyclesReport', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/leased-motorcycles/(:segment)', 'Reportes::generateLeasedMotorcyclesReport/$1', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/preview/leased-motorcycles', 'Reportes::previewLeasedMotorcyclesReport', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/preview/leased-motorcycles/(:segment)', 'Reportes::previewLeasedMotorcyclesReport/$1', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/active-services', 'Reportes::generateActiveServicesReport', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/active-services/(:segment)', 'Reportes::generateActiveServicesReport/$1', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/preview/active-services', 'Reportes::previewActiveServicesReport', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/preview/active-services/(:segment)', 'Reportes::previewActiveServicesReport/$1', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/historical-services', 'Reportes::generateHistoricalServicesReport', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/historical-services/(:segment)', 'Reportes::generateHistoricalServicesReport/$1', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/preview/historical-services', 'Reportes::previewHistoricalServicesReport', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/preview/historical-services/(:segment)', 'Reportes::previewHistoricalServicesReport/$1', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);
$routes->get('reportes/system', 'Reportes::generateSystemReport', ['filter' => 'auth:userRolesFilter:Administrador,Jefatura,Visualizador']);

// Rutas para la gestión de usuarios

$routes->post('usuarios/ajax-add', 'Usuarios::createViaAjax', ['filter' => 'role:Administrador']);
$routes->post('usuarios/createViaAjax', 'Usuarios::createViaAjax2', ['filter' => 'role:Administrador']);
$routes->get('usuarios', 'Usuarios::usuarios', ['filter' => 'role:Administrador']);
$routes->delete('usuarios/delete/(:num)', 'Usuarios::delete/$1', ['filter' => 'role:Administrador']);
$routes->get('usuarios/show/(:num)', 'Usuarios::show/$1', ['filter' => 'role:Administrador']);
$routes->put('usuarios/update/(:num)', 'Usuarios::updateUser/$1', ['filter' => 'role:Administrador']);

// Rutas para la gestión de clientes
$routes->get('clientes', 'Clientes::index', ['filter' => 'role:Administrador,Jefatura']);
$routes->post('clientes/create', 'Clientes::create', ['filter' => 'role:Administrador,Jefatura']);
$routes->get('clientes/list', 'Clientes::getClients', ['filter' => 'role:Administrador,Jefatura']);
$routes->get('clientes/getClient/(:num)', 'Clientes::getClient/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->put('clientes/update/(:num)', 'Clientes::update/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->delete('clientes/delete/(:num)', 'Clientes::delete/$1', ['filter' => 'role:Administrador,Jefatura']);

// Rutas para la gestión de empresas
$routes->get('empresas', 'Empresas::index', ['filter' => 'role:Administrador,Jefatura']);
$routes->post('empresas/create', 'Empresas::create', ['filter' => 'role:Administrador,Jefatura']);
$routes->get('empresas/list', 'Empresas::getCompanies', ['filter' => 'role:Administrador,Jefatura']);
$routes->get('empresas/getCompany/(:num)', 'Empresas::getCompany/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->put('empresas/update/(:num)', 'Empresas::update/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->delete('empresas/delete/(:num)', 'Empresas::delete/$1', ['filter' => 'role:Administrador,Jefatura']);

$routes->resource('usuarios');
//$routes->resource('motos');


//Rutas para la gestión de motocicletas

$routes->get('motocicletas', 'Motocicletas::index');
$routes->post('motocicletas/createViaAjax', 'Motocicletas::createViaAjax', ['filter' => 'role:Administrador,Jefatura']);
$routes->get('motocicletas/details/(:num)', 'Motocicletas::details/$1');
$routes->put('motocicletas/update/(:num)', 'Motocicletas::update/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->delete('motocicletas/delete/(:num)', 'Motocicletas::delete/$1', ['filter' => 'role:Administrador,Jefatura']);

$routes->get('motocicletas/details/(:segment)', 'Motocicletas::getMotocicletaDetails/$1');
$routes->get('motocicletas/services/(:segment)', 'Motocicletas::getServicesForMotorcycle/$1', ['filter' => 'role:Administrador,Jefatura']);
$routes->post('motocicletas/update/(:segment)', 'Motocicletas::update/$1');
$routes->delete('motocicletas/delete/(:segment)', 'Motocicletas::delete/$1');
//Rutas para agencias 
$routes->get('agencias/getAgencias', 'Agencias::getAgencias');
$routes->post('agencias/save', 'Agencias::save');
$routes->delete('agencias/delete/(:num)', 'Agencias::delete/$1');
//Rutas para Bitacora
$routes->post('motocicletas/addComment', 'Motocicletas::addComment',);
//Rutas para el cotizador

$routes->get('cotizador', 'CaludadorController::index');

//Aplicar filtro de autenticación a las rutas de dashboard

// $routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->set404Override(function($message = null) {
    $response = service('response');
    $response->setStatusCode(404);
    return view('errors/html/error_404', ['message' => $message]);
});
