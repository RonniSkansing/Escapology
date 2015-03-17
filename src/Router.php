<?php
namespace Skansing\Escapism;

Interface Router {
  public function handle(
    $routesFile
  );
}