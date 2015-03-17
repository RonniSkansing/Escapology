<?php
namespace Skansing\Escapism;

Interface Cacher {
	public function set($key, $value);
	public function get($key);
}