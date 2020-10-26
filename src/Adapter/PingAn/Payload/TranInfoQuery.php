<?php


namespace Beehplus\BankAPIHub\Adapter\PingAn\Payload;

use Beehplus\BankAPIHub\Base\Query\Payload;

class TranInfoQuery extends Payload {
    /**
     * TranInfoQuery constructor.
     * @param TranInfoParameters $parameters
     */
    public function __construct(TranInfoParameters $parameters) {
        $this->body = new TranInfoBody();
        $this->parameters = $parameters;
    }

    /**
     * 获取查询载体的名称，此名称一般用户接口对应的resource名称或者叫做serverId
     *
     * @return string
     */
    public function getName(): string {
        return 'TranInfoQuery';
    }

}
