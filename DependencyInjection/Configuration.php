<?php

namespace HappyR\ExcerptBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode=$treeBuilder->root('happy_r_excerpt');

        $rootNode
            ->children()
                ->scalarNode('tail')->defaultValue('…')->end()
                ->integerNode('length')->defaultValue(300)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
