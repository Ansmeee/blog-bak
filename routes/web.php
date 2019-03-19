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
    return "Hellor Lumen";
});

$router->get('blogger', "BloggerController@index");
$router->get('blogger/info', "BloggerController@info");

$router->get('blog/list', "BlogController@list");
$router->get('blog', "BlogController@index");
$router->put('blog/like', "BlogController@like");
$router->put('blog/dislike', "BlogController@dislike");

$router->get('class/list', "ClassController@list");
