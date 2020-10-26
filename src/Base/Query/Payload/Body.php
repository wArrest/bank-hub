<?php


namespace Beehplus\BankAPIHub\Base\Query\Payload;


abstract class Body implements BodyInterface {
    /**
     * @var bool
     */
    private $filled = false;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * payload body是否已经被填充
     *
     * @return bool
     */
    public function filled(): bool {
        return $this->filled;
    }

    /**
     * @param array $data
     */
    public function fill(array $data) {
        $this->filled = true;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }
}