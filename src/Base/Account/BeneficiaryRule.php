<?php


namespace Beehplus\BankAPIHub\Base\Account;


class BeneficiaryRule implements BeneficiaryRuleInterface {
    const PROPORTION = 'PROPORTION';
    const FIXED_AMOUNT = 'FIXED_AMOUNT';
    protected $id;
    //结算通道，比如CCB
    protected $name;
    protected $gateway;
    protected $calculationMethod;
    protected $calculationValue;
    //第三方平台，比如91shuichan
    protected $clientId;

    /**
     * @return mixed
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void {
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getGateway(): string {
        return $this->gateway;
    }

    /**
     * @param mixed $gateway
     */
    public function setGateway($gateway): void {
        $this->gateway = $gateway;
    }


    /**
     * @return mixed
     */
    public function getCalculationMethod(): string {
        return $this->calculationMethod;
    }

    /**
     * @param mixed $calculationMethod
     */
    public function setCalculationMethod($calculationMethod): void {
        $this->calculationMethod = $calculationMethod;
    }

    /**
     * @return mixed
     */
    public function getCalculationValue(): float {
        return $this->calculationValue;
    }

    /**
     * @param mixed $calculationValue
     */
    public function setCalculationValue(float $calculationValue): void {
        $this->calculationValue = $calculationValue;
    }

    /**
     * @return mixed
     */
    public function getClientId(): string {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId): void {
        $this->clientId = $clientId;
    }


}