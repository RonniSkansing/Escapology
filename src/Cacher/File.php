<?php
namespace Skansing\Escapism\Cacher;

use \Skansing\Escapism\Cacher;

class File implements Cacher {

  /**
   * @param string $key  File to save the cached data 
   * @param value $value Cached data
   */
  public function set($key, $value)
  {
    file_put_contents(
      $key,
      '<?php return ' . var_export($value, true) . ';'
    );
  }

  /**
   * @param  string $key File to get cached data 
   * @return bool
   */
  public function get($key)
  {
    if(file_exists($key) === false) {

      return false;
    }

    return require $key;
  }
}