<?php
namespace Skansing\Escapology\Router;

use \Skansing\Escapology\Cacher,
    \Skansing\Escapology\Dispatcher,
    \Skansing\Escapology\Router,
    \Skansing\Escapology\RouteFileParser,
    \Skansing\Escapology\RouteFileParser\Regex as RegexRouteFileParser,
    \Skansing\Escapology\Dispatcher\Regex as RegexDispatcher;
  
class Application implements Router {
 
    /**
     * @var RouteFileParser $routeFileParser
     */
    private $routeFileParser;

    /**
     * @var Dispatcher $dispatcher
     */
    private $dispatcher;

    /**
     * @var Cacher $cacher
     */
    private $cacher;

    /**
     * @var string $cacheKey]
     */
    private $cacheKey;

    /**
     * @var boolean $cacheInUse
     */
    private $cacheInUse = false;

  /**
   * Application router
   *
   * Routes found routes to the new application and not found to the old
   *
   * @param Dispatcher|null      $dispatcher      
   * @param RouteFileParser|null $routeFileParser
   * @param Cacher $cacher
   * @param string $cacheKey
   */
  public function __construct(
    Dispatcher $dispatcher,  
    RouteFileParser $routeFileParser = null,
    Cacher $cacher = null,
    $cacheKey = null 
  ){
    $this->routeFileParser = $routeFileParser ?: new RegexRouteFileParser;
    $this->dispatcher = $dispatcher;
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
