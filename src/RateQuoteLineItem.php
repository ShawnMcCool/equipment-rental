<?php

namespace Rental;

class RateQuoteLineItem
{
    /** @var Rate */
    private $rate;
    private $quantity;

    public static function make(Rate $rate, $quantity)
    {
        $lineItem = new static;
        $lineItem->rate = $rate;
        $lineItem->quantity = $quantity;
        return $lineItem;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function modifyQuantity($modifier)
    {
        $this->quantity += $modifier;
    }

    public function getLineTotal()
    {
        return $this->getRate()->getPrice()->times($this->quantity);
    }
}
