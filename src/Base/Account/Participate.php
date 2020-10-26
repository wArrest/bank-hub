<?php


namespace Beehplus\BankAPIHub\Base\Account;

use Symfony\Component\Validator\Constraints as Assert;
use Beehplus\BankAPIHub\Adapter\CCB\CCBAccount;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Participate implements ParticipateInterface {
    //付款方
    private $payer;

    //卖方
    private $seller;

    //获益方
    private $beneficiaries = [];

    

    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        //买家
        $metadata->addPropertyConstraint('payer', new Assert\NotBlank());
        $metadata->addPropertyConstraint('payer', new Assert\Type([
            'type' => 'object',
            'message' => '买家账户没有实例化',
        ]));

        //卖家
        $metadata->addPropertyConstraint('beneficiary', new Assert\NotBlank());
        $metadata->addPropertyConstraint('beneficiary', new Assert\Type([
            'type' => 'object',
            'message' => '卖家账户没有实例化',
        ]));
    }

    public function build(array $params) {
        $this->payer = $params['payer'];
        $this->beneficiary = $params['beneficiary'];
    }

    public function getPayer() {
        return $this->payer;
    }

    public function getBeneficiaries() {
        return $this->beneficiaries;
    }

    public function setPayer($buyer) {
        $this->payer = $buyer;
    }

    public function setBeneficiaries($beneficiaries) {
        $this->beneficiaries = $beneficiaries;
    }

    /**
     * @return mixed
     */
    public function getSeller() {
        return $this->seller;
    }

    /**
     * @param mixed $seller
     */
    public function setSeller($seller): void {
        $this->seller = $seller;
    }

    public function All(): array {
        // TODO: Implement getAll() method.
    }

}