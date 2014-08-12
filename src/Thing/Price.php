<?php

namespace Thing;

final class Price
{
    private $value;
    private $currency;

    public static function fromString($value, Currency $currency)
    {
        // just an over-simplified validation example
        if ( ! is_numeric($value)) {
            throw new \InvalidArgumentException('Value must be a valid number.');
        }

        $price = new static;
        $price->value = $value;
        $price->currency = $currency;
        return $price;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function equals(Price $other)
    {
        return $this->value == $other->value &&
            $this->currency->equals($other->currency);
    }
}
