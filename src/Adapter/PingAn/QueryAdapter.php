<?php


namespace Beehplus\BankAPIHub\Adapter\PingAn;


use Beehplus\BankAPIHub\Base\Query\PayloadInterface;
use Beehplus\BankAPIHub\Base\Query\QueryBaseAdapter;

class QueryAdapter extends QueryBaseAdapter {

    /**
     * @var PaopClient
     */
    protected $paopClient;

    /**
     * @var Server
     */
    protected $apiServer;

    /**
     * QueryAdapter constructor.
     * @param PaopClient $paopClient
     * @param Server $apiServer
     */
    public function __construct(PaopClient $paopClient, Server $apiServer) {
        $this->paopClient = $paopClient;
        $this->apiServer = $apiServer;
    }

    /**
     * @param PayloadInterface $payload
     * @return PayloadInterface
     * @throws \Beehplus\BankAPIHub\Base\InvalidConfigException
     * @throws utils\HttpException
     */
    public function query(PayloadInterface $payload): PayloadInterface {
        $returnData = $this->paopClient->getToken();
        $result = $this->apiServer->execute($payload->getName(), $payload->getParameters()->values(), $returnData['appAccessToken']);
        $payload->fillBody($result);

        return $payload;
    }
}