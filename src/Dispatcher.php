<?php
namespace Skansing\Escapology;

Interface Dispatcher {

  const
    NOT_FOUND = 0,
    FOUND = 1;

  public function dispatch($routesData);
}