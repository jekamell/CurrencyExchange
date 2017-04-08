<?php

declare(strict_types=1);

namespace AppBundle\Entity;

/**
 * Class ExchangeResult
 */
class ExchangeResult implements \JsonSerializable
{
    private $amount = 0;

    /**
     * ExchangeResult constructor.
     * @param float $amount
     */
    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }


    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        return ['amount' => $this->amount];
    }
}
