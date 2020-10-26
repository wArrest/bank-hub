<?php


namespace Beehplus\BankAPIHub\Base\Pay;


interface OrderLineItemInterface {
    public function getOrigId();

    public function getLabel();

    public function getSku();

    public function getQuantity();

    public function getPrice();

//    public function getAmount();
    public function fill(array $params);
}