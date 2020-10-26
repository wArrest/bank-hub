<?php


namespace Beehplus\BankAPIHub\Adapter\PingAn\Payload;


use Beehplus\BankAPIHub\Base\Query\Payload\Parameters;
use Beehplus\BankAPIHub\Base\Query\Payload\ParametersInterface;

class TranInfoParameters extends Parameters implements ParametersInterface {
    public $acctNo;
    public $bussTypeNo;
    public $bankSeqNo;
    public $corpAgreementNo;
    public $endDate;
    public $requestSeqNo;
    public $perPageNum;
    public $pageNum;
    public $startDate;

    public function values(): array {
        $values = parent::values();

        $newValues = [];
        foreach ($values as $k => $v) {
            $newValues[ucfirst($k)] = $v;
        }

        return $newValues;
    }
}