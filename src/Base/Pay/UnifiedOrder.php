<?php


namespace Beehplus\BankAPIHub\Base\Pay;


use Beehplus\BankAPIHub\Base\Account\Account;
use Beehplus\BankAPIHub\Base\Account\Participate;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;


class UnifiedOrder implements UnifiedOrderInterface, TransformAbleInterface {
    //状态常量
    //初始化状态
    const INIT = 'INIT';
    const INIT_STATUS = '1';
    //order
    const WAIT_PAY = 'WAITPAY';
    const PAID = 'PAID';
    const SHIPPED = 'SHIPPED';
    const CONFIRMED = 'CONFIRMED';
    const WAIT_CONFIRM = 'WAIT_CONFIRM';
    const REFUNDING = 'REFUNDING';
    const REFUNDED = 'REFUNDED';

    const PAYER_ROLE_CODE = 1;

    protected $thirdOrderId;
    protected $payTime;
    protected $amount;
    protected $remark;
    protected $orderType;
    protected $payType;
    protected $origOrder;
    protected $lineItems;
    protected $participate;
    protected $transactionId;//流水号
    protected $deliverInfo;//发货信息
    protected $remoteOrderNo;


    const STATUS_DOC = [
        self::INIT => [UnifiedOrderTransform::INIT, UnifiedOrderTransform::INIT_STATUS],
        self::WAIT_PAY => [UnifiedOrderTransform::PAY, UnifiedOrderTransform::WAIT_PAY_STATUS],
        self::PAID => [UnifiedOrderTransform::PAY, UnifiedOrderTransform::PAID_STATUS],
        self::SHIPPED => [UnifiedOrderTransform::SHIP, UnifiedOrderTransform::SHIPPED_STATUS],
        self::WAIT_CONFIRM => [UnifiedOrderTransform::CONFIRM, UnifiedOrderTransform::CONFIRMING_STATUS],
        self::CONFIRMED => [UnifiedOrderTransform::CONFIRM, UnifiedOrderTransform::CONFIRMED_STATUS],
        self::REFUNDING => [UnifiedOrderTransform::REFUND, UnifiedOrderTransform::REFUNDING_STATUS],
        self::REFUNDED => [UnifiedOrderTransform::REFUND, UnifiedOrderTransform::REFUNDED_STATUS]
    ];

    /**
     * 获取订单编号
     * @return string(26)
     */
    public function getThirdOrderId(): string {
        return $this->thirdOrderId;
    }

    /**
     * @param mixed $thirdOrderId
     */
    public function setThirdOrderId($thirdOrderId): void {
        $this->thirdOrderId = $thirdOrderId;
    }


    /**
     * 获取货币种类
     * string
     * @return string(3)
     */
    public function getCurrency(): string {
        return 'CNY';
    }

    /**
     * 获取下单时间
     * @return string(3)
     */
    public function getPayTime(): string {
        return $this->payTime;
    }

    /**
     * @param mixed $payTime
     */
    public function setPayTime($payTime): void {
        $this->payTime = $payTime;
    }

    /**
     * @param $pageDate
     */
    public function setPayDate($pageDate) {
        $this->payDate = $pageDate;
    }

    /**
     * 获取订单描述
     * @return string(200)
     */
    public function getRemark(): string {
        return $this->remark;
    }

    public function setRemark($remark) {
        $this->remark = $remark;
    }

    /**
     * 获取订单清算方式
     * @return int(2)
     */
    public function getOrderType(): int {
        return $this->orderType;
    }

    public function setOrderType($orderType) {
        $this->orderType = $orderType;
    }

    /**
     * 获取支付方式
     * return int(2)
     */
    public function getPayType(): int {
        return $this->payType;
    }

    public function setPayType($payType) {
        $this->payType = $payType;
    }

    /**
     * @return mixed
     */
    public function getLineItems() {
        return $this->lineItems;
    }

    /**
     * @param mixed $lineItems
     */
    public function setLineItems($lineItems): void {
        $this->lineItems = $lineItems;
    }

    /**
     * @param mixed $transactionId
     */
    public function setTransactionId($transactionId): void {
        $this->transactionId = $transactionId;
    }

    /**
     * @return mixed
     */
    public function getTransactionId() {
        return $this->transactionId;
    }

    /**
     * @return mixed
     */
    public function getDeliverInfo() {
        return $this->deliverInfo;
    }

    /**
     * @param mixed $deliverInfo
     */
    public function setDeliverInfo($deliverInfo): void {
        $this->deliverInfo = $deliverInfo;
    }

    /**
     * @return mixed
     */
    public function getRemoteOrderNo() {
        return $this->remoteOrderNo;
    }

    /**
     * @param mixed $remoteOrderNo
     */
    public function setRemoteOrderNo(string $remoteOrderNo): void {
        $this->remoteOrderNo = $remoteOrderNo;
    }

    /**
     * 对填充的数据进行验证
     *
     * @param array $data
     * @param $error
     * @return bool
     */
    public function valid(array $data, &$error): bool {
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        //统一订单编号
        $metadata->addPropertyConstraint('thirdOrderId', new Assert\NotBlank());
        $metadata->addPropertyConstraint('thirdOrderId', new Assert\Length([
            'min' => 8
        ]));
        //支付方式
        $metadata->addPropertyConstraint('payType', new Assert\NotBlank());
        $metadata->addPropertyConstraint('payType', new Assert\Type([
            'type' => 'integer',
            'message' => '{{ value }}不是整数'
        ]));
        //原始订单：json串
        $metadata->addPropertyConstraint('origOrder', new Assert\Type([
            'type' => 'string',
            'message' => '{{ value }}不是字符串'
        ]));

        //下单时间
        $metadata->addPropertyConstraint('payTime', new Assert\NotBlank());
        $metadata->addPropertyConstraint('payTime', new Assert\Type([
            'type' => 'integer',
            'message' => '{{ value }}不是字符串'
        ]));

        //订单清算方式
        $metadata->addPropertyConstraint('orderType', new Assert\Type([
            'type' => 'integer',
            'message' => '{{ value }}不是一个整数'
        ]));
        //订单描述
        $metadata->addPropertyConstraint('remark', new Assert\NotBlank());
        $metadata->addPropertyConstraint('remark', new Assert\Type([
            'type' => 'string',
            'message' => '{{  value }}不是字符串'
        ]));
//        //总金额
//        $metadata->addPropertyConstraint('amount', new Assert\NotBlank());
//        $metadata->addPropertyConstraint('amount', new Assert\Type([
//            'type' => 'float',
//            'message' => '{{  value }}不是一个浮点数'
//        ]));

    }

    /**
     * 用数组对数据进行填充，如果数据有问题则返回错误消息
     *
     * @param array $data
     * @return array
     *  如果数组为空，则说明填充内容成功
     */
    public function fill(array $data): array {
        $error = [];
        if ($this->valid($data, $error)) {
            $this->payDate = $data['pay_data'];
            $this->amount = $data['amount'];
            $this->remark = $data['remark'];
            $this->orderType = $data['order_type'];
            $this->payType = $data['pay_type'];
            $this->origOrder = $data['orig_order'];
            $this->lineItems = $data['lineItems'];
            $buyer = new Account();
            $buyer->fill($data['participate']['buyer']);
            $data['participate']['buyer'];
            $data['participate']['buyer'] = $buyer;

            $seller = new Account();
            $seller->fill($data['participate']['seller']);
            $data['participate']['seller'] = $seller;

            $participate = new Participate();
            $participate->build($data['participate']);
            $data['participate'] = $participate;

            $this->participate = $data['participate'];
            $this->orderId = $data['orderId'];
        }
        return $error;
    }

    /**
     * @return mixed
     */
    public function getAmount():float {
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
    public function getOrigOrder() {
        return $this->origOrder;
    }

    /**
     * @param mixed $origOrder
     */
    public function setOrigOrder($origOrder): void {
        $this->origOrder = $origOrder;
    }

    /**
     * @return mixed
     */
    public function getParticipate() {
        return $this->participate;
    }

    /**
     * @param mixed $participate
     */
    public function setParticipate($participate): void {
        $this->participate = $participate;
    }

//    public function createTransform(string $transformType, string $transactionId, string $relatedData): UnifiedOrderTransformInterface {
//        // TODO: Implement createTransform() method.
//    }
//
//    public function completeTransform(UnifiedOrderTransformInterface $transform, UnifiedOrderNotifyInterface $notify): UnifiedOrderTransformInterface {
//        // TODO: Implement completeTransform() method.
//    }
//
//    public function updateStatusByTransform(UnifiedOrderTransformInterface $orderTransform) {
//        // TODO: Implement updateStatusByTransform() method.
//    }




//    abstract function createTransform(string $transformType, string $transactionId, string $relatedData): UnifiedOrderTransformInterface;
//
//    abstract function completeTransform(UnifiedOrderTransformInterface $transform, UnifiedOrderNotifyInterface $notify): UnifiedOrderTransformInterface;
//
//    abstract function updateStatusByTransform(UnifiedOrderTransformInterface $orderTransform);

}