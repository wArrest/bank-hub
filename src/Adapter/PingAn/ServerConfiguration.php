<?php


namespace Beehplus\BankAPIHub\Adapter\PingAn;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;

class ServerConfiguration implements ConfigurationInterface {

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
        $treeBuilder = new TreeBuilder('pingan_server');

        $rootNode = $treeBuilder->getRootNode();

        $fileLocateCallback = function ($v) {
            $path = $this->fileLocator->locate($v, null, true);
            return $path;
        };

        $rootNode
            ->children()
                ->scalarNode('url')
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
                ->scalarNode('client_password')
                    ->isRequired()
                ->end()
                ->arrayNode('fix_param')
                    ->children()
                        ->scalarNode('api_version_no')->defaultValue('1.1.1')->end()
                        ->scalarNode('application_id')->isRequired()->end()
                        ->scalarNode('request_mode')->defaultValue('json')->end()
                        ->scalarNode('sdk_type')->defaultValue('api')->end()
                        ->scalarNode('sdk_seid')->defaultValue('4984hq-pad39401')->end()
                        ->scalarNode('sdk_version_no')->defaultValue('1.1.1')->end()
                        ->scalarNode('tran_status')->defaultValue('0')->end()
                        ->scalarNode('txn_time')->isRequired()->end()
                        ->scalarNode('valid_term')->isRequired()->end()
                ->end();

        return $treeBuilder;
    }
}