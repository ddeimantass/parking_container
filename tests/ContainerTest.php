<?php

namespace Parking\Tests;

use Parking\ContainerFactory;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private $container = __DIR__ . '/../var/cache/container.php';
    private $containerMeta = __DIR__ . '/../var/cache/container.php.meta';
    
    public function setUp()
    {
        if(file_exists($this->containerMeta)){
            unlink($this->containerMeta);
        }
    }
    
    public function testContainer_noFile()
    {
        if(file_exists($this->container)){
            unlink($this->container);
        }
        $factory = new ContainerFactory();
        $container = $factory->create($this->container);
        $this->assertFileExists($this->container);
        $this->assertFileExists($this->containerMeta);
    }
    
    public function testContainer_noDebug()
    {
        $factory = new ContainerFactory();
        $container = $factory->create($this->container);
        $this->assertFileExists($this->container);
        $this->assertFileNotExists($this->containerMeta);
    }
    
    public function testContainer_Debug()
    {
        $factory = new ContainerFactory();
        $container = $factory->create($this->container, true);
        $this->assertFileExists($this->container);
        $this->assertFileExists($this->containerMeta);
        
    }
}