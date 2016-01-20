<?php

namespace Westwing\Filesystem\Config\Adapter;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class AwsS3 extends AbstractConfig
{
    const INDEX_CREDENTIALS = 'credentials';

    const INDEX_KEY         = 'key';

    const INDEX_SECRET      = 'secret';

    const INDEX_REGION      = 'region';

    const INDEX_BUCKET      = 'bucket';

    const INDEX_VERSION     = 'version';

    const INDEX_PREFIX      = 'prefix';

    const INDEX_OPTIONS     = 'options';

    const DEFAULT_VERSION   = 'latest';

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
                ->scalarNode(self::INDEX_KEY)
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(self::INDEX_SECRET)
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(self::INDEX_REGION)
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(self::INDEX_BUCKET)
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(self::INDEX_VERSION)
                    ->defaultValue(self::DEFAULT_VERSION)
                ->end()
                ->scalarNode(self::INDEX_PREFIX)
                ->end()
                ->arrayNode(self::INDEX_OPTIONS)
                ->end()
            ->end()
        ;

        return $node;
    }
}
