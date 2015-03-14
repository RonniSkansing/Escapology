<?php
namespace Skansing\Escapism;

Interface Router {
  public function route(
    $routesFile,
    $newApplicationFile,
    $oldApplicationFile
  );
}