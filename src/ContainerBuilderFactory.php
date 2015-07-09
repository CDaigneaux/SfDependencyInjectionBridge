<?php
namespace SfDependencyInjectionBridge;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\FileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContainerBuilderFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $container = new ContainerBuilder();
        $loader    = new YamlFileLoader($container, new FileLocator());

        $moduleManager = $serviceLocator->get('ModuleManager');

        foreach ($moduleManager->getLoadedModules() as $module) {
            $config = $this->loadModuleConfig($module);

            $this->loadServiceLocatorConfig($container, $serviceLocator, $config['service-locator']);
            $this->loadYamlConfigFiles($loader, $config['config-files']);
        }

        return $container;
    }

    private function loadModuleConfig($module)
    {
        $moduleConfig = $module->getConfig();

        $config = [];
        if (isset($moduleConfig['sf-dependency-injection'])
            && is_array($moduleConfig['sf-dependency-injection'])
        ) {
            $config = $moduleConfig['sf-dependency-injection'];
        }

        if (!isset($config['service-locator']) || !is_array($config['service-locator'])) {
            $config['service-locator'] = [];
        }
        if (!isset($config['config-files']) || !is_array($config['config-files'])) {
            $config['config-files'] = [];
        }

        return $config;
    }

    private function loadServiceLocatorConfig(
        ContainerBuilder $container,
        ServiceLocatorInterface $serviceLocator,
        array $services
    ) {
        foreach ($services as $name => $service) {
            $container->set($name, $serviceLocator->get($service));
        }
    }

    private function loadYamlConfigFiles(FileLoader $loader, array $files)
    {
        foreach ($files as $file) {
            $loader->load($file);
        }
    }
}
