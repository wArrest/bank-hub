<?php


namespace Beehplus\BankAPIHub\Base;


use Beehplus\BankAPIHub\BankApiProxy;
use Beehplus\BankAPIHub\Base\Pay\UnifiedOrderInterface;

interface ProxyFactoryInterface {
    /**
     * @return BankApiProxy
     */
    public function build(): BankApiProxy;

    /**
     * @return UnifiedOrderInterface
     */
    public function unifiedOrderBuild(): UnifiedOrderInterface;
}