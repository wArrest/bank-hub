<?php


use Beehplus\BankAPIHub\Base\UnifiedValidator;
use PHPUnit\Framework\TestCase;

class UnifiedValidatorTest extends TestCase {
    public function check(){
        $data = [
            'orderId'    => '11221',
        ];
        $validator = new UnifiedValidator($data);
        $validator->gocheck();
    }
}
