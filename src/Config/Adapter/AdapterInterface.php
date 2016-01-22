<?php

namespace Westwing\Filesystem\Config\Adapter;

interface AdapterInterface
{
    const INDEX_FILESYSTEM      = 'Filesystem';
    const INDEX_ADAPTER         = 'adapter';
    const INDEX_TYPE            = 'type';
    const INDEX_DEFAULT_ADAPTER = 'default';

    /**
     * Gets the adapter specific config builder
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @return TreeBuilder
     */
    public function getAdapterConfigTreeBuilder();

    /**
     * Sets the adapter config class name
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param string $className The name of the class
     */
    public function setAdapterName($className);

    /**
     * Gets the adapter name
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @return string $adapterName The name of the adapter
     */
    public function getAdapterName();
}
