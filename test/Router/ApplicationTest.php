<?php
namespace Skansing\Escapism\Test\Router;

use \Skansing\Escapism\Router\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase {

  const 
    DispatcherClassName = '\Skansing\Escapism\Dispatcher\Regex',
    RouteFileParserClassName = '\Skansing\Escapism\RouteFileParser\Regex';

  private $application;

  public function setup() 
  {
    $_SERVER['REQUEST_METHOD'] = 'GET½';
    $_SERVER['REQUEST_URI'] = '/user/42';
    $this->application = new Application;
  }

  public function testDispatcherDependencyFallsbackDispatcherRegex() 
  {
    $this->assertIsPrivateAttributeIsInstanceOf(
      $this->application,
      'dispatcher',
      self::DispatcherClassName
    );
  }

  public function testRouteFileParserDependencyFallsbackRouteFileParserRegex() 
  {
    $this->assertIsPrivateAttributeIsInstanceOf(
      $this->application,
      'routeFileParser',
      self::RouteFileParserClassName
    );
  }
/*
  public function testRouteFileParserIsCalledForDigestingRouteFile()
  {
    $routeFileParserMock = $this->getMockWithDisabledConstructor(' Skansing\Escapism\RouteFileParser');//self::DispatcherClassName);
    $routeFileParserMock->expects($this->once())->method('digest');
    $application = new Application(null, $routeFileParserMock);
    $router->route(
      __DIR__.'/../FixtureData/routes.php',
      __DIR__.'/../FixtureData/dummy',
      __DIR__.'/../FixtureData/dummy'
    );
  }
/*
  public function testDigest()
  {
    $routeFileParserMock = $this->getMockWithDisabledConstructor(self::DispatcherClassName);
    $fileSessionHandlerMock->expects($this->any())->method('dispatch')->will($this->returnValue(False));
  }
*/

  private function getMockWithDisabledConstructor($className)
  {
    $stubBuilder = $this->getMockBuilder($className);
    $stubBuilder->disableOriginalConstructor();
    return $stubBuilder->getMock();

  }

  private function assertIsPrivateAttributeIsInstanceOf(
    $instance, 
    $attribute, 
    $instanceOf
  ){
    $reflection = new \ReflectionClass($instance);
    $reflection = $reflection->getProperty($attribute);
    $reflection->setAccessible(TRUE);
    $value = $reflection->getValue($instance);
    $this->assertInstanceOf($instanceOf, $value);
  }


}