<?php


namespace Beehplus\BankAPIHub\Adapter\PingAn;


use Beehplus\BankAPIHub\BankApiProxy;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderInterface;
use Beehplus\BankAPIHub\Base\ProxyFactoryInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class ProxyFactory implements ProxyFactoryInterface {
    /**
     * @return QueryAdapter
     */
    public function queryAdapterBuild() {
        $resourcesDirectory = [__DIR__ . '/../../../resources'];

        $fileLoader = new FileLocator($resourcesDirectory);


        $yamlFile = $fileLoader->locate('config.yaml', null, true);

        $configValues = Yaml::parse(file_get_contents($yamlFile));

        $processor = new Processor();
        $paopClientConfiguration = new PaopClientConfiguration($fileLoader);
        $serverConfiguration = new ServerConfiguration($fileLoader);
        $processedPaopClientConfiguration = $processor->processConfiguration(
            $paopClientConfiguration,
            [$configValues['pingan_paop_client']]
        );
        $processedServerConfiguration = $processor->processConfiguration(
            $serverConfiguration,
            [$configValues['pingan_server']]
        );

        $paopClient = new PaopClient($processedPaopClientConfiguration);
        $server = new Server($processedServerConfiguration);

        return new QueryAdapter($paopClient, $server);
    }

    /**
     * @return BankApiProxy
     */
    public function build(): BankApiProxy {
        return new BankApiProxy(new PayAdapter(),new AccountAdapter(), $this->queryAdapterBuild());
    }

    /**
     * @return UnifiedOrderInterface
     */
    public function unifiedOrderBuild(): UnifiedOrderInterface {
        // TODO: Implement unifiedOrderBuild() method.
    }
}