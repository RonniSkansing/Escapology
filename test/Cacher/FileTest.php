<?php
namespace Skansing\Escapology\Test\Dispatcher;

use \Skansing\Escapology\Cacher\File as Cache,
    \org\bovigo\vfs\vfsStream;

class FileTest extends \PHPUnit_Framework_TestCase {

  private 
    $cache,
    $virtualFileSystemPath,
    $vfs;

  public function setup() 
  {
    $this->virtualFileSystemPath = 'vfs';
    $this->vfs = vfsStream::setup($this->virtualFileSystemPath);
    $this->cache = new Cache;
  }

  public function testSetUsesKeyAsFileNameToPersistCacheIn()
  {
    $file = vfsStream::url($this->virtualFileSystemPath . '/testFile');
    $this->cache->set($file, 'dummyValue');
    $this->assertTrue(
      $this->vfs->hasChild('testFile')
    );
  }

  public function testSetUsesValueAsFileContentToPersistCacheIn()
  {
    $file = vfsStream::url($this->virtualFileSystemPath . '/testFile');
    $this->cache->set($file, ['GET', '/']);
    $this->assertSame(
      "<?php return array (\n  0 => 'GET',\n  1 => '/',\n);",
      file_get_contents($file)
    );
  }

  public function testGetReturnsFalseIfFalseDoesNotExists() 
  {
    $this->assertFalse(
      $this->cache->get(__DIR__ . 'nonExistentFile.dummy')
    );
  }

  public function testGetReturnsSetCache()
  {
    $file = vfsStream::url($this->virtualFileSystemPath . '/testFile');
    $data = ['GET', '/'];
    $this->cache->set($file, $data);
    $this->assertSame(
      $data,
      $this->cache->get($file)
    );
  }
}