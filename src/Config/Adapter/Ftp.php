<?php

namespace Westwing\Filesystem\Config\Adapter;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Ftp extends AbstractConfig
{
    const INDEX_HOST                   = 'host';
    const INDEX_USERNAME               = 'username';
    const INDEX_PASSWORD               = 'password';
    const INDEX_PORT                   = 'port';
    const INDEX_ROOT                   = 'root';
    const INDEX_SSL                    = 'ssl';
    const INDEX_TIMEOUT                = 'timeout';
    const INDEX_PERM_PRIVATE           = 'permPrivate';
    const INDEX_PERM_PUBLIC            = 'permPublic';
    const INDEX_PASSIVE                = 'passive';
    const INDEX_TRANSFER_MODE          = 'transferMode';
    const INDEX_SYSTEM_TYPE            = 'systemType';
    const INDEX_IGNORE_PASSIVE_ADDRESS = 'ignorePassiveAddress';

    /**
     * Gets the adapter specific config builder
     *
     * @author Damian Gręda <damian.greda@westwing.de>
     *
     * @return ArrayNodeDefinition|NodeDefinition
     */
    public function getAdapterConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node        = $treeBuilder->root($this->getAdapterName());

        $node
            ->children()
                ->scalarNode(self::INDEX_HOST)
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(self::INDEX_USERNAME)
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(self::INDEX_PASSWORD)
                    ->isRequired()
                ->end()
                ->scalarNode(self::INDEX_PORT)
                ->end()
                ->scalarNode(self::INDEX_ROOT)
                ->end()
                ->scalarNode(self::INDEX_SSL)
                ->end()
                ->scalarNode(self::INDEX_TIMEOUT)
                ->end()
                ->scalarNode(self::INDEX_PERM_PRIVATE)
                ->end()
                ->scalarNode(self::INDEX_PERM_PUBLIC)
                ->end()
                ->scalarNode(self::INDEX_PASSIVE)
                ->end()
                ->scalarNode(self::INDEX_TRANSFER_MODE)
                ->end()
                ->scalarNode(self::INDEX_SYSTEM_TYPE)
                ->end()
                ->scalarNode(self::INDEX_IGNORE_PASSIVE_ADDRESS)
                ->end()
            ->end()
        ;

        return $node;
    }
}
