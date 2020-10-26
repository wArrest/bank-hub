<?php


namespace Beehplus\BankAPIHub\Base\Account;


class BeneficiaryResult implements BeneficiaryResultInterface {
    private $result = [];

    public function addItem(AccountInterface $account, $money) {
        $beneficiaryrItem = new BeneficiaryItem($account, $money);
        array_push($this->result, $beneficiaryrItem);
    }

    public function getResult() {
        return $this->result;
    }


}