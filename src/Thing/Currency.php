<?php

namespace Thing;

final class Currency
{
    private $type;

    public function __construct() {}

    public static function fromString($type)
    {
        $currency = new static;
        $currency->type = strtoupper($type);
        return $currency;
    }

    public function getCurrency()
    {
        return $this->type;
    }

    public function equals(Currency $other)
    {
        return $this->type == $other->type;
    }
}
