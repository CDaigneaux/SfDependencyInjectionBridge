<?php
namespace SfDependencyInjectionBridgeTest;

use SfDependencyInjectionBridge\ContainerBuilderFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContainerBuilderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createService_ShouldReturnInstanceOfContainerBuilder()
    {
        $moduleManager = $this->getMockBuilder(ModuleManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $moduleManager
            ->method('getLoadedModules')
            ->will($this->returnValue([]));
        
        $serviceLocator = $this->getMock(ServiceLocatorInterface::class);
        $serviceLocator
            ->method('get')
            ->with('ModuleManager')
            ->will($this->returnValue($moduleManager));

        $containerBuilderFactory = new ContainerBuilderFactory();

        $this->assertInstanceOf(ContainerBuilder::class, $containerBuilderFactory->createService($serviceLocator));
    }
}