<?php

use Westwing\Filesystem\Config\Loader;
use Westwing\Filesystem\Config\Adapter\AbstractConfig as Config;

class LoaderTests extends PHPUnit_Framework_TestCase
{
    protected $adapterName = 'localFS';
    protected $adapterType = 'Local';
    protected $configFile;

    /**
     * Set the config file
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     */
    protected function setUp()
    {
        $this->configFile = __DIR__ . '/../filesystem.yml';
    }

    /**
     * Test that the loader returns the right array when loading the provided config file
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     */
    public function testLoaderCanLoadFile()
    {
        $loader = new Loader();
        $config = $loader->load($this->configFile);

        $this->assertArrayHasKey(Config::INDEX_FILESYSTEM, $config);
        $this->assertArrayHasKey(Config::INDEX_ADAPTER, $config[Config::INDEX_FILESYSTEM]);
        $this->assertArrayHasKey($this->adapterName, $config[Config::INDEX_FILESYSTEM][Config::INDEX_ADAPTER]);
        $this->assertArrayHasKey(
            Config::INDEX_TYPE,
            $config[Config::INDEX_FILESYSTEM][Config::INDEX_ADAPTER][$this->adapterName]
        );
        $this->assertContains(
            $this->adapterType,
            $config[Config::INDEX_FILESYSTEM][Config::INDEX_ADAPTER][$this->adapterName][Config::INDEX_TYPE]
        );
    }

}