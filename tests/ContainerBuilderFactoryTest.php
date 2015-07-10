<?php
namespace SfDependencyInjectionBridgeTest;

use SfDependencyInjectionBridge\ContainerBuilderFactory;
use SfDependencyInjectionBridge\ModuleOptions;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContainerBuilderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createService_ShouldReturnInstanceOfContainerBuilder()
    {
        $serviceLocator = $this->getServiceLocator();
        $serviceLocator
            ->method('get')
            ->with(ModuleOptions::class)
            ->willReturn(new ModuleOptions());

        $this->assertInstanceOf(
            ContainerBuilder::class,
            $this->getContainerBuilder($serviceLocator)
        );
    }

    /**
     * @test
     */
    public function createService_WithExistingService_ShouldGetTheServiceSetted()
    {
        $sfServiceName = 'ServiceTest';
        $zfServiceName = 'ServiceTestInServiceLocator';
        $moduleOptions = new ModuleOptions([
            'service_locator_mapping' => [
                $sfServiceName => $zfServiceName,
            ],
        ]);

        $serviceString  = 'This is a test service in the service locator';
        $serviceLocator = $this->getServiceLocator();
        $serviceLocator
            ->method('get')
            ->will($this->returnValueMap([
                [ModuleOptions::class, $moduleOptions],
                [$zfServiceName, $serviceString]
            ]));

        $this->assertSame(
            $serviceString,
            $this->getContainerBuilder($serviceLocator)->get($sfServiceName)
        );
    }

    private function getServiceLocator()
    {
        return $this->getMock(ServiceLocatorInterface::class);
    }

    private function getContainerBuilder(ServiceLocatorInterface $serviceLocator)
    {
        $containerBuilderFactory = new ContainerBuilderFactory();
        return $containerBuilderFactory->createService($serviceLocator);
    }
}
