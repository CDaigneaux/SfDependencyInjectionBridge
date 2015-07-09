<?php
namespace SfDependencyInjectionBridge;

use SfDependencyInjectionBridge\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $key    = 'sf-dependency-injection';

        $moduleConfig = [];
        if (isset($config[$key]) && is_array($config[$key])) {
            $moduleConfig = $config[$key];
        }

        return new ModuleOptions($moduleConfig);
    }
}
