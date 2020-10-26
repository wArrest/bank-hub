<?php

namespace Beehplus\BankAPIHub\Base\Pay;


use Beehplus\BankAPIHub\Base\Result\PayResult;

/**
 * Interface PayAdapterInterface
 *
 * 支付业务相关的接口定义
 *
 * @package Beehplus\BankAPIHub\Pay
 */
interface PayAdapterInterface {

    /**
     * @param UnifiedOrderInterface $order
     * @return UnifiedOrderInterface
     */
    public function setUnifiedOrder(UnifiedOrderInterface $order): UnifiedOrderInterface;

    /**
     * 把当前的UnifiedOrder提交到第三方服务，并返回相应的结果
     * @param UnifiedOrderInterface $order
     * @param int $type
     * @return PayResult
     */
    public function postUnifiedOrder(UnifiedOrderInterface $order): PayResultInterface;

    /**
     * 供货商发货
     * @param UnifiedOrderInterface $order
     * @param int $type
     * @return mixed
     */
    public function deliverUnifiedOrder(UnifiedOrderInterface $order,UnifiedOrderTransformInterface $orderTransform);


    /**
     * 采购商进行确认付款
     * @param UnifiedOrderInterface $order
     * @param int $type
     * @return mixed
     */
    public function confirmUnifiedOrder(UnifiedOrderInterface $order,UnifiedOrderTransformInterface $transform);

    /**
     * 处理支付异步返回结果
     *
     * @param UnifiedOrderNotify $unifiedOrderNotify
     * @return bool
     */
    public function unifiedOrderNotifyProcess(UnifiedOrderNotify $unifiedOrderNotify): bool;

    public function getTransactionId(UnifiedOrderInterface $order);

}