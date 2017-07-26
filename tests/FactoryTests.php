<?php

use Westwing\Filesystem;
use Westwing\Filesystem\Config\Adapter\AdapterInterface as Config;
use Westwing\Filesystem\Config\Adapter\Local;
use League\Flysystem\Exception;

class FactoryTests extends PHPUnit_Framework_TestCase
{
    protected $adapterName = 'localFS';
    protected $adapterType = 'Local';

    /**
     * Returns a valid configuration with a single adapter.
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @return array
     */
    protected function getValidSingleAdapterConfig()
    {
        return array(
            Config::INDEX_FILESYSTEM => array(
                Config::INDEX_ADAPTER => array(
                    $this->adapterName => array(
                        Config::INDEX_TYPE => $this->adapterType,
                        Local::INDEX_ROOT  => __DIR__,
                    )
                )
            )
        );
    }

    /**
     * Returns an array with wrong configurations with single adapter. (Data provider)
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     */
    public function getWrongSingleAdapterConfig()
    {
        $config1 = array(
            Config::INDEX_FILESYSTEM => array(
                Config::INDEX_ADAPTER => array(
                    $this->adapterName => array(
                        'typo' => $this->adapterType,
                    )
                )
            )
        );

        $config2 = array(
            Config::INDEX_FILESYSTEM => array(
                'adaptor' => array(
                    $this->adapterName => array(
                        Config::INDEX_TYPE => $this->adapterType,
                    )
                )
            )
        );

        $config3 =
            array(
            'Fieldsystem' => array(
                Config::INDEX_ADAPTER => array(
                    $this->adapterName => array(
                        Config::INDEX_TYPE => $this->adapterType,
                    )
                )
            )
        );

        return array(
            $config1,
            $config2,
            $config3,
        );
    }

    /**
     * Throws exception when no config array and no configFile are set in the factory
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @expectedException Exception
     */
    public function testFactoryThrowsExceptionWhenNoConfigAndNoConfigFileAreSet()
    {
        $filesystemFactory = new Filesystem\Factory();
        $filesystemFactory->get($this->adapterName);
    }

    /**
     * Throws exception when the configuration is invalid.
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @dataProvider getWrongSingleAdapterConfig
     *
     * @expectedException Exception
     *
     */
    public function testFactoryThrowsExceptionWithInvalidConfig($config)
    {
        $filesystemFactory = new Filesystem\Factory();

        $filesystemFactory->setConfig($config);
        $filesystemFactory->get($this->adapterName);
    }

    /**
     * Throws exception when the adapter specified by the 'type' index is not implemented
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @expectedException Exception
     */
    public function testFactoryThrowsExceptionWhenAdapterDoesNotExists()
    {
        $config = $this->getValidSingleAdapterConfig();

        unset($config[Config::INDEX_FILESYSTEM][Config::INDEX_ADAPTER]);

        $filesystemFactory = new Filesystem\Factory();
        $filesystemFactory->setConfig($config);
        $filesystemFactory->get($this->adapterName);
    }

    /**
     * Test that the factory can create a League\\filesystem object with the specifed Adapter
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @throws Exception
     */
    public function testFactoryWithConfigAndSingleLocalAdapter()
    {
        $filesystemFactory = new Filesystem\Factory();

        $filesystemFactory->setConfig($this->getValidSingleAdapterConfig());

        $filesystem = $filesystemFactory->get($this->adapterName);

        $this->assertInstanceOf('League\\Flysystem\\AdapterInterface', $filesystem->getAdapter());
        $this->assertInstanceOf('League\\Flysystem\\Filesystem', $filesystem);
    }
}
