<?php


namespace Beehplus\BankAPIHub\Base\Query\Payload;


interface BodyInterface {
    /**
     * payload body是否已经被填充
     *
     * @return bool
     */
    public function filled(): bool;

    /**
     * @param array $data
     * @return void
     */
    public function fill(array $data);

    /**
     * @return array
     */
    public function getData(): array;
}