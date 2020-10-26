<?php


namespace Beehplus\BankAPIHub\Base\Account\SubAccountStrategy;


class Proportion extends BaseStrategy implements CalculationMethod {
    function getMoney() {
        $money = $this->getAmount() * $this->getRule()->getCalculationValue();
        return $money;
    }

}