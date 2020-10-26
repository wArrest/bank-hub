<?php
namespace Beehplus\BankAPIHub\Base\Pay;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

abstract class OrderLineItem implements OrderLineItemInterface {
    protected $origId;
    protected $label;
    protected $amount;
    protected $sku;
    //商品数量
    protected $quantity;
    //商品单价
    protected $price;
    /**
     * @return mixed
     */
    public function getOrigId() {
        return $this->origId;
    }

    /**
     * @param mixed $origId
     */
    public function setOrigId($origId): void {
        $this->origId = $origId;
    }

    /**
     * @return mixed
     */
    public function getAmount() {
        return $this->amount;
    }
    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label): void {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getSku() {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku): void {
        $this->sku = $sku;
    }

    /**
     * @return mixed
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void {
        $this->price = $price;
    }
    public static function loadValidatorMetadata(ClassMetadata $metadata){

        //商品原始id
        $metadata->addPropertyConstraint('origId',new Assert\NotBlank([
            'message' => 'origId is not null'
        ]));
        $metadata->addPropertyConstraint('origId',new Assert\Type([
            'type' => 'string',
            'message' => 'origId should be string'
        ]));
        $metadata->addPropertyConstraint('origId',new Assert\Length([
            'max' => 30
        ]));

        //商品标签
        $metadata->addPropertyConstraint('label',new Assert\Type([
            'type' => 'string',
            'message' => 'label should be string'
        ]));

        //商品sku
        $metadata->addPropertyConstraint('sku',new Assert\NotBlank([
            'message' => 'sku is not null'
        ]));

        //商品数量
        $metadata->addPropertyConstraint('quantity',new Assert\NotBlank([
            'message' => 'quantity is not null'
        ]));

        //商品价格
        $metadata->addPropertyConstraint('price',new Assert\NotBlank([
            'message' => 'price is not null'
        ]));
        $metadata->addPropertyConstraint('price',new Assert\Type([
            'type' => 'float',
            'message' => 'price should be float'
        ]));

    }

    /**
     * @return mixed
     */
    public function fill(array $params){
        $error = [];
        if($this->valid($params,$error)){
            $this->origId = $params['origId'];
            $this->label = $params['label'];
            $this->sku = $params['sku'];
            $this->quantity = $params['quantity'];
            $this->price = $params['price'];
            $this->amount = $params['amount'];
        }
        return $error;
    }

}