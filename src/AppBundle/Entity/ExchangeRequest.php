<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Mell\Bundle\SimpleDtoBundle\Model\DtoSerializableInterface;

/**
 * Class ExchangeRequest
 */
class ExchangeRequest implements DtoSerializableInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @Assert\GreaterThan(0)
     *
     * @var int
     */
    private $currencyFromId;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @Assert\GreaterThan(0)
     *
     * @var int
     */
    private $currencyToId;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("float")
     * @Assert\GreaterThan(0)
     *
     * @var float
     */
    private $amount;

    /**
     * @return int
     */
    public function getCurrencyFromId()
    {
        return $this->currencyFromId;
    }

    /**
     * @param int $currencyFromId
     */
    public function setCurrencyFromId($currencyFromId)
    {
        $this->currencyFromId = $currencyFromId;
    }

    /**
     * @return int
     */
    public function getCurrencyToId()
    {
        return $this->currencyToId;
    }

    /**
     * @param int $currencyToId
     */
    public function setCurrencyToId($currencyToId)
    {
        $this->currencyToId = $currencyToId;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}
