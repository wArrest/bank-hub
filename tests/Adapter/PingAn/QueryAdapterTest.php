<?php

namespace Beehplus\BankAPIHub\Tests\Adapter\PingAn;

use Beehplus\BankAPIHub\Adapter\PingAn\Payload\TranInfoParameters;
use Beehplus\BankAPIHub\Adapter\PingAn\Payload\TranInfoQuery;
use Beehplus\BankAPIHub\Adapter\PingAn\ProxyFactory;
use PHPUnit\Framework\TestCase;

class QueryAdapterTest extends TestCase {
    public function testQuery() {
        $queryAdapter = (new ProxyFactory())->queryAdapterBuild();

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

        $res = $queryAdapter->query($query);

        $data = $res->getBody()->getData();

        $this->assertNotEmpty($data['TranInfoArray'], 'TranInfoArray miss');
        $this->assertEquals($data['TranInfoArray'][0]['BussTypeNo'], '100160');
        $this->assertEquals($data['TranInfoArray'][0]['CorpSeqNo'], 'H222852018051712345678');
    }
}
