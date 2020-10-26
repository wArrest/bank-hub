<?php

namespace Beehplus\BankAPIHub\Base\Pay;

//接收异步通知
class UnifiedOrderNotify implements UnifiedOrderNotifyInterface {
    private $txCode;
    private $transID;
    private $remoteOrderNo;
    private $orderId;
    private $payStatus;
    private $data;
    private $remark;

    /**
     * @return mixed
     */
    public function getTxCode() {
        return $this->txCode;
    }

    /**
     * @param mixed $txCode
     */
    public function setTxCode($txCode): void {
        $this->txCode = $txCode;
    }

    /**
     * @return mixed
     */
    public function getTransID() {
        return $this->transID;
    }

    /**
     * @param mixed $transID
     */
    public function setTransID($transID): void {
        $this->transID = $transID;
    }

    /**
     * @return mixed
     */
    public function getRemoteOrderNo() {
        return $this->remoteOrderNo;
    }

    /**
     * @param mixed $remoteOrderNo
     */
    public function setRemoteOrderNo($remoteOrderNo): void {
        $this->remoteOrderNo = $remoteOrderNo;
    }

    /**
     * @return mixed
     */
    public function getOrderId() {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId): void {
        $this->orderId = $orderId;
    }

    
    /**
     * @return mixed
     */
    public function getPayStatus() {
        return $this->payStatus;
    }

    /**
     * @param mixed $payStatus
     */
    public function setPayStatus($payStatus): void {
        $this->payStatus = $payStatus;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getRemark() {
        return $this->remark;
    }

    /**
     * @param mixed $remark
     */
    public function setRemark($remark): void {
        $this->remark = $remark;
    }

}