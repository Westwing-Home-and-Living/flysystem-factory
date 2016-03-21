<?php

namespace Westwing\Filesystem\Adapter;

class Ftp extends AbstractAdapter
{
    /**
     * Creates and return a new instance of the Ftp adapter.
     *
     * @author Damian Gręda <damian.greda@westwing.de>
     *
     * @param array $config The configuration array
     *
     * @return \League\Flysystem\Adapter\Ftp
     */
    public function make($config)
    {
        $className = $this->getAdapterClassName(__CLASS__);
        $adapter   = new $className($config);

        return $adapter;
    }
}

