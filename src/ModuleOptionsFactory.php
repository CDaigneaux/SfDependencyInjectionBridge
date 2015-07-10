<?php
namespace Cdx\SfDependencyInjectionBridge;

use Cdx\SfDependencyInjectionBridge\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $key    = 'sf_dependency_injection_bridge';

        $moduleConfig = [];
        if (isset($config[$key]) && is_array($config[$key])) {
            $moduleConfig = $config[$key];
        }

        return new ModuleOptions($moduleConfig);
    }
}
