<?php
namespace Skansing\Escapology\RouteFileParser;

use \Skansing\Escapology\RouteFileParser;

class Regex implements RouteFileParser {

  const 
    VERB = 0,
    URI = 1,
    REGEX_PREFIX = '~^(?:',
    REGEX_SEPARATOR = '|',
    REGEX_AFFIX = ')$~';

  /**
   * @var Array $routesData
   */
  private $routesData;

  /**
   * Parses the passed route file and return a specialized array
   * 
   * @param  string $file Absolute path to the route file
   * @return Array Lookup table for routes and a combined regex
   */
  public function digest($file)
  {
    if(file_exists($file) === false) {
      throw new \Exception('Route file not found.');
    }
    $routesData = require $file;
    if(empty($routesData)) {
      throw new \Exception('Route file is empty.');
    }
    $routeRegexes = [];
    for($i = 0; $i < count($routesData) -1; ++$i) {
      if(isset($routeRegexes[$routesData[$i][self::VERB]]) === false) {
        $routeRegexes[$routesData[$i][self::VERB]] = self::REGEX_PREFIX;
      }
      $routeRegexes[$routesData[$i][self::VERB]] .= $routesData[$i][self::URI] . self::REGEX_SEPARATOR;  
    }
    if(isset($routeRegexes[$routesData[$i][self::VERB]]) === false) {
      $routeRegexes[$routesData[$i][self::VERB]] = self::REGEX_PREFIX;
    }
    $routeRegexes[$routesData[$i][self::VERB]] .= $routesData[$i][self::URI];
    foreach($routeRegexes as $verb => $regex) {
      $routeRegexes[$verb] .= self::REGEX_AFFIX;   
    }

    return $routeRegexes;
  }
}