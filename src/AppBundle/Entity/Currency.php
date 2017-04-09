<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Mell\Bundle\SimpleDtoBundle\Model\DtoSerializableInterface;

/**
 * Currency
 */
class Currency implements DtoSerializableInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max = 255)
     *
     * @var string
     */
    private $code;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     * @Assert\Length(max = 255)
     * @Assert\GreaterThan(0)
     *
     * @var float
     */
    private $value;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max = 255)
     *
     * @var string
     */
    private $country;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $code
     * @return Currency
     */
    public function setCode(?string $code): Currency
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param float $value
     * @return Currency
     */
    public function setValue(?float $value): Currency
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @param string $country
     * @return Currency
     */
    public function setCountry(?string $country): Currency
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }
}

