<?php

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

	$r->addRoute('GET', '', 'Homepage::display');


	$r->addRoute('GET', '/login', 'Login::display');
	$r->addRoute('POST', '/login', 'Login::submit');

	$r->addRoute('GET', '/logout', 'Login::logout');

	$r->addRoute('GET', '/register', 'Register::display');
	$r->addRoute('POST', '/register', 'Register::submit');

	$r->addRoute('GET', '/welcome', 'Register::welcome');

	$r->addRoute('GET', '/dashboard', 'Dashboard::display');

	//$r->addRoute('GET', '/users', 'get_all_users_handler');
    // {id} must be a number (\d+)
    //$r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    // The /{title} suffix is optional
    //$r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});
