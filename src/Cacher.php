<?php
namespace Skansing\Escapology;

Interface Cacher {
  public function set($key, $value);
  public function get($key);
}