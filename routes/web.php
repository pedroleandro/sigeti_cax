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

$router->group('/admin');
$router->get('/dashboard', 'Admin\\DashboardController@dashboard');

$router->group('/professor');
$router->get('/dashboard', 'Teacher\\DashboardController@dashboard');

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
