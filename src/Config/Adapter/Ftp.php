<?php

namespace Westwing\Filesystem\Config\Adapter;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Ftp extends AbstractConfig
{
    const INDEX_HOST                   = 'host';

    const INDEX_PORT                   = 'port';

    const INDEX_USERNAME               = 'username';

    const INDEX_PASSWORD               = 'password';

    const INDEX_SSL                    = 'ssl';

    const INDEX_TIMEOUT                = 'timeout';

    const INDEX_ROOT                   = 'permPrivate';

    const INDEX_PERM_PRIVATE           = 'permPrivate';

    const INDEX_PERM_PUBLIC            = 'permPublic';

    const INDEX_PASSIVE                = 'passive';

    const INDEX_TRANSFER_MODE          = 'transferMode';

    const INDEX_IGNORE_PASSIVE_ADDRESS = 'ignorePassiveAddress';

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
                ->integerNode(self::INDEX_PORT)
                ->end()
                ->scalarNode(self::INDEX_USERNAME)
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(self::INDEX_PASSWORD)
                ->end()
                ->booleanNode(self::INDEX_SSL)
                ->end()
                ->integerNode(self::INDEX_TIMEOUT)
                ->end()
                ->scalarNode(self::INDEX_ROOT)
                ->end()
                ->integerNode(self::INDEX_PERM_PRIVATE)
                ->end()
                ->integerNode(self::INDEX_PERM_PUBLIC)
                ->end()
                ->booleanNode(self::INDEX_PASSIVE)
                ->end()
                ->integerNode(self::INDEX_TRANSFER_MODE)
                ->end()
                ->booleanNode(self::INDEX_IGNORE_PASSIVE_ADDRESS)
                ->end()
            ->end();

        return $node;
    }
}
