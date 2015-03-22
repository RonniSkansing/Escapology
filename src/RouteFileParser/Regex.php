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
   * Parses the passed route file and return a specialized array
   * 
   * @param  string $file Absolute path to the route file
   * @throws \Exception If $file is missing or empty
   * @return Array Lookup table for routes and a combined regex
   */
  public function digest($file)
  {
    $routesData = $this->getRoutesData($file);
    $routeRegexes = [];
    for($i = 0; $i < count($routesData) -1; ++$i) {
      $this->setRouteRegexData($routeRegexes, $routesData, $i);
      $routeRegexes[$routesData[$i][self::VERB]] .= $routesData[$i][self::URI] . self::REGEX_SEPARATOR;
    }
    $this->setRouteRegexData($routeRegexes, $routesData, $i);
    $routeRegexes[$routesData[$i][self::VERB]] .= $routesData[$i][self::URI];
    foreach($routeRegexes as $verb => $regex) {
      $routeRegexes[$verb] .= self::REGEX_AFFIX;   
    }

    return $routeRegexes;
  }

  /**
   * Gets the routes data and returns it
   *
   * @param $file
   * @throws \Exception If $file is missing or empty
   */
  private function getRoutesData($file) {
    if(file_exists($file) === false) {
      throw new \Exception('Route file not found.');
    }
    $routesData = require $file;
    if(empty($routesData)) {
      throw new \Exception('Route file is empty.');
    }

    return $routesData;
  }

  /**
   * Sets the group regex string with the constant REGEX_PREFIX between each route
   * 
   * @param array &$routeRegexes
   * @param array &$routesData
   * @param int $index
   */
  private function setRouteRegexData(&$routeRegexes, &$routesData, $index) {
     if(isset($routeRegexes[$routesData[$index][self::VERB]]) === false) {
        $routeRegexes[$routesData[$index][self::VERB]] = self::REGEX_PREFIX;
      }
  }
}