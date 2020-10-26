<?php


namespace Beehplus\BankAPIHub\Adapter\CCB;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ServerConfiguration implements ConfigurationInterface {
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder('ccb');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('url')
                    ->isRequired()
                ->end()
                ->scalarNode('des_key')
                    ->isRequired()
                ->end()
                ->scalarNode('md5_key')
                    ->isRequired()
                ->end()
                ->scalarNode('third_sys_id')
                    ->isRequired()
                ->end()
            ->end();

        return $treeBuilder;
    }

}