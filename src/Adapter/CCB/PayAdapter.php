<?php


namespace Beehplus\BankAPIHub\Adapter\CCB;

use Beehplus\BankAPIHub\Adapter\CCB\utils\Common;
use Beehplus\BankAPIHub\Adapter\CCB\utils\Crypt;
use Beehplus\BankAPIHub\Base\Account\BeneficiaryProcessor;
use Beehplus\BankAPIHub\Base\Pay\BasePayResult;
use Beehplus\BankAPIHub\Base\Pay\OrderLineItemCollection;
use Beehplus\BankAPIHub\Base\Pay\PayBaseAdapter;
use Beehplus\BankAPIHub\Base\Pay\PayResultInterface;
use Beehplus\BankAPIHub\Base\Pay\RefundOrder;
use Beehplus\BankAPIHub\Base\Pay\RefundOrderInterface;
use Beehplus\BankAPIHub\Base\Pay\RefundOrderNotify;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderInterface;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderNotify;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderTransformInterface;
use Curl\Curl;
use Beehplus\BankAPIHub\Base\Result\CCB\RedirectConfirmPayForm;
use Beehplus\BankAPIHub\Base\Result\CCB\RedirectPostOrderForm;
use Beehplus\BankAPIHub\Base\Result\PayResult;
use GuzzleHttp\Client;
use http\Params;
use phpDocumentor\Reflection\Type;

class PayAdapter extends PayBaseAdapter {
    //常量
    const GoPayType = '1';
    const OrderIniter = '0';
    const PayTxCode = 'MALL10020';
    const DeliverTxCode = 'MALL10021';
    const ConfirmTxCode = 'MALL10022';
    const RefundTxCode = 'MALL10023';
    const IsRedirect = '1';
    const NotRedirect = '2';

    //单值无须分割上送： 1- 固定比率，2- 固定金额
    const  CmsnPymdCd = '2';


    private $config;
    private $curl;

    public function __construct($config) {
        $this->config = $config;
    }

    /**
     * 保存订单信息
     * @param UnifiedOrderInterface $order
     * @return UnifiedOrderInterface
     */
    public function setUnifiedOrder(UnifiedOrderInterface $order): UnifiedOrderInterface {
        $transactionId = $this->getTransactionId($order);
        $order->setTransactionId($transactionId);
        return $order;
    }

    /**
     * 提交订单，进行支付
     * @param UnifiedOrderInterface $order
     * @param int $type
     * @return PayResultInterface
     */
    public function postUnifiedOrder(UnifiedOrderInterface $order): PayResultInterface {
        $buyer = $order->getParticipate()->getPayer();
        $seller = $order->getParticipate()->getSeller();
        $beneficiaries = $order->getParticipate()->getBeneficiaries();

        $beneficiariesNum = sizeof($beneficiaries);

        $beneficiaryProcessor = new BeneficiaryProcessor($order);

        $cmsnInraccNo = '';
        $hdcgFeert = '';

        $params = '';
        $errorInfo = '';

        $result = $beneficiaryProcessor->getProcessorResult();
        if (!array_key_exists('error', $result)) {
            $count = 0;
            foreach ($result as $item) {

                if ($count > 0) {
                    $cmsnInraccNo = $cmsnInraccNo . '|' . ($item->getAccount()->getUuid());
                    $hdcgFeert = $hdcgFeert . '|' . $item->getMoney();
                } else {
                    $cmsnInraccNo = $cmsnInraccNo . ($item->getAccount()->getUuid());
                    $hdcgFeert = $hdcgFeert . (string)$item->getMoney();
                }
                $count++;
            }

            $orig = $buyer->getOrigAccount();
            $company = $buyer->getCompany();
            $txCode = self::PayTxCode;
            if ($buyer->getType() == '0') {
                $company = $buyer->getRealName();
            }
            $data = [
                //交易码声明交易类型
                'TxCode' => $txCode,
                //第三方系统号
                'TransID' => $this->getTransactionId($order),
                //默认商城支付
                'GoPayType' => self::GoPayType,
                //默认买方发起
                'OrderIniter' => self::OrderIniter,

                'BuyerUserID_ThirdSys' => (string)$buyer->getUuid(),
                //订单买方在第三方系统中的名
                'BuyerUserName_ThirdSys' => $buyer->getName(),
                //订单卖方在第三方系统中的ID
                'SellerUserID_ThirdSys' => (string)$seller->getUuid(),
                //买方会员在第三方系统中的会员类型
                'BuyerUserType_ThirdSys' => (string)$buyer->getType(),
                //买方的真实姓名
                'BuyerTrueName_ThirdSys' => $buyer->getRealName(),
                //买方公司
                'BuyerCompany_ThirdSys' => $company,
                //买方手机号
                'BuyerPhoneNum_ThirdSys' => $buyer->getPhone(),
                //买方收货地址
                'BuyerAddress_ThirdSys' => $buyer->getAddress(),
                "BuyerCertType_ThirdSys" => "17",
                "BuyerCertValue_ThirdSys" => "330881199705183919",

                //分账相关字段
                'Topy_Tamt' => $beneficiariesNum > 1 ? $order->getAmount() : "0",
                'Cmsn_Inracc_No' => "$cmsnInraccNo",
                'Cmsn_Pymd_Cd' => self::CmsnPymdCd,
                'Hdcg_Feert' => $hdcgFeert,

                'OrderInfos' => [[
                    'Order_No' => "beeh" . (string)$order->getId(),

                    'HaveProducts' => 1,
                    'Order_Products' => $this->lineItemBuild($order->getLineItems()),
                    'Order_Money' => $order->getAmount(),
                    'Order_Time' => $order->getPayTime(),
                    //订单标题，名字起的很魔性
                    'Order_Tile' => $order->getRemark(),
                    'Order_BuyerPhone' => $order->getParticipate()->getpayer()->getPhone(),
                    //收货方的真实姓名
                    'ReceiverTrueName_ThirdSys' => $buyer->getRealName(),
                    //收货方的公司名
                    'ReceiverCompany_ThirdSys' => $buyer->getCompany(),
                    //收货方的收货地址
                    'ReceiverAddress_ThirdSys' => $buyer->getAddress(),
                    'ReceiverCertType_ThirdSys' => '17',
                    'ReceiverCertValue_ThirdSys' => '412722199007087796',
                    'Expand2' => "订单1扩展信息"
                ]],
                'Expand1' => $order->getRemark(),
            ];
            //加密数据
//        $enstr = json_encode($data, JSON_UNESCAPED_UNICODE) . $this->config['des_key'];
            $enstr = Crypt::des_encrypt(json_encode($data, JSON_UNESCAPED_UNICODE), $this->config['des_key']);
            //生成安全码
            $auth = $this->getAuth($txCode, self::GoPayType, $enstr);
            //$auth = Crypt::des_decrypt($enstr,$this->config['des_key']);
            $params = [
                'ThirdSysID' => $this->config['third_sys_id'],
                'TxCode' => $txCode,
                'RequestType' => self::IsRedirect,

                'Data' => $enstr,
                'Auth' => $auth
            ];

        } else {
            $errorInfo = $result['error'];
        }
        $payResult = new BasePayResult(true, $this->config['url'], $params, $errorInfo);


        return $payResult;

    }

    /**
     * 供货商进行发货
     * @param UnifiedOrderTransformInterface $orderTransform
     * @param int $type
     * @return mixed
     */
    public function deliverUnifiedOrder(UnifiedOrderInterface $order, UnifiedOrderTransformInterface $orderTransform) {

        $relatedData = json_decode($orderTransform->getRelatedData(), true);

        $txCode = self::DeliverTxCode;

        $order = $orderTransform->getTrading();
        $seller = $order->getParticipate()->getSeller();

        $data['TxCode'] = $txCode;
        $data['TransID'] = $orderTransform->getTransactionId();
        $data['Order_No_CCB'] = $order->getRemoteOrderNo();
        $data['SellerUserID_ThirdSys'] = (string)$seller->getUuid();
        $data['Send_No'] = $relatedData['send_info']['send_no'];
        //提货方式
        $data['Send_Type'] = $relatedData['send_info']['send_type'];
        $data['Send_Corp'] = $relatedData['send_info']['send_corp'];
        $data['Transmode'] = $relatedData['send_info']['trans_mode'];
        $data['Force_Time'] = $relatedData['send_info']['force_time'];
        $data['Remark'] = $relatedData['send_info']['remark'];
        $data['Expand1'] = 'kuozhan';
        $enstr = Crypt::des_encrypt(json_encode($data, JSON_UNESCAPED_UNICODE), $this->config['des_key']);

        $auth = $this->getAuth($txCode, self::NotRedirect, $enstr);

        $params = [
            'ThirdSysID' => $this->config['third_sys_id'],
            'TxCode' => $txCode,
            'RequestType' => self::NotRedirect,
            'Data' => $enstr,
            'Auth' => $auth
        ];
        $curl = new Curl();
        $res = $curl->post($this->config['url'], $params);
        $deliverData = $this->json_decode($res);
        return $deliverData;
    }

    /**
     *  采购商进行确认收获
     * @param UnifiedOrderInterface $order
     * @param int $type
     * @return RedirectConfirmPayForm|mixed
     */
    public function confirmUnifiedOrder(UnifiedOrderInterface $order, UnifiedOrderTransformInterface $transform): PayResultInterface {
        $txCode = self::ConfirmTxCode;
        $order = $transform->getTrading();
        $buyer = $order->getParticipate()->getPayer();
        $errorInfo='';
        $data = [
            'TxCode' => 'MALL10022',
            'TransID' => $this->getTransactionId($order),
            'BuyerUserID_ThirdSys' => (string)$buyer->getUuid(),
            'Order_No_CCB' => $order->getRemoteOrderNo(),
            'Pay_Money' => $order->getAmount()
        ];

        $enstr = Crypt::des_encrypt(json_encode($data, JSON_UNESCAPED_UNICODE), $this->config['des_key']);
        $auth = $this->getAuth($txCode, self::IsRedirect, $enstr);

        $params = [
            'ThirdSysID' => $this->config['third_sys_id'],
            'TxCode' => $txCode,
            'RequestType' => self::IsRedirect,
            'Data' => $enstr,
            'Auth' => $auth
        ];
        $payResult = new BasePayResult(true, $this->config['url'], $params,$errorInfo);
        return $payResult;
    }

    /**
     * 保存退款订单信息
     * @param RefundOrderInterface $refundOrder
     * @param int $type
     */
    public function setRefundOrder(RefundOrderInterface $refundOrder) {
        $transactionId = $this->getRefundOrderTransactionId($refundOrder);
        $refundOrder->setTransactionId($transactionId);
        return $refundOrder;
    }

    /**
     * 发起退款（全额）
     * @return BasePayResult
     */
    public function postRefundOrder(RefundOrderInterface $refundOrder) {
        $txCode = self::RefundTxCode;
        $data = [
            'TxCode' => $txCode,
            'TransID' => $refundOrder->getTransactionId(),
            'SellerUserID_ThirdSys' => $refundOrder->getSellerUserIDThirdSys(),
            'Order_No_CCB' => $refundOrder->getRemoteOrderNo(),
            'PayBackReason' => $refundOrder->getPayBackReason(),
            'GetProduct' => $refundOrder->getGetProduct(),
            'Introduce' => $refundOrder->getIntroduce(),
            'PayBackID' => $refundOrder->getPayBackID(),
            'PayBackMoney' => $refundOrder->getPayBackMoney(),
            'Expand1' => $refundOrder->getRemark()
        ];

        $enstr = Crypt::des_encrypt(json_encode($data, JSON_UNESCAPED_UNICODE), $this->config['des_key']);
        $auth = $this->getAuth($txCode, self::IsRedirect, $enstr);

        $params = [
            'ThirdSysID' => $this->config['third_sys_id'],
            'TxCode' => $txCode,
            'RequestType' => self::IsRedirect,
            'Data' => $enstr,
            'Auth' => $auth
        ];
        $payResult = new BasePayResult(true, $this->config['url'], $params);
        return $payResult;
    }

    public function unifiedOrderNotifyProcess(UnifiedOrderNotify $unifiedOrderNotify): bool {
        // TODO: Implement unifiedOrderNotifyProcess() method.
    }

    private function lineItemBuild($lineItems): array {
        $results = [];
        foreach ($lineItems as $item) {
            $results[] = [
                'ProductID' => $item->getOrigId(),
                'ProductTitle' => $item->getLabel(),
                'ProductCode' => 'test123',
                'ProductModel' => (string)$item->getSku(),
                'ProductUnit' => (string)$item->getQuantity(),
                'ProductPrice' => $item->getPrice(),
                //商品数量
                'ProductAmount' => $item->getQuantity()
            ];
        }
        return $results;
    }

    //生成安全码Auth
    private function getAuth($txcode, $requestType, $data) {
        $enstr = $this->config['third_sys_id'] . $txcode . $requestType . $data . $this->config['md5_key'];
        return $auth = Crypt::md5_encrypt($enstr);
    }

    //json_decode封装
    private function json_decode($enstr) {
        return json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $enstr), true);
    }

    //生成流水号
    public function getTransactionId(UnifiedOrderInterface $order) {
        $serial = substr(str_pad($order->getThirdOrderId(), 5, 0, STR_PAD_LEFT), 0, 5);
        $transactionId = $this->config['third_sys_id'] . date("YmdHis") . $serial;
        return $transactionId;
    }

    //生成退款订单流水号
    public function getRefundOrderTransactionId(RefundOrderInterface $refundOrder) {
        $serial = substr(str_pad($refundOrder->getId(), 5, 0, STR_PAD_LEFT), 0, 5);
        $transactionId = $this->config['third_sys_id'] . date("YmdHis") . $serial;
        return $transactionId;
    }
}