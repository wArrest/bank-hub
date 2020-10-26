<?php


namespace Beehplus\BankAPIHub\Adapter\CCB;


use Beehplus\BankAPIHub\Base\Pay\BasePayResult;
use Beehplus\BankAPIHub\Base\Pay\RefundBaseAdapter;
use Beehplus\BankAPIHub\Base\Pay\RefundOrderInterface;
use Beehplus\BankAPIHub\Base\Result\CCB\RedirectRefundOrderForm;

class RefundAdapter extends RefundBaseAdapter {
    public function setRefundOrder(): RefundOrderInterface {
    }

    public function postRefundOrder(RefundOrderInterface $refundOrder, int $type) {
        
    }
}