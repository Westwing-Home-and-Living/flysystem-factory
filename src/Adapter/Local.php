<?php

namespace Westwing\Filesystem\Adapter;

use Westwing\Filesystem\Config\Adapter\Local as Config;

class Local extends AbstractAdapter
{
    /**
     * Creates and return a new instance of the adapter.
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param array $config The configuration array
     *
     * @return \League\Flysystem\Adapter\Local
     */
    public function make($config)
    {
        $className = $this->getAdapterClassName(__CLASS__);
        $adapter   = new $className($config[Config::INDEX_ROOT]);

        return $adapter;
    }
}

