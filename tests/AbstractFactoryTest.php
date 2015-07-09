<?php
namespace SfDependencyInjectionBridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zend\ServiceManager\ServiceLocatorInterface;

class AbstractFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canCreateServiceWithName_WithServiceThatExists_ShouldReturnTrue()
    {
        $anyRequestedName = 'any requested name';
        $containerBuilder = $this->getContainerBuilder();
        $containerBuilder
            ->method('has')
            ->with($anyRequestedName)
            ->will($this->returnValue(true));

        $serviceLocator = $this->getServiceLocatorWithContainerBuilder($containerBuilder);

        $abstractFactory = new AbstractFactory();

        $this->assertTrue($abstractFactory->canCreateServiceWithName($serviceLocator, 'any name', $anyRequestedName));
    }

    /**
     * @test
     */
    public function canCreateServiceWithName_WithServiceThatDoesNotExists_ShouldReturnFalse()
    {
        $containerBuilder = $this->getContainerBuilder();
        $containerBuilder
            ->method('has')
            ->will($this->returnValue(false));

        $serviceLocator = $this->getServiceLocatorWithContainerBuilder($containerBuilder);

        $abstractFactory = new AbstractFactory();

        $this->assertFalse($abstractFactory->canCreateServiceWithName($serviceLocator, 'any name', 'any requested name'));
    }

    /**
     * @test
     */
    public function createServiceWithName_WithServiceThatExists_ShouldReturnThatService()
    {
        $anyService       = 'My Any Service is a String here';
        $containerBuilder = $this->getContainerBuilder();
        $containerBuilder
            ->method('get')
            ->will($this->returnValue($anyService));

        $serviceLocator = $this->getServiceLocatorWithContainerBuilder($containerBuilder);

        $abstractFactory = new AbstractFactory();

        $this->assertSame(
            $anyService,
            $abstractFactory->createServiceWithName($serviceLocator, 'any name', $anyService)
        );
    }

    private function getContainerBuilder()
    {
        return $this->getMock(ContainerBuilder::class);
    }

    private function getServiceLocatorWithContainerBuilder(ContainerBuilder $containerBuilder)
    {
        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);
        $serviceLocator
            ->method('get')
            ->with('SfDependencyInjectionBridge\\ContainerBuilder')
            ->will($this->returnValue($containerBuilder));
        return $serviceLocator;
    }
}
