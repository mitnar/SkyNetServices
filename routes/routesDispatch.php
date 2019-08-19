<?php

// Fetch method and URI from somewhere
require_once 'routes.php';

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo json_encode(['result' => 'method_not_found']); // исключительно для тсетового задания
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo json_encode(['result' => 'method_not_allowed']); // исключительно для тестового задания
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$class, $method] = explode("@", $handler, 2);

        require __DIR__."/../controllers/$class.php"; // путь лучше всего вынести в конфигурацию

        echo call_user_func_array([new $class, $method], $vars);
        break;
}
