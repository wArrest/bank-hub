<?php

namespace Beehplus\BankAPIHub\Base\Pay;


class RefundOrder implements RefundOrderInterface {
    protected $transactionId;//流水号
    protected $sellerUserIDThirdSys;
    protected $remoteOrderNo;
    protected $payBackReason;
    protected $getProduct;
    protected $introduce;
    protected $payBackID;
    protected $payBackMoney;
    protected $payBackStatus;
    protected $remark;

    /**
     * @return mixed
     */
    public function getTxCode(): string {
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
    public function getTransactionId(): string {
        return $this->transactionId;
    }

    /**
     * @param mixed $transactionId
     */
    public function setTransactionId($transactionId): void {
        $this->transactionId = $transactionId;
    }

    /**
     * @return mixed
     */
    public function getSellerUserIDThirdSys(): string {
        return $this->sellerUserIDThirdSys;
    }

    /**
     * @param mixed $sellerUserIDThirdSys
     */
    public function setSellerUserIDThirdSys($sellerUserIDThirdSys): void {
        $this->sellerUserIDThirdSys = $sellerUserIDThirdSys;
    }

    /**
     * @return mixed
     */
    public function getRemoteOrderNo(): string {
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
    public function getPayBackReason(): string {
        return $this->payBackReason;
    }

    /**
     * @param mixed $payBackReason
     */
    public function setPayBackReason($payBackReason): void {
        $this->payBackReason = $payBackReason;
    }

    /**
     * @return mixed
     */
    public function getGetProduct(): int {
        return $this->getProduct;
    }

    /**
     * @param mixed $getProduct
     */
    public function setGetProduct($getProduct): void {
        $this->getProduct = $getProduct;
    }

    /**
     * @return mixed
     */
    public function getIntroduce(): string {
        return $this->introduce;
    }

    /**
     * @param mixed $introduce
     */
    public function setIntroduce($introduce): void {
        $this->introduce = $introduce;
    }

    /**
     * @return mixed
     */
    public function getPayBackID(): string {
        return $this->payBackID;
    }

    /**
     * @param mixed $payBackID
     */
    public function setPayBackID($payBackID): void {
        $this->payBackID = $payBackID;
    }

    /**
     * @return mixed
     */
    public function getPayBackMoney(): float {
        return $this->payBackMoney;
    }

    /**
     * @param mixed $payBackMoney
     */
    public function setPayBackMoney($payBackMoney): void {
        $this->payBackMoney = $payBackMoney;
    }

    /**
     * @return mixed
     */
    public function getPayBackStatus(): string {
        return $this->payBackStatus;
    }

    /**
     * @param mixed $payBackStatus
     */
    public function setPayBackStatus($payBackStatus): void {
        $this->payBackStatus = $payBackStatus;
    }


    /**
     * @return mixed
     */
    public function getRemark(): string {
        return $this->remark;
    }

    /**
     * @param mixed $remark
     */
    public function setRemark($remark): void {
        $this->remark = $remark;
    }


}