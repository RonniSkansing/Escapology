<?php
namespace Skansing\Escapism\Test\RouteFileParser;

use \Skansing\Escapism\RouteFileParser\Regex as RouteFileParser;

class RegexTest extends \PHPUnit_Framework_TestCase {

  private $routeFileParser;

  public function setup() 
  {
    $this->routeFileParser = new RouteFileParser();
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage Route file not found.
   */
  public function testThrowsExceptionIfRouteFileNotFound()
  {
    $this->routeFileParser->digest(__DIR__.'/missing.php');
  }

  /**
   * @expectedException \Exception
   * @expectedExceptionMessage Route file is empty.
   */
  public function testThrowsExceptionIfRouteFileIsEmpty()
  {
    $this->getDigestedFromFixture('emptyRoutes.php');
  }

  public function testBuildsVerbKeysFromRouteFile()
  {
    $routeRegexMap = $this->getDigestedFromFixture('routes.php'); 
    foreach(['GET', 'POST', 'PUT'] as $verb) {
      $this->assertArrayHasKey($verb, $routeRegexMap);
    }
  }

  public function testRoutesHasVerbKeyAsConstant() {
    $routes = $this->getRouteFileFixture('routes.php');
    $this->assertSame(
      $routes[0][RouteFileParser::VERB],
      'GET'
    );
  }

  public function testRoutesHasUriKeyAsConstant() {
    $routes = $this->getRouteFileFixture('routes.php');
    $this->assertSame(
      $routes[0][RouteFileParser::URI],
      '/'
    );
  }

  public function testRouteRegexHasRegexPrefixAsConstant() 
  {
    $routeRegexMap = $this->getDigestedFromFixture('routes.php');    
    $this->assertStringStartsWith(
      RouteFileParser::REGEX_PREFIX, $routeRegexMap['GET']
    );
  }

  public function testRouteRegexHasSeparatorAsConstant() 
  {
    $routesFile = 'twoRoutes.php';
    $routes = require __DIR__.'/../FixtureData/'.$routesFile;
    $routeRegexMap = $this->getDigestedFromFixture('twoRoutes.php');
    $offset = strpos($routeRegexMap['GET'], $routes[0][1]);
    $uriLength = strlen($routes[0][1]);
    $separatorTokenOffset = $offset + $uriLength;
    $this->assertSame(
      RouteFileParser::REGEX_SEPARATOR,
      substr($routeRegexMap['GET'], $separatorTokenOffset, 1)  
    );
  }

  public function testRegexHasSeparatorIsNotAddedToLastRoute() 
  {
    $routesFile = 'twoRoutes.php';
    $routes = require __DIR__.'/../FixtureData/'.$routesFile;
    $routeRegexMap = $this->getDigestedFromFixture('twoRoutes.php');
    $offset = strpos($routeRegexMap['GET'], $routes[1][1]);
    $uriLength = strlen($routes[1][1]);
    $separatorTokenOffset = $offset + $uriLength;
    $this->assertNotSame(
      RouteFileParser::REGEX_SEPARATOR,
      substr($routeRegexMap['GET'], $separatorTokenOffset, 1)  
    );
  }

  public function testRouteRegexHasRegexAffixAsConstant() 
  {
    $routeRegexMap = $this->getDigestedFromFixture('routes.php');
    
    $this->assertStringEndsWith(
      RouteFileParser::REGEX_AFFIX, $routeRegexMap['GET']
    );
  }

  public function testRouteRegexHasRegexGroupSeparatorAsConstant()
  {
    $routeRegexMap = $this->getDigestedFromFixture('twoRoutes.php');
    $this->assertTrue(
      strpos($routeRegexMap['GET'], RouteFileParser::REGEX_SEPARATOR) !== FALSE
    );
  }

  public function testGroupRegexIsAppendedOnASingleRoute()
  {
    $routeRegexMap = $this->getDigestedFromFixture('singleRoute.php');
    $this->assertStringStartsWith(
      RouteFileParser::REGEX_PREFIX, $routeRegexMap['GET']
    );
  }

  public function testBuildsAGroupBasedRegexOutOfRoutesForEachVerb()
  {
       $routeRegexMap = $this->getDigestedFromFixture('routes.php');
       $this->assertSame(
        '~^(?:/|/abc|/a/b/c|/ab|)$~',
        $routeRegexMap['GET']
      );
      $this->assertSame(
        '~^(?:/abc|/ab)$~',
        $routeRegexMap['POST']
      );
      $this->assertSame(
        '~^(?:/abc|)$~',
        $routeRegexMap['PUT']
      );
  }

  private function getRouteFileFixture($routeFileName)
  {
    return require __DIR__.'/../FixtureData/'.$routeFileName;
  }

  private function getDigestedFromFixture($routeFileName)
  {
    return $this->routeFileParser->digest(__DIR__.'/../FixtureData/'.$routeFileName); 
  }
}