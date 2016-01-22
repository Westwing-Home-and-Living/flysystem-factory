<?php

use Westwing\Filesystem\Config\Adapter\AbstractConfig as Config;
use Westwing\Filesystem\Factory;

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
        $config = Zend_Registry::get('config');

        if (!($config instanceof Zend_Config)) {
            throw new Exception(Factory::ERROR_CONFIG_AND_CONFIG_FILE_NOT_SET);
        }

        try {
            $config = $config->resources->Filesystem;
        } catch (Exception $e) {
            throw new Exception(Factory::ERROR_CONFIG_AND_CONFIG_FILE_NOT_SET);
        }

        $adapterIndex        = Config::INDEX_ADAPTER;
        $defaultAdapterIndex = Config::INDEX_DEFAULT_ADAPTER;

        /** @var array $config */
        $config = $config->toArray();

        if (empty($config[$adapterIndex]) || !is_array($config[$adapterIndex])) {
            throw new Exception(Factory::ERROR_BAD_CONFIG);
        }

        $defaultAdapter = (!empty($config[$defaultAdapterIndex]) ? $config[$defaultAdapterIndex] : null);

        $fileSystemFactory = new Factory();
        $adaptersConfig    = $config[$adapterIndex];

        foreach ($adaptersConfig as $adapterName => $config) {
            $filesystemConfig = array(
                Config::INDEX_FILESYSTEM => array(
                    $adapterIndex => array(
                        $adapterName => $config
                    )
                )
            );

            $fileSystemFactory->setConfig($filesystemConfig);

            $filesystem = $fileSystemFactory->get($adapterName);

            Zend_Registry::set($adapterName, $filesystem);

            if ($adapterName === $defaultAdapter) {
                Zend_Registry::set($defaultAdapterIndex, $filesystem);
            }
        }
    }
}

