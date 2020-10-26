<?php


namespace Beehplus\BankAPIHub\Base\Account;

use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Account implements AccountInterface {
    protected $name;
    protected $uuid;
    protected $realName;
    protected $company;
    protected $phone;
    protected $address;
    protected $origAccountId;
    protected $origAccount;
    protected $type;
    protected $role;
    protected $beneficiaryRoles = [];

    public static function loadValidatorMetadata(ClassMetadata $metadata) {

        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 12
        ]));
        //type
        $metadata->addPropertyConstraint('type', new Assert\NotBlank());

        //realName
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('name', new Assert\Type([
            'type' => 'string',
            'message' => '{{ value }}不是字符串',
        ]));
        //公司
        $metadata->addPropertyConstraint('company', new Assert\NotBlank());
        $metadata->addPropertyConstraint('company', new Assert\Type([
            'type' => 'string',
            'message' => '{{ value }}不是字符串',
        ]));
        //手机号
        $metadata->addPropertyConstraint('phone', new Assert\Regex([
            'pattern' => '/^1[34578]\d{9}$/',
            'message' => '手机号格式不正确'
        ]));
        //address
        $metadata->addPropertyConstraint('address', new Assert\NotBlank());
        $metadata->addPropertyConstraint('address', new Assert\Type([
            'type' => 'string',
            'message' => '不是字符串'
        ]));
        $metadata->addPropertyConstraint('origAccount', new Assert\NotBlank());
        $metadata->addPropertyConstraint('origAccount', new Assert\Type([
            'type' => 'string',
            'message' => '不是字符串'
        ]));

    }

    /**
     * @return mixed
     */
    public function getId() {
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
    public function getUuid() {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid): void {
        $this->uuid = $uuid;
    }


    /**
     * @return mixed
     */
    public function getName(): string {
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
    public function getRealName(): string {
        return $this->realName;
    }

    /**
     * @param mixed $realName
     */
    public function setRealName($realName): void {
        $this->realName = $realName;
    }

    /**
     * @return mixed
     */
    public function getCompany(): string {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company): void {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getPhone(): string {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getAddress(): string {
        return $this->address;
    }


    /**
     * @param mixed $address
     */
    public function setAddress($address): void {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getOrigAccount(): string {
        return $this->origAccount;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getOrigAccountId() {
        return $this->origAccountId;
    }

    /**
     * @param mixed $origAccountId
     */
    public function setOrigAccountId($origAccountId): void {
        $this->origAccountId = $origAccountId;
    }


    /**
     * @param mixed $origAccount
     */
    public function setOrigAccount($origAccount): void {
        $this->origAccount = $origAccount;
    }

    /**
     * @return mixed
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void {
        $this->role = $role;
    }


    /**
     * @return mixed
     */
    public function getBeneficiaryRoles() {
        return $this->beneficiaryRoles;
    }

    /**
     * @param mixed $beneficiaryRoles
     */
    public function setBeneficiaryRoles($beneficiaryRoles){
        $this->beneficiaryRoles = $beneficiaryRoles;
    }


    public function fill(array $params): array {
        $error = [];
        if ($this->valid($params, $error)) {
            $this->id = $params['id'];
            $this->name = $params['name'];
            $this->type = $params['type'];
            $this->realName = $params['realName'];
            $this->company = $params['company'];
            $this->phone = $params['phone'];
            $this->address = $params['address'];
            $this->origAccount = $params['origAccount'];
        }
        return $error;


    }

    

    //验证填充信息，账户信息面向中间件，唯一账户
    public function valid(array $params, &$error): bool {
        if (!isset($params['name'])) {
            $error['name'] = 'name is not set!';
            return false;
        }
        return true;
    }

}