<?php


namespace Beehplus\BankAPIHub\Base\Query\Payload;


interface ParametersInterface {
    /**
     * 将对象的作为values返回
     *
     * @return array
     */
    public function values(): array;
}