<?php


namespace Beehplus\BankAPIHub\Base\Query;


use Beehplus\BankAPIHub\Base\Query\Payload\BodyInterface;
use Beehplus\BankAPIHub\Base\Query\Payload\ParametersInterface;

abstract class Payload implements PayloadInterface {
    /**
     * @var BodyInterface
     */
    protected $body;

    /**
     * @var ParametersInterface
     */
    protected $parameters;

    /**
     * @return ParametersInterface
     */
    public function getParameters(): ParametersInterface {
        return $this->parameters;
    }

    /**
     * 得到payload的body
     *
     * @return BodyInterface
     */
    public function getBody(): BodyInterface {
        return $this->body;
    }

    /**
     * @param array $data
     * @return PayloadInterface
     */
    public function fillBody(array $data): PayloadInterface {
        $this->body->fill($data);
        return $this;
    }
}