<?php


namespace Beehplus\BankAPIHub\Base\Pay;


interface PayMethodInterface {
    public function getTransactionId($third_sys_id,$orderId): string;
}