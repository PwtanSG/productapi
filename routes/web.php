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

$router->get('/products', 'ProductsController@index');
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