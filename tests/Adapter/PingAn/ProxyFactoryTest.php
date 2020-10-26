<?php

namespace Beehplus\BankAPIHub\Tests\Adapter\PingAn;

use Beehplus\BankAPIHub\Adapter\PingAn\Payload\TranInfoParameters;
use Beehplus\BankAPIHub\Adapter\PingAn\Payload\TranInfoQuery;
use Beehplus\BankAPIHub\Adapter\PingAn\ProxyFactory;
use PHPUnit\Framework\TestCase;

class ProxyFactoryTest extends TestCase {
    public function testBuild() {
        // pingan proxy factory
        $factory = new ProxyFactory();
        $proxy = $factory->build();

        $this->assertIsObject($proxy, 'proxy is not a object');
    }

    public function testQueryByProxy() {
        $factory = new ProxyFactory();
        $proxy = $factory->build();

        $params = new TranInfoParameters();
        $params->acctNo = '';
        $params->bussTypeNo = '100160';
        $params->bankSeqNo = '';
        $params->corpAgreementNo = 'Q000400269';
        $params->endDate = '20180517';
        $params->requestSeqNo = 'H222852018051712345678';
        $params->perPageNum = '';
        $params->pageNum = '';
        $params->startDate = '20180517';

        $query = new TranInfoQuery($params);

        $res = $proxy->query($query);

        $data = $res->getBody()->getData();

        $this->assertNotEmpty($data['TranInfoArray'], 'TranInfoArray miss');
        $this->assertEquals($data['TranInfoArray'][0]['BussTypeNo'], '100160');
        $this->assertEquals($data['TranInfoArray'][0]['CorpSeqNo'], 'H222852018051712345678');
    }
}
