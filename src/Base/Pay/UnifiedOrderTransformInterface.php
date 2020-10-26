<?php


namespace Beehplus\BankAPIHub\Base\Pay;


interface UnifiedOrderTransformInterface {

    public function getId();

    public function getTrading();

    //订单状态:1-支付成功 2-订单已取消 3-支付中 4-已支付未确认付款
    public function getType(): string;

    public function setType(string $transformType);

    public function getStatus(): string;

    public function setStatus(string $status);

    public function getRelatedNo();

    public function setRelatedNo(string $relatedNo);

    public function getRelatedData(): string;

    public function setRelatedData(string $data);

    public function getTransactionId(): string;


    //备注信息（失败原因）
    public function getRemark(): string;

    //状态更改的当前时间
    public function getUpdateTime(): string;


}