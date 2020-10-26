<?php


namespace Beehplus\BankAPIHub\Base\Account;


class BeneficiaryItem implements BeneficiaryItemInterface {
    private $account;
    private $money;

    public function __construct(AccountInterface $account, $money) {
        $this->money = $money;
        $this->account = $account;
    }

    public function getAccount() {
        return $this->account;
    }
    
    public function getMoney() {
        return $this->money;
    }

}