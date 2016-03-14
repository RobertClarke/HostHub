<?php

namespace HostList;

use FastRoute;

// Application bootstrap
require_once('../app/bootstrap.php');

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = rtrim( rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo '404 not found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
		echo '405 method not allowed';
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];


		$route = explode('::', $routeInfo[1]);



		if ( !empty($route[1]) ) {

			if ( file_exists('../app/controllers/'.$route[0].'.php') ) {

				include('../app/controllers/'.$route[0].'.php');

				$object = '\HostList\\'.$route[0];
				$controller = new $object;

				call_user_func_array( [$controller, $route[1]], $routeInfo[2] );

			} else {

				echo 'controller file doesn\'t exist!';

			}

		} else {

			echo 'missing controller::method format, do something else';

		}




        // ... call $handler with $vars
        break;
}
