<?php
namespace Skansing\Escapism\Router;

use \Skansing\Escapism\Dispatcher,
    \Skansing\Escapism\Router,
    \Skansing\Escapism\RouteFileParser,
    \Skansing\Escapism\RouteFileParser\Regex as RegexRouteFileParser,
    \Skansing\Escapism\Dispatcher\Regex as RegexDispatcher;
  
class Application implements Router {

  private 
    /**
     * @var RouteFileParser
     */
    $routeFileParser,
    /**
     * @var Dispatcher
     */
    $dispatcher,
    /**
     * @var Cacher
     */
    $cacher;

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
    RouteFileParser $routeFileParser = null
    //Cacher $cacher = null 
  ){
    $this->routeFileParser = $routeFileParser ?: new RegexRouteFileParser;
    $this->dispatcher = $dispatcher ?: new RegexDispatcher($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    //$this->cacher = $cacher ?: null; // @todo add caching interface
  }

  /**
   * Routes to new or old application
   * 
   * @param  string $routesFile     
   * @param  string $newApplicationFile
   * @param  string $oldApplicationFile
   */
  public function route(
    $routesFile,
    $newApplicationFile,
    $oldApplicationFile
  ){
    $routesData = $this->routeFileParser->digest($routesFile);
    $route = $this->dispatcher->dispatch(
      $routesData
    );
    switch($route) {
      case Dispatcher::NOT_FOUND:
        require $oldApplicationFile;
        break;
      case Dispatcher::FOUND:
        require $newApplicationFile;
        break;
    }
  }
}
