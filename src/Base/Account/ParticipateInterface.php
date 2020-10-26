<?php


namespace Beehplus\BankAPIHub\Base\Account;


interface ParticipateInterface {
    public function All(): array;

    public function getPayer();

    public function getSeller();

    public function getBeneficiaries();
}