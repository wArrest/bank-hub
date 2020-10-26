<?php


namespace Beehplus\BankAPIHub\Adapter\CCB;


use App\Entity\Order;
use Beehplus\BankAPIHub\Adapter\CCB\utils\Crypt;
use Beehplus\BankAPIHub\BankApiProxy;
use Beehplus\BankAPIHub\Base\Pay\PayAdapterInterface;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderInterface;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderNotify;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderNotifyInterface;
use Beehplus\BankAPIHub\Base\ProxyFactoryInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;


class ProxyFactory implements ProxyFactoryInterface {

    /**
     * @return BankApiProxy
     */
    public function build(): BankApiProxy {
        // TODO: Implement build() method.
    }

    public function buildPayAdapter(): PayAdapterInterface {
        $resourcesDirectory = [__DIR__ . '/../../../resources'];

        $fileLoader = new FileLocator($resourcesDirectory);

        $yamlFile = $fileLoader->locate('config.yaml', null, true);

        $configValues = Yaml::parse(file_get_contents($yamlFile));

        $processor = new Processor();

        $configurate = new ServerConfiguration();

        $processedConfigurate = $processor->processConfiguration(
            $configurate,
            [$configValues['ccb']]
        );

        return new PayAdapter($processedConfigurate);
    }

    public function buildNotifyProcess(string $type, array $postData): UnifiedOrderNotifyInterface {
        //解密
        $notify = new UnifiedOrderNotify();
        $data = json_decode(Crypt::des_decrypt($postData['Data'], 'jj#^xw1S'), true);
        if ($type == Order::PAID ) {
            $notify->setTxCode($data['TxCode']);
            $notify->setRemark($data['Expand1']);
            $notify->setOrderId($data['OrderInfos'][0]['Order_No']);
            $notify->setRemoteOrderNo($data['OrderInfos'][0]['Order_No_CCB']);
            $notify->setPayStatus($data['OrderInfos'][0]['PayStatus']);
            $notify->setTransID($data['TransID']);
            $notify->setData(json_encode($data, JSON_UNESCAPED_UNICODE));
        } else {
            $notify->setRemoteOrderNo($data['Order_No_CCB']);
            $notify->setTransID($data['TransID']);
            $notify->setData(json_encode($data, JSON_UNESCAPED_UNICODE));
        }
        return $notify;

    }

    /**
     * @return UnifiedOrderInterface
     */
    public function unifiedOrderBuild(): UnifiedOrderInterface {
        return new CCBUnifiedOrder();
    }
}