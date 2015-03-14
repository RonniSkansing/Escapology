<?php
namespace Skansing\Escapism\Dispatcher;

use \Skansing\Escapism\Dispatcher;
  
class Regex implements Dispatcher {

  private 
    /**
     * @var string $uri
     */
    $uri,
    /**
     * @var string $verb
     */
    $verb;

  /**
   * @param string $verb The HTTP request method/verb
   * @param string $uri  The HTTP URI
   */
  public function __construct(
    $verb,
    $uri
  ){
    $this->verb = $verb;
    $this->uri = $uri;
  }

  /**
   * Returns if the route was found or not
   * 
   * @param Array $routesData
   * @return int
   */
  public function dispatch($routesData)
  {
    $routeRegex = $routesData[0];
    $uriFound = preg_match($routesData[0], $this->uri, $matches);
    if( ! $uriFound) {
      
      return self::NOT_FOUND;
    }

    return isset($routesData[$this->verb][$matches[0]]) ? self::FOUND : self::NOT_FOUND;
  }
}
