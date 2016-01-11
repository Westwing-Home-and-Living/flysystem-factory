<?php

namespace Westwing\Filesystem\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml as YamlParser;

class Yaml extends FileLoader
{
    /**
     * Loads a resource.
     *
     * @param mixed       $resource The resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return array
     * @throws \Exception If something went wrong
     */
    public function load($resource, $type = null)
    {
        $config = $this->parseYaml($resource);

        return $config;
    }

    /**
     * Parse yaml content|file
     *
     * @param string|mixed $resource
     *
     * @return array
     */
    protected function parseYaml($resource)
    {
        return YamlParser::parse($this->loadResourceData($resource));
    }

    /**
     * Load resource data
     *
     * @param string $resource Resource filename
     *
     * @return string
     */
    protected function loadResourceData($resource)
    {
        return file_get_contents($resource);
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed       $resource A resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return preg_match('/\.ya?ml$/i', $resource);
    }
}

