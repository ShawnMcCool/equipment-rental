<?php namespace Rental; 

interface RateQuoteCalculator
{
    public function getQuotesFor(RentalQuery $query);
} 
