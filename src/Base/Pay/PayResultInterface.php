<?php


namespace Beehplus\BankAPIHub\Base\Pay;


interface PayResultInterface {
    //是否需要重定向
    public function isRedirect(): bool;

    //拿到url
    public function getUrl(): string;

    //拿到表单数据
    public function getParamData();
    //错误信息
    public function getErrorInfo();
}