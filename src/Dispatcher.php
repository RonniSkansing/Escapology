<?php
namespace Skansing\Escapism;

Interface Dispatcher {

  const
    NOT_FOUND = 0,
    FOUND = 1;

  public function dispatch($routesData);
}