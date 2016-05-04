<?php
require __DIR__ . '/../../vendor/autoload.php';

use \Skansing\Escapology\Dispatcher\Regex as RegexDispatcher;

$applicationRouter = new Skansing\Escapology\Router\Application(
  new RegexDispatcher($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'])
);
$routeFound = $applicationRouter->handle(
  __DIR__.'/route.php'
);
if($routeFound) {
  require __DIR__.'/newApplication/index.php';
} else {
  require __DIR__.'/oldApplication/index.php';
}
