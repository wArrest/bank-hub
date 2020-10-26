<?php


namespace Beehplus\BankAPIHub\Base\Account;


class BeneficiaryProcessor implements BeneficiaryProcessorInterface {
    private $order;

    public function __construct($order) {
        $this->order = $order;
    }

    public function getProcessorResult() {
        //拿到收益者
        $beneficiaries = $this->order->getParticipate()->getBeneficiaries();
        $processorResult = new BeneficiaryResult();

        $amount = 0;

        foreach ($beneficiaries as $beneficiary) {

            $money = 0.0;
            $role = $beneficiary->getRole();
//            var_dump($role->getId());
            $rules = $role->getRules();
            foreach ($rules as $rule) {
//                var_dump($rule->getId());
                $money = $money + (new CalculationMethodFactory())->getMoney($this->order->getAmount(), $rule);
            }
            $amount = $amount + $money;
//            var_dump($amount);
            $processorResult->addItem($beneficiary, $money);
        }

        if ($amount > $this->order->getAmount()) {
            return ['error' => '分账规则错误'];
        }

        return $processorResult->getResult();
    }


}