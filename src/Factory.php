<?php

namespace Westwing\Filesystem;

use Westwing\Filesystem\Adapter\AdapterInterface;
use Westwing\Filesystem\Config\Loader;
use Westwing\Filesystem\Config\Adapter\AbstractConfig as Config;
use League\Flysystem\Exception;
use League\Flysystem\Filesystem;

class Factory
{
    const ERROR_TEMPLATE_NO_ADAPTER_IMPLEMENTATION = 'There is no factory implementation for the adapter %s';
    const ERROR_TEMPLATE_ADAPTER_MUST_IMPLEMENT    = 'The factory implementation for the adapter %s must implement %s';

    const ERROR_CONFIG_AND_CONFIG_FILE_NOT_SET = 'Either the config or the config file must be set.';
    const ERROR_BAD_CONFIG                     = 'Wrong configuration';

    /**
     * The name of the adapter to be created
     *
     * @var string
     */
    protected $adapterType;

    /**
     * The configuration array
     *
     * @var array
     */
    protected $config = array();

    /**
     * Path to the configuration file
     *
     * @var string
     */
    protected $configFile;

    /**
     * The Config Loader
     *
     * @var Loader
     */
    protected $loader;

    public function __construct()
    {
        $this->loader = new Loader();
    }

    /**
     * Gets the Config Loader
     *
     * @return Loader
     */
    protected function getLoader()
    {
        return $this->loader;
    }

    /**
     * Sets the configuration
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param array $config The configuration array
     *
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Sets the configuration file
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param string $configFile Path to the configuration file
     *
     * @return $this
     */
    public function setConfigFile($configFile)
    {
        $this->configFile = $configFile;

        return $this;
    }

    /**
     * Returns an instance of Filesystem using the adapter specified by $adapterName.
     *
     * If the config array and the configFile are both set,
     * the config will take precedence over the configFile and the later will be ignored.
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param string $adapterName The name of the adapter to use
     *
     * @throws Exception
     *
     * @return Filesystem
     */
    public function get($adapterName)
    {
        if (empty($this->config) && empty($this->configFile)) {
            throw new Exception(self::ERROR_CONFIG_AND_CONFIG_FILE_NOT_SET);
        }

        if (empty($this->config)) {
            $this->config = $this->getLoader()->load($this->configFile);
        }
        
        if (empty($this->config[Config::INDEX_FILESYSTEM][Config::INDEX_ADAPTER][$adapterName][Config::INDEX_TYPE])) {
            throw new Exception(self::ERROR_BAD_CONFIG);
        }

        $adapterType = $this->config[Config::INDEX_FILESYSTEM][Config::INDEX_ADAPTER][$adapterName][Config::INDEX_TYPE];
        $this->setAdapterType($adapterType);

        $adapterFactory = $this->getAdapterFactory($adapterType);

        $processedConfiguration = $this->getLoader()->process($adapterName, $this->config);
        $adapterConfiguration   = $processedConfiguration[Config::INDEX_ADAPTER][$adapterName];
        $adapter                = $adapterFactory->make($adapterConfiguration);
        $fileSystem             = new Filesystem($adapter);

        return $fileSystem;
    }

    /**
     * Sets the adapter type in the Factory class as well as in the Loader class
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param string $adapterType The adapter name to be created
     */
    protected function setAdapterType($adapterType)
    {
        $this->adapterType = $adapterType;

        $this->getLoader()->setAdapterName($adapterType);
    }

    /**
     * Returns the Adapter Factory
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param string $adapterType The adapter type
     *
     * @throws Exception
     *
     * @return AdapterInterface
     */
    protected function getAdapterFactory($adapterType)
    {
        $adapterFactoryClassName = __NAMESPACE__ . '\\Adapter\\' . $adapterType;

        if (!class_exists($adapterFactoryClassName)) {
            throw new Exception(sprintf(self::ERROR_TEMPLATE_NO_ADAPTER_IMPLEMENTATION, $adapterType));
        }

        /** @var AdapterInterface $adapterFactory */
        $adapterFactory = new $adapterFactoryClassName();
        if (!$adapterFactory instanceof AdapterInterface) {
            throw new Exception(sprintf(self::ERROR_TEMPLATE_ADAPTER_MUST_IMPLEMENT, $adapterType, 'AdapterInterface'));
        }

        return $adapterFactory;
    }
}
