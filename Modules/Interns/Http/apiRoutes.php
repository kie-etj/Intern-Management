<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/'], function (Router $router) {
    $router->post('hanet', 'HanetController@hanet');







});
