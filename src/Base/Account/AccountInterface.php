<?php


namespace Beehplus\BankAPIHub\Base\Account;


interface AccountInterface {
    const UserTypePrivate = 1;
    const UserTypeEnterprise = 2;


    public function getName(): string;

    /**
     * 获取用户的类别，是企业用户还是私人用户
     *
     * @return int
     */
    public function getType();

    public function getRealName(): string;

    public function getCompany(): string;

    public function getPhone(): string;

    public function getAddress(): string;

    public function getOrigAccount(): string;

    public function getOrigAccountId();
    public function getBeneficiaryRoles();
}