<?php


namespace Beehplus\BankAPIHub\Base\Pay;


class UnifiedOrderTransform implements UnifiedOrderTransformInterface {

    //状态常量
    //transform
    const INIT = 'INIT';
    const INIT_STATUS = '1';
    const COMPLETE_STATUS = '1';
    const PAY = 'PAY';
    const WAIT_PAY_STATUS = '0';
    const PAID_STATUS = '1';
    const SHIP = 'SHIP';
    const WAIT_SHIP_STATUS = '0';
    const SHIPPED_STATUS = '1';
    const CONFIRM = 'CONFIRM';
    const CONFIRMING_STATUS = '0';
    const CONFIRMED_STATUS = '1';
    const REFUND = 'REFUND';
    const REFUNDING_STATUS = '0';
    const REFUNDED_STATUS = '1';

    protected $id;
    protected $trading;
    protected $relatedNo;
    protected $relatedData;
    protected $transactionId;
    protected $type;
    protected $status = 0;
    protected $remark;
    protected $createTime;
    protected $updateTime;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void {
        $this->id = $id;
    }

    
    /**
     * @return mixed
     */
    public function getTrading() {
        return $this->trading;
    }

    /**
     * @param mixed $trading
     */
    public function setTrading($trading): void {
        $this->trading = $trading;
    }


    /**
     * @return mixed
     */
    public function getRelatedNo() {
        return $this->relatedNo;
    }

    /**
     * @param mixed $relatedNo
     */
    public function setRelatedNo(string $relatedNo): void {
        $this->relatedNo = $relatedNo;
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
    public function getRelatedData(): string {
        return $this->relatedData;
    }

    /**
     * @param mixed $relatedData
     */
    public function setRelatedData(string $relatedData): void {
        $this->relatedData = $relatedData;
    }


    /**
     * @return mixed
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType(string $type): void {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getStatus(): string {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus(string $status): void {
        $this->status = $status;
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

    /**
     * @return mixed
     */
    public function getUpdateTime(): string {
        $this->updateTime = date('Y-m-d H:i:s', $this->updateTime);
        return $this->updateTime;
    }

    /**
     * @param mixed $updateTime
     */
    public function setUpdateTime(): void {
        $this->updateTime = time();
    }

    /**
     * @return mixed
     */
    public function getCreateTime() {
        $this->createTime = date('Y-m-d H:i:s', $this->createTime);
        return $this->createTime;
    }

    /**
     * @param mixed $createTime
     */
    public function setCreateTime(): void {
        $this->createTime = time();
    }




}