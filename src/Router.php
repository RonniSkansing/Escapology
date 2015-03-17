<?php
namespace Skansing\Escapology;

Interface Router {
  public function handle(
    $routesFile
  );
}