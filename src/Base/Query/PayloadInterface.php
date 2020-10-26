<?php


namespace Beehplus\BankAPIHub\Base\Query;

use Beehplus\BankAPIHub\Base\Query\Payload\BodyInterface;
use Beehplus\BankAPIHub\Base\Query\Payload\ParametersInterface;

interface PayloadInterface {
    /**
     * 获取查询载体的名称，此名称一般用户接口对应的resource名称或者叫做serverId
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @return ParametersInterface
     */
    public function getParameters(): ParametersInterface;

    /**
     * 得到payload的body
     *
     * @return Body
     */
    public function getBody(): BodyInterface;

    /**
     * @param array $data
     * @return PayloadInterface
     */
    public function fillBody(array $data): PayloadInterface;
}