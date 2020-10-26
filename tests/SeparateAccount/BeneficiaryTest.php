<?php

namespace Beehplus\Test;

use Beehplus\BankAPIHub\Base\Account\Account;
use Beehplus\BankAPIHub\Base\Account\BeneficiaryItem;
use Beehplus\BankAPIHub\Base\Account\BeneficiaryProcessor;
use Beehplus\BankAPIHub\Base\Account\BeneficiaryRole;
use Beehplus\BankAPIHub\Base\Account\BeneficiaryRule;
use Beehplus\BankAPIHub\Base\Account\Participate;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrder;
use PHPUnit\Framework\TestCase;

class BeneficiaryTest extends TestCase {
    public function testBeneficearyProcessorResult() {
        //-----------------------按比例分账--------------------------
        $rules = [];
        $rule = new BeneficiaryRule();
        $rule->setName('test');
        $rule->setClientId('91shuichan');
        $rule->setId('ssdf3');
        $rule->setCalculationMethod(BeneficiaryRule::PROPORTION);
        $rule->setGateway('CCB');
        $rule->setCalculationValue(0.5);
        array_push($rules, $rule);

        $roles = [];
        $role = new BeneficiaryRole();
        $role->setClientId('91shuichan');
        array_push($roles, $role);
        $role->setRules($rules);


        $beneficiaryProcessor = new BeneficiaryProcessor($this->getOrder($roles));
        $result = $beneficiaryProcessor->getProcessorResult();

        $this->assertArrayNotHasKey('error', $result, '分则规则有问题');
        $this->assertIsArray($result, 'processorResult结果不是数组');

        foreach ($result as $item) {
            $this->assertIsInt($item->getAccount()->getId(), 'uid应该为整数');
            //
            $this->assertIsFloat($item->getMoney(), 'money应该为浮点数');
            $this->assertEquals(50, $item->getMoney(), '生成的money数值不对');
        }


        //---------------------按固定值分账-------------------
        $rules = [];
        $rule = new BeneficiaryRule();
        $rule->setName('test');
        $rule->setClientId('91shuichan');
        $rule->setId('ssdf3');
        $rule->setCalculationMethod(BeneficiaryRule::FIXED_AMOUNT);
        $rule->setGateway('CCB');
        $rule->setCalculationValue(50);
        array_push($rules, $rule);

        $roles = [];
        $role = new BeneficiaryRole();
        $role->setClientId('91shuichan');
        $role->setRules($rules);
        array_push($roles, $role);

        $beneficiaryProcessor = new BeneficiaryProcessor($this->getOrder($roles));
        $result = $beneficiaryProcessor->getProcessorResult();

        $this->assertArrayNotHasKey('error', $result, '分则规则有问题');
        $this->assertIsArray($result, 'processorResult结果不是数组');

        foreach ($result as $item) {
            $this->assertIsInt($item->getAccount()->getId(), 'uid应该为整数');
            $this->assertIsFloat($item->getMoney(), 'money应该为浮点数');
            $this->assertEquals(50, $item->getMoney(), '生成的money数值不对');
        }
        var_dump($result);

        //-----------------固定值和比例混合方式分账----------------
        $rules = [];
        $rule = new BeneficiaryRule();
        $rule->setName('test');
        $rule->setClientId('91shuichan');
        $rule->setId('ssdf3');
        $rule->setCalculationMethod(BeneficiaryRule::FIXED_AMOUNT);
        $rule->setGateway('CCB');
        $rule->setCalculationValue(10);

        //为角色新添加一个规则

        $rule2 = new BeneficiaryRule();
        $rule2->setName('test');
        $rule2->setClientId('91shuichan');
        $rule2->setId('ssdf3');
        $rule2->setCalculationMethod(BeneficiaryRule::PROPORTION);
        $rule2->setGateway('CCB');
        $rule2->setCalculationValue(0.1);
        array_push($rules, $rule);
        array_push($rules, $rule2);


        $roles = [];
        $role = new BeneficiaryRole();
        $role->setClientId('91shuichan');
        $role->setRules($rules);
        array_push($roles, $role);

        $beneficiaryProcessor = new BeneficiaryProcessor($this->getOrder($roles));
        $result = $beneficiaryProcessor->getProcessorResult();

        $this->assertArrayNotHasKey('error', $result, '分则规则有问题');
        $this->assertIsArray($result, 'processorResult结果不是数组');

        foreach ($result as $item) {
            $this->assertIsInt($item->getAccount()->getId(), 'uid应该为整数');
            $this->assertIsFloat($item->getMoney(), 'money应该为浮点数');
            $this->assertEquals(20, $item->getMoney(), '生成的money数值不对');
        }

        //---------为用户新添加一个分账角色---------
        $role2 = new BeneficiaryRole();
        $role2->setClientId('91shuichan');
        $role2->setRules($rules);
        array_push($roles, $role2);

        $beneficiaryProcessor = new BeneficiaryProcessor($this->getOrder($roles));
        $result = $beneficiaryProcessor->getProcessorResult();

        $this->assertArrayNotHasKey('error', $result, '分则规则有问题');
        $this->assertIsArray($result, 'processorResult结果不是数组');

        foreach ($result as $item) {
            $this->assertIsInt($item->getAccount()->getId(), 'uid应该为整数');
            $this->assertIsFloat($item->getMoney(), 'money应该为浮点数');
            $this->assertEquals(40, $item->getMoney(), '生成的money数值不对');
        }


    }

    private function getOrder($roles) {
        $beneficiaries = [];

        $beneficiary2 = new Account();
        $beneficiary2->setId(10002);
        $beneficiary2->setName('barry');
        $beneficiary2->setType('1');
        $beneficiary2->setCompany('beeh');
        $beneficiary2->setOrigAccount('test');
        $beneficiary2->setAddress('gxq');
        $beneficiary2->setPhone('17857024602');
        $beneficiary2->setRealName('wxb');
        $beneficiary2->setOrigAccountId('10002');
        $beneficiary2->setBeneficiaryRoles($roles);
        array_push($beneficiaries, $beneficiary2);


        $beneficiary3 = new Account();
        $beneficiary3->setId(10003);

        $beneficiary3->setName('lucy');
        $beneficiary3->setType('1');
        $beneficiary3->setCompany('beeh');
        $beneficiary3->setOrigAccount('test');
        $beneficiary3->setAddress('gxq');
        $beneficiary3->setPhone('17857024604');
        $beneficiary3->setRealName('zlx');
        $beneficiary3->setOrigAccountId('10003');
        $beneficiary3->setBeneficiaryRoles($roles);
        array_push($beneficiaries, $beneficiary3);

        $participate = new Participate();

        $participate->setBeneficiaries($beneficiaries);


        $order = new UnifiedOrder();
        $this->assertIsObject($order, 'error');


        //订单总额
        $order->setAmount(100.00);

        //订单参与人
        $order->setParticipate($participate);
        return $order;

    }


}
