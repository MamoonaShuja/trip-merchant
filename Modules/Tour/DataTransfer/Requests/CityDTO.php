<?php

namespace Modules\Tour\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

class CityDTO implements DTO
{
    /**
     * @param string $name
     */
    public function __construct(
        private readonly string $name,
        private readonly string $country,
    ) {}

    /**
     * @param string $name
     * @return static
     */
    public static function create(string $name , string $country): self
    {
        return new self($name , $country);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

}
