<?php
namespace SfDependencyInjectionBridge;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this->getContainerBuilder($serviceLocator)->has($requestedName);
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this->getContainerBuilder($serviceLocator)->get($requestedName);
    }
    
    private function getContainerBuilder(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('SfDependencyInjectionBridge\\ContainerBuilder');
    }
}
