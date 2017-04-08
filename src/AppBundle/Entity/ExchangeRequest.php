<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Mell\Bundle\SimpleDtoBundle\Model\DtoSerializableInterface;

/**
 * Class ExchangeRequest
 */
class ExchangeRequest implements DtoSerializableInterface
{
    /**
     * @var int
     */
    private $currencyFromId;

    /**
     * @var int
     */
    private $currencyToId;

    /**
     * @var float
     */
    private $amount;

    /**
     * @return int
     */
    public function getCurrencyFromId(): ?int
    {
        return $this->currencyFromId;
    }

    /**
     * @param int $currencyFromId
     */
    public function setCurrencyFromId(?int $currencyFromId): void
    {
        $this->currencyFromId = $currencyFromId;
    }

    /**
     * @return int
     */
    public function getCurrencyToId(): ?int
    {
        return $this->currencyToId;
    }

    /**
     * @param int $currencyToId
     */
    public function setCurrencyToId(?int $currencyToId): void
    {
        $this->currencyToId = $currencyToId;
    }

    /**
     * @return float
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }
}
