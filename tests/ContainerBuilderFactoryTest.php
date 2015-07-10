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
        $moduleManager = $this->getModuleManager();
        $moduleManager
            ->method('getLoadedModules')
            ->will($this->returnValue([]));
        
        $serviceLocator = $this->getServiceLocator();
        $serviceLocator
            ->method('get')
            ->with('ModuleManager')
            ->will($this->returnValue($moduleManager));

        $this->assertInstanceOf(ContainerBuilder::class, $this->getContainerBuilder($serviceLocator));
    }

    /**
     * @test
     */
    public function createService_WithExistingService_ShouldGetTheServiceSetted()
    {
        $module = $this->getModule([
            'sf-dependency-injection' => [
                'service-locator' => [
                    'ServiceTest' => 'ServiceTestInServiceLocator'
                ]
            ]
        ]);
        $moduleManager = $this->getModuleManager();
        $moduleManager
            ->method('getLoadedModules')
            ->will($this->returnValue([$module]));

        $serviceString  = 'This is a test service in the service locator';
        $serviceLocator = $this->getServiceLocator();
        $serviceLocator
            ->method('get')
            ->will($this->returnValueMap([
                ['ModuleManager', $moduleManager],
                ['ServiceTestInServiceLocator', $serviceString]
            ]));

        $this->assertSame($serviceString, $this->getContainerBuilder($serviceLocator)->get('ServiceTest'));
    }

    private function getModuleManager()
    {
        return $this->getMockBuilder(ModuleManager::class)
            ->disableOriginalConstructor()
            ->getMock();
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

    private function getModule(array $config)
    {
        $moduleTest = $this->getMock('Module', ['getConfig']);
        $moduleTest
            ->method('getConfig')
            ->will($this->returnValue($config));
        return $moduleTest;
    }
}
