<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' => '/'], function (Router $router) {
    $router->get('register-intern', 'RegisterController@index');
    $router->post('register-intern/create', [
        'as' => 'register-intern/create',
        'uses' => 'RegisterController@store',
    ]);
    $router->get('register-intern/success',[
        'RegisterController@success'
    ]);
});