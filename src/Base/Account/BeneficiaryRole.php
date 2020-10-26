<?php


namespace Beehplus\BankAPIHub\Base\Account;


class BeneficiaryRole implements BeneficiaryRoleInterface {
    //卖家
    const SELLER = 'SELLER';
    //平台分成
    const PLATFORM_COMMISSION = 'PLATFORM_COMMISSION';
    //角色名
    protected $name;
    protected $type;
    //第三方平台名，比如91shuichan
    protected $clientId;
    //分账规则
    protected $rules;

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
    public function getRules() {
        return $this->rules;
    }

    /**
     * @param mixed $rule
     */
    public function setRules($rules): void {
        $this->rules = $rules;
    }

    /**
     * @return mixed
     */
    public function getClientId() {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId): void {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void {
        $this->type = $type;
    }


}