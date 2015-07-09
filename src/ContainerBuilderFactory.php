<?php
namespace SfDependencyInjectionBridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContainerBuilderFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $container = new ContainerBuilder();

        $moduleManager = $serviceLocator->get('ModuleManager');
        foreach($moduleManager->getLoadedModules() as $module) {
            $config = $module->getConfig();
            if (isset($config['sf-dependency-injection'])) {
                $this->loadSfDependencyInjectionConfig($container, $serviceLocator, $config['sf-dependency-injection']);
            }
        }

        return $container;
    }

    private function loadSfDependencyInjectionConfig(
        ContainerBuilder $container,
        ServiceLocatorInterface $serviceLocator,
        array $config
    )
    {
        if (isset($config['service-locator']) && is_array($config['service-locator'])) {
            $this->loadServiceLocatorConfig($container, $serviceLocator, $config['service-locator']);
        }
        if (isset($config['config-files']) && is_array($config['config-files'])) {
            $this->loadYamlConfigFiles($container, $config['config-files']);
        }
    }

    private function loadServiceLocatorConfig(
        ContainerBuilder $container,
        ServiceLocatorInterface $serviceLocator,
        array $services
    )
    {
        foreach($services as $id => $service) {
            $container->set($id, $serviceLocator->get($service));
        }
    }

    private function loadYamlConfigFiles(ContainerBuilder $container, array $files)
    {
        $loader = new YamlFileLoader($container, new FileLocator());
        foreach($files as $file) {
            $loader->load($file);
        }
    }
}