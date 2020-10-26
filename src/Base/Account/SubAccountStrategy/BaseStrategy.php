<?php


namespace Beehplus\BankAPIHub\Base\Account\SubAccountStrategy;


use Beehplus\BankAPIHub\Base\Account\BeneficiaryRule;

class BaseStrategy {
    private $rule;
    private $amount;

    public function __construct($amount, BeneficiaryRule $rule) {
        $this->amount = $amount;
        $this->rule = $rule;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getRule() {
        return $this->rule;
    }


}