<?php

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/users/{user_id:\d+}/services/{service_id:\d+}/tarifs', 'ServiceController@getTarifs');
    $r->addRoute('PUT', '/users/{user_id:\d+}/services/{service_id:\d+}/tarif', 'ServiceController@setTarif');
});