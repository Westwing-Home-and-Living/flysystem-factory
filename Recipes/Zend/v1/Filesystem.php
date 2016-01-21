<?php

use Westwing\Filesystem\Factory;
use Westwing\Filesystem\Config\Adapter\AbstractConfig as Config;

class Filesystem extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Creates the Filesystem based on the application.ini config and
     * sets it in the Zend_Registry with the "sharedFS" key.
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @throws Zend_Exception
     *
     * @throws \League\Flysystem\Exception
     */
    public function init()
    {
        /** @var Zend_Config $config */
        $config = Zend_Registry::get('config')->resources->Filesystem;
        /** @var array $config */
        $config = $config->toArray();

        if (empty($config[Config::INDEX_ADAPTER]) || !is_array($config[Config::INDEX_ADAPTER])) {
            throw new Exception(Factory::ERROR_BAD_CONFIG);
        }

        $fileSystemFactory = new Factory();
        $defaultAdapter    = $config[Config::INDEX_DEFAULT_ADAPTER];
        $adaptersConfig    = $config[Config::INDEX_ADAPTER];

        foreach ($adaptersConfig as $adapterName => $config) {
            $filesystemConfig = array(
                Config::INDEX_FILESYSTEM => array(
                    Config::INDEX_ADAPTER => array(
                        $adapterName => $config
                    )
                )
            );

            $fileSystemFactory->setConfig($filesystemConfig);

            $filesystem = $fileSystemFactory->get($adapterName);

            Zend_Registry::set($adapterName, $filesystem);

            if ($adapterName == $defaultAdapter) {
                Zend_Registry::set(Config::INDEX_DEFAULT_ADAPTER, $filesystem);
            }
        }
    }
}

