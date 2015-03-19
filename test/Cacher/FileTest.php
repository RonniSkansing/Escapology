<?php
namespace Skansing\Escapology\Test\Dispatcher;

use \Skansing\Escapology\Cacher\File as Cache;

class FileTest extends \PHPUnit_Framework_TestCase {

  private $cache;

  public function setup() 
  {
    $this->cache = new Cache;
  }

  /**
   * @requires extension uopz
   */
  public function testSetUsesKeyAsFileNameToPersistCacheIn()
  {
    /*
    $file_get_contents = uopz_copy("file_get_contents");
    uopz_function(
      'file_get_contents', 
      function(
        $filename,
        $flags = false,
        $context = null, 
        $offset = -1 
        //$maxlen = null
      ) use ($file_get_contents) {
        switch ($filename) {  
          case 'test.stream':
            var_dump($this);
            return \STDOUT;

          default:  
            echo 'AGH!';
            return $file_get_contents($filename, $flags, $context, $offset);//, $maxlen);  
        }
      }
    );
  */
  }
}