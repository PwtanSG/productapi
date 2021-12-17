<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/login', 'AuthController@login');
$router->post('/register', 'AuthController@register');
$router->post('/logout', 'AuthController@logout');

$router->get('/products', [
    'middleware'=>'auth',
    'uses'=>'ProductsController@index'
]);
$router->get('/products/{id}', 'ProductsController@show');
$router->post('/products/create', 'ProductsController@store');
$router->post('/products/update/{id}','ProductsController@update');
$router->delete('products/{id}','ProductsController@destroy');


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/test', function () use ($router) {
    return "test";
});