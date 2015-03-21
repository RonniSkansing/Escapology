<?php
namespace Skansing\Escapology\Test\Dispatcher;

use \Skansing\Escapology\Dispatcher\Regex as Dispatcher;

class RegexTest extends \PHPUnit_Framework_TestCase {

  private $dispatcher;

  public function setup() 
  {
    $this->dispatcher = new Dispatcher('GET', '/user/42');
  }

  public function testDispatchReturnsNotFoundIfNoDataAreSet()
  {
    $this->assertSame(
      \Skansing\Escapology\Dispatcher::NOT_FOUND,
      $this->dispatcher->dispatch(
        []
      )
    );
  }

  /**
   * @dataProvider routesDataProvider
   */
  public function testDispatchReturnInterfaceNotFoundValueIfNotFound($routesData)
  {
    $this->assertSame(
      \Skansing\Escapology\Dispatcher::FOUND,
      $this->dispatcher->dispatch($routesData)
    );
  }

  public function routesDataProvider() 
  {
    return [
      [[
        'GET' => '~^(?:/|/user/42)$~'
      ]],
      [[
        'GET' => '~^(?:|/user/\d+)$~'
      ]]
    ];
  }
}