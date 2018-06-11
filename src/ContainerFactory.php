<?php

namespace Parking;

use Parking\DependencyInjection\ParkingExtension;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;

class ContainerFactory
{
    /**
     * @return ContainerInterface
     */
    public function create($filename, $isDebug = false){
    
        $containerConfigCache = new ConfigCache($filename, $isDebug);
    
        if (!$containerConfigCache->isFresh()) {
            $containerBuilder = new ContainerBuilder();
            $extension = new ParkingExtension();
            $containerBuilder->registerExtension($extension);
            $containerBuilder->loadFromExtension($extension->getAlias());
            $containerBuilder->compile();
        
            $dumper = new PhpDumper($containerBuilder);
            $containerConfigCache->write(
                $dumper->dump(['class' => 'ParkingContainer']),
                $containerBuilder->getResources()
            );
        }
    
        require_once $filename;
        return new \ParkingContainer();
    }
}