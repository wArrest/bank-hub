<?php


namespace Beehplus\BankAPIHub\Base\Pay;


interface RefundOrderInterface {
    public function getTxCode(): string;

    public function getTransactionId(): string;

    public function getSellerUserIDThirdSys(): string;

    public function getRemoteOrderNo(): string;

    public function getPayBackReason(): string ;

    public function getGetProduct(): int;

    public function getIntroduce(): string;

    public function getPayBackID(): string;

    public function getPayBackMoney(): float;

    public function getPayBackStatus(): string;

    public function getRemark(): string;
}