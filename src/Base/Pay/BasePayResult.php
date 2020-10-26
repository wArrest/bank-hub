<?php


namespace Beehplus\BankAPIHub\Base\Pay;


class BasePayResult implements PayResultInterface {
    private $isRedirect;
    private $url;
    private $paramData;
    private $errorInfo;


    public function __construct($isRedirect, $url, $paramData, $errorInfo) {
        $this->isRedirect = $isRedirect;
        $this->url = $url;
        $this->paramData = $paramData;
        $this->errorInfo = $errorInfo;
    }

    public function isRedirect(): bool {
        return $this->isRedirect;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getParamData() {
        return $this->paramData;
    }

    public function getErrorInfo() {
        return $this->errorInfo;
    }

}