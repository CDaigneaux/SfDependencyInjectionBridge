<?php
namespace SfDependencyInjectionBridge;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $container = $serviceLocator->get('SfDependencyInjectionBridge\\ContainerBuilder');
        return $container->has($requestedName);
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $container = $serviceLocator->get('SfDependencyInjectionBridge\\ContainerBuilder');
        return $container->get($requestedName);
    }
}
