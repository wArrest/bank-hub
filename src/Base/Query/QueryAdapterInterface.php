<?php

namespace Beehplus\BankAPIHub\Base\Query;


/**
 * Interface QueryAdapterInterface
 *
 * 业务查询相关的接口定义
 *
 * @package Beehplus\BankAPIHub\Query
 */
interface QueryAdapterInterface {
    /**
     * 对于一些交易数据查询的通用方法
     *
     * @param PayloadInterface $payload
     * @return PayloadInterface
     */
    public function query(PayloadInterface $payload): PayloadInterface;
}