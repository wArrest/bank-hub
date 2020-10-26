<?php


namespace Beehplus\BankAPIHub\Base\Query\Payload;


class Parameters implements ParametersInterface {
    /**
     * @return array
     */
    public function values(): array {
        return get_object_vars($this);
    }
}