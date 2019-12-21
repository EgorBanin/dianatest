<?php declare(strict_types=1);

// php -S localhost:8000 main.php

require __DIR__ . '/vendor/autoload.php';

$routes = require __DIR__ . '/routes.php';
$handlersDir = __DIR__ . '/httpHandlers';
$container = new Container();
$container->put(
	'db',
	\Mysql\Client::init('root', 'root', '127.0.0.1')
		->defaultDb('dianatest')
		->charset('utf8')
);
$app = new App($routes, $handlersDir, $container);
$exitCode = $app->run(Request::fromGlobals($_SERVER, $_GET, $_POST, $_FILES, $_COOKIE, 'php://input'));
exit($exitCode);