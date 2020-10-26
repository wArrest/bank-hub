<?php


namespace Beehplus\BankAPIHub\Base\Pay;


interface PayAdapterSetterInterface {
    /**
     * 设置当前要处理的UnifiedOrder
     *
     * @param UnifiedOrderInterface $order
     * @return UnifiedOrderInterface
     */
    public function setUnifiedOrder(UnifiedOrderInterface $order): UnifiedOrderInterface;

}