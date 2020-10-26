<?php


namespace Beehplus\BankAPIHub\Base\Account;


interface BeneficiaryRoleInterface {
    //获取角色名称
    public function getType(): string;

    public function getClientId();

    //获取分账规则
    public function getRules();


}