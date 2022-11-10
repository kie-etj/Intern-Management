<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/'], function (Router $router) {
    $router->post('hanet', 'HanetController@hanet');
    $router->post('hanet/token', [
        'as' => 'hanet.token',
        'uses' => 'HanetController@updateToken',
    ]);







});
