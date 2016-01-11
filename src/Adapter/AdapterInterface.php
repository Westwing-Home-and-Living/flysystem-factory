<?php

namespace Westwing\Filesystem\Adapter;

interface AdapterInterface
{
    /**
     * Creates and return a new instance of the adapter.
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param array $config The configuration array
     *
     * @return \\League\Flysystem\AdapterInterface
     */
    public function make($config);
}
