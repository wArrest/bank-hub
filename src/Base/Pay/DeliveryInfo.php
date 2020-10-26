<?php


namespace Beehplus\BankAPIHub\Base\Pay;


class DeliveryInfo implements DeliveryInfoInterface {
    protected $sendNo;
    protected $sendType;
    protected $sendCorp;
    protected $transmode;
    protected $forceTime;
    protected $remark;
    protected $createTime;

    /**
     * @return mixed
     */
    public function getSendNo(): string {
        return $this->sendNo;
    }

    /**
     * @param mixed $sendNo
     */
    public function setSendNo($sendNo): void {
        $this->sendNo = $sendNo;
    }

    /**
     * @return mixed
     */
    public function getSendType(): string {
        return $this->sendType;
    }

    /**
     * @param mixed $sendType
     */
    public function setSendType($sendType): void {
        $this->sendType = $sendType;
    }

    /**
     * @return mixed
     */
    public function getSendCorp(): string {
        return $this->sendCorp;
    }

    /**
     * @param mixed $sendCorp
     */
    public function setSendCorp($sendCorp): void {
        $this->sendCorp = $sendCorp;
    }

    /**
     * @return mixed
     */
    public function getTransmode(): string {
        return $this->transmode;
    }

    /**
     * @param mixed $transmode
     */
    public function setTransmode($transmode): void {
        $this->transmode = $transmode;
    }

    /**
     * @return mixed
     */
    public function getForceTime(): string {
        return $this->forceTime;
    }

    /**
     * @param mixed $forceTime
     */
    public function setForceTime($forceTime): void {
        $this->forceTime = $forceTime;
    }

    /**
     * @return string
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
    public function getCreateTime(): string {
        return $this->createTime;
    }

    /**
     * @param mixed $createTime
     */
    public function setCreateTime($createTime): void {
        $this->createTime = $createTime;
    }


}