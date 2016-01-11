<?php

namespace Westwing\Filesystem\Adapter;

abstract class AbstractAdapter implements AdapterInterface
{
    const ADAPTER_NAMESPACE_TEMPLATE = '\\League\\Flysystem\\Adapter\\%s';

    /**
     * @inheritdoc
     */
    abstract public function make($config);

    /**
     * Returns the full adapter class name (with namespace).
     *
     * @author Josemi Liébana <josemi.liebana@westwing.de>
     *
     * @param string $adapterClassName The adapter classname
     *
     * @return string The namespaced class name
     */
    protected function getAdapterClassName($adapterClassName)
    {
        $adapterClassName = str_replace(__NAMESPACE__, '', $adapterClassName);
        $adapterClassName = str_replace('\\', '', $adapterClassName);
        $adapterClassName = sprintf(self::ADAPTER_NAMESPACE_TEMPLATE, $adapterClassName);

        return $adapterClassName;
    }
}
