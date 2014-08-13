<?php

namespace Rental;

class RateQuote
{
    private $lineItems = [];

    public function getLineItems()
    {
        return $this->lineItems;
    }

    public function add(RateQuoteLineItem $newLineItem)
    {
        /** @var RateQuoteLineItem $lineItem */
        foreach ($this->lineItems as $lineItem) {
            if ($lineItem->getRate() === $newLineItem->getRate()) {
                $lineItem->modifyQuantity($newLineItem->getQuantity());
                return;
            }
        }
        $this->lineItems[] = $newLineItem;
    }

    public function getSubTotal()
    {
        $subtotal = Price::fromString('0', Currency::fromString('EUR'));
        /** @var RateQuoteLineItem $lineItem */
        foreach ($this->lineItems as $lineItem) {
            $subtotal = $subtotal->add($lineItem->getLineTotal());
        }

        return $subtotal;
    }
}
