<?php

namespace Beehplus\BankAPIHub\Tests\Adapter\PingAn\Payload;

use Beehplus\BankAPIHub\Adapter\PingAn\Payload\TranInfoParameters;
use Beehplus\BankAPIHub\Adapter\PingAn\Payload\TranInfoQuery;
use PHPUnit\Framework\TestCase;

class TranInfoQueryTest extends TestCase {

    public function testSetParameters() {
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
        $params = $query->getParameters();
        $array = $params->values();

        $this->assertEquals('100160', $array['BussTypeNo']);
        $this->assertEquals('', $array['BankSeqNo']);
        $this->assertEquals('Q000400269', $array['CorpAgreementNo']);
        $this->assertEquals('20180517', $array['EndDate']);
        $this->assertEquals('H222852018051712345678', $array['RequestSeqNo']);
        $this->assertEquals('', $array['PerPageNum']);
        $this->assertEquals('', $array['PageNum']);
        $this->assertEquals('20180517', $array['StartDate']);

        // Todo test parameter exception
    }

    public function testConstructor() {
        $query = new TranInfoQuery(new TranInfoParameters());
        $this->assertEquals('TranInfoQuery', $query->getName());

        $params = $query->getParameters();

        $paramsArray = $params->values();
        $this->assertEquals('', $paramsArray['acctNo']);
    }
}
