<?php
namespace Cdx\SfDependencyInjectionBridge;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $serviceLocatorMapping = [];

    /**
     * @var array
     */
    protected $configFiles = [];

    /**
     * @param array $mapping
     */
    public function setServiceLocatorMapping(array $mapping = [])
    {
        $this->serviceLocatorMapping = $mapping;
    }

    /**
     * @return array
     */
    public function getServiceLocatorMapping()
    {
        return $this->serviceLocatorMapping;
    }

    /**
     * @param array $files
     */
    public function setConfigFiles(array $files = [])
    {
        $this->configFiles = $files;
    }

    /**
     * @return array
     */
    public function getConfigFiles()
    {
        return $this->configFiles;
    }
}
