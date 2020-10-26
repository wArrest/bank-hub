<?php


namespace Beehplus\BankAPIHub\Base\Pay;

interface UnifiedOrderNotifyInterface {
    public function getTxCode();

    public function getTransID();

    public function getRemoteOrderNo();

    public function getOrderId();

    public function getData();
}