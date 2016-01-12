<?php

namespace Westwing\Filesystem\Config;

use Westwing\Filesystem\Config\Adapter\AdapterInterface;
use Westwing\Filesystem\Config\Loader\Yaml;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Exception\FileLoaderLoadException;

class Loader
{
    const ERROR_TEMPLATE_CLASS_DOESNT_EXISTS  = 'Config class for the adapter %s doesn\'t exist.';
    const ERROR_TEMPLATE_CLASS_MUST_IMPLEMENT = 'Config class for the adapter %s must implement %s';

    /**
     * The adapter name to validate
     *
     * @var string
     */
    protected $adapterName;

    /**
     * Gets the adapter name.
     *
     * @return string
     */
    public function getAdapterName()
    {
        return $this->adapterName;
    }

    /**
     * Sets the adapter name.
     *
     * @param string $adapterName The adapter name to validate
     */
    public function setAdapterName($adapterName)
    {
        $this->adapterName = $adapterName;
    }

    /**
     * Loads the configuration file
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param string $configFile
     *
     * @throws FileLoaderLoadException
     *
     * @return array The configuration
     */
    public function load($configFile)
    {
        $configDirectories = array(dirname($configFile));

        $locator        = new FileLocator($configDirectories);
        $loaderResolver = new LoaderResolver(
            array(
                new Yaml($locator),
            )
        );

        $delegatingLoader = new DelegatingLoader($loaderResolver);
        $config           = $delegatingLoader->load($configFile);

        return $config;
    }

    /**
     * Process and validates the configuration
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param string $adapterName The name of the adapter
     * @param array  $config      The configuration to validate
     *
     * @throws \Exception
     *
     * @return array The processed configuration
     */
    public function process($adapterName, array $config)
    {
        $className = $this->getAdapterConfigNamespace();
        if (!class_exists($className)) {
            throw new \Exception(sprintf(self::ERROR_TEMPLATE_CLASS_DONT_EXISTS, $this->getAdapterName()));
        }

        /** @var Config $configurationClass */
        $configurationClass = new $className();
        if (!$configurationClass instanceof AdapterInterface) {
            throw new \Exception(
                sprintf(self::ERROR_TEMPLATE_CLASS_MUST_EXTENDS, $this->getAdapterName(), 'AdapterInterface')
            );
        }

        $configurationClass->setAdapterName($adapterName);

        $configToValidate = array(
            AdapterInterface::INDEX_FILESYSTEM => array(
                AdapterInterface::INDEX_ADAPTER => array(
                    $adapterName => $config[AdapterInterface::INDEX_FILESYSTEM][AdapterInterface::INDEX_ADAPTER][$adapterName]
                )
            )
        );

        $processor       = new Processor();
        $configProcessed = $processor->processConfiguration($configurationClass, $configToValidate);

        return $configProcessed;
    }

    /**
     * Returns the correct namespace of the Adapter config classes
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @return string The Adapter Config namespace
     */
    protected function getAdapterConfigNamespace()
    {
        $adapterConfigNamespace = sprintf('%s\\Adapter\\%s', __NAMESPACE__, $this->getAdapterName());

        return $adapterConfigNamespace;
    }
}
