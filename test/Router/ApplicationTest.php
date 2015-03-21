<?php
namespace Skansing\Escapology\Test\Router;

use \Skansing\Escapology\Router\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase {

  const
    DispatcherClassName = '\Skansing\Escapology\Dispatcher\Regex',
    RouteFileParserClassName = '\Skansing\Escapology\RouteFileParser\Regex',
    CacherClassName = '\Skansing\Escapology\Cacher\File';

  private $application;

  public function setup() 
  {
    $_SERVER['REQUEST_METHOD'] = 'GET½';
    $_SERVER['REQUEST_URI'] = '/user/42';
    $this->application = new Application;
  }

  public function testDefaultCacheFileNameIsSetWithCacher()
  {
    $application = new Application(
      $this->getMockWithDisabledConstructor(self::DispatcherClassName),
      $this->getMockWithDisabledConstructor(self::RouteFileParserClassName),
      $this->getMockWithDisabledConstructor(self::CacherClassName)
    );
    $this->assertInstancePrivateAttributeIsSameAs(
      $application,
      'cacheKey',
      '__routeCache'
    );
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

  public function testRouteFileParserIsCalledForDigestingRouteFile()
  {
    $routeFileParserMock = $this->getMockWithDisabledConstructor('\Skansing\Escapology\RouteFileParser');//self::DispatcherClassName);
    $routeFileParserMock->expects($this->once())->method('digest');
    $application = new Application(null, $routeFileParserMock);
    $application->handle(
      __DIR__.'/../FixtureData/routes.php'
    );
  }

  public function testDigest()
  {
    $fileSessionHandlerMock = $this->getMockWithDisabledConstructor(self::DispatcherClassName);
    $fileSessionHandlerMock->expects($this->once())->method('dispatch');
    $application = new Application($fileSessionHandlerMock, null);
    $application->handle(
      __DIR__.'/../FixtureData/routes.php'
    );
  }

  public function testHandleSetsCacheIfNoCacheWasFound()
  {
    $cacherMock = $this->getMockWithDisabledConstructor(self::CacherClassName);
    $cacherMock->expects($this->once())->method('get')->will($this->returnValue(false));
    $cacherMock->expects($this->once())->method('set');
    $application = new Application(
      $this->getMockWithDisabledConstructor(self::DispatcherClassName),
      $this->getMockWithDisabledConstructor(self::RouteFileParserClassName),
      $cacherMock
    );
    $application->handle('dummyValue');
  }

  public function testHandleGetsCache()
  {
    $cacherMock = $this->getMockWithDisabledConstructor(self::CacherClassName);
    $cacherMock->expects($this->once())->method('get');
    $application = new Application(
      $this->getMockWithDisabledConstructor(self::DispatcherClassName),
      $this->getMockWithDisabledConstructor(self::RouteFileParserClassName),
      $cacherMock
    );
    $application->handle('dummyValue');
  }


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

  private function assertInstancePrivateAttributeIsSameAs(
    $instance, 
    $attribute, 
    $value
  ){
    $reflection = new \ReflectionClass($instance);
    $reflection = $reflection->getProperty($attribute);
    $reflection->setAccessible(TRUE);
    $reflectionValue = $reflection->getValue($instance);
    $this->assertSame($value, $reflectionValue);
  }
}