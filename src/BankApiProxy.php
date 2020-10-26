<?php


namespace Beehplus\BankAPIHub;


use Beehplus\BankAPIHub\Base\Account\AccountAdapterInterface;
use Beehplus\BankAPIHub\Base\Pay\PayAdapterInterface;
use Beehplus\BankAPIHub\Base\Pay\PayAdapterSetterInterface;
use Beehplus\BankAPIHub\Base\Pay\PayBaseAdapter;
use Beehplus\BankAPIHub\Base\Pay\PayResultInterface;
use Beehplus\BankAPIHub\Base\Pay\RefundOrder;
use Beehplus\BankAPIHub\Base\Pay\RefundOrderNotify;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderInterface;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderNotify;
use Beehplus\BankAPIHub\Base\Query\PayloadInterface;
use Beehplus\BankAPIHub\Base\Query\QueryAdapterInterface;

class BankApiProxy implements AccountAdapterInterface, PayAdapterInterface, QueryAdapterInterface, PayAdapterSetterInterface {
    /**
     * @var PayBaseAdapter
     */
    private $payAdapter;

    /**
     * @var AccountAdapterInterface
     */
    private $accountAdapter;

    /**
     * @var QueryAdapterInterface
     */
    private $queryAdapter;

    /**
     * BankApiProxy constructor.
     *
     * @param $payAdapter
     * @param $accountAdapter
     * @param $queryAdapter
     */
    public function __construct($payAdapter, $accountAdapter, $queryAdapter) {
        $this->payAdapter = $payAdapter;
        $this->accountAdapter = $accountAdapter;
        $this->queryAdapter = $queryAdapter;
    }

    /**
     * @return PayBaseAdapter
     */
    public function getPayAdapter(): PayAdapterInterface {
        return $this->payAdapter;
    }

    /**
     * @return AccountAdapterInterface
     */
    public function getAccountAdapter(): AccountAdapterInterface {
        return $this->accountAdapter;
    }

    /**
     * @return QueryAdapterInterface
     */
    public function getQueryAdapter(): QueryAdapterInterface {
        return $this->queryAdapter;
    }

    /**
     * 设置当前要处理的UnifiedOrder
     *
     * @param UnifiedOrderInterface $order
     * @return UnifiedOrderInterface
     */
    public function setUnifiedOrder(UnifiedOrderInterface $order): UnifiedOrderInterface {
        return $this->payAdapter->setUnifiedOrder($order);
    }

    /**
     * 把当前的UnifiedOrder提交到第三方服务，并返回相应的结果
     *
     * @param UnifiedOrderInterface $order
     * @param int $type
     * @return Base\Pay\PayResultInterface
     */
    public function postUnifiedOrder(UnifiedOrderInterface $order, int $type): \Beehplus\BankAPIHub\Base\Pay\PayResultInterface {
        return $this->payAdapter->postUnifiedOrder($order, $type);
    }

    /**
     * 设置当前要处理的RefundOrder
     *
     * @param RefundOrder $order
     * @return RefundOrder
     */
    public function setRefundOrder(RefundOrder $order): RefundOrder {
        return $this->payAdapter->setRefundOrder($order);
    }

    /**
     * 帮当前要处理的RefundOrder提交到第三方服务，并返回相应的结果
     * @param RefundOrder $refundOrder
     * @return bool
     */
    public function postRefundOrder(RefundOrder $refundOrder): bool {
        return $this->payAdapter->postRefundOrder($refundOrder);
    }

    /**
     * 处理支付异步返回结果
     *
     * @param UnifiedOrderNotify $unifiedOrderNotify
     * @return bool
     */
    public function unifiedOrderNotifyProcess(UnifiedOrderNotify $unifiedOrderNotify): bool {
        return $this->payAdapter->unifiedOrderNotifyProcess($unifiedOrderNotify);
    }

    /**
     * 处理退款的异步返回结果
     *
     * @param RefundOrderNotify $refundOrderNotify
     * @return bool
     */
    public function refundOrderNotifyProcess(RefundOrderNotify $refundOrderNotify): bool {
        return $this->payAdapter->refundOrderNotifyProcess($refundOrderNotify);
    }

    /**
     * @param PayloadInterface $payload
     * @return PayloadInterface
     */
    public function query(PayloadInterface $payload): PayloadInterface {
        return $this->queryAdapter->query($payload);
    }
}