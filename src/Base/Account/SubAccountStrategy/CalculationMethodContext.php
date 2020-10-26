<?php


namespace Beehplus\BankAPIHub\Base\Account\SubAccountStrategy;


class CalculationMethodContext {
    private $strategy;
    private $isChange = false;

    public function __construct(CalculationMethod $calculationMethod) {
        $this->strategy = $calculationMethod;
    }

    /**
     * 改变分账方式
     */
    public function change(CalculationMethod $calculationMethod) {
        $this->strategy = $calculationMethod;
        $this->isChange = true;
    }

    public function getMoney() {
        return $this->strategy->getMoney();
    }
}