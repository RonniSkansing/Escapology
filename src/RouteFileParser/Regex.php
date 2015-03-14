<?php
namespace Skansing\Escapism\RouteFileParser;

use \Skansing\Escapism\RouteFileParser;

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
    $routesData = require $file;
    if($routesData === null) {
      throw new Exception('No route data loaded');
    }
    $data = [];
    $routeRegex = self::REGEX_PREFIX;
    for($i = 0; $i < count($routesData) -1; ++$i) { 
      $routeRegex .= $routesData[$i][self::URI] . self::REGEX_SEPARATOR; 
      $data[$routesData[$i][self::VERB]][$routesData[$i][self::URI]] = true;
    }
    $routeRegex .= $routesData[$i][self::URI] . self::REGEX_AFFIX;
    $data[] = $routeRegex;
    return $data;
  }
}