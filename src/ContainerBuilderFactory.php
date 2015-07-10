<?php
namespace Cdx\SfDependencyInjectionBridge;

use Cdx\SfDependencyInjectionBridge\ModuleOptions;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContainerBuilderFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $container  = new ContainerBuilder();
        $fileLoader = $this->createFileLoader($container);

        /* @var $moduleOptions ModuleOptions */
        $moduleOptions = $serviceLocator->get(ModuleOptions::class);

        $this->loadServiceLocatorConfig(
            $container,
            $serviceLocator,
            $moduleOptions->getServiceLocatorMapping()
        );

        $this->loadConfigFiles($fileLoader, $moduleOptions->getConfigFiles());

        return $container;
    }

    private function createFileLoader(ContainerBuilder $container)
    {
        $locator = new FileLocator();

        $loaderResolver = new LoaderResolver([
            new XmlFileLoader($container, $locator),
            new YamlFileLoader($container, $locator),
        ]);

        return new DelegatingLoader($loaderResolver);
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

    private function loadConfigFiles(Loader $loader, array $files)
    {
        foreach ($files as $file) {
            $loader->load($file);
        }
    }
}
