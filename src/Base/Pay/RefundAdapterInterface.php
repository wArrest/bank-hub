<?php


namespace Beehplus\BankAPIHub\Base\Pay;


interface RefundAdapterInterface {
    /**
     * @return RefundOrderInterface
     */
    public function setRefundOrder():RefundOrderInterface;

    /**
     * @return mixed
     */
    public function postRefundOrder(RefundOrderInterface $refundOrder,int $type);
}