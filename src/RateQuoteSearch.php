<?php namespace Rental;

class RateQuoteSearch
{
    /**
     * @var RateQuoteProvider
     */
    private $provider;

    public function __construct(RateQuoteProvider $provider)
    {
        $this->provider = $provider;
    }

    public function getCheapestQuote(RentalQuery $query)
    {
        $quotes = $this->provider->getQuotesFor($query);

        $cheapestQuote = null;

        /** @var RateQuote $quote */
        foreach ($quotes as $quote) {
            if (is_null($cheapestQuote) || $quote->getSubTotal() < $cheapestQuote->getSubTotal()) {
                $cheapestQuote = $quote;
            }
        }

        return $cheapestQuote;
    }
}
