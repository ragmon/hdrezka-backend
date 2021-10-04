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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/doc/swagger', function () {
    return view('docs.swagger');
});

$router->post('/search', ['as' => 'search', 'uses' => 'SearchController@query']);
$router->get('/search/{requestId}', ['as' => 'search_result', 'uses' => 'SearchController@result']);

$router->post('/page', ['as' => 'page', 'uses' => 'PageController@query']);
$router->get('/page/{pageId}', ['as' => 'page_result', 'uses' => 'PageController@result']);
