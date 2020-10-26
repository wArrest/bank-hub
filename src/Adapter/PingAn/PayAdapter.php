<?php


namespace Beehplus\BankAPIHub\Adapter\PingAn;

use Beehplus\BankAPIHub\Base\Pay\PayBaseAdapter;
use Beehplus\BankAPIHub\Base\Pay\RefundOrder;
use Beehplus\BankAPIHub\Base\Pay\RefundOrderNotify;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderInterface;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderNotify;

class PayAdapter extends PayBaseAdapter {

    /**
     * 设置当前要处理的UnifiedOrder
     *
     * @param UnifiedOrderInterface $order
     * @return UnifiedOrderInterface
     */
    public function setUnifiedOrder(UnifiedOrderInterface $order): UnifiedOrderInterface {
        // TODO: Implement setUnifiedOrder() method.
    }

    /**
     * 把当前的UnifiedOrder提交到第三方服务，并返回相应的结果
     *
     * @param UnifiedOrderInterface $order
     * @param int $type
     * @return \Beehplus\BankAPIHub\Base\Pay\PayResultInterface
     */
    public function postUnifiedOrder(UnifiedOrderInterface $order, int $type): \Beehplus\BankAPIHub\Base\Pay\PayResultInterface {
        // TODO: Implement postUnifiedOrder() method.
    }

    /**
     * 设置当前要处理的RefundOrder
     *
     * @param RefundOrder $order
     * @return RefundOrder
     */
    public function setRefundOrder(RefundOrder $order): RefundOrder {
        // TODO: Implement setRefundOrder() method.
    }

    /**
     * 帮当前要处理的RefundOrder提交到第三方服务，并返回相应的结果
     * @param RefundOrder $refundOrder
     * @return bool
     */
    public function postRefundOrder(RefundOrder $refundOrder): bool {
        // TODO: Implement postRefundOrder() method.
    }

    /**
     * 处理支付异步返回结果
     *
     * @param UnifiedOrderNotify $unifiedOrderNotify
     * @return bool
     */
    public function unifiedOrderNotifyProcess(UnifiedOrderNotify $unifiedOrderNotify): bool {
        // TODO: Implement unifiedOrderNotifyProcess() method.
    }

    /**
     * 处理退款的异步返回结果
     *
     * @param RefundOrderNotify $refundOrderNotify
     * @return bool
     */
    public function refundOrderNotifyProcess(RefundOrderNotify $refundOrderNotify): bool {
        // TODO: Implement refundOrderNotifyProcess() method.
    }
}