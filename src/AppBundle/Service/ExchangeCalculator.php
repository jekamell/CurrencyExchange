<?php

declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Entity\Currency;

/**
 * Class CurrencyExchange
 */
class ExchangeCalculator
{
    /**
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @param float $amount
     * @return int
     */
    public function calculate(Currency $currencyFrom, Currency $currencyTo, float $amount): int
    {
        return (int) ($amount * $currencyFrom->getValue() / $currencyTo->getValue());
    }
}
