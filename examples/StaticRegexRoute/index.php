<?php
require __DIR__ . '/../../vendor/autoload.php';
$applicationRouter = new Skansing\Escapology\Router\Application;
$routeFound = $applicationRouter->handle(
	__DIR__.'/route.php'
);
if($routeFound) {
	require __DIR__.'/newApplication/index.php';
} else {
	require __DIR__.'/oldApplication/index.php';
}