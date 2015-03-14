<?php
require __DIR__ . '/../../vendor/autoload.php';

$router = new Skansing\Escapism\Router\Application;
$router->route(
	__DIR__.'/routes.php',
	__DIR__.'/newApplication/index.php',
	__DIR__.'/oldApplication/index.php'
);