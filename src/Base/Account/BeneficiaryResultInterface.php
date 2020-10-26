<?php


namespace Beehplus\BankAPIHub\Base\Account;


interface BeneficiaryResultInterface {
    public function addItem(AccountInterface $account,$money);
    public function getResult();
}