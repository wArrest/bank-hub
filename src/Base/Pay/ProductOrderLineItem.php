<?php


namespace Beehplus\BankAPIHub\Base\Pay;


class ProductOrderLineItem extends OrderLineItem {

    public function fill(array $data): array {
        $errors = parent::fill($data);

        if (count($errors) === 0) {
            $this->configuration = $data['configuration'];
        }
        return $errors;
    }

    public function valid(array $data, &$error): bool {
        if (!isset($data['orderId'])) {
            $errors[] = 'orderId is miss';
            return false;
        }
        return true;
    }
}