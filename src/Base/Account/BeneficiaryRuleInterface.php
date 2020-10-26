<?php


namespace Beehplus\BankAPIHub\Base\Account;


interface BeneficiaryRuleInterface {

    public function getId(): int;

    public function getGateway(): string;

    //得到计算方式，百分比或者值
    public function getCalculationMethod(): string;

    public function getCalculationValue(): float;

    //得到第三方平台
    public function getClientId(): string;
}