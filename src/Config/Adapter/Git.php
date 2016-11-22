<?php

namespace Westwing\Filesystem\Config\Adapter;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Git extends AbstractConfig
{
    const INDEX_ENDPOINT = 'endpoint';

    const INDEX_REMOTE   = 'remote';

    const INDEX_USERNAME = 'username';

    const INDEX_USEREMAIL = 'useremail';

    const INDEX_PUSH = 'push';

    const INDEX_PULL = 'pull';

    /**
     * Gets the adapter specific config builder
     *
     * @author Shadi Akiki <shadiakiki1986@gmail.com>
     *
     * @return ArrayNodeDefinition|NodeDefinition
     */
    public function getAdapterConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node        = $treeBuilder->root($this->getAdapterName());

        $node
            ->children()
                ->scalarNode(self::INDEX_ENDPOINT)
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(self::INDEX_REMOTE)
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(self::INDEX_USERNAME)
                ->end()
                ->scalarNode(self::INDEX_USEREMAIL)
                ->end()
                ->scalarNode(self::INDEX_PUSH)
                ->end()
                ->scalarNode(self::INDEX_PULL)
                ->end()
            ->end()
        ;

        return $node;
    }
}
