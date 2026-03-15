<?php

use CoffeeCode\Router\Router;

/*
|--------------------------------------------------------------------------
| Router
|--------------------------------------------------------------------------
*/

$router = new Router(APP_URL, '@');
$router->namespace('app\Controllers');


/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
*/

$router->get('/', 'WebController@home');


/*
|--------------------------------------------------------------------------
| Routes App
|--------------------------------------------------------------------------
*/

$router->get('/entrar', 'AuthController@login');
$router->post('/sair', 'AuthController@logout');
$router->get('/registrar', 'AuthController@register');
$router->get('/esqueceu-a-senha', 'AuthController@forgotPassword');

$router->group('/auth');
$router->post('/', 'AuthController@authenticate');
$router->post('/store', 'AuthController@store');
$router->post('/send-link', 'AuthController@sendLink');
$router->get('/recuperar/{code}', 'AuthController@recoverPassword');
$router->post('/reset-password', 'AuthController@resetPassword');


/*
|--------------------------------------------------------------------------
| Routes App Admin
|--------------------------------------------------------------------------
*/

$router->group('/admin');
$router->get('/dashboard', 'Admin\\DashboardController@dashboard');
$router->get('/dashboard/{page}', 'Admin\\DashboardController@dashboard');

$router->get('/escolas/{page}', 'Admin\\SchoolController@index');
$router->get('/escolas', 'Admin\\SchoolController@index');
$router->get('/escolas/cadastrar', 'Admin\\SchoolController@create');
$router->post('/escolas/store', 'Admin\\SchoolController@store');
$router->get('/escolas/editar/{id}', 'Admin\\SchoolController@edit');
$router->post('/escolas/update', 'Admin\\SchoolController@update');

$router->get('/usuarios/{page}', 'Admin\\UserController@index');
$router->get('/usuarios', 'Admin\\UserController@index');
$router->get('/usuarios/cadastrar', 'Admin\\UserController@create');
$router->post('/usuarios/store', 'Admin\\UserController@store');
$router->get('/usuarios/editar/{id}', 'Admin\\UserController@edit');
$router->post('/usuarios/update', 'Admin\\UserController@update');
$router->post('/usuarios/delete/{id}', 'Admin\\UserController@delete');

$router->get('/usuarios/solicitacoes/{page}', 'Admin\\UserController@requests');
$router->get('/usuarios/tecnicos/{page}', 'Admin\\UserController@technicians');
$router->get('/usuarios/professores/{page}', 'Admin\\UserController@teachers');

$router->get('/categorias/{page}', 'Admin\\CategoryController@index');
$router->get('/categorias', 'Admin\\CategoryController@index');
$router->get('/categorias/cadastrar', 'Admin\\CategoryController@create');
$router->post('/categorias/store', 'Admin\\CategoryController@store');
$router->get('/categorias/editar/{id}', 'Admin\\CategoryController@edit');
$router->post('/categorias/update', 'Admin\\CategoryController@update');

$router->get('/chamados/{page}', 'Admin\\TicketController@index');
$router->get('/chamados', 'Admin\\TicketController@index');
$router->get('/chamados/cadastrar', 'Admin\\TicketController@create');
$router->post('/chamados/store', 'Admin\\TicketController@store');
$router->get('/chamados/editar/{id}', 'Admin\\TicketController@edit');
$router->post('/chamados/update', 'Admin\\TicketController@update');

$router->get('/chamados/abertos', 'Admin\\TicketController@open');
$router->get('/chamados/abertos/{page}', 'Admin\\TicketController@open');


/*
|--------------------------------------------------------------------------
| Routes App Professor
|--------------------------------------------------------------------------
*/

$router->group('/professor');
$router->get('/dashboard', 'Teacher\\DashboardController@dashboard');
$router->get('/dashboard/{page}', 'Teacher\\DashboardController@dashboard');
$router->get('/chamados/{page}', 'Teacher\\TicketController@index');
$router->get('/chamados', 'Teacher\\TicketController@index');


/*
|--------------------------------------------------------------------------
| Dispatch
|--------------------------------------------------------------------------
*/
$router->dispatch();


/*
|--------------------------------------------------------------------------
| Router Error
|--------------------------------------------------------------------------
*/

if ($router->error()) {
    echo "Erro: " . $router->error();
}
