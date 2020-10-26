<?php


namespace Beehplus\BankAPIHub\Base\Account\SubAccountStrategy;


use Beehplus\BankAPIHub\Base\Account\BeneficiaryRule;

class FixedValue extends BaseStrategy implements CalculationMethod {
    public function getMoney() {
       return $this->getRule()->getCalculationValue();
    }


}