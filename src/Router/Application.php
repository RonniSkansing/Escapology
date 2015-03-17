<?php
namespace Skansing\Escapism\Router;

use \Skansing\Escapism\Cacher,
    \Skansing\Escapism\Dispatcher,
    \Skansing\Escapism\Router,
    \Skansing\Escapism\RouteFileParser,
    \Skansing\Escapism\RouteFileParser\Regex as RegexRouteFileParser,
    \Skansing\Escapism\Dispatcher\Regex as RegexDispatcher;
  
class Application implements Router {

  private 
    /**
     * @var RouteFileParser $routeFileParser
     */
    $routeFileParser,

    /**
     * @var Dispatcher $dispatcher
     */
    $dispatcher,

    /**
     * @var Cacher $cacher
     */
    $cacher,

    /**
     * @var string $cacheKey]
     */
    $cacheKey,

    /**
     * @var boolean $cacheInUse
     */
    $cacheInUse = false;

  /**
   * Application router
   *
   * Routes found routes to the new application and not found to the old
   *
   * @param Dispatcher|null      $dispatcher      
   * @param RouteFileParser|null $routeFileParser
   */
  public function __construct(
    Dispatcher $dispatcher = null,    
    RouteFileParser $routeFileParser = null,
    Cacher $cacher = null,
    $cacheKey = null 
  ){
    $this->routeFileParser = $routeFileParser ?: new RegexRouteFileParser;
    $this->dispatcher = $dispatcher ?: new RegexDispatcher($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    $this->cacher = $cacher;
    if($this->cacher) {
      $this->cacheKey = $cacheKey ?: '__routeCache';  
      $this->cacheInUse = true;
    }
  }

  /**
   * Routes to new or old application
   * 
   * @param  string $routesFile     
   * @param  string $newApplicationFile
   * @param  string $oldApplicationFile
   */
  public function handle(
    $routesFile
  ){
    if($this->cacheInUse) {
      $routeData = $this->cacher->get($this->cacheKey);  
      if($routeData === false) {
        $routeData = $this->routeFileParser->digest($routesFile);
        $this->cacher->set($this->cacheKey, $routeData);
      }  
    } else {
      $routeData = $this->routeFileParser->digest($routesFile);
    }
    $result = $this->dispatcher->dispatch(
      $routeData
    );

    return $result;
  }
}
