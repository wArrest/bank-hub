<?php

namespace Beehplus\BankAPIHub\Base\Pay;


use Beehplus\BankAPIHub\Base\Account\ParticipateInterface;

interface UnifiedOrderInterface {


    /**
     * 获取订单编号
     * @return string(26)
     */
    public function getThirdOrderId(): string;

    public function getParticipate();

    /**
     * 获取一个当前订单提交到银行方的唯一ID，需要根据具体银行的要求进行生成。
     *
     * @return string
     */
    public function getTransactionId();

    public function getDeliverInfo();

    public function getRemoteOrderNo();

    /**
     * 获取货币种类
     * string
     * @return string(3)
     */
    public function getCurrency(): string;

    /**
     * 获取下单时间
     * @return string(3)
     */
    public function getPayTime(): string;

    /**
     * 获取总金额
     * @return number(12,2)
     */
    public function getAmount(): float;

    /**
     * 获取订单描述
     * @return string(200)
     */
    public function getRemark(): string;

    /**
     * 获取订单清算方式
     * @return int(2)
     */
    public function getOrderType(): int;

    /**
     * 获取支付方式
     * return int(2)
     */
    public function getPayType(): int;

    public function getLineItems();

    /**
     * 获取原始订单，原始订单是第三方平台自己的订单，有个问题：不同的平台对应的原始订单的数据也不同，怎么去利用里面的数据？
     * return json object
     */
//    public function getOrigOrder(): string ;

    /**
     * 获取订单的行项的Collection
     *
     * @return OrderLineItemCollection
     */
//    public function getLineItems();

    /**
     * @param $data
     * @return mixed
     */
    public function fill(array $data);

}