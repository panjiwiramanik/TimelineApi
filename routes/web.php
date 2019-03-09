<?php

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

$router->get('/', function () use ($router) {
    return 'Timeline API - M. Panji Wiramanik XII RPL 1';
});

/**
 * Routes for resource user
 */
$router->get('user', 'UsersController@all');
$router->post('user', 'UsersController@register');
$router->post('user/login', 'UsersController@login');

/**
 * Routes for resource timeline
 */
$router->get('timeline', 'TimelinesController@all');
$router->get('timeline/{id}', 'TimelinesController@getAll');
$router->post('timeline', 'TimelinesController@add');
$router->post('timeline/{id}', 'TimelinesController@put');
$router->delete('timeline/{id}', 'TimelinesController@remove');
