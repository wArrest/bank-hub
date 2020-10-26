<?php


namespace Beehplus\BankAPIHub\Base\Account;


use Beehplus\BankAPIHub\Base\Account\SubAccountStrategy\CalculationMethodContext;
use Beehplus\BankAPIHub\Base\Account\SubAccountStrategy\FixedValue;
use Beehplus\BankAPIHub\Base\Account\SubAccountStrategy\Proportion;

class CalculationMethodFactory {

    public function getMoney($orderAmount,BeneficiaryRule $rule) {
        switch ($rule->getCalculationMethod()) {
            case BeneficiaryRule::PROPORTION :
                $strategy = new CalculationMethodContext(new Proportion($orderAmount, $rule));
                $money = $strategy->getMoney();
                break;
            case BeneficiaryRule::FIXED_AMOUNT:
                $strategy = new CalculationMethodContext(new FixedValue($orderAmount, $rule));
                $money = $strategy->getMoney();
                break;
        }
        return floatval($money);
    }


}
