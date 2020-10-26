<?php


namespace Beehplus\BankAPIHub\Base\Pay;


interface DeliveryInfoInterface {
    //物流单号
    public function getSendNo(): string;

    //提货方式
    public function getSendType(): string;

    //物流公司
    public function getSendCorp(): string;

    //物流类型
    public function getTransmode(): string;

    //强制付款时间
    public function getForceTime(): string;

    //备注
    public function getRemark(): string;

    //当前时间
    public function getCreateTime(): string;
}