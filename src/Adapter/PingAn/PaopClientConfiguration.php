<?php


namespace Beehplus\BankAPIHub\Adapter\PingAn;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;

class PaopClientConfiguration implements ConfigurationInterface {

    /**
     * @var FileLocator
     */
    private $fileLocator;

    /**
     * PaopClientConfiguration constructor.
     * @param FileLocator $fileLocator
     */
    public function __construct(FileLocator $fileLocator) {
        $this->fileLocator = $fileLocator;
    }

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder('pingan_paop_client');

        $rootNode = $treeBuilder->getRootNode();

        $fileLocateCallback = function ($v) {
            $path = $this->fileLocator->locate($v, null, true);
            return $path;
        };

        $rootNode
            ->children()
                ->scalarNode('app_id')
                    ->isRequired()
                ->end()
                ->scalarNode('public_url')
                    ->isRequired()
                ->end()
                ->scalarNode('key_path')
                    ->beforeNormalization()
                        ->ifString()
                        ->then($fileLocateCallback)
                    ->end()
                    ->isRequired()
                ->end()
                ->scalarNode('public_key_path')
                    ->beforeNormalization()
                        ->ifString()
                        ->then($fileLocateCallback)
                    ->end()
                    ->isRequired()
                ->end()
                ->scalarNode('type')
                    ->isRequired()
                ->end()
                ->scalarNode('client_password')
                    ->isRequired()
                ->end();

        return $treeBuilder;
    }
}