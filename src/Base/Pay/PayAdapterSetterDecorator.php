<?php


namespace Beehplus\BankAPIHub\Base\Pay;


class PayAdapterSetterDecorator implements PayAdapterSetterInterface {

    /**
     * @var PayAdapterSetterInterface
     */
    private $payAdapterSetter;

    public function __construct(PayAdapterSetterInterface $payAdapterSetter) {
        $this->payAdapterSetter = $payAdapterSetter;
    }

    /**
     * 设置当前要处理的UnifiedOrder
     *
     * @param UnifiedOrderInterface $order
     * @return UnifiedOrderInterface
     */
    public function setUnifiedOrder(UnifiedOrderInterface $order): UnifiedOrderInterface {
        return $this->payAdapterSetter->setUnifiedOrder($order);
    }
}