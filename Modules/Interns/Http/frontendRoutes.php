<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' => '/'], function (Router $router) {
    $router->get('register-intern', 'RegisterController@index');
});
